<?php

/**
 * The template for displaying archive pages
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package justg
 */

// Exit if accessed directly.

defined('ABSPATH') || exit;
get_header();
?>

<div class="container">
    <div class="row">
        <div class="col-md-8 pt-2">	
            <h1 class="velocity-title"><?php wp_title(''); ?></h1>
            <?php $object = get_queried_object();
            velocity_post_carousel($object->term_id);?>

            <?php $args = array(
                'showposts' => 3,
                'post_type' => array('post'),
                'tax_query' => array(
                    array(
                        'taxonomy' => $object->taxonomy,
                        'field' => 'term_id',
                        'terms' => $object->term_id,
                    ),
                ),
            );
            if($object->count >= 8){
                $args['offset'] = 5;
            }
            $top_posts = get_posts($args);
            if(!empty($top_posts)){
                echo '<div class="row my-4">';
                    echo '<div class="col-md-7 mb-3 mb-md-0 text-muted">';
                    foreach(array_slice($top_posts, 0,1) as $post) {
                        $post_id = $post->ID;
                        echo do_shortcode('[resize-thumbnail width="410" height="280" linked="true" class="w-100" post_id="'.$post_id.'"]');
                        echo '<small class="d-block mt-2 mb-1">';
                            velocity_post_categories($post->ID);
                            echo '<span class="fst-italic ms-2">';
                                velocity_post_date($post_id);
                            echo '</span>';
                        echo '</small>';
                        echo '<div class="fs-5 mb-2"><a class="secondary-font fw-bold text-dark" href="'.get_the_permalink($post_id).'">'.get_the_title($post_id).'</a></div>';
                        echo do_shortcode('[velocity-excerpt count="150" post_id="'.$post_id.'"]');
                    }
                    echo '</div>';
                    echo '<div class="col-md-5">';
                        echo '<div class="row">';
                        foreach(array_slice($top_posts, 1,3) as $post) {                        
                            echo '<div class="col-6 col-md-12 mb-md-3 mb-0">';
                                echo '<div class="velocity-post-thumbnail mb-2">';
                                    echo do_shortcode('[resize-thumbnail width="300" height="180" linked="true" class="w-100"]');
                                echo '</div>';
                                echo '<div class="velocity-post-title">';
                                    echo '<a class="secondary-font fw-bold text-dark" href="'.get_the_permalink().'">'.get_the_title().'</a>';
                                echo '</div>';
                            echo '</div>';
                        }
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            } ?>


			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php velocity_post_loop();?>
				<?php endwhile; ?>
			<?php else : ?>
				<?php get_template_part( 'loop-templates/content', 'none' ); ?>
			<?php endif; ?>
        </div>
        <div class="col-md-4 pt-2">
            <?php get_sidebar('main');?>
        </div>
    </div>
</div>

<?php
get_footer();