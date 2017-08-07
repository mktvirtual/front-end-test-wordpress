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
   } else if (store_locator_google_map == "1") {
      $store_locator_color_opacity = isset($serialize_store_locator_edit_data["store_locator_fill_style"]) ? explode(",", esc_attr($serialize_store_locator_edit_data["store_locator_fill_style"])) : "";
      $store_locator_stroke_color_opacity = isset($serialize_store_locator_edit_data["store_locator_stroke_style"]) ? explode(",", esc_attr($serialize_store_locator_edit_data["store_locator_stroke_style"])) : "";
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
               <a href="admin.php?page=gmb_manage_store">
                  <?php echo $gm_store_locator; ?>
               </a>
               <span>></span>
            </li>
            <li>
               <span>
                  <?php echo isset($_REQUEST["id"]) ? $gm_update_store : $gm_add_store; ?>
               </span>
            </li>
         </ul>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="portlet box vivid-green">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="icon-custom-plus"></i>
                     <?php echo isset($_REQUEST["id"]) ? $gm_update_store : $gm_add_store; ?>
                  </div>
                  <a href="http://beta.tech-banker.com/products/google-maps-bank/" target="_blank" class="premium-editions"><?php echo $mb_upgrade_to ?></a>
               </div>
               <div class="portlet-body form">
                  <form id="ux_frm_store_locator">
                     <div class="form-body">
                        <?php
                        if ($gm_message_translate_help != "") {
                           ?>
                           <div class="note note-danger">
                              <h4 class="block">
                                 <?php echo $gm_important_disclaimer; ?>
                              </h4>
                              <strong><?php echo $gm_message_translate_help; ?><a href="javascript:void(0);" data-popup-open="ux_open_popup_translator" class="custom_links" onclick="show_pop_up_google_map();"><?php echo $gm_message_translate_here; ?></a></strong>
                           </div>
                           <?php
                        }
                        ?>
                        <div style="max-height:350px; margin-bottom: 4%;" id="ux_map_canvas">
                           <div id="ux_div_map_canvas" class="map_canvas"></div>
                           <div class="line-separator"></div>
                        </div>
                        <div id="ux_div_store_locator_settings">
                           <div class="form-group">
                              <label class="control-label">
                                 <?php echo $gm_store_locator_title; ?> :
                                 <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_add_store_title_tooltips; ?>" data-placement="right"></i>
                                 <span class="required" aria-required="true">*  ( <?php echo $gm_premium_edition_label; ?> )  </span>
                              </label>
                              <input type="text" class="form-control" name="ux_txt_store_locator_title" id="ux_txt_store_locator_title" value="" placeholder="<?php echo $gm_add_store_title_placeholder; ?>">
                           </div>
                           <div class="form-group">
                              <label class="control-label">
                                 <?php echo $gm_add_store_locator_description; ?> :
                                 <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_add_store_description_tooltips; ?>" data-placement="right"></i>
                                 <span class="required" aria-required="true">*  ( <?php echo $gm_premium_edition_label; ?> )  </span>
                              </label>
                              <textarea class="form-control" name="ux_txt_store_locator_desc" id="ux_txt_store_locator_desc" rows="4" placeholder="<?php echo $gm_add_store_description_placeholder; ?>"></textarea>
                           </div>
                           <div class="form-group">
                              <label class="control-label">
                                 <?php echo $gm_marker_type; ?> :
                                 <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_marker_type_tooltips; ?>" data-placement="right"></i>
                                 <span class="required" aria-required="true">*  ( <?php echo $gm_premium_edition_label; ?> )  </span>
                              </label>
                              <div class="row" style="margin-top:10px;">
                                 <div class="col-md-3">
                                    <input type="radio" name="ux_chk_map_formatted_address" id="ux_chk_formatted_address" value="formatted_address"  onclick="choose_address_type_google_maps('formatted_address', '#ux_div_map_address', '#ux_div_latitude_longitude');" <?php echo isset($serialize_store_locator_edit_data["store_locator_address_type"]) && esc_attr($serialize_store_locator_edit_data["store_locator_address_type"]) == "formatted_address" ? "checked = checked" : !isset($serialize_store_locator_edit_data["store_locator_address_type"]) ? "checked = checked" : ""; ?>>
                                    <?php echo $gm_formatted_address; ?>
                                 </div>
                                 <div class="col-md-3">
                                    <input type="radio" name="ux_chk_map_formatted_address" id="ux_chk_by_latitude_longitude" value="latitude_longitude" onclick="choose_address_type_google_maps('latitude_longitude', '#ux_div_map_address', '#ux_div_latitude_longitude');" <?php echo isset($serialize_store_locator_edit_data["store_locator_address_type"]) && esc_attr($serialize_store_locator_edit_data["store_locator_address_type"]) == "latitude_longitude" ? "checked = checked" : ""; ?>>
                                    <?php echo $gm_by_latitude_longitude; ?>
                                 </div>
                              </div>
                           </div>
                           <div id="ux_div_map_address">
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_add_map_address; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_add_map_address_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*  ( <?php echo $gm_premium_edition_label; ?> )  </span>
                                 </label>
                                 <input type="text" class="form-control" name="ux_txt_marker_address" id="ux_txt_marker_address" value="" placeholder="<?php echo $gm_add_map_address_placeholder; ?>">
                              </div>
                           </div>
                           <div id="ux_div_latitude_longitude" style="display:none;">
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="control-label">
                                          <?php echo $gm_map_latitude; ?> :
                                          <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_add_map_latitude_tooltips; ?>" data-placement="right"></i>
                                          <span class="required" aria-required="true">*  ( <?php echo $gm_premium_edition_label; ?> )  </span>
                                       </label>
                                       <input type="text" class="form-control" name="ux_txt_marker_latitude" id="ux_txt_marker_latitude" value="" placeholder="<?php echo $gm_add_map_latitude_placeholder; ?>">
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="control-label">
                                          <?php echo $gm_map_longitude; ?> :
                                          <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_add_map_longitude_tooltips; ?>" data-placement="right"></i>
                                          <span class="required" aria-required="true">*  ( <?php echo $gm_premium_edition_label; ?> )  </span>
                                       </label>
                                       <input type="text" class="form-control" name="ux_txt_marker_longitude" id="ux_txt_marker_longitude" value="" placeholder="<?php echo $gm_add_map_longitude_placeholder; ?>">
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="row" style="margin-top:15px !important;">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_phone_number; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_phone_number_tooltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">*  ( <?php echo $gm_premium_edition_label; ?> )  </span>
                                    </label>
                                    <input type="text" class="form-control" name="ux_txt_store_locator_phone_number" id="ux_txt_store_locator_phone_number" value="" placeholder="<?php echo $gm_add_phone_number_placeholder; ?>" onkeypress="google_maps_validate_alphabets(event);" onfocus="paste_prevent_google_maps('ux_txt_store_locator_phone_number')">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_fax_number; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_fax_number_tooltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">*  ( <?php echo $gm_premium_edition_label; ?> )  </span>
                                    </label>
                                    <input type="text" class="form-control" name="ux_txt_store_locator_fax_number" id="ux_txt_store_locator_fax_number" value="" placeholder="<?php echo $gm_add_fax_number_placeholder; ?>"  onkeypress="google_maps_validate_alphabets(event);" onfocus="paste_prevent_google_maps('ux_txt_store_locator_fax_number')">
                                 </div>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="control-label">
                                 <?php echo $gm_website_url; ?> :
                                 <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_website_url_tooltips; ?>" data-placement="right"></i>
                                 <span class="required" aria-required="true">*  ( <?php echo $gm_premium_edition_label; ?> )  </span>
                              </label>
                              <input type="text" class="form-control" name="ux_txt_store_locator_website_url" id="ux_txt_store_locator_website_url" value="" placeholder="<?php echo $gm_add_website_url_placeholder; ?>">
                           </div>
                           <div class="form-group">
                              <label class="control-label">
                                 <?php echo $gm_marker_icon; ?> :
                                 <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_marker_icon_tooltips; ?>" data-placement="right"></i>
                                 <span class="required" aria-required="true">*  ( <?php echo $gm_premium_edition_label; ?> )  </span>
                              </label>
                              <select name="ux_ddl_store_locator_marker_icon" id="ux_ddl_store_locator_marker_icon" class="form-control" onchange="google_maps_upload_marker_icon('#ux_ddl_store_locator_marker_icon');">
                                 <option value="default_icon"><?php echo $gm_default_icon; ?></option>
                                 <option value="choose_icon"><?php echo $gm_choose_icon; ?></option>
                                 <option value="upload"><?php echo $gm_upload_icon; ?></option>
                              </select>
                           </div>
                           <div id="ux_div_marker_icon_ablity" style="display:none">
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_marker_images; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_marker_img_upload_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*  ( <?php echo $gm_premium_edition_label; ?> )  </span>
                                 </label>
                                 <div class="input-icon right">
                                    <input type="text" class="form-control custom-input-large input-inline" readonly="true" name="ux_txt_store_locator_marker_icon_path" id="ux_txt_store_locator_marker_icon_path" placeholder="<?php echo $gm_marker_upload_icon_placeholder; ?>" value="">
                                    <input type="button" class="btn vivid-green custom-top" name="ux_upload_marker_icon" id="ux_upload_marker_icon" onclick="premium_edition_notification_google_maps_bank();" value="<?php echo $gm_upload; ?>">
                                 </div>
                              </div>
                           </div>
                           <p id="wp_media_upload_error" class="wp-media-error-message"><?php echo $gm_media_error_settings_message; ?></p>
                           <div id="ux_div_marker_icon_choose" style="display:none">
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_add_marker_category; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_add_marker_category_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*  ( <?php echo $gm_premium_edition_label; ?> )  </span>
                                 </label>
                                 <div class="layout-controls-location custom-layout-controls-map-location">
                                    <select class="form-control" name="ux_ddl_store_locator_marker_category" id="ux_ddl_store_locator_marker_category" onchange="marker_change_category('#ux_ddl_store_locator_marker_category');">
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
                                       <span class="required" aria-required="true">*  ( <?php echo $gm_premium_edition_label; ?> )  </span>
                                    </label>
                                    <select name="ux_ddl_store_locator_marker_animation" id="ux_ddl_store_locator_marker_animation" class="form-control" onchange="initialize_store_locator_google_maps();">
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
                                       <span class="required" aria-required="true">*  ( <?php echo $gm_premium_edition_label; ?> )  </span>
                                    </label>
                                    <select name="ux_ddl_info_window" id="ux_ddl_info_window" class="form-control" onchange='google_maps_info_window("#ux_ddl_info_window", "#store_locator_image", "#wp_media_upload_error_info"), show_hide_controls_google_maps("#ux_ddl_info_window", "#store_locator_image");initialize_store_locator_google_maps();'>
                                       <option value="enable"><?php echo $gm_enable; ?></option>
                                       <option value="disable"><?php echo $gm_disable; ?></option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group" id="store_locator_image" style="display:none;">
                              <label class="control-label">
                                 <?php echo $gm_image_url; ?> :
                                 <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_image_url_tooltips; ?>" data-placement="right"></i>
                                 <span class="required" aria-required="true">*  ( <?php echo $gm_premium_edition_label; ?> )  </span>
                              </label>
                              <div class="input-icon right">
                                 <input type="text" class="form-control custom-input-middle input-inline" readonly="true" name="ux_txt_store_locator_image_upload_path" id="ux_txt_store_locator_image_upload_path" placeholder="<?php echo $gm_info_window_images_upload_placeholder; ?>" value="">
                                 <input type="button" class="btn vivid-green custom-top" name="ux_upload_info_image" id="ux_upload_info_image" onclick="premium_edition_notification_google_maps_bank();" value="<?php echo $gm_upload; ?>">
                                 <input type="button" class="btn vivid-green custom-top" name="ux_clear_info_image" id="ux_clear_info_image" onclick='premium_edition_notification_google_maps_bank();' value="<?php echo $gm_clear; ?>">
                              </div>
                           </div>
                           <p id="wp_media_upload_error_info" class="wp-media-error-message"><?php echo $gm_media_error_settings_message; ?></p>
                           <div class="form-group">
                              <label class="control-label">
                                 <?php echo $gm_additional_note; ?> :
                                 <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_additional_note_tooltips; ?>" data-placement="right"></i>
                                 <span class="required" aria-required="true">*  ( <?php echo $gm_premium_edition_label; ?> )  </span>
                              </label>
                              <textarea class="form-control" name="ux_txt_store_locator_additional_note" id="ux_txt_store_locator_additional_note" rows="4" placeholder="<?php echo $gm_additional_note_placeholder; ?>"></textarea>
                           </div>
                           <div class="line-separator"></div>
                           <div class="form-actions">
                              <div class="pull-right">
                                 <input type="submit" name="ux_btn_add_store" class="btn vivid-green" id="ux_btn_add_store" value="<?php echo isset($_REQUEST["id"]) ? $gm_update_store : $gm_add_store; ?>">
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
               <a href="admin.php?page=gmb_manage_store">
                  <?php echo $gm_store_locator; ?>
               </a>
               <span>></span>
            </li>
            <li>
               <span>
                  <?php echo $gm_add_store; ?>
               </span>
            </li>
         </ul>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="portlet box vivid-green">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="icon-custom-plus"></i>
                     <?php echo $gm_add_store; ?>
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