<?php
/**
 * Class plugin load.
 */
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('TGM_Plugin_Activation')) {
    require_once get_parent_theme_file_path('/framework/classes/class-tgm-plugin-activation.php');
}
if (!function_exists('kuteshop_plugin_load')) {
    function kuteshop_plugin_load()
    {
        /*
         * Array of plugin arrays. Required keys are name and slug.
         * If the source is NOT from the .org repo, then source is also required.
         */
        $plugins = array(
            array(
                'name'     => 'Kuteshop Toolkit',
                'slug'     => 'kuteshop-toolkit',
                'source'   => esc_url('https://plugins.kutethemes.net/kuteshop-toolkit.zip'),
                'required' => true,
                'version'  => '1.5.1',
            ),
            array(
                'name'     => 'Revolution Slider',
                'slug'     => 'revslider',
                'source'   => esc_url('https://plugins.kutethemes.net/revslider.zip'),
                'required' => true,
                'version'  => '6.2.22',
            ),
            array(
                'name'     => 'WPBakery Visual Composer',
                'slug'     => 'js_composer',
                'source'   => esc_url('https://plugins.kutethemes.net/js_composer.zip'),
                'required' => true,
                'version'  => '6.3',
            ),
            array(
                'name'     => 'Ovic: Product Bundle',
                'slug'     => 'ovic-product-bundle',
                'required' => true,
            ),
            array(
                'name'     => 'Ovic: Responsive WPBakery',
                'slug'     => 'ovic-vc-addon',
                'required' => true,
            ),
            array(
                'name'     => 'Ovic: Import Demo',
                'slug'     => 'ovic-import-demo',
                'required' => true,
            ),
            array(
                'name'     => 'WooCommerce',
                'slug'     => 'woocommerce',
                'required' => true,
            ),
            array(
                'name' => 'YITH WooCommerce Compare',
                'slug' => 'yith-woocommerce-compare',
            ),
            array(
                'name' => 'YITH WooCommerce Wishlist',
                'slug' => 'yith-woocommerce-wishlist',
            ),
            array(
                'name' => 'YITH WooCommerce Quick View',
                'slug' => 'yith-woocommerce-quick-view',
            ),
            array(
                'name' => 'Contact Form 7',
                'slug' => 'contact-form-7',
            ),
            array(
                'name' => 'AJAX Search for WooCommerce',
                'slug' => 'ajax-search-for-woocommerce',
            ),
            array(
                'name' => 'Woo Advanced Product Size Chart',
                'slug' => 'woo-advanced-product-size-chart',
            ),
            array(
                'name' => 'Child Theme Configurator',
                'slug' => 'child-theme-configurator',
            ),
            array(
                'name' => 'WordPress Importer',
                'slug' => 'wordpress-importer',
            ),
        );
        /*
         * Array of configuration settings. Amend each line as needed.
         *
         * TGMPA will start providing localized text strings soon. If you already have translations of our standard
         * strings available, please help us make TGMPA even better by giving us access to these translations or by
         * sending in a pull-request with .po file(s) with the translations.
         *
         * Only uncomment the strings in the config array if you want to customize the strings.
         */
        $config = array(
            'id'           => 'kuteshop-plugins',
            'default_path' => '',
            'menu'         => 'kuteshop-install-plugins',
            'parent_slug'  => 'themes.php',
            'capability'   => 'edit_theme_options',
            'has_notices'  => true,
            'dismissable'  => true,
            'dismiss_msg'  => '',
            'is_automatic' => true,
            'message'      => '',
        );
        tgmpa($plugins, $config);
    }
}
add_action('tgmpa_register', 'kuteshop_plugin_load');