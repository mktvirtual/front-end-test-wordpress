<?php
/*
  Plugin Name: Google Maps Bank
  Plugin URI: http://beta.tech-banker.com
  Description: Google Maps provides directions, locations, markers, interactive maps, and satellite/aerial imagery of anything. It's more than just a Map.
  Author: Tech Banker
  Author URI: http://beta.tech-banker.com
  Version: 2.0.6
  License: GPLv3
  Text Domain: google-maps-bank
  Domain Path: /languages
 */

if (!defined("ABSPATH")) {
   exit;
} // Exit if accessed directly
/* Constant Declaration */

if (!defined("GOOGLE_MAP_DIR_PATH")) {
   define("GOOGLE_MAP_DIR_PATH", plugin_dir_path(__FILE__));
}
if (!defined("GOOGLE_MAP_PLUGIN_DIRNAME")) {
   define("GOOGLE_MAP_PLUGIN_DIRNAME", plugin_basename(dirname(__FILE__)));
}
if (!defined("GOOGLE_MAP_CUSTOM_MARKER_ICON")) {
   define("GOOGLE_MAP_CUSTOM_MARKER_ICON", plugins_url(plugin_basename(dirname(__FILE__)) . "/assets/images/map-icons"));
}
if (!defined("GOOGLE_MAP_DEFAULT_MARKER_ICON")) {
   define("GOOGLE_MAP_DEFAULT_MARKER_ICON", plugins_url(plugin_basename(dirname(__FILE__)) . "/assets/global/img/marker-logo.png"));
}
if (is_ssl()) {
   if (!defined("tech_banker_url")) {
      define("tech_banker_url", "https://tech-banker.com");
   }
   if (!defined("tech_banker_beta_url")) {
      define("tech_banker_beta_url", "https://beta.tech-banker.com");
   }
   if (!defined("tech_banker_services_url")) {
      define("tech_banker_services_url", "https://tech-banker-services.org");
   }
} else {
   if (!defined("tech_banker_url")) {
      define("tech_banker_url", "http://tech-banker.com");
   }
   if (!defined("tech_banker_beta_url")) {
      define("tech_banker_beta_url", "http://beta.tech-banker.com");
   }
   if (!defined("tech_banker_services_url")) {
      define("tech_banker_services_url", "http://tech-banker-services.org");
   }
}
if (!defined("tech_banker_stats_url")) {
   define("tech_banker_stats_url", "http://stats.tech-banker-services.org");
}
if (!defined("google_maps_version_number")) {
   define("google_maps_version_number", "2.0.6");
}

$memory_limit_google_map = intval(ini_get("memory_limit"));
if (!extension_loaded('suhosin') && $memory_limit_google_map < 512) {
   @ini_set("memory_limit", "512M");
}
@ini_set("max_execution_time", 6000);

/*
  Function Name: install_script_for_google_map
  Parameters: No
  Description: This function is used to create Tables in Database.
  Created On: 28-01-2017 10:15
  Created By: Tech Banker Team
 */
function install_script_for_google_map() {
   global $wpdb;
   if (is_multisite()) {
      $blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
      foreach ($blog_ids as $blog_id) {
         switch_to_blog($blog_id);
         $version = get_option("google-maps-bank-version-number");
         if ($version < "2.0.0") {
            if (file_exists(GOOGLE_MAP_DIR_PATH . "lib/install-script.php")) {
               include GOOGLE_MAP_DIR_PATH . "lib/install-script.php";
            }
         }
         restore_current_blog();
      }
   } else {
      $version = get_option("google-maps-bank-version-number");
      if ($version < "2.0.0") {
         if (file_exists(GOOGLE_MAP_DIR_PATH . "lib/install-script.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "lib/install-script.php";
         }
      }
   }
}
/*
  Function Name: google_maps
  Parameters: No
  Description: This function is used to return Parent Table name with prefix.
  Created On: 28-01-2017 10:19
  Created By: Tech Banker Team
 */
function google_maps() {
   global $wpdb;
   return $wpdb->prefix . "google_maps";
}
/*
  Function Name: google_maps_meta
  Parameters: No
  Description: This function is used to return Meta Table name with prefix.
  Created On: 28-01-2017 10:25
  Created By: Tech Banker Team
 */
function google_maps_meta() {
   global $wpdb;
   return $wpdb->prefix . "google_maps_meta";
}
/*
  Function Name: get_others_capabilities_google_maps
  Parameters: No
  Description: This function is used to get all the roles available in WordPress
  Created On: 30-01-2017 15:32
  Created By: Tech Banker Team
 */
function get_others_capabilities_google_maps() {
   $user_capabilities = array();
   if (function_exists("get_editable_roles")) {
      foreach (get_editable_roles() as $role_name => $role_info) {
         foreach ($role_info["capabilities"] as $capability => $values) {
            if (!in_array($capability, $user_capabilities)) {
               array_push($user_capabilities, $capability);
            }
         }
      }
   } else {
      $user_capabilities = array(
          "manage_options",
          "edit_plugins",
          "edit_posts",
          "publish_posts",
          "publish_pages",
          "edit_pages",
          "read"
      );
   }
   return $user_capabilities;
}
/*
  Function Name: google_maps_bank_action_links
  Parameters: Yes
  Description: This function is used to create link for Pro Editions.
  Created On: 28-04-2016 17:56
  Created By: Tech Banker Team
 */
function google_maps_bank_action_links($plugin_link) {
   $plugin_link[] = "<a href=\"http://beta.tech-banker.com/products/google-maps-bank/\" style=\"color: red; font-weight: bold;\" target=\"_blank\">Go Pro!</a>";
   return $plugin_link;
}
/*
  Function Name: google_maps_bank_settings_link
  Parameters: Yes($action)
  Description: This function is used to add settings link.
  Created On: 09-08-2016 02:50
  Created By: Tech Banker Team
 */
function google_maps_bank_settings_link($action) {
   global $wpdb;
   $user_role_permission = get_others_capabilities_google_maps();
   $settings_link = '<a href = "' . admin_url('admin.php?page=gmb_google_maps') . '">' . "Settings" . '</a>';
   array_unshift($action, $settings_link);
   return $action;
}
$version = get_option("google-maps-bank-version-number");
if ($version >= "2.0.0") {
   /*
     Function Name: check_user_roles_google_map
     Parameters: Yes($user)
     Description: This function is used for checking roles of different users.
     Created On: 28-01-2017 13:56
     Created By: Tech Banker Team
    */
   function check_user_roles_google_map() {
      global $current_user;
      $user = $current_user ? new WP_User($current_user) : wp_get_current_user();
      return $user->roles ? $user->roles[0] : false;
   }
   /*
     Function Name: get_users_capabilities_google_map
     Parameters: No
     Description: This function is used to get users capabilities.
     Created On: 28-01-2017 10:45
     Created By: Tech Banker Team
    */
   function get_users_capabilities_google_map() {
      global $wpdb;
      $roles_and_capabilities_data = $wpdb->get_var
          (
          $wpdb->prepare
              (
              "SELECT meta_value FROM " . google_maps_meta() . " WHERE meta_key = %s", "roles_and_capabilities"
          )
      );
      $unserialized_capabilities = maybe_unserialize($roles_and_capabilities_data);
      $core_roles = array(
          "manage_options",
          "edit_plugins",
          "edit_posts",
          "publish_posts",
          "publish_pages",
          "edit_pages",
          "read"
      );
      return isset($unserialized_capabilities["capabilities"]) ? $unserialized_capabilities["capabilities"] : $core_roles;
   }
   /*
     Function Name: backend_js_css_for_google_map
     Parameters: Yes($hook)
     Description: This function is used for including css and js files for backend.
     Created On: 28-01-2017 10:27
     Created by: Tech Banker Team
    */

   if (is_admin()) {

      function backend_js_css_for_google_map() {
         $pages_map_bank = array(
             "gmb_wizard_google_map",
             "gmb_google_maps",
             "gmb_add_map",
             "gmb_manage_overlays",
             "gmb_add_overlays",
             "gmb_layers",
             "gmb_manage_store",
             "gmb_add_store",
             "gmb_info_window",
             "gmb_directions",
             "gmb_store_locator",
             "gmb_map_customization",
             "gmb_custom_css",
             "gmb_shortcode",
             "gmb_other_settings",
             "gmb_roles_and_capabilities",
             "gmb_feature_requests",
             "gmb_system_information",
             "gm_upgrade"
         );
         global $wpdb;
         $other_settings = $wpdb->get_var
             (
             $wpdb->prepare
                 (
                 "SELECT meta_value FROM " . google_maps_meta() . "
						WHERE meta_key=%s", "other_settings"
             )
         );
         $other_settings_unserialize = maybe_unserialize($other_settings);
         if (in_array(isset($_REQUEST["page"]) ? esc_attr($_REQUEST["page"]) : "", $pages_map_bank)) {
            wp_enqueue_script("jquery");
            wp_enqueue_script("jquery-ui-datepicker");
            wp_enqueue_script("google-map-bootstrap.js", plugins_url("assets/global/plugins/custom/js/custom.js", __FILE__));
            wp_enqueue_script("google-map-jquery.validate.js", plugins_url("assets/global/plugins/validation/jquery.validate.js", __FILE__));
            wp_enqueue_script("google-map-jquery.datatables.js", plugins_url("assets/global/plugins/datatables/media/js/jquery.datatables.js", __FILE__));
            wp_enqueue_script("google-map-jquery.fngetfilterednodes.js", plugins_url("assets/global/plugins/datatables/media/js/fngetfilterednodes.js", __FILE__));
            wp_enqueue_script("google-map-toastr.js", plugins_url("assets/global/plugins/toastr/toastr.js", __FILE__));
            wp_enqueue_script("google-map-clipboard.js", plugins_url("assets/global/plugins/clipboard/clipboard.js", __FILE__));
            wp_enqueue_script("google-map-colpick.js", plugins_url("assets/global/plugins/colorpicker/colpick.js", __FILE__));
            wp_enqueue_style("google-map-simple-line-icons.css", plugins_url("assets/global/plugins/icons/icons.css", __FILE__));
            wp_enqueue_style("google-map-components.css", plugins_url("assets/global/css/components.css", __FILE__));
            if (is_ssl()) {
               wp_enqueue_script("google-map-maps_script.js", "https://maps.googleapis.com/maps/api/js?v=3&libraries=geometry,places,visualization&key=" . esc_attr($other_settings_unserialize["other_api_key"]) . "&language=" . esc_attr($other_settings_unserialize['other_settings_map_language']));
            } else {
               wp_enqueue_script("google-map-maps_script.js", "http://maps.googleapis.com/maps/api/js?v=3&libraries=geometry,places,visualization&key=" . esc_attr($other_settings_unserialize["other_api_key"]) . "&language=" . esc_attr($other_settings_unserialize['other_settings_map_language']));
            }
            wp_enqueue_style("google-map-custom.css", plugins_url("assets/admin/layout/css/google-map-custom.css", __FILE__));
            wp_enqueue_style("google-map-premium-edition.css", plugins_url("assets/admin/layout/css/premium-edition.css", __FILE__));
            if (is_rtl()) {
               wp_enqueue_style("google-map-bootstrap.css", plugins_url("assets/global/plugins/custom/css/custom-rtl.css", __FILE__));
               wp_enqueue_style("google-map-layout.css", plugins_url("assets/admin/layout/css/layout-rtl.css", __FILE__));
               wp_enqueue_style("google-map-tech-banker-custom.css", plugins_url("assets/admin/layout/css/tech-banker-custom-rtl.css", __FILE__));
            } else {
               wp_enqueue_style("google-map-bootstrap.css", plugins_url("assets/global/plugins/custom/css/custom.css", __FILE__));
               wp_enqueue_style("google-map-layout.css", plugins_url("assets/admin/layout/css/layout.css", __FILE__));
               wp_enqueue_style("google-map-tech-banker-custom.css", plugins_url("assets/admin/layout/css/tech-banker-custom.css", __FILE__));
            }
            wp_enqueue_style("google-map-default.css", plugins_url("assets/admin/layout/css/themes/default.css", __FILE__));
            wp_enqueue_style("google-map-toastr.min.css", plugins_url("assets/global/plugins/toastr/toastr.css", __FILE__));
            wp_enqueue_style("google-map-jquery-ui.css", plugins_url("assets/global/plugins/datepicker/jquery-ui.css", __FILE__), false, "2.0", false);
            wp_enqueue_style("google-map-datatables.foundation.css", plugins_url("assets/global/plugins/datatables/media/css/datatables.foundation.css", __FILE__));
            wp_enqueue_style("google-map-colpick.css", plugins_url("assets/global/plugins/colorpicker/colpick.css", __FILE__));
         }
      }
      add_action("admin_enqueue_scripts", "backend_js_css_for_google_map");
   }

   /*
     Function Name: frontend_js_css_for_google_map
     Parameters: No
     Description: This function is used for including css and js files for frontend.
     Created On: 23-02-2017 11:44
     Created by: Tech Banker Team
    */
   function frontend_js_css_for_google_map() {
      wp_enqueue_script("jquery");
      wp_enqueue_script("google-map-bootstrap.js", plugins_url("assets/global/plugins/custom/js/custom.js", __FILE__));
      wp_enqueue_script("google-map-jquery.validate.js", plugins_url("assets/global/plugins/validation/jquery.validate.js", __FILE__));
      wp_enqueue_style("google-map-simple-line-icons.css", plugins_url("assets/global/plugins/icons/icons.css", __FILE__));
      wp_enqueue_style("google-map-components.css", plugins_url("assets/global/css/components.css", __FILE__));
      wp_enqueue_style("google-map-custom.css", plugins_url("assets/admin/layout/css/google-map-custom.css", __FILE__));
      if (is_rtl()) {
         wp_enqueue_style("google-map-bootstrap.css", plugins_url("assets/global/plugins/custom/css/custom-rtl.css", __FILE__));
         wp_enqueue_style("google-map-layout.css", plugins_url("assets/admin/layout/css/layout-rtl.css", __FILE__));
         wp_enqueue_style("google-map-tech-banker-custom.css", plugins_url("assets/admin/layout/css/tech-banker-custom-rtl.css", __FILE__));
      } else {
         wp_enqueue_style("google-map-bootstrap.css", plugins_url("assets/global/plugins/custom/css/custom.css", __FILE__));
         wp_enqueue_style("google-map-layout.css", plugins_url("assets/admin/layout/css/layout.css", __FILE__));
         wp_enqueue_style("google-map-tech-banker-custom.css", plugins_url("assets/admin/layout/css/tech-banker-custom.css", __FILE__));
      }
      wp_enqueue_style("google-map-default.css", plugins_url("assets/admin/layout/css/themes/default.css", __FILE__));
   }
   /*
     Function Name: helper_file_for_google_map
     Parameters: No
     Description: This function is used to create Class and Function to perform operations.
     Created On: 28-01-2017 10:37
     Created By: Tech Banker Team
    */
   function helper_file_for_google_map() {
      global $wpdb;
      $user_role_permission = get_users_capabilities_google_map();
      if (file_exists(GOOGLE_MAP_DIR_PATH . "lib/helper.php")) {
         include_once GOOGLE_MAP_DIR_PATH . "lib/helper.php";
      }
   }
   /*
     Function Name: sidebar_menu_for_google_map
     Parameters: No
     Description: This function is used to create Admin sidebar menus.
     Created On: 28-01-2017 10:42
     Created By: Tech Banker Team
    */
   function sidebar_menu_for_google_map() {
      global $wpdb, $current_user, $wp_version;
      $user_role_permission = get_users_capabilities_google_map();
      if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/translations.php")) {
         include GOOGLE_MAP_DIR_PATH . "includes/translations.php";
      }
      if (file_exists(GOOGLE_MAP_DIR_PATH . "lib/sidebar-menu.php")) {
         include_once GOOGLE_MAP_DIR_PATH . "lib/sidebar-menu.php";
      }
   }
   /*
     Function Name: topbar_menu_for_google_map
     Parameters: No
     Description: This function is used for creating Top bar menu.
     Created On: 28-01-2017 10:48
     Created By: Tech Banker Team
    */
   function topbar_menu_for_google_map() {
      global $wpdb, $current_user, $wp_admin_bar;
      $roles_and_capabilities_data = $wpdb->get_var
          (
          $wpdb->prepare
              (
              "SELECT meta_value FROM " . google_maps_meta() . " WHERE meta_key = %s", "roles_and_capabilities"
          )
      );
      $unserialized_capabilities = maybe_unserialize($roles_and_capabilities_data);
      if (esc_attr($unserialized_capabilities["google_map_top_bar_menu"]) == "enable") {
         $user_role_permission = get_users_capabilities_google_map();
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/translations.php")) {
            include GOOGLE_MAP_DIR_PATH . "includes/translations.php";
         }
         if (get_option("google-map-bank-wizard-set-up")) {
            if (file_exists(GOOGLE_MAP_DIR_PATH . "lib/admin-bar-menu.php")) {
               include_once GOOGLE_MAP_DIR_PATH . "lib/admin-bar-menu.php";
            }
         }
      }
   }
   /*
     Function Name: plugin_load_textdomain_google_map
     Parameters: No
     Description: This function is used to load the plugin's translated strings.
     Created On: 28-01-2017 11:37
     Created By: Tech Banker Team
    */
   function plugin_load_textdomain_google_map() {
      load_plugin_textdomain("google-maps-bank", false, GOOGLE_MAP_PLUGIN_DIRNAME . "/languages");
   }
   /*
     Function Name:google_map_shortcode_attributes
     Parameter: Yes(all shortcode attributes)
     Description: This function is used to add frontend files.
     Created on:06-02-2017 15:15
    */
   function google_map_shortcode_attributes($map_id, $maps_id, $map_title, $map_description, $map_height, $map_width, $map_themes, $directions_header_title, $display_text_directions, $store_locator_title) {
      ob_start();
      $random = mt_rand(100, 10000);
      if (file_exists(GOOGLE_MAP_DIR_PATH . "user-views/includes/translations.php")) {
         include GOOGLE_MAP_DIR_PATH . "user-views/includes/translations.php";
      }
      if (file_exists(GOOGLE_MAP_DIR_PATH . "user-views/includes/queries.php")) {
         include_once GOOGLE_MAP_DIR_PATH . "user-views/includes/queries.php";
         if (isset($map_id)) {
            $map_unserialized_data = get_google_map_bank_data_meta_value($map_id, "maps_settings_data");
            $layers_settings_unserialize_data = get_google_map_bank_data_meta_value($map_id, "layers_settings_data");

            $overlays_settings_marker_data = get_overlays_settings_data_google_map_bank($map_id, "marker_settings_data");
            $overlays_settings_polygon_data = get_overlays_settings_data_google_map_bank($map_id, "polygon_settings_data");
            $overlays_settings_polyline_data = get_overlays_settings_data_google_map_bank($map_id, "polyline_settings_data");
            $overlays_settings_circle_data = get_overlays_settings_data_google_map_bank($map_id, "circle_data");
            $overlays_settings_rectangle_data = get_overlays_settings_data_google_map_bank($map_id, "rectangle_data");
         }

         if (isset($maps_id) && $maps_id != "") {
            $map_unserialized_data = get_google_map_bank_meta_value($maps_id, "maps_settings_data");
            $layers_settings_unserialize_data = get_google_map_bank_meta_value($maps_id, "layers_settings_data");

            $overlays_settings_marker_data = get_overlays_google_maps_bank_settings_data($maps_id, "marker_settings_data");
            $overlays_settings_polygon_data = get_overlays_google_maps_bank_settings_data($maps_id, "polygon_settings_data");
            $overlays_settings_polyline_data = get_overlays_google_maps_bank_settings_data($maps_id, "polyline_settings_data");
            $overlays_settings_circle_data = get_overlays_google_maps_bank_settings_data($maps_id, "circle_data");
            $overlays_settings_rectangle_data = get_overlays_google_maps_bank_settings_data($maps_id, "rectangle_data");
         }
         $other_settings_unserialize = get_layout_settings_google_maps_bank("other_settings");
         $layout_settings_info_window_settings = get_layout_settings_google_maps_bank("info_window_settings");
         $map_customization_settings = get_layout_settings_google_maps_bank("map_customization");
      }
      if (file_exists(GOOGLE_MAP_DIR_PATH . "user-views/styles/css-generator.php")) {
         include GOOGLE_MAP_DIR_PATH . "user-views/styles/css-generator.php";
      }
      if (file_exists(GOOGLE_MAP_DIR_PATH . "user-views/views/google-map.php")) {
         include GOOGLE_MAP_DIR_PATH . "user-views/views/google-map.php";
      }
      if (file_exists(GOOGLE_MAP_DIR_PATH . "user-views/includes/themes.php")) {
         include GOOGLE_MAP_DIR_PATH . "user-views/includes/themes.php";
      }
      if (file_exists(GOOGLE_MAP_DIR_PATH . "user-views/includes/footer.php")) {
         include GOOGLE_MAP_DIR_PATH . "user-views/includes/footer.php";
      }
      $google_maps_output = ob_get_clean();
      wp_reset_query();
      return $google_maps_output;
   }
   /*
     Function Name:google_map_shortcode
     Parameters: yes($attr)
     Description: This function is used to set the shortcode attributes.
     Created On: 6-02-2017 14:3710
     Created By: Tech Banker Team
    */
   function google_map_shortcode($attr) {
      $shortcode = extract(shortcode_atts(array(
          "map_id" => "",
          "maps_id" => "",
          "map_title" => "",
          "map_description" => "",
          "map_height" => "",
          "map_width" => "",
          "map_themes" => "",
          "directions_header_title" => "",
          "display_text_directions" => "",
          "store_locator_title" => ""
              ), $attr));
      return google_map_shortcode_attributes($map_id, $maps_id, $map_title, $map_description, $map_height, $map_width, $map_themes, $directions_header_title, $display_text_directions, $store_locator_title);
   }
   /*
     Function Name: deactivation_function_for_google_map
     Description: This function is used for executing the code on deactivation.
     Parameters: No
     Created On: 24-04-2017 14:29
     Created By: Tech Banker Team
    */
   function deactivation_function_for_google_map() {
      $type = get_option("google-map-bank-wizard-set-up");
      if ($type == "opt_in") {
         $plugin_info_google_maps_bank = new plugin_info_google_maps_bank();
         global $wp_version, $wpdb;
         $theme_details = array();

         if ($wp_version >= 3.4) {
            $active_theme = wp_get_theme();
            $theme_details["theme_name"] = strip_tags($active_theme->Name);
            $theme_details["theme_version"] = strip_tags($active_theme->Version);
            $theme_details["author_url"] = strip_tags($active_theme->{"Author URI"});
         }

         $plugin_stat_data = array();
         $plugin_stat_data["plugin_slug"] = "google-maps-bank";
         $plugin_stat_data["type"] = "standard_edition";
         $plugin_stat_data["version_number"] = google_maps_version_number;
         $plugin_stat_data["status"] = $type;
         $plugin_stat_data["event"] = "de-activate";
         $plugin_stat_data["domain_url"] = site_url();
         $plugin_stat_data["wp_language"] = defined("WPLANG") && WPLANG ? WPLANG : get_locale();

         $plugin_stat_data["email"] = get_option("admin_email");
         $plugin_stat_data["wp_version"] = $wp_version;
         $plugin_stat_data["php_version"] = esc_html(phpversion());
         $plugin_stat_data["mysql_version"] = $wpdb->db_version();
         $plugin_stat_data["max_input_vars"] = ini_get("max_input_vars");
         $plugin_stat_data["operating_system"] = PHP_OS . "  (" . PHP_INT_SIZE * 8 . ") BIT";
         $plugin_stat_data["php_memory_limit"] = ini_get("memory_limit") ? ini_get("memory_limit") : "N/A";
         $plugin_stat_data["extensions"] = get_loaded_extensions();
         $plugin_stat_data["plugins"] = $plugin_info_google_maps_bank->get_plugin_info_google_maps_bank();
         $plugin_stat_data["themes"] = $theme_details;
         $url = tech_banker_stats_url . "/wp-admin/admin-ajax.php";
         $response = wp_safe_remote_post($url, array
             (
             "method" => "POST",
             "timeout" => 45,
             "redirection" => 5,
             "httpversion" => "1.0",
             "blocking" => true,
             "headers" => array(),
             "body" => array("data" => serialize($plugin_stat_data), "site_id" => get_option("gmb_tech_banker_site_id") != "" ? get_option("gmb_tech_banker_site_id") : "", "action" => "plugin_analysis_data")
         ));

         if (!is_wp_error($response)) {
            $response["body"] != "" ? update_option("gmb_tech_banker_site_id", $response["body"]) : "";
         }
      }
   }
   /*
     Function Name: ajax_library_for_google_maps_backend
     Parameters: No
     Description: This function is used to register Ajax for backend.
     Created On: 01-02-2017 9:44
     Created By: Tech Banker Team
    */
   function ajax_library_for_google_maps_backend() {
      global $wpdb;
      $user_role_permission = get_users_capabilities_google_map();
      if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/translations.php")) {
         include GOOGLE_MAP_DIR_PATH . "includes/translations.php";
      }
      if (file_exists(GOOGLE_MAP_DIR_PATH . "lib/action-library.php")) {
         include GOOGLE_MAP_DIR_PATH . "lib/action-library.php";
      }
   }
   /*
     Function Name: validate_ip_google_map
     Parameters: No
     description: This function is used for validating ip address.
     Created on: 18-02-2017 11:06
     Created By: Tech Banker Team
    */
   function validate_ip_google_map($ip) {
      if (strtolower($ip) === "unknown") {
         return false;
      }
      $ip = ip2long($ip);

      if ($ip !== false && $ip !== -1) {
         $ip = sprintf("%u", $ip);

         if ($ip >= 0 && $ip <= 50331647) {
            return false;
         }
         if ($ip >= 167772160 && $ip <= 184549375) {
            return false;
         }
         if ($ip >= 2130706432 && $ip <= 2147483647) {
            return false;
         }
         if ($ip >= 2851995648 && $ip <= 2852061183) {
            return false;
         }
         if ($ip >= 2886729728 && $ip <= 2887778303) {
            return false;
         }
         if ($ip >= 3221225984 && $ip <= 3221226239) {
            return false;
         }
         if ($ip >= 3232235520 && $ip <= 3232301055) {
            return false;
         }
         if ($ip >= 4294967040) {
            return false;
         }
      }
      return true;
   }
   /*
     Function Name: get_ip_address_google_map
     Parameters: No
     Description: This function is used for getIpAddress.
     Created on: 18-02-2017 10:40
     Created By: Tech Banker Team
    */
   function get_ip_address_google_map() {
      static $ip = null;
      if (isset($ip)) {
         return $ip;
      }
      global $wpdb;
      $data = $wpdb->get_var
          (
          $wpdb->prepare
              (
              "SELECT meta_value FROM " . google_maps_meta() . "
					WHERE meta_key=%s", "other_settings"
          )
      );
      $other_settings_data = maybe_unserialize($data);
      switch (esc_attr($other_settings_data["ip_address_fetching_method"])) {
         case "REMOTE_ADDR":
            if (isset($_SERVER["REMOTE_ADDR"])) {
               if (!empty($_SERVER["REMOTE_ADDR"]) && validate_ip_google_map($_SERVER["REMOTE_ADDR"])) {
                  $ip = $_SERVER["REMOTE_ADDR"];
                  return $ip;
               }
            }
            break;

         case "HTTP_X_FORWARDED_FOR":
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]) && !empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
               if (strpos($_SERVER["HTTP_X_FORWARDED_FOR"], ",") !== false) {
                  $iplist = explode(",", $_SERVER["HTTP_X_FORWARDED_FOR"]);
                  foreach ($iplist as $ip_address) {
                     if (validate_ip_google_map($ip_address)) {
                        $ip = $ip_address;
                        return $ip;
                     }
                  }
               } else {
                  if (validate_ip_google_map($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                     $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
                     return $ip;
                  }
               }
            }
            break;

         case "HTTP_X_REAL_IP":
            if (isset($_SERVER["HTTP_X_REAL_IP"])) {
               if (!empty($_SERVER["HTTP_X_REAL_IP"]) && validate_ip_google_map($_SERVER["HTTP_X_REAL_IP"])) {
                  $ip = $_SERVER["HTTP_X_REAL_IP"];
                  return $ip;
               }
            }
            break;

         case "HTTP_CF_CONNECTING_IP":
            if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
               if (!empty($_SERVER["HTTP_CF_CONNECTING_IP"]) && validate_ip_google_map($_SERVER["HTTP_CF_CONNECTING_IP"])) {
                  $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
                  return $ip;
               }
            }
            break;

         default:
            if (isset($_SERVER["HTTP_CLIENT_IP"])) {
               if (!empty($_SERVER["HTTP_CLIENT_IP"]) && validate_ip_google_map($_SERVER["HTTP_CLIENT_IP"])) {
                  $ip = $_SERVER["HTTP_CLIENT_IP"];
                  return $ip;
               }
            }
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]) && !empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
               if (strpos($_SERVER["HTTP_X_FORWARDED_FOR"], ",") !== false) {
                  $iplist = explode(",", $_SERVER["HTTP_X_FORWARDED_FOR"]);
                  foreach ($iplist as $ip_address) {
                     if (validate_ip_google_map($ip_address)) {
                        $ip = $ip_address;
                        return $ip;
                     }
                  }
               } else {
                  if (validate_ip_google_map($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                     $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
                     return $ip;
                  }
               }
            }
            if (isset($_SERVER["HTTP_X_FORWARDED"])) {
               if (!empty($_SERVER["HTTP_X_FORWARDED"]) && validate_ip_google_map($_SERVER["HTTP_X_FORWARDED"])) {
                  $ip = $_SERVER["HTTP_X_FORWARDED"];
                  return $ip;
               }
            }
            if (isset($_SERVER["HTTP_X_CLUSTER_CLIENT_IP"])) {
               if (!empty($_SERVER["HTTP_X_CLUSTER_CLIENT_IP"]) && validate_ip_google_map($_SERVER["HTTP_X_CLUSTER_CLIENT_IP"])) {
                  $ip = $_SERVER["HTTP_X_CLUSTER_CLIENT_IP"];
                  return $ip;
               }
            }
            if (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
               if (!empty($_SERVER["HTTP_FORWARDED_FOR"]) && validate_ip_google_map($_SERVER["HTTP_FORWARDED_FOR"])) {
                  $ip = $_SERVER["HTTP_FORWARDED_FOR"];
                  return $ip;
               }
            }
            if (isset($_SERVER["HTTP_FORWARDED"])) {
               if (!empty($_SERVER["HTTP_FORWARDED"]) && validate_ip_google_map($_SERVER["HTTP_FORWARDED"])) {
                  $ip = $_SERVER["HTTP_FORWARDED"];
                  return $ip;
               }
            }
            if (isset($_SERVER["REMOTE_ADDR"])) {
               if (!empty($_SERVER["REMOTE_ADDR"]) && validate_ip_google_map($_SERVER["REMOTE_ADDR"])) {
                  $ip = $_SERVER["REMOTE_ADDR"];
                  return $ip;
               }
            }
            break;
      }
      return "127.0.0.1";
   }
   /*
     Function Name: get_ip_location_google_map
     Parameters: $ip_Address
     description: This function is used to get ip location.
     Created on: 18-02-2017 11:10
     Created By: Tech Banker Team
    */
   function get_ip_location_google_map($ip_Address) {
      $core_data = '{"ip":"0.0.0.0","country_code":"","country_name":"","region_code":"","region_name":"","city":"","latitude":0,"longitude":0}';
      $apiCall = tech_banker_services_url . "/api/getipaddress.php?ip_address=" . $ip_Address;
      $jsonData = @file_get_contents($apiCall);
      return json_decode($jsonData);
   }
   /*
     Function Name: google_maps_urlencode
     Parameters: Yes($string)
     description: This function is used to replace htmlentities.
     Created on: 20-02-2017 09:50
     Created By: Tech Banker Team
    */
   function google_maps_urlencode($string) {
      $entities = array("%21", "%2A", "%27", "%28", "%29", "%3B", "%3A", "%40", "%26", "%3D", "%2B", "%24", "%2C", "%2F", "%3F", "%25", "%23", "%5B", "%5D");
      $replacements = array("!", "*", "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
      return str_replace($entities, $replacements, urlencode($string));
   }
   /*
     Function Name: google_maps_url_get_contents
     Parameters: Yes($url)
     description: This function is used to get all content of url.
     Created on: 20-02-2017 09:55
     Created By: Tech Banker Team
    */
   function google_maps_url_get_contents($url) {
      if (!function_exists('curl_init')) {
         $output = @file_get_contents($url);
      } else {
         $curlHandler = curl_init();
         curl_setopt($curlHandler, CURLOPT_URL, $url);
         curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, true);
         $output = curl_exec($curlHandler);
         curl_close($curlHandler);
      }
      return $output;
   }
   /*
     Function Name: admin_functions_for_google_map
     Parameters: No
     Description: This function is used for calling admin_init functions.
     Created On: 28-01-2017 10:34
     Created By: Tech Banker Team
    */
   function admin_functions_for_google_map() {
      install_script_for_google_map();
      helper_file_for_google_map();
   }
   /*
     Function Name: user_functions_for_google_maps
     Parameter: No
     Description: This function is used for calling init functions.
     Created On: 27-03-2017 12:59
     Created By: Tech Banker Team
    */
   function user_functions_for_google_maps() {
      frontend_js_css_for_google_map();
      plugin_load_textdomain_google_map();
   }
   /*
     Function Name: add_map_shortcode_button
     Parameter: No
     Description: This function is used to create the button in pages and posts.
     Created On: 17-3-2017 14:47
     Created By:Tech Banker Team
    */
   function add_map_shortcode_button() {
      echo '<a href="admin.php?page=gmb_shortcode" target="_blank" id="insert-map-shortcode" class="button" >' . __("Add Google Maps Bank Shortcode", "google-maps-bank") . '</a>';
   }
   /*
     Class Name: MapWidget
     Parameter: No
     Description: This class is used to add widget.
     Created On: 17-03-2017 12:20
     Created by: Tech Banker Team
    */
   class MapWidget extends WP_Widget {
      function __construct() {
         parent::__construct(
             "MapWidget", __("Google Maps Bank", "google-maps-bank"), array("description" => __("Display Google Map", "google-maps-bank"),)
         );
      }
      /*
        Function Name: form
        Parameters: Yes($instance)
        Description: This function is used to add widget form.
        Created On: 17-03-2017 11:52
        Created by: Tech Banker Team
       */
      public function form($instance) {
         global $wpdb;
         $user_role_permission = get_users_capabilities_google_map();
         if (file_exists(GOOGLE_MAP_DIR_PATH . "user-views/includes/translations.php")) {
            include GOOGLE_MAP_DIR_PATH . "user-views/includes/translations.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "user-views/views/widget-form.php")) {
            include GOOGLE_MAP_DIR_PATH . "user-views/views/widget-form.php";
         }
      }
      /*
        Function Name: widget
        Parameters: Yes($args, $instance)
        Description: This function is used to display widget.
        Created On: 17-03-2011 12:05
        Created by: Tech Banker Team
       */
      public function widget($args, $instance) {
         extract($args, EXTR_SKIP);
         echo $before_widget;
         if (isset($instance["map_id"])) {
            $map_id = $instance["map_id"];
            $map_title = $instance["title"];
            $map_description = "";
            $map_height = $instance["mapHeight"];
            $map_width = $instance["mapWidth"];
            $old_shortcode = "[map_bank map_id=\"$map_id\" map_title=\"$map_title\" map_description=\"$map_description\" map_height=\"$map_height\" map_width=\"$map_width\" map_themes=\"default\"]";
            echo do_shortcode($old_shortcode);
         }
         $shortcode_data = empty($instance["shortcode"]) ? " " : apply_filters("widget_google_maps_bank_shortcode", $instance["shortcode"]);
         if (!empty($shortcode_data)) {
            $shortcode = $shortcode_data;
         }
         echo do_shortcode($shortcode);
         echo $after_widget;
      }
      /*
        Function Name: update
        Parameters: Yes($new_instance, $old_instance)
        Description: This function is used to update widget.
        Created On: 17-03-2017 12:03
        Created by: Tech Banker Team
       */
      public function update($new_instance, $old_instance) {
         $instance = $old_instance;
         $instance["shortcode"] = $new_instance["ux_txt_map_shortcode"];
         return $instance;
      }
   }
   /* Hooks */

   /*
     add_action for admin_functions_for_google_map
     Description: This hook contains all admin_init functions.
     Created On: 28-01-2017 10:40
     Created By: Tech Banker Team
    */

   add_action("admin_init", "admin_functions_for_google_map");

   /*
     add_action for sidebar_menu_for_google_map
     Description: This hook is used for calling the function of sidebar menu.
     Created On: 28-01-2017 10:47
     Created By: Tech Banker Team
    */

   add_action("admin_menu", "sidebar_menu_for_google_map");

   /*
     add_action for sidebar_menu_for_google_map
     Description: This hook is used for calling the function of sidebar menu in case of multisite.
     Created On: 01-02-2017 15:51
     Created By: Tech Banker Team
    */

   add_action("network_admin_menu", "sidebar_menu_for_google_map");

   /*
     add_action for topbar_menu_for_google_map
     Description: This hook is used for calling the function of topbar menu.
     Created On: 28-01-2017 10:51
     Created By: Tech Banker Team
    */

   add_action("admin_bar_menu", "topbar_menu_for_google_map", 100);

   /*
     add_action for ajax_library_for_google_maps_backend
     Description: This hook is used to calling the function of ajax register for backend.
     Created On: 01-02-2017 09:40
     Created By: Tech Banker Team
    */

   add_action("wp_ajax_google_maps_backend", "ajax_library_for_google_maps_backend");

   /*
     add_action for frontend_js_css_for_google_map
     Description: This hook contains all init functions.
     Created On: 23-02-2017 11:44
     Created By: Tech Banker Team
    */
   add_action("init", "user_functions_for_google_maps");

   /*
     add_shortcode for google_map_shortcode
     Description: This hook is used for calling the function of shortcode handler.
     Created On: 06-02-2017 15:12
     Created By: Tech Banker Team
    */

   add_shortcode("map_bank", "google_map_shortcode");

   /*
     add_action for add_map_shortcode_button
     Description: This hook is used for add google map button for shortcode popup.
     Created On: 17-03-2017 12:56
     Created By: Tech Banker Team
    */

   add_action("media_buttons", "add_map_shortcode_button");

   /*
     add_action for MapWidget class
     Description: This hook is used for initiate Widget
     Created On: 17-02-2017 13:06
     Created By: Tech Banker Team
    */

   add_action("widgets_init", create_function("", "return register_widget(\"MapWidget\");"));

   /*
     add_action for Widget.
     Description: This hook is used for apply the shortcode for Widget.
     Created On: 17-03-2017 12:16
     Created By: Tech Banker Team
    */

   add_filter("widget_text", "do_shortcode");

   /*
     register_deactivation_hook
     Description: This Hook is used for calling the function of deactivation.
     Created On: 24-04-2017 14:27
     Created By: Tech Banker Team
    */

   register_deactivation_hook(__FILE__, "deactivation_function_for_google_map");
}

/*
  register_activation_hook for install_script_for_google_map
  Description: This hook is used for calling the function of install script.
  Created On: 28-01-2017 10:54
  Created By: Tech Banker Team
 */

register_activation_hook(__FILE__, "install_script_for_google_map");

/*
  add_action for install_script_for_google_map
  Description: This hook used for calling the function of install script.
  Created On: 28-01-2017 10:56
  Created By: Tech Banker Team
 */

add_action("admin_init", "install_script_for_google_map");

/* add_filter create Go Pro link for Google Maps Bank
  Description: This hook is used for create link for premium Editions.
  Created On: 28-04-2014 17:56
  Created by: Tech Banker Team
 */
add_filter("plugin_action_links_" . plugin_basename(__FILE__), "google_maps_bank_action_links");

/*
  add_filter for google_maps_bank_settings_link
  Description: This hook is used for calling the function of settings link.
  Created On: 09-08-2016 02:51
  Created By: Tech Banker Team
 */

add_filter("plugin_action_links_" . plugin_basename(__FILE__), "google_maps_bank_settings_link", 10, 2);
/*
  Class Name: plugin_activate_google_maps
  Description: This function is used to add option on plugin activation.
  Created On: 24-04-2017 12:04
  Created By: Tech Banker Team
 */
function plugin_activate_google_maps() {
   add_option("google_maps_do_activation_redirect", true);
}
/*
  Class Name: google_maps_redirect
  Description: This function is used to redirect to manage maps menu.
  Created On: 24-04-2017 12:04
  Created By: Tech Banker Team
 */
function google_maps_redirect() {
   if (get_option('google_maps_do_activation_redirect', false)) {
      delete_option("google_maps_do_activation_redirect");
      wp_redirect(admin_url("admin.php?page=gmb_google_maps"));
      exit;
   }
}
register_activation_hook(__FILE__, "plugin_activate_google_maps");
add_action("admin_init", "google_maps_redirect");
