<?php
/**
 * Name:  Header style 15
 **/
?>
<header id="header" class="header style15">
    <div class="header-top">
        <div class="logo">
			<?php kuteshop_get_logo(); ?>
        </div>
        <div class="header-right main-menu-wapper">
            <div class="box-header-nav primary-nav">
				<?php
				if ( has_nav_menu( 'primary' ) ) {
					kuteshop_get_header_menu( array(
						'menu'            => 'primary',
						'theme_location'  => 'primary',
						'depth'           => 3,
						'container'       => '',
						'container_class' => '',
						'container_id'    => '',
						'menu_class'      => 'clone-main-menu kuteshop-nav main-menu',
					) );
				}
				?>
            </div>
			<?php kuteshop_search_form(); ?>
            <div class="header-control">
                <div>
					<?php kuteshop_user_link(); ?>
                </div>
                <div>
					<?php
					if ( function_exists( 'kuteshop_header_mini_cart' ) ) {
						kuteshop_header_mini_cart();
					}
					?>
                </div>
                <div>
                    <div class="block-menu-bar">
                        <a class="menu-bar mobile-navigation" href="#">
                            <span class="flaticon-menu03 icon"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php
	$category_menu = kuteshop_get_option_meta( '_custom_metabox_theme_options', 'category_menu' );
	if ( ! empty( $category_menu ) ):
		?>
        <div class="box-header-nav main-menu-wapper category-nav">
			<?php
			wp_nav_menu( array(
				'menu'            => $category_menu,
				'theme_location'  => $category_menu,
				'depth'           => 3,
				'container'       => '',
				'container_class' => '',
				'container_id'    => '',
				'menu_class'      => 'kuteshop-nav main-menu',
			) );
			?>
        </div>
	<?php endif; ?>
</header>