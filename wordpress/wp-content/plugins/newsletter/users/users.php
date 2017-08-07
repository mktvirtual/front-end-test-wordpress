<?php

if (!defined('ABSPATH'))
    exit;

require_once NEWSLETTER_INCLUDES_DIR . '/module.php';

class NewsletterUsers extends NewsletterModule {

    static $instance;

    /**
     * @return NewsletterUsers
     */
    static function instance() {
        if (self::$instance == null) {
            self::$instance = new NewsletterUsers();
        }
        return self::$instance;
    }

    function __construct() {
        parent::__construct('users', '1.0.9');
        add_action('init', array($this, 'hook_init'));
    }

    function hook_init() {
        if (is_admin()) {
            add_action('wp_ajax_newsletter_users_export', array($this, 'hook_wp_ajax_newsletter_users_export'));
        }
    }

    function hook_wp_ajax_newsletter_users_export() {
        require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
        $controls = new NewsletterControls();
        if (current_user_can('manage_options') || ($newsletter->options['editor'] == 1 && current_user_can('manage_categories'))) {
            $controls = new NewsletterControls();

            if ($controls->is_action('export')) {
                NewsletterUsers::instance()->export($controls->data);
            }
        } else {
            die('Not allowed.');
        }
    }

    function upgrade() {
        global $wpdb, $charset_collate;

        parent::upgrade();

        $sql = "CREATE TABLE `" . $wpdb->prefix . "newsletter` (
  `name` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `token` varchar(50) NOT NULL DEFAULT '',
  `status` varchar(1) NOT NULL DEFAULT 'S',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `list` int(11) NOT NULL DEFAULT '0',
  `profile` mediumtext,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `followup_step` tinyint(4) NOT NULL DEFAULT '0',
  `followup_time` bigint(20) NOT NULL DEFAULT '0',
  `followup` tinyint(4) NOT NULL DEFAULT '0',
  `surname` varchar(100) NOT NULL DEFAULT '',
  `sex` char(1) NOT NULL DEFAULT 'n',
  `feed_time` bigint(20) NOT NULL DEFAULT '0',
  `feed` tinyint(4) NOT NULL DEFAULT '0',
  `referrer` varchar(50) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `wp_user_id` int(11) NOT NULL DEFAULT '0',
  `http_referer` varchar(255) NOT NULL DEFAULT '',
  `country` varchar(4) NOT NULL DEFAULT '',
  `region` varchar(100) NOT NULL DEFAULT '',
  `city` varchar(100) NOT NULL DEFAULT '',
  `unsub_email_id` int(11) NOT NULL DEFAULT '0',
  `unsub_time` int(11) NOT NULL DEFAULT '0',\n";

        for ($i = 1; $i <= NEWSLETTER_LIST_MAX; $i++) {
            $sql .= "`list_$i` tinyint(4) NOT NULL DEFAULT '0',\n";
        }

        for ($i = 1; $i <= NEWSLETTER_PROFILE_MAX; $i++) {
            $sql .= "`profile_$i` varchar(255) NOT NULL DEFAULT '',\n";
        }
        // Leave as last
        $sql .= "`test` tinyint(4) NOT NULL DEFAULT '0',\n";
        $sql .= "PRIMARY KEY (`id`), UNIQUE KEY `email` (`email`)) ENGINE=MyISAM $charset_collate;";

        dbDelta($sql);
        $this->upgrade_query("alter table " . NEWSLETTER_USERS_TABLE . " convert to character set $charset_collate");
    }

    function admin_menu() {
        $this->add_menu_page('index', 'Subscribers');
        $this->add_admin_page('new', 'New subscriber');
        $this->add_admin_page('edit', 'Subscribers Edit');
        $this->add_admin_page('massive', 'Massive Management');
        $this->add_admin_page('export', 'Export');
        $this->add_admin_page('import', 'Import');
        $this->add_admin_page('statistics', 'Statistics');
    }

    function export($options = null) {
        global $wpdb;

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="newsletter-subscribers.csv"');

        // BOM
        echo "\xEF\xBB\xBF";

        $sep = ';';
        if ($options) {
            $sep = $options['separator'];
        }
        if ($sep == 'tab') {
            $sep = "\t";
        }

        // CSV header
        echo '"Email"' . $sep . '"Name"' . $sep . '"Surname"' . $sep . '"Sex"' . $sep . '"Status"' . $sep . '"Date"' . $sep . '"Token"' . $sep;

        // In table profiles
        for ($i = 1; $i <= NEWSLETTER_PROFILE_MAX; $i++) {
            echo '"Profile ' . $i . '"' . $sep; // To adjust with field name
        }

        // Lists
        for ($i = 1; $i <= NEWSLETTER_LIST_MAX; $i++) {
            echo '"List ' . $i . '"' . $sep;
        }

        echo '"Feed by mail"' . $sep . '"Follow up"' . $sep;
        echo '"IP"' . $sep . '"Referrer"' . $sep . '"Country"';

        echo "\n";

        $page = 0;
        while (true) {
            $query = "select * from " . NEWSLETTER_USERS_TABLE . "";
            $list = (int) $_POST['options']['list'];
            if (!empty($list)) {
                $query .= " where list_" . $list . "=1";
            }
            $recipients = $wpdb->get_results($query . " order by email limit " . $page * 500 . ",500");
            for ($i = 0; $i < count($recipients); $i++) {
                echo '"' . $recipients[$i]->email . '"' . $sep . '"' . $this->sanitize_csv($recipients[$i]->name) .
                '"' . $sep . '"' . $this->sanitize_csv($recipients[$i]->surname) .
                '"' . $sep . '"' . $recipients[$i]->sex .
                '"' . $sep . '"' . $recipients[$i]->status . '"' . $sep . '"' . $recipients[$i]->created . '"' . $sep . '"' . $recipients[$i]->token . '"' . $sep;

                for ($j = 1; $j <= NEWSLETTER_PROFILE_MAX; $j++) {
                    $column = 'profile_' . $j;
                    echo '"' . $this->sanitize_csv($recipients[$i]->$column) . '"' . $sep;
                }

                for ($j = 1; $j <= NEWSLETTER_LIST_MAX; $j++) {
                    $list = 'list_' . $j;
                    echo '"' . $recipients[$i]->$list . '"' . $sep;
                }

                echo '"' . $recipients[$i]->feed . '"' . $sep;
                echo '"' . $recipients[$i]->followup . '"' . $sep;
                echo '"' . $recipients[$i]->ip . '"' . $sep;
                echo '"' . $recipients[$i]->referrer . '"' . $sep;
                echo '"' . $recipients[$i]->country . '"' . $sep;

                echo "\n";
                flush();
            }
            if (count($recipients) < 500)
                break;
            $page++;
        }
        die();
    }

    function sanitize_csv($text) {
        $text = str_replace('"', "'", $text);
        $text = str_replace("\n", ' ', $text);
        $text = str_replace("\r", ' ', $text);
        $text = str_replace(";", ' ', $text);
        return $text;
    }

    /**
     * Returns a list of users marked as "test user".
     * @global Newsletter $newsletter
     * @return array
     */
    function get_test_users() {
        $newsletter = Newsletter::instance();
        return $newsletter->get_test_users();
    }

    /**
     * @global Newsletter $newsletter
     */
    function delete_user($id) {
        $newsletter = Newsletter::instance();
        return $newsletter->delete_user($id);
    }

    /**
     *
     * @global Newsletter $newsletter
     * @param int|string $id_or_email
     * @param string $status
     * @return boolean
     */
    function set_user_status($id_or_email, $status) {
        $newsletter = Newsletter::instance();
        return $newsletter->set_user_status($id_or_email, $status);
    }

    function set_user_field($id, $field, $value) {
        $this->store->set_field(NEWSLETTER_USERS_TABLE, $id, $field, $value);
    }

}

NewsletterUsers::instance();
