<?php
/**
 * Theme verify admin page and functions.
 *
 * @package Ovic Verify Envato
 *
 * disable: add_filter('ovic_disable_envato_license', '__return_true');
 */
if (!class_exists('Ovic_Verify_Envato')) {
    class Ovic_Verify_Envato
    {
        public $key        = '';
        public $item_name  = '';
        public $verify     = array();
        public $theme      = array();
        public $affiliates = '';
        public $link       = 'https://1.envato.market/WEdOn';

        public function __construct()
        {
            if (!function_exists('ovic_link_affiliates')) {
                /**
                 * affiliates
                 * CDN: https://cdn.staticaly.com/wp/p/:plugin_name/:version/:file
                 */
                include dirname(__FILE__).'/affiliates.php';
            }
            $this->affiliates = ovic_link_affiliates();
            $this->theme      = wp_get_theme(get_template());
            $this->key        = 'ovic_envato_license';
            $this->verify     = Kuteshop_Toolkit()->verify_envato();

            add_action('admin_init', array($this, 'page_init'));
            add_action('admin_notices', array($this, 'display_message'));
            add_action('ovic_envato_license', array($this, 'settings'));
        }

        public function page_init()
        {
            $config = array(
                array(
                    'id'    => 'purchased_code',
                    'type'  => 'text',
                    'title' => esc_html__('Purchased code', 'kuteshop-toolkit'),
                    'desc'  => esc_html__('Purchased code license item.', 'kuteshop-toolkit'),
                ),
            );
            $fields = array(
                'title'  => '',
                'id'     => $this->key,
                'type'   => 'fieldset',
                'fields' => $config,
            );

            register_setting(
                'ovic_addon_envato',
                $this->key
            );
            add_settings_section(
                'ovic_envato_license_id',
                null,
                null,
                'ovic-envato-license'
            );
            add_settings_field(
                $this->key,
                '',
                function () use ($fields) {
                    echo '<div class="ovic-onload">';
                    echo OVIC::field($fields, $this->verify['settings']);
                    echo '</div>';
                },
                'ovic-envato-license',
                'ovic_envato_license_id'
            );
        }

        public function license_info()
        {
            $time = '00/00/0000';
            $last = '00/00/0000';
            $name = $this->theme->get('Name');
            $link = $this->link;
            $txt  = esc_html__('Not activated', 'kuteshop-toolkit');
            if ($this->verify['active'] == true) {
                $txt  = esc_html__('Activated', 'kuteshop-toolkit');
                $time = new DateTime($this->verify['product']['supported_until']);
                $time = $time->format('d/m/Y h:i:s');
                $last = new DateTime($this->verify['product']['item']['updated_at']);
                $last = $last->format('d/m/Y h:i:s');
                $name = $this->verify['product']['item']['name'];
                $id   = $this->verify['product']['item']['id'];
                $url  = $this->verify['product']['item']['url'];
                $link = !empty($this->affiliates[$id]) ? $this->affiliates[$id] : $url;
            }
            $status  = sprintf('<b>%s </b><span>%s</span>',
                esc_html__('Status:', 'kuteshop-toolkit'),
                $txt
            );
            $support = sprintf('<b>%s </b><span>%s</span>',
                esc_html__('Support until:', 'kuteshop-toolkit'),
                $time
            );
            $update  = sprintf('<b>%s </b><span>%s</span>',
                esc_html__('Last update:', 'kuteshop-toolkit'),
                $last
            );
            $product = sprintf('<b>%s </b><a href="%s">%s</a>',
                esc_html__('Product:', 'kuteshop-toolkit'),
                $link,
                $name
            );
            ?>
            <div class="license-info">
                <p class="product">
                    <?php echo wp_kses_post($product); ?>
                </p>
                <p class="status">
                    <?php echo wp_kses_post($status); ?>
                </p>
                <p class="support">
                    <?php echo wp_kses_post($support); ?>
                </p>
                <p class="update">
                    <?php echo wp_kses_post($update); ?>
                </p>
            </div>
            <?php
        }

        public function settings()
        {
            $class = '';
            if ($this->verify['active'] == true) {
                $class = ' activated';
            }
            ?>
            <div class="wrap ovic-license-settings ovic-addon-settings<?php echo esc_attr($class); ?>">
                <h3><?php echo esc_html__('Active Theme License', 'kuteshop-toolkit'); ?></h3>
                <?php $this->license_info(); ?>
                <form method="post" action="options.php">
                    <?php
                    // This prints out all hidden setting fields
                    settings_fields('ovic_addon_envato');
                    do_settings_sections('ovic-envato-license');
                    submit_button();
                    ?>
                </form>
            </div>
            <?php
        }

        public function display_message()
        {
            // Checks license status to display under license key
            if ($this->verify['active'] == false) {
                $theme_name  = $this->theme->get('Name');
                $message     = esc_html__('Please activate this theme before 01/08/2020, the functionality will stop working if the theme is not activated.', 'kuteshop-toolkit');
                $button_text = sprintf(esc_html__('Activate %s', 'kuteshop-toolkit'), $theme_name);
                $button_link = admin_url('admin.php?page=kuteshop_menu&tab=license');
                $link        = $this->link;
                ?>
                <style>
                    .notice.kuteshop-toolkit-notice {
                        border-left-color: red !important;
                        padding: 20px !important;
                    }

                    .rtl .notice.kuteshop-toolkit-notice {
                        border-right-color: red !important;
                    }

                    .notice.kuteshop-toolkit-notice .kuteshop-toolkit-notice-inner {
                        display: table;
                        width: 100%;
                    }

                    .notice.kuteshop-toolkit-notice .message {
                        color: red;
                    }

                    .notice.kuteshop-toolkit-notice .kuteshop-toolkit-notice-inner .kuteshop-toolkit-notice-icon,
                    .notice.kuteshop-toolkit-notice .kuteshop-toolkit-notice-inner .kuteshop-toolkit-notice-content,
                    .notice.kuteshop-toolkit-notice .kuteshop-toolkit-notice-inner .kuteshop-toolkit-install-now {
                        display: table-cell;
                        vertical-align: middle;
                    }

                    .notice.kuteshop-toolkit-notice .kuteshop-toolkit-notice-icon {
                        color: red;
                        font-size: 50px;
                        width: 162px;
                    }

                    .notice.kuteshop-toolkit-notice .kuteshop-toolkit-notice-icon img {
                        display: block;
                        width: 100%;
                    }

                    .notice.kuteshop-toolkit-notice .kuteshop-toolkit-notice-content {
                        padding: 0 20px;
                    }

                    .notice.kuteshop-toolkit-notice p {
                        padding: 0;
                        margin: 0;
                    }

                    .notice.kuteshop-toolkit-notice h3 {
                        margin: 0 0 5px;
                    }

                    .notice.kuteshop-toolkit-notice .kuteshop-toolkit-install-now {
                        text-align: center;
                    }

                    .notice.kuteshop-toolkit-notice .kuteshop-toolkit-install-now .kuteshop-toolkit-install-button {
                        padding: 5px 30px;
                        height: auto;
                        line-height: 20px;
                        text-transform: capitalize;
                    }

                    .notice.kuteshop-toolkit-notice .kuteshop-toolkit-install-now .kuteshop-toolkit-install-button i {
                        padding-right: 5px;
                        vertical-align: middle;
                    }

                    .rtl .notice.kuteshop-toolkit-notice .kuteshop-toolkit-install-now .kuteshop-toolkit-install-button i {
                        padding-right: 0;
                        padding-left: 5px;
                    }

                    .notice.kuteshop-toolkit-notice .kuteshop-toolkit-install-now .kuteshop-toolkit-install-button:active {
                        transform: translateY(1px);
                    }

                    @media (max-width: 782px) {
                        .notice.kuteshop-toolkit-notice .kuteshop-toolkit-install-now .kuteshop-toolkit-install-button {
                            line-height: 25px;
                        }
                    }

                    @media (max-width: 767px) {
                        .notice.kuteshop-toolkit-notice {
                            padding: 10px;
                        }

                        .notice.kuteshop-toolkit-notice .kuteshop-toolkit-notice-inner {
                            display: block;
                        }

                        .notice.kuteshop-toolkit-notice .kuteshop-toolkit-notice-inner .kuteshop-toolkit-notice-content {
                            display: block;
                            padding: 0;
                        }

                        .notice.kuteshop-toolkit-notice .kuteshop-toolkit-notice-inner .kuteshop-toolkit-notice-icon {
                            display: none;
                        }

                        .notice.kuteshop-toolkit-notice .kuteshop-toolkit-install-now .kuteshop-toolkit-install-button {
                            margin-top: 4px;
                        }
                    }
                </style>
                <div class="notice updated is-dismissible kuteshop-toolkit-notice kuteshop-toolkit-install-elementor">
                    <div class="kuteshop-toolkit-notice-inner">
                        <div class="kuteshop-toolkit-notice-icon">
                            <img src="<?php echo esc_url(KUTESHOP_TOOLKIT_URL.'/assets/images/logo.png'); ?>"
                                 alt="Kutethemes Logo"/>
                        </div>
                        <div class="kuteshop-toolkit-notice-content">
                            <h3>
                                <?php printf(esc_html__('Thanks for installing %s!', 'kuteshop-toolkit'),
                                    $theme_name
                                ); ?>
                            </h3>
                            <p class="message"><?php echo esc_html($message); ?></p>
                            <a href="<?php echo esc_url($link); ?>"
                               target="_blank">
                                <?php esc_html_e('Browse theme', 'kuteshop-toolkit'); ?>
                            </a>
                        </div>
                        <div class="kuteshop-toolkit-install-now">
                            <a class="button button-primary kuteshop-toolkit-install-button"
                               href="<?php echo esc_attr($button_link); ?>">
                                <i class="dashicons dashicons-download"></i>
                                <?php echo esc_html($button_text); ?>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
    }

    return new Ovic_Verify_Envato();
}