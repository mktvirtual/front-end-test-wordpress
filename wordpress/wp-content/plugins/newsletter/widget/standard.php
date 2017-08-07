<?php
if (!defined('ABSPATH')) exit;

/**
 * Newsletter widget version 2.0: it'll replace the old version left for compatibility.
 */
class NewsletterWidget extends WP_Widget {

    function __construct() {
        parent::__construct(false, $name = 'Newsletter', array('description' => 'Newsletter widget to add subscription forms on sidebars'), array('width' => '350px'));
    }

    static function get_widget_form($instance) {

        $field_wrapper_tag = 'div';
        if (!isset($instance['nl']) || !is_array($instance['nl'])) $instance['nl'] = array();

        $options_profile = get_option('newsletter_profile');
        //$form = NewsletterSubscription::instance()->get_form_javascript();
        $form = '';
        
        $form .= '<div class="tnp tnp-widget">';
        $form .= NewsletterSubscription::instance()->get_subscription_form_html5('widget', null, array('list'=> implode(',', $instance['nl'])));
        $form .= "</div>\n";
        
        return $form;
    }

    static function get_old_widget_form($instance) {
        $options_profile = get_option('newsletter_profile');
        $form = NewsletterSubscription::instance()->get_form_javascript();
        
        $form .= '<div class="tnp tnp-widget">';
        $form .= '<form action="' . home_url('/') . '?na=s" onsubmit="return newsletter_check(this)" method="post">';
        // Referrer
        $form .= '<input type="hidden" name="nr" value="widget"/>';
        
        if (isset($instance['nl']) && is_array($instance['nl'])) {
            foreach ($instance['nl'] as $a) {
                $form .= "<input type='hidden' name='nl[]' value='" . ((int) trim($a)) . "'>\n";
            }
        }

        if ($options_profile['name_status'] == 2) {
            $form .= '<p><input class="tnp-firstname" type="text" name="nn" value="' . esc_attr($options_profile['name']) . '" onclick="if (this.defaultValue==this.value) this.value=\'\'" onblur="if (this.value==\'\') this.value=this.defaultValue"/></p>';
        }

        if ($options_profile['surname_status'] == 2) {
            $form .= '<p><input class="tnp-lastname" type="text" name="ns" value="' . esc_attr($options_profile['surname']) . '" onclick="if (this.defaultValue==this.value) this.value=\'\'" onblur="if (this.value==\'\') this.value=this.defaultValue"/></p>';
        }

        $form .= '<p><input class="tnp-email" type="email" required name="ne" value="' . esc_attr($options_profile['email']) . '" onclick="if (this.defaultValue==this.value) this.value=\'\'" onblur="if (this.value==\'\') this.value=this.defaultValue"/></p>';

        if (isset($options_profile['sex_status']) && $options_profile['sex_status'] == 2) {
            $form .= '<p><select name="nx" class="tnp-gender">';
            $form .= '<option value="m">' . $options_profile['sex_male'] . '</option>';
            $form .= '<option value="f">' . $options_profile['sex_female'] . '</option>';
            $form .= '</select></p>';
        }

        // Extra profile fields
        for ($i = 1; $i <= NEWSLETTER_PROFILE_MAX; $i++) {
            if ($options_profile['profile_' . $i . '_status'] != 2)
                continue;
            if ($options_profile['profile_' . $i . '_type'] == 'text') {
                $form .= '<p><input class="tnp-profile tnp-profile-' . $i . '" type="text" name="np' . $i . '" value="' . $options_profile['profile_' . $i] . '" onclick="if (this.defaultValue==this.value) this.value=\'\'" onblur="if (this.value==\'\') this.value=this.defaultValue"/></p>';
            }
            if ($options_profile['profile_' . $i . '_type'] == 'select') {
                $form .= '<p>' . $options_profile['profile_' . $i] . '<br /><select class="tnp-profile tnp-profile-' . $i . '" name="np' . $i . '">';
                $opts = explode(',', $options_profile['profile_' . $i . '_options']);
                for ($t = 0; $t < count($opts); $t++) {
                    $form .= '<option>' . trim($opts[$t]) . '</option>';
                }
                $form .= '</select></p>';
            }
        }

        $lists = '';
        for ($i = 1; $i <= NEWSLETTER_LIST_MAX; $i++) {
            if ($options_profile['list_' . $i . '_status'] != 2)
                continue;
            $lists .= '<input type="checkbox" name="nl[]" value="' . $i . '"';
            if ($options_profile['list_' . $i . '_checked'] == 1)
                $lists .= ' checked';
            $lists .= '/>&nbsp;' . $options_profile['list_' . $i] . '<br />';
        }
        if (!empty($lists))
            $form .= '<p>' . $lists . '</p>';


        $extra = apply_filters('newsletter_subscription_extra', array());
        foreach ($extra as &$x) {
            $form .= "<p>";
            if (!empty($x['label']))
                $form .= $x['label'] . "<br/>";
            $form .= $x['field'] . "</p>";
        }

        if ($options_profile['privacy_status'] == 1) {
            if (!empty($options_profile['privacy_url'])) {
                $form .= '<p><input type="checkbox" name="ny"/>&nbsp;<a target="_blank" href="' . $options_profile['privacy_url'] . '">' . $options_profile['privacy'] . '</a></p>';
            } else
                $form .= '<p><input type="checkbox" name="ny"/>&nbsp;' . $options_profile['privacy'] . '</p>';
        }

        if (strpos($options_profile['subscribe'], 'http://') !== false) {
            $form .= '<p><input class="tnp-submit" type="image" src="' . $options_profile['subscribe'] . '"/></p>';
        } else {
            $form .= '<p><input class="tnp-submit" type="submit" value="' . $options_profile['subscribe'] . '"/></p>';
        }

        $form .= '</form>';
        $form .= '</div>';

        return $form;
    }

    function widget($args, $instance) {
        global $newsletter;
        extract($args);

        if (empty($instance))
            $instance = array();
        $instance = array_merge(array('text' => '', 'title' => ''), $instance);

        echo $before_widget;

        // Filters are used for WPML
        if (!empty($instance['title'])) {
            $title = apply_filters('widget_title', $instance['title'], $instance);
            echo $before_title . $title . $after_title;
        }

        $buffer = apply_filters('widget_text', $instance['text'], $instance);
        $options = get_option('newsletter');
        $options_profile = get_option('newsletter_profile');

        if (stripos($instance['text'], '<form') === false) {

            if (isset($instance['old_form'])) {
                $form = NewsletterWidget::get_old_widget_form($instance);
            } else {
                $form = NewsletterWidget::get_widget_form($instance);
            }

            // Canot user directly the replace, since the form is different on the widget...
            if (strpos($buffer, '{subscription_form}') !== false)
                $buffer = str_replace('{subscription_form}', $form, $buffer);
            else {
                if (strpos($buffer, '{subscription_form_') !== false) {
                    // TODO: Optimize with a method to replace only the custom forms
                    $buffer = $newsletter->replace($buffer);
                } else {
                    $buffer .= $form;
                }
            }
        } else {
            $buffer = str_ireplace('<form', '<form method="post" action="' . esc_attr(home_url('/') . '?na=s') . '" onsubmit="return newsletter_check(this)"', $buffer);
            $buffer = str_ireplace('</form>', '<input type="hidden" name="nr" value="widget"/></form>', $buffer);
        }

        // That replace all the remaining tags
        $buffer = $newsletter->replace($buffer);

        echo $buffer;
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
//        $instance = $old_instance;
//        $instance['title'] = strip_tags($new_instance['title']);
//        $instance['text'] = $new_instance['text'];
//        if (isset($new_instance['old_form']))
//            $instance['old_form'] = 1;
//        else
//            unset($instance['old_form']);
        return $new_instance;
    }

    function form($instance) {
        if (!is_array($instance)) {
            $instance = array();
        }
        $instance = array_merge(array('title' => '', 'text' => ''), $instance);
        $options_profile = get_option('newsletter_profile');
        if (!isset($instance['nl']) || !is_array($instance['nl'])) $instance['nl'] = array();
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                Title:
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
            </label>

            <label for="<?php echo $this->get_field_id('text'); ?>">
                Introduction:
                <textarea class="widefat" rows="10" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_html($instance['text']); ?></textarea>
            </label>
            
            <br><br>
            <?php _e('Automatically subscribe to', 'newsletter')?>
            <br>
            <?php
            for ($i = 1; $i <= NEWSLETTER_LIST_MAX; $i++) {
            if (empty($options_profile['list_' . $i])) continue;
            if (empty($options_profile['list_' . $i . '_status'])) continue;
            ?>
            <label for="nl<?php echo $i?>">
                <input type="checkbox" value="<?php echo $i?>" name="<?php echo $this->get_field_name('nl[]') ?>" <?php echo array_search($i, $instance['nl']) !== false?'checked':''?>> <?php echo esc_html($options_profile['list_' . $i]) ?>
            </label>
            <br>
            <?php } ?>
          
        
        <br>
            
            <label for="<?php echo $this->get_field_id('old_form'); ?>">
                <input type="checkbox" id="<?php echo $this->get_field_id('old_form'); ?>" name="<?php echo $this->get_field_name('old_form'); ?>" <?php echo isset($instance['old_form']) ? 'checked' : '' ?>>
                       Use the old form (will be removed in future versions)
            </label>
        </p>

        <p>
            Use the tag {subscription_form} to place the subscription form within your personal text.
        </p>
        <?php
    }

}

add_action('widgets_init', create_function('', 'return register_widget("NewsletterWidget");'));
?>
