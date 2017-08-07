<?php
/**
 * This file is used to create tables.
 *
 * @author Tech Banker
 * @package google-maps-bank/lib
 * @version 2.0.0
 */
if (!defined("ABSPATH")) {
   exit;
} //Exit if accessed directly
if (!is_user_logged_in()) {
   return;
} else {
   if (!current_user_can("manage_options")) {
      return;
   } else {
      /*
        Class Name: dbHelper_install_script_google_maps
        Description: This class is used to perform operations.
        Created On: 02-02-2017 17:12
        Created By: Tech Banker Team
       */
      class dbHelper_install_script_google_maps {
         /*
           Function Name: insertCommand
           Parameters: Yes($table_name,$data)
           Description: This function is used for insert data in the database.
           Created On: 02-02-2017 17:15
           Created By: Tech Banker Team
          */
         function insertCommand($table_name, $data) {
            global $wpdb;
            $wpdb->insert($table_name, $data);
            return $wpdb->insert_id;
         }
         /*
           Function Name: updateCommand
           Parameters: Yes($table_name,$data,$where)
           Description: This function is used for Update data.
           Created On: 02-02-2017 17:17
           Created By: Tech Banker Team
          */
         function updateCommand($table_name, $data, $where) {
            global $wpdb;
            $wpdb->update($table_name, $data, $where);
         }
      }
      require_once ABSPATH . "wp-admin/includes/upgrade.php";
      $google_map_version_number = get_option("google-maps-bank-version-number");

      /*
        Function Name: google_maps_parent_table
        Parameter: No
        Description: It is used for creating a parent table.
        Created On: 02-02-2017 17:20
        Created By: Tech Banker Team
       */
      function google_maps_parent_table() {
         global $wpdb;
         $obj_dbHelper_google_maps = new dbHelper_install_script_google_maps();
         $sql = "CREATE TABLE IF NOT EXISTS " . google_maps() . "
				(
					`id` int(10) NOT NULL AUTO_INCREMENT,
					`type` longtext NOT NULL,
					`parent_id` int(10) DEFAULT NULL,
					 PRIMARY KEY (`id`)
				)
				ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
         dbDelta($sql);

         $data = "INSERT INTO " . google_maps() . " (`type`, `parent_id`) VALUES
				('maps','0'),
				('store_locator','0'),
				('layout_settings', 0),
				('custom_css',0),
				('other_settings', 0),
				('roles_and_capabilities_settings', 0);";
         dbDelta($data);

         $parent_table_data = $wpdb->get_results
             (
             "SELECT id,type FROM " . google_maps()
         );
         foreach ($parent_table_data as $row) {
            switch (esc_attr($row->type)) {
               case "layout_settings":
                  $gmb_layout_settings_serialize = array();
                  $gmb_layout_settings_serialize["info_window"] = isset($row->id) ? intval($row->id) : 0;
                  $gmb_layout_settings_serialize["directions"] = isset($row->id) ? intval($row->id) : 0;
                  $gmb_layout_settings_serialize["store_locator"] = isset($row->id) ? intval($row->id) : 0;
                  $gmb_layout_settings_serialize["map_customization"] = isset($row->id) ? intval($row->id) : 0;
                  foreach ($gmb_layout_settings_serialize as $keys => $value) {
                     $gmb_layout_settings_data = array();
                     $gmb_layout_settings_data["type"] = $keys;
                     $gmb_layout_settings_data["parent_id"] = $value;
                     $obj_dbHelper_google_maps->insertCommand(google_maps(), $gmb_layout_settings_data);
                  }
                  break;
            }
         }
      }
      /*
        Function Name: google_maps_meta_table
        Parameter: No
        Description: It is used for creating a meta table.
        Created On: 02-02-2017 17:24
        Created By: Tech Banker Team
       */
      function google_maps_meta_table() {
         global $wpdb;
         $obj_dbHelper_google_maps = new dbHelper_install_script_google_maps();
         $sql = "CREATE TABLE IF NOT EXISTS " . google_maps_meta() . "
				(
					`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					`meta_id` int(10) NOT NULL,
					`meta_key` varchar(100) NOT NULL,
					`meta_value` longtext NOT NULL,
					`old_map_id` int(10) NOT NULL,
					PRIMARY KEY (`id`)
				)
				ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
         dbDelta($sql);

         $parent_table_data = $wpdb->get_results
             (
             "SELECT id,type FROM " . google_maps()
         );
         foreach ($parent_table_data as $row) {
            switch (esc_attr($row->type)) {
               case "info_window":
                  $gmb_info_window_settings = array();
                  $gmb_info_window_settings["info_window_width"] = "300";
                  $gmb_info_window_settings["info_window_open_event"] = "click";
                  $gmb_info_window_settings["info_window_title_style"] = "15,#000000";
                  $gmb_info_window_settings["info_window_title_font_family"] = "Roboto Condensed";
                  $gmb_info_window_settings["info_window_desc_style"] = "12,#000000";
                  $gmb_info_window_settings["info_window_desc_font_family"] = "Roboto Condensed";
                  $gmb_info_window_settings["info_window_border_style"] = "0,none,#000000";
                  $gmb_info_window_settings["info_window_border_radius"] = "0";
                  $gmb_info_window_settings["info_windows_image_padding"] = "0,10,0,0";
                  $gmb_info_window_settings["info_windows_text_padding"] = "0,0,0,0";
                  $gmb_info_window_settings["info_window_image_position"] = "left";

                  $gmb_info_window_settings_array = array();
                  $gmb_info_window_settings_array["meta_id"] = isset($row->id) ? intval($row->id) : 0;
                  $gmb_info_window_settings_array["meta_key"] = "info_window_settings";
                  $gmb_info_window_settings_array["meta_value"] = serialize($gmb_info_window_settings);
                  $gmb_info_window_settings_array["old_map_id"] = 0;
                  $obj_dbHelper_google_maps->insertCommand(google_maps_meta(), $gmb_info_window_settings_array);
                  break;

               case "directions":
                  $gmb_directions_settings = array();
                  $gmb_directions_settings["directions_general_background_color"] = "#ffffff";
                  $gmb_directions_settings["directions_general_background_opacity"] = "100";

                  $gmb_directions_settings["directions_header_title_style"] = "20,#000000";
                  $gmb_directions_settings["directions_header_font_family"] = "Roboto Condensed";
                  $gmb_directions_settings["directions_background_color"] = "#ffffff";
                  $gmb_directions_settings["directions_background_opacity"] = "100";

                  $gmb_directions_settings["directions_label_style"] = "15,#000000";
                  $gmb_directions_settings["directions_label_font_family"] = "Roboto Condensed";
                  $gmb_directions_settings["input_field_placeholder_from"] = "Please enter Starting Point";
                  $gmb_directions_settings["input_field_placeholder_to"] = "Please enter Destination Point";
                  $gmb_directions_settings["directions_input_field_default_mode"] = "driving";
                  $gmb_directions_settings["directions_input_field_placeholder_style"] = "15,#000000";
                  $gmb_directions_settings["directions_placeholder_font_family"] = "Roboto Condensed";
                  $gmb_directions_settings["directions_input_field_margin"] = "0,0,10,0";
                  $gmb_directions_settings["directions_input_field_padding"] = "0,0,0,0";
                  $gmb_directions_settings["directions_input_field_height"] = "40";
                  $gmb_directions_settings["directions_input_field_width"] = "100";
                  $gmb_directions_settings["directions_input_field_text_style"] = "15,#000000";
                  $gmb_directions_settings["directions_input_field_font_family"] = "Roboto Condensed";
                  $gmb_directions_settings["directions_input_field_background_color"] = "#ffffff";
                  $gmb_directions_settings["directions_input_field_background_opacity"] = "75";
                  $gmb_directions_settings["directions_line_color"] = "#000000";
                  $gmb_directions_settings["directions_line_color_opacity"] = "75";

                  $gmb_directions_settings["directions_button_text_style"] = "15,#ffffff";
                  $gmb_directions_settings["directions_button_font_family"] = "Roboto Condensed";
                  $gmb_directions_settings["directions_button_background_color"] = "#a4cd39";
                  $gmb_directions_settings["directions_button_background_color_opacity"] = "75";
                  $gmb_directions_settings["directions_button_height_and_width"] = "50,100";
                  $gmb_directions_settings["directions_button_alignment"] = "center";

                  $gmb_directions_settings["text_direction_width"] = "100";
                  $gmb_directions_settings["directions_display_text_style"] = "14,#000000";
                  $gmb_directions_settings["directions_display_text_font_family"] = "Roboto Condensed";
                  $gmb_directions_settings["directions_display_background_color"] = "#ffffff";
                  $gmb_directions_settings["directions_display_background_color_opacity"] = "100";
                  $gmb_directions_settings["directions_display_border_style"] = "0,none,#a4cd39";
                  $gmb_directions_settings["directions_display_border_radius"] = "0";

                  $gmb_directions_settings["direction_type"] = "disable";
                  $gmb_directions_settings["direction_address_type"] = "formatted_address";
                  $gmb_directions_settings["direction_address"] = "";
                  $gmb_directions_settings["direction_latitude"] = "";
                  $gmb_directions_settings["direction_longitude"] = "";
                  $gmb_directions_settings["directions_type_to"] = "disable";
                  $gmb_directions_settings["direction_address_type_to"] = "formatted_address";
                  $gmb_directions_settings["direction_address_to"] = "";
                  $gmb_directions_settings["direction_latitude_to"] = "";
                  $gmb_directions_settings["direction_longitude_to"] = "";

                  $gmb_directions_settings_array = array();
                  $gmb_directions_settings_array["meta_id"] = isset($row->id) ? intval($row->id) : 0;
                  $gmb_directions_settings_array["meta_key"] = "directions_settings";
                  $gmb_directions_settings_array["meta_value"] = serialize($gmb_directions_settings);
                  $gmb_directions_settings_array["old_map_id"] = 0;
                  $obj_dbHelper_google_maps->insertCommand(google_maps_meta(), $gmb_directions_settings_array);
                  break;

               case "store_locator":
                  $gmb_store_locator_settings = array();
                  $gmb_store_locator_settings["store_locator_general_background_color"] = "#ffffff";
                  $gmb_store_locator_settings["store_locator_general_background_opacity"] = "100";

                  $gmb_store_locator_settings["store_locator_header_title_style"] = "20,#000000";
                  $gmb_store_locator_settings["store_locator_header_title_font_family"] = "Roboto Condensed";
                  $gmb_store_locator_settings["store_locator_background_color"] = "#ffffff";
                  $gmb_store_locator_settings["store_locator_background_color_opacity"] = "100";

                  $gmb_store_locator_settings["store_locator_label_style"] = "15,#000000";
                  $gmb_store_locator_settings["store_locator_label_font_family"] = "Roboto Condensed";
                  $gmb_store_locator_settings["store_locator_input_field_placeholder_form"] = "Please enter location address";
                  $gmb_store_locator_settings["store_locator_input_field_placeholder_style"] = "15,#000000";
                  $gmb_store_locator_settings["store_locator_input_field_placeholder_font_family"] = "Roboto Condensed";
                  $gmb_store_locator_settings["store_locator_input_field_text_style"] = "15,#000000";
                  $gmb_store_locator_settings["store_locator_input_field_font_family"] = "Roboto Condensed";
                  $gmb_store_locator_settings["store_locator_input_field_background_color"] = "#ffffff";
                  $gmb_store_locator_settings["store_locator_input_field_background_color_opacity"] = "75";
                  $gmb_store_locator_settings["store_locator_input_field_margin"] = "0,0,10,0";
                  $gmb_store_locator_settings["store_locator_input_field_padding"] = "0,0,0,0";
                  $gmb_store_locator_settings["store_locator_input_field_width"] = "100";
                  $gmb_store_locator_settings["store_locator_input_field_height"] = "40";
                  $gmb_store_locator_settings["store_locator_input_field_show_default_location"] = "disable";
                  $gmb_store_locator_settings["store_locator_input_field_default_location"] = "formatted_address";
                  $gmb_store_locator_settings["store_locator_input_field_formatted"] = "";
                  $gmb_store_locator_settings["store_locator_input_field_latitude"] = "";
                  $gmb_store_locator_settings["store_locator_input_field_longitude"] = "";


                  $gmb_store_locator_settings["store_locator_button_text_style"] = "15,#ffffff";
                  $gmb_store_locator_settings["store_locator_button_text_font_family"] = "Roboto Condensed";
                  $gmb_store_locator_settings["store_locator_button_background_color"] = "#a4cd39";
                  $gmb_store_locator_settings["store_locator_button_background_color_opacity"] = "75";
                  $gmb_store_locator_settings["store_locator_button_height_and_width"] = "50,100";
                  $gmb_store_locator_settings["store_locator_button_alignment"] = "center";

                  $gmb_store_locator_settings["store_locator_distance_measurement"] = "kilometers";
                  $gmb_store_locator_settings["store_locator_circle_line_width"] = "3";
                  $gmb_store_locator_settings["store_locator_circle_line_color"] = "#000000";
                  $gmb_store_locator_settings["store_locator_circle_line_color_opacity"] = "75";
                  $gmb_store_locator_settings["store_locator_circle_fill_color"] = "#e37be3";
                  $gmb_store_locator_settings["store_locator_circle_fill_color_opacity"] = "75";

                  $gmb_store_locator_settings["store_locator_table_width"] = "100";
                  $gmb_store_locator_settings["store_locator_table_text_style"] = "14,#000000";
                  $gmb_store_locator_settings["store_locator_table_text_font_family"] = "Roboto Condensed";
                  $gmb_store_locator_settings["store_locator_table_background_color"] = "#ffffff";
                  $gmb_store_locator_settings["store_locator_table_background_color_opacity"] = "75";
                  $gmb_store_locator_settings["store_locator_table_border_style"] = "0,none,#a4cd39";
                  $gmb_store_locator_settings["store_locator_table_border_radius"] = "0";

                  $gmb_store_locator_settings_array = array();
                  $gmb_store_locator_settings_array["meta_id"] = isset($row->id) ? intval($row->id) : 0;
                  $gmb_store_locator_settings_array["meta_key"] = "store_locator_settings";
                  $gmb_store_locator_settings_array["meta_value"] = serialize($gmb_store_locator_settings);
                  $gmb_store_locator_settings_array["old_map_id"] = 0;
                  $obj_dbHelper_google_maps->insertCommand(google_maps_meta(), $gmb_store_locator_settings_array);
                  break;

               case "map_customization":
                  $gmb_map_customization_settings = array();
                  $gmb_map_customization_settings["map_title_html_tag"] = "h1";
                  $gmb_map_customization_settings["map_title_text_alignment"] = "left";
                  $gmb_map_customization_settings["map_title_font_style"] = "18,#000000";
                  $gmb_map_customization_settings["map_title_font_family"] = "Roboto Condensed";
                  $gmb_map_customization_settings["map_title_margin"] = "0,0,0,0";
                  $gmb_map_customization_settings["map_title_padding"] = "0,0,0,0";

                  $gmb_map_customization_settings["map_description_html_tag"] = "p";
                  $gmb_map_customization_settings["map_description_text_alignment"] = "left";
                  $gmb_map_customization_settings["map_description_font_style"] = "15,#000000";
                  $gmb_map_customization_settings["map_description_font_family"] = "Roboto Condensed";
                  $gmb_map_customization_settings["map_description_margin"] = "0,0,0,0";
                  $gmb_map_customization_settings["map_description_padding"] = "0,0,0,0";

                  $gmb_map_customization_settings["map_draggable"] = "enable";
                  $gmb_map_customization_settings["map_type"] = "show";
                  $gmb_map_customization_settings["map_type_control_position"] = "top_left";
                  $gmb_map_customization_settings["map_type_control_style"] = "none";
                  $gmb_map_customization_settings["map_double_click_zoom"] = "enable";
                  $gmb_map_customization_settings["mouse_wheel_scrolling"] = "enable";
                  $gmb_map_customization_settings["full_screen_control"] = "hide";
                  $gmb_map_customization_settings["full_screen_control_position"] = "top_right";
                  $gmb_map_customization_settings["street_view_control"] = "hide";
                  $gmb_map_customization_settings["street_view_control_position"] = "right_bottom";
                  $gmb_map_customization_settings["rotate_control"] = "show";
                  $gmb_map_customization_settings["scale_control"] = "show";
                  $gmb_map_customization_settings["map_zoom_control"] = "hide";
                  $gmb_map_customization_settings["map_zoom_control_alignment"] = "right_bottom";


                  $gmb_map_customization_settings_array = array();
                  $gmb_map_customization_settings_array["meta_id"] = isset($row->id) ? intval($row->id) : 0;
                  $gmb_map_customization_settings_array["meta_key"] = "map_customization";
                  $gmb_map_customization_settings_array["meta_value"] = serialize($gmb_map_customization_settings);
                  $gmb_map_customization_settings_array["old_map_id"] = 0;
                  $obj_dbHelper_google_maps->insertCommand(google_maps_meta(), $gmb_map_customization_settings_array);
                  break;

               case "custom_css":
                  $gmb_custom_css_data = array();
                  $gmb_custom_css_data["custom_css"] = "";

                  $gmb_custom_css_array = array();
                  $gmb_custom_css_array["meta_id"] = isset($row->id) ? intval($row->id) : 0;
                  $gmb_custom_css_array["meta_key"] = "custom_css";
                  $gmb_custom_css_array["meta_value"] = serialize($gmb_custom_css_data);
                  $gmb_custom_css_array["old_map_id"] = 0;
                  $obj_dbHelper_google_maps->insertCommand(google_maps_meta(), $gmb_custom_css_array);
                  break;

               case "other_settings":
                  $gmb_other_settings_data["remove_tables_at_uninstall"] = "enable";
                  $gmb_other_settings_data["other_api_key"] = "AIzaSyC4rVG7IsNk9pKUO_uOZuxQO4FmF6z03Ks";
                  $gmb_other_settings_data["other_settings_map_language"] = "en";
                  $gmb_other_settings_data["ip_address_fetching_method"] = "";

                  $gmb_other_settings_serialize = array();
                  $gmb_other_settings_serialize["meta_id"] = isset($row->id) ? intval($row->id) : 0;
                  $gmb_other_settings_serialize["meta_key"] = "other_settings";
                  $gmb_other_settings_serialize["meta_value"] = serialize($gmb_other_settings_data);
                  $gmb_other_settings_serialize["old_map_id"] = 0;
                  $obj_dbHelper_google_maps->insertCommand(google_maps_meta(), $gmb_other_settings_serialize);
                  break;

               case "roles_and_capabilities_settings":
                  $roles_capabilities_data_array = array();
                  $roles_capabilities_data_array["roles_and_capabilities"] = "1,1,1,0,0,0";
                  $roles_capabilities_data_array["google_map_top_bar_menu"] = "enable";
                  $roles_capabilities_data_array["others_full_control_capability"] = "0";
                  $roles_capabilities_data_array["administrator_privileges"] = "1,1,1,1,1,1,1,1,1,1,1,1,1";
                  $roles_capabilities_data_array["author_privileges"] = "0,0,1,0,1,0,0,1,0,0,0,0,0";
                  $roles_capabilities_data_array["editor_privileges"] = "0,0,0,0,1,1,0,0,1,0,0,0,0";
                  $roles_capabilities_data_array["contributor_privileges"] = "0,0,0,0,1,1,0,0,0,0,1,0,0";
                  $roles_capabilities_data_array["subscriber_privileges"] = "0,0,0,0,0,0,0,0,0,0,0,0,0";
                  $roles_capabilities_data_array["other_roles_privileges"] = "0,0,0,0,0,0,0,0,0,0,0,0,0";
                  $user_capabilities = get_others_capabilities_google_maps();
                  $other_roles_array = array();
                  $gmb_other_roles_access_array = array(
                      "manage_options",
                      "edit_plugins",
                      "edit_posts",
                      "publish_posts",
                      "publish_pages",
                      "edit_pages",
                      "read"
                  );
                  foreach ($gmb_other_roles_access_array as $role) {
                     if (in_array($role, $user_capabilities)) {
                        array_push($other_roles_array, $role);
                     }
                  }
                  $roles_capabilities_data_array["capabilities"] = $other_roles_array;

                  $roles_capabilities_data = array();
                  $roles_capabilities_data["meta_id"] = isset($row->id) ? intval($row->id) : 0;
                  $roles_capabilities_data["meta_key"] = "roles_and_capabilities";
                  $roles_capabilities_data["meta_value"] = serialize($roles_capabilities_data_array);
                  $roles_capabilities_data["old_map_id"] = 0;
                  $obj_dbHelper_google_maps->insertCommand(google_maps_meta(), $roles_capabilities_data);
                  break;
            }
         }
      }
      $obj_dbHelper_google_maps = new dbHelper_install_script_google_maps();
      switch ($google_map_version_number) {
         case "":
            google_maps_parent_table();
            google_maps_meta_table();
            break;

         default:
            // Unschedule Schedulers
            if (wp_next_scheduled("google_maps_bank_auto_update")) {
               wp_clear_scheduled_hook("google_maps_bank_auto_update");
            }
            if (wp_next_scheduled("google_maps_optimizer_scheduler")) {
               wp_clear_scheduled_hook("google_maps_optimizer_scheduler");
            }
            if (wp_next_scheduled("check_plugin_updates-google-maps-bank-pro-edition")) {
               wp_clear_scheduled_hook("check_plugin_updates-google-maps-bank-pro-edition");
            }
            global $wpdb;
            if (count($wpdb->get_var("SHOW TABLES LIKE '" . google_maps() . "'")) == 0) {
               google_maps_parent_table();
            }
            if (count($wpdb->get_var("SHOW TABLES LIKE '" . google_maps_meta() . "'")) == 0) {
               google_maps_meta_table();
            }
            /* Drop Tables */

            $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "gmb_marker_category");
            $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "gmb_marker_themes");
            $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "gmb_plugin_settings");

            if (count($wpdb->get_var("SHOW TABLES LIKE '" . $wpdb->prefix . "gmb_maps'")) != 0 && count($wpdb->get_var("SHOW TABLES LIKE '" . $wpdb->prefix . "gmb_maps_meta'")) != 0) {

               function get_maps_overlays_data($overlay_id) {
                  global $wpdb;
                  $overlaydata = $wpdb->get_results
                      (
                      $wpdb->prepare
                          (
                          "SELECT * FROM " . $wpdb->prefix . "gmb_maps_meta
									WHERE map_id = %d", $overlay_id
                      )
                  );
                  foreach ($overlaydata as $value) {
                     $maps_settings_array = array();
                     $unserialize[$value->map_meta_key] = $value->map_meta_value;
                     array_push($maps_settings_array, $unserialize);
                  }
                  return $maps_settings_array;
               }
               $get_map_parent_table_id = $wpdb->get_var
                   (
                   $wpdb->prepare
                       (
                       "SELECT id FROM " . google_maps() . " WHERE type = %s", "maps"
                   )
               );
               $get_map_id = $wpdb->get_results
                   (
                   $wpdb->prepare
                       (
                       "SELECT id FROM " . $wpdb->prefix . "gmb_maps
							WHERE map_type = %s", "map"
                   )
               );
               if (count($get_map_id) > 0) {
                  foreach ($get_map_id as $map_id) {
                     $mapid = isset($map_id->id) ? intval($map_id->id) : 0;
                     $mapdata = $wpdb->get_results
                         (
                         $wpdb->prepare
                             (
                             "SELECT * FROM " . $wpdb->prefix . "gmb_maps_meta
									WHERE map_id = %d", $mapid
                         )
                     );
                     $maps_settings_data = array();
                     foreach ($mapdata as $data) {
                        $maps_settings_data[$data->map_meta_key] = $data->map_meta_value;
                     }

                     $old_maps_data_array = array();
                     $old_maps_data_array["map_title"] = esc_attr($maps_settings_data["map_title"]);
                     $old_maps_data_array["map_description"] = "";
                     $old_maps_data_array["map_address_type"] = "formatted_address";
                     $old_maps_data_array["formatted_address"] = esc_html($maps_settings_data["location_title"]);
                     $old_maps_data_array["map_latitude"] = floatval($maps_settings_data["latitude"]);
                     $old_maps_data_array["map_longitude"] = floatval($maps_settings_data["longitude"]);
                     $map_type = 1;
                     switch (intval($maps_settings_data["map_type"])) {
                        case 1:
                           $map_type = "roadmap";
                           break;
                        case 2:
                           $map_type = "terrain";
                           break;
                        case 3:
                           $map_type = "hybrid";
                           break;
                        case 4:
                           $map_type = "satellite";
                           break;
                     }
                     $old_maps_data_array["map_type"] = $map_type;
                     $old_maps_data_array["map_zoom_level"] = 18;

                     $insert_old_map_data = array();
                     $insert_old_map_data["type"] = "maps_settings";
                     $insert_old_map_data["parent_id"] = isset($get_map_parent_table_id) ? intval($get_map_parent_table_id) : 0;
                     $parent_last_id = $obj_dbHelper_google_maps->insertCommand(google_maps(), $insert_old_map_data);

                     $add_old_maps_meta_data = array();
                     $add_old_maps_meta_data["meta_id"] = $parent_last_id;
                     $add_old_maps_meta_data["meta_key"] = "maps_settings_data";
                     $add_old_maps_meta_data["meta_value"] = serialize($old_maps_data_array);
                     $add_old_maps_meta_data["old_map_id"] = $mapid;
                     $obj_dbHelper_google_maps->insertCommand(google_maps_meta(), $add_old_maps_meta_data);
                     $get_maps_overlay_type = $wpdb->get_results
                         (
                         $wpdb->prepare
                             (
                             "SELECT map_type,id FROM " . $wpdb->prefix . "gmb_maps
									WHERE parent_id = %d", $mapid
                         )
                     );
                     /* Bind Overlays Data */
                     foreach ($get_maps_overlay_type as $overlay_type) {
                        switch ($overlay_type->map_type) {
                           case "marker":
                              $marker_data_array = get_maps_overlays_data($overlay_type->id);
                              foreach ($marker_data_array as $value) {
                                 $old_map_marker_data_array = array();
                                 $old_map_marker_data_array["marker_title"] = esc_attr($value["marker_name"]);
                                 $old_map_marker_data_array["marker_description"] = isset($value["description"]) ? esc_html($value["description"]) : "";
                                 $old_map_marker_data_array["marker_type"] = "formatted_address";
                                 $old_map_marker_data_array["marker_address"] = esc_html($value["marker_location"]);
                                 $old_map_marker_data_array["marker_latitude"] = floatval($value["marker_latitude"]);
                                 $old_map_marker_data_array["marker_longitude"] = floatval($value["marker_longitude"]);
                                 $old_map_marker_data_array["marker_icon_type"] = "choose_icon";
                                 $old_map_marker_data_array["marker_icon_category"] = intval($value["marker_category"]);
                                 $old_map_marker_data_array["marker_icon_url"] = isset($value["map_marker"]) ? esc_attr($value["map_marker"]) : "";
                                 $old_map_marker_data_array["marker_icon_id"] = "";
                                 $old_map_marker_data_array["marker_icon_upload"] = isset($value["map_marker"]) ? esc_attr($value["map_marker"]) : "";
                                 $marker_animation = "none";
                                 switch (intval($value["animation"])) {
                                    case 0:
                                       $marker_animation = "drop";
                                       break;
                                    case 1:
                                       $marker_animation = "bounce";
                                       break;
                                 }
                                 $old_map_marker_data_array["marker_animation"] = $marker_animation;
                                 $marker_infowindow = "disable";
                                 switch (intval($value["info_window"])) {
                                    case 0:
                                       $marker_infowindow = "disable";
                                       break;
                                    case 1:
                                       $marker_infowindow = "enable";
                                       break;
                                 }
                                 $old_map_marker_data_array["marker_info_window_show_hide"] = $marker_infowindow;
                                 $old_map_marker_data_array["marker_info_window_upload_path"] = isset($value["info_window_image_url"]) ? esc_attr($value["info_window_image_url"]) : "";

                                 $insert_old_marker_meta_data = array();
                                 $insert_old_marker_meta_data["meta_id"] = $parent_last_id;
                                 $insert_old_marker_meta_data["meta_key"] = "marker_settings_data";
                                 $insert_old_marker_meta_data["meta_value"] = serialize($old_map_marker_data_array);
                                 $insert_old_marker_meta_data["old_map_id"] = $mapid;
                                 $obj_dbHelper_google_maps->insertCommand(google_maps_meta(), $insert_old_marker_meta_data);
                              }
                              break;
                           case "polygon":
                              $polygon_data_array = get_maps_overlays_data($overlay_type->id);
                              foreach ($polygon_data_array as $value) {
                                 $old_map_polygon_data_array = array();
                                 $old_map_polygon_data_array["polygon_title"] = "Untitled Polygon";
                                 $old_map_polygon_data_array["polygon_description"] = "";
                                 $old_map_polygon_data_array["polygon_stroke_weight"] = "2";
                                 $old_map_polygon_data_array["polygon_stroke_color_style"] = esc_attr($value["polygon_line_color"]) . "," . intval(floatval($value["polygon_line_opacity"]) * 100);
                                 $polygon_coordinates = explode("\n", esc_attr($value["polygon_data"]));
                                 $corrdinates_data = array_filter(array_map("trim", $polygon_coordinates), "strlen");
                                 $coordinates = "";
                                 $flag = 0;
                                 foreach ($corrdinates_data as $data) {
                                    if ($flag <= count($corrdinates_data) - 1) {
                                       $coordinates .= "[" . $data . "]\n";
                                    }
                                    $polygon_corrdinates_data = $coordinates;
                                 }
                                 $old_map_polygon_data_array["polygon_coordinates"] = $polygon_corrdinates_data;
                                 $old_map_polygon_data_array["polygon_fill_color_style"] = esc_attr($value["polygon_color"]) . "," . intval(floatval($value["polygon_opacity"]) * 100);
                                 $old_map_polygon_data_array["polygon_info_window"] = "disable";
                                 $old_map_polygon_data_array["polygon_image_upload_path"] = "";

                                 $insert_old_polygon_meta_data = array();
                                 $insert_old_polygon_meta_data["meta_id"] = $parent_last_id;
                                 $insert_old_polygon_meta_data["meta_key"] = "polygon_settings_data";
                                 $insert_old_polygon_meta_data["meta_value"] = serialize($old_map_polygon_data_array);
                                 $insert_old_polygon_meta_data["old_map_id"] = $mapid;
                                 $obj_dbHelper_google_maps->insertCommand(google_maps_meta(), $insert_old_polygon_meta_data);
                              }
                              break;
                           case "polyline":
                              $polyline_data_array = get_maps_overlays_data($overlay_type->id);
                              foreach ($polyline_data_array as $value) {
                                 $old_map_polyline_data_array = array();
                                 $old_map_polyline_data_array["polyline_title"] = "Untitled Polyline";
                                 $old_map_polyline_data_array["polyline_description"] = "";
                                 $old_map_polyline_data_array["polyline_stroke_width"] = isset($value["polyline_thickness"]) ? intval($value["polyline_thickness"]) : "";
                                 $old_map_polyline_data_array["polyline_stroke_color_opacity"] = esc_attr($value["polyline_color"]) . "," . intval(floatval($value["polyline_opacity"]) * 100);
                                 $polyline_type = "solid";
                                 switch (intval($value["polyline_type"])) {
                                    case 0 :
                                       $polyline_type = "solid";
                                       break;
                                    case 1 :
                                       $polyline_type = "dotted";
                                       break;
                                    case 2 :
                                       $polyline_type = "dashed";
                                       break;
                                 }
                                 $old_map_polyline_data_array["polyline_type"] = $polyline_type;
                                 $polyline_coordinates = explode("\n", esc_attr($value["polyline_data"]));
                                 $corrdinates_data = array_filter(array_map("trim", $polyline_coordinates), 'strlen');
                                 $coordinates = "";
                                 $flag = 0;
                                 foreach ($corrdinates_data as $value) {
                                    if ($flag <= count($corrdinates_data) - 1) {
                                       $coordinates .= "[" . $value . "]\n";
                                    }
                                    $polyline_corrdinates_data = $coordinates;
                                 }
                                 $old_map_polyline_data_array["polyline_cordinates"] = $polyline_corrdinates_data;
                                 $old_map_polyline_data_array["polyline_info_window"] = "disable";
                                 $old_map_polyline_data_array["image_upload_polyline_path"] = "";

                                 $insert_old_polyline_meta_data = array();
                                 $insert_old_polyline_meta_data["meta_id"] = $parent_last_id;
                                 $insert_old_polyline_meta_data["meta_key"] = "polyline_settings_data";
                                 $insert_old_polyline_meta_data["meta_value"] = serialize($old_map_polyline_data_array);
                                 $insert_old_polyline_meta_data["old_map_id"] = $mapid;
                                 $obj_dbHelper_google_maps->insertCommand(google_maps_meta(), $insert_old_polyline_meta_data);
                              }
                              break;
                        }
                     }
                     $old_maps_layers_data = array();
                     $old_maps_layers_data["bicycling_layer"] = isset($maps_settings_data["bicycling_layer"]) && intval($maps_settings_data["bicycling_layer"]) == 1 ? "show" : "hide";
                     $old_maps_layers_data["traffic_layer"] = isset($maps_settings_data["traffic_layer"]) && intval($maps_settings_data["traffic_layer"]) == 1 ? "show" : "hide";
                     $old_maps_layers_data["transit_layer"] = isset($maps_settings_data["transit_layer"]) && intval($maps_settings_data["transit_layer"]) == 1 ? "show" : "hide";
                     $old_maps_layers_data["heatmap_layer"] = "hide";
                     $old_maps_layers_data["heatmap_gradient_color"] = "hide";
                     $old_maps_layers_data["heatmap_coordinates"] = "";
                     $old_maps_layers_data["heatmap_opacity"] = "75";
                     $old_maps_layers_data["heatmap_radius"] = "20";
                     $old_maps_layers_data["fusion_table_layer"] = isset($maps_settings_data["fussion_table_layer"]) && intval($maps_settings_data["fussion_table_layer"]) == 1 ? "show" : "hide";
                     $old_maps_layers_data["fusion_table_id"] = isset($maps_settings_data["fussion_layer_table_name"]) ? esc_attr($maps_settings_data["fussion_layer_table_name"]) : "";
                     $old_maps_layers_data["kml_layer"] = isset($maps_settings_data["kml_layer"]) && intval($maps_settings_data["kml_layer"]) == 1 ? "show" : "hide";
                     $old_maps_layers_data["kml_url"] = isset($maps_settings_data["kml_layer_link"]) ? esc_attr($maps_settings_data["kml_layer_link"]) : "";

                     $insert_maps_layers_data_array = array();
                     $insert_maps_layers_data_array["meta_id"] = $parent_last_id;
                     $insert_maps_layers_data_array["meta_key"] = "layers_settings_data";
                     $insert_maps_layers_data_array["meta_value"] = serialize($old_maps_layers_data);
                     $insert_maps_layers_data_array["old_map_id"] = $mapid;
                     $obj_dbHelper_google_maps->insertCommand(google_maps_meta(), $insert_maps_layers_data_array);

                     if (isset($maps_settings_data["circle_overlay"]) && intval($maps_settings_data["circle_overlay"]) == 1) {
                        $old_map_circle_data_array = array();
                        $old_map_circle_data_array["circle_title"] = esc_attr($maps_settings_data["map_title"]);
                        $old_map_circle_data_array["circle_description"] = "";
                        $old_map_circle_data_array["circle_stroke_weight"] = intval($maps_settings_data["circle_weight"]);
                        $old_map_circle_data_array["circle_stroke_color"] = esc_attr($maps_settings_data["stroke_color"]) . "," . intval(floatval($maps_settings_data["circle_opacity"]) * 100);
                        $old_map_circle_data_array["circle_fill_color"] = esc_attr($maps_settings_data["fill_color"]) . ",75";
                        $old_map_circle_data_array["circle_radius_type"] = "miles";
                        $old_map_circle_data_array["circle_radius_value"] = intval($maps_settings_data["circle_radius"]);
                        $old_map_circle_data_array["circle_coordinates"] = "Latitude : " . floatval($maps_settings_data["latitude"]) . "\nLongitude : " . floatval($maps_settings_data["longitude"]);
                        $old_map_circle_data_array["circle_info_window"] = "disable";
                        $old_map_circle_data_array["image_upload_circle_path"] = "";

                        $insert_old_circle_data = array();
                        $insert_old_circle_data["meta_id"] = $parent_last_id;
                        $insert_old_circle_data["meta_key"] = "circle_data";
                        $insert_old_circle_data["meta_value"] = serialize($old_map_circle_data_array);
                        $insert_old_circle_data["old_map_id"] = $mapid;
                        $obj_dbHelper_google_maps->insertCommand(google_maps_meta(), $insert_old_circle_data);
                     }
                  }
               }
               $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "gmb_maps");
               $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "gmb_maps_meta");
            }
            break;
      }
      update_option("google-maps-bank-version-number", "2.0.0");
   }
}