<?php
/**
 * Name:  Header style 11
 **/
$header_phone = kuteshop_get_option_meta( '_custom_metabox_theme_options', 'header_phone' );
?>
<header id="header" class="header style11 cart-style11">
    <div class="header-middle">
        <div class="container">
            <div class="header-middle-inner">
                <div class="logo">
					<?php kuteshop_get_logo(); ?>
                </div>
                <div class="header-megabox main-menu-wapper">
                    <div class="header-megabox-nav">
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
							kuteshop_header_control();
							if ( $header_phone != '' ) : ?>
                                <div class="header-phone"><a href="#"><?php echo esc_html( $header_phone ); ?></a></div>
							<?php endif;
							kuteshop_header_social();
							?>
                        </div>
						<?php if ( has_nav_menu( 'primary' ) ): ?>
                            <div class="box-header-nav">
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
						<?php endif; ?>
                    </div>
					<?php
					if ( function_exists( 'kuteshop_header_mini_cart' ) ) {
						kuteshop_header_mini_cart();
					}
					?>
                    <div class="block-menu-bar">
                        <a class="menu-bar mobile-navigation" href="#">
                            <span class="flaticon-menu03 icon"></span>
                            <span class="text"><?php echo esc_html__( 'MENU', 'kuteshop' ) ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-nav">
        <div class="container">
            <div class="header-nav-inner">
				<?php
				kuteshop_header_vertical();
				kuteshop_search_form();
				?>
                <div class="header-nav-control">
					<?php if ( $header_phone != '' ) : ?>
                        <div class="header-phone">
                            <span class="fa fa-phone"></span>
							<?php echo esc_html( $header_phone ); ?>
                        </div>
					<?php endif;
					kuteshop_header_social(); ?>
                </div>
            </div>
        </div>
    </div>
</header>