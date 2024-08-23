<div class="row align-items-center m-0 py-1">
    <div class="col-md-4 mb-md-0 mb-2 text-md-start text-center">
        <?php echo the_custom_logo(); ?>
    </div>
    <div class="col-md-8 ps-md-0 text-md-end mt-2 mt-md-0">
        <?php get_berita_iklan('iklan_header'); ?>
    </div>
</div>


<div class="container my-3 d-none d-md-block">
<nav id="main-nav" class="navbar navbar-expand-md d-block navbar-dark py-0 bg-color-theme" aria-labelledby="main-nav-label">

    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarNavOffcanvas" aria-controls="navbarNavOffcanvas" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'justg'); ?>">
        <span class="navbar-toggler-icon"></span>
        <small>Menu</small>
    </button>

    <div class="offcanvas bg-dark offcanvas-start" tabindex="-1" id="navbarNavOffcanvas">

        <div class="offcanvas-header justify-content-end">
            <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div><!-- .offcancas-header -->

        <!-- The WordPress Menu goes here -->
        <?php
        wp_nav_menu(
            array(
                'theme_location'  => 'primary',
                'container_class' => 'offcanvas-body',
                'container_id'    => '',
                'menu_class'      => 'navbar-nav justify-content-start flex-grow-1 pe-3',
                'fallback_cb'     => '',
                'menu_id'         => 'main-menu',
                'depth'           => 4,
                'walker'          => new justg_WP_Bootstrap_Navwalker(),
            )
        );
        ?>
    </div><!-- .offcanvas -->
</nav>

<nav id="secondary-nav" class="navbar navbar-expand-md d-block navbar-dark py-0 bg-color-theme" aria-labelledby="secondary-nav-label">

    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#secondarynavbar" aria-controls="secondarynavbar" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'justg'); ?>">
        <span class="navbar-toggler-icon"></span>
        <small>Menu</small>
    </button>

    <div class="offcanvas bg-dark offcanvas-start" tabindex="-1" id="secondarynavbar">

        <div class="offcanvas-header justify-content-end">
            <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div><!-- .offcancas-header -->

        <!-- The WordPress Menu goes here -->
        <?php
        wp_nav_menu(
            array(
                'theme_location'  => 'secondary',
                'container_class' => 'offcanvas-body',
                'container_id'    => '',
                'menu_class'      => 'navbar-nav justify-content-start flex-grow-1 pe-3',
                'fallback_cb'     => '',
                'menu_id'         => 'secondary-menu',
                'depth'           => 4,
                'walker'          => new justg_WP_Bootstrap_Navwalker(),
            )
        );
        ?>
    </div><!-- .offcanvas -->
</nav>
</div>




<div class="container my-3 d-block d-md-none">
	<nav id="responsive-nav" class="navbar navbar-expand-md d-block navbar-dark py-0 bg-color-theme" aria-labelledby="main-nav-label">

		<button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#responsivenavbar" aria-controls="responsivenavbar" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'justg'); ?>">
			<span class="navbar-toggler-icon"></span>
			<small>Menu</small>
		</button>

		<div class="offcanvas bg-dark offcanvas-start" tabindex="-1" id="responsivenavbar">

			<div class="offcanvas-header justify-content-end">
				<button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
			</div><!-- .offcancas-header -->

			<div class="offcanvas-body">
				<ul class="navbar-nav justify-content-start flex-grow-1 pe-3" id="responsive-menu">
				  <?php $responsive_menu = array(
					'theme_location'  => 'primary',
					'container'  => '',
					'walker'          => new justg_WP_Bootstrap_Navwalker(),
					'items_wrap'  => '%3$s',
				  ); ?>
				  <?php wp_nav_menu($responsive_menu); ?>
				  <?php $responsive_menu['theme_location'] = 'secondary'; ?>
				  <?php wp_nav_menu($responsive_menu); ?>
				</ul>
			</div>
		</div><!-- .offcanvas -->
	</nav>
</div>