<?php
/**
 * Plugin Name: Kuteshop Toolkit
 * Plugin URI:  https://kutethemes.com/
 * Description: Kuteshop toolkit for Kuteshop theme. Currently supports the following theme functionality: shortcodes, CPT.
 * Version:     1.5.5
 * Author:      Kutethemes Team
 * Author URI:  https://kutethemes.com/contact-us
 * License:     GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: kuteshop-toolkit
 **/
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Include function plugins if not include.
if (!function_exists('is_plugin_active')) {
    require_once(ABSPATH.'wp-admin/includes/plugin.php');
}
if (!class_exists('Kuteshop_Toolkit')) {
    class Kuteshop_Toolkit
    {
        public $current_theme;
        /**
         * @var Kuteshop_Toolkit The one true Kuteshop_Toolkit
         */
        private static $instance;

        public static function instance()
        {
            if (!isset(self::$instance) && !(self::$instance instanceof Kuteshop_Toolkit)) {
                self::$instance = new Kuteshop_Toolkit;
                self::$instance->auto_update_plugins();
                self::$instance->setup_constants();
                self::$instance->load_setup();
                add_action('plugins_loaded', array(self::$instance, 'includes'));
            }

            return self::$instance;
        }

        public function setup_constants()
        {
            // Plugin version.
            if (!defined('KUTESHOP_VERSION')) {
                define('KUTESHOP_VERSION', '1.5.5');
            }
            // Plugin Folder Path.
            if (!defined('KUTESHOP_TOOLKIT_PATH')) {
                define('KUTESHOP_TOOLKIT_PATH', trailingslashit(plugin_dir_path(__FILE__)));
            }
            // Plugin Folder URL.
            if (!defined('KUTESHOP_TOOLKIT_URL')) {
                define('KUTESHOP_TOOLKIT_URL', trailingslashit(plugin_dir_url(__FILE__)));
            }
        }

        public function includes()
        {
            if (self::$instance->current_theme->get('Name') == 'Kuteshop' && self::$instance->current_theme->get('Version') < '3.5.0') {
                return;
            }
            if (class_exists('Vc_Manager')) {
                include_once KUTESHOP_TOOLKIT_PATH.'includes/shortcode.php';
            }
            /* WIDGET */
            include_once KUTESHOP_TOOLKIT_PATH.'includes/widgets/widget-post.php';
            include_once KUTESHOP_TOOLKIT_PATH.'includes/widgets/widget-banner.php';
            include_once KUTESHOP_TOOLKIT_PATH.'includes/widgets/widget-category.php';
            if (class_exists('WooCommerce')) {
                include_once KUTESHOP_TOOLKIT_PATH.'includes/widgets/widget-products.php';
                include_once KUTESHOP_TOOLKIT_PATH.'includes/widgets/widget-product-filter.php';
                include_once KUTESHOP_TOOLKIT_PATH.'includes/widgets/widget-attribute-product.php';
                include_once KUTESHOP_TOOLKIT_PATH.'includes/classes/product-brand/product-brand.php';
                include_once KUTESHOP_TOOLKIT_PATH.'includes/classes/attributes-swatches/product-attribute-meta.php';
            }
            /* MAILCHIMP */
            include_once KUTESHOP_TOOLKIT_PATH.'includes/classes/mailchimp/MCAPI.class.php';
            include_once KUTESHOP_TOOLKIT_PATH.'includes/classes/mailchimp/mailchimp-settings.php';
            include_once KUTESHOP_TOOLKIT_PATH.'includes/classes/mailchimp/mailchimp.php';
            /* LANGUAGE */
            load_plugin_textdomain('kuteshop-toolkit', false, KUTESHOP_TOOLKIT_PATH.'languages');
        }

        public function load_setup()
        {
            if (self::$instance->current_theme->get('Name') == 'Kuteshop' && self::$instance->current_theme->get('Version') < '3.5.0') {
                add_action('admin_notices', array(self::$instance, 'admin_notice__error'));

                return;
            }

            add_filter('widget_text', 'do_shortcode');

            include_once KUTESHOP_TOOLKIT_PATH.'includes/classes/dashboard.php';
            include_once KUTESHOP_TOOLKIT_PATH.'includes/options/options.php';
            include_once KUTESHOP_TOOLKIT_PATH.'includes/post-types.php';

            if (!is_plugin_active('ovic-vc-addon/addon.php')) {
                include_once KUTESHOP_TOOLKIT_PATH.'includes/classes/ovic-vc-addon/addon.php';
            }
        }

        function auto_update_plugins()
        {
            self::$instance->current_theme = wp_get_theme(get_template());

            if (!is_admin()) {
                return;
            }
            require_once trailingslashit(plugin_dir_path(__FILE__)).'plugin-update-checker/plugin-update-checker.php';
            /* UPDATE PLUGIN AUTOMATIC */
            if (class_exists('Puc_v4_Factory')) {
                $Plugin_Updater = Puc_v4_Factory::buildUpdateChecker(
                    'https://github.com/kutethemes/kuteshop-toolkit',
                    __FILE__,
                    'kuteshop-toolkit'
                );
                $Plugin_Updater->setAuthentication('c8c2d98855d2a14dae30711a6ab3652ef50b5a0e');
                if ('Kuteshop' == self::$instance->current_theme->get('Name')) {
                    $theme_root    = self::$instance->current_theme->theme_root.'/kuteshop';
                    $Theme_Updater = Puc_v4_Factory::buildUpdateChecker(
                        'https://github.com/kutethemes/kuteshop',
                        $theme_root,
                        'kuteshop'
                    );
                    $Theme_Updater->setAuthentication('c8c2d98855d2a14dae30711a6ab3652ef50b5a0e');
                }
            }
        }

        function admin_notice__error()
        {
            ?>
            <div class="notice notice-error">
                <p>
                    <?php echo __('Require theme ver >= 3.5.0, Please update auto', 'kuteshop-toolkit'); ?>
                    <a href="<?php echo esc_url(self_admin_url('update-core.php')); ?>" target="_blank">
                        <?php echo __(' Update Core ', 'kuteshop-toolkit'); ?>
                    </a>
                    <?php echo __('or', 'kuteshop-toolkit'); ?>
                    <a href="<?php echo esc_url(self_admin_url('theme.php')); ?>" target="_blank">
                        <?php echo __(' Themes ', 'kuteshop-toolkit'); ?>
                    </a>
                    <?php echo __('for use plugin "Kuteshop Toolkit" ver >= 1.3.5', 'kuteshop-toolkit'); ?>
                </p>
            </div>
            <?php
        }

        /*
         *
         * 200 – Everything was okay and the purchase code is valid!
         * 404 – The purchase code was invalid, not real, or was not from one of your customers.
         * 403 – The personal token is incorrect or does not have the required permission(s).
         * 401 – The authorization header is missing or malformed. Verify that your code is correct.
         * 400 – A parameter or argument in the request was invalid.
         *
         * exp:
         * - code:  ca637a3c-7c72-42c2-8f2b-fb66a8cac7f1
         * - Token: ItdonUWAUYnQBvEXOcB7ugEIEOQhZU6s
         *
         * */
        public function verify_envato()
        {
            $key      = 'ovic_envato_license';
            $id       = '13012521';
            $settings = get_option($key);
            $response = array(
                'id'       => $id,
                'active'   => false,
                'settings' => array(),
                'product'  => array(),
            );

            if (empty($settings['purchased_code'])) {
                return $response;
            }

            $api_key   = array_merge(array('ovic-envato-license', $id, KUTESHOP_VERSION), $settings);
            $cache_key = sanitize_key(implode('-', $api_key));
            $options   = get_transient($cache_key);

            if ($options) {
                return $options;
            }

            $home_url             = home_url('/');
            $code                 = $settings['purchased_code'];
            $personalToken        = "ItdonUWAUYnQBvEXOcB7ugEIEOQhZU6s";
            $userAgent            = "Purchase code verification on {$home_url}";
            $response['settings'] = $settings;

            // Surrounding whitespace can cause a 404 error, so trim it first
            $code = trim($code);

            // Make sure the code looks valid before sending it to Envato
            if (!preg_match("/^([a-f0-9]{8})-(([a-f0-9]{4})-){3}([a-f0-9]{12})$/i", $code)) {
                return $response;
            }

            // Build the request
            $data = wp_remote_get("https://api.envato.com/v3/market/author/sale?code={$code}",
                array(
                    'sslverify' => true,
                    'headers'   => array(
                        'authorization' => 'Bearer '.$personalToken,
                        'User-Agent'    => $userAgent,
                    ),
                )
            );
            if (!is_wp_error($data) && wp_remote_retrieve_response_code($data) == 200) {
                $content = wp_remote_retrieve_body($data);
                $content = json_decode($content, true);
                if ($content['item']['id'] == $id) {
                    $response['active']  = true;
                    $response['product'] = $content;

                    set_transient($cache_key, $response, 12 * HOUR_IN_SECONDS);

                    return $response;
                }
            }

            return $response;
        }
    }
}
if (!function_exists('Kuteshop_Toolkit')) {
    function Kuteshop_Toolkit()
    {
        return Kuteshop_Toolkit::instance();
    }
}
Kuteshop_Toolkit();
