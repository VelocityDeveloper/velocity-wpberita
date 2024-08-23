<?php
/**
 * Kumpulan shortcode yang digunakan di theme ini.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
//[resize-thumbnail width="300" height="150" linked="true" class="w-100"]
add_shortcode('resize-thumbnail', 'resize_thumbnail');
function resize_thumbnail($atts) {
    ob_start();
	global $post;
    $atribut = shortcode_atts( array(
        'output'	=> 'image', /// image or url
        'width'    	=> '300', ///width image
        'height'    => '150', ///height image
        'crop'      => 'false',
        'upscale'   => 'true',
        'linked'   	=> 'true', ///return link to post	
        'class'   	=> 'w-100', ///return class name to img	
        'attachment' => 'true',
        'post_id'   => $post->ID,
    ), $atts );

    $output			= $atribut['output'];
    $attach         = $atribut['attachment'];
    $width          = $atribut['width'];
    $height         = $atribut['height'];
    $crop           = $atribut['crop'];
    $upscale        = $atribut['upscale'];
    $linked        	= $atribut['linked'];
    $post_id        = $atribut['post_id'];
    $class        	= $atribut['class']?'class="'.$atribut['class'].'"':'';
	$urlimg			= get_the_post_thumbnail_url($post_id,'full');
	
	if(empty($urlimg) && $attach == 'true'){
          $attachments = get_posts( array(
            'post_type' 		=> 'attachment',
            'posts_per_page' 	=> 1,
            'post_parent' 		=> $post_id,
        	'orderby'          => 'date',
        	'order'            => 'DESC',
          ) );
          if ( $attachments ) {
				$urlimg = wp_get_attachment_url( $attachments[0]->ID, 'full' );
          }
    }

	if($urlimg):
		$urlresize      = aq_resize( $urlimg, $width, $height, $crop, true, $upscale );
		if($output=='image'):
			if($linked=='true'):
				echo '<a href="'.get_the_permalink($post_id).'" title="'.get_the_title($post_id).'">';
			endif;
			echo '<img src="'.$urlresize.'" width="'.$width.'" height="'.$height.'" loading="lazy" '.$class.'>';
			if($linked=='true'):
				echo '</a>';
			endif;
		else:
			echo $urlresize;
		endif;

	else:
		if($linked=='true'):
			echo '<a href="'.get_the_permalink($post_id).'" title="'.get_the_title($post_id).'">';
		endif;
		echo '<svg style="background-color: #ececec;width: 100%;height: auto;" width="'.$width.'" height="'.$height.'"></svg>';
		if($linked=='true'):
			echo '</a>';
		endif;
	endif;

	return ob_get_clean();
}

//[velocity-excerpt count="150" post_id=""]
add_shortcode('velocity-excerpt', 'vd_getexcerpt');
function vd_getexcerpt($atts){
    ob_start();
	global $post;
    $atribut = shortcode_atts( array(
        'count'	=> '150', /// count character
        'post_id'   => $post->ID,
    ), $atts );
    $post_id        = $atribut['post_id'];

    $count		= $atribut['count'];
    $excerpt	= get_the_excerpt($post_id);
    $excerpt 	= strip_tags($excerpt);
    $excerpt 	= substr($excerpt, 0, $count);
    $excerpt 	= substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt 	= ''.$excerpt.'...';

    echo $excerpt;

	return ob_get_clean();
}

// [vd-breadcrumbs]
add_shortcode('vd-breadcrumbs','vd_breadcrumbs');
function vd_breadcrumbs() {
    ob_start();
    echo justg_breadcrumb();
    return ob_get_clean();
}

//[ratio-thumbnail size="medium" ratio="16:9"]
add_shortcode('ratio-thumbnail', 'ratio_thumbnail');
function ratio_thumbnail($atts) {
    ob_start();
	global $post;

    $atribut = shortcode_atts( array(
        'size'      => 'medium', // thumbnail, medium, large, full
        'ratio'     => '16:9', // 16:9, 8:5, 4:3, 3:2, 1:1
    ), $atts );

    $size       = $atribut['size'];
    $ratio      = $atribut['ratio'];
    $ratio      = $ratio?str_replace(":","-",$ratio):'';
	$urlimg     = get_the_post_thumbnail_url($post->ID,$size);

    echo '<div class="ratio-thumbnail">';
        echo '<a class="ratio-thumbnail-link" href="'.get_the_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
            echo '<div class="ratio-thumbnail-box ratio-thumbnail-'.$ratio.'" style="background-image: url('.$urlimg.');">';
                echo '<img src="'.$urlimg.'" loading="lazy" class="ratio-thumbnail-image"/>';
            echo '</div>';
        echo '</a>';
    echo '</div>';

	return ob_get_clean();
}




// [velocity-post-tabs]
function velocity_post_tabs() {
    ob_start();
    $jumlah = 3; ?>

    <ul class="nav nav-tabs velocity-post-tabs row p-0" role="tablist">
        <li class="nav-item pb-0 border-0 col p-0 text-center">
            <a class="nav-link active secondary-font fw-bold rounded-0" id="kategori1-tab" data-bs-toggle="tab" href="#kategori1" role="tab" aria-controls="kategori1" aria-selected="true">
            Popular</a>
        </li>
        <li class="nav-item pb-0 border-0 col p-0 text-center">
            <a class="nav-link secondary-font fw-bold rounded-0" id="kategori2-tab" data-bs-toggle="tab" href="#kategori2" role="tab" aria-controls="kategori2" aria-selected="false">
            Recent</a>
        </li>
        <li class="nav-item pb-0 border-0 col p-0 text-center">
            <a class="nav-link secondary-font fw-bold rounded-0" id="kategori3-tab" data-bs-toggle="tab" href="#kategori3" role="tab" aria-controls="kategori3" aria-selected="false">
            Comment</a>
        </li>
    </ul>
    
    <div class="tab-content py-2 border-left border-right border-bottom" id="myTabContent">

        <!-- Tab Popular -->
        <div class="tab-pane fade show active" id="kategori1" role="tabpanel" aria-labelledby="kategori1-tab">
        <?php 
        $args = array(
            'post_type' => 'post',
            'meta_key' => 'hit',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'numberposts' => $jumlah,
        );
        $posts = get_posts($args);
        if ($posts): ?>
            <div class="frame-kategori">
            <?php foreach ($posts as $post):
                setup_postdata($post);
                echo '<div class="row m-0 py-2">';
                echo '<div class="col-4 col-sm-3 p-0">';
                if (has_post_thumbnail($post->ID)) {
                    echo '<a href="'.get_the_permalink($post->ID).'">';
                    echo velocity_thumbnail('200','200','false','true','w-100 img-fluid',$post->ID);
                    echo '</a>';
                }
                echo '</div>';
                echo '<div class="col-8 col-sm-9 py-1">';
                $vtitle = get_the_title($post->ID);
                echo '<div class="vtitle"><a class="text-dark secondary-font fw-bold" href="'.get_the_permalink($post->ID).'">'.substr($vtitle, 0, 60) . ' ...'.'</a></div>';
                echo '<div class="text-muted"><small><i class="fa fa-calendar" aria-hidden="true"></i> ';
                velocity_post_date($post->ID);
                echo ' / <i class="fa fa-eye" aria-hidden="true"></i> '.get_post_meta($post->ID,'hit',true).'</small></div>';
                echo '</div>';
                echo '</div>';
            endforeach; ?>
            </div>
        <?php else:
            _e('<p>Belum ada post.</p>');
        endif;
        wp_reset_postdata(); ?>
        </div>

        <!-- Tab Recent -->
        <div class="tab-pane fade" id="kategori2" role="tabpanel" aria-labelledby="kategori2-tab">
        <?php 
        $args2 = array(
            'post_type' => 'post',
            'numberposts' => $jumlah,
        );
        $posts2 = get_posts($args2);
        if ($posts2): ?>
            <div class="frame-kategori">
            <?php foreach ($posts2 as $post):
                setup_postdata($post);
                echo '<div class="row m-0 py-2">';
                echo '<div class="col-4 col-sm-3 p-0">';
                if (has_post_thumbnail($post->ID)) {
                    echo '<a href="'.get_the_permalink($post->ID).'">';
                    echo velocity_thumbnail('200','200','false','true','w-100 img-fluid',$post->ID);
                    echo '</a>';
                }
                echo '</div>';
                echo '<div class="col-8 col-sm-9 py-1">';
                $vtitle = get_the_title($post->ID);
                echo '<div class="vtitle"><a class="text-dark secondary-font fw-bold" href="'.get_the_permalink($post->ID).'">'.substr($vtitle, 0, 60) . ' ...'.'</a></div>';
                echo '<div class="text-muted"><small><i class="fa fa-calendar" aria-hidden="true"></i> ';
                velocity_post_date($post->ID);
                echo ' / <i class="fa fa-eye" aria-hidden="true"></i> '.get_post_meta($post->ID,'hit',true).'</small></div>';
                echo '</div>';
                echo '</div>';
            endforeach; ?>
            </div>
        <?php else:
            _e('<p>Belum ada post.</p>');
        endif;
        wp_reset_postdata(); ?>
        </div>

        <!-- Tab Comment -->
        <div class="tab-pane fade" id="kategori3" role="tabpanel" aria-labelledby="kategori3-tab">
        <?php 
        $args3 = array(
            'post_type' => 'post',
            'orderby' => 'comment_count',
            'order' => 'DESC',
            'numberposts' => $jumlah,
        );
        $posts3 = get_posts($args3);
        if ($posts3): ?>
            <div class="frame-kategori">
            <?php foreach ($posts3 as $post):
                setup_postdata($post);
                echo '<div class="row m-0 py-2">';
                echo '<div class="col-4 col-sm-3 p-0">';
                if (has_post_thumbnail($post->ID)) {
                    echo '<a href="'.get_the_permalink($post->ID).'">';
                    echo velocity_thumbnail('200','200','false','true','w-100 img-fluid',$post->ID);
                    echo '</a>';
                }
                echo '</div>';
                echo '<div class="col-8 col-sm-9 py-1">';
                $vtitle = get_the_title($post->ID);
                echo '<div class="vtitle"><a class="text-dark secondary-font fw-bold" href="'.get_the_permalink($post->ID).'">'.substr($vtitle, 0, 60) . ' ...'.'</a></div>';
                echo '<div class="text-muted"><small><i class="fa fa-calendar" aria-hidden="true"></i> ';
                velocity_post_date($post->ID);
                echo ' / <i class="fa fa-eye" aria-hidden="true"></i> '.get_post_meta($post->ID,'hit',true).'</small></div>';
                echo '</div>';
                echo '</div>';
            endforeach; ?>
            </div>
        <?php else:
            _e('<p>Belum ada post.</p>');
        endif;
        wp_reset_postdata(); ?>
        </div>

    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('velocity-post-tabs', 'velocity_post_tabs');




function velocity_popular_posts(){
    ob_start();
    $args = array(
        'post_type'   => 'post',
        'meta_key'    => 'hit',
        'orderby'     => 'meta_value_num',
        'order'       => 'DESC',
        'numberposts' => 10 // Batas maksimal post yang diambil
    );
    $posts = get_posts( $args );
    if ( $posts ) {
        echo '<div class="velocity-popular-posts">';
        foreach ( $posts as $post ) {
            setup_postdata( $post ); ?>
            <div class="velocity-popular-list mb-3">
                <div class="fw-bold mb-0"><a class="text-dark" href="<?php echo get_permalink($post->ID); ?>"><b><?php echo get_the_title($post->ID); ?></b></a></div>
                <small class="text-secondary fst-italic"><?php velocity_post_date($post->ID); ?>  |  <?php echo get_post_meta($post->ID, 'hit', true); ?> dilihat</small>
            </div>
        <?php }
        echo '</div>';
        wp_reset_postdata();
    }
    return ob_get_clean();
}
add_shortcode('velocity-popular-posts', 'velocity_popular_posts');


function velocity_recent_posts($atts){
    ob_start();
    $args = shortcode_atts( array(
        'style'         => 'list', // list, gallery, first_image
        'post_type'     => 'post',
        'category_name' => '',
        'numberposts'   => 4, // Batas maksimal post yang diambil
    ), $atts );
    
    $style = $args['style'];
    $posts = get_posts( $args );
    
    if ( $posts ) {
        if ($style == 'gallery') {
            $topclass = ' row';
            $colframe = ' col-6 mb-3';
            $col1 = ' mb-2';
            $col2 = '';
        } else {
            $topclass = '';
            $colframe = ' mb-3 row';
            $col1 = ' col-4 pe-0';
            $col2 = ' col-8';
        }
        
        echo '<div class="velocity-recent-posts'.$topclass.'">';
        $i = 0;
        foreach ( $posts as $post ) {
            setup_postdata( $post );
            $no = ++$i;
            if ($style == 'first_image' && $no == '1') {
                $class = 'col-12 mb-2';
            } else {
                $class = $col1;
            } ?>
            <div class="velocity-recent-list<?php echo $colframe;?>">
                <div class="col-image<?php echo $class;?>">
                    <?php echo do_shortcode('[resize-thumbnail width="400" height="280" linked="true" class="w-100" post_id="'.$post->ID.'"]');?>
                </div>
                <div class="col-content<?php echo $col2;?>">
                    <div class="v-post-title fw-bold mb-0"><a class="text-dark" href="<?php echo get_permalink($post->ID); ?>"><b><?php echo get_the_title($post->ID); ?></b></a></div>
                    <small class="v-post-date text-secondary fst-italic"><?php velocity_post_date($post->ID);?></small>
                </div>
            </div>
        <?php }
        echo '</div>';
        wp_reset_postdata();
    }
    return ob_get_clean();
}
add_shortcode('velocity-recent-posts', 'velocity_recent_posts');