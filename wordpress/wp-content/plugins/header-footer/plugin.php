<?php

/*
  Plugin Name: Head, Footer and Post Injections
  Plugin URI: http://www.satollo.net/plugins/header-footer
  Description: Header and Footer lets to add html/javascript code to the head and footer and posts of your blog. Some examples are provided on the <a href="http://www.satollo.net/plugins/header-footer">official page</a>.
  Version: 3.0.7
  Author: Stefano Lissa
  Author URI: http://www.satollo.net
  Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
 */

/*
  Copyright 2008-2017 Stefano Lissa (stefano@satollo.net)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

$hefo_options = get_option('hefo', array());

$hefo_is_mobile = false;
if (defined('IS_PHONE') && IS_PHONE) {
    $hefo_is_mobile = true;
} else if (isset($_SERVER['HTTP_USER_AGENT']) && isset($hefo_options['mobile_user_agents_parsed'])) {
    $hefo_is_mobile = preg_match('/' . $hefo_options['mobile_user_agents_parsed'] . '/', strtolower($_SERVER['HTTP_USER_AGENT']));
}

if (is_admin()) {
    include dirname(__FILE__) . '/admin.php';
}

if (isset($hefo_options['disable_css_id'])) {

    function hefo_style_loader_tag($link) {
        global $hefo_options;
        $link = preg_replace("/id='.*?-css'/", "", $link);
        if (isset($hefo_options['disable_css_media'])) {
            if (!preg_match("/media='print'/", $link)) {
                $link = preg_replace("/media='.*?'/", "", $link);
            }
        }
        return $link;
    }

    add_filter('style_loader_tag', 'hefo_style_loader_tag');
}

add_action('template_redirect', 'hefo_template_redirect', 99);

$hefo_body_block = '';
$hefo_generic_block = array();

function hefo_template_redirect() {
    global $hefo_body_block, $hefo_generic_block, $hefo_options, $hefo_is_mobile;

    if ($hefo_is_mobile && isset($hefo_options['mobile_body_enabled'])) {
        $hefo_body_block = hefo_execute($hefo_options['mobile_body']);
    } else {
        $hefo_body_block = hefo_execute($hefo_options['body']);
    }
    for ($i = 1; $i < 4; $i++) {
        if ($hefo_is_mobile && isset($hefo_options['mobile_generic_enabled_' . $i])) {
            if (isset($hefo_options['mobile_generic_' . $i]))
                $hefo_generic_block[$i] = hefo_execute($hefo_options['mobile_generic_' . $i]);
        } else {
            if (isset($hefo_options['generic_' . $i]))
                $hefo_generic_block[$i] = hefo_execute($hefo_options['generic_' . $i]);
        }
    }
    ob_start('hefo_callback');
}

function hefo_callback($buffer) {
    global $hefo_body_block, $hefo_generic_block, $hefo_options, $hefo_is_mobile;

    for ($i = 1; $i < 4; $i++) {
        if (isset($hefo_options['generic_tag_' . $i]))
            hefo_insert_before($buffer, $hefo_generic_block[$i], $hefo_options['generic_tag_' . $i]);
    }
    $x = strpos($buffer, '<body');
    if ($x === false) {
        return $buffer;
    }
    $x = strpos($buffer, '>', $x);
    if ($x === false) {
        return $buffer;
    }
    $x++;
    return substr($buffer, 0, $x) . "\n" . $hefo_body_block . substr($buffer, $x);
}

add_action('wp_head', 'hefo_wp_head_pre', 1);

function hefo_wp_head_pre() {
    global $hefo_options, $wp_query;

    if (isset($hefo_options['disable_wlwmanifest_link'])) {
        remove_action('wp_head', 'wlwmanifest_link');
    }

    if (isset($hefo_options['disable_rsd_link'])) {
        remove_action('wp_head', 'rsd_link');
    }

    if (isset($hefo_options['disable_feed_links_extra'])) {
        remove_action('wp_head', 'feed_links_extra', 3);
    }

    if (isset($hefo_options['disable_wp_shortlink_wp_head'])) {
        remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
    }

    if (isset($hefo_options['disable_wp_shortlink_wp_head'])) {
        remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
    }

    if (is_home() && is_paged() && isset($hefo_options['seo_home_paged_noindex'])) {
        echo '<meta name="robots" content="noindex">';
    }

    if (is_home() && !is_paged() && isset($hefo_options['seo_home_canonical'])) {
        echo '<meta name="canonical" content="' . get_option('home') . '">';
    }

    if (is_archive() && is_paged() && isset($hefo_options['seo_archives_paged_noindex'])) {
        echo '<meta name="robots" content="noindex">';
    }

    if (is_search() && isset($hefo_options['seo_search_noindex'])) {
        echo '<meta name="robots" content="noindex">';
    }
}

add_action('wp_head', 'hefo_wp_head_post', 11);

function hefo_wp_head_post() {
    global $hefo_options, $wp_query, $wpdb;
    $buffer = '';
    if (is_front_page()) {
        $buffer .= hefo_replace($hefo_options['head_home']);
    }

    $buffer .= hefo_replace($hefo_options['head']);

    if (apply_filters('hefo_php_exec', true)) {
        ob_start();
        eval('?>' . $buffer);
        ob_end_flush();
    } else {
        echo $buffer;
    }
}

add_action('amp_post_template_head', 'hefo_amp_post_template_head', 100);

function hefo_amp_post_template_head() {
    global $hefo_options;
    echo hefo_execute($hefo_options['amp_head']);
}

add_action('amp_post_template_css', 'hefo_amp_post_template_css', 100);

function hefo_amp_post_template_css() {
    global $hefo_options;
    echo "\n";
    echo hefo_execute($hefo_options['amp_css']);
    echo "\n";
}

add_action('amp_post_template_footer', 'hefo_amp_post_template_footer', 100);

function hefo_amp_post_template_footer() {
    global $hefo_options;
    echo "\n";
    echo hefo_execute($hefo_options['amp_footer']);
    echo "\n";
}

add_action('wp_footer', 'hefo_wp_footer');

function hefo_wp_footer() {
    global $hefo_options, $hefo_is_mobile;

    if ($hefo_is_mobile && isset($hefo_options['mobile_footer_enabled'])) {
        $buffer = $hefo_options['mobile_footer'];
    } else {
        $buffer = $hefo_options['footer'];
    }

    $buffer = hefo_replace($buffer);

    if (apply_filters('hefo_php_exec', true)) {
        ob_start();
        eval('?>' . $buffer);
        ob_end_flush();
    } else {
        echo $buffer;
    }
}

// BBPRESS
$bbp_reply_count = 0;

add_action('bbp_theme_before_reply_content', 'hefo_bbp_theme_before_reply_content');

function hefo_bbp_theme_before_reply_content() {
    global $hefo_options, $hefo_is_mobile, $wpdb, $post, $bbp_reply_count;
    $bbp_reply_count++;
    if ($hefo_is_mobile && isset($hefo_options['mobile_bbp_theme_before_reply_content_enabled'])) {
        echo hefo_execute(hefo_replace($hefo_options['mobile_bbp_theme_before_reply_content']));
    } else {
        echo hefo_execute(hefo_replace($hefo_options['bbp_theme_before_reply_content']));
    }
}

add_action('bbp_theme_after_reply_content', 'hefo_bbp_theme_after_reply_content');

function hefo_bbp_theme_after_reply_content() {
    global $hefo_options, $hefo_is_mobile, $wpdb, $post, $bbp_reply_count;

    if ($hefo_is_mobile && isset($hefo_options['mobile_bbp_theme_after_reply_content_enabled'])) {
        echo hefo_execute(hefo_replace($hefo_options['mobile_bbp_theme_after_reply_content']));
    } else {
        echo hefo_execute(hefo_replace($hefo_options['bbp_theme_after_reply_content']));
    }
}

add_action('bbp_template_before_single_forum', 'hefo_bbp_template_before_single_forum');

function hefo_bbp_template_before_single_forum() {
    global $hefo_options, $hefo_is_mobile, $wpdb, $post;

    if ($hefo_is_mobile && isset($hefo_options['mobile_bbp_template_before_single_forum_enabled'])) {
        echo hefo_execute(hefo_replace($hefo_options['mobile_bbp_template_before_single_forum']));
    } else {
        echo hefo_execute(hefo_replace($hefo_options['bbp_template_before_single_forum']));
    }
}

add_action('bbp_template_before_single_topic', 'hefo_bbp_template_before_single_topic');

function hefo_bbp_template_before_single_topic() {
    global $hefo_options, $hefo_is_mobile, $wpdb, $post;

    if ($hefo_is_mobile && isset($hefo_options['mobile_bbp_template_after_before_topic_enabled'])) {
        echo hefo_execute(hefo_replace($hefo_options['mobile_bbp_template_before_single_topic']));
    } else {
        echo hefo_execute(hefo_replace($hefo_options['bbp_template_after_before_topic']));
    }
}

add_action('bbp_template_after_single_topic', 'hefo_bbp_template_after_single_topic');

function hefo_bbp_template_after_single_topic() {
    global $hefo_options, $hefo_is_mobile, $wpdb, $post;

    if ($hefo_is_mobile && isset($hefo_options['mobile_bbp_template_after_single_topic_enabled'])) {
        echo hefo_execute(hefo_replace($hefo_options['mobile_bbp_template_after_single_topic']));
    } else {
        echo hefo_execute(hefo_replace($hefo_options['bbp_template_after_single_topic']));
    }
}

add_action('the_content', 'hefo_the_content');

global $hefo_page_top, $hefo_page_bottom, $hefo_post_top, $hefo_post_bottom;
$hefo_page_top = true;
$hefo_page_bottom = true;
$hefo_post_top = true;
$hefo_post_bottom = true;

function hefo_the_content($content) {
    global $hefo_options, $wpdb, $post, $hefo_page_top, $hefo_page_bottom, $hefo_post_top, $hefo_post_bottom, $hefo_is_mobile;

    $before = '';
    $after = '';

    // AMP detection
    if (function_exists('is_amp_endpoint') && is_amp_endpoint()) {
        $before = hefo_execute($hefo_options['amp_post_before']);
        $after = hefo_execute($hefo_options['amp_post_after']);
        return $before . $content . $after;
    }

    //if (is_singular() || ($hefo_options['category'] && (is_category() || is_tag()))) {
    if (is_singular()) {
        //if (!empty($hefo_options[$post->post_type . '_before'])) {
        //    echo $hefo_options[$post->post_type . '_before'];
        //}
        if (is_page() && !isset($hefo_options['page_use_post'])) {
            if ($hefo_page_top) {
                $value = get_post_meta($post->ID, 'hefo_before', true);
                if ($value != '1') {
                    if (isset($hefo_options['mobile_page_before_enabled']) && $hefo_is_mobile) {
                        $before = hefo_execute(hefo_replace($hefo_options['mobile_page_before']));
                    } else {
                        $before = hefo_execute(hefo_replace($hefo_options['page_before']));
                    }
                }
            }
            if ($hefo_page_bottom) {
                $value = get_post_meta($post->ID, 'hefo_after', true);
                if ($value != '1') {
                    if (isset($hefo_options['mobile_page_after_enabled']) && $hefo_is_mobile) {
                        $after = hefo_execute(hefo_replace($hefo_options['mobile_page_after']));
                    } else {
                        $after = hefo_execute(hefo_replace($hefo_options['page_after']));
                    }
                }
            }
        } else {
            if ($hefo_post_top) {
                $value = get_post_meta($post->ID, 'hefo_before', true);
                if ($value != '1') {
                    if (isset($hefo_options['mobile_before_enabled']) && $hefo_is_mobile) {
                        $before = hefo_execute(hefo_replace($hefo_options['mobile_before']));
                    } else {
                        $before = hefo_execute(hefo_replace($hefo_options['before']));
                    }
                }
            }
            if ($hefo_post_bottom) {
                $value = get_post_meta($post->ID, 'hefo_after', true);
                if ($value != '1') {
                    if (isset($hefo_options['mobile_after_enabled']) && $hefo_is_mobile) {
                        $after = hefo_execute(hefo_replace($hefo_options['mobile_after']));
                    } else {
                        $after = hefo_execute(hefo_replace($hefo_options['after']));
                    }
                }
            }
        }

        // Rules



        for ($i = 1; $i < 4; $i++) {
            if (empty($hefo_options['inner_tag_' . $i])) {
                continue;
            }
            $prefix = '';
            if ($hefo_is_mobile && isset($hefo_options['mobile_inner_enabled_' . $i])) {
                $prefix = 'mobile_';
            }
            $skip = trim($hefo_options['inner_skip_' . $i]);
            if (empty($skip))
                $skip = 0;
            else if (substr($skip, -1) == '%') {
                $skip = (intval($skip) * strlen($content) / 100);
            }

            if ($hefo_options['inner_pos_' . $i] == 'after') {
                $res = hefo_insert_after($content, hefo_execute($hefo_options[$prefix . 'inner_' . $i]), $hefo_options['inner_tag_' . $i], $skip);
            } else {
                $res = hefo_insert_before($content, hefo_execute($hefo_options[$prefix . 'inner_' . $i]), $hefo_options['inner_tag_' . $i], $skip);
            }
            if (!$res) {
                switch ($hefo_options['inner_alt_' . $i]) {
                    case 'after':
                        $content = $content . hefo_execute($hefo_options[$prefix . 'inner_' . $i]);
                        break;
                    case 'before':
                        $content = hefo_execute($hefo_options[$prefix . 'inner_' . $i]) . $content;
                }
            }
        }

        return $before . $content . $after;
    } else {
        return $content;
    }
}

function hefo_insert_before(&$content, $what, $marker, $starting_from = 0) {
    if (strlen($content) < $starting_from) {
        return false;
    }

    if (empty($marker)) {
        $marker = ' ';
    }
    $x = strpos($content, $marker, $starting_from);
    if ($x !== false) {
        $content = substr_replace($content, $what, $x, 0);
        return true;
    }
    return false;
}

function hefo_insert_after(&$content, $what, $marker, $starting_from = 0) {

    if (strlen($content) < $starting_from) {
        return false;
    }

    if (empty($marker)) {
        $marker = ' ';
    }

    $x = strpos($content, $marker, $starting_from);

    if ($x !== false) {
        $content = substr_replace($content, $what, $x + strlen($marker), 0);
        return true;
    }
    return false;
}

add_action('the_excerpt', 'hefo_the_excerpt');
global $hefo_count;
$hefo_count = 0;

function hefo_the_excerpt($content) {
    global $hefo_options, $post, $wpdb, $hefo_count;
    $hefo_count++;
    if (is_category() || is_tag()) {
        $before = hefo_execute(hefo_replace($hefo_options['excerpt_before']));
        $after = hefo_execute(hefo_replace($hefo_options['excerpt_after']));

        return $before . $content . $after;
    } else {
        return $content;
    }
}

function hefo_replace($buffer) {
    global $hefo_options, $post;

    if (empty($buffer)) {
        return '';
    }

    for ($i = 1; $i <= 5; $i++) {
        if (!isset($hefo_options['snippet_' . $i]))
            $hefo_options['snippet_' . $i] = '';
        $buffer = str_replace('[snippet_' . $i . ']', $hefo_options['snippet_' . $i], $buffer);
    }

    // For 404 pages and maybe others...
    if (!is_object($post)) {
        return $buffer;
    }

    $images_url = plugins_url('images', 'header-footer/plugin.php');
    $permalink = urlencode(get_permalink());
    $title = urlencode($post->post_title);
    $buffer = str_replace('[images_url]', $images_url, $buffer);

    $facebook_url = 'https://www.facebook.com/sharer/sharer.php?u=' . $permalink;
    $buffer = str_replace('[facebook_share_url]', $facebook_url, $buffer);

    // Twitter
    $twitter_url = 'http://twitter.com/intent/tweet?text=' . $title;
    $twitter_url .= '&url=' . $permalink;
    $buffer = str_replace('[twitter_share_url]', $twitter_url, $buffer);

    // Google
    $google_url = 'https://plus.google.com/share?url=' . $permalink;
    $buffer = str_replace('[google_share_url]', $google_url, $buffer);

    // Pinterest
    $pinterest_url = 'http://www.pinterest.com/pin/create/button/?url=' . $permalink;
    $image_id = function_exists('get_post_thumbnail_id') ? get_post_thumbnail_id($post->ID) : false;
    if ($image_id) {
        $image = wp_get_attachment_image_src($image_id, 'full');
        $pinterest_url .= '&media=' . urlencode($image[0]);
    }
    $pinterest_url .= '&description=' . $title;
    $buffer = str_replace('[pinterest_share_url]', $pinterest_url, $buffer);

    $linkedin_url = 'http://www.linkedin.com/shareArticle?mini=true&url=' . $permalink;
    $linkedin_url .= '&title=' . $title . '&source=' . urlencode(get_option('blogname'));
    $buffer = str_replace('[linkedin_share_url]', $linkedin_url, $buffer);

    return $buffer;
}

function hefo_execute($buffer) {
    global $post;
    if (empty($buffer)) {
        return '';
    }
    if (apply_filters('hefo_php_exec', true)) {
        ob_start();
        eval('?>' . $buffer);
        $buffer = ob_get_clean();
    }
    return $buffer;
}
