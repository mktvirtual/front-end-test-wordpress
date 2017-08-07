<?php
/**
 * This file is used for displaying sidebar menus.
 *
 * @author  Tech Banker
 * @package google-maps-bank/includes
 * @version 2.0.0
 */
if (!defined("ABSPATH")) {
   exit;
}// Exit if accessed directly
if (!is_user_logged_in()) {
   return;
} else {
   $access_granted = false;
   foreach ($user_role_permission as $permission) {
      if (current_user_can($permission)) {
         $access_granted = true;
         break;
      }
   }
   if (!$access_granted) {
      return;
   } else {
      $flag = 0;
      $roles_and_capabilities = $wpdb->get_var
          (
          $wpdb->prepare
              (
              "SELECT meta_value FROM " . google_maps_meta() . " WHERE meta_key = %s", "roles_and_capabilities"
          )
      );
      $roles_capabilities_data = maybe_unserialize($roles_and_capabilities);
      $capabilities = explode(",", esc_attr($roles_capabilities_data["roles_and_capabilities"]));
      if (is_super_admin()) {
         $user_roles = "administrator";
      } else {
         $user_roles = check_user_roles_google_map();
      }
      switch ($user_roles) {
         case "administrator":
            $privileges = "administrator_privileges";
            $flag = $capabilities[0];
            break;

         case "author":
            $privileges = "author_privileges";
            $flag = $capabilities[1];
            break;

         case "editor":
            $privileges = "editor_privileges";
            $flag = $capabilities[2];
            break;

         case "contributor":
            $privileges = "contributor_privileges";
            $flag = $capabilities[3];
            break;

         case "subscriber":
            $privileges = "subscriber_privileges";
            $flag = $capabilities[4];
            break;

         default:
            $privileges = "other_roles_privileges";
            $flag = $capabilities[5];
            break;
      }

      $privileges_role = "";
      foreach ($roles_capabilities_data as $key => $value) {
         if ($privileges == $key) {
            $privileges_role = $value;
            break;
         }
      }
      $full_control = explode(",", $privileges_role);
      if (!defined("full_control")) {
         define("full_control", $full_control[0]);
      }
      if (!defined("map_settings_google_map")) {
         define("map_settings_google_map", $full_control[1]);
      }
      if (!defined("overlays_google_map")) {
         define("overlays_google_map", $full_control[2]);
      }
      if (!defined("layers_google_map")) {
         define("layers_google_map", $full_control[3]);
      }
      if (!defined("store_locator_google_map")) {
         define("store_locator_google_map", $full_control[4]);
      }
      if (!defined("layout_settings_google_map")) {
         define("layout_settings_google_map", $full_control[5]);
      }
      if (!defined("custom_css_google_map")) {
         define("custom_css_google_map", $full_control[6]);
      }
      if (!defined("shortcodes_google_map")) {
         define("shortcodes_google_map", $full_control[7]);
      }
      if (!defined("other_settings_google_map")) {
         define("other_settings_google_map", $full_control[8]);
      }
      if (!defined("roles_and_capabilities_google_map")) {
         define("roles_and_capabilities_google_map", $full_control[9]);
      }
      if (!defined("system_information_google_map")) {
         define("system_information_google_map", $full_control[10]);
      }
      $check_google_map_wizard = get_option("google-map-bank-wizard-set-up");
      if ($flag == 1) {
         $icon = plugins_url("assets/global/img/icon.png", dirname(__FILE__));
         if ($check_google_map_wizard) {
            add_menu_page($google_maps_bank, $google_maps_bank, "read", "gmb_google_maps", "", $icon);
         } else {
            add_menu_page($google_maps_bank, $google_maps_bank, "read", "gmb_wizard_google_map", "", plugins_url("assets/global/img/icon.png", dirName(__FILE__)));
            add_submenu_page($google_maps_bank, $google_maps_bank, "", "read", "gmb_wizard_google_map", "gmb_wizard_google_map");
         }

         add_submenu_page("gmb_google_maps", $google_maps_bank, $gm_google_maps, "read", "gmb_google_maps", $check_google_map_wizard == "" ? "gmb_wizard_google_map" : "gmb_google_maps");
         add_submenu_page($gm_add_map, $gm_add_map, "", "read", "gmb_add_map", $check_google_map_wizard == "" ? "gmb_wizard_google_map" : "gmb_add_map");

         add_submenu_page("gmb_google_maps", $gm_manage_overlays, $gm_overlays, "read", "gmb_manage_overlays", $check_google_map_wizard == "" ? "gmb_wizard_google_map" : "gmb_manage_overlays");
         add_submenu_page($gm_add_overlays, $gm_add_overlays, "", "read", "gmb_add_overlays", $check_google_map_wizard == "" ? "gmb_wizard_google_map" : "gmb_add_overlays");

         add_submenu_page("gmb_google_maps", $gm_layers, $gm_layers, "read", "gmb_layers", $check_google_map_wizard == "" ? "gmb_wizard_google_map" : "gmb_layers");

         add_submenu_page("gmb_google_maps", $gm_manage_store, $gm_store_locator, "read", "gmb_manage_store", $check_google_map_wizard == "" ? "gmb_wizard_google_map" : "gmb_manage_store");
         add_submenu_page($gm_add_store, $gm_add_store, "", "read", "gmb_add_store", $check_google_map_wizard == "" ? "gmb_wizard_google_map" : "gmb_add_store");


         add_submenu_page("gmb_google_maps", $gm_info_window, $gm_layout_settings, "read", "gmb_info_window", $check_google_map_wizard == "" ? "gmb_wizard_google_map" : "gmb_info_window");
         add_submenu_page($gm_directions, $gm_directions, "", "read", "gmb_directions", $check_google_map_wizard == "" ? "gmb_wizard_google_map" : "gmb_directions");
         add_submenu_page($gm_store_locator, $gm_store_locator, "", "read", "gmb_store_locator", $check_google_map_wizard == "" ? "gmb_wizard_google_map" : "gmb_store_locator");
         add_submenu_page($gm_map_customization, $gm_map_customization, "", "read", "gmb_map_customization", $check_google_map_wizard == "" ? "gmb_wizard_google_map" : "gmb_map_customization");

         add_submenu_page("gmb_google_maps", $gm_custom_css, $gm_custom_css, "read", "gmb_custom_css", $check_google_map_wizard == "" ? "gmb_wizard_google_map" : "gmb_custom_css");


         add_submenu_page("gmb_google_maps", $gm_shortcode, $gm_shortcode, "read", "gmb_shortcode", $check_google_map_wizard == "" ? "gmb_wizard_google_map" : "gmb_shortcode");
         add_submenu_page("gmb_google_maps", $gm_other_settings, $gm_other_settings, "read", "gmb_other_settings", $check_google_map_wizard == "" ? "gmb_wizard_google_map" : "gmb_other_settings");
         add_submenu_page("gmb_google_maps", $gm_roles_and_capabilities, $gm_roles_and_capabilities, "read", "gmb_roles_and_capabilities", $check_google_map_wizard == "" ? "gmb_wizard_google_map" : "gmb_roles_and_capabilities");
         add_submenu_page("gmb_google_maps", $gm_feature_requests, $gm_feature_requests, "read", "gmb_feature_requests", $check_google_map_wizard == "" ? "gmb_wizard_google_map" : "gmb_feature_requests");
         add_submenu_page("gmb_google_maps", $gm_system_information, $gm_system_information, "read", "gmb_system_information", $check_google_map_wizard == "" ? "gmb_wizard_google_map" : "gmb_system_information");
         add_submenu_page("gmb_google_maps", $gm_upgrade, $gm_upgrade, "read", "gm_upgrade", $check_google_map_wizard == "" ? "gmb_wizard_google_map" : "gm_upgrade");
      }

      /*
        Function Name: gmb_wizard_google_map
        Parameters: No
        Description: This function is used to create gmb_wizard_google_map
        Created On: 24-04-2017 11:52
        Created By: Tech Banker Team
       */
      function gmb_wizard_google_map() {
         global $wpdb;
         $user_role_permission = get_users_capabilities_google_map();
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/translations.php")) {
            include GOOGLE_MAP_DIR_PATH . "includes/translations.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "views/wizard/wizard.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "views/wizard/wizard.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/footer.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/footer.php";
         }
      }
      /*
        Function Name: gmb_google_maps
        Parameters: No
        Description: This function is used to create gm_google_maps menu.
        Created On: 28-01-2017 12:29
        Created By: Tech Banker Team
       */
      function gmb_google_maps() {
         global $wpdb;
         $user_role_permission = get_users_capabilities_google_map();
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/translations.php")) {
            include GOOGLE_MAP_DIR_PATH . "includes/translations.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/header.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/header.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/sidebar.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/sidebar.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/queries.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/queries.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "views/maps/manage-maps.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "views/maps/manage-maps.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/footer.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/footer.php";
         }
      }
      /*
        Function Name: gmb_add_map
        Parameters: No
        Description: This function is used to create gm_add_map menu.
        Created On: 28-01-2017 12:29
        Created By: Tech Banker Team
       */
      function gmb_add_map() {
         global $wpdb;
         $user_role_permission = get_users_capabilities_google_map();
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/translations.php")) {
            include GOOGLE_MAP_DIR_PATH . "includes/translations.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/header.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/header.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/sidebar.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/sidebar.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/queries.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/queries.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "views/maps/add-map.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "views/maps/add-map.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/footer.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/footer.php";
         }
      }
      /*
        Function Name: gmb_manage_overlays
        Parameters: No
        Description: This function is used to create gm_manage_overlays menu.
        Created On: 28-01-2017 12:29
        Created By: Tech Banker Team
       */
      function gmb_manage_overlays() {
         global $wpdb;
         $user_role_permission = get_users_capabilities_google_map();
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/translations.php")) {
            include GOOGLE_MAP_DIR_PATH . "includes/translations.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/header.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/header.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/sidebar.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/sidebar.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/queries.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/queries.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "views/overlays/manage-overlays.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "views/overlays/manage-overlays.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/footer.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/footer.php";
         }
      }
      /*
        Function Name: gmb_add_overlays
        Parameters: No
        Description: This function is used to create gm_add_overlays menu.
        Created On: 28-01-2017 13:18
        Created By: Tech Banker Team
       */
      function gmb_add_overlays() {
         global $wpdb;
         $user_role_permission = get_users_capabilities_google_map();
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/translations.php")) {
            include GOOGLE_MAP_DIR_PATH . "includes/translations.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/header.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/header.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/sidebar.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/sidebar.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/queries.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/queries.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "views/overlays/add-overlay.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "views/overlays/add-overlay.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/footer.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/footer.php";
         }
      }
      /*
        Function Name: gmb_layers
        Parameters: No
        Description: This function is used to create gm_layers menu.
        Created On: 28-01-2017 14:06
        Created By: Tech Banker Team
       */
      function gmb_layers() {
         global $wpdb;
         $user_role_permission = get_users_capabilities_google_map();
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/translations.php")) {
            include GOOGLE_MAP_DIR_PATH . "includes/translations.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/header.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/header.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/sidebar.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/sidebar.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/queries.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/queries.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "views/layers/layers.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "views/layers/layers.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/footer.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/footer.php";
         }
      }
      /*
        Function Name: gmb_manage_store
        Parameters: No
        Description: This function is used to create gm_manage_store menu.
        Created On: 07-03-2017 10:46
        Created By: Tech Banker Team
       */
      function gmb_manage_store() {
         global $wpdb;
         $user_role_permission = get_users_capabilities_google_map();
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/translations.php")) {
            include GOOGLE_MAP_DIR_PATH . "includes/translations.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/header.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/header.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/sidebar.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/sidebar.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/queries.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/queries.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "views/store-locator/manage-store.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "views/store-locator/manage-store.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/footer.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/footer.php";
         }
      }
      /*
        Function Name: gmb_add_store
        Parameters: No
        Description: This function is used to create gm_add_store menu.
        Created On: 07-03-2017 10:46
        Created By: Tech Banker Team
       */
      function gmb_add_store() {
         global $wpdb;
         $user_role_permission = get_users_capabilities_google_map();
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/translations.php")) {
            include GOOGLE_MAP_DIR_PATH . "includes/translations.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/header.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/header.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/sidebar.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/sidebar.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/queries.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/queries.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "views/store-locator/add-store.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "views/store-locator/add-store.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/footer.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/footer.php";
         }
      }
      /*
        Function Name: gmb_info_window
        Parameters: NO
        Description: This function is used to create gmb_info_window menu.
        Created On: 02-02-2017 17:33
        Created By: Tech Banker Team
       */
      function gmb_info_window() {
         global $wpdb;
         $user_role_permission = get_users_capabilities_google_map();
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/translations.php")) {
            include GOOGLE_MAP_DIR_PATH . "includes/translations.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/header.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/header.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/sidebar.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/sidebar.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/queries.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/queries.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/web-fonts.php")) {
            $web_font_list = include_once GOOGLE_MAP_DIR_PATH . "includes/web-fonts.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "views/layout-settings/info-window.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "views/layout-settings/info-window.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/footer.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/footer.php";
         }
      }
      /*
        Function Name: gmb_directions
        Parameters: NO
        Description: This function is used to create gmb_directions menu.
        Created On: 03-02-2017 10:33
        Created By: Tech Banker Team
       */
      function gmb_directions() {
         global $wpdb;
         $user_role_permission = get_users_capabilities_google_map();
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/translations.php")) {
            include GOOGLE_MAP_DIR_PATH . "includes/translations.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/header.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/header.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/sidebar.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/sidebar.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/queries.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/queries.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/web-fonts.php")) {
            $web_font_list = include_once GOOGLE_MAP_DIR_PATH . "includes/web-fonts.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "views/layout-settings/directions.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "views/layout-settings/directions.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/footer.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/footer.php";
         }
      }
      /*
        Function Name: gmb_store_locator
        Parameters: NO
        Description: This function is used to create gmb_store_locator menu.
        Created On: 03-02-2017 10:33
        Created By: Tech Banker Team
       */
      function gmb_store_locator() {
         global $wpdb;
         $user_role_permission = get_users_capabilities_google_map();
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/translations.php")) {
            include GOOGLE_MAP_DIR_PATH . "includes/translations.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/header.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/header.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/sidebar.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/sidebar.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/queries.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/queries.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/web-fonts.php")) {
            $web_font_list = include_once GOOGLE_MAP_DIR_PATH . "includes/web-fonts.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "views/layout-settings/store-locator.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "views/layout-settings/store-locator.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/footer.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/footer.php";
         }
      }
      /*
        Function Name: gmb_map_customization
        Parameters: NO
        Description: This function is used to create gmb_map_customization menu.
        Created On: 23-03-2017 14:13
        Created By: Tech Banker Team
       */
      function gmb_map_customization() {
         global $wpdb;
         $user_role_permission = get_users_capabilities_google_map();
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/translations.php")) {
            include GOOGLE_MAP_DIR_PATH . "includes/translations.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/header.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/header.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/sidebar.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/sidebar.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/queries.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/queries.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/web-fonts.php")) {
            $web_font_list = include_once GOOGLE_MAP_DIR_PATH . "includes/web-fonts.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "views/layout-settings/map-customization.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "views/layout-settings/map-customization.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/footer.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/footer.php";
         }
      }
      /*
        Function Name: gmb_custom_css
        Parameters: NO
        Description: This function is used to create gmb_custom_css menu.
        Created On: 25-04-2017 12:34
        Created By: Tech Banker Team
       */
      function gmb_custom_css() {
         global $wpdb;
         $user_role_permission = get_users_capabilities_google_map();
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/translations.php")) {
            include GOOGLE_MAP_DIR_PATH . "includes/translations.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/header.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/header.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/sidebar.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/sidebar.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/queries.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/queries.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/web-fonts.php")) {
            $web_font_list = include_once GOOGLE_MAP_DIR_PATH . "includes/web-fonts.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "views/custom-css/custom-css.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "views/custom-css/custom-css.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/footer.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/footer.php";
         }
      }
      /*
        Function Name: gmb_shortcode
        Parameters: No
        Description: This function is used to create gm_shortcode menu.
        Created On: 28-01-2017 14:12
        Created By: Tech Banker Team
       */
      function gmb_shortcode() {
         global $wpdb;
         $user_role_permission = get_users_capabilities_google_map();
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/translations.php")) {
            include GOOGLE_MAP_DIR_PATH . "includes/translations.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/header.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/header.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/sidebar.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/sidebar.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/queries.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/queries.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "views/shortcodes/shortcodes.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "views/shortcodes/shortcodes.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/footer.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/footer.php";
         }
      }
      /*
        Function Name: gmb_other_settings
        Parameters: No
        Description: This function is used to create gm_other_settings menu.
        Created On: 28-01-2017 14:13
        Created By: Tech Banker Team
       */
      function gmb_other_settings() {
         global $wpdb;
         $user_role_permission = get_users_capabilities_google_map();
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/translations.php")) {
            include GOOGLE_MAP_DIR_PATH . "includes/translations.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/header.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/header.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/sidebar.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/sidebar.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/queries.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/queries.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "views/other-settings/other-settings.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "views/other-settings/other-settings.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/footer.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/footer.php";
         }
      }
      /*
        Function Name: gmb_roles_and_capabilities
        Parameters: No
        Description: This function is used to create gm_roles_and_capabilities menu.
        Created On: 28-01-2017 14:15
        Created By: Tech Banker Team
       */
      function gmb_roles_and_capabilities() {
         global $wpdb;
         $user_role_permission = get_users_capabilities_google_map();
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/translations.php")) {
            include GOOGLE_MAP_DIR_PATH . "includes/translations.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/header.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/header.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/sidebar.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/sidebar.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/queries.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/queries.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "views/roles-and-capabilities/roles-and-capabilities.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "views/roles-and-capabilities/roles-and-capabilities.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/footer.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/footer.php";
         }
      }
      /*
        Function Name: gmb_feature_requests
        Parameters: No
        Description: This function is used to create gm_feature_requests menu.
        Created On: 28-01-2017 14:16
        Created By: Tech Banker Team
       */
      function gmb_feature_requests() {
         global $wpdb;
         $user_role_permission = get_users_capabilities_google_map();
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/translations.php")) {
            include GOOGLE_MAP_DIR_PATH . "includes/translations.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/header.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/header.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/sidebar.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/sidebar.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "views/feature-requests/feature-requests.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "views/feature-requests/feature-requests.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/footer.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/footer.php";
         }
      }
      /*
        Function Name: gmb_system_information
        Parameters: No
        Description: This function is used to create gm_system_information menu.
        Created On: 28-01-2017 14:18
        Created By: Tech Banker Team
       */
      function gmb_system_information() {
         global $wpdb;
         $user_role_permission = get_users_capabilities_google_map();
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/translations.php")) {
            include GOOGLE_MAP_DIR_PATH . "includes/translations.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/header.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/header.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/sidebar.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/sidebar.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "views/system-information/system-information.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "views/system-information/system-information.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/footer.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/footer.php";
         }
      }
      /*
        Function Name: gm_upgrade
        Parameters: No
        Description: This function is used to create gm_upgrade menu.
        Created On: 28-04-2017 14:19
        Created By: Tech Banker Team
       */
      function gm_upgrade() {
         global $wpdb;
         $user_role_permission = get_users_capabilities_google_map();
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/translations.php")) {
            include GOOGLE_MAP_DIR_PATH . "includes/translations.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/header.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/header.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/sidebar.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/sidebar.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "views/premium-editions/premium-editions.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "views/premium-editions/premium-editions.php";
         }
         if (file_exists(GOOGLE_MAP_DIR_PATH . "includes/footer.php")) {
            include_once GOOGLE_MAP_DIR_PATH . "includes/footer.php";
         }
      }
   }
}