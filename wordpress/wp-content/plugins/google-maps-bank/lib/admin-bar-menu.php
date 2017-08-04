<?php
/**
 * This file is used for displaying admin bar menu.
 *
 * @author  Tech Banker
 * @package google-maps-bank/lib
 * @version 2.0.0
 */
if (!defined("ABSPATH")) {
   exit;
} // Exit if accessed directly
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
            $flag = $capabilities[0];
            break;

         case "author":
            $flag = $capabilities[1];
            break;

         case "editor":
            $flag = $capabilities[2];
            break;

         case "contributor":
            $flag = $capabilities[3];
            break;

         case "subscriber":
            $flag = $capabilities[4];
            break;

         default:
            $flag = $capabilities[5];
            break;
      }

      if ($flag == 1) {
         global $wp_version;
         $icon = "<img style=\"width:16px; height:16px; vertical-align:middle; margin-right:3px;\" src=" . plugins_url("assets/global/img/icon.png", dirname(__FILE__)) . "> ";
         $wp_admin_bar->add_menu(array
             (
             "id" => "google_maps_bank",
             "title" => $icon . "<span class=\"ab-label\">" . $google_maps_bank . "</span>",
             "href" => admin_url("admin.php?page=gmb_google_maps")
         ));
         $wp_admin_bar->add_menu(array
             (
             "parent" => "google_maps_bank",
             "id" => "maps_google_maps_bank",
             "title" => $gm_google_maps,
             "href" => admin_url("admin.php?page=gmb_google_maps")
         ));
         $wp_admin_bar->add_menu(array
             (
             "parent" => "google_maps_bank",
             "id" => "overlays_google_maps_bank",
             "title" => $gm_overlays,
             "href" => admin_url("admin.php?page=gmb_manage_overlays")
         ));
         $wp_admin_bar->add_menu(array
             (
             "parent" => "google_maps_bank",
             "id" => "layers_google_maps_bank",
             "title" => $gm_layers,
             "href" => admin_url("admin.php?page=gmb_layers")
         ));
         $wp_admin_bar->add_menu(array
             (
             "parent" => "google_maps_bank",
             "id" => "store_locator_google_maps_bank",
             "title" => $gm_store_locator,
             "href" => admin_url("admin.php?page=gmb_manage_store")
         ));
         $wp_admin_bar->add_menu(array
             (
             "parent" => "google_maps_bank",
             "id" => "layout_settings_google_maps_bank",
             "title" => $gm_layout_settings,
             "href" => admin_url("admin.php?page=gmb_info_window")
         ));
         $wp_admin_bar->add_menu(array
             (
             "parent" => "google_maps_bank",
             "id" => "custom_css_google_maps_bank",
             "title" => $gm_custom_css,
             "href" => admin_url("admin.php?page=gmb_custom_css")
         ));
         $wp_admin_bar->add_menu(array
             (
             "parent" => "google_maps_bank",
             "id" => "shortcode_google_maps_bank",
             "title" => $gm_shortcode,
             "href" => admin_url("admin.php?page=gmb_shortcode")
         ));
         $wp_admin_bar->add_menu(array
             (
             "parent" => "google_maps_bank",
             "id" => "other_setting_google_maps_bank",
             "title" => $gm_other_settings,
             "href" => admin_url("admin.php?page=gmb_other_settings")
         ));
         $wp_admin_bar->add_menu(array
             (
             "parent" => "google_maps_bank",
             "id" => "roles_capabilities_google_maps_bank",
             "title" => $gm_roles_and_capabilities,
             "href" => admin_url("admin.php?page=gmb_roles_and_capabilities")
         ));
         $wp_admin_bar->add_menu(array
             (
             "parent" => "google_maps_bank",
             "id" => "feature_requests_google_maps_bank",
             "title" => $gm_feature_requests,
             "href" => admin_url("admin.php?page=gmb_feature_requests")
         ));
         $wp_admin_bar->add_menu(array
             (
             "parent" => "google_maps_bank",
             "id" => "system_information_google_maps_bank",
             "title" => $gm_system_information,
             "href" => admin_url("admin.php?page=gmb_system_information")
         ));
         $wp_admin_bar->add_menu(array
             (
             "parent" => "google_maps_bank",
             "id" => "gm_upgrade_google_maps_bank",
             "title" => $gm_upgrade,
             "href" => admin_url("admin.php?page=gm_upgrade")
         ));
      }
   }
}