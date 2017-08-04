<?php
/**
 * This file is used for removing tables at uninstall.
 *
 * @author Tech Banker
 * @package google-maps-bank/lib
 * @version 2.0.0
 */
if (!defined('WP_UNINSTALL_PLUGIN')) {
   die;
} else {
   if (!current_user_can("manage_options")) {
      return;
   } else {
      $google_maps_bank_version_number = get_option("google-maps-bank-version-number");
      if ($google_maps_bank_version_number != "") {
         global $wp_version, $wpdb;
         $other_settings_data = $wpdb->get_var
             (
             $wpdb->prepare
                 (
                 "SELECT meta_value FROM " . $wpdb->prefix . "google_maps_meta
                             WHERE meta_key = %s ", "other_settings"
             )
         );
         $other_settings_unserialized = maybe_unserialize($other_settings_data);

         if (esc_attr($other_settings_unserialized["remove_tables_at_uninstall"]) == "enable") {
            // Drop Tables
            $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "google_maps");
            $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "google_maps_meta");

            // Delete options
            delete_option("google-maps-bank-version-number");
            delete_option("google-map-bank-wizard-set-up");
            delete_option("gmb_tech_banker_site_id");
         }
      }
   }
}