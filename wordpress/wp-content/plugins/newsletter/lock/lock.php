<?php
if (!defined('ABSPATH')) exit;

require_once NEWSLETTER_INCLUDES_DIR . '/module.php';

class NewsletterLock extends NewsletterModule {

    static $instance;
    var $found = false;

    /**
     * @return NewsletterLock
     */
    static function instance() {
        if (self::$instance == null) {
            self::$instance = new NewsletterLock();
        }
        return self::$instance;
    }

    function __construct() {
        parent::__construct('lock', '1.0.3');
        add_action('init', array($this, 'hook_init'), 90);
    }

    function hook_init() {
        if (empty($this->options['enabled'])) {
            add_shortcode('newsletter_lock', array($this, 'shortcode_newsletter_lock_dummy'));
            return;
        }

        add_shortcode('newsletter_lock', array($this, 'shortcode_newsletter_lock'));
        add_filter('the_content', array($this, 'hook_the_content'));
        add_action('wp_loaded', array($this, 'hook_wp_loaded'));
    }

    function hook_wp_loaded() {

        switch (Newsletter::instance()->action) {

            case 'ul':
                $user = $this->check_user();

                if ($user == null || $user->status != 'C') {
                    echo 'Subscriber not found, sorry.';
                    die();
                }

                setcookie('newsletter', $user->id . '-' . $user->token, time() + 60 * 60 * 24 * 365, '/');
                if (empty($this->options['url'])) {
                    header('Location: ' . home_url());
                } else {
                    header('Location: ' . $this->options['url']);
                }

                die();
        }
    }

    function upgrade() {
        parent::upgrade();

        if ($this->old_version < '1.0.2') {
            // Locked content configuration migration

            $old_options = Newsletter::instance()->get_options();
            if (isset($old_options['lock_message']) || isset($old_options['lock_ids']) || isset($old_options['lock_url'])) {
                $this->options['ids'] = $old_options['lock_ids'];
                $this->options['url'] = $old_options['lock_url'];
                $this->options['message'] = $old_options['lock_message'];
                $this->options['enabled'] = 1;
                $this->save_options($this->options);

                unset($old_options['lock_ids']);
                unset($old_options['lock_url']);
                unset($old_options['lock_message']);
                Newsletter::instance()->save_options($old_options);
            }

            $old_options = NewsletterSubscription::instance()->get_options('lock');
            if (!empty($old_options)) {
                $this->options['ids'] = $old_options['ids'];
                $this->options['url'] = $old_options['url'];
                $this->options['message'] = $old_options['message'];
                $this->options['enabled'] = 1;
                $this->save_options($this->options);
                NewsletterSubscription::instance()->delete_options('lock');
            }
        }
    }

    function admin_menu() {
        $this->add_admin_page('index', 'Locked content');
    }

    function hook_the_content($content) {
        global $post, $cache_stop;

        if (empty($this->options['ids'])) {
            return $content;
        }
        
        if (current_user_can('manage_options')) {
            return $content;
        }
        
        $ids = explode(',', str_replace(' ', '', $this->options['ids']));

        if (has_tag($ids) || in_category($ids) || in_array($post->post_name, $ids)) {
            $cache_stop = true;
            $user = $this->check_user();
            if ($user == null || $user->status != 'C') {
                $buffer = Newsletter::instance()->replace($this->options['message']);
                return '<div class="newsletter-lock">' . do_shortcode($buffer) . '</div>';
            }
        }

        return $content;
    }

    function shortcode_newsletter_lock_dummy($attrs, $content = null) {
        return $content;
    }
    
    function shortcode_newsletter_lock($attrs, $content = null) {
        global $hyper_cache_stop, $cache_stop;

        $hyper_cache_stop = true;
        $cache_stop = true;

        $this->found = true;
        
        if (current_user_can('publish_posts')) {
            return do_shortcode($content);
        }

        $user = $this->check_user();
        if ($user != null && $user->status == 'C') {
            return do_shortcode($content);
        }

        $buffer = $this->options['message'];

        $buffer = str_ireplace('<form', '<form method="post" action="' . plugins_url('newsletter/do/subscribe.php') . '"', $buffer);
        $buffer = Newsletter::instance()->replace($buffer, null, null, 'lock');

        $buffer = do_shortcode($buffer);

        return '<div class="newsletter-lock">' . $buffer . '</div>';
    }

}

NewsletterLock::instance();
