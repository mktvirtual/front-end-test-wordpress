<?php
/**
 * This File fetching data from database.
 *
 * @author  Tech Banker
 * @package google-maps-bank/user-views/includes
 * @version 2.0.0
 */
if (!defined("ABSPATH")) {
   exit;
} //exit if accessed directly
if (isset($map_id)) {
   /*
     Function Name : get_google_map_bank_data_meta_value
     Parameter : yes
     Description :  This function is used to get the meta_value from database.
     Created On : 28-2-2017 11:40
     Created By : Tech Banker Team
    */
   function get_google_map_bank_data_meta_value($map_id, $meta_key) {
      global $wpdb;
      $maps_settings_data = $wpdb->get_var
          (
          $wpdb->prepare
              (
              "SELECT meta_value FROM " . google_maps_meta() . "
					WHERE old_map_id = %d AND meta_key = %s", $map_id, $meta_key
          )
      );
      $map_unserialized_data = maybe_unserialize($maps_settings_data);
      return $map_unserialized_data;
   }
   /*
     Function Name : get_overlays_settings_data_google_map_bank
     Parameter: yes
     Description: This function is used to fetch the all data according to the meta_id and meta_key.
     Created On : 28-02-2017 10:27
     Created By : Tech Banker Team
    */
   function get_overlays_settings_data_google_map_bank($map_id, $meta_key) {
      global $wpdb;
      $serialize_overlays_settings_data = $wpdb->get_results
          (
          $wpdb->prepare
              (
              "SELECT * FROM " . google_maps_meta() . "
					WHERE old_map_id = %d AND meta_key = %s", $map_id, $meta_key
          )
      );
      $overlays_settings_data = array();
      foreach ($serialize_overlays_settings_data as $value) {
         $unserialize = maybe_unserialize($value->meta_value);
         $unserialize["id"] = $value->id;
         $unserialize["meta_id"] = $value->meta_id;
         array_push($overlays_settings_data, $unserialize);
      }
      return $overlays_settings_data;
   }
}

if (isset($maps_id) && $maps_id != "") {

   function get_google_map_bank_meta_value($maps_id, $meta_key) {
      global $wpdb;
      $maps_settings_data = $wpdb->get_var
          (
          $wpdb->prepare
              (
              "SELECT meta_value FROM " . google_maps_meta() . "
					WHERE meta_id = %d AND meta_key = %s", $maps_id, $meta_key
          )
      );
      $map_unserialized_data_array = maybe_unserialize($maps_settings_data);
      return $map_unserialized_data_array;
   }
   function get_overlays_google_maps_bank_settings_data($maps_id, $meta_key) {
      global $wpdb;
      $serialize_overlays_settings_data = $wpdb->get_results
          (
          $wpdb->prepare
              (
              "SELECT * FROM " . google_maps_meta() . "
					WHERE meta_id = %d AND meta_key = %s", $maps_id, $meta_key
          )
      );
      $overlays_settings_data = array();
      foreach ($serialize_overlays_settings_data as $value) {
         $unserialize = maybe_unserialize($value->meta_value);
         $unserialize["id"] = $value->id;
         $unserialize["meta_id"] = $value->meta_id;
         array_push($overlays_settings_data, $unserialize);
      }
      return $overlays_settings_data;
   }
}

/*
  Function Name : get_layout_settings_google_maps_bank
  Parameter : yes
  Description : This function is used to fetch the data from database according to the meta_key.
  Created On : 28-02-2017 10:37
  Created By : Tech Banker Team
 */
function get_layout_settings_google_maps_bank($meta_key) {
   global $wpdb;
   $layout_settings_data = $wpdb->get_var
       (
       $wpdb->prepare
           (
           "SELECT meta_value FROM " . google_maps_meta() . "
				WHERE meta_key = %s", $meta_key
       )
   );
   return maybe_unserialize($layout_settings_data);
}
