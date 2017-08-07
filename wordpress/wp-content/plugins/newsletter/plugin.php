<?php

/*
  Plugin Name: Newsletter
  Plugin URI: https://www.thenewsletterplugin.com/plugins/newsletter
  Description: Newsletter is a cool plugin to create your own subscriber list, to send newsletters, to build your business. <strong>Before update give a look to <a href="https://www.thenewsletterplugin.com/category/release">this page</a> to know what's changed.</strong>
  Version: 5.0.2
  Author: Stefano Lissa & The Newsletter Team
  Author URI: https://www.thenewsletterplugin.com
  Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
  Text Domain: newsletter

  Copyright 2009-2017 The Newsletter Team (email: info@thenewsletterplugin.com, web: https://www.thenewsletterplugin.com)
 */

// Used as dummy parameter on css and js links
define('NEWSLETTER_VERSION', '5.0.2');

global $wpdb, $newsletter;

//@include_once WP_CONTENT_DIR . '/extensions/newsletter/config.php';

if (!defined('NEWSLETTER_EMAILS_TABLE'))
    define('NEWSLETTER_EMAILS_TABLE', $wpdb->prefix . 'newsletter_emails');

if (!defined('NEWSLETTER_USERS_TABLE'))
    define('NEWSLETTER_USERS_TABLE', $wpdb->prefix . 'newsletter');

if (!defined('NEWSLETTER_STATS_TABLE'))
    define('NEWSLETTER_STATS_TABLE', $wpdb->prefix . 'newsletter_stats');

if (!defined('NEWSLETTER_SENT_TABLE'))
    define('NEWSLETTER_SENT_TABLE', $wpdb->prefix . 'newsletter_sent');

// Do not use basename(dirname()) since on activation the plugin is sandboxed inside a function
define('NEWSLETTER_SLUG', 'newsletter');

define('NEWSLETTER_DIR', WP_PLUGIN_DIR . '/' . NEWSLETTER_SLUG);
define('NEWSLETTER_INCLUDES_DIR', WP_PLUGIN_DIR . '/' . NEWSLETTER_SLUG . '/includes');

// Almost obsolete but the first two must be kept for compatibility with modules
define('NEWSLETTER_URL', WP_PLUGIN_URL . '/newsletter');
define('NEWSLETTER_EMAIL_URL', NEWSLETTER_URL . '/do/view.php');

define('NEWSLETTER_SUBSCRIPTION_POPUP_URL', NEWSLETTER_URL . '/do/subscription-popup.php');
define('NEWSLETTER_SUBSCRIBE_URL', NEWSLETTER_URL . '/do/subscribe.php');
define('NEWSLETTER_SUBSCRIBE_POPUP_URL', NEWSLETTER_URL . '/do/subscribe-popup.php');
define('NEWSLETTER_PROFILE_URL', NEWSLETTER_URL . '/do/profile.php');
define('NEWSLETTER_SAVE_URL', NEWSLETTER_URL . '/do/save.php');
define('NEWSLETTER_CONFIRM_URL', NEWSLETTER_URL . '/do/confirm.php');
define('NEWSLETTER_CHANGE_URL', NEWSLETTER_URL . '/do/change.php');
define('NEWSLETTER_UNLOCK_URL', NEWSLETTER_URL . '/do/unlock.php');
define('NEWSLETTER_UNSUBSCRIBE_URL', NEWSLETTER_URL . '/do/unsubscribe.php');
define('NEWSLETTER_UNSUBSCRIPTION_URL', NEWSLETTER_URL . '/do/unsubscription.php');

if (!defined('NEWSLETTER_LIST_MAX'))
    define('NEWSLETTER_LIST_MAX', 20);

if (!defined('NEWSLETTER_PROFILE_MAX'))
    define('NEWSLETTER_PROFILE_MAX', 20);

if (!defined('NEWSLETTER_FORMS_MAX'))
    define('NEWSLETTER_FORMS_MAX', 10);

if (!defined('NEWSLETTER_CRON_INTERVAL'))
    define('NEWSLETTER_CRON_INTERVAL', 300);

if (!defined('NEWSLETTER_HEADER'))
    define('NEWSLETTER_HEADER', true);

if (!defined('NEWSLETTER_DEBUG'))
    define('NEWSLETTER_DEBUG', false);

// Force the whole system log level to this value
//define('NEWSLETTER_LOG_LEVEL', 4);

require_once NEWSLETTER_INCLUDES_DIR . '/logger.php';
require_once NEWSLETTER_INCLUDES_DIR . '/store.php';
require_once NEWSLETTER_INCLUDES_DIR . '/module.php';
require_once NEWSLETTER_INCLUDES_DIR . '/themes.php';

class Newsletter extends NewsletterModule {

    // Limits to respect to avoid memory, time or provider limits
    var $time_start;
    var $time_limit;
    var $email_limit = 10; // Per run, every 5 minutes
    var $limits_set = false;
    var $max_emails = 20;

    /**
     * @var PHPMailer
     */
    var $mailer;
    // Message shown when the interaction is inside a WordPress page
    var $message;
    var $user;
    var $error;
    var $theme;
    // Theme autocomposer variables
    var $theme_max_posts;
    var $theme_excluded_categories; // comma separated ids (eventually negative to exclude)
    var $theme_posts; // WP_Query object
    // Secret key to create a unique log file name (and may be other)
    var $lock_found = false;
    var $action = '';
    static $instance;

    const MAX_CRON_SAMPLES = 100;

    /**
     * @return Newsletter
     */
    static function instance() {
        if (self::$instance == null) {
            self::$instance = new Newsletter();
        }
        return self::$instance;
    }

    function __construct() {
        // Grab it before a plugin decides to remove it.
        if (isset($_GET['na'])) {
            $this->action = $_GET['na'];
        }
        if (isset($_POST['na'])) {
            $this->action = $_POST['na'];
        }

        if (!empty($this->action)) {
            // For old versions of wp super cache
            $_GET['preview'] = 'true';
        }

        $this->time_start = time();

        // Here because the upgrade is called by the parent constructor and uses the scheduler
        add_filter('cron_schedules', array($this, 'hook_cron_schedules'), 1000);

        parent::__construct('main', '1.3.0');

        $max = $this->options['scheduler_max'];
        if (!is_numeric($max)) {
            $max = 100;
        }
        $this->max_emails = max(floor($max / 12), 1);

        add_action('init', array($this, 'hook_init'));
        add_action('newsletter', array($this, 'hook_newsletter'), 1);
        add_action('newsletter_extension_versions', array($this, 'hook_newsletter_extension_versions'), 1);
        add_action('plugins_loaded', array($this, 'hook_plugins_loaded'));

        // This specific event is created by "Feed by mail" panel on configuration
        add_action('shutdown', array($this, 'hook_shutdown'));

        if (defined('DOING_CRON') && DOING_CRON) {
            $calls = get_option('newsletter_diagnostic_cron_calls', array());
            $calls[] = time();
            if (count($calls) > self::MAX_CRON_SAMPLES) {
                array_shift($calls);
            }
            update_option('newsletter_diagnostic_cron_calls', $calls, false);

            if (count($calls) > 50) {
                $mean = 0;
                $max = 0;
                $min = 0;
                for ($i = 1; $i < count($calls); $i++) {
                    $diff = $calls[$i] - $calls[$i - 1];
                    $mean += $diff;
                    if ($min == 0 || $min > $diff) {
                        $min = $diff;
                    }
                    if ($max < $diff) {
                        $max = $diff;
                    }
                }
                $mean = $mean / count($calls) - 1;
                update_option('newsletter_diagnostic_cron_data', array('mean' => $mean, 'max' => $max, 'min' => $min), false);
            }
            return;
        }

        // TODO: Meditation on how to use those ones...
        register_activation_hook(__FILE__, array($this, 'hook_activate'));
        //register_deactivation_hook(__FILE__, array(&$this, 'hook_deactivate'));

        add_action('admin_init', array($this, 'hook_admin_init'));

        add_action('wp_head', array($this, 'hook_wp_head'));

        add_filter('the_content', array($this, 'hook_the_content'), 99);

        if (is_admin()) {
            if ($this->is_admin_page()) {
                add_action('in_admin_header', array($this, 'hook_in_admin_header'), 999);
            }
            add_action('admin_head', array($this, 'hook_admin_head'));

            // Protection against strange schedule removal on some installations
            if (!wp_next_scheduled('newsletter') && (!defined('WP_INSTALLING') || !WP_INSTALLING)) {
                wp_schedule_event(time() + 30, 'newsletter', 'newsletter');
            }



            add_action('admin_menu', array($this, 'add_extensions_menu'), 90);
        }
    }

    function hook_in_admin_header() {
        //remove_all_filters('admin_notices');
    }

    function hook_activate() {
        // Ok, why? When the plugin is not active WordPress may remove the scheduled "newsletter" action because
        // the every-five-minutes schedule named "newsletter" is not present.
        // Since the activation does not forces an upgrade, that schedule must be reactivated here. It is activated on
        // the upgrade method as well for the user which upgrade the plugin without deactivte it (many).
        if (!wp_next_scheduled('newsletter')) {
            wp_schedule_event(time() + 30, 'newsletter', 'newsletter');
        }

        $install_time = get_option('newsletter_install_time');
        if (!$install_time) {
            update_option('newsletter_install_time', time(), false);
        }
    }

    function first_install() {
        parent::first_install();
        $dismissed = get_option('newsletter_dismissed', array());

        $dismissed['wpmail'] = 1;
        update_option('newsletter_dismissed', $dismissed);
    }

    function upgrade() {
        global $wpdb, $charset_collate;

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        parent::upgrade();


        $this->upgrade_query("create table if not exists " . NEWSLETTER_EMAILS_TABLE . " (id int auto_increment, primary key (id)) $charset_collate");
        $this->upgrade_query("alter table " . NEWSLETTER_EMAILS_TABLE . " add column message longtext");
        $this->upgrade_query("alter table " . NEWSLETTER_EMAILS_TABLE . " add column message_text longtext");
        $this->upgrade_query("alter table " . NEWSLETTER_EMAILS_TABLE . " add column subject varchar(255) not null default ''");
        $this->upgrade_query("alter table " . NEWSLETTER_EMAILS_TABLE . " add column type varchar(50) not null default ''");
        $this->upgrade_query("alter table " . NEWSLETTER_EMAILS_TABLE . " add column created timestamp not null default current_timestamp");

        $this->upgrade_query("alter table " . NEWSLETTER_EMAILS_TABLE . " add column status enum('new','sending','sent','paused') not null default 'new'");

        $this->upgrade_query("alter table " . NEWSLETTER_EMAILS_TABLE . " add column total int not null default 0");
        $this->upgrade_query("alter table " . NEWSLETTER_EMAILS_TABLE . " add column last_id int not null default 0");
        $this->upgrade_query("alter table " . NEWSLETTER_EMAILS_TABLE . " add column sent int not null default 0");
        $this->upgrade_query("alter table " . NEWSLETTER_EMAILS_TABLE . " add column send_on int not null default 0");
        $this->upgrade_query("alter table " . NEWSLETTER_EMAILS_TABLE . " add column track tinyint not null default 0");
        $this->upgrade_query("alter table " . NEWSLETTER_EMAILS_TABLE . " add column editor tinyint not null default 0");
        $this->upgrade_query("alter table " . NEWSLETTER_EMAILS_TABLE . " add column sex char(1) not null default ''");
        $this->upgrade_query("alter table " . NEWSLETTER_EMAILS_TABLE . " change column sex sex char(1) not null default ''");

        $this->upgrade_query("alter table " . NEWSLETTER_EMAILS_TABLE . " add column query text");
        $this->upgrade_query("alter table " . NEWSLETTER_EMAILS_TABLE . " add column preferences text");
        $this->upgrade_query("alter table " . NEWSLETTER_EMAILS_TABLE . " add column options longtext");

        // Cleans up old installations
        $this->upgrade_query("alter table " . NEWSLETTER_EMAILS_TABLE . " drop column name");
        $this->upgrade_query("drop table if exists " . $wpdb->prefix . "newsletter_work");
        $this->upgrade_query("alter table " . NEWSLETTER_EMAILS_TABLE . " convert to character set utf8");

        if ('utf8mb4' === $wpdb->charset) {
            $this->upgrade_query("alter table " . NEWSLETTER_EMAILS_TABLE . " convert to character set utf8mb4");
        }

        // WP does not manage composite primary key when it tries to upgrade a table...
        $suppress_errors = $wpdb->suppress_errors(true);

        dbDelta("CREATE TABLE " . $wpdb->prefix . "newsletter_sent (
            email_id int(10) unsigned NOT NULL DEFAULT '0',
            user_id int(10) unsigned NOT NULL DEFAULT '0',
            status tinyint(1) unsigned NOT NULL DEFAULT '0',
            open tinyint(1) unsigned NOT NULL DEFAULT '0',
            time int(10) unsigned NOT NULL DEFAULT '0',
            error varchar(100) NOT NULL DEFAULT '',
	    ip varchar(100) NOT NULL DEFAULT '',
            PRIMARY KEY (email_id,user_id),
            KEY user_id (user_id),
            KEY email_id (email_id)
          ) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
        $wpdb->suppress_errors($suppress_errors);

//        if ('utf8mb4' === $wpdb->charset) {
//            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
//            if (function_exists('maybe_convert_table_to_utf8mb4')) {
//                maybe_convert_table_to_utf8mb4(NEWSLETTER_EMAILS_TABLE);
//            }
//        }
        // Some setting check to avoid the common support request for mis-configurations
        $options = $this->get_options();

        if (empty($options['sender_email'])) {
            // That code was taken from WordPress
            $sitename = strtolower($_SERVER['SERVER_NAME']);
            if (substr($sitename, 0, 4) == 'www.')
                $sitename = substr($sitename, 4);
            // WordPress build an address in the same way using wordpress@...
            $options['sender_email'] = 'newsletter@' . $sitename;
            $this->save_options($options);
        }

        if (empty($options['scheduler_max']) || !is_numeric($options['scheduler_max'])) {
            $options['scheduler_max'] = 100;
            $this->save_options($options);
        }

        if (empty($options['api_key'])) {
            $options['api_key'] = self::get_token();
            $this->save_options($options);
        }

        if (empty($options['scheduler_max'])) {
            $options['scheduler_max'] = 100;
            $this->save_options($options);
        }

        wp_clear_scheduled_hook('newsletter');
        wp_schedule_event(time() + 30, 'newsletter', 'newsletter');

        wp_clear_scheduled_hook('newsletter_extension_versions');
        wp_schedule_event(time() + 30, 'daily', 'newsletter_extension_versions');

        // If the original options has already saved once
        if (isset($options['smtp_host'])) {
            $smtp_options['enabled'] = $options['smtp_enabled'];
            $smtp_options['test_email'] = $options['smtp_test_email'];
            $smtp_options['host'] = $options['smtp_host'];
            $smtp_options['pass'] = $options['smtp_pass'];
            $smtp_options['port'] = $options['smtp_port'];
            $smtp_options['user'] = $options['smtp_user'];
            $smtp_options['secure'] = $options['smtp_secure'];
            $this->save_options($smtp_options, 'smtp');
            unset($options['smtp_enabled']);
            unset($options['smtp_test_email']);
            unset($options['smtp_pass']);
            unset($options['smtp_port']);
            unset($options['smtp_user']);
            unset($options['smtp_secure']);
            unset($options['smtp_host']);
            $this->save_options($options);
        }
        $this->init_options('smtp');

        return true;
    }

    function admin_menu() {
        // This adds the main menu page
        add_menu_page('Newsletter', 'Newsletter', ($this->options['editor'] == 1) ? 'manage_categories' : 'manage_options', 'newsletter_main_index', '', plugins_url('newsletter') . '/images/menu-icon.png', '30.333');

        $this->add_menu_page('index', 'Dashboard');
        $this->add_menu_page('main', 'Settings and More');

        $this->add_admin_page('smtp', 'SMTP');
        $this->add_admin_page('status', 'Status');
        $this->add_admin_page('info', 'Company info');
        $this->add_admin_page('diagnostic', 'Diagnostic');
        $this->add_admin_page('startup', 'Quick Startup');
    }

    function add_extensions_menu() {
        $this->add_menu_page('extensions', '<span style="color:#27AE60; font-weight: bold;">Extensions</span>');
    }

    /**
     * Returns a set of warnings about this installtion the suser should be aware of. Return an empty string
     * if there are no warnings.
     */
    function warnings() {
        $warnings = '';
        $x = wp_next_scheduled('newsletter');
        if ($x === false) {
            $warnings .= 'The delivery engine is off (it should never be off). Deactivate and reactivate the plugin. Thank you.<br>';
        } else if (time() - $x > 900) {
            $warnings .= 'The cron system seems not running correctly. See <a href="https://www.thenewsletterplugin.com/how-to-make-the-wordpress-cron-work" target="_blank">this page</a> for more information.<br>';
        } else {
            $cron_data = get_option('newsletter_diagnostic_cron_data');
            if ($cron_data && $cron_data['mean'] > 400) {
                $warnings .= 'The WordPress internal schedule is not triggered enough often. See <a href="https://www.thenewsletterplugin.com/how-to-make-the-wordpress-cron-work" target="_blank">this page</a> for more information.<br>';
            }
        }

        if (!empty($warnings)) {
            echo '<div class="tnp-error">';
            echo $warnings;
            echo '</div>';
        }
    }

    function hook_init() {
        global $cache_stop, $hyper_cache_stop, $wpdb;

        if (isset($this->options['debug']) && $this->options['debug'] == 1) {
            ini_set('log_errors', 1);
            ini_set('error_log', WP_CONTENT_DIR . '/logs/newsletter/php-' . date('Y-m') . '-' . get_option('newsletter_logger_secret') . '.txt');
        }

        if (is_admin()) {
            if ($this->is_admin_page()) {
                wp_enqueue_script('jquery-ui-tabs');
                wp_enqueue_media();
                wp_enqueue_style('tnp-admin', plugins_url('newsletter') . '/admin.css', array(), time());
                wp_enqueue_script('tnp-admin', plugins_url('newsletter') . '/admin.js', array(), time());

                wp_enqueue_style('tnp-select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css');
                wp_enqueue_script('tnp-select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js');
                wp_enqueue_script('tnp-jquery-vmap', 'https://cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/jquery.vmap.min.js');
                wp_enqueue_script('tnp-jquery-vmap-world', 'https://cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/maps/jquery.vmap.world.js', array('tnp-jquery-vmap'));
                wp_enqueue_style('tnp-jquery-vmap', 'https://cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/jqvmap.min.css');

                wp_register_script('tnp-chart', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js');

                $dismissed = get_option('newsletter_dismissed', array());

                if (isset($_GET['dismiss'])) {
                    $dismissed[$_GET['dismiss']] = 1;
                    update_option('newsletter_dismissed', $dismissed);
                    wp_redirect($_SERVER['HTTP_REFERER']);
                    exit();
                }
            }
        }

        $action = isset($_REQUEST['na']) ? $_REQUEST['na'] : '';
        if (empty($action) || is_admin()) {
            return;
        }

        // TODO: Remove!
        $cache_stop = true;
        $hyper_cache_stop = true;

        if ($action == 'of') {
            echo $this->subscription_form('os');
            die();
        }

        if ($action == 'fu') {
            $user = $this->check_user();
            if ($user == null) {
                die('No user');
            }
            $wpdb->query("update " . NEWSLETTER_USERS_TABLE . " set followup=2 where id=" . $user->id);
            $options_followup = get_option('newsletter_followup');
            $this->message = $options_followup['unsubscribed_text'];
            return;
        }

        if ($action == 'test') {
            echo 'ok';
            die();
        }
    }

    function is_admin_page() {
        if (!isset($_GET['page'])) {
            return false;
        }
        $page = $_GET['page'];
        return strpos($page, 'newsletter_') === 0; // || strpos($page, 'newsletter-') === 0;
    }

    function hook_admin_init() {
        
    }

    function hook_admin_head() {
        // Small global rule for sidebar menu entries
        echo '<style>';
        echo '.tnp-side-menu { color: #E67E22!important; }';
        echo '</style>';
    }

    function hook_wp_head() {
        if (!empty($this->options['css'])) {
            echo "<style type='text/css'>\n";
            echo $this->options['css'];
            echo "</style>";
        }
    }

    function relink($text, $email_id, $user_id, $email_token = '') {
        return NewsletterStatistics::instance()->relink($text, $email_id, $user_id, $email_token);
    }

    /**
     * Runs every 5 minutes and look for emails that need to be processed.
     */
    function hook_newsletter() {
        global $wpdb;

        $this->logger->debug('hook_newsletter> Start');

        // Do not accept job activation before at least 4 minutes are elapsed from the last run.
        if (!$this->check_transient('engine', NEWSLETTER_CRON_INTERVAL)) {
            return;
        }

        // Retrieve all emails in "sending" status
        $emails = $wpdb->get_results("select * from " . NEWSLETTER_EMAILS_TABLE . " where status='sending' and send_on<" . time() . " order by id asc");
        $this->logger->debug('hook_newsletter> Emails found in sending status: ' . count($emails));
        foreach ($emails as $email) {
            $this->logger->debug('hook_newsletter> Sending email ' . $email->id);
            $this->send($email);
        }
        // Remove the semaphore so the delivery engine can be activated again
        $this->delete_transient('engine');

        $this->logger->debug('hook_newsletter> End');
    }

    /**
     * Sends an email to targeted users or to given users. If a list of users is given (usually a list of test users)
     * the query inside the email to retrieve users is not used.
     *
     * @global wpdb $wpdb
     * @global type $newsletter_feed
     * @param type $email
     * @param array $users
     * @return boolean True if the proccess completed, false if limits was reached. On false the caller should no continue to call it with other emails.
     */
    function send($email, $users = null) {
        global $wpdb;

        ignore_user_abort(true);

        if (is_array($email)) {
            $email = (object) $email;
        }

        $this->logger->debug('send> Email ID: ' . $email->id);

        // This stops the update of last_id and sent fields since it's not a scheduled delivery but a test or something else (like an autoresponder)
        $test = $users != null;

        if ($users == null) {

            $skip_this_run = apply_filters('newsletter_send_skip', false, $email);
            if ($skip_this_run)
                return false;

            if (empty($email->query)) {
                $email->query = "select * from " . NEWSLETTER_USERS_TABLE . " where status='C'";
            }

            $email->options = maybe_unserialize($email->options);
            $max_emails = apply_filters('newsletter_send_max_emails', $this->max_emails, $email);

            $this->logger->debug('send> Max emails per run: ' . $max_emails);

            if (empty($max_emails)) {
                $this->logger->error('send> Max emails empty after the filter');
                $max_emails = $this->max_emails;
            }

            //$query = apply_filters('newsletter_send_query', $email->query, $email);
            $query = $email->query;
            $query .= " and id>" . $email->last_id . " order by id limit " . $max_emails;

            $this->logger->debug('send> Query: ' . $query);

            $users = $wpdb->get_results($query);

            $this->logger->debug('send> Loaded users: ' . count($users));

            // If there was a database error, do nothing
            if ($wpdb->last_error) {
                $this->logger->fatal($wpdb->last_error);
                $this->logger->fatal($wpdb->last_query);
                return;
            }

            if (empty($users)) {
                $this->logger->info('send> No more users, set as sent');
                $wpdb->query("update " . NEWSLETTER_EMAILS_TABLE . " set status='sent', total=sent where id=" . $email->id . " limit 1");
                return true;
            }

            //$users = apply_filters('newsletter_send_users', $users, $email);
        }

        $start_time = microtime(true);
        $count = 0;
        $result = true;

        foreach ($users as $user) {
            $this->logger->debug('send> Processing user ID: ' . $user->id);

            // Before try to send, check the limits.
            if (!$test && $this->limits_exceeded()) {
                $result = false;
                break;
            }

            $headers = array('List-Unsubscribe' => '<' . home_url('/') . '?na=u&nk=' . $user->id . '-' . $user->token . '>');
            $headers['Precedence'] = 'bulk';
            $headers['X-Newsletter-Email-Id'] = $email->id;


            if (!$test) {
                $wpdb->query("update " . NEWSLETTER_EMAILS_TABLE . " set sent=sent+1, last_id=" . $user->id . " where id=" . $email->id . " limit 1");
            }

            $m = $this->replace($email->message, $user, $email->id);
            $mt = $this->replace($email->message_text, $user, $email->id);

            $m = apply_filters('newsletter_message_html', $m, $email, $user);

            if ($email->track == 1) {
                $m = $this->relink($m, $email->id, $user->id, $email->token);
            }

            $s = $this->replace($email->subject, $user);
            $s = apply_filters('newsletter_message_subject', $s, $email, $user);

            if (!empty($user->wp_user_id)) {
                $this->logger->debug('send> Has wp_user_id: ' . $user->wp_user_id);
                // TODO: possibly name extraction
                $wp_user_email = $wpdb->get_var($wpdb->prepare("select user_email from $wpdb->users where id=%d limit 1", $user->wp_user_id));
                if (!empty($wp_user_email)) {
                    $user->email = $wp_user_email;
                    $this->logger->debug('send> Email replaced with: ' . $user->email);
                } else {
                    $this->logger->debug('send> This WP user has not an email');
                }
            }

            $r = $this->mail($user->email, $s, array('html' => $m, 'text' => $mt), $headers);

            $status = $r ? 0 : 1;

            $wpdb->query($wpdb->prepare("insert into " . $wpdb->prefix . 'newsletter_sent (user_id, email_id, time, status, error) values (%d, %d, %d, %d, %s) on duplicate key update time=%d, status=%d, error=%s', $user->id, $email->id, time(), $status, $this->mail_last_error, time(), $status, $this->mail_last_error));

            $this->email_limit--;
            $count++;
        }
        $end_time = microtime(true);

        if ($count > 0) {
            $send_calls = get_option('newsletter_diagnostic_send_calls', array());
            $send_calls[] = array($start_time, $end_time, $count, $result);

            if (count($send_calls) > self::MAX_CRON_SAMPLES)
                array_shift($send_calls);

            update_option('newsletter_diagnostic_send_calls', $send_calls, false);
        }
        return $result;
    }

    /**
     * Probably obsolete.
     */
    function execute($text, $user = null) {
        global $wpdb;
        ob_start();
        $r = eval('?' . '>' . $text);
        if ($r === false) {
            $this->error = 'Error while executing a PHP expression in a message body. See log file.';
            $this->log('Error on execution of ' . $text, 1);
            ob_end_clean();
            return false;
        }

        return ob_get_clean();
    }

    /**
     * This function checks is, during processing, we are getting to near to system limits and should stop any further
     * work (when returns true).
     */
    function limits_exceeded() {
        global $wpdb;

        if (!$this->limits_set) {
            $this->logger->debug('limits_exceeded> Setting the limits for the first time');

            $max_time = NEWSLETTER_CRON_INTERVAL;

            // Actually it should be set on startup, anyway the scripts use as time base the startup time
            if (!empty($this->options['php_time_limit'])) {
                @set_time_limit((int) $this->options['php_time_limit']);
            } else if (defined('NEWSLETTER_MAX_EXECUTION_TIME')) {
                @set_time_limit(NEWSLETTER_MAX_EXECUTION_TIME);
            } else {
                @set_time_limit(NEWSLETTER_CRON_INTERVAL);
            }

            $max_time = (int) (@ini_get('max_execution_time') * 0.95);
            if ($max_time == 0 || $max_time > NEWSLETTER_CRON_INTERVAL)
                $max_time = (int) (NEWSLETTER_CRON_INTERVAL * 0.95);

            $this->time_limit = $this->time_start + $max_time;

            $this->logger->info('limits_exceeded> Max time set to ' . $max_time);

            $max = $this->options['scheduler_max'];
            if (!is_numeric($max))
                $max = 100;
            $this->email_limit = max(floor($max / 12), 1);
            $this->logger->debug('limits_exceeded> Max number of emails can send: ' . $this->email_limit);

            $wpdb->query("set session wait_timeout=300");
            // From default-constants.php
            if (function_exists('memory_get_usage') && ( (int) @ini_get('memory_limit') < 128 ))
                @ini_set('memory_limit', '256M');

            $this->limits_set = true;
        }

        // The time limit is set on constructor, since it has to be set as early as possible
        if (time() > $this->time_limit) {
            $this->logger->info('limits_exceeded> Max execution time limit reached');
            return true;
        }

        if ($this->email_limit <= 0) {
            $this->logger->info('limits_exceeded> Max emails limit reached');
            return true;
        }
        return false;
    }

    /**
     *
     * @param string $to
     * @param string $subject
     * @param string|array $message
     * @param type $headers
     * @return boolean
     */
    var $mail_method = null;

    function register_mail_method($callable) {
        $this->mail_method = $callable;
    }

    var $mail_last_error = '';

    function mail($to, $subject, $message, $headers = null) {
        $this->mail_last_error = '';
        //$this->logger->debug('mail> To: ' . $to);
        //$this->logger->debug('mail> Subject: ' . $subject);
        if (empty($subject)) {
            $this->logger->error('mail> Subject empty, skipped');
            return true;
        }
        
        if (!$headers) {
            $headers = array();
        }
        
        $headers['X-Auto-Response-Suppress'] = 'OOF, AutoReply';

        // Message carrige returns and line feeds clean up
        if (!is_array($message)) {
            $message = str_replace("\r\n", "\n", $message);
            $message = str_replace("\r", "\n", $message);
            $message = str_replace("\n", "\r\n", $message);
        } else {
            if (!empty($message['text'])) {
                $message['text'] = str_replace("\r\n", "\n", $message['text']);
                $message['text'] = str_replace("\r", "\n", $message['text']);
                $message['text'] = str_replace("\n", "\r\n", $message['text']);
            }

            if (!empty($message['html'])) {
                $message['html'] = str_replace("\r\n", "\n", $message['html']);
                $message['html'] = str_replace("\r", "\n", $message['html']);
                $message['html'] = str_replace("\n", "\r\n", $message['html']);
            }
        }

        if ($this->mail_method != null) {
            //$this->logger->debug('mail> alternative mail method found');
            return call_user_func($this->mail_method, $to, $subject, $message, $headers);
        }

        if ($this->mailer == null) {
            $this->mailer_init();
        }

        if ($this->mailer == null) {
            // If still null, we need to use wp_mail()...

            $wp_mail_headers = array();

            $wp_mail_headers[] = 'From: ' . $this->options['sender_name'] . ' <' . $this->options['sender_email'] . '>';

            if (!empty($this->options['return_path'])) {
                $wp_mail_headers[] = 'Return-Path: ' . $this->options['return_path'];
            }
            if (!empty($this->options['reply_to'])) {
                $wp_mail_headers[] = 'Reply-To: ' . $this->options['reply_to'];
            }

            if (!is_array($message)) {
                $wp_mail_headers[] = 'Content-Type: text/html;charset=UTF-8';
                $body = $message;
            } else {
                // Only html is present?
                if (!empty($message['html'])) {
                    $wp_mail_headers[] = 'Content-Type: text/html;charset=UTF-8';

                    $body = $message['html'];
                } else if (!empty($message['text'])) {
                    $wp_mail_headers[] = 'Content-Type: text/plain;charset=UTF-8';
                    //$this->mailer->IsHTML(false);
                    $body = $message['text'];
                }
            }

            if (is_array($headers)) {
                foreach ($headers as $key => $value) {
                    $wp_mail_headers[] = $key . ': ' . $value;
                }
            }

            $r = wp_mail($to, $subject, $body, $wp_mail_headers);
            if (!$r) {
                $last_error = error_get_last();
                if (is_array($last_error)) {
                    $this->mail_last_error = $last_error['message'];
                }
            }
            return $r;
        }

        // Simple message is asumed to be html
        if (!is_array($message)) {
            $this->mailer->IsHTML(true);
            $this->mailer->Body = $message;
        } else {
            // Only html is present?
            if (empty($message['text'])) {
                $this->mailer->IsHTML(true);
                $this->mailer->Body = $message['html'];
            }
            // Only text is present?
            else if (empty($message['html'])) {
                $this->mailer->IsHTML(false);
                $this->mailer->Body = $message['text'];
            } else {
                $this->mailer->IsHTML(true);
                $this->mailer->Body = $message['html'];
                $this->mailer->AltBody = $message['text'];
            }
        }

        $this->mailer->Subject = $subject;

        $this->mailer->ClearCustomHeaders();
        if (!empty($headers)) {
            foreach ($headers as $key => $value) {
                $this->mailer->AddCustomHeader($key . ': ' . $value);
            }
        }

        $this->mailer->ClearAddresses();
        $this->mailer->AddAddress($to);
        $this->mailer->Send();

        if ($this->mailer->IsError()) {
            $this->mail_last_error = $this->mailer->ErrorInfo;
            $this->logger->error('mail> ' . $this->mailer->ErrorInfo);
            // If the error is due to SMTP connection, the mailer cannot be reused since it does not clean up the connection
            // on error.
            $this->mailer = null;
            return false;
        }
        return true;
    }

    /**
     * Returns the SMTP options filtered so extensions can change them.
     */
    function get_smtp_options() {
        $smtp_options = $this->get_options('smtp');
        $smtp_options = apply_filters('newsletter_smtp', $smtp_options);
        return $smtp_options;
    }

    function mailer_init() {
        require_once ABSPATH . WPINC . '/class-phpmailer.php';
        require_once ABSPATH . WPINC . '/class-smtp.php';

        $smtp_options = $this->get_smtp_options();


        if ($smtp_options['enabled'] == 1) {
            $this->mailer = new PHPMailer();
            $this->mailer->IsSMTP();
            $this->mailer->Host = $smtp_options['host'];
            if (!empty($smtp_options['port']))
                $this->mailer->Port = (int) $smtp_options['port'];

            if (!empty($smtp_options['user'])) {
                $this->mailer->SMTPAuth = true;
                $this->mailer->Username = $smtp_options['user'];
                $this->mailer->Password = $smtp_options['pass'];
            }
            $this->mailer->SMTPKeepAlive = true;
            $this->mailer->SMTPSecure = $smtp_options['secure'];
            $this->mailer->SMTPAutoTLS = false;

            if ($smtp_options['ssl_insecure'] == 1) {
                $this->mailer->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
            }
        } else {
            if ($this->options['phpmailer'] == 1) {
                $this->mailer = new PHPMailer();
                $this->mailer->IsMail();
            } else {
                $this->mailer = null;
                return;
            }
        }

        if (!empty($this->options['content_transfer_encoding'])) {
            $this->mailer->Encoding = $this->options['content_transfer_encoding'];
        } else {
            $this->mailer->Encoding = 'base64';
        }

        $this->mailer->CharSet = 'UTF-8';
        $this->mailer->From = $this->options['sender_email'];

        $return_path = $this->options['return_path'];
        if (!empty($return_path)) {
            $this->mailer->Sender = $return_path;
        }
        if (!empty($this->options['reply_to'])) {
            $this->mailer->AddReplyTo($this->options['reply_to']);
        }

        $this->mailer->FromName = $this->options['sender_name'];
    }

    function hook_deactivate() {
        wp_clear_scheduled_hook('newsletter');
        wp_clear_scheduled_hook('newsletter_feed');
    }

    function hook_cron_schedules($schedules) {
        $schedules['newsletter'] = array(
            'interval' => NEWSLETTER_CRON_INTERVAL, // seconds
            'display' => 'Newsletter'
        );
//        $schedules['newsletter_weekly'] = array(
//            'interval' => 86400 * 7, // seconds
//            'display' => 'Newsletter Weekly'
//        );
        return $schedules;
    }

    function shortcode_newsletter_form($attrs, $content) {
        return $this->form($attrs['form']);
    }

    function form($number = null) {
        if ($number == null)
            return $this->subscription_form();
        $options = get_option('newsletter_forms');

        $form = $options['form_' . $number];

        if (stripos($form, '<form') !== false) {
            $form = str_replace('{newsletter_url}', plugins_url('newsletter/do/subscribe.php'), $form);
        } else {
            $form = '<form method="post" action="' . plugins_url('newsletter/do/subscribe.php') . '" onsubmit="return newsletter_check(this)">' .
                    $form . '</form>';
        }

        $form = $this->replace_lists($form);

        return $form;
    }

    function find_file($file1, $file2) {
        if (is_file($file1))
            return $file1;
        return $file2;
    }

    /**
     * Return a user if there are request parameters or cookie with identification data otherwise null.
     */
    function check_user() {
        global $wpdb, $current_user;

        if (isset($_REQUEST['nk'])) {
            list($id, $token) = @explode('-', $_REQUEST['nk'], 2);
        } else if (isset($_REQUEST['ni'])) {
            $id = (int) $_REQUEST['ni'];
            $token = $_REQUEST['nt'];
        } else if (isset($_COOKIE['newsletter'])) {
            list ($id, $token) = @explode('-', $_COOKIE['newsletter'], 2);
        }

        if (!empty($id) && !empty($token)) {
            return $wpdb->get_row($wpdb->prepare("select * from " . NEWSLETTER_USERS_TABLE . " where id=%d and token=%s limit 1", $id, $token));
        }

        $wp_user_id = get_current_user_id();
        if (empty($wp_user_id))
            return null;

        $user = $this->get_user_by_wp_user_id($wp_user_id);
        return $user;
    }

    function replace_date($text) {
        $text = str_replace('{date}', date_i18n(get_option('date_format')), $text);

        // Date processing
        $x = 0;
        while (($x = strpos($text, '{date_', $x)) !== false) {
            $y = strpos($text, '}', $x);
            if ($y === false)
                continue;
            $f = substr($text, $x + 6, $y - $x - 6);
            $text = substr($text, 0, $x) . date($f) . substr($text, $y + 1);
        }
        return $text;
    }

    /**
     * Replace any kind of newsletter placeholder in a text.
     */
    function replace($text, $user = null, $email_id = null, $referrer = null) {
        global $wpdb;

        //$this->logger->debug('Replace start');
        if (is_array($user)) {
            $user = $this->get_user($user['id']);
        }

        $email = null;
        if (is_object($email_id)) {
            $email = $email_id;
            $email_id = $email->id;
        } else if (is_numeric($email_id)) {
            $email = $this->get_email($email_id);
        }

        $text = apply_filters('newsletter_replace', $text, $user, $email);

        $text = $this->replace_url($text, 'BLOG_URL', home_url('/'));
        $text = $this->replace_url($text, 'HOME_URL', home_url('/'));

        $text = str_replace('{blog_title}', get_option('blogname'), $text);
        $text = str_replace('{blog_description}', get_option('blogdescription'), $text);

        $text = $this->replace_date($text);

        if ($user != null) {
            $options_profile = get_option('newsletter_profile');

            $text = str_replace('{email}', $user->email, $text);
            if (empty($user->name)) {
                $text = str_replace(' {name}', '', $text);
                $text = str_replace('{name}', '', $text);
            } else {
                $text = str_replace('{name}', $user->name, $text);
            }

            switch ($user->sex) {
                case 'm': $text = str_replace('{title}', $options_profile['title_male'], $text);
                    break;
                case 'f': $text = str_replace('{title}', $options_profile['title_female'], $text);
                    break;
                case 'n': $text = str_replace('{title}', $options_profile['title_none'], $text);
                    break;
                default:
                    $text = str_replace('{title}', '', $text);
            }


            $text = str_replace('{surname}', $user->surname, $text);
            $text = str_replace('{last_name}', $user->surname, $text);

            $full_name = trim($user->name . ' ' . $user->surname);
            if (empty($full_name)) {
                $text = str_replace(' {full_name}', '', $text);
                $text = str_replace('{full_name}', '', $text);
            } else {
                $text = str_replace('{full_name}', $full_name, $text);
            }

            $text = str_replace('{token}', $user->token, $text);
            $text = str_replace('%7Btoken%7D', $user->token, $text);
            $text = str_replace('{id}', $user->id, $text);
            $text = str_replace('%7Bid%7D', $user->id, $text);
            $text = str_replace('{ip}', $user->ip, $text);
            $text = str_replace('{key}', $user->id . '-' . $user->token, $text);
            $text = str_replace('%7Bkey%7D', $user->id . '-' . $user->token, $text);

            if (strpos($text, '{profile_form}') !== false) {
                $text = str_replace('{profile_form}', NewsletterSubscription::instance()->get_profile_form_html5($user), $text);
            }

            for ($i = 1; $i < NEWSLETTER_PROFILE_MAX; $i++) {
                $p = 'profile_' . $i;
                $text = str_replace('{profile_' . $i . '}', $user->$p, $text);
            }

//            $profile = $wpdb->get_results("select name,value from " . $wpdb->prefix . "newsletter_profiles where newsletter_id=" . $user->id);
//            foreach ($profile as $field) {
//                $text = str_ireplace('{np_' . $field->name . '}', htmlspecialchars($field->value), $text);
//            }
//
//            $text = preg_replace('/\\{np_.+\}/i', '', $text);

            $base = (empty($this->options_main['url']) ? get_option('home') : $this->options_main['url']);
            $id_token = '&amp;ni=' . $user->id . '&amp;nt=' . $user->token;
            $nk = $user->id . '-' . $user->token;

            $options_subscription = NewsletterSubscription::instance()->options;

            if ($email) {
                $text = str_replace('{email_id}', $email->id, $text);
                $text = str_replace('{email_subject}', $email->subject, $text);
            }

            $home_url = home_url('/');
            //$text = $this->replace_url($text, 'SUBSCRIPTION_CONFIRM_URL', self::add_qs(plugins_url('do.php', __FILE__), 'a=c' . $id_token));
            $text = $this->replace_url($text, 'SUBSCRIPTION_CONFIRM_URL', $home_url . '?na=c&nk=' . $nk);
            $text = $this->replace_url($text, 'UNSUBSCRIPTION_CONFIRM_URL', $home_url . '?na=uc&nk=' . $nk . ($email ? '&nek=' . $email->id : ''));
            //$text = $this->replace_url($text, 'UNSUBSCRIPTION_CONFIRM_URL', NEWSLETTER_URL . '/do/unsubscribe.php?nk=' . $nk);
            $text = $this->replace_url($text, 'UNSUBSCRIPTION_URL', $home_url . '?na=u&nk=' . $nk . ($email ? '&nek=' . $email->id : ''));
            $text = $this->replace_url($text, 'CHANGE_URL', plugins_url('newsletter/do/change.php'));

            // Obsolete.
            $text = $this->replace_url($text, 'FOLLOWUP_SUBSCRIPTION_URL', self::add_qs($base, 'nm=fs' . $id_token));
            $text = $this->replace_url($text, 'FOLLOWUP_UNSUBSCRIPTION_URL', self::add_qs($base, 'nm=fu' . $id_token));
            $text = $this->replace_url($text, 'FEED_SUBSCRIPTION_URL', self::add_qs($base, 'nm=es' . $id_token));
            $text = $this->replace_url($text, 'FEED_UNSUBSCRIPTION_URL', self::add_qs($base, 'nm=eu' . $id_token));


            if (empty($options_profile['profile_url']))
                $text = $this->replace_url($text, 'PROFILE_URL', $home_url . '?na=p&nk=' . $nk);
            else
                $text = $this->replace_url($text, 'PROFILE_URL', self::add_qs($options_profile['profile_url'], 'ni=' . $user->id . '&amp;nt=' . $user->token));

            //$text = $this->replace_url($text, 'UNLOCK_URL', self::add_qs($this->options_main['lock_url'], 'nm=m' . $id_token));
            $text = $this->replace_url($text, 'UNLOCK_URL', $home_url . '?na=ul&nk=' . $nk);
            if (!empty($email_id)) {
                $text = $this->replace_url($text, 'EMAIL_URL', $home_url . '?na=v&id=' . $email_id . '&amp;nk=' . $nk);
            }

            for ($i = 1; $i <= NEWSLETTER_LIST_MAX; $i++) {
                $text = $this->replace_url($text, 'LIST_' . $i . '_SUBSCRIPTION_URL', self::add_qs($base, 'nm=ls&amp;nl=' . $i . $id_token));
                $text = $this->replace_url($text, 'LIST_' . $i . '_UNSUBSCRIPTION_URL', self::add_qs($base, 'nm=lu&amp;nl=' . $i . $id_token));
            }

            // Profile fields change links
            $text = $this->replace_url($text, 'SET_SEX_MALE', NEWSLETTER_CHANGE_URL . '?nk=' . $nk . '&nf=sex&nv=m');
            $text = $this->replace_url($text, 'SET_SEX_FEMALE', NEWSLETTER_CHANGE_URL . '?nk=' . $nk . '&nf=sex&nv=f');
            $text = $this->replace_url($text, 'SET_FEED', NEWSLETTER_CHANGE_URL . '?nk=' . $nk . '&nv=1&nf=feed');
            $text = $this->replace_url($text, 'UNSET_FEED', NEWSLETTER_CHANGE_URL . '?nk=' . $nk . '&nv=0&nf=feed');
            for ($i = 1; $i <= NEWSLETTER_LIST_MAX; $i++) {
                $text = $this->replace_url($text, 'SET_PREFERENCE_' . $i, NEWSLETTER_CHANGE_URL . '?nk=' . $nk . '&nv=1&nf=preference_' . $i);
                $text = $this->replace_url($text, 'UNSET_PREFERENCE_' . $i, NEWSLETTER_CHANGE_URL . '?nk=' . $nk . '&nv=0&nf=preference_' . $i);
            }
        }

        if (strpos($text, '{subscription_form}') !== false) {
            $text = str_replace('{subscription_form}', NewsletterSubscription::instance()->get_subscription_form($referrer), $text);
        } else {
            for ($i = 1; $i <= 10; $i++) {
                if (strpos($text, "{subscription_form_$i}") !== false) {
                    $text = str_replace("{subscription_form_$i}", NewsletterSubscription::instance()->get_form($i), $text);
                    break;
                }
            }
        }

        //$this->logger->debug('Replace end');
        return $text;
    }

    function replace_url($text, $tag, $url) {
        $home = trailingslashit(home_url());
        $tag_lower = strtolower($tag);
        $text = str_replace($home . '{' . $tag_lower . '}', $url, $text);
        $text = str_replace($home . '%7B' . $tag_lower . '%7D', $url, $text);
        $text = str_replace('{' . $tag_lower . '}', $url, $text);
        $text = str_replace('%7B' . $tag_lower . '%7D', $url, $text);

        // for compatibility
        $text = str_replace($home . $tag, $url, $text);

        return $text;
    }

    function hook_shutdown() {
        if ($this->mailer != null)
            $this->mailer->SmtpClose();
    }

    function hook_the_content($content) {
        global $post, $cache_stop;

        if ($this->lock_found || !is_singular() || is_user_logged_in()) {
            return $content;
        }

        if (!empty($this->options['lock_ids'])) {
            $ids = explode(',', $this->options['lock_ids']);
        }

        if (!empty($ids) && (has_tag($ids) || in_category($ids) || in_array($post->post_name, $ids))) {
            $cache_stop = true;
            $user = $this->check_user();
            if ($user == null || $user->status != 'C') {
                $buffer = $this->replace($this->options['lock_message']);
                return '<div class="newsletter-lock">' . do_shortcode($buffer) . '</div>';
            }
        }

        return $content;
    }

    /**
     * Exceutes a query and log it.
     */
    function query($query) {
        global $wpdb;

        $this->log($query, 3);
        return $wpdb->query($query);
    }

    function get_user_from_request($required = false) {
        if (isset($_REQUEST['nk'])) {
            list($id, $token) = @explode('-', $_REQUEST['nk'], 2);
        } else if (isset($_REQUEST['ni'])) {
            $id = (int) $_REQUEST['ni'];
            $token = $_REQUEST['nt'];
        }
        $user = $this->get_user($id);

        if ($user == null || $token != $user->token) {
            if ($required)
                die('No subscriber found.');
            else
                return null;
        }
        return $user;
    }

    /** Save an email and provide serialization, if needed, of $email['options']. */
    function save_email($email, $return_format = OBJECT) {
        if (is_object($email)) {
            $email = (array) $email;
        }

        if (isset($email['subject'])) {
            if (mb_strlen($email['subject'], 'UTF-8') > 250) {
                $email['subject'] = mb_substr($email['subject'], 0, 250, 'UTF-8');
            }
        }
        if (isset($email['options']) && is_array($email['options']))
            $email['options'] = serialize($email['options']);
        return $this->store->save(NEWSLETTER_EMAILS_TABLE, $email, $return_format);
    }

    function delete_email($id) {
        return $this->store->delete(NEWSLETTER_EMAILS_TABLE, $id);
    }

    function get_email_field($id, $field_name) {
        return $this->store->get_field(NEWSLETTER_EMAILS_TABLE, $id, $field_name);
    }

    /**
     * Returns a list of users marked as "test user".
     * @return array
     */
    function get_test_users() {
        return $this->store->get_all(NEWSLETTER_USERS_TABLE, "where test=1");
    }

    function delete_user($id) {
        global $wpdb;
        $r = $this->store->delete(NEWSLETTER_USERS_TABLE, $id);
        if ($r !== false) {
            $wpdb->delete(NEWSLETTER_STATS_TABLE, array('user_id' => $id));
        }
    }

    function set_user_status($id_or_email, $status) {
        global $wpdb;

        $this->logger->debug('Status change to ' . $status . ' of subscriber ' . $id_or_email . ' from ' . $_SERVER['REQUEST_URI']);

        $id_or_email = strtolower(trim($id_or_email));
        if (is_numeric($id_or_email)) {
            $r = $wpdb->query($wpdb->prepare("update " . NEWSLETTER_USERS_TABLE . " set status=%s where id=%d limit 1", $status, $id_or_email));
        } else {
            $r = $wpdb->query($wpdb->prepare("update " . NEWSLETTER_USERS_TABLE . " set status=%s where email=%s limit 1", $status, $id_or_email));
        }

        if ($wpdb->last_error) {
            $this->logger->error($wpdb->last_error);
            return false;
        }
        return $r;
    }

    /**
     * Called weekly if at least one extension is active.
     */
    function hook_newsletter_extension_versions($force = false) {
        if (!$force && !defined('NEWSLETTER_EXTENSION')) {
            return;
        }
        $response = wp_remote_get('https://www.thenewsletterplugin.com/wp-content/versions/all.txt');
        if (is_wp_error($response)) {
            $this->logger->error($response);
            return;
        }

        $versions = json_decode(wp_remote_retrieve_body($response));
        update_option('newsletter_extension_versions', $versions, false);
    }

    function get_extension_version($extension_id) {
        $versions = get_option('newsletter_extension_versions');
        if (!is_array($versions)) {
            return null;
        }
        foreach ($versions as $data) {
            if ($data->id == $extension_id) {
                return $data->version;
            }
        }

        return null;
    }

    /**
     * Completes the WordPress plugin update data with the extension data. 
     * $value is the data WordPress is saving
     * $extension is an instance of an extension
     */
    function set_extension_update_data($value, $extension) {

        // See the wp_update_plugins function
        if (!is_object($value)) {
            return $value;
        }

        // If someone registered our extension name on wordpress.org... get rid of it otherwise
        // our extenions will be overwritten!
        unset($value->response[$extension->plugin]);
        unset($value->no_update[$extension->plugin]);

        if (defined('NEWSLETTER_EXTENSION_UPDATE') && !NEWSLETTER_EXTENSION_UPDATE) {
            return $value;
        }

        if (!function_exists('get_plugin_data')) {
            return $value;
        }

        $new_version = $this->get_extension_version($extension->id);

        if (empty($new_version)) {
            return $value;
        }

        if (function_exists('get_plugin_data')) {
            if (file_exists(WP_PLUGIN_DIR . '/' . $extension->plugin)) {
                $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $extension->plugin, false, false);
            } else if (file_exists(WPMU_PLUGIN_DIR . '/' . $extension->plugin)) {
                $plugin_data = get_plugin_data(WPMU_PLUGIN_DIR . '/' . $extension->plugin, false, false);
            }
        }

        if (!isset($plugin_data)) {
            return $value;
        }

        if (version_compare($new_version, $plugin_data['Version']) <= 0) {
            return $value;
        }

        $plugin = new stdClass();
        $plugin->id = $extension->id;
        $plugin->slug = $extension->slug;
        $plugin->plugin = $extension->plugin;
        $plugin->new_version = $new_version;
        $plugin->url = '';
        $value->response[$extension->plugin] = $plugin;

        if (defined('NEWSLETTER_LICENSE_KEY')) {
            $value->response[$extension->plugin]->package = 'http://www.thenewsletterplugin.com/wp-content/plugins/file-commerce-pro/get.php?f=' . $extension->id .
                    '&k=' . NEWSLETTER_LICENSE_KEY;
        } else {
            $value->response[$extension->plugin]->package = 'http://www.thenewsletterplugin.com/wp-content/plugins/file-commerce-pro/get.php?f=' . $extension->id .
                    '&k=' . Newsletter::instance()->options['contract_key'];
        }

        return $value;
    }

    /**
     * Retrieve the extensions form the tnp site
     * @return array 
     */
    function getTnpExtensions() {

        $extensions_json = get_transient('tnp_extensions_json');

        if (false === $extensions_json) {
            $url = "https://www.thenewsletterplugin.com/wp-content/extensions.json";
            if (!empty($this->options['contract_key'])) {
                $url = "http://www.thenewsletterplugin.com/wp-content/plugins/file-commerce-pro/extensions.php?k=" . $this->options['contract_key'];
            }

            $extensions_response = wp_remote_get($url);
            $extensions_json = wp_remote_retrieve_body($extensions_response);
            if (!empty($extensions_json)) {
                set_transient('tnp_extensions_json', $extensions_json, 24 * 60 * 60);
            }
        }

        $extensions = json_decode($extensions_json);

        return $extensions;
    }

    /**
     * Load plugin textdomain.
     *
     * @since 1.0.0
     */
    function hook_plugins_loaded() {
        if (function_exists('load_plugin_textdomain')) {
            load_plugin_textdomain('newsletter', false, plugin_basename(dirname(__FILE__)) . '/languages');
        }
    }

    var $panels = array();

    function add_panel($key, $panel) {
        if (!isset($this->panels[$key]))
            $this->panels[$key] = array();
        if (!isset($panel['id']))
            $panel['id'] = sanitize_key($panel['label']);
        $this->panels[$key][] = $panel;
    }

    function has_license() {
        return !empty($this->options['contract_key']);
    }

}

$newsletter = Newsletter::instance();

require_once NEWSLETTER_DIR . '/subscription/subscription.php';
require_once NEWSLETTER_DIR . '/emails/emails.php';
require_once NEWSLETTER_DIR . '/users/users.php';
require_once NEWSLETTER_DIR . '/statistics/statistics.php';
if (!file_exists(WP_PLUGIN_DIR . '/newsletter-lock')) {
    require_once NEWSLETTER_DIR . '/lock/lock.php';
}

if (!file_exists(WP_PLUGIN_DIR . '/newsletter-wpusers')) {
    require_once NEWSLETTER_DIR . '/wp/wp.php';
}

if (!is_dir(WP_PLUGIN_DIR . '/newsletter-feed')) {
    if (is_file(WP_CONTENT_DIR . '/extensions/newsletter/feed/feed.php')) {
        require_once WP_CONTENT_DIR . '/extensions/newsletter/feed/feed.php';
    }
}

if (!is_dir(WP_PLUGIN_DIR . '/newsletter-followup')) {
    if (is_file(WP_CONTENT_DIR . '/extensions/newsletter/followup/followup.php')) {
        require_once WP_CONTENT_DIR . '/extensions/newsletter/followup/followup.php';
    }
}

if (!is_dir(WP_PLUGIN_DIR . '/newsletter-reports')) {
    if (is_file(WP_CONTENT_DIR . '/extensions/newsletter/reports/reports.php')) {
        require_once WP_CONTENT_DIR . '/extensions/newsletter/reports/reports.php';
    }
}

if (!is_dir(WP_PLUGIN_DIR . '/newsletter-mailjet')) {
    if (is_file(WP_CONTENT_DIR . '/extensions/newsletter/mailjet/mailjet.php')) {
        require_once WP_CONTENT_DIR . '/extensions/newsletter/mailjet/mailjet.php';
    }
}
if (!is_dir(WP_PLUGIN_DIR . '/newsletter-sendgrid')) {
    if (is_file(WP_CONTENT_DIR . '/extensions/newsletter/sendgrid/sendgrid.php')) {
        require_once WP_CONTENT_DIR . '/extensions/newsletter/sendgrid/sendgrid.php';
    }
}

if (!is_dir(WP_PLUGIN_DIR . '/newsletter-facebook')) {
    if (is_file(WP_CONTENT_DIR . '/extensions/newsletter/facebook/facebook.php')) {
        require_once WP_CONTENT_DIR . '/extensions/newsletter/facebook/facebook.php';
    }
}


if (!is_dir(WP_PLUGIN_DIR . '/newsletter-popup')) {
    if (is_file(WP_CONTENT_DIR . '/extensions/newsletter/popup/popup.php')) {
        require_once WP_CONTENT_DIR . '/extensions/newsletter/popup/popup.php';
    }
}

if (!is_dir(WP_PLUGIN_DIR . '/newsletter-mandrill')) {
    if (is_file(WP_CONTENT_DIR . '/extensions/newsletter/mandrill/mandrill.php')) {
        require_once WP_CONTENT_DIR . '/extensions/newsletter/mandrill/mandrill.php';
    }
}


require_once(dirname(__FILE__) . '/widget/standard.php');
require_once(dirname(__FILE__) . '/widget/minimal.php');

register_activation_hook(__FILE__, 'newsletter_activate');

function newsletter_activate() {
    Newsletter::instance()->upgrade();

    NewsletterUsers::instance()->upgrade();
    NewsletterEmails::instance()->upgrade();
    NewsletterSubscription::instance()->upgrade();
    NewsletterStatistics::instance()->upgrade();
}

register_activation_hook(__FILE__, 'newsletter_deactivate');

function newsletter_deactivate() {
    
}
