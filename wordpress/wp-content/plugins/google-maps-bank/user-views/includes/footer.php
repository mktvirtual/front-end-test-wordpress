<?php
/**
 * This File displays Google Maps in frontend.
 *
 * @author  Tech Banker
 * @package google-maps-bank/user-views/views
 * @version 2.0.0
 */
if (!defined("ABSPATH")) {
   exit;
}//exit if accessed directly
?>
<script>
<?php
$api_key = isset($other_settings_unserialize['other_api_key']) ? esc_attr($other_settings_unserialize['other_api_key']) : "";
$language = isset($other_settings_unserialize['other_settings_map_language']) ? htmlspecialchars_decode($other_settings_unserialize['other_settings_map_language']) : "";
$protocol = is_ssl() ? "https" : "http";
wp_enqueue_script("maps_script.js", "$protocol://maps.googleapis.com/maps/api/js?v=3&libraries=geometry,places,visualization&key=$api_key&language=$language");
?>
   jQuery(".tooltips").tooltip_tip({placement: "left"});
   var map_themes_<?php echo $random; ?> = '<?php echo isset($map_themes) ? $map_themes : ""; ?>';
   var map_draggable_<?php echo $random; ?> = '<?php echo isset($map_customization_settings["map_draggable"]) && $map_customization_settings["map_draggable"] == "enable" ? true : false; ?>';
   var map_type_<?php echo $random; ?> = '<?php echo isset($map_customization_settings["map_type"]) && $map_customization_settings["map_type"] == "show" ? true : false; ?>';
   var map_type_control_position_<?php echo $random; ?> = '<?php echo isset($map_customization_settings["map_type_control_position"]) ? esc_attr($map_customization_settings["map_type_control_position"]) : "top_left"; ?>';
   var map_type_control_style_<?php echo $random; ?> = '<?php echo isset($map_customization_settings["map_type_control_style"]) ? esc_attr($map_customization_settings["map_type_control_style"]) : "horizontal_bar"; ?>';
   var double_click_zoom_<?php echo $random; ?> = '<?php echo isset($map_customization_settings["map_double_click_zoom"]) && esc_attr($map_customization_settings["map_double_click_zoom"]) == "enable" ? false : true; ?>';
   var scroll_wheel_<?php echo $random; ?> = '<?php echo isset($map_customization_settings["mouse_wheel_scrolling"]) && esc_attr($map_customization_settings["mouse_wheel_scrolling"]) == "enable" ? true : false; ?>';
   var full_screen_control_<?php echo $random; ?> = '<?php echo isset($map_customization_settings["full_screen_control"]) && esc_attr($map_customization_settings["full_screen_control"]) == "show" ? true : false; ?>';
   var full_screen_control_position_<?php echo $random; ?> = '<?php echo isset($map_customization_settings["full_screen_control_position"]) ? esc_attr($map_customization_settings["full_screen_control_position"]) : "top_left"; ?>'
   var street_control_<?php echo $random; ?> = '<?php echo isset($map_customization_settings["street_view_control"]) && esc_attr($map_customization_settings["street_view_control"]) == "show" ? true : false; ?>';
   var street_view_control_position_<?php echo $random; ?> = '<?php echo isset($map_customization_settings["street_view_control_position"]) ? esc_attr($map_customization_settings["street_view_control_position"]) : "top_left"; ?>';
   var rotate_control_<?php echo $random; ?> = '<?php echo isset($map_customization_settings["rotate_control"]) && esc_attr($map_customization_settings["rotate_control"]) == "show" ? true : false; ?>';
   var scale_control_<?php echo $random; ?> = '<?php echo isset($map_customization_settings["scale_control"]) && esc_attr($map_customization_settings["scale_control"]) == "show" ? true : false; ?>';
   var zoom_control_<?php echo $random; ?> = '<?php echo isset($map_customization_settings["map_zoom_control"]) && esc_attr($map_customization_settings["map_zoom_control"]) == "show" ? true : false; ?>';
   var zoom_control_position_<?php echo $random; ?> = '<?php echo isset($map_customization_settings["map_zoom_control_alignment"]) ? esc_attr($map_customization_settings["map_zoom_control_alignment"]) : "top_left"; ?>';
   function control_positioning_google_maps_<?php echo $random; ?>(map_type_control_position)
   {
      var controls_positions = "";
      switch (map_type_control_position)
      {
         case "top_left":
            controls_positions = google.maps.ControlPosition.TOP_LEFT
            break;
         case "top_center":
            controls_positions = google.maps.ControlPosition.TOP_CENTER
            break;
         case "top_right":
            controls_positions = google.maps.ControlPosition.TOP_RIGHT
            break;
         case "left_center":
            controls_positions = google.maps.ControlPosition.LEFT_CENTER
            break;
         case "left_top":
            controls_positions = google.maps.ControlPosition.LEFT_TOP
            break;
         case "left_bottom":
            controls_positions = google.maps.ControlPosition.LEFT_BOTTOM
            break;
         case "right_top":
            controls_positions = google.maps.ControlPosition.RIGHT_TOP
            break;
         case "right_center":
            controls_positions = google.maps.ControlPosition.RIGHT_CENTER
            break;
         case "right_bottom":
            controls_positions = google.maps.ControlPosition.RIGHT_BOTTOM
            break;
         case "bottom_left":
            controls_positions = google.maps.ControlPosition.BOTTOM_LEFT
            break;
         case "bottom_center":
            controls_positions = google.maps.ControlPosition.BOTTOM_CENTER
            break;
         case "bottom_right":
            controls_positions = google.maps.ControlPosition.BOTTOM_RIGHT
            break;
      }
      return controls_positions;
   }

   /* Show all Overlays On Map */

   function get_all_overlays_google_maps_<?php echo $random; ?>(map_<?php echo $random; ?>)
   {
<?php
$open_event = isset($layout_settings_info_window_settings["info_window_open_event"]) ? esc_html($layout_settings_info_window_settings["info_window_open_event"]) : "click";
$info_window_event = $open_event == "click" ? "click" : "mouseover";
if (isset($overlays_settings_marker_data) && !empty($overlays_settings_marker_data)) {
   foreach ($overlays_settings_marker_data as $markers) {
      $url = isset($markers["marker_icon_url"]) && $markers["marker_icon_url"] != "" ? esc_url($markers["marker_icon_url"]) : GOOGLE_MAP_DEFAULT_MARKER_ICON;
      ?>
            var icon = "";
            var icon_type = "<?php echo isset($markers["marker_icon_type"]) ? esc_html($markers["marker_icon_type"]) : "" ?>";
            if (icon_type === "choose_icon")
            {
               icon = "<?php echo GOOGLE_MAP_CUSTOM_MARKER_ICON . $url; ?>"
            } else if (icon_type === "upload")
            {
               icon =
                       {
                          url: "<?php echo isset($markers["marker_icon_upload"]) ? esc_url($markers["marker_icon_upload"]) : ""; ?>",
                          scaledSize: new google.maps.Size(32, 40),
                          origin: new google.maps.Point(0, 0),
                          anchor: new google.maps.Point(15, 40)
                       }
            }
            var animation = "";
            var animation_type = "<?php echo isset($markers["marker_animation"]) ? esc_html($markers["marker_animation"]) : ""; ?>";
            switch (animation_type)
            {
               case "bounce":
                  animation = google.maps.Animation.BOUNCE
                  break;
               case "drop":
                  animation = google.maps.Animation.DROP
                  break;
            }
            var marker = new google.maps.Marker
                    ({
                       animation: animation,
                       icon: icon,
                       map: map_<?php echo $random; ?>,
                       position: new google.maps.LatLng("<?php echo isset($markers["marker_latitude"]) ? floatval($markers["marker_latitude"]) : ""; ?>", "<?php echo isset($markers["marker_longitude"]) ? floatval($markers["marker_longitude"]) : ""; ?>")
                    });
      <?php
      $marker_info_window_show_hide = isset($markers["marker_info_window_show_hide"]) ? esc_attr($markers["marker_info_window_show_hide"]) : "disable";
      if ($marker_info_window_show_hide == "enable") {
         $infowindow_title = isset($markers["marker_title"]) ? esc_attr($markers["marker_title"]) : "";
         $infowindow_description = isset($markers["marker_description"]) ? esc_html($markers["marker_description"]) : "";
         ?>
               marker.content = '<div style="overflow: hidden;"><div class="gmb-style-infowindow">';
               marker.content += '<?php echo isset($markers["marker_info_window_upload_path"]) && $markers["marker_info_window_upload_path"] != "" ? '<img src="' . esc_attr($markers["marker_info_window_upload_path"]) . '" class="gmb-image-padding-position">' : ""; ?>';
               marker.content += '<p class="store-locator-style">';
               marker.content += '<span class="store-title-style"><b><?php echo preg_replace('/\s+/S', " ", $infowindow_title); ?></b></span><br/>';
               marker.content += '<span class="store-description-style"><?php echo preg_replace('/\s+/S', " ", htmlspecialchars_decode($infowindow_description)); ?></span></p></div></div>';
               var infowindow = new google.maps.InfoWindow();
               marker.addListener("<?php echo $info_window_event; ?>", function ()
               {
                  infowindow.setContent(this.content);
                  infowindow.open(this.getMap(), this);
               });
         <?php
         if ($open_event == "hover") {
            ?>
                  marker.addListener("mouseout", function ()
                  {
                     infowindow.setMap(null);
                  });
            <?php
         }
      }
      ?>
            marker.setMap(map_<?php echo $random; ?>);
      <?php
   }
}
if (isset($overlays_settings_polygon_data) && !empty($overlays_settings_polygon_data)) {
   foreach ($overlays_settings_polygon_data as $polygons) {
      ?>
            var polygonCoords = [];
      <?php
      if (isset($polygons["polygon_coordinates"])) {
         $coords_explode = explode("\n", esc_attr($polygons["polygon_coordinates"]));
         foreach ($coords_explode as $coordinates) {
            $replace_left = str_replace("[", "", $coordinates);
            $replace_right = str_replace("]", "", $replace_left);
            $coordinate = explode(",", $replace_right);
            if (isset($coordinate[0]) && isset($coordinate[1])) {
               ?>
                     var latlng = new google.maps.LatLng("<?php echo sanitize_text_field($coordinate[0]); ?>", "<?php echo sanitize_text_field($coordinate[1]); ?>");
                     polygonCoords.push(latlng);
               <?php
            }
         }
      }
      $stroke_color = isset($polygons["polygon_stroke_color_style"]) ? explode(",", esc_attr($polygons["polygon_stroke_color_style"])) : "";
      $stroke_fill_color = isset($polygons["polygon_fill_color_style"]) ? explode(",", esc_attr($polygons["polygon_fill_color_style"])) : "";
      ?>
            polygon = new google.maps.Polygon
                    ({
                       paths: polygonCoords,
                       strokeColor: "<?php echo isset($stroke_color[0]) ? esc_attr($stroke_color[0]) : "#000000"; ?>",
                       strokeOpacity: "<?php echo isset($stroke_color[1]) ? floatval($stroke_color[1] / 100) : "0.75"; ?>",
                       strokeWeight: "<?php echo isset($polygons["polygon_stroke_weight"]) ? intval($polygons["polygon_stroke_weight"]) : "2"; ?>",
                       fillColor: "<?php echo isset($stroke_fill_color[0]) ? esc_attr($stroke_fill_color[0]) : "#000000"; ?>",
                       fillOpacity: "<?php echo isset($stroke_fill_color[1]) ? floatval($stroke_fill_color[1] / 100) : "0.75"; ?>"
                    });
            polygon.setMap(map_<?php echo $random; ?>);
      <?php
   }
}
if (isset($overlays_settings_polyline_data) && !empty($overlays_settings_polyline_data)) {
   foreach ($overlays_settings_polyline_data as $polylines) {
      ?>
            var repeat = "";
            var lineSymbol = "";
            var coords = [];
            var poly_line_stroke_opacity = "";
      <?php
      if (isset($polylines["polyline_cordinates"])) {
         $coords_explode = explode("\n", esc_attr($polylines["polyline_cordinates"]));
         $polyline_stroke_color_opacity = explode(",", esc_attr($polylines["polyline_stroke_color_opacity"]));
         foreach ($coords_explode as $coordinates) {
            $replace_left = str_replace("[", "", $coordinates);
            $replace_right = str_replace("]", "", $replace_left);
            $coordinate = explode(",", $replace_right);
            if (isset($coordinate[0]) && isset($coordinate[1])) {
               ?>
                     var latlng = new google.maps.LatLng("<?php echo sanitize_text_field($coordinate[0]); ?>", "<?php echo sanitize_text_field($coordinate[1]); ?>");
                     coords.push(latlng);
               <?php
            }
         }
      }
      $polylines_type = isset($polylines["polyline_type"]) ? esc_attr($polylines["polyline_type"]) : "solid";
      switch ($polylines_type) {
         case "solid":
            ?>
                  poly_line_stroke_opacity = "<?php echo isset($polyline_stroke_color_opacity[1]) ? floatval($polyline_stroke_color_opacity[1] / 100) : "0.75"; ?>";
            <?php
            break;
         case "dotted":
            ?>
                  poly_line_stroke_opacity = 0;
                  repeat = "10px";
                  var lineSymbol =
                          {
                             path: google.maps.SymbolPath.CIRCLE,
                             fillOpacity: "<?php echo isset($polyline_stroke_color_opacity[1]) ? floatval($polyline_stroke_color_opacity[1] / 100) : "0.75"; ?>",
                             scale: "<?php echo isset($polylines["polyline_stroke_width"]) ? intval($polylines["polyline_stroke_width"]) : "2"; ?>"
                          };
            <?php
            break;
         case "dashed":
            ?>
                  poly_line_stroke_opacity = 0;
                  repeat = "20px";
                  var lineSymbol =
                          {
                             path: "M 0,-1 0,1",
                             strokeOpacity: "<?php echo isset($polyline_stroke_color_opacity[1]) ? floatval($polyline_stroke_color_opacity[1] / 100) : "0.75"; ?>",
                             scale: "<?php echo isset($polylines["polyline_stroke_width"]) ? intval($polylines["polyline_stroke_width"]) : "2"; ?>"
                          };
            <?php
            break;
      }
      ?>
            polyline = new google.maps.Polyline
                    ({
                       path: coords,
                       strokeColor: "<?php echo isset($polyline_stroke_color_opacity[0]) ? esc_attr($polyline_stroke_color_opacity[0]) : "#000000"; ?>",
                       strokeOpacity: poly_line_stroke_opacity,
                       strokeWeight: "<?php echo isset($polylines["polyline_stroke_width"]) ? intval($polylines["polyline_stroke_width"]) : "2"; ?>",
                       icons: [{
                             icon: lineSymbol,
                             offset: "0",
                             repeat: repeat
                          }]
                    });
            polyline.setMap(map_<?php echo $random; ?>);
      <?php
   }
}
if (isset($overlays_settings_circle_data) && !empty($overlays_settings_circle_data)) {
   foreach ($overlays_settings_circle_data as $circles) {
      $circle_stroke_color_opacity = isset($circles["circle_stroke_color"]) ? explode(",", esc_attr($circles["circle_stroke_color"])) : "";
      $circle_fill_color_opacity = isset($circles["circle_fill_color"]) ? explode(",", esc_attr($circles["circle_fill_color"])) : "";
      ?>
            var circle_array = <?php echo isset($circles["circle_coordinates"]) ? json_encode($circles["circle_coordinates"]) : ""; ?>;
            var circle_coordinates = circle_array.split("\n");
            var circle_lat = parseFloat(circle_coordinates[0].substr(10));
            var circle_lng = parseFloat(circle_coordinates[1].substr(11));
            var circle_latLng = new google.maps.LatLng(circle_lat, circle_lng);
            var circle_radius = "";
      <?php
      if (isset($circles["circle_radius_type"]) && esc_attr($circles["circle_radius_type"]) == "metres") {
         ?>
               circle_radius = "<?php echo isset($circles["circle_radius_value"]) ? floatval($circles["circle_radius_value"]) : ""; ?>";
         <?php
      } else if ($circles["circle_radius_type"] && esc_attr($circles["circle_radius_type"]) == "kilometers") {
         ?>
               circle_radius = "<?php echo isset($circles["circle_radius_value"]) ? floatval($circles["circle_radius_value"] * 1000) : ""; ?>";
         <?php
      } else {
         ?>
               circle_radius = "<?php echo isset($circles["circle_radius_value"]) ? floatval($circles["circle_radius_value"] * 1609.34) : ""; ?>";
         <?php
      }
      ?>
            var circle = new google.maps.Circle(
                    {
                       strokeColor: "<?php echo isset($circle_stroke_color_opacity[0]) ? esc_attr($circle_stroke_color_opacity[0]) : "#000000"; ?>",
                       strokeOpacity: "<?php echo isset($circle_stroke_color_opacity[1]) ? floatval($circle_stroke_color_opacity[1] / 100) : "0.75"; ?>",
                       strokeWeight: "<?php echo isset($circles["circle_stroke_weight"]) ? intval($circles["circle_stroke_weight"]) : "2" ?>",
                       fillColor: "<?php echo isset($circle_fill_color_opacity[0]) ? esc_attr($circle_fill_color_opacity[0]) : "#000000"; ?>",
                       fillOpacity: "<?php echo isset($circle_fill_color_opacity[1]) ? floatval($circle_fill_color_opacity[1] / 100) : "0.75"; ?>",
                       map: map_<?php echo $random; ?>,
                       center: circle_latLng,
                       radius: parseFloat(circle_radius)
                    });
            circle.setMap(map_<?php echo $random; ?>)
      <?php
   }
}
?>
   }
   /* Initialize Map Settings */
   function initialize_map_settings_google_maps_<?php echo $random; ?>()
   {
<?php
$ip = get_ip_address_google_map();
$ip_address = ($ip == "::1" || $ip == "127.0.0.1") ? ip2long("127.0.0.1") : ip2long($ip);
$location = get_ip_location_google_map(long2ip($ip_address));
?>
      var type = "";
      switch ("<?php echo isset($map_unserialized_data["map_type"]) ? esc_attr($map_unserialized_data["map_type"]) : "roadmap"; ?>")
      {
         case "roadmap":
            type = google.maps.MapTypeId.ROADMAP
            break;
         case "satellite":
            type = google.maps.MapTypeId.SATELLITE
            break;
         case "hybrid":
            type = google.maps.MapTypeId.HYBRID
            break;
         case "terrain":
            type = google.maps.MapTypeId.TERRAIN
            break;
      }
      var control_style = "";
      switch (map_type_control_style_<?php echo $random; ?>)
      {
         case "horizontal_bar":
            control_style = google.maps.MapTypeControlStyle.HORIZONTAL_BAR
            break;
         case "dropdown_menu":
            control_style = google.maps.MapTypeControlStyle.DROPDOWN_MENU
            break;
         case "none":
            control_style = google.maps.MapTypeControlStyle.DEFAULT
            break;
      }
      var mapOptions =
              {
                 center: new google.maps.LatLng("<?php echo isset($map_unserialized_data["map_latitude"]) ? floatval($map_unserialized_data["map_latitude"]) : ($location->latitude != 0 ? floatval($location->latitude) : '40.73141229999999'); ?>", "<?php echo isset($map_unserialized_data["map_longitude"]) ? floatval($map_unserialized_data["map_longitude"]) : ($location->longitude != 0 ? floatval($location->longitude) : '-73.9969848'); ?>"),
                 zoom: parseInt(<?php echo isset($map_unserialized_data["map_zoom_level"]) ? intval($map_unserialized_data["map_zoom_level"]) : "18"; ?>),
                 styles: window[map_themes_<?php echo $random; ?>],
                 streetViewControl: street_control_<?php echo $random; ?>,
                 streetViewControlOptions:
                         {
                            position: control_positioning_google_maps_<?php echo $random; ?>(street_view_control_position_<?php echo $random; ?>)
                         },
                 mapTypeControl: map_type_<?php echo $random; ?>,
                 mapTypeControlOptions:
                         {
                            style: control_style,
                            position: control_positioning_google_maps_<?php echo $random; ?>(map_type_control_position_<?php echo $random; ?>)
                         },
                 mapTypeId: type,
                 scaleControl: scale_control_<?php echo $random; ?>,
                 rotateControl: rotate_control_<?php echo $random; ?>,
                 draggable: map_draggable_<?php echo $random; ?>,
                 scrollwheel: scroll_wheel_<?php echo $random; ?>,
                 zoomControl: zoom_control_<?php echo $random; ?>,
                 zoomControlOptions:
                         {
                            position: control_positioning_google_maps_<?php echo $random; ?>(zoom_control_position_<?php echo $random; ?>)
                         },
                 tilt: 45,
                 disableDoubleClickZoom: double_click_zoom_<?php echo $random; ?>,
                 fullscreenControl: full_screen_control_<?php echo $random; ?>,
                 fullscreenControlOptions:
                         {
                            position: control_positioning_google_maps_<?php echo $random; ?>(full_screen_control_position_<?php echo $random; ?>)
                         }
              };
      var map_<?php echo $random; ?> = new google.maps.Map(document.getElementById("ux_div_map_canvas_front_end_<?php echo $random; ?>"), mapOptions);
      get_all_overlays_google_maps_<?php echo $random; ?>(map_<?php echo $random; ?>);
      return map_<?php echo $random; ?>;
   }

   jQuery(document).ready(function ()
   {
      var map_<?php echo $random; ?> = initialize_map_settings_google_maps_<?php echo $random; ?>();
   });
</script>
