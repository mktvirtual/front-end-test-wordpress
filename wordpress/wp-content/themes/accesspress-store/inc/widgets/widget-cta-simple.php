<?php

/**
 * Testimonial post/page widget
 *
 * @package Accesspress Pro
 */
/**
 * Adds accesspress_store_Testimonial widget.
 */
add_action('widgets_init', 'register_cta_simple_widget');

function register_cta_simple_widget() {
    register_widget('accesspress_cta_simple');
}

if( !class_exists( 'Accesspress_cta_simple' ) ) :
    class Accesspress_cta_simple extends WP_Widget {

        /**
         * Register widget with WordPress.
         */
        public function __construct() {
            parent::__construct(
                'accesspress_cta_simple', 'AP :  Call to Action', array(
                'description' => __('A widget that shows Simple Call to Action', 'accesspress-store')
                    )
            );
        }

        /**
         * Helper function that holds widget fields
         * Array is used in update and form functions
         */
        private function widget_fields() {
            $fields = array(
                'cta_simple_title' => array(
                    'accesspress_store_widgets_name' => 'cta_simple_title',
                    'accesspress_store_widgets_title' => __('Title', 'accesspress-store'),
                    'accesspress_store_widgets_field_type' => 'title'
                ),
                'cta_simple_phone' => array(
                    'accesspress_store_widgets_name' => 'cta_simple_desc',
                    'accesspress_store_widgets_title' => __('Description', 'accesspress-store'),
                    'accesspress_store_widgets_field_type' => 'textarea',
                    'accesspress_store_widgets_row' => '4'
                ),
                'cta_simple_website' => array(
                    'accesspress_store_widgets_name' => 'cta_simple_btn_text',
                    'accesspress_store_widgets_title' => __('Button Text', 'accesspress-store'),
                    'accesspress_store_widgets_field_type' => 'text',
                ),
                'cta_simple_font_awesome' => array(
                    'accesspress_store_widgets_name' => 'cta_simple_font_awsome',
                    'accesspress_store_widgets_title' => __('Enter Fontawesome Class to show in button', 'accesspress-store'),
                    'accesspress_store_widgets_field_type' => 'text',
                ),
                'cta_simple_address' => array(
                    'accesspress_store_widgets_name' => 'cta_simple_btn_url',
                    'accesspress_store_widgets_title' => __('Button Url', 'accesspress-store'),
                    'accesspress_store_widgets_field_type' => 'text'
                    
                )
                
            );

            return $fields;
        }

        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         *
         * @param array $args     Widget arguments.
         * @param array $instance Saved values from database.
         */
        public function widget($args, $instance) {
            extract($args);
            if($instance!=null){
                $cta_simple_title = $instance['cta_simple_title'];
                $cta_simple_desc = $instance['cta_simple_desc'];
                $cta_simple_btn_text = $instance['cta_simple_btn_text'];
                $cta_simple_btn_url = $instance['cta_simple_btn_url'];
                $cta_simple_font_class = $instance['cta_simple_font_awsome'];
            }
            else
            {
                $cta_simple_title = "";
                $cta_simple_desc = "";
                $cta_simple_btn_text = "";
                $cta_simple_btn_url = "";
                $cta_simple_font_class = "";
            }
            echo $before_widget; ?>            
            <div class="cta-banner clearfix">
                <div class="banner-text wow fadeInLeft" data-wow-delay="0.5s">
                    <h1 class="widget-title"><?php echo $cta_simple_title;?></h1>                        
                    <div class="cta-desc_simple"><?php echo $cta_simple_desc;  ?></div>
                </div>
                <div class="banner-btn wow fadeInRight" data-wow-delay="0.5s">
                    <a class="btn" href="<?php echo $cta_simple_btn_url; ?>"><i class="fa <?php echo $cta_simple_font_class; ?>"></i><?php echo $cta_simple_btn_text; ?></a>
                </div>                
            </div>
            <?php 
            echo $after_widget;
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @see WP_Widget::update()
         *
         * @param	array	$new_instance	Values just sent to be saved.
         * @param	array	$old_instance	Previously saved values from database.
         *
         * @uses	accesspress_store_widgets_updated_field_value()		defined in widget-fields.php
         *
         * @return	array Updated safe values to be saved.
         */
        public function update($new_instance, $old_instance) {
            $instance = $old_instance;

            $widget_fields = $this->widget_fields();

            // Loop through fields
            foreach ($widget_fields as $widget_field) {

                extract($widget_field);

                // Use helper function to get updated field values
                $instance[$accesspress_store_widgets_name] = accesspress_store_widgets_updated_field_value($widget_field, $new_instance[$accesspress_store_widgets_name]);
            }

            return $instance;
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param	array $instance Previously saved values from database.
         *
         * @uses	accesspress_store_widgets_show_widget_field()		defined in widget-fields.php
         */
        public function form($instance) {
            $widget_fields = $this->widget_fields();

            // Loop through fields
            foreach ($widget_fields as $widget_field) {

                // Make array elements available as variables
                extract($widget_field);
                $accesspress_store_widgets_field_value = !empty($instance[$accesspress_store_widgets_name]) ? esc_attr($instance[$accesspress_store_widgets_name]) : '';
                accesspress_store_widgets_show_widget_field($this, $widget_field, $accesspress_store_widgets_field_value);
            }
        }
    }
endif;
