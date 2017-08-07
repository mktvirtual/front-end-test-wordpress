<?php
/**
 * This Template is used for managing directions.
 *
 * @author  Tech Banker
 * @package google-maps-bank/views/layout-settings
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
   } else if (layout_settings_google_map == "1") {
      $info_window_nonce = wp_create_nonce("info_window_nonce");
      $info_window_title_style = isset($details_info_window["info_window_title_style"]) ? explode(",", esc_attr($details_info_window["info_window_title_style"])) : "";
      $info_window_desc_style = isset($details_info_window["info_window_desc_style"]) ? explode(",", esc_attr($details_info_window["info_window_desc_style"])) : "";
      $info_window_border_style = isset($details_info_window["info_window_border_style"]) ? explode(",", esc_attr($details_info_window["info_window_border_style"])) : "";
      $info_windows_image_padding = isset($details_info_window["info_windows_image_padding"]) ? explode(",", esc_attr($details_info_window["info_windows_image_padding"])) : "";
      $info_windows_text_padding = isset($details_info_window["info_windows_text_padding"]) ? explode(",", esc_attr($details_info_window["info_windows_text_padding"])) : "";
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
               <a href="admin.php?page=gmb_info_window">
                  <?php echo $gm_layout_settings; ?>
               </a>
               <span>></span>
            </li>
            <li>
               <span>
                  <?php echo $gm_info_window; ?>
               </span>
            </li>
         </ul>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="portlet box vivid-green">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="icon-custom-picture"></i>
                     <?php echo $gm_info_window; ?>
                  </div>
                  <a href="http://beta.tech-banker.com/products/google-maps-bank/" target="_blank" class="premium-editions"><?php echo $mb_upgrade_to ?></a>
               </div>
               <div class="portlet-body form">
                  <form id="ux_frm_info_window">
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
                        <div class="form-actions">
                           <div class="pull-right">
                              <input type="submit" class="btn vivid-green" name="ux_btn_infowindow_settings" id="ux_btn_infowindow_settings" value="<?php echo $gm_save_changes; ?>">
                           </div>
                        </div>
                        <div class="line-separator"></div>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_width; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_info_window_width_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*</span>
                                 </label>
                                 <div class="input-icon right">
                                    <input type="text" class="form-control" name="ux_txt_info_window_width" id="ux_txt_info_window_width" placeholder="<?php echo $gm_info_window_width_placeholder; ?>" onblur="default_value_google_maps('#ux_txt_info_window_width', '300', 'info');" value="<?php echo isset($details_info_window["info_window_width"]) ? intval($details_info_window["info_window_width"]) : 300; ?>" maxlength="3" onkeypress="only_digits_google_maps(event);">
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_info_window_open; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_info_window_open_tooltip; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*</span>
                                 </label>
                                 <select name="ux_ddl_info_window_event" id="ux_ddl_info_window_event" class="form-control">
                                    <option value="click"><?php echo $gm_infowindow_click; ?></option>
                                    <option value="hover"><?php echo $gm_infowindow_hover; ?></option>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_title_style; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_marker_title_style_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*</span>
                                 </label>
                                 <div class="input-icon right">
                                    <select name="ux_txt_title_font_size_and_color[]" id="ux_ddl_title_font_size" class="form-control custom-input-medium">
                                       <?php
                                       for ($font_size = 1; $font_size <= 200; $font_size++) {
                                          ?>
                                          <option value="<?php echo $font_size; ?>"><?php echo $font_size . "px"; ?></option>
                                          <?php
                                       }
                                       ?>
                                    </select>
                                    <input type="text" class="form-control custom-input-medium" name="ux_txt_title_font_size_and_color[]" id="ux_txt_title_font_color" onfocus="google_map_color_picker('#ux_txt_title_font_color', this.value)" onblur="default_value_google_maps('#ux_txt_title_font_color', '#000000');" placeholder="<?php echo $gm_marker_font_color_placeholder; ?>" value="<?php echo isset($info_window_title_style[1]) ? esc_attr($info_window_title_style[1]) : "#000000"; ?>">
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_font_family; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_marker_title_font_family_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*  ( <?php echo $gm_premium_edition_label; ?> )  </span>
                                 </label>
                                 <select name="ux_ddl_title_font_family" id="ux_ddl_title_font_family" class="form-control">
                                    <?php
                                    foreach ($web_font_list as $key => $font_names) {
                                       $font_family_type = $key == "Roboto Condensed" ? "" : "disabled = disabled";
                                       ?>
                                       <option <?php echo $font_family_type; ?> value="<?php echo $key; ?>"><?php echo $font_names; ?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_map_dsecription_font_style; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_marker_description_style_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*</span>
                                 </label>
                                 <div class="input-icon right">
                                    <select name="ux_txt_description_font_size_and_color[]" id="ux_ddl_description_font_size" class="form-control custom-input-medium">
                                       <?php
                                       for ($font_size = 1; $font_size <= 200; $font_size++) {
                                          ?>
                                          <option value="<?php echo $font_size; ?>"><?php echo $font_size . "px"; ?></option>
                                          <?php
                                       }
                                       ?>
                                    </select>
                                    <input type="text" class="form-control custom-input-medium" name="ux_txt_description_font_size_and_color[]" id="ux_txt_description_font_color" onfocus="google_map_color_picker('#ux_txt_description_font_color', this.value)" onblur="default_value_google_maps('#ux_txt_description_font_color', '#000000');" placeholder="<?php echo $gm_marker_font_color_placeholder; ?>" value="<?php echo isset($info_window_desc_style[1]) ? esc_attr($info_window_desc_style[1]) : "#000000"; ?>">
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_marker_description_font_family; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_marker_description_font_family_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*  ( <?php echo $gm_premium_edition_label; ?> )  </span>
                                 </label>
                                 <select name="ux_ddl_description_font_family" id="ux_ddl_description_font_family" class="form-control">
                                    <?php
                                    foreach ($web_font_list as $key => $font_names) {
                                       $font_family_type = $key == "Roboto Condensed" ? "" : "disabled = disabled";
                                       ?>
                                       <option <?php echo $font_family_type; ?> value="<?php echo $key; ?>"><?php echo $font_names; ?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_border_style; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_border_style_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*</span>
                                 </label>
                                 <div class="input-icon right">
                                    <input type="text" class="form-control input-width-25 input-inline" name="ux_txt_border_style[]" id="ux_txt_border_style_width"  onfocus="paste_prevent_google_maps(this.id);" placeholder="<?php echo $gm_width; ?>"  maxlength="3" value="<?php echo isset($info_window_border_style[0]) ? intval($info_window_border_style[0]) : 0; ?>" onkeypress="only_digits_google_maps(event);" onblur="default_value_google_maps('#ux_txt_border_style_width', '0');">
                                    <select name="ux_txt_border_style[]" id="ux_ddl_border_style_thickness" class="form-control input-width-27 input-inline">
                                       <option value="none"><?php echo $gm_none; ?></option>
                                       <option value="solid"><?php echo $gm_solid; ?></option>
                                       <option value="dashed"><?php echo $gm_dashed; ?></option>
                                       <option value="dotted"><?php echo $gm_dotted; ?></option>
                                    </select>
                                    <input type="text" class="form-control input-normal input-inline" name="ux_txt_border_style[]" id="ux_txt_border_style_color" onfocus="google_map_color_picker('#ux_txt_border_style_color', this.value)" onblur="default_value_google_maps('#ux_txt_border_style_color', '#000000');" placeholder="<?php echo $gm_marker_font_color_placeholder; ?>" value="<?php echo isset($info_window_border_style[2]) ? esc_attr($info_window_border_style[2]) : "#000000"; ?>">
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_border_radius; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_info_window_border_radius_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*</span>
                                 </label>
                                 <input type="text" class="form-control" name="ux_txt_border_radius" id="ux_txt_border_radius"  onfocus="paste_prevent_google_maps(this.id);" placeholder="<?php echo $gm_border_radius_placeholder; ?>" value="<?php echo isset($details_info_window["info_window_border_radius"]) ? intval($details_info_window["info_window_border_radius"]) : 0; ?>" maxlength="3" onkeypress="only_digits_google_maps(event);" onblur="default_value_google_maps('#ux_txt_border_radius', '0');">
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_info_window_image_padding; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_info_window_image_padding_tootltip; ?>" data-placement="right"></i>
                                    <span aria-required="true" class="required">*  ( <?php echo $gm_premium_edition_label; ?> )  </span>
                                 </label>
                                 <div>
                                    <input type="text" class="form-control custom-input-xsmall input-inline" name="ux_txt_image_padding[]" id="ux_txt_image_top_padding" placeholder="<?php echo $gm_top; ?>" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_image_top_padding', '10');"  value="0" maxlength="3" disabled>
                                    <input type="text" class="form-control custom-input-xsmall input-inline" name="ux_txt_image_padding[]" id="ux_txt_image_right_padding" placeholder="<?php echo $gm_right; ?>" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_image_right_padding', '10');" value="10" maxlength="3" disabled>
                                    <input type="text" class="form-control custom-input-xsmall input-inline" name="ux_txt_image_padding[]" id="ux_txt_image_bottom_padding" placeholder="<?php echo $gm_bottom ?>" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_image_bottom_padding', '0');" value="0" maxlength="3" disabled>
                                    <input type="text" class="form-control custom-input-xsmall input-inline" name="ux_txt_image_padding[]" id="ux_txt_image_left_padding" placeholder="<?php echo $gm_left; ?>" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_image_left_padding', '10');"  value="0" maxlength="3" disabled>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_info_window_text_padding; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_info_window_text_padding_tooltip; ?>" data-placement="right"></i>
                                    <span aria-required="true" class="required">*  ( <?php echo $gm_premium_edition_label; ?> )  </span>
                                 </label>
                                 <div>
                                    <input type="text" class="form-control custom-input-xsmall input-inline" name="ux_txt_text_padding[]" id="ux_txt_text_top_padding"  placeholder="<?php echo $gm_top; ?>" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_text_top_padding', '10');" value="0" maxlength="3" disabled>
                                    <input type="text" class="form-control custom-input-xsmall input-inline" name="ux_txt_text_padding[]" id="ux_txt_text_right_padding"  placeholder="<?php echo $gm_right; ?>" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_text_right_padding', '0');"  value="0" maxlength="3" disabled>
                                    <input type="text" class="form-control custom-input-xsmall input-inline" name="ux_txt_text_padding[]" id="ux_txt_text_bottom_padding" placeholder="<?php echo $gm_bottom; ?>" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_text_bottom_padding', '0');"  value="0" maxlength="3" disabled>
                                    <input type="text" class="form-control custom-input-xsmall input-inline" name="ux_txt_text_padding[]" id="ux_txt_text_left_padding"  placeholder="<?php echo $gm_left; ?>" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_text_left_padding', '0');"  value="0" maxlength="3" disabled>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="control-label">
                              <?php echo $gm_info_window_images_position; ?> :
                              <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_info_window_images_tooltips; ?>" data-placement="right"></i>
                              <span class="required" aria-required="true">*</span>
                           </label>
                           <select name="ux_ddl_info_window_img_position" id="ux_ddl_info_window_img_position" class="form-control">
                              <option value="left"><?php echo $gm_left; ?></option>
                              <option value="right"><?php echo $gm_right; ?></option>
                           </select>
                        </div>
                        <div class="line-separator"></div>
                        <div class="form-actions">
                           <div class="pull-right">
                              <input type="submit" class="btn vivid-green" name="ux_btn_infowindow_settings" id="ux_btn_infowindow_settings" value="<?php echo $gm_save_changes; ?>">
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
               <a href="admin.php?page=gmb_info_window">
                  <?php echo $gm_layout_settings; ?>
               </a>
               <span>></span>
            </li>
            <li>
               <span>
                  <?php echo $gm_info_window; ?>
               </span>
            </li>
         </ul>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="portlet box vivid-green">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="icon-custom-picture"></i>
                     <?php echo $gm_info_window; ?>
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