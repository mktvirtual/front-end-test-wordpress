<?php

/**
 * Testimonial post/page widget
 *
 * @package Accesspress Pro
 */
/**
 * Adds accesspress_store_Testimonial widget.
 */
add_action('widgets_init', 'register_icon_text_widget');

function register_icon_text_widget() {
    register_widget('accesspress_store_icon_text');
}

if( !class_exists( 'accesspress_store_Icon_Text' ) ) :
class accesspress_store_Icon_Text extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'accesspress_store_icon_text', 'AP : Icon Text Block', array(
            'description' => __('A widget that shows Text with Icon', 'accesspress-store')
                )
        );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {

        $fields = array(

            'icon_text_title' => array(
                'accesspress_store_widgets_name' => 'icon_text_title',
                'accesspress_store_widgets_title' => __('Title', 'accesspress-store'),
                'accesspress_store_widgets_field_type' => 'text',
            ),
            'icon_text_content' => array(
                'accesspress_store_widgets_name' => 'icon_text_content',
                'accesspress_store_widgets_title' => __('Content', 'accesspress-store'),
                'accesspress_store_widgets_field_type' => 'textarea',
                'accesspress_store_widgets_row' => '6'
            ),
            'icon_text_icon' => array(
                'accesspress_store_widgets_name' => 'icon_text_icon',
                'accesspress_store_widgets_title' => __('Icon', 'accesspress-store'),
                'accesspress_store_widgets_field_type' => 'icon',
            ),
            'icon_text_readmore' => array(
                'accesspress_store_widgets_name' => 'icon_text_readmore',
                'accesspress_store_widgets_title' => __('Read More Text', 'accesspress-store'),
                 'accesspress_store_widgets_desc' => __('Leave Empty not to show', 'accesspress-store'),
                'accesspress_store_widgets_field_type' => 'text',
            ),
            'icon_text_readmore_link' => array(
                'accesspress_store_widgets_name' => 'icon_text_readmore_link',
                'accesspress_store_widgets_title' => __('Read More Link', 'accesspress-store'),
                'accesspress_store_widgets_field_type' => 'url',
            ),            
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

        $icon_text_title = $instance['icon_text_title'];
        $icon_text_content = $instance['icon_text_content'];
        $icon_text_icon = $instance['icon_text_icon'];
        $icon_text_readmore = $instance['icon_text_readmore'];
        $icon_text_readmore_link = $instance['icon_text_readmore_link'];

        echo $before_widget; ?>
        <div class="wow fadeInUp ap-icon-text">
        <?php
        
        if (!empty($icon_text_icon)): 
        if(!empty($icon_text_readmore_link)){?>
        
        <a class="bttn" href="<?php if(!empty($icon_text_readmore_link)){ echo $icon_text_readmore_link; }?>"><?php }?>
        <div class="ap-icon-text-icon">
            <i class="<?php echo $icon_text_icon; ?>"></i>
        </div>    
        <?php
        if(!empty($icon_text_readmore_link)){?></a><?php } ?>
        <?php endif; ?>

        <div class="ap-icon-text-content-wrap">
        <div class="ap-icon-text-inner">
        <?php
        if (!empty($icon_text_title)): ?>
            <h5 class="ap-icon-text-title">
            <?php echo $icon_text_title; ?>
            </h5>
        <?php endif; ?>

        <?php    
        if (!empty($icon_text_content)): ?>
            <div class="ap-icon-text-content">
            <?php echo $icon_text_content; ?>
            </div>
        <?php endif; ?>

        <?php  
        if (!empty($icon_text_readmore)): ?>
            <div class="ap-icon-text-readmore">
            <a class="bttn" href="<?php echo $icon_text_readmore_link; ?>"><?php echo $icon_text_readmore; ?></a>
            </div>
        <?php endif; ?>
        </div>
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
