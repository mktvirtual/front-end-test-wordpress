<?php
/**
 * This Template is used for adding overlays.
 *
 * @author  Tech Banker
 * @package google-maps-bank/views/overlays
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
   } else if (overlays_google_map == "1") {
      $google_maps_add_marker_nonce = wp_create_nonce("google_maps_add_marker_nonce");
      $google_maps_polygon_nonce = wp_create_nonce("google_maps_polygon_nonce");
      $google_maps_add_polyline_nonce = wp_create_nonce("google_maps_add_polyline_nonce");
      $google_map_add_circle_nonce = wp_create_nonce("google_map_add_circle_nonce");
      $marker_fill_color_opacity = isset($serialize_overlay_edit_data["marker_fill_color_opacity"]) ? explode(",", esc_attr($serialize_overlay_edit_data["marker_fill_color_opacity"])) : "";
      $marker_stroke_color_opacity = isset($serialize_overlay_edit_data["marker_stroke_color_opacity"]) ? explode(",", esc_attr($serialize_overlay_edit_data["marker_fill_color_opacity"])) : "";
      $rectangle_color_and_opacity = explode(",", isset($serialize_rectangle_overlay_edit_data["stroke_color_and_opacity"]) ? esc_attr($serialize_rectangle_overlay_edit_data["stroke_color_and_opacity"]) : "#000000,75");
      $rectangle_fill_color_and_opacity = explode(",", isset($serialize_rectangle_overlay_edit_data["fill_color_and_opacity"]) ? esc_attr($serialize_rectangle_overlay_edit_data["fill_color_and_opacity"]) : "#000000,75");
      $mapid = isset($_REQUEST["google_map_id"]) ? "&google_map_id=" . $_REQUEST["google_map_id"] : "";
      $polygon_stroke_color_style = isset($serialize_overlay_polygon_edit_data["polygon_stroke_color_style"]) ? explode(",", esc_attr($serialize_overlay_polygon_edit_data["polygon_stroke_color_style"])) : "";
      $polygon_fill_color_style = isset($serialize_overlay_polygon_edit_data["polygon_fill_color_style"]) ? explode(",", esc_attr($serialize_overlay_polygon_edit_data["polygon_fill_color_style"])) : "";
      $polyline_stroke_color = isset($polyline_overlays_edit_data["polyline_stroke_color_opacity"]) ? explode(",", esc_attr($polyline_overlays_edit_data["polyline_stroke_color_opacity"])) : "";
      $gmb_circle_stroke_color = isset($serialize_circle_overlay_edit_data["circle_stroke_color"]) ? explode(",", esc_attr($serialize_circle_overlay_edit_data["circle_stroke_color"])) : "";
      $gmb_circle_fill_color = isset($serialize_circle_overlay_edit_data["circle_fill_color"]) ? explode(",", esc_attr($serialize_circle_overlay_edit_data["circle_fill_color"])) : "";
      ?>
      <div class="page-bar">
         <ul class="page-breadcrumb">
            <li>
               <i class="icon-custom-home"></i>
               <a href="admin.php?page=gmb_google_maps">
                  <?php echo $google_maps_bank; ?>
               </a>
               <span>></span>
            </li>
            <li>
               <a href="admin.php?page=gmb_manage_overlays">
                  <?php echo $gm_overlays; ?>
               </a>
               <span>></span>
            </li>
            <li>
               <span>
                  <?php echo isset($_REQUEST["edit"]) ? $gm_update_overlays : $gm_add_overlays; ?>
               </span>
            </li>
         </ul>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="portlet box vivid-green">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="icon-custom-basket"></i>
                     <?php echo isset($_REQUEST["edit"]) ? $gm_update_overlays : $gm_add_overlays; ?>
                  </div>
                  <a href="http://beta.tech-banker.com/products/google-maps-bank/" target="_blank" class="premium-editions"><?php echo $mb_upgrade_to ?></a>
               </div>
               <div class="portlet-body form">
                  <form id="ux_frm_add_overlays">
                     <div class="form-body">
                        <?php
                        if ($gm_message_translate_help != "") {
                           ?>
                           <div class="note note-danger">
                              <h4 class="block">
                                 <?php echo $gm_important_disclaimer; ?>
                              </h4>
                              <strong><?php echo $gm_message_translate_help; ?> <a href="javascript:void(0);" data-popup-open="ux_open_popup_translator" class="custom_links" onclick="show_pop_up_google_map();"><?php echo $gm_message_translate_here; ?></a></strong>
                           </div>
                           <?php
                        }
                        ?>
                        <div style="max-height:350px; display:none; margin-bottom: 4%;" id="ux_map_canvas" >
                           <div id="ux_div_map_canvas" class="map_canvas"></div>
                           <div class="line-separator"></div>
                        </div>
                        <div id="choose_map_hide">
                           <div class="form-group">
                              <label class="control-label">
                                 <?php echo $gm_choose_map; ?> :
                                 <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_choose_map_tooltips; ?>" data-placement="right"></i>
                                 <span class="required" aria-required="true">*</span>
                              </label>
                              <select name="ux_ddl_choose_map" id="ux_ddl_choose_map" class="form-control" onchange="get_url_google_maps('#ux_ddl_choose_map', 'marker', 'gmb_add_overlays')">
                                 <option value=""><?php echo $gm_choose_map; ?></option>
                                 <?php
                                 foreach ($choose_map_data as $key => $value) {
                                    ?>
                                    <option value="<?php echo intval($value["meta_id"]); ?>"><?php echo esc_attr($value["map_title"]); ?></option>
                                    <?php
                                 }
                                 ?>
                              </select>
                           </div>
                        </div>
                        <div id="ux_div_ddl_choose_map" style="display:none;">
                           <div id="ux_div_overlay_hide">
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_overlays_type; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_overlays_type_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*</span>
                                 </label>
                                 <div class="row" style="margin-top:10px;">
                                    <div class="col-md-2">
                                       <input type="radio" name="ux_chk_overlay_type" id="ux_chk_overlay_type_marker" value="marker" onclick="get_url_google_maps('<?php echo $mapid; ?>', 'marker', 'gmb_add_overlays');" checked="checked">
                                       <?php echo $gm_marker; ?>
                                    </div>
                                    <div class="col-md-2">
                                       <input type="radio" name="ux_chk_overlay_type" id="ux_chk_overlay_type_polygon" value="polygon"  onclick="get_url_google_maps('<?php echo $mapid; ?>', 'polygon', 'gmb_add_overlays');">
                                       <?php echo $gm_polygon; ?>
                                    </div>
                                    <div class="col-md-2">
                                       <input type="radio" name="ux_chk_overlay_type" id="ux_chk_overlay_type_polyline" value="polyline" onclick="get_url_google_maps('<?php echo $mapid; ?>', 'polyline', 'gmb_add_overlays');">
                                       <?php echo $gm_polyline; ?>
                                    </div>
                                    <div class="col-md-2">
                                       <input type="radio" name="ux_chk_overlay_type" id="ux_chk_overlay_type_circle" value="circle" onclick="get_url_google_maps('<?php echo $mapid; ?>', 'circle', 'gmb_add_overlays');">
                                       <?php echo $gm_circle; ?>
                                    </div>
                                    <div class="col-md-2">
                                       <input type="radio" name="ux_chk_overlay_type" id="ux_chk_overlay_type_rectangle" value="rectangle" onclick="get_url_google_maps('<?php echo $mapid; ?>', 'rectangle', 'gmb_add_overlays');">
                                       <?php echo $gm_rectangle; ?>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div id="ux_div_marker_settings">
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_marker_title; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_marker_title_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*</span>
                                 </label>
                                 <input type="text" class="form-control" name="ux_txt_marker_title" onblur="initialize_google_map_setttings('marker');" id="ux_txt_marker_title" value="<?php echo isset($serialize_overlay_edit_data['marker_title']) ? esc_attr($serialize_overlay_edit_data['marker_title']) : ''; ?>" placeholder="<?php echo $gm_marker_title_placeholder; ?>">
                              </div>
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_marker_description; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_marker_description_tooltips; ?>" data-placement="right"></i>
                                 </label>
                                 <textarea class="form-control" name="ux_txt_marker_desc" id="ux_txt_marker_desc" onblur="initialize_google_map_setttings('marker');" rows="4" placeholder="<?php echo $gm_marker_description_placeholder; ?>"><?php echo isset($serialize_overlay_edit_data['marker_description']) ? esc_html($serialize_overlay_edit_data['marker_description']) : ''; ?></textarea>
                              </div>
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_marker_type; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_marker_type_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*</span>
                                 </label>
                                 <div class="row" style="margin-top:10px;">
                                    <div class="col-md-3">
                                       <input type="radio" name="ux_chk_formatted_address" class="ux_chk_formatted_address" id="ux_chk_formatted_address" value="formatted_address" checked="checked" onclick="choose_address_type_google_maps('formatted_address', '#ux_div_map_address', '#ux_div_latitude_longitude');" <?php echo isset($serialize_overlay_edit_data["marker_type"]) && esc_attr($serialize_overlay_edit_data["marker_type"]) == "formatted_address" ? 'checked="checked"' : ""; ?>>
                                       <?php echo $gm_formatted_address; ?>
                                    </div>
                                    <div class="col-md-3">
                                       <input type="radio" name="ux_chk_formatted_address" class="ux_chk_formatted_address" id="ux_chk_by_latitude_longitude" value="latitude_longitude" onclick="choose_address_type_google_maps('latitude_longitude', '#ux_div_map_address', '#ux_div_latitude_longitude');" <?php echo isset($serialize_overlay_edit_data["marker_type"]) && esc_attr($serialize_overlay_edit_data["marker_type"]) == "latitude_longitude" ? 'checked="checked"' : ""; ?>>
                                       <?php echo $gm_by_latitude_longitude; ?>
                                    </div>
                                 </div>
                              </div>
                              <div id="ux_div_map_address">
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_add_map_address; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_add_map_address_tooltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="ux_txt_marker_address" id="ux_txt_marker_address" value="<?php echo (isset($serialize_overlay_edit_data['marker_address']) && esc_html($serialize_overlay_edit_data['marker_address']) != "") ? esc_html($serialize_overlay_edit_data['marker_address']) : (isset($serialized_map_data["formatted_address"]) && esc_html($serialized_map_data["formatted_address"]) ? esc_html($serialized_map_data["formatted_address"]) : ""); ?>" placeholder="<?php echo $gm_add_map_address_placeholder; ?>">
                                 </div>
                              </div>
                              <div id="ux_div_latitude_longitude" style="display:none;">
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_map_latitude; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_add_map_latitude_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">*</span>
                                          </label>
                                          <input type="text" class="form-control ux_txt_latitude" name="ux_txt_marker_latitude" id="ux_txt_marker_latitude" value="<?php echo (isset($serialize_overlay_edit_data["marker_latitude"]) && floatval($serialize_overlay_edit_data["marker_latitude"]) != 0) ? floatval($serialize_overlay_edit_data["marker_latitude"]) : (isset($serialized_map_data["map_latitude"]) && floatval($serialized_map_data["map_latitude"]) ? floatval($serialized_map_data["map_latitude"]) : ""); ?>" placeholder="<?php echo $gm_add_map_latitude_placeholder; ?>" onblur="geocode_latitude_longitude_google_maps('marker');">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_map_longitude; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_add_map_longitude_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">*</span>
                                          </label>
                                          <input type="text" class="form-control ux_txt_longitude" name="ux_txt_marker_longitude" id="ux_txt_marker_longitude" value="<?php echo (isset($serialize_overlay_edit_data["marker_longitude"]) && floatval($serialize_overlay_edit_data["marker_longitude"]) != 0) ? floatval($serialize_overlay_edit_data["marker_longitude"]) : (isset($serialized_map_data["map_longitude"]) && floatval($serialized_map_data["map_longitude"]) ? floatval($serialized_map_data["map_longitude"]) : ""); ?>" placeholder="<?php echo $gm_add_map_longitude_placeholder; ?>" onblur="geocode_latitude_longitude_google_maps('marker');">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_marker_icon; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_marker_icon_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*</span>
                                 </label>
                                 <select name="ux_ddl_marker_icon" id="ux_ddl_marker_icon" class="form-control" onchange="google_maps_upload_marker_icon('#ux_ddl_marker_icon');initialize_google_map_setttings('marker');">
                                    <option value="default_icon"><?php echo $gm_default_icon; ?></option>
                                    <option value="choose_icon"><?php echo $gm_choose_icon; ?></option>
                                    <option value="upload"><?php echo $gm_upload_icon; ?></option>
                                 </select>
                              </div>
                              <div id="ux_div_marker_icon_ablity" style="display:none;">
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_marker_images; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_marker_img_upload_tooltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">*</span>
                                    </label>
                                    <div class="input-icon right">
                                       <input type="text" class="form-control custom-input-large input-inline" readonly="true" name="ux_txt_marker_icon_path" id="ux_txt_marker_icon_path" placeholder="<?php echo $gm_marker_upload_icon_placeholder; ?>" value="<?php echo isset($serialize_overlay_edit_data['marker_icon_upload']) ? esc_attr($serialize_overlay_edit_data['marker_icon_upload']) : ''; ?>">
                                       <input type="button" class="btn vivid-green custom-top" name="ux_upload_marker_icon" id="ux_upload_marker_icon" onclick="google_maps_upload_image('ux_txt_marker_icon_path');" value="<?php echo $gm_upload; ?>">
                                    </div>
                                 </div>
                              </div>
                              <p id="wp_media_upload_error" class="wp-media-error-message"><?php echo $gm_media_error_settings_message; ?></p>
                              <div id="ux_div_marker_icon_choose" style="display:none;">
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_add_marker_category; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_add_marker_category_tooltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">*</span>
                                    </label>
                                    <div class="layout-controls-location custom-layout-controls-map-location">
                                       <select class="form-control" name="ux_ddl_marker_category" id="ux_ddl_marker_category" onchange="marker_change_category('#ux_ddl_marker_category');">
                                          <option value="0"><?php _e("Select Marker Category", "google-maps-bank"); ?></option>
                                          <optgroup label="Culture & Entertainment">
                                             <option value="1"><?php _e("Culture", "google-maps-bank"); ?></option>
                                             <option value="2"><?php _e("Entertainment", "google-maps-bank"); ?></option>
                                          </optgroup>
                                          <optgroup label="Events">
                                             <option value="3"><?php _e("Crime", "google-maps-bank"); ?></option>
                                             <option value="4"><?php _e("Natural Disasters", "google-maps-bank"); ?></option>
                                          </optgroup>
                                          <optgroup label="Health And Education">
                                             <option value="5"><?php _e("Education", "google-maps-bank"); ?></option>
                                             <option value="6"><?php _e("Health", "google-maps-bank"); ?></option>
                                          </optgroup>
                                          <optgroup label="Industry">
                                             <option value="7"><?php _e("Electric Power", "google-maps-bank"); ?></option>
                                             <option value="8"><?php _e("Military", "google-maps-bank"); ?></option>
                                          </optgroup>
                                          <optgroup label="Miscellaneous">
                                             <option value="9"><?php _e("Miscellaneous", "google-maps-bank"); ?></option>
                                             <option value="10"><?php _e("Media", "google-maps-bank"); ?></option>
                                             <option value="11"><?php _e("Days", "google-maps-bank"); ?></option>
                                             <option value="12"><?php _e("Numbers", "google-maps-bank"); ?></option>
                                             <option value="13"><?php _e("Letters", "google-maps-bank"); ?></option>
                                             <option value="14"><?php _e("Special Characters", "google-maps-bank"); ?></option>
                                          </optgroup>
                                          <optgroup label="Nature">
                                             <option value="15"><?php _e("Agriculture", "google-maps-bank"); ?></option>
                                             <option value="16"><?php _e("Animals", "google-maps-bank"); ?></option>
                                             <option value="17"><?php _e("Natural Marvels", "google-maps-bank"); ?></option>
                                             <option value="18"><?php _e("Weather", "google-maps-bank"); ?></option>
                                          </optgroup>
                                          <optgroup label="Offices">
                                             <option value="19"><?php _e("City Services", "google-maps-bank"); ?></option>
                                             <option value="20"><?php _e("Interior", "google-maps-bank"); ?></option>
                                             <option value="21"><?php _e("Real Estate", "google-maps-bank"); ?></option>
                                          </optgroup>
                                          <optgroup label="People">
                                             <option value="22"><?php _e("Kids", "google-maps-bank"); ?></option>
                                             <option value="23"><?php _e("People", "google-maps-bank"); ?></option>
                                             <option value="24"><?php _e("Home", "google-maps-bank"); ?></option>
                                          </optgroup>
                                          <optgroup label="Restaurants & Hotels">
                                             <option value="25"><?php _e("Bars", "google-maps-bank"); ?></option>
                                             <option value="26"><?php _e("Hotels", "google-maps-bank"); ?></option>
                                             <option value="27"><?php _e("Restaurants", "google-maps-bank"); ?></option>
                                             <option value="28"><?php _e("Takeaway", "google-maps-bank"); ?></option>
                                          </optgroup>
                                          <optgroup label="Sports">
                                             <option value="29"><?php _e("Sports", "google-maps-bank"); ?></option>
                                          </optgroup>
                                          <optgroup label="Stores">
                                             <option value="30"><?php _e("Apparel", "google-maps-bank"); ?></option>
                                             <option value="31"><?php _e("Brands Chains", "google-maps-bank"); ?></option>
                                             <option value="32"><?php _e("Computer Electronics", "google-maps-bank"); ?></option>
                                             <option value="33"><?php _e("Food Drinks", "google-maps-bank"); ?></option>
                                             <option value="34"><?php _e("General Merchandise", "google-maps-bank"); ?></option>
                                          </optgroup>
                                          <optgroup label="Transportation">
                                             <option value="35"><?php _e("Aerial Transportation", "google-maps-bank"); ?></option>
                                             <option value="36"><?php _e("Directions", "google-maps-bank"); ?></option>
                                             <option value="37"><?php _e("Other Transportation", "google-maps-bank"); ?></option>
                                             <option value="38"><?php _e("Road Signs", "google-maps-bank"); ?></option>
                                             <option value="39"><?php _e("Road Transportation", "google-maps-bank"); ?></option>
                                          </optgroup>
                                          <optgroup label="Tourism">
                                             <option value="40"><?php _e("Religion", "google-maps-bank"); ?></option>
                                             <option value="41"><?php _e("Tourism", "google-maps-bank"); ?></option>
                                          </optgroup>
                                       </select>
                                    </div>
                                 </div>
                                 <div id="ux_div_show_map_icons_ability" style="display:none;">
                                    <div class="form-group">
                                       <?php
                                       if (file_exists(GOOGLE_MAP_DIR_PATH . "/includes/map-icons.php")) {
                                          include_once GOOGLE_MAP_DIR_PATH . "/includes/map-icons.php";
                                       }
                                       ?>
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="control-label">
                                          <?php echo $gm_marker_animation; ?> :
                                          <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_marker_animation_tooltips; ?>" data-placement="right"></i>
                                          <span class="required" aria-required="true">*</span>
                                       </label>
                                       <select name="ux_ddl_marker_animation" id="ux_ddl_marker_animation" class="form-control" onchange="initialize_google_map_setttings('marker');">
                                          <option value="none"><?php echo $gm_none; ?></option>
                                          <option value="bounce"><?php echo $gm_bounce; ?></option>
                                          <option value="drop"><?php echo $gm_drop; ?></option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="control-label">
                                          <?php echo $gm_info_window; ?> :
                                          <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_info_window_tooltips; ?>" data-placement="right"></i>
                                          <span class="required" aria-required="true">*</span>
                                       </label>
                                       <select name="ux_ddl_info_window" id="ux_ddl_info_window" class="form-control" onchange='google_maps_info_window("#ux_ddl_info_window", "#ux_div_info_window_image", "#wp_media_upload_error_info");initialize_google_map_setttings("marker");'>
                                          <option value="enable"><?php echo $gm_enable; ?></option>
                                          <option value="disable"><?php echo $gm_disable; ?></option>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div id="ux_div_info_window_image" style="display:none;">
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_info_window_images; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_info_window_images_tooltips; ?>" data-placement="right"></i>
                                    </label>
                                    <div class="input-icon right">
                                       <input type="text" class="form-control custom-input-middle input-inline" readonly="true" name="ux_txt_image_upload_path" id="ux_txt_image_upload_path" placeholder="<?php echo $gm_info_window_images_upload_placeholder; ?>" value="<?php echo isset($serialize_overlay_edit_data["marker_info_window_upload_path"]) ? esc_attr($serialize_overlay_edit_data["marker_info_window_upload_path"]) : ""; ?>">
                                       <input type="button" class="btn vivid-green custom-top" name="ux_upload_info_image" id="ux_upload_info_image" onclick="google_maps_upload_image('ux_txt_image_upload_path');" value="<?php echo $gm_upload; ?>">
                                       <input type="button" class="btn vivid-green custom-top" name="ux_clear_info_image" id="ux_clear_info_image" onclick='google_maps_clear_info_window_image("#ux_txt_image_upload_path");' value="<?php echo $gm_clear; ?>">
                                    </div>
                                 </div>
                              </div>
                              <p id="wp_media_upload_error_info" class="wp-media-error-message"><?php echo $gm_media_error_settings_message; ?></p>
                              <div class="line-separator"></div>
                              <div class="form-actions">
                                 <div class="pull-right">
                                    <a onclick="google_maps_cancel_maps_overlay_settings('admin.php?page=gmb_add_overlays');" class="btn vivid-green" name="ux_btn_cancel" id="ux_btn_cancel"><?php echo $gm_cancel_button; ?></a>
                                    <input type="submit" name="ux_btn_add_marker" class="btn vivid-green" id="ux_btn_add_marker" value="<?php echo isset($_REQUEST["edit"]) ? $gm_update_marker : $gm_add_marker; ?>">
                                 </div>
                              </div>
                           </div>
                           <div id="ux_div_polygon_settings" style="display:none">
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_polygon_title; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_polygon_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*</span>
                                 </label>
                                 <input type="text" class="form-control" name="ux_txt_polygon_title" id="ux_txt_polygon_title" value="<?php echo isset($serialize_overlay_polygon_edit_data['polygon_title']) ? esc_attr($serialize_overlay_polygon_edit_data['polygon_title']) : ''; ?>" placeholder="<?php echo $gm_polygon_placeholder; ?>";>
                              </div>
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_polygon_description; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_polygon_description_tooltips; ?>" data-placement="right"></i>
                                 </label>
                                 <textarea class="form-control" name="ux_txt_polygon_desc" id="ux_txt_polygon_desc" rows="4"  placeholder="<?php echo $gm_polygon_description_placeholder; ?>"><?php echo isset($serialize_overlay_polygon_edit_data['polygon_description']) ? esc_html($serialize_overlay_polygon_edit_data['polygon_description']) : ''; ?></textarea>
                              </div>
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_stroke_weight; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_polygon_stroke_width_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*</span>
                                 </label>
                                 <select name="ux_ddl_polygon_weight" id="ux_ddl_polygon_weight" class="form-control" onchange="initialize_google_map_setttings('polygon');">
                                    <?php
                                    for ($stroke_weight = 0; $stroke_weight <= 50; $stroke_weight++) {
                                       ?>
                                       <option value="<?php echo $stroke_weight; ?>"><?php echo $stroke_weight; ?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="control-label">
                                          <?php echo $gm_stroke_color; ?> :
                                          <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_polygon_stroke_color_tooltips; ?>" data-placement="right"></i>
                                          <span class="required" aria-required="true">*</span>
                                       </label>
                                       <div class="input-icon right">
                                          <input type="text" class="form-control custom-input-medium" name="ux_txt_polygon_stroke_color_style[]" id="ux_txt_polygon_stroke_color" onblur="default_value_google_maps('#ux_txt_polygon_stroke_color', '#000000'); initialize_google_map_setttings('polygon');" onfocus="google_map_color_picker('#ux_txt_polygon_stroke_color', this.value)" value="<?php echo isset($polygon_stroke_color_style[0]) ? esc_attr($polygon_stroke_color_style[0]) : '#000000'; ?>" placeholder="<?php echo $gm_stroke_color_placeholder; ?>">
                                          <input type="text" class="form-control custom-input-medium" name="ux_txt_polygon_stroke_color_style[]" id="ux_txt_polygon_stroke_opacity" maxlength="3"  onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_polygon_stroke_opacity', '75', 'width'); initialize_google_map_setttings('polygon');" onkeypress="only_digits_google_maps(event);" value="<?php echo isset($polygon_stroke_color_style[1]) ? intval($polygon_stroke_color_style[1]) : 75; ?>" placeholder="<?php echo $gm_stroke_opacity_placeholder; ?>">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="control-label">
                                          <?php echo $gm_fill_color; ?> :
                                          <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_polygon_fill_color_tooltips; ?>" data-placement="right"></i>
                                          <span class="required" aria-required="true">*</span>
                                       </label>
                                       <div class="input-icon right">
                                          <input type="text" class="form-control custom-input-medium" name="ux_txt_polygon_fill_color_style[]" id="ux_txt_polygon_fill_color" onblur="default_value_google_maps('#ux_txt_polygon_fill_color', '#000000'); initialize_google_map_setttings('polygon');" onfocus="google_map_color_picker('#ux_txt_polygon_fill_color', this.value)" value="<?php echo isset($polygon_fill_color_style[0]) ? esc_attr($polygon_fill_color_style[0]) : '#000000'; ?>" placeholder="<?php echo $gm_fill_color_placeholder; ?>">
                                          <input type="text" class="form-control custom-input-medium" name="ux_txt_polygon_fill_color_style[]" id="ux_txt_polygon_fill_color_opacity" maxlength="3"  onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_polygon_fill_color_opacity', '75', 'width'); initialize_google_map_setttings('polygon');" onkeypress="only_digits_google_maps(event);" value="<?php echo isset($polygon_fill_color_style[1]) ? intval($polygon_fill_color_style[1]) : 75; ?>" placeholder="<?php echo $gm_stroke_opacity_placeholder; ?>">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group" style='margin-top:15px;'>
                                 <label class="control-label" style="magin-top:15px;">
                                    <?php echo $gm_coordinates; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_polygon_coordinate_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*</span>
                                 </label>
                                 <textarea class="form-control" name="ux_txt_polygon_coordinate" id="ux_txt_polygon_coordinate" rows="4" readonly="true" placeholder="<?php echo $gm_coordinate_placeholder; ?>"><?php echo isset($serialize_overlay_polygon_edit_data['polygon_coordinates']) ? esc_attr($serialize_overlay_polygon_edit_data['polygon_coordinates']) : ''; ?></textarea>
                              </div>
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_info_window; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_info_window_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                 </label>
                                 <select name="ux_ddl_polygon_info_window" id="ux_ddl_polygon_info_window" class="form-control" onchange='google_maps_info_window("#ux_ddl_polygon_info_window", "#ux_div_polygon_info_window_image", "#wp_media_upload_polygon_error_info");'>
                                    <option value="enable"><?php echo $gm_enable; ?></option>
                                    <option value="disable"><?php echo $gm_disable; ?></option>
                                 </select>
                              </div>
                              <div id="ux_div_polygon_info_window_image" style="display:none;">
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_info_window_images; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_info_window_images_tooltips; ?>" data-placement="right"></i>
                                    </label>
                                    <span span class="required" aria-required="true"> <?php echo "( " . $gm_premium_edition_label . " )" ?> </span>
                                    <div class="input-icon right">
                                       <input type="text" class="form-control custom-input-middle input-inline" readonly="true" name="ux_txt_image_upload_polygon_path" id="ux_txt_image_upload_polygon_path" placeholder="<?php echo $gm_info_window_images_upload_placeholder; ?>" value='<?php echo isset($serialize_overlay_polygon_edit_data["polygon_image_upload_path"]) ? esc_attr($serialize_overlay_polygon_edit_data["polygon_image_upload_path"]) : ""; ?>'>
                                       <input type="button" class="btn vivid-green custom-top" name="ux_upload_info_image" id="ux_upload_info_image" onclick="premium_edition_notification_google_maps_bank();" value="<?php echo $gm_upload; ?>">
                                       <input type="button" class="btn vivid-green custom-top" name="ux_clear_info_image" id="ux_clear_info_image"  onclick="premium_edition_notification_google_maps_bank();" value="<?php echo $gm_clear; ?>">
                                    </div>
                                 </div>
                              </div>
                              <p id="wp_media_upload_polygon_error_info" class="wp-media-error-message"><?php echo $gm_media_error_settings_message; ?></p>
                              <div class="line-separator"></div>
                              <div class="form-actions">
                                 <div class="pull-right">
                                    <a onclick="google_maps_cancel_maps_overlay_settings('admin.php?page=gmb_add_overlays');" class="btn vivid-green" name="ux_btn_cancel" id="ux_btn_cancel"><?php echo $gm_cancel_button; ?></a>
                                    <input type="submit" name="ux_btn_add_polygon" class="btn vivid-green" id="ux_btn_add_polygon" value="<?php echo isset($_REQUEST["edit"]) ? $gm_update_polygon : $gm_add_polygon; ?>">
                                 </div>
                              </div>
                           </div>
                           <div id="ux_div_polyline_settings" style="display:none;">
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_polyline_title; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_polyline_title_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*</span>
                                 </label>
                                 <input type="text" class="form-control" name="ux_txt_polyline_title" id="ux_txt_polyline_title"  value="<?php echo isset($polyline_overlays_edit_data['polyline_title']) ? esc_attr($polyline_overlays_edit_data['polyline_title']) : ''; ?>" placeholder="<?php echo $gm_polyline_title_placeholder; ?>">
                              </div>
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_polyline_description; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_polyline_description_tooltips; ?>" data-placement="right"></i>
                                 </label>
                                 <textarea rows="4" class="form-control" name="ux_txt_polyline_description" id="ux_txt_polyline_description" placeholder="<?php echo $gm_polyline_description_placeholder; ?>" value=""><?php echo isset($polyline_overlays_edit_data['polyline_description']) ? esc_html($polyline_overlays_edit_data['polyline_description']) : ''; ?></textarea>
                              </div>
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_stroke_weight; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_polyline_stroke_weigth_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*</span>
                                 </label>
                                 <select name="ux_ddl_polyine_line_weight" id="ux_ddl_polyine_line_weight" class="form-control" onchange="initialize_google_map_setttings('polyline');">
                                    <?php
                                    for ($stroke_weight = 0; $stroke_weight < 51; $stroke_weight++) {
                                       ?>
                                       <option value="<?php echo $stroke_weight; ?>"><?php echo $stroke_weight; ?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="control-label">
                                          <?php echo $gm_stroke_color; ?> :
                                          <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_polyline_stroke_color_tooltips; ?>" data-placement="right"></i>
                                          <span class="required" aria-required="true">*</span>
                                       </label>
                                       <div>
                                          <input type="text" class="form-control custom-input-medium" name="ux_txt_polyline_line_color[]" id="ux_txt_polyline_line_color" onblur="default_value_google_maps('#ux_txt_polyline_line_color', '#000000'); initialize_google_map_setttings('polyline');" onfocus="google_map_color_picker('#ux_txt_polyline_line_color', this.value)" value="<?php echo isset($polyline_stroke_color[0]) ? esc_attr($polyline_stroke_color[0]) : "#000000"; ?>" placeholder="<?php echo $gm_stroke_color_placeholder; ?>">
                                          <input type="text" class="form-control custom-input-medium" name="ux_txt_polyline_line_color[]" id="ux_txt_polyline_line_opacity"  maxlength="3" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_polyline_line_opacity', '75', 'width'); initialize_google_map_setttings('polyline');" onkeypress="only_digits_google_maps(event);" value="<?php echo isset($polyline_stroke_color[1]) ? intval($polyline_stroke_color[1]) : 75; ?>"  placeholder="<?php echo $gm_stroke_opacity_placeholder; ?>">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="control-label">
                                          <?php echo $gm_polyline_type; ?> :
                                          <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_polyline_type_tooltips; ?>" data-placement="right"></i>
                                          <span class="required" aria-required="true">*</span>
                                       </label>
                                       <select id="ux_ddl_polyline_type" name="ux_ddl_polyline_type" class="form-control" onchange="initialize_google_map_setttings('polyline');">
                                          <option value="solid"><?php echo $gm_solid; ?></option>
                                          <option value="dotted"><?php echo $gm_dotted; ?></option>
                                          <option value="dashed"><?php echo $gm_dashed; ?></option>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_coordinates; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_polyline_coordinate_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*</span>
                                 </label>
                                 <textarea class="form-control" id="ux_div_polyline_coordinate" name="ux_div_polyline_coordinate" rows="4" readonly="true" placeholder="<?php echo $gm_coordinate_placeholder; ?>"><?php echo isset($polyline_overlays_edit_data['polyline_cordinates']) ? esc_attr($polyline_overlays_edit_data['polyline_cordinates']) : ''; ?></textarea>
                              </div>
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_info_window; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_info_window_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                 </label>
                                 <select name="ux_ddl_polyline_info_window" id="ux_ddl_polyline_info_window" class="form-control" onchange='google_maps_info_window("#ux_ddl_polyline_info_window", "#ux_div_polyline_info_window_image", "#wp_media_upload_polyline_error_info");'>
                                    <option value="enable"><?php echo $gm_enable; ?></option>
                                    <option value="disable"><?php echo $gm_disable; ?></option>
                                 </select>
                              </div>
                              <div id="ux_div_polyline_info_window_image" style="display:none;">
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_info_window_images; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_info_window_images_tooltips; ?>" data-placement="right"></i>
                                    </label>
                                    <span span class="required" aria-required="true"> <?php echo "( " . $gm_premium_edition_label . " )" ?> </span>
                                    <div class="input-icon right">
                                       <input type="text" class="form-control custom-input-middle input-inline" readonly="true" name="ux_txt_image_upload_polyline_path" id="ux_txt_image_upload_polyline_path" placeholder="<?php echo $gm_info_window_images_upload_placeholder; ?>" value="<?php echo isset($polyline_overlays_edit_data['image_upload_polyline_path']) ? esc_attr($polyline_overlays_edit_data['image_upload_polyline_path']) : ""; ?>">
                                       <input type="button" class="btn vivid-green custom-top" name="ux_upload_info_image" id="ux_upload_info_image" onclick="premium_edition_notification_google_maps_bank();" value="<?php echo $gm_upload; ?>">
                                       <input type="button" class="btn vivid-green custom-top" name="ux_clear_info_image" id="ux_clear_info_image"  onclick="premium_edition_notification_google_maps_bank();" value="<?php echo $gm_clear; ?>">
                                    </div>
                                 </div>
                              </div>
                              <p id="wp_media_upload_polyline_error_info" class="wp-media-error-message"><?php echo $gm_media_error_settings_message; ?></p>
                              <div class="line-separator"></div>
                              <div class="form-actions">
                                 <div class="pull-right">
                                    <a onclick="google_maps_cancel_maps_overlay_settings('admin.php?page=gmb_add_overlays');" class="btn vivid-green" name="ux_btn_cancel" id="ux_btn_cancel"><?php echo $gm_cancel_button; ?></a>
                                    <input type="submit" name="ux_btn_add_polyline" class="btn vivid-green" id="ux_btn_add_polyline" value="<?php echo isset($_REQUEST["edit"]) ? $gm_update_polyline : $gm_add_polyline; ?>">
                                 </div>
                              </div>
                           </div>
                           <div id="ux_div_circle_settings" style="display:none">
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_circle_title; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_circle_title_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*</span>
                                 </label>
                                 <input type="text" class="form-control" name="ux_txt_circle_title" id="ux_txt_circle_title"  value="<?php echo isset($serialize_circle_overlay_edit_data['circle_title']) ? esc_attr($serialize_circle_overlay_edit_data['circle_title']) : ''; ?>" placeholder="<?php echo $gm_circle_title_placeholder; ?>">
                              </div>
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_circle_description; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_circle_description_tooltips; ?>" data-placement="right"></i>
                                 </label>
                                 <textarea class="form-control" name="ux_txt_circle_desc" id="ux_txt_circle_desc"  rows="4" placeholder="<?php echo $gm_circle_description_placeholder; ?>"><?php echo isset($serialize_circle_overlay_edit_data['circle_description']) ? esc_html($serialize_circle_overlay_edit_data['circle_description']) : ''; ?></textarea>
                              </div>
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_stroke_weight; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_circle_stroke_width_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*</span>
                                 </label>
                                 <select name="ux_ddl_circle_weight" id="ux_ddl_circle_weight" class="form-control" onChange="initialize_google_map_setttings('circle');">
                                    <?php
                                    for ($stroke_weight = 0; $stroke_weight <= 50; $stroke_weight++) {
                                       ?>
                                       <option value="<?php echo $stroke_weight; ?>"><?php echo $stroke_weight; ?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="row" style="margin-top:15px;">
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="control-label">
                                          <?php echo $gm_stroke_color; ?> :
                                          <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_circle_stroke_color_tooltips; ?>" data-placement="right"></i>
                                          <span class="required" aria-required="true">*</span>
                                       </label>
                                       <div>
                                          <input type="text" class="form-control custom-input-medium"  name="ux_txt_circle_stroke_color[]" id="ux_txt_circle_stroke_color" onblur="default_value_google_maps('#ux_txt_circle_stroke_color', '#000000');initialize_google_map_setttings('circle');" onfocus="google_map_color_picker('#ux_txt_circle_stroke_color', this.value)" value="<?php echo isset($gmb_circle_stroke_color[0]) ? esc_attr($gmb_circle_stroke_color[0]) : '#000000'; ?>" placeholder="<?php echo $gm_stroke_color_placeholder; ?>">
                                          <input type="text" class="form-control custom-input-medium"   name="ux_txt_circle_stroke_color[]" id="ux_txt_circle_stroke_opacity" maxlength="3" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_circle_stroke_opacity', '75', 'width');initialize_google_map_setttings('circle');" onkeypress="only_digits_google_maps(event);" value="<?php echo isset($gmb_circle_stroke_color[1]) ? intval($gmb_circle_stroke_color[1]) : 75; ?>" placeholder="<?php echo $gm_stroke_opacity_placeholder; ?>">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="control-label">
                                          <?php echo $gm_fill_color; ?> :
                                          <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_circle_fill_color_tooltips; ?>" data-placement="right"></i>
                                          <span class="required" aria-required="true">*</span>
                                       </label>
                                       <div>
                                          <input type="text" class="form-control custom-input-medium" name="ux_txt_circle_fill_color[]" id="ux_txt_circle_fill_color" onblur="default_value_google_maps('#ux_txt_circle_fill_color', '#000000');initialize_google_map_setttings('circle');" onfocus="google_map_color_picker('#ux_txt_circle_fill_color', this.value)" value="<?php echo isset($gmb_circle_fill_color[0]) ? esc_attr($gmb_circle_fill_color[0]) : '#000000'; ?>" placeholder="<?php echo $gm_fill_color_placeholder; ?>">
                                          <input type="text" class="form-control custom-input-medium" name="ux_txt_circle_fill_color[]" id="ux_txt_circle_fill_color_opacity" maxlength="3" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_circle_fill_color_opacity', '75', 'width');initialize_google_map_setttings('circle');" onkeypress="only_digits_google_maps(event);" value="<?php echo isset($gmb_circle_fill_color[1]) ? intval($gmb_circle_fill_color[1]) : 75; ?>" placeholder="<?php echo $gm_fill_opacity_placeholder; ?>">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="row" style="margin-top:15px;">
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="control-label">
                                          <?php echo $gm_circle_radius_value; ?> :
                                          <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_circle_radius_value_tooltips; ?>" data-placement="right"></i>
                                          <span class="required" aria-required="true">*</span>
                                       </label>
                                       <input type="text" class="form-control" name="ux_txt_circle_radius_value" id="ux_txt_circle_radius_value" maxlength="7" value="<?php echo isset($serialize_circle_overlay_edit_data["circle_radius_value"]) ? intval($serialize_circle_overlay_edit_data["circle_radius_value"]) : 30; ?>" placeholder="<?php echo $gm_circle_radius_value_placeholder; ?>" onkeypress="only_digits_google_maps(event);" onblur="default_value_google_maps('#ux_txt_circle_radius_value', '30');initialize_google_map_setttings('circle');">
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="control-label">
                                          <?php echo $gm_circle_radius_type; ?> :
                                          <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_circle_radius_type_tooltips; ?>" data-placement="right"></i>
                                          <span class="required" aria-required="true">*</span>
                                       </label>
                                       <select name="ux_txt_circle_radius_type" id="ux_ddl_circle_radius_type" class="form-control" onchange="initialize_google_map_setttings('circle');">
                                          <option value="metres"><?php echo $gm_metres; ?></option>
                                          <option value="kilometers"><?php echo $gm_kilometers; ?></option>
                                          <option value="miles"><?php echo $gm_miles; ?></option>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_coordinates; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_circle_coordinate_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*</span>
                                 </label>
                                 <textarea class="form-control" name="ux_txt_circle_coordinate" id="ux_txt_circle_coordinate" rows="4" readonly="true" value="" placeholder="<?php echo $gm_coordinate_placeholder; ?>"><?php echo isset($serialize_circle_overlay_edit_data['circle_coordinates']) ? esc_attr($serialize_circle_overlay_edit_data['circle_coordinates']) : ''; ?></textarea>
                              </div>
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_info_window; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_info_window_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?> </span>
                                 </label>
                                 <select name="ux_ddl_circle_info_window" id="ux_ddl_circle_info_window" class="form-control" onchange='google_maps_info_window("#ux_ddl_circle_info_window", "#ux_div_circle_info_window_image", "#wp_media_upload_circle_error_info");'>
                                    <option value="enable"><?php echo $gm_enable; ?></option>
                                    <option value="disable"><?php echo $gm_disable; ?></option>
                                 </select>
                              </div>
                              <div id="ux_div_circle_info_window_image" style="display:none;">
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_info_window_images; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_info_window_images_tooltips; ?>" data-placement="right"></i>
                                    </label>
                                    <span span class="required" aria-required="true"> <?php echo "( " . $gm_premium_edition_label . " )" ?> </span>
                                    <div class="input-icon right">
                                       <input type="text" class="form-control custom-input-middle input-inline" readonly="true" name="ux_txt_image_upload_circle_path" id="ux_txt_image_upload_circle_path" placeholder="<?php echo $gm_info_window_images_upload_placeholder; ?>" value="<?php echo isset($serialize_circle_overlay_edit_data['image_upload_circle_path']) ? esc_attr($serialize_circle_overlay_edit_data['image_upload_circle_path']) : ''; ?>">
                                       <input type="button" class="btn vivid-green custom-top" name="ux_upload_info_image" id="ux_upload_info_image" onclick="premium_edition_notification_google_maps_bank();" value="<?php echo $gm_upload; ?>">
                                       <input type="button" class="btn vivid-green custom-top" name="ux_clear_info_image" id="ux_clear_info_image"  onclick="premium_edition_notification_google_maps_bank();" value="<?php echo $gm_clear; ?>">
                                    </div>
                                 </div>
                              </div>
                              <p id="wp_media_upload_circle_error_info" class="wp-media-error-message"><?php echo $gm_media_error_settings_message; ?></p>
                              <div class="line-separator"></div>
                              <div class="form-actions">
                                 <div class="pull-right">
                                    <a onclick="google_maps_cancel_maps_overlay_settings('admin.php?page=gmb_add_overlays');" class="btn vivid-green" name="ux_btn_cancel" id="ux_btn_cancel"><?php echo $gm_cancel_button; ?></a>
                                    <input type="submit" name="ux_btn_add_circle" class="btn vivid-green" id="ux_btn_add_circle" value="<?php echo isset($_REQUEST["edit"]) ? $gm_update_circle : $gm_add_circle; ?>">
                                 </div>
                              </div>
                           </div>
                           <div id="ux_div_rectangle_settings" style="display:none">
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_rectangle_title; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_rectangle_title_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                 </label>
                                 <input type="text" class="form-control" name="ux_txt_rectangle_title" id="ux_txt_rectangle_title" value="<?php echo isset($serialize_rectangle_overlay_edit_data["rectangle_title"]) ? esc_attr($serialize_rectangle_overlay_edit_data["rectangle_title"]) : ""; ?>" placeholder="<?php echo $gm_rectangle_title_placeholder; ?>">
                              </div>
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_rectangle_description; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_rectangle_description_tooltips; ?>" data-placement="right"></i>
                                 </label>
                                 <span class="required" aria-required="true"><?php echo "( " . $gm_premium_edition_label . " )" ?> </span>
                                 <textarea class="form-control" name="ux_txt_rectangle_desc" id="ux_txt_rectangle_desc" rows="4" placeholder="<?php echo $gm_rectangle_description_placeholder; ?>"><?php echo isset($serialize_rectangle_overlay_edit_data['rectangle_description']) ? esc_html($serialize_rectangle_overlay_edit_data['rectangle_description']) : ""; ?></textarea>
                              </div>
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="control-label">
                                          <?php echo $gm_stroke_color; ?> :
                                          <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_rectangle_stroke_color_tooltips; ?>" data-placement="right"></i>
                                          <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                       </label>
                                       <div class="input-icon right">
                                          <input type="text" class="form-control custom-input-medium valid" name="ux_txt_rectangle_stroke_color_opacity[]" id="ux_txt_rectangle_stroke_color" onblur="default_value_google_maps('#ux_txt_rectangle_stroke_color', '#000000');" onfocus="google_map_color_picker('#ux_txt_rectangle_stroke_color', this.value)" value="<?php echo isset($rectangle_color_and_opacity[0]) ? esc_attr($rectangle_color_and_opacity[0]) : "#000000"; ?>" placeholder="<?php echo $gm_stroke_color_placeholder; ?>">
                                          <input type="text" class="form-control custom-input-medium valid" name="ux_txt_rectangle_stroke_color_opacity[]" id="ux_txt_rectangle_stroke_opacity" maxlength="3" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_rectangle_stroke_opacity', '75', 'width');" onkeypress="only_digits_google_maps(event);" value="<?php echo isset($rectangle_color_and_opacity[1]) ? intval($rectangle_color_and_opacity[1]) : 75; ?>" placeholder="<?php echo $gm_stroke_opacity_placeholder; ?>">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="control-label">
                                          <?php echo $gm_fill_color; ?> :
                                          <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_rectangle_fill_color_tooltips; ?>" data-placement="right"></i>
                                          <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                       </label>
                                       <div class="input-icon right">
                                          <input type="text" class="form-control custom-input-medium valid" name="ux_txt_rectangle_fill_color_opacity[]" id="ux_txt_rectangle_fill_color" onblur="default_value_google_maps('#ux_txt_rectangle_fill_color', '#000000');" onfocus="google_map_color_picker('#ux_txt_rectangle_fill_color', this.value)" value="<?php echo isset($rectangle_fill_color_and_opacity[0]) ? esc_attr($rectangle_fill_color_and_opacity[0]) : "#000000"; ?>" placeholder="<?php echo $gm_fill_color_placeholder; ?>">
                                          <input type="text" class="form-control custom-input-medium valid" name="ux_txt_rectangle_fill_color_opacity[]" id="ux_txt_rectangle_fill_color_opacity" maxlength="3" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_rectangle_fill_color_opacity', '75', 'width');" onkeypress="only_digits_google_maps(event);" value="<?php echo isset($rectangle_fill_color_and_opacity[1]) ? intval($rectangle_fill_color_and_opacity[1]) : 75; ?>" placeholder="<?php echo $gm_fill_opacity_placeholder; ?>">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group" style ="margin-top:15px;">
                                 <label class="control-label">
                                    <?php echo $gm_coordinates; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_rectangle_coordinate_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                 </label>
                                 <textarea class="form-control" name="ux_txt_rectangle_coordinate" id="ux_txt_rectangle_coordinate" rows="4" readonly="true" value="" placeholder="<?php echo $gm_coordinate_placeholder; ?>"><?php echo isset($serialize_rectangle_overlay_edit_data["coordinates"]) ? esc_attr($serialize_rectangle_overlay_edit_data["coordinates"]) : ""; ?></textarea>
                              </div>
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_info_window; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_info_window_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                 </label>
                                 <select name="ux_ddl_rectangle_info_window" id="ux_ddl_rectangle_info_window" class="form-control" onchange='google_maps_info_window("#ux_ddl_rectangle_info_window", "#ux_div_rectangle_info_window_image", "#wp_media_upload_rectangle_error_info"); initialize_google_map_setttings("rectangle");'>
                                    <option value="enable"><?php echo $gm_enable; ?></option>
                                    <option value="disable"><?php echo $gm_disable; ?></option>
                                 </select>
                              </div>
                              <div id="ux_div_rectangle_info_window_image" style="display:none;">
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_info_window_images; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_info_window_images_tooltips; ?>" data-placement="right"></i>
                                    </label>
                                    <span class="required" aria-required="true"> <?php echo "( " . $gm_premium_edition_label . " )" ?> </span>
                                    <div class="input-icon right">
                                       <input type="text" class="form-control custom-input-middle input-inline" readonly="true" name="ux_txt_image_upload_rectangle_path" id="ux_txt_image_upload_rectangle_path" placeholder="<?php echo $gm_info_window_images_upload_placeholder; ?>" value="<?php echo isset($serialize_rectangle_overlay_edit_data["image_upload_rectangle_path"]) ? esc_attr($serialize_rectangle_overlay_edit_data["image_upload_rectangle_path"]) : ""; ?>">
                                       <input type="button" class="btn vivid-green custom-top" name="ux_upload_info_image" id="ux_upload_info_image" onclick="premium_edition_notification_google_maps_bank();" value="<?php echo $gm_upload; ?>">
                                       <input type="button" class="btn vivid-green custom-top" name="ux_clear_info_image" id="ux_clear_info_image"  onclick='premium_edition_notification_google_maps_bank();' value="<?php echo $gm_clear; ?>">
                                    </div>
                                 </div>
                              </div>
                              <p id="wp_media_upload_rectangle_error_info" class="wp-media-error-message"><?php echo $gm_media_error_settings_message; ?></p>
                              <div class="line-separator"></div>
                              <div class="form-actions">
                                 <div class="pull-right">
                                    <a onclick="google_maps_cancel_maps_overlay_settings('admin.php?page=gmb_add_overlays');" class="btn vivid-green" name="ux_btn_cancel" id="ux_btn_cancel"><?php echo $gm_cancel_button; ?></a>
                                    <input type="submit" name="ux_btn_add_rectangle" class="btn vivid-green" id="ux_btn_add_rectangle" value="<?php echo isset($_REQUEST["edit"]) ? $gm_update_rectangle : $gm_add_rectangle; ?>">
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <?php
   } else {
      ?>
      <div class="page-bar">
         <ul class="page-breadcrumb">
            <li>
               <i class="icon-custom-home"></i>
               <a href="admin.php?page=gmb_google_maps">
                  <?php echo $google_maps_bank; ?>
               </a>
               <span>></span>
            </li>
            <li>
               <a href="admin.php?page=gmb_manage_overlays">
                  <?php echo $gm_overlays; ?>
               </a>
               <span>></span>
            </li>
            <li>
               <span>
                  <?php echo $gm_add_overlays; ?>
               </span>
            </li>
         </ul>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="portlet box vivid-green">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="icon-custom-basket"></i>
                     <?php echo $gm_add_overlays; ?>
                  </div>
               </div>
               <div class="portlet-body form">
                  <div class="form-body">
                     <strong><?php echo $gm_user_access_message; ?></strong>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php
   }
}