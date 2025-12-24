<?php
/**
 * Name:  Header style 01
 **/
$header_banner       = kuteshop_get_option_meta( '_custom_metabox_theme_options', 'header_banner', 'metabox_header_banner' );
$banner_url          = kuteshop_get_option_meta( '_custom_metabox_theme_options', 'header_banner_url', 'metabox_header_banner_url', '#' );
$header_border_class = '';
$header_border_html  = '';
if ( is_front_page() ) {
	$header_border_html  = '<div class="container"><div class="header-border"></div></div>';
	$header_border_class = 'has-border';
}
?>
<header id="header" class="header style1 cart-style1 <?php echo esc_attr( $header_border_class ); ?>">
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
					'menu'            => 'top_left_menu',
					'theme_location'  => 'top_left_menu',
					'depth'           => 1,
					'container'       => '',
					'container_class' => '',
					'container_id'    => '',
					'menu_class'      => 'kuteshop-nav top-bar-menu left',
				) );
				kuteshop_header_control();
				?>
            </div>
			<?php if ( has_nav_menu( 'top_right_menu' ) ): ?>
                <div class="top-bar-menu right">
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
					?>
                </div>
			<?php endif; ?>
        </div>
    </div>
    <div class="header-middle">
        <div class="container">
            <div class="header-middle-inner">
                <div class="logo">
					<?php kuteshop_get_logo(); ?>
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
            <div class="header-nav-inner">
				<?php kuteshop_header_vertical(); ?>
                <div class="box-header-nav main-menu-wapper">
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
							)
						);
					}
					?>
                </div>
            </div>
        </div>
    </div>
	<?php echo wp_specialchars_decode( $header_border_html ); ?>
</header>