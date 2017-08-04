<?php
if (!defined('ABSPATH')) exit;

require_once NEWSLETTER_INCLUDES_DIR . '/module.php';

class NewsletterWp extends NewsletterModule {

    static $instance;
    var $found = false;

    /**
     * @return NewsletterWp
     */
    static function instance() {
        if (self::$instance == null) {
            self::$instance = new NewsletterWp();
        }
        return self::$instance;
    }

    function __construct() {
        parent::__construct('wp', '1.0.1');
        add_action('init', array($this, 'hook_init'), 90);
    }

    function hook_init() {
        add_action('delete_user', array($this, 'hook_delete_user'));
        add_action('wp_login', array($this, 'hook_wp_login'));
        add_action('register_form', array($this, 'hook_register_form'));
        // The hook is always active so the module can be activated only on registration (otherwise we should check that
        // option on every page load. The registration code should be moved inside the module...
        add_action('user_register', array($this, 'hook_subscription_user_register'));
    }

    /**
     * See wp-includes/user.php function wp_signon().
     */
    function hook_wp_login($user_login) {
        //$this->logger->info(__METHOD__ . '> Start with ' . $user_login);
        $wp_user = get_user_by('login', $user_login);
        if (!empty($wp_user)) {
            //$this->logger->info($wp_user);
            // We have a user able to login, so his subscription can be confirmed if not confirmed
            $user = $this->get_user($wp_user->user_email);
            if (!empty($user)) {
                NewsletterSubscription::instance()->confirm($user->id, $this->options['welcome'] == 1);
            }
        }
        //$this->logger->info(__METHOD__ . '> End');
    }

    function hook_delete_user($id) {
        global $wpdb;
        if ($this->options['delete'] == 1) {
            $wpdb->delete(NEWSLETTER_USERS_TABLE, array('wp_user_id' => $id));
        }
    }

    function upgrade() {
        parent::upgrade();

        if ($this->old_version < '1.0.0') {
            // Locked content configuration migration

            $old_options = $old_options = NewsletterSubscription::instance()->get_options();

            if (isset($old_options['wp_welcome'])) {
                $this->options['welcome'] = $old_options['wp_welcome'];
            }
            if (isset($old_options['wp_delete'])) {
                $this->options['delete'] = $old_options['wp_delete'];
            }
            if (isset($old_options['subscribe_wp_users_label'])) {
                $this->options['subscribe_label'] = $old_options['subscribe_wp_users_label'];
            }
            if (isset($old_options['subscribe_wp_users'])) {
                $this->options['subscribe'] = $old_options['subscribe_wp_users'];
            }
            if (isset($old_options['wp_send_confirmation'])) {
                $this->options['confirmation'] = $old_options['wp_send_confirmation'];
            }
            $this->save_options($this->options);

            unset($old_options['wp_welcome']);
            unset($old_options['wp_delete']);
            unset($old_options['subscribe_wp_users_label']);
            unset($old_options['subscribe_wp_users']);
            unset($old_options['wp_send_confirmation']);
            NewsletterSubscription::instance()->save_options($old_options);
        }
    }

    function admin_menu() {
        $this->add_admin_page('index', 'WP Registration');
    }

    function hook_register_form() {
        if ($this->options['subscribe'] == 2 || $this->options['subscribe'] == 3) {
            echo '<p>';
            echo '<input type="checkbox" value="1" name="newsletter"';
            if ($this->options['subscribe'] == 3) {
                echo ' checked';
            }
            echo '>&nbsp;';
            echo $this->options['subscribe_label'];
            echo '</p>';
        }
    }

    function hook_subscription_user_register($wp_user_id) {
        global $wpdb;

        // If the integration is disabled...
        if ($this->options['subscribe'] == 0) {
            return;
        }

        // If not forced and the user didn't choose the newsletter...
        if ($this->options['subscribe'] != 1) {
            if (!isset($_REQUEST['newsletter'])) {
                return;
            }
        }

        $this->logger->info('Adding a registered WordPress user (' . $wp_user_id . ')');
        $wp_user = $wpdb->get_row($wpdb->prepare("select * from $wpdb->users where id=%d limit 1", $wp_user_id));
        if (empty($wp_user)) {
            $this->logger->error('User not found?!');
            return;
        }

        // Yes, some registration procedures allow empty email
        if (!$this->is_email($wp_user->user_email)) {
            return;
        }

        $_REQUEST['ne'] = $wp_user->user_email;
        $_REQUEST['nr'] = 'registration';
        // Upon registration there is no last name and first name, sorry.
        // $status is determined by the opt in
        $user = NewsletterSubscription::instance()->subscribe(null, $this->options['confirmation'] == 1);

        // Now we associate it with wp
        $this->set_user_wp_user_id($user->id, $wp_user_id);
    }

}

NewsletterWp::instance();
