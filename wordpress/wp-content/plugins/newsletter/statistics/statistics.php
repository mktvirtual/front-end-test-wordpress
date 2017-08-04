<?php

if (!defined('ABSPATH'))
    exit;

require_once NEWSLETTER_INCLUDES_DIR . '/module.php';

class NewsletterStatistics extends NewsletterModule {

    static $instance;

    /**
     * @return NewsletterStatistics
     */
    static function instance() {
        if (self::$instance == null) {
            self::$instance = new NewsletterStatistics();
        }
        return self::$instance;
    }

    function __construct() {
        parent::__construct('statistics', '1.1.6');
        add_action('wp_loaded', array($this, 'hook_wp_loaded'));
        if (is_admin()) {
            add_action('admin_enqueue_scripts', array($this, 'hook_admin_enqueue_scripts'));
        }
    }
    
    function hook_admin_enqueue_scripts() {
        if (isset($_GET['page']) && (strpos($_GET['page'], 'newsletter_statistics') === 0 || strpos($_GET['page'], 'newsletter_reports') === 0)) {
            wp_enqueue_style('newsletter-admin-statistics', plugins_url('newsletter') . '/statistics/css/tnp-statistics.css', array('tnp-admin'), time());
        }
    }

    /**
     * 
     * @global wpdb $wpdb
     */
    function hook_wp_loaded() {
        global $wpdb;

        // Newsletter Link Tracking
        if (isset($_GET['nltr'])) {

            // Patch for links with ;
            $parts = explode(';', base64_decode($_GET['nltr']));
            $email_id = (int) array_shift($parts);
            $user_id = (int) array_shift($parts);
            $signature = array_pop($parts);
            $anchor = array_pop($parts); // No more used
            // The remaining elements are the url splitted when it contains
            $url = implode(';', $parts);

            //list($email_id, $user_id, $url, $anchor, $signature) = explode(';', base64_decode($_GET['nltr']), 5);
            //$url = esc_url_raw($url);
            //$user_id = (int) $user_id;
            //$email_id = (int) $email_id;

            if (empty($user_id) || empty($url)) {
                header("HTTP/1.0 404 Not Found");
                die('Invalid data');
            }

            $parts = parse_url($url);

            $verified = $parts['host'] == $_SERVER['HTTP_HOST'];
            if (!$verified) {
                $verified = $signature == md5($email_id . ';' . $user_id . ';' . $url . ';' . $anchor . $this->options['key']);
            }

            if (!$verified) {
                header("HTTP/1.0 404 Not Found");
                die('Url not verified');
            }

            $user = Newsletter::instance()->get_user($user_id);
            if (!$user) {
                header("HTTP/1.0 404 Not Found");
                die('Invalid subscriber');
            }

            // Test emails
            if (empty($email_id)) {
                header('Location: ' . esc_url_raw($url));
                die();
            }

            $email = $this->get_email($email_id);
            if (!$email) {
                header("HTTP/1.0 404 Not Found");
                die('Invalid newsletter');
            }

            setcookie('newsletter', $user->id . '-' . $user->token, time() + 60 * 60 * 24 * 365, '/');

            $ip = preg_replace('/[^0-9a-fA-F:., ]/', '', $_SERVER['REMOTE_ADDR']);

            $wpdb->insert(NEWSLETTER_STATS_TABLE, array(
                'email_id' => $email_id,
                'user_id' => $user_id,
                'url' => $url,
                'ip' => $ip
                    )
            );

            $wpdb->query($wpdb->prepare("update " . NEWSLETTER_SENT_TABLE . " set open=2, ip=%s where email_id=%d and user_id=%d limit 1", $ip, $email_id, $user_id));

            header('Location: ' . apply_filters('newsletter_redirect_url', $url, $email, $user));
            die();
        }

        // Newsletter Open Traking Image
        if (isset($_GET['noti'])) {
            $this->logger->debug('Open tracking: ' . $_GET['noti']);

            list($email_id, $user_id, $signature) = explode(';', base64_decode($_GET['noti']), 3);

            $email = $this->get_email($email_id);
            if (!$email) {
                $this->logger->error('Open tracking request for unexistant email');
                die();
            }

            $user = $this->get_user($user_id);
            if (!$user) {
                $this->logger->error('Open tracking request for unexistant subscriber');
                die();
            }

            if ($email->token) {
                $this->logger->debug('Signature: ' . $signature);
                $s = md5($email_id . $user_id . $email->token);
                if ($s != $signature) {
                    $this->logger->error('Open tracking request with wrong signature. Email token: ' . $email->token);
                    die();
                }
            } else {
                $this->logger->info('Email with no token hence not signature to check');
            }

            $row = $wpdb->get_row($wpdb->prepare("select * from " . NEWSLETTER_STATS_TABLE . " where email_id=%d and user_id=%d and url='' limit 1", $email->id, $user->id));
            if ($row) {
                $this->logger->info('Open already registered');
                // MAybe an update for some fields?
            } else {

                $res = $wpdb->insert(NEWSLETTER_STATS_TABLE, array(
                    'email_id' => (int) $email_id,
                    'user_id' => (int) $user_id,
                    'ip' => $_SERVER['REMOTE_ADDR'])
                );
                if (!$res) {
                    $this->logger->fatal($wpdb->last_error);
                }
            }

            header('Content-Type: image/gif');
            echo base64_decode('_R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');
            die();
        }
    }

    function upgrade() {
        global $wpdb, $charset_collate;

        parent::upgrade();

        // This before table creation or update for compatibility
        $this->upgrade_query("alter table {$wpdb->prefix}newsletter_stats change column newsletter_id user_id int not null default 0");
        $this->upgrade_query("alter table {$wpdb->prefix}newsletter_stats change column newsletter_id user_id int not null default 0");
        $this->upgrade_query("alter table {$wpdb->prefix}newsletter_stats change column date created timestamp not null default current_timestamp");

        // Just for test since it will be part of statistics module
        // This table stores clicks and email opens. An open is registered with a empty url.
        $this->upgrade_query("create table if not exists {$wpdb->prefix}newsletter_stats (id int auto_increment, primary key (id)) $charset_collate");

        // References
        $this->upgrade_query("alter table {$wpdb->prefix}newsletter_stats add column user_id int not null default 0");
        $this->upgrade_query("alter table {$wpdb->prefix}newsletter_stats add column email_id int not null default 0");
        // Future... see the links table
        $this->upgrade_query("alter table {$wpdb->prefix}newsletter_stats add column link_id int not null default 0");

        $this->upgrade_query("alter table {$wpdb->prefix}newsletter_stats add column created timestamp not null default current_timestamp");
        $this->upgrade_query("alter table {$wpdb->prefix}newsletter_stats add column url varchar(255) not null default ''");
        $this->upgrade_query("alter table {$wpdb->prefix}newsletter_stats add column anchor varchar(200) not null default ''");
        $this->upgrade_query("alter table {$wpdb->prefix}newsletter_stats add column ip varchar(20) not null default ''");
        $this->upgrade_query("alter table {$wpdb->prefix}newsletter_stats add column country varchar(4) not null default ''");

        $this->upgrade_query("ALTER TABLE `{$wpdb->prefix}newsletter_stats` ADD INDEX `email_id` (`email_id`)");
        $this->upgrade_query("ALTER TABLE `{$wpdb->prefix}newsletter_stats` ADD INDEX `user_id` (`user_id`)");

        if (empty($this->options['key'])) {
            $this->options['key'] = md5($_SERVER['REMOTE_ADDR'] . rand(100000, 999999) . time());
            $this->save_options($this->options);
        }

        $this->upgrade_query("ALTER TABLE `{$wpdb->prefix}newsletter_emails` ADD COLUMN `open_count` int UNSIGNED NOT NULL DEFAULT 0");
        $this->upgrade_query("ALTER TABLE `{$wpdb->prefix}newsletter_emails` ADD COLUMN `click_count`  int UNSIGNED NOT NULL DEFAULT 0");
        $this->upgrade_query("alter table {$wpdb->prefix}newsletter_emails change column read_count open_count int not null default 0");
    }

    function admin_menu() {
        $this->add_admin_page('index', 'Statistics');
        $this->add_admin_page('view', 'Statistics');
        $this->add_admin_page('newsletters', 'Statistics');
        $this->add_admin_page('settings', 'Statistics');
        $this->add_admin_page('view_retarget', 'Statistics');
        $this->add_admin_page('view_urls', 'Statistics');
        $this->add_admin_page('view_users', 'Statistics');
    }

    function relink($text, $email_id, $user_id, $email_token = '') {
        $this->relink_email_id = $email_id;
        $this->relink_user_id = $user_id;
        $this->relink_email_token = $email_token;

        $this->logger->debug('Relink with token: ' . $email_token);
        $text = preg_replace_callback('/(<[aA][^>]+href[\s]*=[\s]*["\'])([^>"\']+)(["\'][^>]*>)(.*?)(<\/[Aa]>)/s', array($this, 'relink_callback'), $text);

        $signature = md5($email_id . $user_id . $email_token);
        $text = str_replace('</body>', '<img width="1" height="1" alt="" src="' . home_url('/') . '?noti=' . urlencode(base64_encode($email_id . ';' . $user_id . ';' . $signature)) . '"/></body>', $text);
        return $text;
    }

    function relink_callback($matches) {
        $href = trim(str_replace('&amp;', '&', $matches[2]));

        // Do not replace the tracking or subscription/unsubscription links.
        if (strpos($href, '/newsletter/') !== false) {
            return $matches[0];
        }

        if (strpos($href, '?na=') !== false) {
            return $matches[0];
        }

        // Do not relink anchors
        if (substr($href, 0, 1) == '#') {
            return $matches[0];
        }
        // Do not relink mailto:
        if (substr($href, 0, 7) == 'mailto:') {
            return $matches[0];
        }

        // This is the link text which is added to the tracking data
        $anchor = '';
//        if ($this->options['anchor'] == 1) {
//            $anchor = trim(str_replace(';', ' ', $matches[4]));
//            // Keep images but not other tags
//            $anchor = strip_tags($anchor, '<img>');
//
//            // Truncate if needed to avoid to much long URLs
//            if (stripos($anchor, '<img') === false && strlen($anchor) > 100) {
//                $anchor = substr($anchor, 0, 100);
//            }
//        }
        $r = $this->relink_email_id . ';' . $this->relink_user_id . ';' . $href . ';' . $anchor;
        $r = $r . ';' . md5($r . $this->options['key']);
        $r = base64_encode($r);
        $r = urlencode($r);

        $url = home_url('/') . '?nltr=' . $r;

        return $matches[1] . $url . $matches[3] . $matches[4] . $matches[5];
    }

    function get_statistics_url($email_id) {
        $page = apply_filters('newsletter_statistics_view', 'newsletter_statistics_view');
        return 'admin.php?page=' . $page . '&amp;id=' . $email_id;
    }

    function maybe_fix_sent_stats($email) {
        global $wpdb;

        // Very old emails was missing the send_on
        if ($email->send_on == 0) {
            $wpdb->query($wpdb->prepare("update " . NEWSLETTER_EMAILS_TABLE . " set send_on=unix_timestamp(created) where id=%d limit 1", $email->id));
            $email = $this->get_email($email->id);
        }
        
        if ($email->status == 'sending') {
            return;
        }

        $count = $wpdb->get_var($wpdb->prepare("select count(*) from " . NEWSLETTER_SENT_TABLE . " where email_id=%d", $email->id));

        if ($count) {
            return;
        }

        if (empty($email->query)) {
            $email->query = "select * from " . NEWSLETTER_USERS_TABLE . " where status='C'";
        }

        $query = $email->query . " and unix_timestamp(created)<" . $email->send_on;

        $query = str_replace('*', 'id, ' . $email->id . ', ' . $email->send_on, $query);
        $wpdb->query("insert ignore into " . NEWSLETTER_SENT_TABLE . " (user_id, email_id, time) " . $query);
    }

    function update_stats($email) {
        global $wpdb;

        $wpdb->query($wpdb->prepare("update " . $wpdb->prefix . "newsletter_sent s1 join " . $wpdb->prefix . "newsletter_stats s2 on s1.user_id=s2.user_id and s1.email_id=s2.email_id and s1.email_id=%d set s1.open=1, s1.ip=s2.ip", $email->id));
        $wpdb->query($wpdb->prepare("update " . $wpdb->prefix . "newsletter_sent s1 join " . $wpdb->prefix . "newsletter_stats s2 on s1.user_id=s2.user_id and s1.email_id=s2.email_id and s2.url<>'' and s1.email_id=%d set s1.open=2, s1.ip=s2.ip", $email->id));
    }
    
    function get_total_count($email_id) {
        global $wpdb;
        return (int)$wpdb->get_var($wpdb->prepare("select count(*) from " . NEWSLETTER_SENT_TABLE . " where email_id=%d", $this->to_int_id($email_id)));
    }
    
    function get_open_count($email_id) {
        global $wpdb;

        return (int) $wpdb->get_var($wpdb->prepare("select count(*) from " . NEWSLETTER_SENT_TABLE . " where open>0 and email_id=%d", $this->to_int_id($email_id)));
       
    }

    function get_click_count($email_id) {
        global $wpdb;
        return (int) $wpdb->get_var($wpdb->prepare("select count(*) from " . NEWSLETTER_SENT_TABLE . " where open>1 and email_id=%d", $this->to_int_id($email_id)));
    }
    
    function get_error_count($email_id) {
        global $wpdb;
        return (int) $wpdb->get_var($wpdb->prepare("select count(*) from " . NEWSLETTER_SENT_TABLE . " where status>0 and email_id=%d", $this->to_int_id($email_id)));
    }    

}

NewsletterStatistics::instance();

