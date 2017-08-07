<?php

if (!defined('ABSPATH'))
    exit;

class NewsletterModule {

    /**
     * @var NewsletterLogger
     */
    var $logger;

    /**
     * @var NewsletterStore
     */
    var $store;

    /**
     * The main module options
     * @var array
     */
    var $options;

    /**
     * @var string The module name
     */
    var $module;

    /**
     * The module version
     * @var string
     */
    var $version;
    var $old_version;
    var $module_id;
    var $available_version;

    /**
     * Prefix for all options stored on WordPress options table.
     * @var string
     */
    var $prefix;

    /**
     * @var NewsletterThemes
     */
    var $themes;

    function __construct($module, $version, $module_id = null) {
        $this->module = $module;
        $this->version = $version;
        $this->module_id = $module_id;
        $this->prefix = 'newsletter_' . $module;


        $this->logger = new NewsletterLogger($module);
        $this->options = $this->get_options();
        $this->store = NewsletterStore::singleton();

        //$this->logger->debug($module . ' constructed');
        // Version check
        if (is_admin()) {
            $this->old_version = get_option($this->prefix . '_version', '0.0.0');

            if ($this->old_version == '0.0.0') {
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                $this->first_install();
                update_option($this->prefix . "_first_install_time", time(), FALSE);
            }

            if (strcmp($this->old_version, $this->version) != 0) {
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                $this->logger->info('Version changed from ' . $this->old_version . ' to ' . $this->version);
                // Do all the stuff for this version change
                $this->upgrade();
                update_option($this->prefix . '_version', $this->version);
            }

            add_action('admin_menu', array($this, 'admin_menu'));
            $this->available_version = get_option($this->prefix . '_available_version');
        }
    }

    function first_install() {
        
    }

    /**
     * Does a basic upgrade work, checking if the options is already present and if not (first
     * installation), recovering the defaults, saving them on database and initializing the
     * internal $options.
     */
    function upgrade() {
        $default_options = $this->get_default_options();
        if (empty($this->options) || !is_array($this->options)) {
            $this->save_options($default_options);
        } else {
            $this->save_options(array_merge($default_options, $this->options));
        }
    }

    function init_options($sub, $autoload = true) {
        global $wpdb;
        $default_options = $this->get_default_options($sub);
        $options = $this->get_options($sub);
        $options = array_merge($default_options, $options);
        $this->save_options($options, $sub);
        if ($autoload) {
            $this->upgrade_query('update ' . $wpdb->options . " set autoload='yes' where option_name='" . esc_sql($this->get_prefix($sub)) . "' limit 1");
        } else {
            $this->upgrade_query('update ' . $wpdb->options . " set autoload='no' where option_name='" . esc_sql($this->get_prefix($sub)) . "' limit 1");
        }
    }

    function upgrade_query($query) {
        global $wpdb, $charset_collate;

        $this->logger->info('upgrade_query> Executing ' . $query);
        $suppress_errors = $wpdb->suppress_errors(true);
        $wpdb->query($query);
        if ($wpdb->last_error) {
            $this->logger->debug($wpdb->last_error);
        }
        $wpdb->suppress_errors($suppress_errors);
    }

    /**
     * Kept for compatibility.
     */
    static function get_available_version($module_id, $force = false) {
        return '';
    }

    /**
     * Kept for compatibility.
     */
    function new_version_available($force = false) {
        return false;
    }

    /** Returns a prefix to be used for option names and other things which need to be uniquely named. The parameter
     * "sub" should be used when a sub name is needed for another set of options or like.
     *
     * @param string $sub
     * @return string The prefix for names
     */
    function get_prefix($sub = '') {
        return $this->prefix . (!empty($sub) ? '_' : '') . $sub;
    }

    /**
     * Returns the options of a module, if not found an empty array.
     */
    function get_options($sub = '') {
        $options = get_option($this->get_prefix($sub), array());
        if (!is_array($options)) return array();
        return $options;
    }

    function get_default_options($sub = '') {
        if (!empty($sub)) {
            $sub .= '-';
        }
        @include NEWSLETTER_DIR . '/' . $this->module . '/languages/' . $sub . 'en_US.php';
        if (defined('WPLANG') && WPLANG != 'en_US') {
            @include NEWSLETTER_DIR . '/' . $this->module . '/languages/' . $sub . WPLANG . '.php';
        }
        if (!isset($options) || !is_array($options)) {
            return array();
        }
        return $options;
    }

    function reset_options($sub = '') {
        $this->save_options(array_merge($this->get_options($sub), $this->get_default_options($sub)), $sub);
        return $this->options;
    }

    /**
     * Saves the module options (or eventually a subset names as per parameter $sub). $options
     * should be an array (even if it can work with non array options.
     * The internal module options variable IS initialized with those new options only for the main
     * options (empty $sub parameter).
     * If the options contain a "theme" value, the theme-related options contained are saved as well
     * (used by some modules).
     *
     * @param array $options
     * @param string $sub
     */
    function save_options($options, $sub = '') {
        update_option($this->get_prefix($sub), $options);
        if (empty($sub)) {
            $this->options = $options;
            if (isset($this->themes) && isset($options['theme'])) {
                $this->themes->save_options($options['theme'], $options);
            }
            // TODO: To be remove since there is no more log level at module level (should it be reintroduced?)
            if (isset($options['log_level']))
                update_option('newsletter_' . $this->module . '_log_level', $options['log_level']);
        }
    }

    function delete_options($sub = '') {
        delete_option($this->get_prefix($sub));
        if (empty($sub)) {
            $this->options = array();
        }
    }

    function merge_options($options, $sub = '') {
        if (!is_array($options)) $options = array();
        $old_options = $this->get_options($sub);
        $this->save_options(array_merge($old_options, $options), $sub);
    }

    function backup_options($sub) {
        $options = $this->get_options($sub);
        update_option($this->get_prefix($sub) . '_backup', $options, false);
    }

    function get_last_run($sub = '') {
        return get_option($this->get_prefix($sub) . '_last_run', 0);
    }

    /**
     * Save the module last run value. Used to store a timestamp for some modules,
     * for example the Feed by Mail module.
     *
     * @param int $time Unix timestamp (as returned by time() for example)
     * @param string $sub Sub module name (default empty)
     */
    function save_last_run($time, $sub = '') {
        update_option($this->get_prefix($sub) . '_last_run', $time);
    }

    /**
     * Sums $delta seconds to the last run time.
     * @param int $delta Seconds
     * @param string $sub Sub module name (default empty)
     */
    function add_to_last_run($delta, $sub = '') {
        $time = $this->get_last_run($sub);
        $this->save_last_run($time + $delta, $sub);
    }

    /**
     * Checks if the semaphore of that name (for this module) is still red. If it is active the method
     * returns false. If it is not active, it will be activated for $time seconds.
     *
     * Since this method activate the semaphore when called, it's name is a bit confusing.
     *
     * @param string $name Sempahore name (local to this module)
     * @param int $time Max time in second this semaphore should stay red
     * @return boolean False if the semaphore is red and you should not proceed, true is it was not active and has been activated.
     */
    function check_transient($name, $time) {
        if ($time < 60)
            $time = 60;
        //usleep(rand(0, 1000000));
        if (($value = get_transient($this->get_prefix() . '_' . $name)) !== false) {
            $this->logger->error('Blocked by transient ' . $this->get_prefix() . '_' . $name . ' set ' . (time() - $value) . ' seconds ago');
            return false;
        }
        set_transient($this->get_prefix() . '_' . $name, time(), $time);
        return true;
    }

    function delete_transient($name = '') {
        delete_transient($this->get_prefix() . '_' . $name);
    }

    /** Returns a random token of the specified size (or 10 characters if size is not specified).
     *
     * @param int $size
     * @return string
     */
    static function get_token($size = 10) {
        return substr(md5(rand()), 0, $size);
    }

    /**
     * Adds query string parameters to an URL checing id there are already other parameters.
     *
     * @param string $url
     * @param string $qs The part of query-string to add (param1=value1&param2=value2...)
     * @param boolean $amp If the method must use the &amp; instead of the plain & (default true)
     * @return string
     */
    static function add_qs($url, $qs, $amp = true) {
        if (strpos($url, '?') !== false) {
            if ($amp)
                return $url . '&amp;' . $qs;
            else
                return $url . '&' . $qs;
        } else
            return $url . '?' . $qs;
    }

    /**
     * Returns the email address normalized, lowecase with no spaces. If it's not a valid email
     * returns null.
     */
    static function normalize_email($email) {
        $email = strtolower(trim($email));
        if (!is_email($email))
            return null;
        return $email;
    }

    static function normalize_name($name) {
        $name = str_replace(';', ' ', $name);
        $name = strip_tags($name);
        return $name;
    }

    static function normalize_sex($sex) {
        $sex = trim(strtolower($sex));
        if ($sex != 'f' && $sex != 'm')
            $sex = 'n';
        return $sex;
    }

    static function is_email($email, $empty_ok = false) {
        $email = strtolower(trim($email));
        if ($empty_ok && $email == '')
            return true;

        if (!is_email($email))
            return false;

        // TODO: To be moved on the subscription module and make configurable
        if (strpos($email, 'mailinator.com') !== false)
            return false;
        if (strpos($email, 'guerrillamailblock.com') !== false)
            return false;
        if (strpos($email, 'emailtemporanea.net') !== false)
            return false;
        return true;
    }

    /**
     * Converts a GMT date from mysql (see the posts table columns) into a timestamp.
     *
     * @param string $s GMT date with format yyyy-mm-dd hh:mm:ss
     * @return int A timestamp
     */
    static function m2t($s) {

        // TODO: use the wordpress function I don't remeber the name
        $s = explode(' ', $s);
        $d = explode('-', $s[0]);
        $t = explode(':', $s[1]);
        return gmmktime((int) $t[0], (int) $t[1], (int) $t[2], (int) $d[1], (int) $d[2], (int) $d[0]);
    }

    static function format_date($time) {
        if (empty($time)) {
            return '-';
        }
        return gmdate(get_option('date_format') . ' ' . get_option('time_format'), $time + get_option('gmt_offset') * 3600);
    }

    static function format_time_delta($delta) {
        $days = floor($delta / (3600 * 24));
        $hours = floor(($delta % (3600 * 24)) / 3600);
        $minutes = floor(($delta % 3600) / 60);
        $seconds = floor(($delta % 60));
        $buffer = $days . ' days, ' . $hours . ' hours, ' . $minutes . ' minutes, ' . $seconds . ' seconds';
        return $buffer;
    }

    /**
     * Formats a scheduler returned "next execution" time, managing negative or false values. Many times
     * used in conjuction with "last run".
     *
     * @param string $name The scheduler name
     * @return string
     */
    static function format_scheduler_time($name) {
        $time = wp_next_scheduled($name);
        if ($time === false) {
            return 'No next run scheduled';
        }
        $delta = $time - time();
        // If less 10 minutes late it can be a cron problem but now it is working
        if ($delta < 0 && $delta > -600) {
            return 'Probably running now';
        } else if ($delta <= -600) {
            return 'It seems the cron system is not working. Reload the page to see if this message change.';
        }
        return 'Runs in ' . self::format_time_delta($delta);
    }

    static function date($time = null, $now = false, $left = false) {
        if (is_null($time)) {
            $time = time();
        }
        if ($time == false) {
            $buffer = 'none';
        } else {
            $buffer = gmdate(get_option('date_format') . ' ' . get_option('time_format'), $time + get_option('gmt_offset') * 3600);
        }
        if ($now) {
            $buffer .= ' (now: ' . gmdate(get_option('date_format') . ' ' .
                            get_option('time_format'), time() + get_option('gmt_offset') * 3600);
            $buffer .= ')';
        }
        if ($left) {
            $buffer .= ', ' . gmdate('H:i:s', $time - time()) . ' left';
        }
        return $buffer;
    }

    /**
     * Return an array of array with on first element the array of recent post and on second element the array
     * of old posts.
     *
     * @param array $posts
     * @param int $time
     */
    static function split_posts(&$posts, $time = 0) {
        if ($last_run < 0) {
            return array_chunk($posts, ceil(count($posts) / 2));
        }

        $result = array(array(), array());
        foreach ($posts as &$post) {
            if (self::is_post_old($post, $time))
                $result[1][] = $post;
            else
                $result[0][] = $post;
        }
        return $result;
    }

    static function is_post_old(&$post, $time = 0) {
        return self::m2t($post->post_date_gmt) <= $time;
    }

    static function get_post_image($post_id = null, $size = 'thumbnail', $alternative = null) {
        global $post;

        if (empty($post_id))
            $post_id = $post->ID;
        if (empty($post_id))
            return $alternative;

        $image_id = function_exists('get_post_thumbnail_id') ? get_post_thumbnail_id($post_id) : false;
        if ($image_id) {
            $image = wp_get_attachment_image_src($image_id, $size);
            return $image[0];
        } else {
            $attachments = get_children(array('post_parent' => $post_id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID'));

            if (empty($attachments)) {
                return $alternative;
            }

            foreach ($attachments as $id => $attachment) {
                $image = wp_get_attachment_image_src($id, $size);
                return $image[0];
            }
        }
    }

    /** Returns true if the named extension is installed. */
    static function extension_exists($name) {
        return is_file(WP_CONTENT_DIR . "/extensions/newsletter/$name/$name.php");
    }

    /**
     * Cleans up a text containing url tags with appended the absolute URL (due to
     * the editor behavior) moving back them to the simple form.
     */
    static function clean_url_tags($text) {
        $text = str_replace('%7B', '{', $text);
        $text = str_replace('%7D', '}', $text);

        // Only tags which are {*_url}
        $text = preg_replace("/[\"']http[^\"']+(\\{[^\\}]+_url\\})[\"']/i", "\"\\1\"", $text);
        return $text;
    }

    function get_styles() {

        $list = array('' => 'none');

        $dir = NEWSLETTER_DIR . '/' . $this->module . '/styles';
        $handle = @opendir($dir);

        if ($handle !== false) {
            while ($file = readdir($handle)) {
                if ($file == '.' || $file == '..')
                    continue;
                if (substr($file, -4) != '.css')
                    continue;
                $list[$file] = substr($file, 0, strlen($file) - 4);
            }
            closedir($handle);
        }

        $dir = WP_CONTENT_DIR . '/extensions/newsletter/' . $this->module . '/styles';
        if (is_dir($dir)) {
            $handle = @opendir($dir);

            if ($handle !== false) {
                while ($file = readdir($handle)) {
                    if ($file == '.' || $file == '..')
                        continue;
                    if (isset($list[$file]))
                        continue;
                    if (substr($file, -4) != '.css')
                        continue;
                    $list[$file] = substr($file, 0, strlen($file) - 4);
                }
                closedir($handle);
            }
        }
        return $list;
    }

    function get_style_url($style) {
        if (is_file(WP_CONTENT_DIR . '/extensions/newsletter/' . $this->module . '/styles/' . $style))
            return WP_CONTENT_URL . '/extensions/newsletter/' . $this->module . '/styles/' . $style;
        else
            return plugins_url('newsletter') . '/' . $this->module . '/styles/' . $style;
    }

    function admin_menu() {
        
    }

    function add_menu_page($page, $title) {
        global $newsletter;
        $name = 'newsletter_' . $this->module . '_' . $page;
        add_submenu_page('newsletter_main_index', $title, $title, ($newsletter->options['editor'] == 1) ? 'manage_categories' : 'manage_options', $name, array($this, 'menu_page'));
    }

    function add_admin_page($page, $title) {
        global $newsletter;
        $name = 'newsletter_' . $this->module . '_' . $page;
        $name = apply_filters('newsletter_admin_page', $name);
        add_submenu_page(null, $title, $title, ($newsletter->options['editor'] == 1) ? 'manage_categories' : 'manage_options', $name, array($this, 'menu_page'));
    }

    function sanitize_file_name($name) {
        return preg_replace('/[^a-z_\\-]/i', '', $name);
    }

    function menu_page() {
        global $plugin_page, $newsletter, $wpdb;

        $parts = explode('_', $plugin_page, 3);
        $module = $this->sanitize_file_name($parts[1]);
        $page = $this->sanitize_file_name($parts[2]);
        $page = str_replace('_', '-', $page);

        $file = WP_CONTENT_DIR . '/extensions/newsletter/' . $module . '/' . $page . '.php';
        if (!is_file($file)) {
            $file = NEWSLETTER_DIR . '/' . $module . '/' . $page . '.php';
        }
        require $file;
    }

    function get_admin_page_url($page) {
        return admin_url('admin.php') . '?page=newsletter_' . $this->module . '_' . $page;
    }

    /** Returns all the emails of the give type (message, feed, followup, ...) and in the given format
     * (default as objects). Return false on error or at least an empty array. Errors should never
     * occur.
     *
     * @global wpdb $wpdb
     * @param string $type
     * @return boolean|array
     */
    function get_emails($type = null, $format = OBJECT) {
        global $wpdb;
        if ($type == null) {
            $list = $wpdb->get_results("select * from " . NEWSLETTER_EMAILS_TABLE . " order by id desc", $format);
        } else {
            $list = $wpdb->get_results($wpdb->prepare("select * from " . NEWSLETTER_EMAILS_TABLE . " where type=%s order by id desc", $type), $format);
        }
        if ($wpdb->last_error) {
            $this->logger->error($wpdb->last_error);
            return false;
        }
        if (empty($list)) {
            return array();
        }
        return $list;
    }

    function get_email($id, $format = OBJECT) {
        return $this->store->get_single(NEWSLETTER_EMAILS_TABLE, (int) $id, $format);
    }

    function get_email_status_label($email) {
        switch ($email->status) {
            case 'sending':
                if ($email->send_on > time()) {
                    return __('Scheduled', 'newsletter');
                } else {
                    return __('Sending', 'newsletter');
                }

            case 'sent':
                return __('Sent', 'newsletter');
            case 'paused':
                return __('Paused', 'newsletter');
            case 'new':
                return __('Draft', 'newsletter');
            default:
                return ucfirst($email->status);
        }
    }

    function get_email_type_label($type) {

        // Is an email?
        if (is_object($type))
            $type = $type->type;

        switch ($type) {
            case 'followup':
                return 'Followup';
            case 'message':
                return 'Standard Newsletter';
            case 'feed':
                return 'Feed by Mail';
        }

        if (strpos($type, 'automated') === 0) {
            list($a, $id) = explode('_', $type->type);
            return 'Automated Channel ' . $id;
        }

        return ucfirst($type);
    }

    function get_email_progress_label($email) {
        if ($email->status == 'sent' || $email->status == 'sending') {
            return $email->sent . ' ' . __('of', 'newsletter') . ' ' . $email->total;
        }
        return '-';
    }

    /** Searches for a user using the nk parameter or the ni and nt parameters. Tries even with the newsletter cookie.
     * If found, the user object is returned or null.
     * The user is returned without regards to his status that should be checked by caller.
     *
     * @return null
     */
    function check_user() {
        global $wpdb;

        if (isset($_REQUEST['nk'])) {
            list($id, $token) = @explode('-', $_REQUEST['nk'], 2);
        } else if (isset($_REQUEST['ni'])) {
            $id = (int) $_REQUEST['ni'];
            $token = $_REQUEST['nt'];
        } else if (isset($_COOKIE['newsletter'])) {
            list ($id, $token) = @explode('-', $_COOKIE['newsletter'], 2);
        }

        $user = $this->get_user($id);
        if ($user == null || $token != $user->token) {
            $user = null;
            if (is_user_logged_in()) {
                $user = $this->get_user_by_wp_user_id(get_current_user_id());
            }
        }
        return $user;
    }

    /** Returns the user identify by an id or an email. If $id_or_email is an object or an array, it is assumed it contains
     * the "id" attribute or key and that is used to load the user.
     *
     * @global type $wpdb
     * @param string|int|object|array $id_or_email
     * @param type $format
     * @return boolean
     */
    function get_user($id_or_email, $format = OBJECT) {
        global $wpdb;

        // To simplify the reaload of a user passing the user it self.
        if (is_object($id_or_email))
            $id_or_email = $id_or_email->id;
        else if (is_array($id_or_email))
            $id_or_email = $id_or_email['id'];

        $id_or_email = strtolower(trim($id_or_email));

        if (is_numeric($id_or_email)) {
            $r = $wpdb->get_row($wpdb->prepare("select * from " . NEWSLETTER_USERS_TABLE . " where id=%d limit 1", $id_or_email), $format);
        } else {
            $r = $wpdb->get_row($wpdb->prepare("select * from " . NEWSLETTER_USERS_TABLE . " where email=%s limit 1", $id_or_email), $format);
        }

        if ($wpdb->last_error) {
            $this->logger->error($wpdb->last_error);
            return false;
        }
        return $r;
    }

    function get_list($id) {
        global $wpdb;
        $id = (int) $id;
        $list = get_option('newsletter_list_' . $id, array());
        $profile = get_option('newsletter_profile');
        $list['name'] = $profile['list_' . $id];
        $list['subscriber_count'] = $wpdb->get_var("select count(*) from " . NEWSLETTER_USERS_TABLE . " where status='C' and list_" . $id . "=1");
        return $list;
    }

    /**
     * NEVER CHANGE THIS METHOD SIGNATURE, USER BY THIRD PARTY PLUGINS.
     *
     * Saves a new user on the database. Return false if the email (that must be unique) is already
     * there. For a new users set the token and creation time if not passed.
     *
     * @param array|object $user
     */
    function save_user($user, $return_format = OBJECT) {
        if (is_object($user)) {
            $user = (array) $user;
        }
        if (empty($user['id'])) {
            $existing = $this->get_user($user['email']);
            if ($existing != null) {
                return false;
            }
            if (empty($user['token'])) {
                $user['token'] = NewsletterModule::get_token();
            }
            //if (empty($user['created'])) $user['created'] = time();
            // Database default
            //if (empty($user['status'])) $user['status'] = 'S';
        }
        // Due to the unique index on email field, this can fail.
        return $this->store->save(NEWSLETTER_USERS_TABLE, $user, $return_format);
    }

    function inline_css($content, $strip_style_blocks = false) {
        // CSS
        $matches = array();
        // "s" skips line breaks
        $styles = preg_match('|<style>(.*?)</style>|s', $content, $matches);
        if (isset($matches[1])) {
            $style = str_replace(array("\n", "\r"), '', $matches[1]);
            $rules = array();
            preg_match_all('|\s*\.(.*?)\{(.*?)\}\s*|s', $style, $rules);
            //print_r($rules);
            for ($i = 0; $i < count($rules[1]); $i++) {
                $class = trim($rules[1][$i]);
                $value = trim($rules[2][$i]);
                $value = preg_replace('|\s+|', ' ', $value);
                $content = str_replace('class="' . $class . '"', 'class="' . $class . '" style="' . $value . '"', $content);
            }
        }

        if ($strip_style_blocks) {
            return trim(preg_replace('|<style>.*?</style>|s', '', $content));
        } else {
            return $content;
        }
    }

    function set_user_wp_user_id($user_id, $wp_user_id) {
        $this->store->set_field(NEWSLETTER_USERS_TABLE, $user_id, 'wp_user_id', $wp_user_id);
    }

    function get_user_by_wp_user_id($wp_user_id, $format = OBJECT) {
        return $this->store->get_single_by_field(NEWSLETTER_USERS_TABLE, 'wp_user_id', $wp_user_id, $format);
    }

    public static function antibot_form_check() {
        return strtolower($_SERVER['REQUEST_METHOD']) == 'post' && isset($_POST['ts']) && time() - $_POST['ts'] < 30;
    }

    public static function request_to_antibot_form($submit_label = 'Continue...') {
        header('Content-Type: text/html;charset=UTF-8');
        header('X-Robots-Tag: noindex,nofollow,noarchive');
        header('Cache-Control: no-cache,no-store,private');
        echo "<!DOCTYPE html>\n";
        echo '<html><head></head><body>';
        echo '<form method="post" action="' . home_url('/') . '" id="form">';
        foreach ($_REQUEST as $name => $value) {
            if ($name == 'submit')
                continue;
            if (is_array($value)) {
                foreach ($value as $element) {
                    echo '<input type="hidden" name="';
                    echo esc_attr($name);
                    echo '[]" value="';
                    echo esc_attr(stripslashes($element));
                    echo '">';
                }
            } else {

                echo '<input type="hidden" name="';
                echo esc_attr($name);
                echo '" value="';
                echo esc_attr(stripslashes($value));
                echo '">';
            }
        }
        if (isset($_SERVER['HTTP_REFERER'])) {
            echo '<input type="hidden" name="nhr" value="' . esc_attr($_SERVER['HTTP_REFERER']) . '">';
        }
        echo '<input type="hidden" name="ts" value="' . time() . '">';
        echo '<noscript><input type="submit" value="';
        echo esc_attr($submit_label);
        echo '"></noscript></form>';
        echo '<script>document.getElementById("form").submit();</script>';
        echo '</body></html>';
        die();
    }

    static function extract_body($html) {
        $x = stripos($html, '<body');
        if ($x !== false) {
            $x = strpos($html, '>', $x);
            $y = strpos($html, '</body>');
            return substr($html, $x + 1, $y - $x - 1);
        } else {
            return $html;
        }
    }

    /** Returns a percentage as string */
    static function percent($value, $total) {
        if ($total == 0)
            return '-';
        return sprintf("%.2f", $value / $total * 100) . '%';
    }

    /** Returns a percentage as integer value */
    static function percentValue($value, $total) {
        if ($total == 0)
            return 0;
        return round($value / $total * 100);
    }
    
    static function to_int_id($var) {
        if (is_object($var)) return (int)$var->id;
        if (is_array($var)) return (int)$var['id'];
        return (int)$var;
    }

}

/**
 * Kept for compatibility.
 *
 * @param type $post_id
 * @param type $size
 * @param type $alternative
 * @return type
 */
function nt_post_image($post_id = null, $size = 'thumbnail', $alternative = null) {
    return NewsletterModule::get_post_image($post_id, $size, $alternative);
}

function newsletter_get_post_image($post_id = null, $size = 'thumbnail', $alternative = null) {
    echo NewsletterModule::get_post_image($post_id, $size, $alternative);
}

/**
 * Accepts a post or a post ID.
 * 
 * @param WP_Post $post
 */
function newsletter_the_excerpt($post, $words = 30) {
    $post = get_post($post);
    $excerpt = $post->post_excerpt;
    if (empty($excerpt)) {
        $excerpt = $post->post_content;
        $excerpt = strip_shortcodes($excerpt);
        $excerpt = wp_strip_all_tags($excerpt, true);
    }
    echo '<p>' . wp_trim_words($excerpt, $words) . '</p>';
}
