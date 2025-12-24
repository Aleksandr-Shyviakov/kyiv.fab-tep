<?php
/**
 * Name:  Header style 03
 **/
$header_text_box = kuteshop_get_option_meta( '_custom_metabox_theme_options', 'header_text_box' );
?>
<header id="header" class="header style3 cart-style3">
    <div class="header-top">
        <div class="container">
            <div class="top-bar-menu left">
				<?php kuteshop_header_control(); ?>
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

                <?php if (get_locale() == 'ru_RU') : ?>
                    <a href="https://kyiv.fabrika-teplic.com/ru/">
                        <img src="/wp-content/uploads/fabrika-teplic-ru-kiev.svg" alt="" class="_rw">
                    </a>
                <?php else : ?>
                    <a href="https://kyiv.fabrika-teplic.com/">
                        <img src="/wp-content/uploads/fabrika-teplic-ua-kyiv.svg" alt="" class="_rw">
                    </a>
                <?php endif; ?>

                </div>
                <div class="header-mega-box">
                    <div class="top-bar-menu">
						<?php
						kuteshop_get_header_menu( array(
							'menu'            => 'top_center_menu',
							'theme_location'  => 'top_center_menu',
							'depth'           => 1,
							'container'       => '',
							'container_class' => '',
							'container_id'    => '',
							'menu_class'      => 'kuteshop-nav top-bar-menu left',
						) );

						?>
						<?php if ( $header_text_box ): ?>
                            <div class="header-text-box">
                                <a href="javascript:void(0)"><?php echo esc_html( $header_text_box ); ?></a>
                            </div>
						<?php endif; ?>
                    </div>
                    <div class="header-search-box">
						<div class="new-header__address">
                            <div class="new-header__address-text">
                                <?php
                                if (get_locale() == 'ru_RU')
                                    echo 'г. Киев, Б. Окружная 4;<br>пгт Гостомель, ул. Свято-Покровская 220';
                                else
                                    echo 'м. Київ, В. Кільцева 4;<br>смт Гостомель, вул. Свято-Покровська 220';
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-nav">
        <div class="container">
            <div class="header-nav-inner">
				<?php kuteshop_header_vertical(); ?>
				<?php if ( has_nav_menu( 'primary' ) ): ?>
                    <div class="box-header-nav main-menu-wapper">
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
        </div>
    </div>
</header>