<?php

class NewsletterWidgetMinimal extends WP_Widget {

    function __construct() {
        parent::__construct(false, $name = 'Newsletter Minimal', array('description' => 'Newsletter widget to add a minimal subscription form'), array('width' => '350px'));
    }

    function widget($args, $instance) {
        global $newsletter;
        extract($args);

        echo $before_widget;

        if (!is_array($instance)) {
            $instance = array();
        }
        // Filters are used for WPML
        if (!empty($instance['title'])) {
            $title = apply_filters('widget_title', $instance['title'], $instance);
            echo $before_title . $title . $after_title;
        }

        if (empty($instance['button'])) {
            $instance['button'] = 'Subscribe';
        }

        $options_profile = get_option('newsletter_profile');
        

        $form = '<div class="tnp tnp-widget-minimal">';
        $form .= '<form action="' . esc_attr(home_url('/')) . '?na=s" method="post">';
        if (isset($instance['nl']) && is_array($instance['nl'])) {
            foreach ($instance['nl'] as $a) {
                $form .= "<input type='hidden' name='nl[]' value='" . ((int) trim($a)) . "'>\n";
            }
        }
        // Referrer
        $form .= '<input type="hidden" name="nr" value="widget-minimal"/>';

        $form .= '<input class="tnp-email" type="email" required name="ne" value="" placeholder="' . esc_attr($options_profile['email']) . '">';

        $form .= '<input class="tnp-submit" type="submit" value="' . esc_attr($instance['button']) . '">';

        $form .= '</form></div>';

        echo $form;
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        return $new_instance;
    }

    function form($instance) {
        if (!is_array($instance)) {
            $instance = array();
        }
        $instance = array_merge(array('title' => '', 'text' => '', 'button'=>''), $instance);
        $options_profile = get_option('newsletter_profile');
        if (!is_array($instance['nl'])) {
            $instance['nl'] = array();
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                Title:
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>">
            </label>

            <label for="<?php echo $this->get_field_id('button'); ?>">
                Button label:
                <input class="widefat" id="<?php echo $this->get_field_id('button'); ?>" name="<?php echo $this->get_field_name('button'); ?>" type="text" value="<?php echo esc_attr($instance['button']); ?>">
                Use a short one!
            </label>
        </p>

        <p>
            <?php _e('Automatically subscribe to', 'newsletter') ?>
            <br>
            <?php
            for ($i = 1; $i <= NEWSLETTER_LIST_MAX; $i++) {
                if (empty($options_profile['list_' . $i]) || empty($options_profile['list_' . $i . '_status'])) {
                    continue;
                }
                ?>
                <label for="nl<?php echo $i ?>">
                    <input type="checkbox" value="<?php echo $i ?>" name="<?php echo $this->get_field_name('nl[]') ?>" <?php echo array_search($i, $instance['nl']) !== false ? 'checked' : '' ?>> <?php echo esc_html($options_profile['list_' . $i]) ?>
                </label>
                <br>
        <?php } ?>
        </p>

        <?php
    }

}

add_action('widgets_init', create_function('', 'return register_widget("NewsletterWidgetMinimal");'));
?>
