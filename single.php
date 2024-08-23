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
            <?php while ( have_posts() ) : the_post(); ?>
                <header class="mb-3">
                    <?php velocity_post_categories(); ?>
                    <?php the_title( '<h1 class="h4 fw-bold color-theme mt-1">', '</h1>' ); ?>
                    <div class="text-secondary velocity-post-info">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill align-middle" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                        </svg> <small class="align-middle"><?php echo get_the_author(); ?></small>
                        <div class="px-3 d-inline-block"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" class="bi bi-clock align-middle" viewBox="0 0 16 16">
                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                        </svg> <small class="align-middle"><?php echo velocity_post_date($post->ID);?></small></div>
                    </div>
                </header>

                <?php if (has_post_thumbnail()) { ?>
                    <div class="mb-4">
                        <?php the_post_thumbnail('full', array( 'class' => 'w-100')); ?>
                        <?php $caption = get_the_post_thumbnail_caption();
                        if(!empty($caption)){
                            echo '<small class="mt-1 text-muted">'.$caption.'</small>';
                        } ?>
                    </div>
                <?php } ?>
                <div class="row">
                    <div class="col-md-3 pe-md-0">
                        <div class="sticky-top d-md-block d-none"><?php get_berita_iklan('iklan_single'); ?></div>
                    </div>
                    <div class="col-md-9">
                        <?php the_content(); ?>
                        <?php velocity_post_tags(); ?>
                    </div>
                </div>
                <hr class="border-top">
                <?php echo '<div class="row align-items-center">';
                    echo '<div class="col-md-3 mb-md-0 mb-2">';
                        if ( comments_open() || get_comments_number() ) {                    
                            echo '<a class="d-inline-block py-1 px-4 bg-gray ms-md-0 ms-1 text-dark" href="#comment-title"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left-text me-2" viewBox="0 0 16 16">
                            <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                            <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6zm0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                        </svg>Komentar</a>';
                        }
                    echo '</div>';
                    echo '<div class="col-md-9 ps-md-0 text-md-end">';
                        velocity_social_share();
                    echo '</div>';
                echo '</div>';
                 ?><hr class="border-top">
                <?php $cats = wp_get_post_terms( get_the_ID(), 'category' ); 
                    $cats_ids = array();  
                    foreach( $cats as $wpex_related_cat ) {
                        $cats_ids[] = $wpex_related_cat->term_id; 
                    }
                    if ( ! empty( $cats_ids ) ) {
                        $args['category__in'] = $cats_ids;
                    }
                    $args['posts_per_page'] = 3;
                    $args['post__not_in'] = array($post->ID);
                    $wpex_query = new wp_query( $args );
                    if($wpex_query->have_posts ()):
                    echo '<h3 class="mt-4 velocity-title">Baca Juga</h3>';
                    echo '<div class="row mb-3">';
                        while($wpex_query->have_posts()): $wpex_query->the_post(); ?>
                        <div class="col-md-4 col-sm-6 mb-3">
                            <?php echo do_shortcode('[resize-thumbnail width="300" height="200" linked="true" class="w-100 mb-2"]'); ?>
                            <a class="text-dark" href="<?php echo get_the_permalink($post->ID); ?>"><b><?php echo get_the_title($post->ID); ?></b></a>
                        </div>
                    <?php endwhile;
                    echo '</div>';
                    endif;
                    wp_reset_postdata(); ?>
                <?php if ( comments_open() || get_comments_number() ) :
						echo '<h3 class="velocity-title" id="comment-title">Komentar</h3>';
						comments_template();
				endif; ?>
            <?php endwhile; // end of the loop. ?>
        </div>
        <div class="col-md-4 pt-2">
            <?php get_sidebar('main');?>
        </div>
    </div>
</div>

<?php
get_footer();