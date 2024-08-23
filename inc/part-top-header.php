<div class="bg-color-theme">
    <div class="container">
        <div class="row text-center align-items-stretch m-0 py-1">
			<div class="col-md-2 px-0 align-items-center d-md-flex d-none">
				<div class="text-center color-theme bg-white col-12 py-1 px-0 rounded fw-bold">Breaking News</div>
			</div>
			<div class="col-md-10 pr-0 text-left align-items-center d-flex">
				<div class="vertical-post-header velocity-marquee">
                    <div class="velocity-marquee-content">
                        <?php $headerposts = get_posts(array(
                            'showposts' => 5,
                            'post_type' => array('post'),
                        ));
                        foreach($headerposts as $post) {
                            echo '<a class="text-white d-inline-block me-4 pe-2" href="'.get_the_permalink($post->ID).'">'.get_the_title($post->ID).'</a>';
                        } ?>
                    </div>
				</div>
			</div>
        </div>
    </div>
</div>


<div class="bg-white shadow-sm mb-3">
    <div class="container">
        <div class="row align-items-center m-0 py-1">
            <div class="col-5 col-sm-8 px-0">
                <small><?php echo velocity_date(); ?></small>
            </div>
            <div class="col-7 col-sm-4 text-md-end px-0">
                <form method="get" name="searchform" action="<?php echo get_home_url();?>">
                    <div class="row">
                        <div class="col-9 col-md-10 pe-0">
                            <input type="text" name="s" class="form-control form-control-sm" placeholder="Search" required />
                        </div>
                        <div class="col-3 col-md-2 ps-1">
                            <button type="submit" class="h-100 w-100 btn btn-primary btn-sm bg-color-theme border-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                </svg>
                            </button>
                        </div>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>
