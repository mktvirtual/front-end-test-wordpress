<?php
/**
 * This file contains javascript code.
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
      ?>
      </div>
      </div>
      </div>
      <div class="popup" data-popup="ux_open_popup_translator">
         <div class="popup-inner">
            <div class="portlet box vivid-green" style="margin-bottom:0px;">
               <div class="portlet-title">
                  <div class="caption" id="ux_div_action">
                     <?php echo $gm_translation_request; ?>
                  </div>
               </div>
               <div class="portlet-body form">
                  <div id="ux_div_popup_header">
                     <form id="ux_frm_language_translator">
                        <div class="form-body">
                           <div class="row">
                              <div class="col-md-6 popup-control">
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_feature_requests_your_name; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_popup_your_name_tooltip; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="ux_txt_your_name" id="ux_txt_your_name" value="" placeholder="<?php echo $gm_feature_requests_your_name_placeholder; ?>">
                                 </div>
                              </div>
                              <div class="col-md-6 popup-control">
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_feature_requests_your_email; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_popup_your_email_tooltip; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="ux_txt_email_address" id="ux_txt_email_address" value=""  placeholder="<?php echo $gm_feature_requests_your_email_placeholder; ?>">
                                 </div>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="control-label">
                                 <?php echo $gm_language_interested_to_translate; ?> :
                                 <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_language_interested_to_translate_tooltip; ?>" data-placement="right"></i>
                                 <span class="required" aria-required="true">*</span>
                              </label>
                              <input type="text" class="form-control" name="ux_txt_language" id="ux_txt_language"  value="" placeholder="<?php echo $gm_language_interested_to_translate_placeholder; ?>">
                           </div>
                           <div class="form-group">
                              <label class="control-label">
                                 <?php echo $gm_popup_query; ?> :
                                 <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_popup_query_tooltip; ?>" data-placement="right"></i>
                                 <span class="required" aria-required="true">*</span>
                              </label>
                              <textarea class="form-control" name="ux_txtarea_query" id="ux_txtarea_query" rows="7" placeholder="<?php echo $gm_popup_query_placeholder; ?>"><?php echo "Hi,\r\r\nI am interested in translating your plugin Google Maps Bank in my native language.\r\r\nPlease get back to me!\r\r\nThanks"; ?></textarea>
                           </div>
                        </div>
                        <div class="modal-footer">
                           <div class="form-actions">
                              <div class="pull-right">
                                 <input type="button" data-popup-close-translator="ux_open_popup_translator" class="btn vivid-green" name="ux_btn_close" id="ux_btn_close" value="<?php echo $gm_manage_backups_close; ?>">
                                 <input type="submit"  class="btn vivid-green" name="ux_btn_send_request" id="ux_btn_send_request" value="<?php echo $gm_feature_requests_send_request; ?>">
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script type="text/javascript">
         jQuery(".tooltips").tooltip_tip({placement: "left"});
         jQuery("li > a").parents("li").each(function ()
         {
            if (jQuery(this).parent("ul.page-sidebar-menu-tech-banker").size() === 1)
            {
               jQuery(this).find("> a").append("<span class=\"selected\"></span>");
            }
         });
         jQuery(".page-sidebar-tech-banker").on("click", "li > a", function (e)
         {
            var hasSubMenu = jQuery(this).next().hasClass("sub-menu");
            var parent = jQuery(this).parent().parent();
            var sidebar_menu = jQuery(".page-sidebar-menu-tech-banker");
            var sub = jQuery(this).next();
            var slideSpeed = parseInt(sidebar_menu.data("slide-speed"));
            parent.children("li.open").children(".sub-menu:not(.always-open)").slideUp(slideSpeed);
            parent.children("li.open").removeClass("open");
            if (sub.is(":visible"))
            {
               jQuery(this).parent().removeClass("open");
               sub.slideUp(slideSpeed);
            } else if (hasSubMenu)
            {
               jQuery(this).parent().addClass("open");
               sub.slideDown(slideSpeed);
            }
         });
         jQuery.validator.addMethod("marker_lat_valid", function (value, element, options)
         {
            var latVal = /^(\+|-)?(?:90(?:(?:\.0{0,15})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{0,15})?))$/;
            var Lat = jQuery("#ux_txt_marker_latitude").val();
            var latvalid = (!latVal.test(Lat));
            if (latvalid)
            {
               jQuery("#ux_txt_marker_latitude").addClass("error");
            } else
            {
               jQuery("#ux_txt_marker_latitude").removeClass("error");
            }
            return !latvalid;
         });
         jQuery.validator.addMethod("marker_lng_valid", function (value, element, options)
         {
            var lngVal = /^(\+|-)?(?:180(?:(?:\.0{0,19})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{0,19})?))$/;
            var lngvalid = (!lngVal.test(jQuery("#ux_txt_marker_longitude").val()));
            if (lngvalid)
            {
               jQuery("#ux_txt_marker_longitude").addClass("error");
            } else
            {
               jQuery("#ux_txt_marker_longitude").removeClass("error");
            }
            return !lngvalid;
         });
         jQuery.validator.addMethod("latvalid", function (value, element, options)
         {
            var latVal = /^(\+|-)?(?:90(?:(?:\.0{0,15})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{0,15})?))$/;
            var latvalid = (!latVal.test(jQuery(".ux_txt_latitude").val()));
            if (latvalid)
            {
               jQuery(".ux_txt_latitude").addClass("error");
            } else
            {
               jQuery(".ux_txt_latitude").removeClass("error");
            }
            return !latvalid;
         });
         jQuery.validator.addMethod("lngvalid", function (value, element, options)
         {
            var lngVal = /^(\+|-)?(?:180(?:(?:\.0{0,19})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{0,19})?))$/;
            var lngvalid = (!lngVal.test(jQuery(".ux_txt_longitude").val()));
            if (lngvalid)
            {
               jQuery(".ux_txt_longitude").addClass("error");
            } else
            {
               jQuery(".ux_txt_longitude").removeClass("error");
            }
            return !lngvalid;
         });
         function base64_encode_google_maps_bank(data)
         {
            var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
            var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
                    ac = 0,
                    enc = "",
                    tmp_arr = [];
            if (!data)
            {
               return data;
            }
            do
            {
               o1 = data.charCodeAt(i++);
               o2 = data.charCodeAt(i++);
               o3 = data.charCodeAt(i++);
               bits = o1 << 16 | o2 << 8 | o3;
               h1 = bits >> 18 & 0x3f;
               h2 = bits >> 12 & 0x3f;
               h3 = bits >> 6 & 0x3f;
               h4 = bits & 0x3f;
               tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
            } while (i < data.length);
            enc = tmp_arr.join("");
            var r = data.length % 3;
            return (r ? enc.slice(0, r - 3) : enc) + "===".slice(r || 3);
         }
         function load_sidebar_content_google_maps()
         {
            var menus_height = jQuery(".page-sidebar-menu-tech-banker").height();
            var content_height = jQuery(".page-content").height() + 30;
            if (parseInt(menus_height) > parseInt(content_height))
            {
               jQuery(".page-content").attr("style", "min-height:" + menus_height + "px");
            } else
            {
               jQuery(".page-sidebar-menu-tech-banker").attr("style", "min-height:" + content_height + "px");
            }
         }
         var sidebar_load_interval = setInterval(load_sidebar_content_google_maps, 1000);
         function overlay_loading_google_maps(control_id)
         {
            var overlay_opacity = jQuery("<div class=\"opacity_overlay\"></div>");
            jQuery("body").append(overlay_opacity);
            var overlay = jQuery("<div class=\"loader_opacity\"><div class=\"processing_overlay\"></div></div>");
            jQuery("body").append(overlay);
            if (control_id !== undefined)
            {
               var message = control_id;
               var success = <?php echo json_encode($gm_success); ?>;
               var issuccessmessage = jQuery("#toast-container").exists();
               if (issuccessmessage !== true)
               {
                  var shortCutFunction = jQuery("#manage_messages input:checked").val();
                  toastr[shortCutFunction](message, success);
               }
            }
         }
         function remove_overlay_google_maps()
         {
            jQuery(".loader_opacity").remove();
            jQuery(".opacity_overlay").remove();
         }
         function google_maps_manage_datatable(id)
         {
            var oTable = jQuery(id).dataTable
                    ({
                       "pagingType": "full_numbers",
                       "language":
                               {
                                  "emptyTable": "No data available in table",
                                  "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                                  "infoEmpty": "No entries found",
                                  "infoFiltered": "(filtered1 from _MAX_ total entries)",
                                  "lengthMenu": "Show _MENU_ entries",
                                  "search": "Search:",
                                  "zeroRecords": "No matching records found"
                               },
                       "bSort": true,
                       "pageLength": 10,
                       "aoColumnDefs": [{"bSortable": false, "aTargets": [0]}]
                    });
            return oTable;
         }
         function only_digits_google_maps(event)
         {
            if (event.which !== 8 && event.which !== 0 && (event.which < 48 || event.which > 57))
            {
               event.preventDefault();
            }
         }
         function premium_edition_notification_google_maps_bank()
         {
            var premium_edition = <?php echo json_encode($gm_message_premium_edition); ?>;
            var shortCutFunction = jQuery("#toastTypeGroup_error input:checked").val();
            toastr[shortCutFunction](premium_edition);
         }
         function paste_prevent_google_maps(control_id)
         {
            jQuery("#" + control_id).on("paste", function (e)
            {
               e.preventDefault();
            });
         }
         function google_maps_validate_alphabets(event)
         {
            if ((event.which >= 97 && event.which <= 122) || (event.which >= 65 && event.which <= 90))
            {
               event.preventDefault();
            }
         }
         function default_value_google_maps(id, value, type)
         {
            if (type === "width" && type !== undefined)
            {
               jQuery(id).val() > 100 ? jQuery(id).val(value) : jQuery(id).val();
               jQuery(id).val() < 1 ? jQuery(id).val(value) : jQuery(id).val();
            }
            if (type === "info" && type !== undefined)
            {
               jQuery(id).val() < 200 ? jQuery(id).val(value) : jQuery(id).val();
            }
            jQuery(id).val() === "" ? jQuery(id).val(value) : jQuery(id).val();
         }
         function get_url_google_maps(mapid, type, url)
         {
            overlay_loading_google_maps();
            setTimeout(function ()
            {
               remove_overlay_google_maps();
               if (type === "")
               {
                  var id = jQuery(mapid).val();
                  if (id !== "")
                  {
                     location.href = "admin.php?page=" + url + "&google_map_id=" + id;
                  } else
                  {
                     location.href = "admin.php?page=" + url;
                  }
               } else
               {
                  if (mapid === "#ux_ddl_choose_map")
                  {
                     if (jQuery(mapid).val() !== "")
                     {
                        mapid = "&google_map_id=" + jQuery(mapid).val();
                        var overlay = "&overlay=" + type;
                     } else
                     {
                        mapid = "";
                        var overlay = "";
                     }
                  } else
                  {
                     var overlay = "&overlay=" + type;
                  }
                  location.href = "admin.php?page=" + url + mapid + overlay;
               }
            }, 1000);
         }
         function google_map_color_picker(id, color_value)
         {
            jQuery(id).colpick
                    ({
                       layout: "hex",
                       colorScheme: "dark",
                       color: color_value,
                       onChange: function (hsb, hex, rgb, el, bySetColor)
                       {
                          if (!bySetColor)
                             jQuery(el).val("#" + hex);
                       }
                    }).keyup(function ()
            {
               jQuery(this).colpickSetColor("#" + this.value);
            });
         }
         function show_hide_controls_google_maps(id, div_id)
         {
            switch (jQuery(id).val())
            {
               case "hide":
                  jQuery(div_id).css("display", "none");
                  break;
               case "show":
                  jQuery(div_id).css("display", "block");
                  break;
            }
         }
         function get_shortcode_google_maps()
         {
            var type = jQuery("#ux_ddl_display_type").val();
            switch (type)
            {
               case "map":
                  jQuery("#ux_div_map_shortcode_settings").css("display", "block");
                  jQuery("#ux_div_store_locator_shortcode_settings").css("display", "none");
                  jQuery("#ux_div_directions_shortcode_settings").css("display", "none");
                  jQuery("#ux_div_generate_shortcode").css("display", "none");
                  break;
               case "store_locator":
                  jQuery("#ux_div_store_locator_shortcode_settings").css("display", "block");
                  jQuery("#ux_div_map_shortcode_settings").css("display", "none");
                  jQuery("#ux_div_directions_shortcode_settings").css("display", "none");
                  jQuery("#ux_div_generate_shortcode").css("display", "none");
                  break;
               case "directions":
                  jQuery("#ux_div_directions_shortcode_settings").css("display", "block");
                  jQuery("#ux_div_map_shortcode_settings").css("display", "none");
                  jQuery("#ux_div_store_locator_shortcode_settings").css("display", "none");
                  jQuery("#ux_div_generate_shortcode").css("display", "none");
                  break;
            }
         }
         function google_maps_canvas_show(id, choose_map_id, map_id, div_id)
         {
            switch (id)
            {
               case "":
                  jQuery(map_id).css("display", "none");
                  jQuery(div_id).css("display", "none");
                  break;
               default:
                  jQuery(map_id).css("display", "block");
                  jQuery(div_id).css("display", "block");
                  jQuery(choose_map_id).val(id);
                  break;
            }
         }
         function google_maps_info_window(id, info_window_image, wp_error_id)
         {
            if (jQuery(id).val() === "enable")
            {
      <?php
      global $wp_version;
      if ($wp_version >= 3.5) {
         ?>
                  jQuery(info_window_image).css("display", "block");
         <?php
      } else {
         ?>
                  jQuery(wp_error_id).css("display", "block");
         <?php
      }
      ?>
            } else
            {
               jQuery(info_window_image).css("display", "none");
               jQuery(wp_error_id).css("display", "none");
            }
         }
         function get_geocode_position_google_maps(position, id)
         {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode
                    ({
                       latLng: position
                    },
                            function (responses)
                            {
                               if (responses && responses.length > 0)
                               {
                                  jQuery(id).val(responses[0].formatted_address);
                               }
                            });
         }
         function get_all_overlays_data_google_maps(map)
         {
      <?php
      $open_event = isset($details_info_window["info_window_open_event"]) ? esc_attr($details_info_window["info_window_open_event"]) : "click";
      $info_window_event = $open_event == "click" ? "click" : "mouseover";
      if (isset($google_maps_marker_data) && !empty($google_maps_marker_data)) {
         foreach ($google_maps_marker_data as $markers) {
            $url = isset($markers["marker_icon_url"]) && $markers["marker_icon_url"] != "" ? $markers["marker_icon_url"] : GOOGLE_MAP_DEFAULT_MARKER_ICON;
            ?>
                  var icon = "";
                  var markers_icons_type = "<?php echo isset($markers["marker_icon_type"]) ? esc_attr($markers["marker_icon_type"]) : "choose_icon"; ?>";
                  if (markers_icons_type === "choose_icon")
                  {
                     icon = "<?php echo GOOGLE_MAP_CUSTOM_MARKER_ICON . $url; ?>";
                  } else if (markers_icons_type === "upload")
                  {
                     icon =
                             {
                                url: "<?php echo $markers["marker_icon_upload"]; ?>",
                                scaledSize: new google.maps.Size(32, 32),
                                origin: new google.maps.Point(0, 0),
                                anchor: new google.maps.Point(15, 40)
                             };
                  }
                  var animation = "";
                  switch ("<?php echo $markers["marker_animation"]; ?>")
                  {
                     case "bounce":
                        animation = google.maps.Animation.BOUNCE;
                        break;
                     case "drop":
                        animation = google.maps.Animation.DROP;
                        break;
                  }
                  var marker = new google.maps.Marker
                          ({
                             animation: animation,
                             icon: icon,
                             map: map,
                             position: new google.maps.LatLng("<?php echo $markers["marker_latitude"]; ?>", "<?php echo $markers["marker_longitude"]; ?>")
                          });
            <?php
            if (esc_attr($markers["marker_info_window_show_hide"]) == "enable") {
               $infowindow_title = isset($markers["marker_title"]) ? esc_html($markers["marker_title"]) : "";
               $infowindow_description = isset($markers["marker_description"]) ? esc_html($markers["marker_description"]) : "";
               ?>
                     marker.content = '<div class="gmb-style-infowindow" style="overflow:auto;"><img src="<?php echo esc_attr($markers["marker_info_window_upload_path"]); ?>" class="gmb-image-padding-position" style="max-width:120px;display:inline;">';
                     marker.content += "<p class='store-locator-style'>";
                     marker.content += '<span class="store-title-style"><b><?php echo preg_replace('/\s+/S', " ", $infowindow_title); ?></b></span><br/>';
                     marker.content += '<span class="store-description-style"><?php echo preg_replace('/\s+/S', " ", htmlspecialchars_decode($infowindow_description)); ?></span></p></div>';
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
                  marker.setMap(map);
            <?php
         }
      }
      if (isset($google_maps_polygon_data) && !empty($google_maps_polygon_data)) {
         foreach ($google_maps_polygon_data as $polygons) {
            $polygons_coordinates_explode = explode("\n", $polygons["polygon_coordinates"]);
            ?>
                  var polygonCoords = [];
            <?php
            foreach ($polygons_coordinates_explode as $coordinates) {
               $unwanted_char_replace_left = str_replace("[", "", $coordinates);
               $unwanted_char_replace_right = str_replace("]", "", $unwanted_char_replace_left);
               $polygons_coordinates_latlng = explode(",", $unwanted_char_replace_right);
               if (isset($polygons_coordinates_latlng[0]) && isset($polygons_coordinates_latlng[1])) {
                  ?>
                        var latlng = new google.maps.LatLng("<?php echo sanitize_text_field($polygons_coordinates_latlng[0]); ?>", "<?php echo sanitize_text_field($polygons_coordinates_latlng[1]); ?>");
                        polygonCoords.push(latlng);
                  <?php
               }
            }
            $stroke_color = isset($polygons["polygon_stroke_color_style"]) ? explode(",", esc_attr($polygons["polygon_stroke_color_style"])) : "";
            $stroke_fill_color = isset($polygons["polygon_fill_color_style"]) ? explode(",", esc_attr($polygons["polygon_fill_color_style"])) : "";
            ?>
                  polygon = new google.maps.Polygon
                          ({
                             paths: polygonCoords,
                             strokeColor: "<?php echo isset($stroke_color[0]) ? esc_attr($stroke_color[0]) : "#000000"; ?>",
                             strokeOpacity: "<?php echo isset($stroke_color[1]) ? floatval($stroke_color[1] / 100) : 1; ?>",
                             strokeWeight: "<?php echo isset($polygons["polygon_stroke_weight"]) ? intval($polygons["polygon_stroke_weight"]) : 2; ?>",
                             fillColor: "<?php echo isset($stroke_fill_color[0]) ? esc_attr($stroke_fill_color[0]) : "#000000"; ?>",
                             fillOpacity: "<?php echo isset($stroke_fill_color[1]) ? floatval($stroke_fill_color[1] / 100) : 1; ?>"
                          });
                  polygon.setMap(map);
            <?php
         }
      }
      if (isset($google_polyline_unserialize_data) && !empty($google_polyline_unserialize_data)) {
         foreach ($google_polyline_unserialize_data as $polylines) {
            $polylines_coordinates_explode = explode("\n", esc_attr($polylines["polyline_cordinates"]));
            $polyline_stroke_color_opacity = explode(",", esc_attr($polylines["polyline_stroke_color_opacity"]));
            ?>
                  var repeat = "";
                  var lineSymbol = "";
                  var polylines_path = [];
                  var poly_line_stroke_opacity = "";
            <?php
            foreach ($polylines_coordinates_explode as $coordinates) {
               $unwanted_char_replace_left = str_replace("[", "", $coordinates);
               $unwanted_char_replace_right = str_replace("]", "", $unwanted_char_replace_left);
               $polylines_coordinates_latlng = explode(",", $unwanted_char_replace_right);
               if (isset($polylines_coordinates_latlng[0]) && isset($polylines_coordinates_latlng[1])) {
                  ?>
                        var latlng = new google.maps.LatLng("<?php echo sanitize_text_field($polylines_coordinates_latlng[0]); ?>", "<?php echo sanitize_text_field($polylines_coordinates_latlng[1]); ?>");
                        polylines_path.push(latlng);
                  <?php
               }
            }
            $polylines_type = isset($polylines["polyline_type"]) ? esc_attr($polylines["polyline_type"]) : "solid";
            switch ($polylines_type) {
               case "solid":
                  ?>
                        poly_line_stroke_opacity = "<?php echo floatval($polyline_stroke_color_opacity[1] / 100); ?>";
                  <?php
                  break;
               case "dotted":
                  ?>
                        poly_line_stroke_opacity = 0;
                        repeat = "10px";
                        var lineSymbol =
                                {
                                   path: google.maps.SymbolPath.CIRCLE,
                                   fillOpacity: "<?php echo floatval($polyline_stroke_color_opacity[1] / 100); ?>",
                                   scale: "<?php echo intval($polylines["polyline_stroke_width"]); ?>"
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
                                   strokeOpacity: "<?php echo floatval($polyline_stroke_color_opacity[1] / 100); ?>",
                                   scale: "<?php echo intval($polylines["polyline_stroke_width"]); ?>"
                                };
                  <?php
                  break;
            }
            ?>
                  polyline = new google.maps.Polyline
                          ({
                             path: polylines_path,
                             strokeColor: "<?php echo isset($polyline_stroke_color_opacity[0]) ? esc_attr($polyline_stroke_color_opacity[0]) : "#000000"; ?>",
                             strokeOpacity: poly_line_stroke_opacity,
                             strokeWeight: "<?php echo isset($polylines["polyline_stroke_width"]) ? intval($polylines["polyline_stroke_width"]) : 2; ?>",
                             icons: [{
                                   icon: lineSymbol,
                                   offset: "0",
                                   repeat: repeat
                                }]
                          });
                  polyline.setMap(map);
            <?php
         }
      }
      if (isset($google_map_circle_data) && !empty($google_map_circle_data)) {
         foreach ($google_map_circle_data as $circles) {
            $circle_stroke_color_opacity = explode(",", esc_attr($circles["circle_stroke_color"]));
            $circle_fill_color_opacity = explode(",", esc_attr($circles["circle_fill_color"]));
            ?>
                  var circle_array = <?php echo isset($circles["circle_coordinates"]) ? json_encode($circles["circle_coordinates"]) : ""; ?>;
                  var circle_coordinates = circle_array.split("\n");
                  var circle_lat = parseFloat(circle_coordinates[0].substr(10));
                  var circle_lng = parseFloat(circle_coordinates[1].substr(11));
                  var circle_latLng = new google.maps.LatLng(circle_lat, circle_lng);
            <?php
            $circle_radius = "";
            switch ($circles["circle_radius_type"]) {
               case "metres":
                  $circle_radius = floatval($circles["circle_radius_value"]);
                  break;
               case "kilometers":
                  $circle_radius = floatval($circles["circle_radius_value"] * 1000);
                  break;
               case "miles":
                  $circle_radius = floatval($circles["circle_radius_value"] * 1609.34);
                  break;
            }
            ?>
                  var circle = new google.maps.Circle
                          ({
                             strokeColor: "<?php echo isset($circle_stroke_color_opacity[0]) ? esc_attr($circle_stroke_color_opacity[0]) : "#000000"; ?>",
                             strokeOpacity: '<?php echo isset($circle_stroke_color_opacity[1]) ? floatval($circle_stroke_color_opacity[1] / 100) : 1; ?>',
                             strokeWeight: "<?php echo isset($circles["circle_stroke_weight"]) ? intval($circles["circle_stroke_weight"]) : 2; ?>",
                             fillColor: "<?php echo isset($circle_fill_color_opacity[0]) ? esc_attr($circle_fill_color_opacity[0]) : "#000000"; ?>",
                             fillOpacity: "<?php echo isset($circle_fill_color_opacity[1]) ? floatval($circle_fill_color_opacity[1] / 100) : "#000000"; ?>",
                             map: map,
                             center: circle_latLng,
                             radius: parseFloat("<?php echo $circle_radius; ?>")
                          });
                  circle.setMap(map);
            <?php
         }
      }
      ?>
         }
         function gmb_create_map(check_data)
         {
      <?php
      $ip = get_ip_address_google_map();
      $ip_address = ($ip == "::1" || $ip == "127.0.0.1") ? ip2long("127.0.0.1") : ip2long($ip);
      $location = get_ip_location_google_map(long2ip($ip_address));
      ?>
            var map_latitude = jQuery("#ux_txt_latitude").val() === "" ? "<?php echo $location->latitude != "0" ? floatval($location->latitude) : "40.73141229999999"; ?>" : jQuery("#ux_txt_latitude").val();
            var map_longitude = jQuery("#ux_txt_longitude").val() === "" ? "<?php echo $location->latitude != "0" ? floatval($location->longitude) : "-73.9969848"; ?>" : jQuery("#ux_txt_longitude").val();
            var map_type = check_data === "" ? jQuery("#ux_ddl_map_type").val() : '<?php echo isset($serialized_map_data["map_type"]) ? esc_attr($serialized_map_data["map_type"]) : "roadmap"; ?>';
            var zoom_level = check_data === "" ? jQuery("#ux_ddl_map_zoom_level").val() : '<?php echo isset($serialized_map_data["map_zoom_level"]) ? intval($serialized_map_data["map_zoom_level"]) : "18"; ?>';
            var latitude = check_data === "" ? map_latitude : '<?php echo isset($serialized_map_data["map_latitude"]) ? floatval($serialized_map_data["map_latitude"]) : "40.73141229999999"; ?>';
            var longitude = check_data === "" ? map_longitude : '<?php echo isset($serialized_map_data["map_longitude"]) ? floatval($serialized_map_data["map_longitude"]) : "-73.9969848"; ?>';
            var type = "";
            switch (map_type)
            {
               case "roadmap":
                  type = google.maps.MapTypeId.ROADMAP;
                  break;
               case "satellite":
                  type = google.maps.MapTypeId.SATELLITE;
                  break;
               case "hybrid":
                  type = google.maps.MapTypeId.HYBRID;
                  break;
               case "terrain":
                  type = google.maps.MapTypeId.TERRAIN;
                  break;
            }
            var mapOptions =
                    {
                       center: new google.maps.LatLng(latitude, longitude),
                       zoom: parseInt(zoom_level),
                       streetViewControl: false,
                       panControl: true,
                       mapTypeControl: true,
                       mapTypeId: type,
                       scaleControl: true,
                       streetViewControl: true,
                       overviewMapControl: true,
                       rotateControl: true
                    };
            var map = new google.maps.Map(document.getElementById("ux_div_map_canvas"), mapOptions);
      <?php
      if (!isset($_REQUEST["overlay"])) {
         ?>
               get_all_overlays_data_google_maps(map);
         <?php
      }
      ?>
            return map;
         }
         function marker_initialize_google_maps(map)
         {
            var lat = jQuery("#ux_txt_marker_latitude").val();
            var lng = jQuery("#ux_txt_marker_longitude").val();
            var marker_animation = jQuery("#ux_ddl_marker_animation").val();
            var image = "";
            if (jQuery("#ux_ddl_marker_icon").val() === "choose_icon")
            {
               image = jQuery("#ux_div_show_map_icons_ability .selected").attr("src");
            } else if (jQuery("#ux_ddl_marker_icon").val() === "upload")
            {
               image = jQuery("#ux_txt_marker_icon_path").val();
            }
            if (image === undefined || image === "")
            {
               var icon = "";
            } else
            {
               var icon = {
                  url: image,
                  scaledSize: new google.maps.Size(32, 32),
                  origin: new google.maps.Point(0, 0),
                  anchor: new google.maps.Point(15, 40)
               };
            }
            var animation = "";
            switch (marker_animation)
            {
               case "bounce":
                  animation = google.maps.Animation.BOUNCE;
                  break;
               case "drop":
                  animation = google.maps.Animation.DROP;
                  break;
            }
            var check_zoom_level = '<?php echo isset($serialized_map_data["map_zoom_level"]) ? intval($serialized_map_data["map_zoom_level"]) : "18"; ?>';
            var position = new google.maps.LatLng(lat, lng);
            var marker = new google.maps.Marker
                    ({
                       draggable: true,
                       map: map,
                       animation: animation,
                       zoom: check_zoom_level,
                       position: new google.maps.LatLng(lat, lng),
                       icon: icon
                    });
            google.maps.event.addListener(marker, "dragend", function (event)
            {
               get_geocode_position_google_maps(marker.getPosition(), "#ux_txt_marker_address");
               map.panTo(marker.getPosition());
               jQuery("#ux_txt_marker_latitude").val(event.latLng.lat());
               jQuery("#ux_txt_marker_longitude").val(event.latLng.lng());
            });
            marker.setMap(map);
            if (lat !== "" && lng !== "")
               map.setCenter(position);
            var input = document.getElementById("ux_txt_marker_address");
            var marker_autocomplete = new google.maps.places.Autocomplete(input);
            marker_autocomplete.bindTo("bounds", map);
            marker_autocomplete.addListener("place_changed", function ()
            {
               var place = marker_autocomplete.getPlace();
               var check_zoom_level = '<?php echo isset($serialized_map_data["map_zoom_level"]) ? intval($serialized_map_data["map_zoom_level"]) : "18"; ?>';
               if (place.geometry.viewport)
               {
                  map.fitBounds(place.geometry.viewport);
                  map.setZoom(parseInt(check_zoom_level));
               } else
               {
                  map.setCenter(place.geometry.location);
                  map.setZoom(parseInt(check_zoom_level));
               }
               marker.setPosition(place.geometry.location);
               map.panTo(marker.getPosition());
               marker.setAnimation(animation);
               jQuery("#ux_txt_marker_latitude").val(place.geometry.location.lat());
               jQuery("#ux_txt_marker_longitude").val(place.geometry.location.lng());
            });
            if (jQuery("#ux_ddl_info_window").val() === "enable")
            {
               var infowindow_description = jQuery("#ux_txt_marker_desc").val();
               var infowindow_title = jQuery("#ux_txt_marker_title").val();
               var infowindow_image = jQuery("#ux_txt_image_upload_path").val();
               var content = "<div class='gmb-style-infowindow' style='overflow:auto;'><img  src='" + infowindow_image + "'class='gmb-image-padding-position' style='max-width:120px;display:inline;'>";
               content += "<p class='store-locator-style'>";
               content += "<span class='store-title-style'><b>" + infowindow_title + "</b></span><br/>";
               content += "<span class='store-description-style'>" + infowindow_description + "</span></p></div>";
               var marker_infowindow_open = '<?php echo isset($details_info_window["info_window_open_event"]) ? esc_attr($details_info_window["info_window_open_event"]) : "click"; ?>';
               var marker_infowindow_event = marker_infowindow_open === "click" ? "click" : "mouseover";
               var infowindow = new google.maps.InfoWindow();
               marker.addListener(marker_infowindow_event, function ()
               {
                  infowindow.setContent(content);
                  infowindow.open(map, marker);
               });
               if (marker_infowindow_open === "hover")
               {
                  marker.addListener("mouseout", function ()
                  {
                     infowindow.close(map, marker);
                  });
               }
            }
         }
         function gmb_remove_polygon_vertex(vertex)
         {
            var path = polygon.getPath();
            path.removeAt(vertex);
         }
         function get_polygon_coordinates_google_maps()
         {
            var html_str = [];
            var polygon_latlng = polygon.getPath().getArray();
            for (var index = 0; index < polygon_latlng.length; index++)
            {
               html_str.push("[" + polygon_latlng[index].lat() + ", " + polygon_latlng[index].lng() + "]\n");
            }
            jQuery("#ux_txt_polygon_coordinate").html(html_str);
         }
         function get_new_onclicked_polygon_coords_google_maps(event)
         {
            var polygon_coords = [];
            if (jQuery("#ux_txt_polygon_coordinate").html() !== "")
            {
               polygon_coords.push(jQuery("#ux_txt_polygon_coordinate").html());
            }
            path = polygon.getPath();
            path.push(event.latLng);
            polygon_coords.push("[" + event.latLng.lat() + ", " + event.latLng.lng() + "]\n");
            jQuery("#ux_txt_polygon_coordinate").html(polygon_coords);
         }
         function create_polygon_google_maps(map)
         {
            var polygon_stroke_weight = jQuery("#ux_ddl_polygon_weight").val();
            var polygon_stroke_color = jQuery("#ux_txt_polygon_stroke_color").val();
            var polygon_stroke_opacity = jQuery("#ux_txt_polygon_stroke_opacity").val();
            var polygon_fill_color = jQuery("#ux_txt_polygon_fill_color").val();
            var polygon_fill_color_opacity = jQuery("#ux_txt_polygon_fill_color_opacity").val();
            var path = [];
            var polygon_coordinate = jQuery("#ux_txt_polygon_coordinate").html();
            if (polygon_coordinate !== "")
            {
               var polygon_coordinate_string = polygon_coordinate.slice(0, -1);
               var polygon_coordinates_path = polygon_coordinate_string.split("\n");
               var get_polygon_Coords = [];
               var bounds = new google.maps.LatLngBounds();
               for (index = 0; index < polygon_coordinates_path.length; index++)
               {
                  var unwanted_char_replace_left = polygon_coordinates_path[index].replace("[", "");
                  var unwanted_char_replace_right = unwanted_char_replace_left.replace("]", "");
                  var polygons_coordinates_latlng = unwanted_char_replace_right.split(",");
                  var latlng = new google.maps.LatLng(polygons_coordinates_latlng[0], polygons_coordinates_latlng[1]);
                  get_polygon_Coords.push(latlng);
                  bounds.extend(latlng);
               }
               polygon = new google.maps.Polygon
                       ({
                          paths: get_polygon_Coords,
                          strokeColor: polygon_stroke_color,
                          strokeOpacity: parseFloat(polygon_stroke_opacity / 100),
                          strokeWeight: polygon_stroke_weight,
                          fillColor: polygon_fill_color,
                          fillOpacity: parseFloat(polygon_fill_color_opacity / 100),
                          editable: true,
                          draggable: true,
                          clickable: true
                       });
               map.fitBounds(bounds);
            } else
            {
               polygon = new google.maps.Polygon
                       ({
                          strokeColor: polygon_stroke_color,
                          strokeOpacity: parseFloat(polygon_stroke_opacity / 100),
                          strokeWeight: polygon_stroke_weight,
                          fillColor: polygon_fill_color,
                          fillOpacity: parseFloat(polygon_fill_color_opacity / 100),
                          editable: true,
                          draggable: true,
                          clickable: true
                       });
            }
            map.addListener("click", get_new_onclicked_polygon_coords_google_maps);
            google.maps.event.addListener(polygon, "dragend", get_polygon_coordinates_google_maps);
            google.maps.event.addListener(polygon.getPath(), "insert_at", get_polygon_coordinates_google_maps);
            google.maps.event.addListener(polygon.getPath(), "remove_at", get_polygon_coordinates_google_maps);
            google.maps.event.addListener(polygon.getPath(), "set_at", get_polygon_coordinates_google_maps);
            google.maps.event.addListener(polygon, "drag", function ()
            {
               var polygon_points = polygon.getPath().getArray();
               var bounds = new google.maps.LatLngBounds();
               for (var index = 0; index < polygon_points.length; index++)
               {
                  bounds.extend(polygon_points[index]);
               }
               map.fitBounds(bounds);
            });
            google.maps.event.addListener(polygon, "rightclick", function (event)
            {
               if (event.vertex === undefined)
               {
                  return;
               } else
               {
                  gmb_remove_polygon_vertex(event.vertex);
               }
            });
            polygon.setMap(map);
         }
         function google_maps_dragged_polyline_coords()
         {
            var changelatlng = [];
            var curLatLng = polyline.getPath().getArray();
            for (index = 0; index < curLatLng.length; index++)
            {
               changelatlng.push("[" + curLatLng[index].lat() + ", " + curLatLng[index].lng() + "]\n");
            }
            jQuery("#ux_div_polyline_coordinate").html(changelatlng);
         }
         function add_latitude_longitude_polyline_google_maps(event)
         {
            var coordinates = [];
            if (jQuery("#ux_div_polyline_coordinate").html() !== "")
            {
               coordinates.push(jQuery("#ux_div_polyline_coordinate").html());
            }
            var path = polyline.getPath();
            path.push(event.latLng);
            coordinates.push("[" + event.latLng.lat() + ", " + event.latLng.lng() + "]\n");
            jQuery("#ux_div_polyline_coordinate").html(coordinates);
         }
         function google_maps_remove_polyline_vertex(vertex)
         {
            var path = polyline.getPath();
            path.removeAt(vertex);
         }
         function create_polyline_google_maps(map)
         {
            var polyline_stroke_color = jQuery("#ux_txt_polyline_line_color").val();
            var polyline_stroke_opacity = jQuery("#ux_txt_polyline_line_opacity").val();
            var polyline_stroke_weight = jQuery("#ux_ddl_polyine_line_weight").val();
            var polyline_path = jQuery("#ux_div_polyline_coordinate").html();
            var polyline_type = jQuery("#ux_ddl_polyline_type").val();
            var poly_line_stroke_opacity = "";
            var repeat = "";
            var lineSymbol = "";
            switch (polyline_type)
            {
               case "solid":
                  poly_line_stroke_opacity = parseFloat(polyline_stroke_opacity / 100);
                  break;
               case "dotted":
                  poly_line_stroke_opacity = 0;
                  repeat = "10px";
                  var lineSymbol =
                          {
                             path: google.maps.SymbolPath.CIRCLE,
                             fillOpacity: parseFloat(polyline_stroke_opacity / 100),
                             scale: polyline_stroke_weight
                          };
                  break;
               case "dashed":
                  poly_line_stroke_opacity = 0;
                  repeat = "20px";
                  var lineSymbol =
                          {
                             path: "M 0,-1 0,1",
                             strokeOpacity: parseFloat(polyline_stroke_opacity / 100),
                             scale: polyline_stroke_weight
                          };
                  break;
            }
            if (polyline_path !== "")
            {
               var cords_str = polyline_path.slice(0, -1);
               var polyline_path = cords_str.split("\n");
               var coords = [];
               var bounds = new google.maps.LatLngBounds();
               for (index = 0; index < polyline_path.length; index++)
               {
                  var unwanted_char_replace_left = polyline_path[index].replace("[", "");
                  var unwanted_char_replace_right = unwanted_char_replace_left.replace("]", "");
                  var polyline_coordinate_latlng = unwanted_char_replace_right.split(",");
                  var latlng = new google.maps.LatLng(polyline_coordinate_latlng[0], polyline_coordinate_latlng[1]);
                  coords.push(latlng);
                  bounds.extend(latlng);
               }
               polyline = new google.maps.Polyline
                       ({
                          path: coords,
                          strokeColor: polyline_stroke_color,
                          strokeOpacity: poly_line_stroke_opacity,
                          strokeWeight: polyline_stroke_weight,
                          draggable: true,
                          editable: true,
                          geodesic: true,
                          icons: [{
                                icon: lineSymbol,
                                offset: "0",
                                repeat: repeat
                             }]
                       });
               map.fitBounds(bounds);
            } else
            {
               polyline = new google.maps.Polyline
                       ({
                          strokeColor: polyline_stroke_color,
                          strokeOpacity: poly_line_stroke_opacity,
                          strokeWeight: polyline_stroke_weight,
                          draggable: true,
                          editable: true,
                          geodesic: true,
                          icons: [{
                                icon: lineSymbol,
                                offset: "0",
                                repeat: repeat
                             }]
                       });
            }
            polyline.setMap(map);
            map.addListener("click", add_latitude_longitude_polyline_google_maps);
            google.maps.event.addListener(polyline.getPath(), "dragend", google_maps_dragged_polyline_coords);
            google.maps.event.addListener(polyline.getPath(), "insert_at", google_maps_dragged_polyline_coords);
            google.maps.event.addListener(polyline.getPath(), "remove_at", google_maps_dragged_polyline_coords);
            google.maps.event.addListener(polyline.getPath(), "set_at", google_maps_dragged_polyline_coords);
            google.maps.event.addListener(polyline, "drag", function ()
            {
               var polyline_points = polyline.getPath().getArray();
               var bounds = new google.maps.LatLngBounds();
               for (var index = 0; index < polyline_points.length; index++)
               {
                  bounds.extend(polyline_points[index]);
               }
               map.fitBounds(bounds);
            });
            google.maps.event.addListener(polyline, "rightclick", function (e)
            {
               if (e.vertex === undefined)
               {
                  return;
               } else
               {
                  google_maps_remove_polyline_vertex(e.vertex);
               }
            });
         }
         function google_maps_circle_initialize(map)
         {
            var stroke_color = jQuery("#ux_txt_circle_stroke_color").val();
            var stroke_opacity = jQuery("#ux_txt_circle_stroke_opacity").val();
            var stroke_weight = jQuery("#ux_ddl_circle_weight").val();
            var fill_color = jQuery("#ux_txt_circle_fill_color").val();
            var fill_color_opacity = jQuery("#ux_txt_circle_fill_color_opacity").val();
            var radius_type = jQuery("#ux_ddl_circle_radius_type").val();
            var radius_value = jQuery("#ux_txt_circle_radius_value").val();
            switch (radius_type)
            {
               case "metres":
                  circle_radius = parseInt(radius_value);
                  break;
               case "kilometers":
                  circle_radius = parseInt(radius_value * 1000);
                  break;
               case "miles":
                  circle_radius = parseFloat(radius_value * 1609.34);
                  break;
            }
            var coordinates = jQuery("#ux_txt_circle_coordinate").html();
            if (coordinates !== "" && coordinates !== null)
            {
               var circle_coordinates = coordinates.split("\n");
               var circle_lat = parseFloat(circle_coordinates[0].substr(10));
               var circle_lng = parseFloat(circle_coordinates[1].substr(11));
               var circle_latLng = new google.maps.LatLng(circle_lat, circle_lng);
               var circle = new google.maps.Circle(
                       {
                          draggable: true,
                          editable: true,
                          strokeColor: stroke_color,
                          strokeOpacity: parseFloat(stroke_opacity / 100),
                          strokeWeight: stroke_weight,
                          fillColor: fill_color,
                          fillOpacity: parseFloat(fill_color_opacity / 100),
                          map: map,
                          center: circle_latLng,
                          radius: parseFloat(circle_radius)
                       });
               google.maps.event.addListener(circle, "radius_changed", function ()
               {
                  map.panTo(circle.getCenter());
                  var radius_in_metres = circle.getRadius();
                  switch (radius_type)
                  {
                     case "metres":
                        jQuery("#ux_txt_circle_radius_value").val(parseInt(radius_in_metres));
                        break;
                     case "kilometers":
                        jQuery("#ux_txt_circle_radius_value").val(parseInt(radius_in_metres / 1000));
                        if (radius_in_metres < 1000)
                        {
                           jQuery("#ux_ddl_circle_radius_type").val("metres");
                           jQuery("#ux_txt_circle_radius_value").val(parseInt(radius_in_metres));
                        }
                        break;
                     case "miles":
                        jQuery("#ux_txt_circle_radius_value").val(parseInt(radius_in_metres / 1609.34));
                        if (radius_in_metres < 1609.34)
                        {
                           jQuery("#ux_ddl_circle_radius_type").val("kilometers");
                           jQuery("#ux_txt_circle_radius_value").val(parseInt(radius_in_metres / 1000));
                        }
                        break;
                  }
               });
               google.maps.event.addListener(circle, "center_changed", function ()
               {
                  map.panTo(circle.getCenter());
                  jQuery("#ux_txt_circle_coordinate").html("Latitude : " + circle.getCenter().lat() + "\nLongitude : " + circle.getCenter().lng());
               });
               google.maps.event.addListener(circle, "rightclick", function ()
               {
                  circle.setMap(null);
                  jQuery("#ux_txt_circle_coordinate").html("");
                  google_maps_circle_initialize(map);
               });
               map.panTo(circle.getCenter());
            } else
            {
               var count = 0;
               google.maps.event.addListener(map, "click", function (e)
               {
                  if (count < 1)
                  {
                     jQuery("#ux_txt_circle_coordinate").html("Latitude : " + e.latLng.lat() + "\nLongitude : " + e.latLng.lng());
                     google_maps_circle_initialize(map);
                     count++;
                  }
               });
            }
         }
         function google_maps_clear_info_window_image(id)
         {
            if (jQuery(id).val() !== "")
            {
               var confirm_delete = confirm(<?php echo json_encode($gm_confirm_clear); ?>);
               if (confirm_delete === true)
               {
                  jQuery(id).val("");
                  if (id === "#ux_txt_store_locator_image_upload_path")
                  {
                     initialize_store_locator_google_maps();
                  } else
                  {
                     var map = gmb_create_map("serialize_data");
                     switch (id)
                     {
                        case "#ux_txt_image_upload_path":
                           marker_initialize_google_maps(map);
                           break;
                        case "#ux_txt_image_upload_polygon_path":
                           create_polygon_google_maps(map);
                           break;
                        case "#ux_txt_image_upload_polyline_path":
                           create_polyline_google_maps(map);
                           break;
                        case "#ux_txt_image_upload_circle_path":
                           google_maps_circle_initialize(map);
                           break;
                     }
                  }
               }
            }
         }
         function get_select_checkbox_setting(overlay_type)
         {
            switch (overlay_type)
            {
               case "marker":
                  jQuery("#ux_chk_overlay_type_marker").attr("checked", "checked");
                  jQuery("#ux_div_marker_settings").css("display", "block");
                  jQuery("#ux_div_polygon_settings,#ux_div_overlay_polygon_settings").css("display", "none");
                  jQuery("#ux_div_polyline_settings,#ux_div_overlay_polyline_settings").css("display", "none");
                  jQuery("#ux_div_circle_settings,#ux_div_overlay_circle_settings").css("display", "none");
                  jQuery("#ux_div_rectangle_settings,#ux_div_overlay_rectangle_settings").css("display", "none");
                  break;
               case "polygon":
                  jQuery("#ux_chk_overlay_type_polygon").attr("checked", "checked");
                  jQuery("#ux_div_marker_settings,#ux_div_overlay_marker_settings").css("display", "none");
                  jQuery("#ux_div_polygon_settings").css("display", "block");
                  jQuery("#ux_div_polyline_settings,#ux_div_overlay_polyline_settings").css("display", "none");
                  jQuery("#ux_div_circle_settings,#ux_div_overlay_circle_settings").css("display", "none");
                  jQuery("#ux_div_rectangle_settings,#ux_div_overlay_rectangle_settings").css("display", "none");
                  break;
               case "polyline":
                  jQuery("#ux_chk_overlay_type_polyline").attr("checked", "checked");
                  jQuery("#ux_div_marker_settings,#ux_div_overlay_marker_settings").css("display", "none");
                  jQuery("#ux_div_polygon_settings,#ux_div_overlay_polygon_settings").css("display", "none");
                  jQuery("#ux_div_polyline_settings").css("display", "block");
                  jQuery("#ux_div_circle_settings,#ux_div_overlay_circle_settings").css("display", "none");
                  jQuery("#ux_div_rectangle_settings,#ux_div_overlay_rectangle_settings").css("display", "none");
                  break;
               case "circle":
                  jQuery("#ux_chk_overlay_type_circle").attr("checked", "checked");
                  jQuery("#ux_div_marker_settings,#ux_div_overlay_marker_settings").css("display", "none");
                  jQuery("#ux_div_polygon_settings,#ux_div_overlay_polygon_settings").css("display", "none");
                  jQuery("#ux_div_polyline_settings,#ux_div_overlay_polyline_settings").css("display", "none");
                  jQuery("#ux_div_circle_settings").css("display", "block");
                  jQuery("#ux_div_rectangle_settings,#ux_div_overlay_rectangle_settings").css("display", "none");
                  break;
               case "rectangle":
                  jQuery("#ux_chk_overlay_type_rectangle").attr("checked", "checked");
                  jQuery("#ux_div_marker_settings,#ux_div_overlay_marker_settings").css("display", "none");
                  jQuery("#ux_div_polygon_settings,#ux_div_overlay_polygon_settings").css("display", "none");
                  jQuery("#ux_div_polyline_settings,#ux_div_overlay_polyline_settings").css("display", "none");
                  jQuery("#ux_div_circle_settings,#ux_div_overlay_circle_settings").css("display", "none");
                  jQuery("#ux_div_rectangle_settings").css("display", "block");
                  break;
            }
         }
         function google_maps_upload_marker_icon(id)
         {
            switch (jQuery(id).val())
            {
               case "default_icon":
                  jQuery("#ux_div_marker_icon_choose").css("display", "none");
                  jQuery("#ux_div_marker_icon_ablity").css("display", "none");
                  jQuery("#wp_media_upload_error").css("display", "none");
                  break;
               case "upload":
      <?php
      global $wp_version;
      if ($wp_version >= 3.5) {
         ?>
                     jQuery("#ux_div_marker_icon_ablity").css("display", "block");
         <?php
      } else {
         ?>
                     jQuery("#wp_media_upload_error").css("display", "block");
         <?php
      }
      ?>
                  jQuery("#ux_div_marker_icon_choose").css("display", "none");
                  break;
               case "choose_icon":
                  jQuery("#ux_div_marker_icon_choose").css("display", "block");
                  jQuery("#ux_div_marker_icon_ablity").css("display", "none");
                  jQuery("#wp_media_upload_error").css("display", "none");
                  break;
            }
         }
         function marker_change_category(id)
         {
            if (jQuery(id).val() !== 0)
            {
               var marker_category_selected = jQuery(id).val();
               jQuery("#ux_div_show_map_icons_ability").css("display", "block");
               jQuery("#ux_div_show_map_icons").css("display", "block");
               jQuery(".googlemaps-icons").css("display", "none");
               jQuery("#ux_" + marker_category_selected).css("display", "block");
            } else
            {
               jQuery("#ux_div_show_map_icons_ability").css("display", "none");
               jQuery("#ux_div_show_map_icons").css("display", "none");
            }
         }
         function initialize_google_map_setttings(type)
         {
            var map = gmb_create_map("serialize_data");
            switch (type)
            {
               case "marker":
                  marker_initialize_google_maps(map);
                  break;
               case "polygon":
                  create_polygon_google_maps(map);
                  break;
               case "polyline":
                  create_polyline_google_maps(map);
                  break;
               case "circle":
                  google_maps_circle_initialize(map);
                  break;
            }
         }
         function marker_img_select(img_id)
         {
            var image = jQuery("#img_" + img_id).attr("src");
            jQuery(".selected_marker").removeAttr("style");
            if (jQuery(".selected_marker").hasClass("selected"))
            {
               jQuery(".selected_marker").removeClass("selected");
            }
            jQuery("#img_" + img_id).addClass("selected");
            jQuery("#img_" + img_id).attr("style", "background-color: rgb(248, 248, 9);border: 1px solid rgb(245, 20, 20);");
      <?php
      if (isset($_GET["page"]) && esc_attr($_GET["page"]) === "gmb_add_store") {
         ?>
               initialize_store_locator_google_maps();
         <?php
      } else {
         ?>
               initialize_google_map_setttings("marker");
         <?php
      }
      ?>
         }
         function choose_address_type_google_maps(overlay_type, address_id, latlng_id)
         {
            switch (overlay_type)
            {
               case "formatted_address":
                  jQuery(address_id).css("display", "block");
                  jQuery(latlng_id).css("display", "none");
                  break;
               case "latitude_longitude":
                  jQuery(latlng_id).css("display", "block");
                  jQuery(address_id).css("display", "none");
                  break;
            }
         }
         function all_check_google_maps(id, table_id)
         {
            if (jQuery("input:checked", table_id.fnGetFilteredNodes()).length === jQuery("input[type=checkbox]", table_id.fnGetFilteredNodes()).length)
            {
               jQuery(id).attr("checked", "checked");
            } else
            {
               jQuery(id).removeAttr("checked");
            }
         }
         jQuery("#ux_chk_all_maps_marker").click(function ()
         {
            jQuery("input[type=checkbox]", oTable_marker.fnGetFilteredNodes()).attr("checked", this.checked);
         });
         jQuery("#ux_chk_all_maps_polyline").click(function ()
         {
            jQuery("input[type=checkbox]", oTable_polyline.fnGetFilteredNodes()).attr("checked", this.checked);
         });
         jQuery("#ux_chk_all_maps_polygon").click(function ()
         {
            jQuery("input[type=checkbox]", oTable_polygon.fnGetFilteredNodes()).attr("checked", this.checked);
         });
         jQuery("#ux_chk_all_maps_circle").click(function ()
         {
            jQuery("input[type=checkbox]", oTable_circle.fnGetFilteredNodes()).attr("checked", this.checked);
         });
         jQuery("#ux_chk_all_maps_rectangle").click(function ()
         {
            jQuery("input[type=checkbox]", oTable_rectangle.fnGetFilteredNodes()).attr("checked", this.checked);
         });
         function google_maps_cancel_maps_overlay_settings(path)
         {
            var cancel_settings = confirm(<?php echo json_encode($gm_confirm_cancel); ?>);
            if (cancel_settings === true)
            {
               overlay_loading_google_maps();
               setTimeout(function ()
               {
                  remove_overlay_google_maps();
                  window.location.href = path;
               }, 3000);
            }
         }
         function show_default_location_google_maps(id, div_id)
         {
            var type = jQuery(id).val();
            switch (type)
            {
               case "disable":
                  jQuery("#" + div_id).css("display", "none");
                  break;
               case "enable":
                  jQuery("#" + div_id).css("display", "block");
                  break;
            }
         }
         function delete_data_google_maps(meta_id, overlay_message, page_url, nonce, param)
         {
            var confirm_delete = confirm(<?php echo json_encode($gm_confirm_delete); ?>);
            if (confirm_delete === true)
            {
               overlay_loading_google_maps(overlay_message);
               jQuery.post(ajaxurl,
                       {
                          id: meta_id,
                          param: param,
                          action: "google_maps_backend",
                          _wp_nonce: nonce
                       },
                       function ()
                       {
                          setTimeout(function ()
                          {
                             remove_overlay_google_maps();
                             window.location.href = page_url;
                          }, 3000);
                       });
            }
         }
         function google_maps_initialize(map)
         {
            var input = document.getElementById("ux_txt_address");
            var map_autocomplete = new google.maps.places.Autocomplete(input);
            var check_zoom = '<?php echo isset($serialized_map_data["map_zoom_level"]) ? intval($serialized_map_data["map_zoom_level"]) : "18"; ?>';
            map_autocomplete.bindTo("bounds", map);
            map_autocomplete.addListener("place_changed", function ()
            {
               var place = map_autocomplete.getPlace();
               if (place.geometry.viewport)
               {
                  map.fitBounds(place.geometry.viewport);
               } else
               {
                  map.setCenter(place.geometry.location);
                  map.setZoom(parseInt(check_zoom));
               }
               jQuery("#ux_txt_latitude").val(place.geometry.location.lat());
               jQuery("#ux_txt_longitude").val(place.geometry.location.lng());
               gmb_create_map("");
            });
         }
         function get_address_by_latitude_longitude_google_maps(map, lat_id, lng_id, formatted_address, check)
         {
            var latlng = {lat: parseFloat(jQuery(lat_id).val()), lng: parseFloat(jQuery(lng_id).val())};
            var geocoder = new google.maps.Geocoder;
            geocoder.geocode({"location": latlng}, function (results, status)
            {
               if (status === "OK")
               {
                  if (results[1])
                  {
                     jQuery(formatted_address).val(results[1].formatted_address);
      <?php
      if (!isset($_REQUEST["overlay"])) {
         ?>
                        get_all_overlays_data_google_maps(map);
         <?php
      }
      ?>
                  }
               }
            });
            if (check === "marker")
            {
               initialize_google_map_setttings("marker");
            }
         }
         function geocode_latitude_longitude_google_maps(check)
         {
            if (check === "marker")
            {
               var map = gmb_create_map("serialize_data");
               get_address_by_latitude_longitude_google_maps(map, "#ux_txt_marker_latitude", "#ux_txt_marker_longitude", "#ux_txt_marker_address", check);
            } else
            {
               var map = gmb_create_map("");
               get_address_by_latitude_longitude_google_maps(map, "#ux_txt_latitude", "#ux_txt_longitude", "#ux_txt_address", check);
            }
         }
         function google_maps_upload_image(path)
         {
      <?php
      global $wp_version;
      if ($wp_version >= 3.5) {
         wp_enqueue_media();
      }
      ?>
            var image = "";
            var vid_thumb_file_frame;
            vid_thumb_file_frame = wp.media.frames.vid_thumb_file_frame = wp.media
                    ({
                       button:
                               {
                                  text: jQuery(this).data("uploader_button_text")
                               },
                       multiple: false
                    });
            vid_thumb_file_frame.on("select", function ()
            {
               var selection = vid_thumb_file_frame.state().get("selection");
               selection.map(function (attachment)
               {
                  attachment = attachment.toJSON();
                  if (attachment.type === "image")
                  {
                     var image_name = attachment.filename;
                     var image_target_url = attachment.url;
                     var image_title = attachment.title;
                     var image_desc = attachment.description === "" ? attachment.caption : attachment.description;
                     var alt_text = attachment.alt;
                     jQuery("#" + path).val(image_target_url);
                     image = image_target_url;
                     if (path === "ux_txt_store_locator_image_upload_path" || path === "ux_txt_store_locator_marker_icon_path")
                     {
                        initialize_store_locator_google_maps();
                     } else
                     {
                        var map = gmb_create_map("serialize_data");
                        switch (path)
                        {
                           case "ux_txt_marker_icon_path":
                           case "ux_txt_image_upload_path":
                              marker_initialize_google_maps(map);
                              break;
                           case "ux_txt_image_upload_polygon_path":
                              create_polygon_google_maps(map);
                              break;
                           case "ux_txt_image_upload_polyline_path":
                              create_polyline_google_maps(map);
                              break;
                           case "ux_txt_image_upload_circle_path":
                              google_maps_circle_initialize(map);
                              break;
                        }
                     }
                  }
               });
            });
            vid_thumb_file_frame.open();
         }
         function check_google_map_exists()
         {
            var shortCutFunction = jQuery("#toastTypeGroup_error input:checked").val();
            toastr[shortCutFunction](<?php echo json_encode($gm_confirm_choose_map) ?>);
         }
         var translation_request_array = [];
         var url = "<?php echo tech_banker_url . "/feedbacks.php"; ?>";
         var domain_url = "<?php echo site_url(); ?>";
         jQuery("#ux_frm_language_translator").validate
                 ({
                    rules:
                            {
                               ux_txt_your_name:
                                       {
                                          required: true
                                       },
                               ux_txt_email_address:
                                       {
                                          required: true,
                                          email: true
                                       },
                               ux_txt_language:
                                       {
                                          required: true
                                       },
                               ux_txtarea_query:
                                       {
                                          required: true
                                       }
                            },
                    errorPlacement: function ()
                    {
                    },
                    highlight: function (element)
                    {
                       jQuery(element).closest(".form-group").removeClass("has-success").addClass("has-error");
                    },
                    success: function (label, element)
                    {
                       var icon = jQuery(element).parent(".input-icon").children("i");
                       jQuery(element).closest(".form-group").removeClass("has-error").addClass("has-success");
                       icon.removeClass("fa-warning").addClass("fa-check");
                    },
                    submitHandler: function ()
                    {
                       translation_request_array.push(jQuery("#ux_txt_your_name").val(), jQuery("#ux_txt_email_address").val(), domain_url, jQuery("#ux_txt_language").val(), jQuery("#ux_txt_language").val(), jQuery("#ux_txtarea_query").val());
                       jQuery.post(url,
                               {
                                  data: JSON.stringify(translation_request_array),
                                  param: "gmb_translation_request"
                               },
                               function ()
                               {
                                  overlay_loading_google_maps(<?php echo json_encode($gm_feature_request_message); ?>);
                                  setTimeout(function ()
                                  {
                                     remove_overlay_google_maps();
                                     window.location.href = "admin.php?page=gmb_google_maps";
                                  }, 3000);
                               });
                    }
                 });
         // Close popup
         jQuery("[data-popup-close-translator]").on("click", function (e)
         {
            var confirm_close = confirm(<?php echo json_encode($gm_confirm_close); ?>);
            if (confirm_close === true)
            {
               var targeted_popup_class = jQuery(this).attr("data-popup-close-translator");
               jQuery('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);
            }
            e.preventDefault();
         });
         function open_popup_google_bank()
         {
            jQuery("[data-popup-open]").on("click", function (e)
            {
               var targeted_popup_class = jQuery(this).attr("data-popup-open");
               jQuery('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);
               e.preventDefault();
            });
         }
         function enable_disable_controls_google_maps(id, div_id)
         {
            switch (jQuery(id).val())
            {
               case "disable":
                  jQuery(div_id).css("display", "none");
                  break;
               case "enable":
                  jQuery(div_id).css("display", "block");
                  break;
            }
         }
         function show_pop_up_google_map()
         {
            open_popup_google_bank();
         }
         jQuery(document).ready(function ()
         {
            show_pop_up_google_map();
         });
      <?php
      $check_google_map_wizard = get_option("google-map-bank-wizard-set-up");
      $gmb_page_url = $check_google_map_wizard == "" ? "gmb_wizard_google_map" : esc_attr($_GET["page"]);
      if (isset($_GET["page"])) {
         switch ($gmb_page_url) {
            case "gmb_wizard_google_map":
               ?>
                  function show_hide_details_google_maps()
                  {
                     if (jQuery("#ux_div_wizard_set_up").hasClass("wizard-set-up"))
                     {
                        jQuery("#ux_div_wizard_set_up").css("display", "none");
                        jQuery("#ux_div_wizard_set_up").removeClass("wizard-set-up");
                     } else
                     {
                        jQuery("#ux_div_wizard_set_up").css("display", "block");
                        jQuery("#ux_div_wizard_set_up").addClass("wizard-set-up");
                     }
                  }
                  function plugin_stats_google_maps(type)
                  {
                     overlay_loading_google_maps();
                     jQuery.post(ajaxurl,
                             {
                                type: type,
                                param: "wizard_google_maps_bank",
                                action: "google_maps_backend",
                                _wp_nonce: "<?php echo $google_maps_check_status; ?>"
                             },
                             function ()
                             {
                                remove_overlay_google_maps();
                                window.location.href = "admin.php?page=gmb_google_maps";
                             });
                  }
               <?php
               break;
            case "gmb_google_maps":
               ?>
                  jQuery("#ux_li_google_map").addClass("active");
                  jQuery("#ux_li_manage_map").addClass("active");
               <?php
               if (map_settings_google_map == "1") {
                  ?>
                     var oTable = google_maps_manage_datatable("#ux_tbl_manage_maps");
                     jQuery("#ux_chk_all_manage_maps").click(function ()
                     {
                        jQuery("input[type=checkbox]", oTable.fnGetFilteredNodes()).attr("checked", this.checked);
                     });
                  <?php
               }
               break;
            case "gmb_add_map":
               ?>
                  jQuery("#ux_li_google_map").addClass("active");
                  jQuery("#ux_li_add_map").addClass("active");
               <?php
               if (map_settings_google_map == "1") {
                  ?>
                     var oTable_marker = google_maps_manage_datatable("#ux_tbl_maps_marker");
                     var oTable_polygon = google_maps_manage_datatable("#ux_tbl_maps_polygon");
                     var oTable_polyline = google_maps_manage_datatable("#ux_tbl_maps_polyline");
                     var oTable_circle = google_maps_manage_datatable("#ux_tbl_maps_circle");
                     var oTable_rectangle = google_maps_manage_datatable("#ux_tbl_maps_rectangle");
                     jQuery(document).ready(function ()
                     {
                  <?php
                  if (!isset($_REQUEST["google_map_id"])) {
                     if ($total_maps_data >= 5) {
                        ?>
                              window.location.href = "admin.php?page=gmb_google_maps";
                        <?php
                     }
                  }
                  ?>
                        choose_address_type_google_maps("<?php echo isset($serialized_map_data["map_address_type"]) ? esc_attr($serialized_map_data["map_address_type"]) : "formatted_address"; ?>", "#ux_div_map_address", "#ux_div_latitude_longitude");
                        show_hide_controls_google_maps("#ux_ddl_enable_heatmap_layer", "#ux_div_enable_heatmap_layer");
                        show_hide_controls_google_maps("#ux_ddl_enable_fusion_table_layer", "#ux_div_enable_fusion_table_layer");
                        show_hide_controls_google_maps("#ux_ddl_enable_kml_layer", "#ux_div_enable_kml_layer");
                        jQuery("#ux_ddl_map_type").val("<?php echo isset($serialized_map_data["map_type"]) ? esc_attr($serialized_map_data["map_type"]) : "roadmap" ?>");
                        jQuery("#ux_ddl_map_zoom_level").val("<?php echo isset($serialized_map_data["map_zoom_level"]) ? intval($serialized_map_data["map_zoom_level"]) : "18" ?>");
                        jQuery("#ux_ddl_marker_icon").val("<?php echo isset($serialize_edit_data["marker_icon_type"]) ? esc_attr($serialize_edit_data["marker_icon_type"]) : "default_icon"; ?>");
                        jQuery("#ux_ddl_marker_category").val("<?php echo isset($serialize_edit_data["marker_icon_category"]) ? intval($serialize_edit_data["marker_icon_category"]) : "0"; ?>");
                        jQuery("#ux_ddl_marker_animation").val("<?php echo isset($serialize_edit_data["marker_animation"]) ? esc_attr($serialize_edit_data["marker_animation"]) : "none"; ?>");
                        jQuery("#ux_ddl_polygon_info_window").val('<?php echo isset($serialize_polygon_edit_data["polygon_info_window"]) ? esc_attr($serialize_polygon_edit_data["polygon_info_window"]) : "disable"; ?>');
                        jQuery("#ux_ddl_polygon_weight").val('<?php echo isset($serialize_polygon_edit_data["polygon_stroke_weight"]) ? esc_attr($serialize_polygon_edit_data["polygon_stroke_weight"]) : "2"; ?>');
                        jQuery("#ux_ddl_info_window").val("<?php echo isset($serialize_edit_data["marker_info_window_show_hide"]) ? esc_attr($serialize_edit_data["marker_info_window_show_hide"]) : "disable"; ?>");
                        jQuery("#ux_ddl_polyline_info_window").val("<?php echo isset($serialize_polyline_edit_data["polyline_info_window"]) ? esc_attr($serialize_polyline_edit_data["polyline_info_window"]) : "disable"; ?>");
                        jQuery("#ux_ddl_polyine_line_weight").val("<?php echo isset($serialize_polyline_edit_data["polyline_stroke_width"]) ? intval($serialize_polyline_edit_data["polyline_stroke_width"]) : "2"; ?>");
                        jQuery("#ux_ddl_polyline_type").val("<?php echo isset($serialize_polyline_edit_data["polyline_type"]) ? esc_attr($serialize_polyline_edit_data["polyline_type"]) : "solid"; ?>");
                        jQuery("#ux_ddl_polygon_weight").val('<?php echo isset($serialize_polygon_edit_data["polygon_stroke_weight"]) ? intval($serialize_polygon_edit_data["polygon_stroke_weight"]) : "2"; ?>');
                        jQuery("#ux_ddl_circle_weight").val("<?php echo isset($serialize_circle_edit_data["circle_stroke_weight"]) ? intval($serialize_circle_edit_data["circle_stroke_weight"]) : "2"; ?>");
                        jQuery("#ux_ddl_circle_radius_type").val("<?php echo isset($serialize_circle_edit_data["circle_radius_type"]) ? esc_attr($serialize_circle_edit_data["circle_radius_type"]) : "metres"; ?>");
                        jQuery("#ux_ddl_circle_info_window").val("<?php echo isset($serialize_circle_edit_data["circle_info_window"]) ? esc_attr($serialize_circle_edit_data["circle_info_window"]) : "disable"; ?>");
                        jQuery("#ux_ddl_rectangle_info_window").val("<?php echo isset($serialize_rectangle_edit_data["rectangle_info_window"]) ? esc_attr($serialize_rectangle_edit_data["rectangle_info_window"]) : "disable"; ?>");
                        jQuery("#ux_ddl_rectangle_info_window_image_position").val("<?php echo isset($serialize_rectangle_edit_data["rectangle_infowindow_image_position"]) ? esc_attr($serialize_rectangle_edit_data["rectangle_infowindow_image_position"]) : "left"; ?>");
                        jQuery("#ux_ddl_enable_bicycling_layer").val("<?php echo isset($google_map_layers_data["bicycling_layer"]) ? esc_attr($google_map_layers_data["bicycling_layer"]) : "hide" ?>");
                        jQuery("#ux_ddl_enable_traffic_layer").val("<?php echo isset($google_map_layers_data["traffic_layer"]) ? esc_attr($google_map_layers_data["traffic_layer"]) : "hide" ?>");
                        jQuery("#ux_ddl_enable_transit_layer").val("<?php echo isset($google_map_layers_data["transit_layer"]) ? esc_attr($google_map_layers_data["transit_layer"]) : "hide" ?>");
                        jQuery("#ux_ddl_enable_heatmap_layer").val("<?php echo isset($google_map_layers_data["heatmap_layer"]) ? esc_attr($google_map_layers_data["heatmap_layer"]) : "hide" ?>");
                        jQuery("#ux_ddl_enable_gradient_heatmap").val("<?php echo isset($google_map_layers_data["heatmap_gradient_color"]) ? esc_attr($google_map_layers_data["heatmap_gradient_color"]) : "hide" ?>");
                        jQuery("#ux_ddl_enable_fusion_table_layer").val("<?php echo isset($google_map_layers_data["fusion_table_layer"]) ? esc_attr($google_map_layers_data["fusion_table_layer"]) : "hide" ?>");
                        jQuery("#ux_ddl_enable_kml_layer").val("<?php echo isset($google_map_layers_data["kml_layer"]) ? esc_attr($google_map_layers_data["kml_layer"]) : "hide" ?>");
                        show_hide_controls_google_maps("#ux_ddl_enable_heatmap_layer", "#ux_div_enable_heatmap_layer");
                        show_hide_controls_google_maps("#ux_ddl_enable_fusion_table_layer", "#ux_div_enable_fusion_table_layer");
                        show_hide_controls_google_maps("#ux_ddl_enable_kml_layer", "#ux_div_enable_kml_layer");
                        var map = gmb_create_map("");
                  <?php
                  if (isset($_REQUEST["overlay"])) {
                     ?>
                           google_maps_move_to_second_step();
                           get_select_checkbox_setting("<?php echo esc_attr($_REQUEST["overlay"]); ?>");
                     <?php
                  }
                  if (isset($_REQUEST["edit"]) && isset($_REQUEST["overlay"])) {
                     switch (esc_attr($_REQUEST["overlay"])) {
                        case "marker":
                           ?>
                                 show_settings_div_google_maps("marker");
                                 marker_initialize_google_maps(map);
                                 marker_change_category("#ux_ddl_marker_category");
                                 marker_img_select("<?php echo isset($serialize_edit_data["marker_icon_id"]) ? intval(substr($serialize_edit_data["marker_icon_id"], 4)) : 0; ?>");
                                 google_maps_info_window("#ux_ddl_info_window", "#ux_div_info_window_image", "#wp_media_upload_error_info");
                                 choose_address_type_google_maps("<?php echo isset($serialize_edit_data["marker_type"]) ? esc_attr($serialize_edit_data["marker_type"]) : ""; ?>", "#ux_div_marker_address", "#ux_div_marker_latitude_longitude");
                           <?php
                           break;
                        case "polygon":
                           ?>
                                 show_settings_div_google_maps("polygon");
                                 google_maps_info_window("#ux_ddl_polygon_info_window", "#ux_div_polygon_info_window_image", "#wp_media_upload_polygon_error_info");
                                 create_polygon_google_maps(map);
                           <?php
                           break;
                        case "polyline":
                           ?>
                                 google_maps_info_window("#ux_ddl_polyline_info_window", "#ux_div_polyline_info_window_image", "#wp_media_upload_polyline_error_info");
                                 show_settings_div_google_maps("polyline");
                                 create_polyline_google_maps(map);
                           <?php
                           break;
                        case "circle":
                           ?>
                                 google_maps_info_window("#ux_ddl_circle_info_window", "#ux_div_circle_info_window_image", "#wp_media_upload_circle_error_info");
                                 show_settings_div_google_maps("circle");
                                 google_maps_circle_initialize(map);
                           <?php
                           break;
                        case "rectangle":
                           ?>
                                 show_settings_div_google_maps("rectangle");
                                 google_maps_info_window("#ux_ddl_rectangle_info_window", "#ux_div_rectangle_info_window_image", "#wp_media_upload_rectangle_error_info");
                           <?php
                           break;
                     }
                  }
                  if (isset($_REQUEST["settings"]) && isset($_REQUEST["overlay"])) {
                     ?>
                           show_settings_div_google_maps("<?php echo esc_attr($_REQUEST["overlay"]); ?>");
                     <?php
                     switch (esc_attr($_REQUEST["overlay"])) {
                        case "marker":
                           ?>
                                 marker_initialize_google_maps(map);
                           <?php
                           break;
                        case "polygon":
                           ?>
                                 create_polygon_google_maps(map);
                           <?php
                           break;
                        case "polyline":
                           ?>
                                 create_polyline_google_maps(map);
                           <?php
                           break;
                        case "circle":
                           ?>
                                 google_maps_circle_initialize(map);
                           <?php
                           break;
                     }
                  }
                  if (isset($_REQUEST["layers"])) {
                     ?>
                           google_maps_move_to_third_step();
                     <?php
                  }
                  ?>
                        google_maps_upload_marker_icon("#ux_ddl_marker_icon");
                        google_maps_initialize(map);
                     });
                     function gmb_change_map_setting()
                     {
                        var map = gmb_create_map("");
                     }
                     function show_settings_google_maps(mapid, overlay)
                     {
                        window.location.href = "admin.php?page=gmb_add_map" + mapid + "&overlay=" + overlay + "&settings";
                     }
                     function show_settings_div_google_maps(overlay_type)
                     {
                        switch (overlay_type)
                        {
                           case "marker":
                              jQuery("#ux_div_marker_settings,#ux_div_overlay_type,#ux_div_maps_action").css("display", "none");
                              jQuery("#ux_div_map_ability,#ux_div_overlay_marker_settings").css("display", "block");
                              break;
                           case "polygon":
                              jQuery("#ux_div_polygon_settings,#ux_div_overlay_type,#ux_div_maps_action").css("display", "none");
                              jQuery("#ux_div_map_ability,#ux_div_overlay_polygon_settings").css("display", "block");
                              break;
                           case "polyline":
                              jQuery("#ux_div_polyline_settings,#ux_div_overlay_type,#ux_div_maps_action").css("display", "none");
                              jQuery("#ux_div_map_ability,#ux_div_overlay_polyline_settings").css("display", "block");
                              break;
                           case "circle":
                              jQuery("#ux_div_circle_settings,#ux_div_overlay_type,#ux_div_maps_action").css("display", "none");
                              jQuery("#ux_div_map_ability,#ux_div_overlay_circle_settings").css("display", "block");
                              break;
                           case "rectangle":
                              jQuery("#ux_div_rectangle_settings,#ux_div_overlay_type,#ux_div_maps_action").css("display", "none");
                              jQuery("#ux_div_map_ability,#ux_div_overlay_rectangle_settings").css("display", "block");
                              break;
                        }
                     }
                     function google_maps_save_settings(mapid, message, param, nonce, url, icon_src, edit_id, icon_id)
                     {
                        if (message !== "")
                        {
                           overlay_loading_google_maps(message);
                        } else
                        {
                           overlay_loading_google_maps();
                        }
                        jQuery.post(ajaxurl,
                                {
                                   id: mapid,
                                   edit: edit_id,
                                   icon_url: icon_src,
                                   icon_id: icon_id,
                                   data: base64_encode_google_maps_bank(jQuery("#ux_frm_maps_settings").serialize()),
                                   param: param,
                                   action: "google_maps_backend",
                                   _wp_nonce: nonce
                                },
                                function (data)
                                {
                                   setTimeout(function ()
                                   {
                                      remove_overlay_google_maps();
                                      if (url !== "layers")
                                      {
                                         window.location.href = "admin.php?page=gmb_add_map&google_map_id=" + data + "&overlay=" + url;
                                      } else
                                      {
                                         window.location.href = "admin.php?page=gmb_google_maps";
                                      }
                                   }, 3000);
                                });
                     }
                     jQuery("#ux_frm_maps_settings").validate
                             ({
                                rules:
                                        {
                                           ux_txt_map_title:
                                                   {
                                                      required: true
                                                   },
                                           ux_txt_address:
                                                   {
                                                      required: true
                                                   },
                                           ux_txt_latitude:
                                                   {
                                                      required: true,
                                                      latvalid: true
                                                   },
                                           ux_txt_longitude:
                                                   {
                                                      required: true,
                                                      lngvalid: true
                                                   },
                                           ux_txt_marker_address:
                                                   {
                                                      required: true
                                                   },
                                           ux_txt_marker_latitude:
                                                   {
                                                      required: true,
                                                      marker_lat_valid: true
                                                   },
                                           ux_txt_marker_longitude:
                                                   {
                                                      required: true,
                                                      marker_lng_valid: true
                                                   },
                                           ux_txt_marker_title:
                                                   {
                                                      required: true
                                                   },
                                           ux_txt_marker_icon_path:
                                                   {
                                                      required: true
                                                   },
                                           ux_txt_polygon_title:
                                                   {
                                                      required: true
                                                   },
                                           ux_txt_polygon_weight:
                                                   {
                                                      required: true
                                                   },
                                           ux_txt_polygon_coordinate:
                                                   {
                                                      required: true
                                                   },
                                           ux_txt_polyline_title:
                                                   {
                                                      required: true
                                                   },
                                           ux_div_polyline_coordinate:
                                                   {
                                                      required: true
                                                   },
                                           ux_txt_circle_title:
                                                   {
                                                      required: true
                                                   },
                                           ux_txt_circle_coordinate:
                                                   {
                                                      required: true
                                                   }
                                        },
                                errorPlacement: function ()
                                {
                                },
                                highlight: function (element)
                                {
                                   jQuery(element).closest(".form-group").removeClass("has-success").addClass("has-error");
                                },
                                success: function (label, element)
                                {
                                   jQuery(element).closest(".form-group").removeClass("has-error").addClass("has-success");
                                },
                                submitHandler: function ()
                                {
                                   setTimeout(function ()
                                   {
                                      var mapid = "<?php echo isset($_REQUEST["google_map_id"]) ? intval($_REQUEST["google_map_id"]) : "" ?>";
                                      var edit_id = "<?php echo isset($_REQUEST["edit"]) ? intval($_REQUEST["edit"]) : ""; ?>";
                                      var overlay_request = "<?php echo isset($_REQUEST["overlay"]) ? esc_attr($_REQUEST["overlay"]) : ""; ?>";
                                      var layers_request = "<?php echo isset($_REQUEST["layers"]) ? "layers" : ""; ?>";
                                      if (layers_request === "")
                                      {
                                         switch (overlay_request)
                                         {
                                            case "":
                                               google_maps_save_settings(mapid, "", "google_maps_add_maps", "<?php echo $google_maps_add_maps_nonce; ?>", "marker", "", "", "");
                                               break;
                                            case "marker":
                                               var marker_icons_src = jQuery("#ux_div_show_map_icons_ability .googlemaps-icons").find(".selected").attr("icon_src");
                                               var marker_icons_id = jQuery("#ux_div_show_map_icons_ability .googlemaps-icons").find(".selected").attr("id");
                                               var icons_id = marker_icons_id !== undefined ? marker_icons_id : "";
                                               if (jQuery("#ux_ddl_marker_icon").val() === "choose_icon" && (marker_icons_src === undefined || jQuery("#ux_ddl_marker_category").val() === 0))
                                               {
                                                  var shortCutFunction = jQuery("#toastTypeGroup_error input:checked").val();
                                                  toastr[shortCutFunction]("<?php echo $gm_error_choose_icon_message; ?>");
                                               } else
                                               {
                                                  google_maps_save_settings(mapid, edit_id === "" ? <?php echo json_encode($gm_add_marker_message); ?> : <?php echo json_encode($gm_update_marker_data); ?>, "google_maps_add_marker", "<?php echo $google_maps_add_marker_nonce; ?>", "marker", marker_icons_src, edit_id, icons_id);
                                               }
                                               break;
                                            case "polygon":
                                               google_maps_save_settings(mapid, edit_id === "" ? <?php echo json_encode($gm_polygon_saving_message); ?> : <?php echo json_encode($gm_update_polygon_data); ?>, "google_map_polygon_module", "<?php echo $google_maps_polygon_nonce; ?>", "polygon", "", edit_id, "");
                                               break;
                                            case "polyline":
                                               google_maps_save_settings(mapid, edit_id === "" ? <?php echo json_encode($gm_polyline_saving_message); ?> : <?php echo json_encode($gm_update_polyline_data); ?>, "google_maps_add_polyline", "<?php echo $google_maps_add_polyline_nonce; ?>", "polyline", "", edit_id, "");
                                               break;
                                            case "circle":
                                               google_maps_save_settings(mapid, edit_id === "" ? <?php echo json_encode($gm_circle_saving_message); ?> : <?php echo json_encode($gm_update_circle_data); ?>, "google_map_overlay_circle", "<?php echo $google_map_add_circle_nonce; ?>", "circle", "", edit_id, "");
                                               break;
                                            case "rectangle":
                                               premium_edition_notification_google_maps_bank();
                                               break;
                                         }
                                      } else
                                      {
                                         google_maps_save_settings(mapid,<?php echo json_encode($gm_update_saving_message); ?>, "add_maps_layers", "<?php echo $add_maps_layers_nonce; ?>", "layers", "", "", "");
                                      }
                                   }, 500);
                                }
                             });
                     function google_maps_move_to_first_step()
                     {
                        jQuery("#ux_div_map_canvas").css("display", "block");
                        jQuery("#ux_div_first_step_basic").css("display", "block");
                        jQuery("#ux_div_second_step_overlay").css("display", "none");
                        jQuery("#ux_div_third_step_layers").css("display", "none");
                        jQuery("#ux_div_step_progres_bar_width").css("width", "33%");
                        jQuery("#ux_div_frm_wizard li:eq(0)").addClass("active");
                        jQuery("#ux_div_frm_wizard li:eq(1)").removeClass("active");
                        jQuery("#ux_div_frm_wizard li:eq(2)").removeClass("active");
                     }
                     function google_maps_move_to_second_step()
                     {
                        jQuery("#ux_div_map_ability").css("display", "none");
                        jQuery("#ux_div_first_step_basic").css("display", "none");
                        jQuery("#ux_div_second_step_overlay").css("display", "block");
                        jQuery("#ux_div_third_step_layers").css("display", "none");
                        jQuery("#ux_div_step_progres_bar_width").css("width", "66%");
                        jQuery("#ux_div_frm_wizard li:eq(0)").addClass("active");
                        jQuery("#ux_div_frm_wizard li:eq(1)").addClass("active");
                        jQuery("#ux_div_frm_wizard li:eq(2)").removeClass("active");
                     }
                     function google_maps_move_to_third_step()
                     {
                        jQuery("#ux_div_map_ability").css("display", "block");
                        jQuery("#ux_div_first_step_basic").removeClass("first-step-helper");
                        jQuery("#ux_div_first_step_basic").css("display", "none");
                        jQuery("#ux_div_second_step_overlay").css("display", "none");
                        jQuery("#ux_div_third_step_layers").css("display", "block");
                        jQuery("#ux_div_step_progres_bar_width").css("width", "100%");
                        jQuery("#ux_div_step_progres_bar_width").css("width", "100%");
                        jQuery("#ux_div_frm_wizard li:eq(0)").addClass("active");
                        jQuery("#ux_div_frm_wizard li:eq(1)").addClass("active");
                        jQuery("#ux_div_frm_wizard li:eq(2)").addClass("active");
                     }
                  <?php
               }
               break;
            case "gmb_manage_overlays":
               ?>
                  jQuery("#ux_li_google_map_overlay").addClass("active");
                  jQuery("#ux_li_manage_overlay").addClass("active");
               <?php
               if (overlays_google_map == "1") {
                  ?>
                     jQuery(document).ready(function ()
                     {
                  <?php
                  if (isset($_REQUEST["google_map_id"])) {
                     $id = intval($_REQUEST["google_map_id"]);
                     ?>
                           jQuery("#ux_ddl_choose_map").val("<?php echo $id; ?>");
                           jQuery("#ux_div_map_canvas_custom").css("display", "block");
                           var map = gmb_create_map("serialize_data");
                     <?php
                     if (isset($_REQUEST["overlay"])) {
                        ?>
                              get_all_overlays_data_google_maps(map);
                              jQuery(".tab-content .tab-pane,.tabbable-custom .nav-tabs li").removeClass("active");
                        <?php
                        switch (esc_attr($_REQUEST["overlay"])) {
                           case "marker":
                              ?>
                                    jQuery(".tab-content #marker_data,.tabbable-custom .nav-tabs li:eq(0)").addClass("active");
                              <?php
                              break;
                           case "polygon":
                              ?>
                                    jQuery(".tab-content #polygon_data,.tabbable-custom .nav-tabs li:eq(1)").addClass("active");
                              <?php
                              break;
                           case "polyline":
                              ?>
                                    jQuery(".tab-content #polyline_data,.tabbable-custom .nav-tabs li:eq(2)").addClass("active");
                              <?php
                              break;
                           case "circle":
                              ?>
                                    jQuery(".tab-content #circle_data,.tabbable-custom .nav-tabs li:eq(3)").addClass("active");
                              <?php
                              break;
                           case "rectangle":
                              ?>
                                    jQuery(".tab-content #rectangle_data,.tabbable-custom .nav-tabs li:eq(4)").addClass("active");
                              <?php
                              break;
                        }
                     }
                  }
                  ?>
                     });
                     var oTable_marker = google_maps_manage_datatable("#ux_tbl_marker_overlays");
                     var oTable_polygon = google_maps_manage_datatable("#ux_tbl_polygon_overlays");
                     var oTable_polyline = google_maps_manage_datatable("#ux_tbl_polyline_overlays");
                     var oTable_circle = google_maps_manage_datatable("#ux_tbl_circle_overlays");
                     var oTable_rectangle = google_maps_manage_datatable("#ux_tbl_rectangle_overlays");
                  <?php
               }
               break;
            case "gmb_add_overlays":
               ?>
                  jQuery("#ux_li_google_map_overlay").addClass("active");
                  jQuery("#ux_li_add_overlay").addClass("active");
               <?php
               if (overlays_google_map == "1") {
                  ?>
                     jQuery(document).ready(function ()
                     {
                        var map = gmb_create_map("serialize_data");
                  <?php
                  if (isset($_REQUEST["google_map_id"])) {
                     ?>
                           jQuery("#ux_ddl_marker_icon").val("<?php echo isset($serialize_overlay_edit_data["marker_icon_type"]) ? esc_attr($serialize_overlay_edit_data["marker_icon_type"]) : "default_icon"; ?>");
                           jQuery("#ux_ddl_marker_category").val("<?php echo isset($serialize_overlay_edit_data["marker_icon_category"]) ? intval($serialize_overlay_edit_data["marker_icon_category"]) : 0; ?>");
                           jQuery("#ux_ddl_marker_animation").val("<?php echo isset($serialize_overlay_edit_data["marker_animation"]) ? esc_attr($serialize_overlay_edit_data["marker_animation"]) : "none"; ?>");
                           jQuery("#ux_ddl_marker_info_window_img_position").val("<?php echo isset($serialize_overlay_edit_data["marker_info_window_img_position"]) ? esc_attr($serialize_overlay_edit_data["marker_info_window_img_position"]) : "left"; ?>");
                           jQuery("#ux_ddl_info_window").val("<?php echo isset($serialize_overlay_edit_data["marker_info_window_show_hide"]) ? esc_attr($serialize_overlay_edit_data["marker_info_window_show_hide"]) : "disable"; ?>");
                           jQuery("#ux_ddl_polygon_info_window").val("<?php echo isset($serialize_overlay_polygon_edit_data["polygon_info_window"]) ? esc_attr($serialize_overlay_polygon_edit_data["polygon_info_window"]) : "disable"; ?>");
                           jQuery("#ux_ddl_polyline_info_window").val("<?php echo isset($polyline_overlays_edit_data["polyline_info_window"]) ? esc_attr($polyline_overlays_edit_data["polyline_info_window"]) : "disable"; ?>");
                           jQuery("#ux_ddl_polygon_weight").val("<?php echo isset($serialize_overlay_polygon_edit_data["polygon_stroke_weight"]) ? intval($serialize_overlay_polygon_edit_data["polygon_stroke_weight"]) : "2"; ?>");
                           jQuery("#ux_ddl_polyine_line_weight").val("<?php echo isset($polyline_overlays_edit_data["polyline_stroke_width"]) ? intval($polyline_overlays_edit_data["polyline_stroke_width"]) : "2"; ?>");
                           jQuery("#ux_ddl_polyline_type").val("<?php echo isset($polyline_overlays_edit_data["polyline_type"]) ? esc_attr($polyline_overlays_edit_data["polyline_type"]) : "solid"; ?>");
                           jQuery("#ux_ddl_circle_weight").val("<?php echo isset($serialize_circle_overlay_edit_data["circle_stroke_weight"]) ? intval($serialize_circle_overlay_edit_data["circle_stroke_weight"]) : "2"; ?>");
                           jQuery("#ux_ddl_circle_info_window").val("<?php echo isset($serialize_circle_overlay_edit_data["circle_info_window"]) ? esc_attr($serialize_circle_overlay_edit_data["circle_info_window"]) : "disable"; ?>");
                           jQuery("#ux_ddl_circle_radius_type").val("<?php echo isset($serialize_circle_overlay_edit_data["circle_radius_type"]) ? esc_attr($serialize_circle_overlay_edit_data["circle_radius_type"]) : "metres"; ?>");
                           jQuery("#ux_ddl_rectangle_info_window").val("<?php echo isset($serialize_rectangle_overlay_edit_data["rectangle_info_window"]) ? esc_attr($serialize_rectangle_overlay_edit_data["rectangle_info_window"]) : "disable"; ?>");
                           google_maps_info_window("#ux_ddl_info_window", "#ux_div_info_window_image", "#wp_media_upload_error_info");
                           choose_address_type_google_maps("<?php echo isset($serialize_overlay_edit_data["marker_type"]) ? esc_attr($serialize_overlay_edit_data["marker_type"]) : ""; ?>", "#ux_div_map_address", "#ux_div_latitude_longitude");
                           google_maps_info_window("#ux_ddl_polygon_info_window", "#ux_div_polygon_info_window_image", "#wp_media_upload_polygon_error_info");
                           google_maps_info_window("#ux_ddl_polyline_info_window", "#ux_div_polyline_info_window_image", "#wp_media_upload_polyline_error_info");
                           google_maps_info_window("#ux_ddl_circle_info_window", "#ux_div_circle_info_window_image", "#wp_media_upload_circle_error_info");
                           google_maps_info_window("#ux_ddl_rectangle_info_window", "#ux_div_rectangle_info_window_image", "#wp_media_upload_rectangle_error_info");
                           google_maps_canvas_show("<?php echo intval($_REQUEST["google_map_id"]); ?>", "#ux_ddl_choose_map", "#ux_map_canvas", "#ux_div_ddl_choose_map");
                           get_select_checkbox_setting("<?php echo isset($_REQUEST["overlay"]) ? esc_attr($_REQUEST["overlay"]) : "marker"; ?>");
                     <?php
                  }
                  if (isset($_REQUEST["overlay"])) {
                     switch (esc_attr($_REQUEST["overlay"])) {
                        case "marker":
                           ?>
                                 marker_initialize_google_maps(map);
                           <?php
                           break;
                        case "polygon":
                           ?>
                                 create_polygon_google_maps(map);
                           <?php
                           break;
                        case "polyline":
                           ?>
                                 create_polyline_google_maps(map);
                           <?php
                           break;
                        case "circle":
                           ?>
                                 google_maps_circle_initialize(map);
                           <?php
                           break;
                     }
                  }
                  if (isset($_REQUEST["edit"]) && isset($_REQUEST["overlay"])) {
                     ?>
                           jQuery("#choose_map_hide,#ux_div_overlay_hide").css("display", "none");
                     <?php
                     if (esc_attr($_REQUEST["overlay"]) == "marker") {
                        ?>
                              marker_change_category("#ux_ddl_marker_category");
                              marker_img_select("<?php echo isset($serialize_overlay_edit_data["marker_icon_id"]) ? intval(substr($serialize_overlay_edit_data["marker_icon_id"], 4)) : 0; ?>");
                        <?php
                     }
                  }
                  ?>
                        google_maps_upload_marker_icon("#ux_ddl_marker_icon");
                     });
                     function google_maps_overlays_settings(mapid, message, param, nonce, url, icon_src, edit_id, icon_id)
                     {
                        if (message !== "")
                        {
                           overlay_loading_google_maps(message);
                        } else
                        {
                           overlay_loading_google_maps();
                        }
                        jQuery.post(ajaxurl,
                                {
                                   id: mapid,
                                   edit: edit_id,
                                   icon_url: icon_src,
                                   icon_id: icon_id,
                                   data: base64_encode_google_maps_bank(jQuery("#ux_frm_add_overlays").serialize()),
                                   param: param,
                                   action: "google_maps_backend",
                                   _wp_nonce: nonce
                                },
                                function (data)
                                {
                                   setTimeout(function ()
                                   {
                                      remove_overlay_google_maps();
                                      window.location.href = "admin.php?page=gmb_manage_overlays&google_map_id=" + data + "&overlay=" + url;
                                   }, 3000);
                                });
                     }
                     jQuery("#ux_frm_add_overlays").validate
                             ({
                                rules:
                                        {
                                           ux_txt_marker_address:
                                                   {
                                                      required: true
                                                   },
                                           ux_txt_marker_latitude:
                                                   {
                                                      required: true,
                                                      latvalid: true
                                                   },
                                           ux_txt_marker_longitude:
                                                   {
                                                      required: true,
                                                      lngvalid: true
                                                   },
                                           ux_txt_marker_title:
                                                   {
                                                      required: true
                                                   },
                                           ux_txt_marker_icon_path:
                                                   {
                                                      required: true
                                                   },
                                           ux_txt_polygon_title:
                                                   {
                                                      required: true
                                                   },
                                           ux_txt_polygon_weight:
                                                   {
                                                      required: true
                                                   },
                                           ux_txt_polygon_coordinate:
                                                   {
                                                      required: true
                                                   },
                                           ux_txt_polyline_title:
                                                   {
                                                      required: true
                                                   },
                                           ux_div_polyline_coordinate:
                                                   {
                                                      required: true
                                                   },
                                           ux_txt_circle_title:
                                                   {
                                                      required: true
                                                   },
                                           ux_txt_circle_coordinate:
                                                   {
                                                      required: true
                                                   }
                                        },
                                errorPlacement: function ()
                                {
                                },
                                highlight: function (element)
                                {
                                   jQuery(element).closest(".form-group").removeClass("has-success").addClass("has-error");
                                },
                                success: function (label, element)
                                {
                                   jQuery(element).closest(".form-group").removeClass("has-error").addClass("has-success");
                                },
                                submitHandler: function ()
                                {
                                   setTimeout(function ()
                                   {
                                      var overlay_type = "<?php echo isset($_REQUEST["overlay"]) ? esc_attr($_REQUEST["overlay"]) : ""; ?>";
                                      var mapid = jQuery("#ux_ddl_choose_map").val();
                                      var edit_id = "<?php echo isset($_REQUEST["edit"]) ? intval($_REQUEST["edit"]) : ""; ?>";
                                      switch (overlay_type)
                                      {
                                         case "marker":
                                            var marker_icons_src = jQuery("#ux_div_show_map_icons_ability .googlemaps-icons").find(".selected").attr("icon_src");
                                            var marker_icons_id = jQuery("#ux_div_show_map_icons_ability .googlemaps-icons").find(".selected").attr("id");
                                            var icons_id = marker_icons_id !== undefined ? marker_icons_id : "";
                                            if (jQuery("#ux_ddl_marker_icon").val() === "choose_icon" && (marker_icons_src === undefined || jQuery("#ux_ddl_marker_category").val() === 0))
                                            {
                                               var shortCutFunction = jQuery("#toastTypeGroup_error input:checked").val();
                                               toastr[shortCutFunction]("<?php echo $gm_error_choose_icon_message; ?>");
                                            } else
                                            {
                                               google_maps_overlays_settings(mapid, edit_id === "" ? <?php echo json_encode($gm_add_marker_message); ?> : <?php echo json_encode($gm_update_marker_data); ?>, "google_maps_add_marker", "<?php echo $google_maps_add_marker_nonce; ?>", "marker", marker_icons_src, edit_id, icons_id);
                                            }
                                            break;
                                         case "polygon":
                                            google_maps_overlays_settings(mapid, edit_id === "" ? <?php echo json_encode($gm_polygon_saving_message); ?> : <?php echo json_encode($gm_update_polygon_data); ?>, "google_map_polygon_module", "<?php echo $google_maps_polygon_nonce; ?>", "polygon", "", edit_id, "");
                                            break;
                                         case "polyline":
                                            google_maps_overlays_settings(mapid, edit_id === "" ? <?php echo json_encode($gm_polyline_saving_message); ?> : <?php echo json_encode($gm_update_polyline_data); ?>, "google_maps_add_polyline", "<?php echo $google_maps_add_polyline_nonce; ?>", "polyline", "", edit_id, "");
                                            break;
                                         case "circle":
                                            google_maps_overlays_settings(mapid, edit_id === "" ? <?php echo json_encode($gm_circle_saving_message); ?> : <?php echo json_encode($gm_update_circle_data); ?>, "google_map_overlay_circle", "<?php echo $google_map_add_circle_nonce; ?>", "circle", "", edit_id, "");
                                            break;
                                         default:
                                            premium_edition_notification_google_maps_bank();
                                            break;
                                      }
                                   }, 500);
                                }
                             });
                  <?php
               }
               break;
            case "gmb_layers":
               ?>
                  jQuery("#ux_li_google_map_layers").addClass("active");
               <?php
               if (layers_google_map == "1") {
                  ?>
                     jQuery(document).ready(function ()
                     {
                  <?php
                  if (isset($_REQUEST["google_map_id"])) {
                     ?>
                           jQuery("#ux_ddl_enable_bicycling_layer").val("<?php echo isset($layers_data_unserialized["bicycling_layer"]) ? esc_attr($layers_data_unserialized["bicycling_layer"]) : "hide" ?>");
                           jQuery("#ux_ddl_enable_traffic_layer").val("<?php echo isset($layers_data_unserialized["traffic_layer"]) ? esc_attr($layers_data_unserialized["traffic_layer"]) : "hide" ?>");
                           jQuery("#ux_ddl_enable_transit_layer").val("<?php echo isset($layers_data_unserialized["transit_layer"]) ? esc_attr($layers_data_unserialized["transit_layer"]) : "hide" ?>");
                           jQuery("#ux_ddl_enable_heatmap_layer").val("<?php echo isset($layers_data_unserialized["heatmap_layer"]) ? esc_attr($layers_data_unserialized["heatmap_layer"]) : "hide" ?>");
                           jQuery("#ux_ddl_enable_gradient_heatmap").val("<?php echo isset($layers_data_unserialized["heatmap_gradient_color"]) ? esc_attr($layers_data_unserialized["heatmap_gradient_color"]) : "hide" ?>");
                           jQuery("#ux_ddl_enable_fusion_table_layer").val("<?php echo isset($layers_data_unserialized["fusion_table_layer"]) ? esc_attr($layers_data_unserialized["fusion_table_layer"]) : "hide" ?>");
                           jQuery("#ux_ddl_enable_kml_layer").val("<?php echo isset($layers_data_unserialized["kml_layer"]) ? esc_attr($layers_data_unserialized["kml_layer"]) : "hide" ?>");
                           var map = gmb_create_map("serialize_data");
                           google_maps_canvas_show("<?php echo intval($_REQUEST["google_map_id"]); ?>", "#ux_ddl_choose_map", "#ux_map_canvas", "#ux_div_ddl_choose_map");
                     <?php
                  }
                  ?>
                        show_hide_controls_google_maps("#ux_ddl_enable_heatmap_layer", "#ux_div_enable_heatmap_layer");
                        show_hide_controls_google_maps("#ux_ddl_enable_fusion_table_layer", "#ux_div_enable_fusion_table_layer");
                        show_hide_controls_google_maps("#ux_ddl_enable_kml_layer", "#ux_div_enable_kml_layer");
                     });
                     jQuery("#ux_frm_add_layers").validate
                             ({
                                submitHandler: function ()
                                {
                                   if (jQuery("#ux_ddl_choose_map").val() === "")
                                   {
                                      var shortCutFunction = jQuery("#toastTypeGroup_error input:checked").val();
                                      toastr[shortCutFunction]("<?php echo $gm_confirm_choose_map; ?>");
                                   } else
                                   {
                                      premium_edition_notification_google_maps_bank();
                                   }
                                }
                             });
                  <?php
               }
               break;
            case "gmb_manage_store":
               ?>
                  jQuery("#ux_li_google_map_store_locator").addClass("active");
                  jQuery("#ux_li_manage_store").addClass("active");
               <?php
               if (store_locator_google_map == "1") {
                  ?>
                     var oTable_store_locator = google_maps_manage_datatable("#ux_tbl_manage_store");
                     jQuery("#ux_chk_all_manage_store").click(function ()
                     {
                        jQuery("input[type=checkbox]", oTable_store_locator.fnGetFilteredNodes()).attr("checked", this.checked);
                     });
                  <?php
               }
               break;
            case "gmb_add_store":
               ?>
                  jQuery("#ux_li_google_map_store_locator").addClass("active");
                  jQuery("#ux_li_add_store").addClass("active");
               <?php
               if (store_locator_google_map == "1") {
                  ?>
                     function initialize_store_locator_google_maps()
                     {
                  <?php
                  $ip = get_ip_address_google_map();
                  $ip_address = ($ip == "::1" || $ip == "127.0.0.1") ? ip2long("127.0.0.1") : ip2long($ip);
                  $location = get_ip_location_google_map(long2ip($ip_address));
                  ?>
                        var map_latitude = "<?php echo $location->latitude != "0" ? floatval($location->latitude) : "40.73141229999999"; ?>";
                        var map_longitude = "<?php echo $location->latitude != "0" ? floatval($location->longitude) : "-73.9969848"; ?>";
                        var mapOptions =
                                {
                                   center: new google.maps.LatLng(map_latitude, map_longitude),
                                   streetViewControl: false,
                                   panControl: true,
                                   mapTypeId: google.maps.MapTypeId.ROADMAP,
                                   scaleControl: true,
                                   overviewMapControl: true,
                                   rotateControl: true,
                                   zoom: 18
                                };
                        var lat = jQuery("#ux_txt_marker_latitude").val() === "" ? map_latitude : jQuery("#ux_txt_marker_latitude").val();
                        var lng = jQuery("#ux_txt_marker_longitude").val() === "" ? map_longitude : jQuery("#ux_txt_marker_longitude").val();
                        var map = new google.maps.Map(document.getElementById("ux_div_map_canvas"), mapOptions);
                        var position = new google.maps.LatLng(lat, lng);
                        var marker = new google.maps.Marker
                                ({
                                   draggable: true,
                                   map: map,
                                   position: new google.maps.LatLng(lat, lng)
                                });
                        marker.setMap(map);
                        map.setCenter(position);
                     }
                     jQuery(document).ready(function ()
                     {
                        jQuery("#ux_ddl_info_window").val("<?php echo isset($serialize_store_locator_edit_data["store_locator_info_window"]) ? esc_attr($serialize_store_locator_edit_data["store_locator_info_window"]) : "disable"; ?>");
                        jQuery("#ux_ddl_store_locator_marker_animation").val("<?php echo isset($serialize_store_locator_edit_data["store_locator_marker_animation"]) ? esc_attr($serialize_store_locator_edit_data["store_locator_marker_animation"]) : "none"; ?>");
                        jQuery("#ux_ddl_store_locator_marker_icon").val("<?php echo isset($serialize_store_locator_edit_data["store_locator_marker_icon"]) ? esc_attr($serialize_store_locator_edit_data["store_locator_marker_icon"]) : "default_icon"; ?>");
                        jQuery("#ux_ddl_store_locator_marker_category").val("<?php echo isset($serialize_store_locator_edit_data["store_locator_marker_category"]) ? intval($serialize_store_locator_edit_data["store_locator_marker_category"]) : "0"; ?>");
                        choose_address_type_google_maps("<?php echo isset($serialize_store_locator_edit_data["store_locator_address_type"]) ? esc_attr($serialize_store_locator_edit_data["store_locator_address_type"]) : "formatted_address"; ?>", "#ux_div_map_address", "#ux_div_latitude_longitude");
                        google_maps_info_window("#ux_ddl_info_window", "#store_locator_image", "#wp_media_upload_error_info");
                        google_maps_upload_marker_icon("#ux_ddl_store_locator_marker_icon");
                        marker_change_category("#ux_ddl_store_locator_marker_category");
                        marker_img_select("<?php echo isset($serialize_store_locator_edit_data["marker_icon_id"]) ? intval(substr($serialize_store_locator_edit_data["marker_icon_id"], 4)) : 0; ?>");
                        initialize_store_locator_google_maps();
                     });
                     jQuery("#ux_frm_store_locator").validate
                             ({
                                submitHandler: function ()
                                {
                                   premium_edition_notification_google_maps_bank();
                                }
                             });
                  <?php
               }
               break;
            case "gmb_info_window":
               ?>
                  jQuery("#ux_li_layout_settings").addClass("active");
                  jQuery("#ux_li_info_window").addClass("active");
               <?php
               if (layout_settings_google_map == "1") {
                  ?>
                     jQuery(document).ready(function ()
                     {
                        jQuery("#ux_ddl_title_font_size").val("<?php echo isset($info_window_title_style[0]) ? esc_attr($info_window_title_style[0]) : "15" ?>");
                        jQuery("#ux_ddl_title_font_family").val("<?php echo isset($details_info_window["info_window_title_font_family"]) ? htmlspecialchars_decode($details_info_window["info_window_title_font_family"]) : "Roboto Condensed" ?>");
                        jQuery("#ux_ddl_description_font_size").val("<?php echo isset($info_window_desc_style[0]) ? esc_attr($info_window_desc_style[0]) : "12" ?>");
                        jQuery("#ux_ddl_description_font_family").val("<?php echo isset($details_info_window["info_window_desc_font_family"]) ? htmlspecialchars_decode($details_info_window["info_window_desc_font_family"]) : "Roboto Condensed" ?>");
                        jQuery("#ux_ddl_border_style_thickness").val("<?php echo isset($info_window_border_style[1]) ? esc_attr($info_window_border_style[1]) : "none" ?>");
                        jQuery("#ux_ddl_info_window_img_position").val("<?php echo isset($details_info_window["info_window_image_position"]) ? esc_attr($details_info_window["info_window_image_position"]) : "left"; ?>");
                        jQuery("#ux_ddl_info_window_event").val("<?php echo isset($details_info_window["info_window_open_event"]) ? esc_attr($details_info_window["info_window_open_event"]) : "click"; ?>");
                     });
                     jQuery("#ux_frm_info_window").validate
                             ({
                                submitHandler: function ()
                                {
                                   overlay_loading_google_maps(<?php echo json_encode($gm_info_window_message); ?>);
                                   jQuery.post(ajaxurl,
                                           {
                                              data: base64_encode_google_maps_bank(jQuery("#ux_frm_info_window").serialize()),
                                              param: "gmb_info_window_module",
                                              action: "google_maps_backend",
                                              _wp_nonce: "<?php echo $info_window_nonce; ?>"
                                           },
                                           function ()
                                           {
                                              setTimeout(function ()
                                              {
                                                 remove_overlay_google_maps();
                                                 window.location.href = "admin.php?page=gmb_info_window";
                                              }, 3000);
                                           });
                                }
                             });
                  <?php
               }
               break;
            case "gmb_directions":
               ?>
                  jQuery("#ux_li_layout_settings").addClass("active");
                  jQuery("#ux_li_directions").addClass("active");
               <?php
               if (layout_settings_google_map == "1") {
                  ?>
                     jQuery(document).ready(function ()
                     {
                        jQuery("#ux_ddl_direction_header_title_style_size").val("<?php echo isset($direction_header_title_style[0]) ? esc_attr($direction_header_title_style[0]) : "20" ?>");
                        jQuery("#ux_ddl_direction_header_font_family").val("<?php echo isset($details_directions["directions_header_font_family"]) ? htmlspecialchars_decode($details_directions["directions_header_font_family"]) : "Roboto Condensed" ?>");
                        jQuery("#ux_ddl_direction_label_style_size").val("<?php echo isset($direction_label_style[0]) ? esc_attr($direction_label_style[0]) : "15" ?>");
                        jQuery("#ux_ddl_direction_label_font_family").val("<?php echo isset($details_directions["directions_label_font_family"]) ? htmlspecialchars_decode($details_directions["directions_label_font_family"]) : "Roboto Condensed" ?>");
                        jQuery("#ux_ddl_direction_input_field_text_style_size").val("<?php echo isset($direction_input_field_text_style[0]) ? esc_attr($direction_input_field_text_style[0]) : "15" ?>");
                        jQuery("#ux_ddl_direction_input_field_font_family").val("<?php echo isset($details_directions["directions_input_field_font_family"]) ? htmlspecialchars_decode($details_directions["directions_input_field_font_family"]) : "Roboto Condensed" ?>");
                        jQuery("#ux_ddl_direction_button_text_style_size").val("<?php echo isset($direction_button_text_style[0]) ? esc_attr($direction_button_text_style[0]) : "15"; ?>");
                        jQuery("#ux_ddl_direction_button_text_font_family").val("<?php echo isset($details_directions["directions_button_font_family"]) ? htmlspecialchars_decode($details_directions["directions_button_font_family"]) : "Roboto Condensed" ?>");
                        jQuery("#ux_ddl_direction_button_alignment").val("<?php echo isset($details_directions["directions_button_alignment"]) ? esc_attr($details_directions["directions_button_alignment"]) : "Roboto Condensed" ?>");
                        jQuery("#ux_ddl_text_direction_size").val("<?php echo isset($text_direction_style[0]) ? esc_attr($text_direction_style[0]) : "12" ?>");
                        jQuery("#ux_ddl_text_direction_font_family").val("<?php echo isset($details_directions["directions_display_text_font_family"]) ? htmlspecialchars_decode($details_directions["directions_display_text_font_family"]) : "Roboto Condensed" ?>");
                        jQuery("#ux_ddl_direction_input_field_placeholder_font_family").val("<?php echo isset($details_directions["directions_placeholder_font_family"]) ? htmlspecialchars_decode($details_directions["directions_placeholder_font_family"]) : "Roboto Condensed" ?>");
                        jQuery("#ux_ddl_input_field_size").val("<?php echo isset($directions_input_field_placeholder_style[0]) ? esc_attr($directions_input_field_placeholder_style[0]) : "15" ?>");
                        jQuery("#ux_ddl_directions_default_mode").val("<?php echo isset($details_directions["directions_input_field_default_mode"]) ? esc_attr($details_directions["directions_input_field_default_mode"]) : "Driving"; ?>");
                        jQuery("#ux_ddl_text_direction_border_style_size").val("<?php echo isset($direction_display_border_style[1]) ? esc_attr($direction_display_border_style[1]) : "none" ?>");
                        jQuery("#ux_ddl_direction").val("<?php echo isset($details_directions["direction_type"]) ? esc_attr($details_directions["direction_type"]) : "disable" ?>");
                        jQuery("#ux_ddl_default_location_to").val("<?php echo isset($details_directions["directions_type_to"]) ? esc_attr($details_directions["directions_type_to"]) : "disable" ?>");
                        show_default_location_google_maps('#ux_ddl_direction', 'ux_div_default_location_direction');
                        show_default_location_google_maps('#ux_ddl_default_location_to', 'ux_div_default_location_direction_to');
                        choose_address_type_google_maps("<?php echo isset($details_directions["direction_address_type"]) ? esc_attr($details_directions["direction_address_type"]) : "formatted_address"; ?>", "#ux_div_map_address", "#ux_div_latitude_longitude");
                        choose_address_type_google_maps("<?php echo isset($details_directions["direction_address_type_to"]) ? esc_attr($details_directions["direction_address_type_to"]) : "formatted_address"; ?>", "#ux_div_map_address_to", "#ux_div_latitude_longitude_to");
                     });
                     jQuery("#ux_frm_directions").validate
                             ({
                                submitHandler: function ()
                                {
                                   premium_edition_notification_google_maps_bank();
                                }
                             });
                  <?php
               }
               break;
            case "gmb_store_locator":
               ?>
                  jQuery("#ux_li_layout_settings").addClass("active");
                  jQuery("#ux_li_store_locator").addClass("active");
               <?php
               if (layout_settings_google_map == "1") {
                  ?>
                     jQuery(document).ready(function ()
                     {
                        choose_address_type_google_maps("<?php echo isset($details_store_locator["store_locator_input_field_default_location"]) ? esc_attr($details_store_locator["store_locator_input_field_default_location"]) : "formatted_address"; ?>", "#ux_div_map_address", "#ux_div_latitude_longitude");
                        jQuery("#ux_ddl_store_locator_header_title_style_size").val("<?php echo isset($store_locator_header_title_style[0]) ? esc_attr($store_locator_header_title_style[0]) : "20" ?>");
                        jQuery("#ux_ddl_store_locator_header_font_family").val("<?php echo isset($details_store_locator["store_locator_header_title_font_family"]) ? htmlspecialchars_decode($details_store_locator["store_locator_header_title_font_family"]) : "Roboto Condensed" ?>");
                        jQuery("#ux_ddl_store_locator_label_style_size").val("<?php echo isset($store_locator_label_style[0]) ? esc_attr($store_locator_label_style[0]) : "15" ?>");
                        jQuery("#ux_ddl_store_locator_label_font_family").val("<?php echo isset($details_store_locator["store_locator_label_font_family"]) ? htmlspecialchars_decode($details_store_locator["store_locator_label_font_family"]) : "Roboto Condensed" ?>");
                        jQuery("#ux_ddl_store_locator_input_field_text_style_size").val("<?php echo isset($store_locator_input_field_text_style[0]) ? intval($store_locator_input_field_text_style[0]) : "15" ?>");
                        jQuery("#ux_ddl_store_locator_input_field_font_family").val("<?php echo isset($details_store_locator["store_locator_input_field_font_family"]) ? htmlspecialchars_decode($details_store_locator["store_locator_input_field_font_family"]) : "Roboto Condensed" ?>");
                        jQuery("#ux_ddl_store_locator_button_text_size").val("<?php echo isset($store_locator_button_text_style[0]) ? esc_attr($store_locator_button_text_style[0]) : "15" ?>");
                        jQuery("#ux_ddl_store_locator_button_font_family").val("<?php echo isset($details_store_locator["store_locator_button_text_font_family"]) ? htmlspecialchars_decode($details_store_locator["store_locator_button_text_font_family"]) : "Roboto Condensed" ?>");
                        jQuery("#ux_ddl_store_locator_button_alignment").val("<?php echo isset($details_store_locator["store_locator_button_alignment"]) ? esc_attr($details_store_locator["store_locator_button_alignment"]) : "left" ?>");
                        jQuery("#ux_ddl_store_locator_distance").val("<?php echo isset($details_store_locator["store_locator_distance_measurement"]) ? esc_attr($details_store_locator["store_locator_distance_measurement"]) : "kilometers" ?>");
                        jQuery("#ux_ddl_input_field_placeholder_size").val("<?php echo isset($store_locator_input_field_placeholder_style[0]) ? esc_attr($store_locator_input_field_placeholder_style[0]) : "15" ?>");
                        jQuery("#ux_ddl_store_locator_input_field_placeholder_font_family").val("<?php echo isset($details_store_locator["store_locator_input_field_placeholder_font_family"]) ? htmlspecialchars_decode($details_store_locator["store_locator_input_field_placeholder_font_family"]) : "Roboto Condensed" ?>");
                        jQuery("#ux_txt_store_locator_table_font_size").val("<?php echo isset($store_locator_table_style[0]) ? intval($store_locator_table_style[0]) : "15" ?>");
                        jQuery("#ux_ddl_store_locator_table_font_family").val("<?php echo isset($details_store_locator["store_locator_table_text_font_family"]) ? htmlspecialchars_decode($details_store_locator["store_locator_table_text_font_family"]) : "Roboto Condensed" ?>");
                        jQuery("#ux_ddl_store_locator_table_border_style_type").val("<?php echo isset($store_locator_table_display_border_style[1]) ? esc_attr($store_locator_table_display_border_style[1]) : "none" ?>");
                        jQuery("#ux_ddl_default_location").val("<?php echo isset($details_store_locator["store_locator_input_field_show_default_location"]) ? esc_attr($details_store_locator["store_locator_input_field_show_default_location"]) : "enable" ?>");
                        enable_disable_controls_google_maps("#ux_ddl_default_location", "#ux_div_default_location");
                     });
                     jQuery("#ux_frm_store_locator").validate
                             ({
                                submitHandler: function ()
                                {
                                   premium_edition_notification_google_maps_bank();
                                }
                             });
                  <?php
               }
               break;
            case "gmb_map_customization":
               ?>
                  jQuery("#ux_li_layout_settings").addClass("active");
                  jQuery("#ux_li_map_customization").addClass("active");
               <?php
               if (layout_settings_google_map == "1") {
                  ?>
                     jQuery(document).ready(function ()
                     {
                        jQuery("#ux_ddl_map_title_html_tag").val("<?php echo isset($details_map_customization["map_title_html_tag"]) ? esc_attr($details_map_customization["map_title_html_tag"]) : "h1"; ?>");
                        jQuery("#ux_ddl_map_title_alignment").val("<?php echo isset($details_map_customization["map_title_text_alignment"]) ? esc_attr($details_map_customization["map_title_text_alignment"]) : "left"; ?>");
                        jQuery("#ux_ddl_map_title_size").val("<?php echo isset($map_title_size_color[0]) ? esc_attr($map_title_size_color[0]) : "18"; ?>");
                        jQuery("#ux_ddl_map_title_font_family").val("<?php echo isset($details_map_customization["map_title_font_family"]) ? htmlspecialchars_decode($details_map_customization["map_title_font_family"]) : "Roboto Condensed"; ?>");
                        jQuery("#ux_ddl_description_html_tag").val("<?php echo isset($details_map_customization["map_description_html_tag"]) ? esc_attr($details_map_customization["map_description_html_tag"]) : "p"; ?>");
                        jQuery("#ux_ddl_map_description_alignment").val("<?php echo isset($details_map_customization["map_description_text_alignment"]) ? esc_attr($details_map_customization["map_description_text_alignment"]) : "left"; ?>");
                        jQuery("#ux_ddl_map_description_size").val("<?php echo isset($map_description_size_color[0]) ? esc_attr($map_description_size_color[0]) : "15"; ?>");
                        jQuery("#ux_ddl_map_description_font_family").val("<?php echo isset($details_map_customization["map_description_font_family"]) ? htmlspecialchars_decode($details_map_customization["map_description_font_family"]) : "Roboto Condensed"; ?>");
                        jQuery("#ux_ddl_map_draggable").val("<?php echo isset($details_map_customization["map_draggable"]) ? esc_attr($details_map_customization["map_draggable"]) : "enable"; ?>");
                        jQuery("#ux_ddl_map_double_click_zoom").val("<?php echo isset($details_map_customization["map_double_click_zoom"]) ? esc_attr($details_map_customization["map_double_click_zoom"]) : "enable"; ?>");
                        jQuery("#ux_ddl_map_type").val("<?php echo isset($details_map_customization["map_type"]) ? esc_attr($details_map_customization["map_type"]) : "show"; ?>");
                        jQuery("#ux_ddl_mouse_wheel_scrolling").val("<?php echo isset($details_map_customization["mouse_wheel_scrolling"]) ? esc_attr($details_map_customization["mouse_wheel_scrolling"]) : "enable"; ?>");
                        jQuery("#ux_ddl_map_type_control_position").val("<?php echo isset($details_map_customization["map_type_control_position"]) ? esc_attr($details_map_customization["map_type_control_position"]) : "top_left"; ?>");
                        jQuery("#ux_ddl_full_screen_control").val("<?php echo isset($details_map_customization["full_screen_control"]) ? esc_attr($details_map_customization["full_screen_control"]) : "hide"; ?>");
                        jQuery("#ux_ddl_full_screen_control_position").val("<?php echo isset($details_map_customization["full_screen_control_position"]) ? esc_attr($details_map_customization["full_screen_control_position"]) : "top_right"; ?>");
                        jQuery("#ux_ddl_street_view_control").val("<?php echo isset($details_map_customization["street_view_control"]) ? esc_attr($details_map_customization["street_view_control"]) : "hide"; ?>");
                        jQuery("#ux_ddl_rotate_control").val("<?php echo isset($details_map_customization["rotate_control"]) ? esc_attr($details_map_customization["rotate_control"]) : "show"; ?>");
                        jQuery("#ux_ddl_street_view_control_position").val("<?php echo isset($details_map_customization["street_view_control_position"]) ? esc_attr($details_map_customization["street_view_control_position"]) : "right_bottom"; ?>");
                        jQuery("#ux_ddl_scale_control").val("<?php echo isset($details_map_customization["scale_control"]) ? esc_attr($details_map_customization["scale_control"]) : "show"; ?>");
                        jQuery("#ux_ddl_map_zoom_control").val("<?php echo isset($details_map_customization["map_zoom_control"]) ? esc_attr($details_map_customization["map_zoom_control"]) : "hide"; ?>");
                        jQuery("#ux_ddl_map_zoom_control_alignment").val("<?php echo isset($details_map_customization["map_zoom_control_alignment"]) ? esc_attr($details_map_customization["map_zoom_control_alignment"]) : "right_bottom"; ?>");
                        jQuery("#ux_ddl_map_type_control_style").val("<?php echo isset($details_map_customization["map_type_control_style"]) ? esc_attr($details_map_customization["map_type_control_style"]) : "none"; ?>");
                        show_hide_controls_google_maps("#ux_ddl_map_type", "#ux_div_map_type_control");
                        show_hide_controls_google_maps('#ux_ddl_full_screen_control', '#ux_full_screen_control_position');
                        show_hide_controls_google_maps('#ux_ddl_street_view_control', '#ux_street_view_control_position');
                        show_hide_controls_google_maps('#ux_ddl_map_zoom_control', '#ux_map_zoom_control_alignment');
                     });
                     jQuery("#ux_frm_map_customization").validate
                             ({
                                submitHandler: function ()
                                {
                                   overlay_loading_google_maps(<?php echo json_encode($gm_map_customization_message); ?>);
                                   jQuery.post(ajaxurl,
                                           {
                                              data: base64_encode_google_maps_bank(jQuery("#ux_frm_map_customization").serialize()),
                                              param: "google_map_customization_module",
                                              action: "google_maps_backend",
                                              _wp_nonce: "<?php echo $google_map_customization_nonce; ?>"
                                           },
                                           function ()
                                           {
                                              setTimeout(function ()
                                              {
                                                 remove_overlay_google_maps();
                                                 window.location.href = "admin.php?page=gmb_map_customization";
                                              }, 3000);
                                           });
                                }
                             });
                  <?php
               }
               break;
            case "gmb_custom_css":
               ?>
                  jQuery("#ux_li_custom_css").addClass("active");
               <?php
               if (custom_css_google_map == "1") {
                  ?>
                     jQuery("#ux_frm_custom_css").validate
                             ({
                                submitHandler: function ()
                                {
                                   premium_edition_notification_google_maps_bank();
                                }
                             });
                  <?php
               }
               break;
            case "gmb_shortcode":
               ?>
                  jQuery("#ux_li_shortcodes").addClass("active");
               <?php
               if (shortcodes_google_map == "1") {
                  ?>
                     var clipboard = new Clipboard(".icon-custom-docs");
                     clipboard.on("success", function (e)
                     {
                        var shortCutFunction = jQuery("#manage_messages input:checked").val();
                        toastr[shortCutFunction](<?php echo json_encode($gm_copy_to_clipboard) ?>);
                     });
                     clipboard.on("error", function (e)
                     {
                        var shortCutFunction = jQuery("#toastTypeGroup_error input:checked").val();
                        toastr[shortCutFunction](<?php echo json_encode($gm_copied_failed) ?>);
                     });
                     jQuery("#ux_frm_shortcode").validate
                             ({
                                submitHandler: function ()
                                {
                                   var choose_map = jQuery("#ux_ddl_select_map").val();
                                   var map_title = jQuery("#ux_ddl_map_title").val();
                                   var map_description = jQuery("#ux_ddl_map_description").val();
                                   var map_height = jQuery("#ux_txt_map_height").val();
                                   var map_width = jQuery("#ux_txt_map_width").val();
                                   var map_themes = jQuery("#ux_ddl_map_themes").val();
                                   var directions_header = jQuery("#ux_txt_directions_header_title").val();
                                   var display_directions = jQuery("#ux_ddl_display_text_directions").val();
                                   var store_locator_value = jQuery("#ux_txt_store_locator_header_title").val();
                                   var display_type = jQuery("#ux_ddl_display_type").val();
                                   var shortcode = "";
                                   switch (display_type)
                                   {
                                      case "map":
                                         if (jQuery("#ux_ddl_select_map").val() === "")
                                         {
                                            var shortCutFunction = jQuery("#toastTypeGroup_error input:checked").val();
                                            toastr[shortCutFunction](<?php echo json_encode($gm_confirm_choose_map); ?>);
                                            jQuery("#ux_div_generate_shortcode").css("display", "none");
                                         } else
                                         {
                                            jQuery("#ux_div_generate_shortcode").css("display", "block");
                                            shortcode = "[map_bank maps_id=\"" + choose_map + "\" map_title=\"" + map_title + "\" map_description=\"" + map_description + "\" map_height=\"" + map_height + "\" map_width=\"" + map_width + "\" map_themes=\"" + map_themes + "\"]";
                                            jQuery("#ux_txt_shortcodes").html("");
                                            jQuery("#ux_txt_shortcodes").html(shortcode);
                                         }
                                         break;
                                      case "store_locator":
                                         jQuery("#ux_div_generate_shortcode").css("display", "none");
                                         premium_edition_notification_google_maps_bank();
                                         break;
                                      case "directions":
                                         jQuery("#ux_div_generate_shortcode").css("display", "none");
                                         premium_edition_notification_google_maps_bank();
                                         break;
                                   }
                                }
                             });
                  <?php
               }
               break;
            case "gmb_other_settings":
               ?>
                  jQuery("#ux_li_other_settings").addClass("active");
               <?php
               if (other_settings_google_map == "1") {
                  ?>
                     jQuery(document).ready(function ()
                     {
                        jQuery("#ux_ddl_remove_tables").val("<?php echo isset($details_other_settings["remove_tables_at_uninstall"]) ? esc_attr($details_other_settings["remove_tables_at_uninstall"]) : "disable"; ?>");
                        jQuery("#ux_ddl_map_language").val("<?php echo isset($details_other_settings["other_settings_map_language"]) ? htmlspecialchars_decode($details_other_settings["other_settings_map_language"]) : "en"; ?>");
                        jQuery("#ux_ddl_fetching_method").val("<?php echo isset($details_other_settings["ip_address_fetching_method"]) ? esc_attr($details_other_settings["ip_address_fetching_method"]) : "" ?>");
                     });
                     jQuery("#ux_frm_other_settings").validate
                             ({
                                rules:
                                        {
                                           ux_txt_other_api_key:
                                                   {
                                                      required: true
                                                   }
                                        },
                                errorPlacement: function ()
                                {
                                },
                                highlight: function (element)
                                {
                                   jQuery(element).closest(".form-group").removeClass("has-success").addClass("has-error");
                                },
                                success: function (label, element)
                                {
                                   jQuery(element).closest(".form-group").removeClass("has-error").addClass("has-success");
                                },
                                submitHandler: function ()
                                {
                                   overlay_loading_google_maps(<?php echo json_encode($gm_other_settings_message); ?>);
                                   jQuery.post(ajaxurl,
                                           {
                                              data: base64_encode_google_maps_bank(jQuery("#ux_frm_other_settings").serialize()),
                                              param: "gmb_other_settings_module",
                                              action: "google_maps_backend",
                                              _wp_nonce: "<?php echo $other_settings_nonce; ?>"
                                           },
                                           function ()
                                           {
                                              setTimeout(function ()
                                              {
                                                 remove_overlay_google_maps();
                                                 window.location.href = "admin.php?page=gmb_other_settings";
                                              }, 3000);
                                           });
                                }
                             });
                  <?php
               }
               break;
            case "gmb_roles_and_capabilities":
               ?>
                  jQuery("#ux_li_roles_and_capabilities").addClass("active");
               <?php
               if (roles_and_capabilities_google_map == "1") {
                  ?>
                     function show_roles_capabilities_google_maps(id, div_id)
                     {
                        if (jQuery(id).prop("checked"))
                        {
                           jQuery("#" + div_id).css("display", "block");
                        } else
                        {
                           jQuery("#" + div_id).css("display", "none");
                        }
                     }
                     function full_control_function_google_maps(id, div_id)
                     {
                        var checkbox_id = jQuery(id).prop("checked");
                        jQuery("#" + div_id + " input[type=checkbox]").each(function ()
                        {
                           if (checkbox_id)
                           {
                              jQuery(this).attr("checked", "checked");
                              if (jQuery(id).attr("id") !== jQuery(this).attr("id"))
                              {
                                 jQuery(this).attr("disabled", "disabled");
                              }
                           } else
                           {
                              if (jQuery(id).attr("id") !== jQuery(this).attr("id"))
                              {
                                 jQuery(this).removeAttr("disabled");
                                 jQuery("#ux_chk_other_capabilities_manage_options").attr("disabled", "disabled");
                                 jQuery("#ux_chk_other_capabilities_read").attr("disabled", "disabled");
                              }
                           }
                        });
                     }
                     jQuery(document).ready(function ()
                     {
                        jQuery("#ux_ddl_top_bar").val("<?php echo isset($details_roles_capabilities["google_map_top_bar_menu"]) ? esc_attr($details_roles_capabilities["google_map_top_bar_menu"]) : "enable"; ?>");
                        show_roles_capabilities_google_maps("#ux_chk_author", "ux_div_author_roles");
                        full_control_function_google_maps("#ux_chk_full_control_author", "ux_div_author_roles");
                        show_roles_capabilities_google_maps("#ux_chk_editor", "ux_div_editor_roles");
                        full_control_function_google_maps("#ux_chk_full_control_editor", "ux_div_editor_roles");
                        show_roles_capabilities_google_maps("#ux_chk_contributor", "ux_div_contributor_roles");
                        full_control_function_google_maps("#ux_chk_full_control_contributor", "ux_div_contributor_roles");
                        show_roles_capabilities_google_maps("#ux_chk_subscriber", "ux_div_subscriber_roles");
                        full_control_function_google_maps("#ux_chk_full_control_subscriber", "ux_div_subscriber_roles");
                        show_roles_capabilities_google_maps("#ux_chk_other", "ux_div_other_roles");
                        full_control_function_google_maps("#ux_chk_full_control_other", "ux_div_other_roles");
                        full_control_function_google_maps("#ux_chk_full_control_other_roles", "ux_div_other_roles_capabilities");
                     });
                     jQuery("#ux_frm_roles_and_capabilities").validate
                             ({
                                submitHandler: function ()
                                {
                                   premium_edition_notification_google_maps_bank();
                                }
                             });
                  <?php
               }
               break;
            case "gmb_feature_requests":
               ?>
                  jQuery("#ux_li_feature_requests").addClass("active");
                  var gmb_feature_request_array = [];
                  var url = "<?php echo tech_banker_url . "/feedbacks.php"; ?>";
                  var domain_url = "<?php echo site_url(); ?>";
                  jQuery("#ux_frm_feature_request").validate
                          ({
                             rules:
                                     {
                                        ux_txt_your_name:
                                                {
                                                   required: true
                                                },
                                        ux_txt_email_address:
                                                {
                                                   required: true,
                                                   email: true
                                                },
                                        ux_txtarea_feature_request:
                                                {
                                                   required: true
                                                }
                                     },
                             errorPlacement: function ()
                             {
                             },
                             highlight: function (element)
                             {
                                jQuery(element).closest(".form-group").removeClass("has-success").addClass("has-error");
                             },
                             success: function (label, element)
                             {
                                jQuery(element).closest(".form-group").removeClass("has-error").addClass("has-success");
                             },
                             submitHandler: function ()
                             {
                                gmb_feature_request_array.push(jQuery("#ux_txt_your_name").val(), jQuery("#ux_txt_email_address").val(), domain_url, jQuery("#ux_txtarea_feature_request").val());
                                overlay_loading_google_maps(<?php echo json_encode($gm_feature_request_message); ?>);
                                jQuery.post(url,
                                        {
                                           data: JSON.stringify(gmb_feature_request_array),
                                           param: "google_maps_feature_request"
                                        },
                                        function ()
                                        {
                                           setTimeout(function ()
                                           {
                                              remove_overlay_google_maps();
                                              window.location.href = "admin.php?page=gmb_feature_requests";
                                           }, 3000);
                                        });
                             }
                          });
               <?php
               break;
            case "gmb_system_information":
               ?>
                  jQuery("#ux_li_system_information").addClass("active");
               <?php
               if (system_information_google_map == "1") {
                  ?>
                     jQuery.getSystemReport = function (strDefault, stringCount, string, location)
                     {
                        var o = strDefault.toString();
                        if (!string)
                        {
                           string = "0";
                        }
                        while (o.length < stringCount)
                        {
                           if (location === "undefined")
                           {
                              o = string + o;
                           } else
                           {
                              o = o + string;
                           }
                        }
                        return o;
                     };
                     jQuery(".system-report").click(function ()
                     {
                        var report = "";
                        jQuery(".custom-form-body").each(function ()
                        {
                           jQuery("h3.form-section", jQuery(this)).each(function ()
                           {
                              report = report + "\n### " + jQuery.trim(jQuery(this).text()) + " ###\n\n";
                           });
                           jQuery("tbody > tr", jQuery(this)).each(function ()
                           {
                              var the_name = jQuery.getSystemReport(jQuery.trim(jQuery(this).find("strong").text()), 25, " ");
                              var the_value = jQuery.trim(jQuery(this).find("span").text());
                              var value_array = the_value.split(", ");
                              if (value_array.length > 1)
                              {
                                 var temp_line = "";
                                 jQuery.each(value_array, function (key, line)
                                 {
                                    var tab = (key === 0) ? 0 : 25;
                                    temp_line = temp_line + jQuery.getSystemReport("", tab, " ", "f") + line + "\n";
                                 });
                                 the_value = temp_line;
                              }
                              report = report + "" + the_name + the_value + "\n";
                           });
                        });
                        try
                        {
                           jQuery("#ux_system_information").slideDown();
                           jQuery("#ux_system_information textarea").val(report).focus().select();
                           return false;
                        } catch (e)
                        {
                           console.log(e);
                        }
                        return false;
                     });
                     jQuery("#ux_btn_system_information").click(function ()
                     {
                        if (jQuery("#ux_btn_system_information").text() === "Close System Information!")
                        {
                           jQuery("#ux_system_information").slideUp();
                           jQuery("#ux_btn_system_information").html("Get System Information!");
                        } else
                        {
                           jQuery("#ux_btn_system_information").html("Close System Information!");
                           jQuery("#ux_btn_system_information").removeClass("system-information");
                           jQuery("#ux_btn_system_information").addClass("close-information");
                        }
                     });
                     load_sidebar_content_google_maps();
                  <?php
               }
               break;
            case "gm_upgrade":
               ?>
                  jQuery("#ux_li_upgrade").addClass("active");
               <?php
               break;
         }
      }
      ?>
      </script>
      <?php
   }
}