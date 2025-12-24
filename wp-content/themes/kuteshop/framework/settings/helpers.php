<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access pages directly.
/* HOOK */
if (!is_admin()) {
    add_filter('wp_get_attachment_url', 'kuteshop_get_attachment_url', 10, 2);
    add_filter('wp_get_attachment_image_attributes', 'kuteshop_lazy_attachment_image', 10, 3);
    add_filter('wp_kses_allowed_html', 'kuteshop_kses_allowed_html', 10, 2);
    add_filter('dokan_product_image_attributes', 'kuteshop_dokan_image_attributes', 10, 3);
    add_filter('post_thumbnail_html', 'kuteshop_post_thumbnail_html', 10, 5);
    add_filter('vc_wpb_getimagesize', 'kuteshop_wpb_getimagesize', 10, 3);
}
/* SET SESSION */
/*
if (!function_exists('kuteshop_session')) {
    function kuteshop_session()
    {
        if (!is_admin() && !session_id()) {
            session_start();
        }
    }

    add_action('init', 'kuteshop_session');
}
*/
/* GET OPTION */
if (!function_exists('kuteshop_get_option')) {
    function kuteshop_get_option($option_name = '', $default = '')
    {
        $get_value  = isset($_GET[$option_name]) ? $_GET[$option_name] : '';
        $get_option = get_option('_cs_options');
        if (isset($_GET[$option_name])) {
            $get_option = $get_value;
            $default    = $get_value;
        }
        $options = apply_filters('ovic_get_customize_option', $get_option, $option_name, $default);
        if (!empty($option_name) && !empty($options[$option_name])) {
            $option = $options[$option_name];
            if (is_array($option) && isset($option['multilang']) && $option['multilang'] == true) {
                if (defined('ICL_LANGUAGE_CODE')) {
                    if (isset($option[ICL_LANGUAGE_CODE])) {
                        return $option[ICL_LANGUAGE_CODE];
                    }
                }
            }

            return $option;
        } else {
            return (!empty($default)) ? $default : null;
        }
    }
}
/* GET META */
if (!function_exists('kuteshop_get_option_meta')) {
    function kuteshop_get_option_meta($meta_id, $option_key, $key_meta = '', $default = '')
    {
        $ID = get_the_ID();

        if (!empty($_GET['demo']) && $meta_id == '_custom_metabox_theme_options') {
            $ID = $_GET['demo'];
        }

        if ($option_key == null) {
            $enable_options = 1;
            $theme_options  = $default;
        } else {
            $enable_options = kuteshop_get_option('enable_theme_options');
            $theme_options  = kuteshop_get_option($option_key, $default);
        }
        if ($key_meta == '') {
            $key_meta = "metabox_{$option_key}";
        }

        $data_meta = get_post_meta($ID, $meta_id, true);

        if ($enable_options == 1 && isset($data_meta[$key_meta])) {
            $theme_options = $data_meta[$key_meta];
        }
        if ($default != '' && $theme_options == '') {
            $theme_options = $default;
        }

        return $theme_options;
    }
}
if (!function_exists('kuteshop_get_meta')) {
    function kuteshop_get_meta($meta_id, $meta_key)
    {
        $main_data = '';
        $ID        = get_the_ID();

        if (!empty($_GET['demo']) && $meta_id == '_custom_metabox_theme_options') {
            $ID = $_GET['demo'];
        }
        $enable_theme_options = kuteshop_get_option('enable_theme_options');
        $meta_data            = get_post_meta($ID, $meta_id, true);
        if (!empty($meta_data[$meta_key]) && $enable_theme_options == 1) {
            $main_data = $meta_data[$meta_key];
        }

        return $main_data;
    }
}
/**
 *
 * RESIZE IMAGE
 * svg: <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"></svg>
 **/
if (!function_exists('kuteshop_dokan_image_attributes')) {
    function kuteshop_dokan_image_attributes($image_attributes)
    {
        $image_attributes['img']['data-src'] = array();

        return $image_attributes;
    }
}
if (!function_exists('kuteshop_get_attachment_url')) {
    function kuteshop_get_attachment_url($url, $post_id)
    {
        if (function_exists('jetpack_photon_url')) {
            $url = jetpack_photon_url($url);
        }

        return $url;
    }
}

if (!function_exists('kuteshop_kses_allowed_html')) {
    function kuteshop_kses_allowed_html($allowedposttags, $context)
    {
        $allowedposttags['img']['data-src']    = true;
        $allowedposttags['img']['data-srcset'] = true;
        $allowedposttags['img']['data-sizes']  = true;

        return $allowedposttags;
    }
}

if (!function_exists('kuteshop_lazy_attachment_image')) {
    function kuteshop_lazy_attachment_image($attr, $attachment, $size)
    {
        $enable_lazy = kuteshop_get_option('kuteshop_theme_lazy_load');
        $image_size  = apply_filters('woocommerce_gallery_image_size', 'woocommerce_single');
        if ($size == $image_size && class_exists('WooCommerce')) {
            if (is_product()) {
                $enable_lazy = 0;
            }
        }
        if ($enable_lazy == 1) {
            $data_img         = wp_get_attachment_image_src($attachment->ID, $size);
            $img_lazy         = "data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%27http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%27%20viewBox%3D%270%200%20".$data_img[1]."%20".$data_img[2]."%27%2F%3E";
            $attr['data-src'] = $attr['src'];
            $attr['src']      = $img_lazy;
            $attr['class']    .= ' lazy';
            if (isset($attr['srcset']) && $attr['srcset'] != '') {
                $attr['data-srcset'] = $attr['srcset'];
                $attr['data-sizes']  = $attr['sizes'];
                unset($attr['srcset']);
                unset($attr['sizes']);
            }
        }

        return $attr;
    }
}

if (!function_exists('kuteshop_post_thumbnail_html')) {
    function kuteshop_post_thumbnail_html($html, $post_ID, $post_thumbnail_id, $size, $attr)
    {
        $enable_lazy = kuteshop_get_option('kuteshop_theme_lazy_load');
        if ($enable_lazy == 1) {
            $html = '<figure>'.$html.'</figure>';
        }

        return $html;
    }
}

if (!function_exists('kuteshop_wpb_getimagesize')) {
    function kuteshop_wpb_getimagesize($img, $attach_id, $params)
    {
        $enable_lazy = kuteshop_get_option('kuteshop_theme_lazy_load');
        if ($enable_lazy == 1) {
            $img['thumbnail'] = '<figure>'.$img['thumbnail'].'</figure>';
        }

        return $img;
    }
}

if (!function_exists('kuteshop_get_attachment_image')) {
    function kuteshop_get_attachment_image($attachment_id, $src, $width, $height, $lazy, $class)
    {
        $image    = '';
        $img_lazy = "data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22{$width}%22%20height%3D%22{$height}%22%20viewBox%3D%220%200%20{$width}%20{$height}%22%3E%3C%2Fsvg%3E";
        if (is_ajax()) {
            $lazy = false;
        }
        if ($src) {
            $hwstring   = image_hwstring($width, $height);
            $size_class = $width.'x'.$height;
            $attachment = get_post($attachment_id);
            $attr       = array(
                'src'   => $src,
                'class' => "attachment-$size_class size-$size_class",
                'alt'   => trim(strip_tags(get_post_meta($attachment_id, '_wp_attachment_image_alt', true))),
            );
            if ($class != '') {
                $attr['class'] .= " $class";
            }
            if ($lazy == true) {
                $attr['src']      = $img_lazy;
                $attr['data-src'] = $src;
                $attr['class']    .= ' lazy';
            }
            $attr  = apply_filters('kuteshop_get_attachment_image_attributes', $attr, $attachment);
            $attr  = array_map('esc_attr', $attr);
            $image = rtrim("<img $hwstring");
            foreach ($attr as $name => $value) {
                $image .= " $name=".'"'.$value.'"';
            }
            $image .= ' />';
        }

        return array(
            'url'    => $src,
            'width'  => $width,
            'height' => $height,
            'img'    => $image,
        );
    }
}

if (!function_exists('kuteshop_resize_image')) {
    function kuteshop_resize_image($attachment_id, $width, $height, $crop = true, $use_lazy = false)
    {
        $class        = '';
        $original     = false;
        $needs_resize = true;
        $image_src    = array();
        $width        = absint($width);
        $height       = absint($height);
        if ($width == false && $height == false) {
            $original = true;
        }
        if (is_numeric($attachment_id)) {
            $image_src     = wp_get_attachment_image_src($attachment_id, 'full');
            $attached_file = get_attached_file($attachment_id);
            // this is not an attachment, let's use the image url
        } elseif (!empty($attachment_id) && @getimagesize($attachment_id)) {
            $img_url       = $attachment_id;
            $file_path     = parse_url($img_url);
            $attached_file = rtrim(ABSPATH, '/').$file_path['path'];
            $orig_size     = @getimagesize($attached_file);
            $image_src[0]  = $img_url;
            $image_src[1]  = $orig_size[0];
            $image_src[2]  = $orig_size[1];
        }

        if (!empty($attached_file)) {
            // checking if the full size
            if ($original == true) {
                return kuteshop_get_attachment_image(
                    $attachment_id,
                    $image_src[0],
                    $image_src[1],
                    $image_src[2],
                    $use_lazy,
                    $class
                );
            }
            // Look through the attachment meta data for an image that fits our size.
            $meta       = wp_get_attachment_metadata($attachment_id);
            $upload_dir = wp_upload_dir();
            $base_dir   = strtolower($upload_dir['basedir']);
            $base_url   = strtolower($upload_dir['baseurl']);
            $src        = trailingslashit($base_url).$meta['file'];
            $path       = trailingslashit($base_dir).$meta['file'];
            foreach ($meta['sizes'] as $key => $size) {
                if (($size['width'] == $width && $size['height'] == $height) || $key == sprintf('resized-%dx%d', $width, $height)) {
                    if (!empty($size['file'])) {
                        $file = str_replace(basename($path), $size['file'], $path);
                        $src  = str_replace(basename($src), $size['file'], $src);
                        if (file_exists($file)) {
                            $needs_resize = false;
                        }
                    }
                    break;
                }
            }
            // checking if the file size is larger than the target size
            // if it is smaller or the same size, stop right here and return
            if ($needs_resize) {
                $resized = image_make_intermediate_size($attached_file, $width, $height, $crop);

                if (is_wp_error($resized)) {
                    return kuteshop_get_attachment_image(
                        $attachment_id,
                        $image_src[0],
                        $image_src[1],
                        $image_src[2],
                        $use_lazy,
                        $class
                    );
                }
                if (empty($resized)) {
                    $image_no_crop = wp_get_attachment_image_src($attachment_id, array($width, $height));

                    return kuteshop_get_attachment_image(
                        $attachment_id,
                        $image_no_crop[0],
                        $image_no_crop[1],
                        $image_no_crop[2],
                        $use_lazy,
                        $class
                    );
                }

                // Let metadata know about our new size.
                $key                 = sprintf('resized-%dx%d', $width, $height);
                $meta['sizes'][$key] = $resized;
                if (!empty($resized['file'])) {
                    $src = str_replace(basename($src), $resized['file'], $src);
                }

                wp_update_attachment_metadata($attachment_id, $meta);

                // Record in backup sizes so everything's cleaned up when attachment is deleted.
                $backup_sizes = get_post_meta($attachment_id, '_wp_attachment_backup_sizes', true);
                if (!is_array($backup_sizes)) {
                    $backup_sizes = array();
                }
                $backup_sizes[$key] = $resized;
                update_post_meta($attachment_id, '_wp_attachment_backup_sizes', $backup_sizes);
            }

            // output image
            return kuteshop_get_attachment_image(
                $attachment_id,
                $src,
                $width,
                $height,
                $use_lazy,
                $class
            );
        } elseif (!empty($image_src)) {
            return kuteshop_get_attachment_image(
                $attachment_id,
                $image_src[0],
                $image_src[1],
                $image_src[2],
                $use_lazy,
                $class
            );
        }
        // placeholder image
        $placeholder_url = "https://via.placeholder.com/{$width}x{$height}?text={$width}x{$height}";

        return array(
            'url'    => $placeholder_url,
            'width'  => $width,
            'height' => $height,
            'img'    => "<img class='attachment-{$width}x{$height} size-{$width}x{$height} {$class}' src='{$placeholder_url}' ".image_hwstring($width, $height)." alt='placeholder'>",
        );
    }
}

if (!function_exists('kuteshop_product_query')) {
    function kuteshop_product_query($atts, $args = array(), $ignore_sticky_posts = 1)
    {
        extract($atts);
        $target             = isset($target) ? $target : 'recent-product';
        $meta_query         = WC()->query->get_meta_query();
        $args['meta_query'] = $meta_query;
        $args['post_type']  = 'product';
        if (isset($atts['taxonomy']) && $atts['taxonomy'] != '') {
            $args['tax_query'] =
                array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field'    => 'slug',
                        'terms'    => array_map('sanitize_title', explode(',', $atts['taxonomy'])
                        ),
                    ),
                );
        }
        $args['post_status']         = 'publish';
        $args['ignore_sticky_posts'] = $ignore_sticky_posts;
        $args['suppress_filter']     = true;
        if (isset($atts['per_page']) && $atts['per_page']) {
            $args['posts_per_page'] = $atts['per_page'];
        }
        $ordering_args = WC()->query->get_catalog_ordering_args();

        $orderby = !empty($atts['orderby']) ? $atts['orderby'] : $ordering_args['orderby'];
        $order   = !empty($atts['order']) ? $atts['order'] : $ordering_args['order'];

        switch ($target):
            case 'best-selling' :
                $args['meta_key'] = 'total_sales';
                $args['orderby']  = 'meta_value_num';
                break;
            case 'top-rated' :
                $args['meta_key'] = '_wc_average_rating';
                $args['orderby']  = array(
                    'meta_value_num' => $order,
                    'ID'             => 'ASC',
                );
                break;
            case 'product-category' :
                $ordering_args   = WC()->query->get_catalog_ordering_args($orderby, $order);
                $args['orderby'] = $ordering_args['orderby'];
                $args['order']   = $ordering_args['order'];
                break;
            case 'product-brand' :
                if (isset($atts['taxonomy_brand']) && $atts['taxonomy_brand'] != '') {
                    $args['tax_query'] =
                        array(
                            array(
                                'taxonomy' => 'product_brand',
                                'field'    => 'slug',
                                'terms'    => $atts['taxonomy_brand'],
                            ),
                        );
                }
                $ordering_args   = WC()->query->get_catalog_ordering_args($orderby, $order);
                $args['orderby'] = $ordering_args['orderby'];
                $args['order']   = $ordering_args['order'];
                break;
            case 'products' :
                $args['posts_per_page'] = -1;
                if (!empty($ids)) {
                    $args['post__in'] = array_map('trim', explode(',', $ids));
                    $args['orderby']  = 'post__in';
                }
                if (!empty($skus)) {
                    $args['meta_query'][] = array(
                        'key'     => '_sku',
                        'value'   => array_map('trim', explode(',', $skus)),
                        'compare' => 'IN',
                    );
                }
                break;
            case 'featured_products' :
                $meta_query         = WC()->query->get_meta_query();
                $tax_query          = WC()->query->get_tax_query();
                $tax_query[]        = array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => 'featured',
                    'operator' => 'IN',
                );
                $args['tax_query']  = $tax_query;
                $args['meta_query'] = $meta_query;
                break;
            case 'product_attribute' :
                //'recent-product'
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => strstr($atts['attribute'], 'pa_') ? sanitize_title($atts['attribute']) : 'pa_'.sanitize_title($atts['attribute']),
                        'terms'    => array_map('sanitize_title', explode(',', $atts['filter'])),
                        'field'    => 'slug',
                    ),
                );
                break;
            case 'on_new' :
                $newness            = kuteshop_get_option('product_newness', 0);    // Newness in days as defined by option
                $args['date_query'] = array(
                    array(
                        'after'     => ''.$newness.' days ago',
                        'inclusive' => true,
                    ),
                );
                if ($orderby == '_sale_price') {
                    $orderby = 'date';
                    $order   = 'DESC';
                }
                $args['orderby'] = $orderby;
                $args['order']   = $order;
                break;
            case 'on_sale' :
                $product_ids_on_sale = wc_get_product_ids_on_sale();
                $args['post__in']    = array_merge(array(0), $product_ids_on_sale);
                if ($orderby == '_sale_price') {
                    $orderby = 'date';
                    $order   = 'DESC';
                }
                $args['orderby'] = $orderby;
                $args['order']   = $order;
                break;
            default :
                //'recent-product'
                $args['orderby'] = $orderby;
                $args['order']   = $order;
                if (isset($ordering_args['meta_key'])) {
                    $args['meta_key'] = $ordering_args['meta_key'];
                }
                // Remove ordering query arguments
                WC()->query->remove_ordering_args();
                break;
        endswitch;

        return $products = new WP_Query(apply_filters('woocommerce_shortcode_products_query', $args, $atts, $args['post_type']));
    }
}