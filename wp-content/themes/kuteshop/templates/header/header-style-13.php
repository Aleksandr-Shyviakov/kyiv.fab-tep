<?php
/**
 * Name:  Header style 13
 **/
$header_banner = kuteshop_get_option_meta( '_custom_metabox_theme_options', 'header_banner', 'metabox_header_banner' );
$banner_url    = kuteshop_get_option_meta( '_custom_metabox_theme_options', 'header_banner_url', 'metabox_header_banner_url', '#' );
?>
<header id="header" class="header style13 cart-style12">
	<?php if ( $header_banner ): ?>
        <a href="<?php echo esc_url( $banner_url ); ?>">
			<?php echo wp_get_attachment_image( $header_banner, 'full' ); ?>
        </a>
	<?php endif; ?>
    <div class="header-top">
        <div class="container">
            <div class="top-bar-menu left">
				<?php
				kuteshop_get_header_menu( array(
					'menu'            => 'top_right_menu',
					'theme_location'  => 'top_right_menu',
					'depth'           => 1,
					'container'       => '',
					'container_class' => '',
					'container_id'    => '',
					'menu_class'      => 'kuteshop-nav top-bar-menu',
				) );
				kuteshop_header_control();
				?>
            </div>
            <div class="top-bar-menu right">
				<?php
				kuteshop_get_header_menu( array(
					'menu'            => 'top_left_menu',
					'theme_location'  => 'top_left_menu',
					'depth'           => 1,
					'container'       => '',
					'container_class' => '',
					'container_id'    => '',
					'menu_class'      => 'kuteshop-nav top-bar-menu',
				) );
				kuteshop_header_social();
				?>
            </div>
        </div>
    </div>
    <div class="header-middle">
        <div class="container">
            <div class="header-middle-inner">
                <div class="logo">
					<?php do_action( 'kuteshop_get_logo' ); ?>
                </div>
                <div class="header-control">
					<?php
					kuteshop_search_form();
					if ( function_exists( 'kuteshop_header_mini_cart' ) ) {
						kuteshop_header_mini_cart();
					}
					?>
                    <div class="block-menu-bar">
                        <a class="menu-bar mobile-navigation" href="#">
                            <span class="flaticon-menu01"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-nav">
        <div class="container">
            <div class="header-nav-inner main-menu-wapper">
				<?php kuteshop_header_vertical(); ?>
				<?php if ( has_nav_menu( 'primary' ) ): ?>
                    <div class="box-header-nav">
                        <div class="main-menu-wapper">
							<?php
							kuteshop_get_header_menu( array(
								'menu'            => 'primary',
								'theme_location'  => 'primary',
								'depth'           => 3,
								'container'       => '',
								'container_class' => '',
								'container_id'    => '',
								'menu_class'      => 'clone-main-menu kuteshop-nav main-menu',
							) );
							?>
                        </div>
                    </div>
				<?php endif; ?>
            </div>
        </div>
    </div>
</header>