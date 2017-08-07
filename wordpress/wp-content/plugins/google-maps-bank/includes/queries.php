<?php
/**
 * This file is used for fetching data from database.
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

      function get_google_map_meta_data($meta_key) {
         global $wpdb;
         $data = $wpdb->get_var
             (
             $wpdb->prepare
                 (
                 "SELECT meta_value FROM " . google_maps_meta() . "
						WHERE meta_key=%s", $meta_key
             )
         );
         return maybe_unserialize($data);
      }
      function get_google_map_settings($mapid, $meta_key) {
         global $wpdb;
         $maps_settings = $wpdb->get_var
             (
             $wpdb->prepare
                 (
                 "SELECT meta_value FROM " . google_maps_meta() . "
						WHERE meta_id = %d AND meta_key = %s", $mapid, $meta_key
             )
         );
         return maybe_unserialize($maps_settings);
      }
      function get_google_maps_unserialize_data($meta_key) {
         global $wpdb;
         $unserialize_data = $wpdb->get_results
             (
             $wpdb->prepare
                 (
                 "SELECT meta_id,meta_value FROM " . google_maps_meta() . "
						WHERE meta_key=%s ORDER BY meta_id DESC", $meta_key
             )
         );
         $serialize_data = array();
         foreach ($unserialize_data as $value) {
            $unserialize = maybe_unserialize($value->meta_value);
            $unserialize["meta_id"] = $value->meta_id;
            array_push($serialize_data, $unserialize);
         }
         return $serialize_data;
      }
      function get_google_maps_info_window($details_info_window) {
         $fonts_family_array = array(stripslashes(htmlspecialchars_decode($details_info_window["info_window_title_font_family"])), stripslashes(htmlspecialchars_decode($details_info_window["info_window_desc_font_family"])));
         $font_array = array_unique($fonts_family_array);

         $url = is_ssl() ? "https://fonts.googleapis.com/css?family=" : "http://fonts.googleapis.com/css?family=";
         if (isset($font_array) && count($font_array) > 0) {
            foreach ($font_array as $key) {
               ?>
               <link rel="stylesheet" type="text/css" href="<?php echo $url . htmlentities($key) ?>">
               <?php
            }
         }
         $info_title_font_family = google_maps_url_get_contents("http://fonts.googleapis.com/css?family=" . google_maps_urlencode(stripslashes(htmlspecialchars_decode($details_info_window["info_window_title_font_family"]))));
         $info_description_font_family = google_maps_url_get_contents("http://fonts.googleapis.com/css?family=" . google_maps_urlencode(stripslashes(htmlspecialchars_decode($details_info_window["info_window_desc_font_family"]))));
         $info_store_title_font_family_class = str_replace("@font-face", "store-title-style", $info_title_font_family);
         $info_store_description_font_family_class = str_replace("@font-face", "store-description-style", $info_description_font_family);

         $infowindow_border_style = isset($details_info_window["info_window_border_style"]) ? explode(",", esc_attr($details_info_window["info_window_border_style"])) : "0,none,#000000";
         $info_window_image_padding = isset($details_info_window["info_windows_image_padding"]) ? explode(",", esc_attr($details_info_window["info_windows_image_padding"])) : "10,10,0,10";
         $info_window_text_padding = isset($details_info_window["info_windows_text_padding"]) ? explode(",", esc_attr($details_info_window["info_windows_text_padding"])) : "10,0,0,10";
         $info_window_description_style = isset($details_info_window["info_window_desc_style"]) ? explode(",", esc_attr($details_info_window["info_window_desc_style"])) : "12,#000000";
         $info_window_title_style = isset($details_info_window["info_window_title_style"]) ? explode(",", esc_attr($details_info_window["info_window_title_style"])) : "15,#000000";
         ?>
         <style type="text/css">
            .<?php echo $info_store_title_font_family_class; ?>
            .<?php echo $info_store_description_font_family_class; ?>
            [class^="icon-custom"]::before, [class*=" icon-custom"]::before
            {
               margin-left: 0px !important;
               margin-right: 0.5em !important;
            }
            .gmb-style-infowindow
            {
               line-height: 1.35;
               overflow: hidden;
               word-wrap: break-word;
               border: <?php echo intval($infowindow_border_style[0]); ?>px <?php echo esc_attr($infowindow_border_style[1]); ?> <?php echo esc_attr($infowindow_border_style[2]); ?>;
               border-radius: <?php echo intval($details_info_window["info_window_border_radius"]); ?>px !important;
               width: <?php echo intval($details_info_window["info_window_width"]); ?>px;
            }
            .store-locator-style
            {
               line-height: 1.35 !important;
               margin-top: -2px !important;
               padding: <?php echo intval($info_window_text_padding[0]); ?>px <?php echo intval($info_window_text_padding[1]); ?>px <?php echo intval($info_window_text_padding[2]); ?>px <?php echo intval($info_window_text_padding[3]); ?>px;
            }
            .store-description-style
            {
               word-break: break-word;
               font-size : <?php echo intval($info_window_description_style[0]); ?>px;
               color: <?php echo esc_attr($info_window_description_style[1]); ?>;
            }
            .gmb-image-padding-position
            {
               padding: <?php echo intval($info_window_image_padding[0]); ?>px <?php echo intval($info_window_image_padding[1]); ?>px <?php echo intval($info_window_image_padding[2]); ?>px <?php echo intval($info_window_image_padding[3]); ?>px;
               float: <?php echo esc_attr($details_info_window["info_window_image_position"]); ?>;
            }
            .store-title-style
            {
               font-size: <?php echo intval($info_window_title_style[0]); ?>px;
               color: <?php echo esc_attr($info_window_title_style[1]); ?>;
            }
         </style>
         <?php
      }
      function get_google_maps_overlays_data($meta_key, $mapid) {
         global $wpdb;
         $unserialize_map_data = $wpdb->get_results
             (
             $wpdb->prepare
                 (
                 "SELECT * FROM " . google_maps_meta() . "
						WHERE meta_id=%d AND meta_key=%s ORDER BY id DESC", $mapid, $meta_key
             )
         );
         $serialize_map_data = array();
         foreach ($unserialize_map_data as $value) {
            $unserialize = maybe_unserialize($value->meta_value);
            $unserialize["id"] = $value->id;
            $unserialize["meta_id"] = $value->meta_id;
            array_push($serialize_map_data, $unserialize);
         }
         return $serialize_map_data;
      }
      function google_maps_edit_data($markerid, $meta_key, $mapid) {
         global $wpdb;
         $unserialize_edit_data = $wpdb->get_var
             (
             $wpdb->prepare
                 (
                 "SELECT meta_value FROM " . google_maps_meta() . "
						WHERE id = %d AND meta_key = %s AND meta_id = %d", $markerid, $meta_key, $mapid
             )
         );
         return maybe_unserialize($unserialize_edit_data);
      }
      global $wpdb;
      if (isset($_GET["page"])) {
         switch (esc_attr($_GET["page"])) {
            case "gmb_google_maps":
               $google_maps_unserialize_data = get_google_maps_unserialize_data("maps_settings_data");
               $total_maps_data = $wpdb->get_var
                   (
                   $wpdb->prepare
                       (
                       "SELECT count(*) FROM " . google_maps() . " WHERE type = %s", "maps_settings"
                   )
               );
               break;

            case "gmb_add_map":
               $total_maps_data = $wpdb->get_var
                   (
                   $wpdb->prepare
                       (
                       "SELECT count(*) FROM " . google_maps() . " WHERE type = %s", "maps_settings"
                   )
               );
               $details_info_window = get_google_map_meta_data("info_window_settings");
               $google_maps_info_window = get_google_maps_info_window($details_info_window);
               if (isset($_REQUEST["google_map_id"])) {
                  $mapid = intval($_REQUEST["google_map_id"]);
                  $serialized_map_data = get_google_map_settings($mapid, "maps_settings_data");
                  $google_maps_marker_data = get_google_maps_overlays_data("marker_settings_data", $mapid);
                  $google_polyline_unserialize_data = get_google_maps_overlays_data("polyline_settings_data", $mapid);
                  $google_maps_polygon_data = get_google_maps_overlays_data("polygon_settings_data", $mapid);
                  $google_map_circle_data = get_google_maps_overlays_data("circle_data", $mapid);
                  $google_map_rectangle_data = get_google_maps_overlays_data("rectangle_data", $mapid);
                  $google_map_layers_data = get_google_map_settings($mapid, "layers_settings_data");
                  if (isset($_REQUEST["edit"])) {
                     $editid = intval($_REQUEST["edit"]);
                     $serialize_edit_data = google_maps_edit_data($editid, "marker_settings_data", $mapid);
                     $serialize_circle_edit_data = google_maps_edit_data($editid, "circle_data", $mapid);
                     $serialize_rectangle_edit_data = google_maps_edit_data($editid, "rectangle_data", $mapid);
                     $serialize_polygon_edit_data = google_maps_edit_data($editid, "polygon_settings_data", $mapid);
                     $serialize_polyline_edit_data = google_maps_edit_data($editid, "polyline_settings_data", $mapid);
                  }
               }
               break;

            case "gmb_manage_overlays":
               $details_info_window = get_google_map_meta_data("info_window_settings");
               $google_maps_info_window = get_google_maps_info_window($details_info_window);
               $choose_map_data = get_google_maps_unserialize_data("maps_settings_data");
               if (isset($_REQUEST["google_map_id"])) {
                  $id = intval($_REQUEST["google_map_id"]);
                  $serialized_map_data = get_google_map_settings($id, "maps_settings_data");
                  $google_maps_marker_data = get_google_maps_overlays_data("marker_settings_data", $id);
                  $google_maps_polygon_data = get_google_maps_overlays_data("polygon_settings_data", $id);
                  $google_polyline_unserialize_data = get_google_maps_overlays_data("polyline_settings_data", $id);
                  $google_map_circle_data = get_google_maps_overlays_data("circle_data", $id);
                  $google_map_rectangle_data = get_google_maps_overlays_data("rectangle_data", $id);
               }
               break;

            case "gmb_add_overlays":
               $details_info_window = get_google_map_meta_data("info_window_settings");
               $google_maps_info_window = get_google_maps_info_window($details_info_window);
               $choose_map_data = get_google_maps_unserialize_data("maps_settings_data");
               if (isset($_REQUEST["google_map_id"])) {
                  $mapid = intval($_REQUEST["google_map_id"]);
                  $serialized_map_data = get_google_map_settings($mapid, "maps_settings_data");
                  if (isset($_REQUEST["edit"])) {
                     $editid = intval($_REQUEST["edit"]);
                     $serialize_overlay_edit_data = google_maps_edit_data($editid, "marker_settings_data", $mapid);
                     $serialize_overlay_polygon_edit_data = google_maps_edit_data($editid, "polygon_settings_data", $mapid);
                     $polyline_overlays_edit_data = google_maps_edit_data($editid, "polyline_settings_data", $mapid);
                     $serialize_circle_overlay_edit_data = google_maps_edit_data($editid, "circle_data", $mapid);
                     $serialize_rectangle_overlay_edit_data = google_maps_edit_data($editid, "rectangle_data", $mapid);
                  }
               }
               break;

            case "gmb_layers":
               $details_info_window = get_google_map_meta_data("info_window_settings");
               $google_maps_info_window = get_google_maps_info_window($details_info_window);
               $choose_map_data = get_google_maps_unserialize_data("maps_settings_data");
               if (isset($_REQUEST["google_map_id"])) {
                  $mapid = intval($_REQUEST["google_map_id"]);
                  $serialized_map_data = get_google_map_settings($mapid, "maps_settings_data");
                  $layers_data_unserialized = get_google_map_settings($mapid, "layers_settings_data");
                  $google_maps_marker_data = get_google_maps_overlays_data("marker_settings_data", $mapid);
                  $google_maps_polygon_data = get_google_maps_overlays_data("polygon_settings_data", $mapid);
                  $google_polyline_unserialize_data = get_google_maps_overlays_data("polyline_settings_data", $mapid);
                  $google_map_circle_data = get_google_maps_overlays_data("circle_data", $mapid);
                  $google_map_rectangle_data = get_google_maps_overlays_data("rectangle_data", $mapid);
               }
               break;

            case "gmb_manage_store":
               $google_maps_unserialize_data = get_google_maps_unserialize_data("maps_settings_data");
               $store_locator_unserialize_data = get_google_maps_unserialize_data("store_locator_data");
               break;

            case "gmb_add_store":
               $details_info_window = get_google_map_meta_data("info_window_settings");
               $google_maps_info_window = get_google_maps_info_window($details_info_window);
               $choose_map_data = get_google_maps_unserialize_data("maps_settings_data");
               if (isset($_REQUEST["id"])) {
                  $edit_id = intval($_REQUEST["id"]);
                  $serialize_store_locator_edit_data = get_google_map_settings($edit_id, "store_locator_data");
               }
               break;

            case "gmb_info_window":
               $details_info_window = get_google_map_meta_data("info_window_settings");
               break;

            case "gmb_directions":
               $details_directions = get_google_map_meta_data("directions_settings");
               break;

            case "gmb_store_locator":
               $details_store_locator = get_google_map_meta_data("store_locator_settings");
               break;

            case "gmb_map_customization":
               $details_map_customization = get_google_map_meta_data("map_customization");
               break;

            case "gmb_shortcode":
               $choose_map_data = get_google_maps_unserialize_data("maps_settings_data");
               break;

            case "gmb_other_settings":
               $details_other_settings = get_google_map_meta_data("other_settings");
               break;

            case "gmb_roles_and_capabilities":
               $details_roles_capabilities = get_google_map_meta_data("roles_and_capabilities");
               $gmb_other_roles_access_array = array(
                   "manage_options",
                   "edit_plugins",
                   "edit_posts",
                   "publish_posts",
                   "publish_pages",
                   "edit_pages",
                   "read"
               );
               $other_roles_array = isset($details_roles_capabilities["capabilities"]) && $details_roles_capabilities["capabilities"] != "" ? $details_roles_capabilities["capabilities"] : $gmb_other_roles_access_array;
               break;
         }
      }
   }
}