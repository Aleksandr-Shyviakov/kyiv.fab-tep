<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access directly.
/**
 *
 * Field: repeater
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!class_exists('OVIC_Field_repeater')) {
    class OVIC_Field_repeater extends OVIC_Fields
    {

        public function __construct($field, $value = '', $unique = '', $where = '', $parent = '')
        {
            parent::__construct($field, $value, $unique, $where, $parent);
        }

        public function render()
        {

            if (!wp_script_is('jquery-ui-sortable')) {
                wp_enqueue_script('jquery-ui-sortable');
            }

            $args = wp_parse_args($this->field, array(
                'max'          => 0,
                'min'          => 0,
                'button_title' => '<i class="fas fa-plus-circle"></i>',
            ));

            $fields    = $this->field['fields'];
            $unique_id = (!empty($this->unique)) ? '['.$this->field['id'].']' : $this->field['id'];

            if ($this->parent && preg_match('/'.preg_quote('['.$this->field['id'].']').'/', $this->parent)) {

                echo '<div class="ovic-notice ovic-notice-danger">'.esc_html__('Error: Nested field id can not be same with another nested field id.', 'ovic-addon-toolkit').'</div>';

            } else {

                echo $this->field_before();

                echo '<div class="ovic-repeater-item ovic-repeater-hidden">';
                echo '<div class="ovic-repeater-content">';
                foreach ($fields as $field) {

                    $field_parent  = $this->parent.'['.$this->field['id'].']';
                    $field_default = (isset($field['default'])) ? $field['default'] : '';

                    echo OVIC::field($field, $field_default, '_nonce', 'field/repeater', $field_parent);

                }
                echo '</div>';
                echo '<div class="ovic-repeater-helper">';
                echo '<div class="ovic-repeater-helper-inner">';
                echo '<i class="ovic-repeater-sort fas fa-arrows-alt"></i>';
                echo '<i class="ovic-repeater-clone far fa-clone"></i>';
                echo '<i class="ovic-repeater-remove ovic-confirm fas fa-times" data-confirm="'.esc_html__('Are you sure to delete this item?', 'ovic-addon-toolkit').'"></i>';
                echo '</div>';
                echo '</div>';
                echo '</div>';

                echo '<div class="ovic-repeater-wrapper ovic-data-wrapper" data-unique-id="'.esc_attr($this->unique).'" data-field-id="'.esc_attr($unique_id).'" data-max="'.esc_attr($args['max']).'" data-min="'.esc_attr($args['min']).'">';

                if (!empty($this->value) && is_array($this->value)) {

                    $num = 0;

                    foreach ($this->value as $key => $value) {

                        echo '<div class="ovic-repeater-item">';

                        echo '<div class="ovic-repeater-content">';
                        foreach ($fields as $field) {

                            $field_parent = $this->parent.'['.$this->field['id'].']';
                            $field_unique = (!empty($this->unique)) ? $this->unique.'['.$this->field['id'].']['.$num.']' : $this->field['id'].'['.$num.']';
                            $field_value  = (isset($field['id']) && isset($this->value[$key][$field['id']])) ? $this->value[$key][$field['id']] : '';

                            echo OVIC::field($field, $field_value, $field_unique, 'field/repeater', $field_parent);

                        }
                        echo '</div>';

                        echo '<div class="ovic-repeater-helper">';
                        echo '<div class="ovic-repeater-helper-inner">';
                        echo '<i class="ovic-repeater-sort fas fa-arrows-alt"></i>';
                        echo '<i class="ovic-repeater-clone far fa-clone"></i>';
                        echo '<i class="ovic-repeater-remove ovic-confirm fas fa-times" data-confirm="'.esc_html__('Are you sure to delete this item?', 'ovic-addon-toolkit').'"></i>';
                        echo '</div>';
                        echo '</div>';

                        echo '</div>';

                        $num++;

                    }

                }

                echo '</div>';

                echo '<div class="ovic-repeater-alert ovic-repeater-max">'.esc_html__('You can not add more than', 'ovic-addon-toolkit').' '.esc_attr($args['max']).'</div>';
                echo '<div class="ovic-repeater-alert ovic-repeater-min">'.esc_html__('You can not remove less than', 'ovic-addon-toolkit').' '.esc_attr($args['min']).'</div>';

                echo '<a href="#" class="button button-primary ovic-repeater-add">'.wp_kses_post($args['button_title']).'</a>';

                echo $this->field_after();

            }

        }

    }
}
