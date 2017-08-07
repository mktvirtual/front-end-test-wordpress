<?php
/**
 * This file is used  for managing database.
 *
 * @author Tech Banker
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
      if (isset($_REQUEST["param"])) {
         $obj_helper_google_map = new dbHelper_google_maps();
         function get_google_maps_parent_id($type) {
            global $wpdb;
            $parent_id = $wpdb->get_var
                (
                $wpdb->prepare
                    (
                    "SELECT id FROM " . google_maps() . "
							WHERE type = %s", $type
                )
            );
            return $parent_id;
         }
         switch (esc_attr($_REQUEST["param"])) {
            case "wizard_google_maps_bank":
               if (wp_verify_nonce((isset($_REQUEST["_wp_nonce"]) ? esc_attr($_REQUEST["_wp_nonce"]) : ""), "google_maps_check_status")) {
                  $type = isset($_REQUEST["type"]) ? esc_attr($_REQUEST["type"]) : "";
                  update_option("google-map-bank-wizard-set-up", $type);
                  if ($type == "opt_in") {
                     $plugin_info_google_maps_bank = new plugin_info_google_maps_bank();
                     global $wp_version;
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
                     $plugin_stat_data["event"] = "activate";
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
               break;
            case "delete_data_google_maps":
               if (wp_verify_nonce(isset($_REQUEST["_wp_nonce"]) ? esc_attr($_REQUEST["_wp_nonce"]) : "", "google_maps_delete_nonce")) {
                  $meta_id = isset($_REQUEST["id"]) ? intval($_REQUEST["id"]) : "";
                  $where = array();

                  $where["id"] = $meta_id;
                  $obj_helper_google_map->deleteCommand(google_maps_meta(), $where);
               }
               break;

            case "delete_maps_data_google_maps":
               if (wp_verify_nonce(isset($_REQUEST["_wp_nonce"]) ? esc_attr($_REQUEST["_wp_nonce"]) : "", "google_maps_data_delete_nonce")) {
                  $meta_id = isset($_REQUEST["id"]) ? intval($_REQUEST["id"]) : "";
                  $where_parent = array();
                  $where = array();

                  $where_parent["id"] = $meta_id;
                  $where["meta_id"] = $meta_id;
                  $obj_helper_google_map->deleteCommand(google_maps(), $where_parent);
                  $obj_helper_google_map->deleteCommand(google_maps_meta(), $where);
               }
               break;

            case "google_maps_add_maps":
               if (wp_verify_nonce(isset($_REQUEST["_wp_nonce"]) ? esc_attr($_REQUEST["_wp_nonce"]) : "", "google_maps_add_maps_nonce")) {
                  parse_str(isset($_REQUEST["data"]) ? base64_decode($_REQUEST["data"]) : "", $maps_form_data);

                  $parent_id = get_google_maps_parent_id("maps");
                  $map_id = isset($_REQUEST["id"]) ? intval($_REQUEST["id"]) : "";

                  $maps_data_array = array();
                  $maps_data_array["map_title"] = esc_attr($maps_form_data["ux_txt_map_title"]);
                  $maps_data_array["map_description"] = esc_attr($maps_form_data["ux_txt_map_description"]);
                  $maps_data_array["map_address_type"] = esc_attr($maps_form_data["ux_chk_map_formatted_address"]);
                  $maps_data_array["formatted_address"] = esc_html($maps_form_data["ux_txt_address"]);
                  $maps_data_array["map_latitude"] = floatval($maps_form_data["ux_txt_latitude"]);
                  $maps_data_array["map_longitude"] = floatval($maps_form_data["ux_txt_longitude"]);
                  $maps_data_array["map_type"] = esc_attr($maps_form_data["ux_ddl_map_type"]);
                  $maps_data_array["map_zoom_level"] = intval($maps_form_data["ux_ddl_map_zoom_level"]);
                  if ($map_id == "") {
                     $add_maps_parent_data = array();
                     $add_maps_parent_data["type"] = "maps_settings";
                     $add_maps_parent_data["parent_id"] = isset($parent_id) ? intval($parent_id) : 0;
                     $parent_last_id = $obj_helper_google_map->insertCommand(google_maps(), $add_maps_parent_data);

                     $add_maps_meta_data = array();
                     $add_maps_meta_data["meta_id"] = $parent_last_id;
                     $add_maps_meta_data["meta_key"] = "maps_settings_data";
                     $add_maps_meta_data["meta_value"] = serialize($maps_data_array);
                     $add_maps_meta_data["old_map_id"] = $parent_last_id;
                     $obj_helper_google_map->insertCommand(google_maps_meta(), $add_maps_meta_data);
                     echo $parent_last_id;
                  } else {
                     $update_maps_data_array = array();
                     $where = array();
                     $where["meta_id"] = $map_id;
                     $where["meta_key"] = "maps_settings_data";
                     $update_maps_data_array["meta_value"] = serialize($maps_data_array);
                     $obj_helper_google_map->updateCommand(google_maps_meta(), $update_maps_data_array, $where);
                     echo $map_id;
                  }
               }
               break;

            case "google_maps_add_marker":
               if (wp_verify_nonce(isset($_REQUEST["_wp_nonce"]) ? esc_attr($_REQUEST["_wp_nonce"]) : "", "google_maps_add_marker_nonce")) {
                  parse_str(isset($_REQUEST["data"]) ? base64_decode($_REQUEST["data"]) : "", $marker_form_data);
                  $map_id = isset($_REQUEST["id"]) ? intval($_REQUEST["id"]) : "";

                  $marker_data_array = array();
                  $marker_data_array["marker_title"] = esc_attr($marker_form_data["ux_txt_marker_title"]);
                  $marker_data_array["marker_description"] = esc_html($marker_form_data["ux_txt_marker_desc"]);
                  $marker_data_array["marker_type"] = esc_attr($marker_form_data["ux_chk_formatted_address"]);
                  $marker_data_array["marker_address"] = esc_html($marker_form_data["ux_txt_marker_address"]);
                  $marker_data_array["marker_latitude"] = floatval($marker_form_data["ux_txt_marker_latitude"]);
                  $marker_data_array["marker_longitude"] = floatval($marker_form_data["ux_txt_marker_longitude"]);
                  $marker_data_array["marker_icon_type"] = esc_attr($marker_form_data["ux_ddl_marker_icon"]);
                  $marker_data_array["marker_icon_category"] = esc_attr($marker_form_data["ux_ddl_marker_category"]);
                  $marker_data_array["marker_icon_url"] = isset($_REQUEST["icon_url"]) ? esc_attr($_REQUEST["icon_url"]) : "";
                  $marker_data_array["marker_icon_id"] = isset($_REQUEST["icon_id"]) ? esc_attr($_REQUEST["icon_id"]) : "";
                  $marker_data_array["marker_icon_upload"] = esc_attr($marker_form_data["ux_txt_marker_icon_path"]);
                  $marker_data_array["marker_animation"] = esc_attr($marker_form_data["ux_ddl_marker_animation"]);
                  $marker_data_array["marker_info_window_show_hide"] = esc_attr($marker_form_data["ux_ddl_info_window"]);
                  $marker_data_array["marker_info_window_upload_path"] = esc_attr($marker_form_data["ux_txt_image_upload_path"]);
                  $edit_id = isset($_REQUEST["edit"]) ? intval($_REQUEST["edit"]) : "";
                  if ($edit_id != "") {
                     $update_marker_data_array = array();
                     $update_marker_data_array["meta_value"] = serialize($marker_data_array);

                     $where = array();
                     $where["id"] = $edit_id;
                     $where["meta_key"] = "marker_settings_data";
                     $obj_helper_google_map->updateCommand(google_maps_meta(), $update_marker_data_array, $where);
                  } else {
                     $add_marker_data_array = array();
                     $add_marker_data_array["meta_id"] = $map_id;
                     $add_marker_data_array["meta_key"] = "marker_settings_data";
                     $add_marker_data_array["meta_value"] = serialize($marker_data_array);
                     $add_marker_data_array["old_map_id"] = $map_id;
                     $obj_helper_google_map->insertCommand(google_maps_meta(), $add_marker_data_array);
                  }
                  echo $map_id;
               }
               break;

            case "google_map_polygon_module" :
               if (wp_verify_nonce(isset($_REQUEST["_wp_nonce"]) ? esc_attr($_REQUEST["_wp_nonce"]) : "", "google_maps_polygon_nonce")) {
                  parse_str(isset($_REQUEST["data"]) ? base64_decode($_REQUEST["data"]) : "", $polygon_form_data);
                  $map_id = isset($_REQUEST["id"]) ? intval($_REQUEST["id"]) : "";
                  $edit_id = isset($_REQUEST["edit"]) ? intval($_REQUEST["edit"]) : "";

                  $polygon_form_data_array = array();
                  $polygon_form_data_array["polygon_title"] = esc_attr($polygon_form_data["ux_txt_polygon_title"]);
                  $polygon_form_data_array["polygon_description"] = esc_attr($polygon_form_data["ux_txt_polygon_desc"]);
                  $polygon_form_data_array["polygon_stroke_weight"] = intval($polygon_form_data["ux_ddl_polygon_weight"]);
                  $polygon_form_data_array["polygon_stroke_color_style"] = esc_attr(implode(",", $polygon_form_data["ux_txt_polygon_stroke_color_style"]));
                  $polygon_form_data_array["polygon_fill_color_style"] = esc_attr(implode(",", $polygon_form_data["ux_txt_polygon_fill_color_style"]));
                  $polygon_form_data_array["polygon_coordinates"] = esc_attr($polygon_form_data["ux_txt_polygon_coordinate"]);
                  $polygon_form_data_array["polygon_info_window"] = esc_attr($polygon_form_data["ux_ddl_polygon_info_window"]);
                  $polygon_form_data_array["polygon_image_upload_path"] = esc_attr($polygon_form_data["ux_txt_image_upload_polygon_path"]);
                  if ($edit_id == "") {
                     $polygon_data_array = array();
                     $polygon_data_array["meta_id"] = $map_id;
                     $polygon_data_array["meta_key"] = "polygon_settings_data";
                     $polygon_data_array["meta_value"] = serialize($polygon_form_data_array);
                     $polygon_data_array["old_map_id"] = $map_id;
                     $obj_helper_google_map->insertCommand(google_maps_meta(), $polygon_data_array);
                  } else {
                     $update_polygon_data_array = array();
                     $update_polygon_data_array["meta_value"] = serialize($polygon_form_data_array);

                     $where = array();
                     $where["id"] = $edit_id;
                     $where["meta_key"] = "polygon_settings_data";
                     $obj_helper_google_map->updateCommand(google_maps_meta(), $update_polygon_data_array, $where);
                  }
                  echo $map_id;
               }
               break;

            case "google_maps_add_polyline":
               if (wp_verify_nonce(isset($_REQUEST["_wp_nonce"]) ? esc_attr($_REQUEST["_wp_nonce"]) : "", "google_maps_add_polyline_nonce")) {
                  parse_str(isset($_REQUEST["data"]) ? base64_decode($_REQUEST["data"]) : "", $polyline_form_data);
                  $map_id = isset($_REQUEST["id"]) ? intval(($_REQUEST["id"])) : 0;
                  $edit_id = isset($_REQUEST["edit"]) ? intval($_REQUEST["edit"]) : "";

                  $add_polyline_array = array();
                  $add_polyline_array["polyline_title"] = esc_attr($polyline_form_data["ux_txt_polyline_title"]);
                  $add_polyline_array["polyline_description"] = esc_attr($polyline_form_data["ux_txt_polyline_description"]);
                  $add_polyline_array["polyline_stroke_width"] = esc_html($polyline_form_data["ux_ddl_polyine_line_weight"]);
                  $add_polyline_array["polyline_stroke_color_opacity"] = esc_attr(implode(",", $polyline_form_data["ux_txt_polyline_line_color"]));
                  $add_polyline_array["polyline_type"] = esc_attr($polyline_form_data["ux_ddl_polyline_type"]);
                  $add_polyline_array["polyline_cordinates"] = esc_attr($polyline_form_data["ux_div_polyline_coordinate"]);
                  $add_polyline_array["polyline_info_window"] = esc_attr($polyline_form_data["ux_ddl_polyline_info_window"]);
                  $add_polyline_array["image_upload_polyline_path"] = esc_attr($polyline_form_data["ux_txt_image_upload_polyline_path"]);
                  if ($edit_id == "") {
                     $add_polyline_data_array = array();
                     $add_polyline_data_array["meta_id"] = $map_id;
                     $add_polyline_data_array["meta_key"] = "polyline_settings_data";
                     $add_polyline_data_array["meta_value"] = serialize($add_polyline_array);
                     $add_polyline_data_array["old_map_id"] = $map_id;
                     $obj_helper_google_map->insertCommand(google_maps_meta(), $add_polyline_data_array);
                  } else {
                     $update_polyline_data_array = array();
                     $where = array();

                     $where["id"] = $edit_id;
                     $where["meta_key"] = "polyline_settings_data";
                     $update_polyline_data_array["meta_value"] = serialize($add_polyline_array);
                     $obj_helper_google_map->updateCommand(google_maps_meta(), $update_polyline_data_array, $where);
                  }
                  echo $map_id;
               }
               break;

            case "google_map_overlay_circle":
               if (wp_verify_nonce(isset($_REQUEST["_wp_nonce"]) ? esc_attr($_REQUEST["_wp_nonce"]) : "", "google_map_add_circle_nonce")) {
                  parse_str(isset($_REQUEST["data"]) ? base64_decode($_REQUEST["data"]) : "", $circle_form_data);
                  $id = isset($_REQUEST["id"]) ? intval($_REQUEST["id"]) : "";
                  $edit_id = isset($_REQUEST["edit"]) ? intval($_REQUEST["edit"]) : "";

                  $circle_data_array = array();
                  $circle_data_array["circle_title"] = esc_attr($circle_form_data["ux_txt_circle_title"]);
                  $circle_data_array["circle_description"] = esc_attr($circle_form_data["ux_txt_circle_desc"]);
                  $circle_data_array["circle_stroke_weight"] = intval($circle_form_data["ux_ddl_circle_weight"]);
                  $circle_data_array["circle_stroke_color"] = esc_attr(implode(",", $circle_form_data["ux_txt_circle_stroke_color"]));
                  $circle_data_array["circle_fill_color"] = esc_attr(implode(",", $circle_form_data["ux_txt_circle_fill_color"]));
                  $circle_data_array["circle_radius_value"] = intval($circle_form_data["ux_txt_circle_radius_value"]);
                  $circle_data_array["circle_radius_type"] = esc_attr($circle_form_data["ux_txt_circle_radius_type"]);
                  $circle_data_array["circle_coordinates"] = esc_attr($circle_form_data["ux_txt_circle_coordinate"]);
                  $circle_data_array["circle_info_window"] = esc_html($circle_form_data["ux_ddl_circle_info_window"]);
                  $circle_data_array["image_upload_circle_path"] = esc_attr($circle_form_data["ux_txt_image_upload_circle_path"]);
                  if ($edit_id == "") {
                     $add_circle_data = array();
                     $add_circle_data["meta_id"] = $id;
                     $add_circle_data["meta_key"] = "circle_data";
                     $add_circle_data["meta_value"] = serialize($circle_data_array);
                     $add_circle_data["old_map_id"] = $id;
                     $obj_helper_google_map->insertCommand(google_maps_meta(), $add_circle_data);
                  } else {
                     $update_circle_data = array();
                     $where = array();
                     $where["id"] = $edit_id;
                     $where["meta_key"] = "circle_data";
                     $update_circle_data["meta_value"] = serialize($circle_data_array);
                     $obj_helper_google_map->updateCommand(google_maps_meta(), $update_circle_data, $where);
                  }
                  echo $id;
               }
               break;

            case "add_maps_layers":
               if (wp_verify_nonce(isset($_REQUEST["_wp_nonce"]) ? esc_attr($_REQUEST["_wp_nonce"]) : "", "add_maps_layers_nonce")) {
                  parse_str(isset($_REQUEST["data"]) ? base64_decode($_REQUEST["data"]) : "", $maps_layers_form_data);
                  $map_id = isset($_REQUEST["id"]) ? intval($_REQUEST["id"]) : 0;

                  $add_maps_layers_data = array();
                  $add_maps_layers_data["bicycling_layer"] = "hide";
                  $add_maps_layers_data["traffic_layer"] = "hide";
                  $add_maps_layers_data["transit_layer"] = "hide";
                  $add_maps_layers_data["heatmap_layer"] = "hide";
                  $add_maps_layers_data["heatmap_gradient_color"] = "hide";
                  $add_maps_layers_data["heatmap_coordinates"] = "";
                  $add_maps_layers_data["heatmap_opacity"] = "75";
                  $add_maps_layers_data["heatmap_radius"] = "20";
                  $add_maps_layers_data["fusion_table_layer"] = "hide";
                  $add_maps_layers_data["fusion_table_id"] = "";
                  $add_maps_layers_data["kml_layer"] = "hide";
                  $add_maps_layers_data["kml_url"] = "";

                  global $wpdb;
                  $unserialize_layers_data = $wpdb->get_var
                      (
                      $wpdb->prepare
                          (
                          "SELECT meta_key FROM " . google_maps_meta() . "
								WHERE meta_id=%d AND meta_key=%s", $map_id, "layers_settings_data"
                      )
                  );
                  if (count($unserialize_layers_data) == 0) {
                     $maps_layers_data_array = array();
                     $maps_layers_data_array["meta_id"] = $map_id;
                     $maps_layers_data_array["meta_key"] = "layers_settings_data";
                     $maps_layers_data_array["meta_value"] = serialize($add_maps_layers_data);
                     $maps_layers_data_array["old_map_id"] = $map_id;
                     $obj_helper_google_map->insertCommand(google_maps_meta(), $maps_layers_data_array);
                  } else {
                     $update_map_layers_data_array = array();
                     $where = array();
                     $where["meta_id"] = $map_id;
                     $where["meta_key"] = "layers_settings_data";
                     $update_map_layers_data_array["meta_value"] = serialize($add_maps_layers_data);
                     $obj_helper_google_map->updateCommand(google_maps_meta(), $update_map_layers_data_array, $where);
                  }
               }
               break;

            case "delete_store_locator_google_maps":
               if (wp_verify_nonce(isset($_REQUEST["_wp_nonce"]) ? esc_attr($_REQUEST["_wp_nonce"]) : "", "store_locator_delete_nonce")) {
                  $meta_id = isset($_REQUEST["id"]) ? intval($_REQUEST["id"]) : "";
                  $where_parent = array();
                  $where = array();

                  $where_parent["id"] = $meta_id;
                  $where["meta_id"] = $meta_id;
                  $obj_helper_google_map->deleteCommand(google_maps(), $where_parent);
                  $obj_helper_google_map->deleteCommand(google_maps_meta(), $where);
               }
               break;

            case "gmb_info_window_module" :
               if (wp_verify_nonce(isset($_REQUEST["_wp_nonce"]) ? esc_attr($_REQUEST["_wp_nonce"]) : "", "info_window_nonce")) {
                  parse_str(isset($_REQUEST["data"]) ? base64_decode($_REQUEST["data"]) : "", $info_window_form_data);

                  $info_window_data = array();
                  $info_window_data["info_window_width"] = intval($info_window_form_data["ux_txt_info_window_width"]);
                  $info_window_data["info_window_open_event"] = esc_attr($info_window_form_data["ux_ddl_info_window_event"]);
                  $info_window_data["info_window_title_style"] = esc_attr(implode(",", $info_window_form_data["ux_txt_title_font_size_and_color"]));
                  $info_window_data["info_window_title_font_family"] = "Roboto Condensed";
                  $info_window_data["info_window_desc_style"] = esc_attr(implode(",", $info_window_form_data["ux_txt_description_font_size_and_color"]));
                  $info_window_data["info_window_desc_font_family"] = "Roboto Condensed";
                  $info_window_data["info_window_border_style"] = esc_attr(implode(",", $info_window_form_data["ux_txt_border_style"]));
                  $info_window_data["info_window_border_radius"] = intval($info_window_form_data["ux_txt_border_radius"]);
                  $info_window_data["info_windows_image_padding"] = "0,10,0,0";
                  $info_window_data["info_windows_text_padding"] = "0,0,0,0";
                  $info_window_data["info_window_image_position"] = esc_attr($info_window_form_data["ux_ddl_info_window_img_position"]);

                  $update_info_window_array = array();
                  $where = array();
                  $where["meta_key"] = "info_window_settings";
                  $update_info_window_array["meta_value"] = serialize($info_window_data);
                  $obj_helper_google_map->updateCommand(google_maps_meta(), $update_info_window_array, $where);
               }
               break;

            case "google_map_customization_module":
               if (wp_verify_nonce(isset($_REQUEST["_wp_nonce"]) ? esc_attr($_REQUEST["_wp_nonce"]) : "", "google_map_customization_nonce")) {
                  parse_str(isset($_REQUEST["data"]) ? base64_decode($_REQUEST["data"]) : "", $map_customization_form_data);
                  $map_customization_data_array = array();
                  $map_customization_data_array["map_title_html_tag"] = esc_html($map_customization_form_data["ux_ddl_map_title_html_tag"]);
                  $map_customization_data_array["map_title_text_alignment"] = esc_html($map_customization_form_data["ux_ddl_map_title_alignment"]);
                  $map_customization_data_array["map_title_font_style"] = esc_attr(implode(",", $map_customization_form_data["ux_txt_map_title_style"]));
                  $map_customization_data_array["map_title_font_family"] = "Roboto Condensed";
                  $map_customization_data_array["map_title_margin"] = "0,0,0,0";
                  $map_customization_data_array["map_title_padding"] = "0,0,0,0";
                  $map_customization_data_array["map_description_html_tag"] = esc_html($map_customization_form_data["ux_ddl_description_html_tag"]);
                  $map_customization_data_array["map_description_text_alignment"] = esc_html($map_customization_form_data["ux_ddl_map_description_alignment"]);
                  $map_customization_data_array["map_description_font_style"] = esc_attr(implode(",", $map_customization_form_data["ux_txt_map_description_style"]));
                  $map_customization_data_array["map_description_font_family"] = "Roboto Condensed";
                  $map_customization_data_array["map_description_margin"] = "0,0,0,0";
                  $map_customization_data_array["map_description_padding"] = "0,0,0,0";

                  $map_customization_data_array["map_draggable"] = esc_html($map_customization_form_data["ux_ddl_map_draggable"]);
                  $map_customization_data_array["map_type"] = esc_html($map_customization_form_data["ux_ddl_map_type"]);
                  $map_customization_data_array["map_type_control_position"] = esc_html($map_customization_form_data["ux_ddl_map_type_control_position"]);
                  $map_customization_data_array["map_type_control_style"] = esc_html($map_customization_form_data["ux_ddl_map_type_control_style"]);
                  $map_customization_data_array["map_double_click_zoom"] = esc_html($map_customization_form_data["ux_ddl_map_double_click_zoom"]);
                  $map_customization_data_array["mouse_wheel_scrolling"] = esc_html($map_customization_form_data["ux_ddl_mouse_wheel_scrolling"]);
                  $map_customization_data_array["full_screen_control"] = esc_html($map_customization_form_data["ux_ddl_full_screen_control"]);
                  $map_customization_data_array["full_screen_control_position"] = esc_html($map_customization_form_data["ux_ddl_full_screen_control_position"]);
                  $map_customization_data_array["street_view_control"] = esc_html($map_customization_form_data["ux_ddl_street_view_control"]);
                  $map_customization_data_array["street_view_control_position"] = esc_html($map_customization_form_data["ux_ddl_street_view_control_position"]);
                  $map_customization_data_array["rotate_control"] = esc_html($map_customization_form_data["ux_ddl_rotate_control"]);
                  $map_customization_data_array["scale_control"] = esc_html($map_customization_form_data["ux_ddl_scale_control"]);
                  $map_customization_data_array["map_zoom_control"] = esc_html($map_customization_form_data["ux_ddl_map_zoom_control"]);
                  $map_customization_data_array["map_zoom_control_alignment"] = esc_html($map_customization_form_data["ux_ddl_map_zoom_control_alignment"]);


                  $update_map_customization_data = array();
                  $where = array();
                  $where["meta_key"] = "map_customization";
                  $update_map_customization_data["meta_value"] = serialize($map_customization_data_array);
                  $obj_helper_google_map->updateCommand(google_maps_meta(), $update_map_customization_data, $where);
               }
               break;

            case "gmb_other_settings_module":
               if (wp_verify_nonce(isset($_REQUEST["_wp_nonce"]) ? esc_attr($_REQUEST["_wp_nonce"]) : "", "other_settings_nonce")) {
                  parse_str(isset($_REQUEST["data"]) ? base64_decode($_REQUEST["data"]) : "", $other_settings_form_data);

                  $other_settings_data = array();
                  $other_settings_data["remove_tables_at_uninstall"] = esc_html($other_settings_form_data["ux_ddl_remove_tables"]);
                  $other_settings_data["other_api_key"] = esc_attr($other_settings_form_data["ux_txt_other_api_key"]);
                  $other_settings_data["other_settings_map_language"] = htmlspecialchars_decode($other_settings_form_data["ux_ddl_map_language"]);
                  $other_settings_data["ip_address_fetching_method"] = esc_html($other_settings_form_data["ux_ddl_fetching_method"]);
                  $update_other_settings_array = array();
                  $where = array();
                  $where["meta_key"] = "other_settings";
                  $update_other_settings_array["meta_value"] = serialize($other_settings_data);
                  $obj_helper_google_map->updateCommand(google_maps_meta(), $update_other_settings_array, $where);
               }
               break;
         }
         die();
      }
   }
}