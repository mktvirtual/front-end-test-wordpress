<?php
/**
 * This Template is used for managing Store Locator settings.
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
      $store_locator_nonce = wp_create_nonce("store_locator_nonce");
      $store_locator_header_title_style = isset($details_store_locator["store_locator_header_title_style"]) ? explode(",", esc_attr($details_store_locator["store_locator_header_title_style"])) : "";
      $store_locator_label_style = isset($details_store_locator["store_locator_label_style"]) ? explode(",", esc_attr($details_store_locator["store_locator_label_style"])) : "";
      $store_locator_button_text_style = isset($details_store_locator["store_locator_button_text_style"]) ? explode(",", esc_attr($details_store_locator["store_locator_button_text_style"])) : "";
      $store_locator_height_width = isset($details_store_locator["store_locator_button_height_and_width"]) ? explode(",", esc_attr($details_store_locator["store_locator_button_height_and_width"])) : "";
      $store_locator_input_field_text_style = isset($details_store_locator["store_locator_input_field_text_style"]) ? explode(",", esc_attr($details_store_locator["store_locator_input_field_text_style"])) : "";
      $store_locator_input_field_margin = isset($details_store_locator["store_locator_input_field_margin"]) ? explode(",", esc_attr($details_store_locator["store_locator_input_field_margin"])) : "";
      $store_locator_input_field_padding = isset($details_store_locator["store_locator_input_field_padding"]) ? explode(",", esc_attr($details_store_locator["store_locator_input_field_padding"])) : "";
      $store_locator_input_field_placeholder_style = isset($details_store_locator["store_locator_input_field_placeholder_style"]) ? explode(",", esc_attr($details_store_locator["store_locator_input_field_placeholder_style"])) : "";
      $store_locator_table_style = isset($details_store_locator["store_locator_table_text_style"]) ? explode(",", esc_attr($details_store_locator["store_locator_table_text_style"])) : "";
      $store_locator_table_display_border_style = isset($details_store_locator["store_locator_table_border_style"]) ? explode(",", esc_attr($details_store_locator["store_locator_table_border_style"])) : "";
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
                  <?php echo $gm_store_locator; ?>
               </span>
            </li>
         </ul>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="portlet box vivid-green">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="icon-custom-tag"></i>
                     <?php echo $gm_store_locator; ?>
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
                        <div class="form-actions">
                           <div class="pull-right">
                              <input type="submit" class="btn vivid-green" name="ux_btn_store_locator_settings" id="ux_btn_store_locator_settings" value="<?php echo $gm_save_changes; ?>">
                           </div>
                        </div>
                        <div class="line-separator"></div>
                        <div class="tabbable-custom">
                           <ul class="nav nav-tabs ">
                              <li class="active">
                                 <a aria-expanded="true" href="#general_settings" data-toggle="tab">
                                    <?php echo $gm_general_settings; ?>
                                 </a>
                              </li>
                              <li>
                                 <a aria-expanded="true" href="#header_settings" data-toggle="tab">
                                    <?php echo $gm_header_settings; ?>
                                 </a>
                              </li>
                              <li>
                                 <a aria-expanded="false" href="#controls_settings" data-toggle="tab">
                                    <?php echo $gm_control; ?>
                                 </a>
                              </li>
                              <li>
                                 <a aria-expanded="false" href="#button_settings" data-toggle="tab">
                                    <?php echo $gm_button_settings; ?>
                                 </a>
                              </li>
                              <li>
                                 <a aria-expanded="false" href="#circle_settings" data-toggle="tab">
                                    <?php echo $gm_circle; ?>
                                 </a>
                              </li>
                              <li>
                                 <a aria-expanded="false" href="#store_locator_table_settings" data-toggle="tab">
                                    <?php echo $gm_map_store_locator_table; ?>
                                 </a>
                              </li>
                           </ul>
                           <div id="store_locator_map_canvas" style="display:none;"></div>
                           <div class="tab-content">
                              <div class="tab-pane active" id="general_settings">
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_background_color; ?>
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_store_locator_background_color_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <input type="text" name="ux_txt_background_color" id= "ux_txt_background_color" placeholder="<?php echo $gm_background_color_placeholder; ?>" class="form-control" onfocus="google_map_color_picker('#ux_txt_background_color', this.value);" onblur="default_value_google_maps('#ux_txt_background_color', '#ffffff');" value="<?php echo isset($details_store_locator["store_locator_general_background_color"]) ? esc_attr($details_store_locator["store_locator_general_background_color"]) : "#ffffff"; ?>">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_background_opacity; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_store_locator_background_opacity_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <input type="text" name="ux_txt_background_color_opacity" id= "ux_txt_background_color_opacity" placeholder="<?php echo $gm_background_color_opacity_placeholder; ?>" class="form-control" maxlength="3" onblur="default_value_google_maps('#ux_txt_background_color_opacity', '100', 'width');" onkeypress="only_digits_google_maps(event);" onfocus="paste_prevent_google_maps(this.id);" value="<?php echo isset($details_store_locator["store_locator_general_background_opacity"]) ? intval($details_store_locator["store_locator_general_background_opacity"]) : 100; ?>">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="tab-pane" id="header_settings">
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_title_style; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_store_locator_header_style_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <div class="input-icon right">
                                             <select name="ux_txt_store_locator_header_title_style[]" id="ux_ddl_store_locator_header_title_style_size" class="form-control custom-input-medium">
                                                <?php
                                                for ($font_size = 1; $font_size <= 200; $font_size++) {
                                                   ?>
                                                   <option value="<?php echo $font_size; ?>"><?php echo $font_size . "px"; ?></option>
                                                   <?php
                                                }
                                                ?>
                                             </select>
                                             <input type="text" class="form-control custom-input-medium" name="ux_txt_store_locator_header_title_style[]" id="ux_txt_store_locator_header_title_style_color" onblur="default_value_google_maps('#ux_txt_store_locator_header_title_style_color', '#000000');" placeholder="<?php echo $gm_background_color_placeholder; ?>" value="<?php echo isset($store_locator_header_title_style[1]) ? esc_attr($store_locator_header_title_style[1]) : "#000000"; ?>" onfocus="google_map_color_picker('#ux_txt_store_locator_header_title_style_color', this.value);">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_font_family; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_store_locator_header_font_family_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <select name="ux_ddl_store_locator_header_font_family" id="ux_ddl_store_locator_header_font_family" class="form-control">
                                             <?php
                                             foreach ($web_font_list as $key => $font_names) {
                                                ?>
                                                <option value="<?php echo $key; ?>"><?php echo $font_names; ?></option>
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
                                             <?php echo $gm_background_color; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_store_locator_background_color_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <input type="text" class="form-control" name="ux_txt_store_locator_background_color" id="ux_txt_store_locator_background_color" onblur="default_value_google_maps('#ux_txt_store_locator_background_color', '#ffffff');" value="<?php echo isset($details_store_locator["store_locator_background_color"]) ? esc_attr($details_store_locator["store_locator_background_color"]) : "#ffffff"; ?>" onfocus="google_map_color_picker('#ux_txt_store_locator_background_color', this.value);" placeholder="<?php echo $gm_background_color_placeholder; ?>">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_background_color_opacity; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_store_locator_background_color_opacity_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <input type="text" class="form-control" name="ux_txt_store_locator_background_color_opacity" id="ux_txt_store_locator_background_color_opacity"  onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_store_locator_background_color_opacity', '100', 'width');" value="<?php echo isset($details_store_locator["store_locator_background_color_opacity"]) ? intval($details_store_locator["store_locator_background_color_opacity"]) : 100; ?>" maxlength="3" onkeypress="only_digits_google_maps(event);" placeholder="<?php echo $gm_background_color_opacity_placeholder; ?>">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="tab-pane" id="controls_settings">
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_title_style; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_store_locator_label_style_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <div class="input-icon right">
                                             <select name="ux_txt_store_locator_label_style[]" id="ux_ddl_store_locator_label_style_size" class="form-control custom-input-medium">
                                                <?php
                                                for ($font_size = 1; $font_size <= 200; $font_size++) {
                                                   ?>
                                                   <option value="<?php echo $font_size; ?>"><?php echo $font_size . "px"; ?></option>
                                                   <?php
                                                }
                                                ?>
                                             </select>
                                             <input type="text" class="form-control custom-input-medium" name="ux_txt_store_locator_label_style[]" id="ux_txt_store_locator_label_style_color"  onblur="default_value_google_maps('#ux_txt_store_locator_label_style_color', '#000000');" placeholder="<?php echo $gm_background_color_placeholder; ?>" value="<?php echo isset($store_locator_label_style[1]) ? esc_attr($store_locator_label_style[1]) : "#000000"; ?>" onfocus="google_map_color_picker('#ux_txt_store_locator_label_style_color', this.value);">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_font_family; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_store_locator_label_font_family_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <select name="ux_ddl_store_locator_label_font_family" id="ux_ddl_store_locator_label_font_family" class="form-control">
                                             <?php
                                             foreach ($web_font_list as $key => $font_names) {
                                                ?>
                                                <option value="<?php echo $key; ?>"><?php echo $font_names; ?></option>
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
                                             <?php echo $gm_input_field_height; ?>
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_store_locator_input_field_height_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <input type="text" name="ux_txt_input_field_height" id="ux_txt_input_field_height" class="form-control" maxlength="3" onblur="default_value_google_maps('#ux_txt_input_field_height', '40');" onfocus="paste_prevent_google_maps(this.id);" onkeypress="only_digits_google_maps(event);" placeholder="<?php echo $gm_input_field_height_placeholder; ?>" value="<?php echo isset($details_store_locator["store_locator_input_field_height"]) ? intval($details_store_locator["store_locator_input_field_height"]) : 40; ?>">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_input_field_width; ?>
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_store_locator_input_field_width_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <input type="text" name="ux_txt_input_field_width" id="ux_txt_input_field_width" class="form-control" maxlength="3" onblur="default_value_google_maps('#ux_txt_input_field_width', '100', 'width');" onfocus="paste_prevent_google_maps(this.id);" onkeypress="only_digits_google_maps(event);" placeholder="<?php echo $gm_input_field_width_placeholder; ?>" value="<?php echo isset($details_store_locator["store_locator_input_field_width"]) ? intval($details_store_locator["store_locator_input_field_width"]) : 100; ?>">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_input_field_text_style; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_input_field_text_style_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <div class="input-icon right">
                                             <select name="ux_ddl_store_locator_input_field_text_style[]" id="ux_ddl_store_locator_input_field_text_style_size" class="form-control custom-input-medium">
                                                <?php
                                                for ($font_size = 1; $font_size <= 200; $font_size++) {
                                                   ?>
                                                   <option value="<?php echo $font_size; ?>"><?php echo $font_size . "px"; ?></option>
                                                   <?php
                                                }
                                                ?>
                                             </select>
                                             <input type="text" class="form-control custom-input-medium" name="ux_ddl_store_locator_input_field_text_style[]" id="ux_txt_store_locator_input_field_text_style_color" placeholder="<?php echo $gm_marker_font_color_placeholder; ?>" value="<?php echo isset($store_locator_input_field_text_style[1]) ? esc_attr($store_locator_input_field_text_style[1]) : "#000000"; ?>" onblur="default_value_google_maps('#ux_txt_store_locator_input_field_text_style_color', '#000000');" onfocus="google_map_color_picker('#ux_txt_store_locator_input_field_text_style_color', this.value);">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_input_field_font_family; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_input_field_font_family_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <select name="ux_ddl_store_locator_input_field_font_family" id="ux_ddl_store_locator_input_field_font_family" class="form-control">
                                             <?php
                                             foreach ($web_font_list as $key => $font_names) {
                                                ?>
                                                <option value="<?php echo $key; ?>"><?php echo $font_names; ?></option>
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
                                             <?php echo $gm_shortcode_background_color; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_store_locator_input_field_background_color_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <input type="text" class="form-control" name="ux_txt_store_locator_input_field_background_color" id="ux_txt_store_locator_input_field_background_color" onblur="default_value_google_maps('#ux_txt_store_locator_input_field_background_color', '#ffffff');" value="<?php echo isset($details_store_locator["store_locator_input_field_background_color"]) ? esc_attr($details_store_locator["store_locator_input_field_background_color"]) : "#ffffff"; ?>" onfocus="google_map_color_picker('#ux_txt_store_locator_input_field_background_color', this.value);" placeholder="<?php echo $gm_background_color_placeholder; ?>">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_background_opacity; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_store_locator_input_field_background_color_opacity_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <input type="text" class="form-control" name="ux_txt_store_locator_input_field_background_color_opacity" id="ux_txt_store_locator_input_field_background_color_opacity"  onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_store_locator_input_field_background_color_opacity', '75', 'width');" value="<?php echo isset($details_store_locator["store_locator_input_field_background_color_opacity"]) ? intval($details_store_locator["store_locator_input_field_background_color_opacity"]) : 75; ?>" maxlength="3" onkeypress="only_digits_google_maps(event);" placeholder="<?php echo $gm_background_color_opacity_placeholder; ?>">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_input_field_margin; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_store_locator_input_field_margin_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <div>
                                             <input type="text" name="ux_txt_store_locator_input_field_margin[]" id="ux_txt_input_field_top_margin" placeholder="<?php echo $gm_top; ?>" class="form-control custom-input-xsmall input-inline valid" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_input_field_top_margin', '0');" value="<?php echo isset($store_locator_input_field_margin[0]) ? intval($store_locator_input_field_margin[0]) : 0; ?>" maxlength="3" aria-invalid="false">
                                             <input type="text" name="ux_txt_store_locator_input_field_margin[]" id="ux_txt_input_field_right_margin"  placeholder="<?php echo $gm_right; ?>" class="form-control custom-input-xsmall input-inline valid" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_input_field_right_margin', '0');" value="<?php echo isset($store_locator_input_field_margin[1]) ? intval($store_locator_input_field_margin[1]) : 0; ?>" maxlength="3" aria-invalid="false">
                                             <input type="text" name="ux_txt_store_locator_input_field_margin[]" id="ux_txt_input_field_bottom_margin" placeholder="<?php echo $gm_bottom; ?>" class="form-control custom-input-xsmall input-inline valid" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_input_field_bottom_margin', '10');" value="<?php echo isset($store_locator_input_field_margin[2]) ? intval($store_locator_input_field_margin[2]) : 10; ?>" maxlength="3" aria-invalid="false">
                                             <input type="text" name="ux_txt_store_locator_input_field_margin[]" id="ux_txt_input_field_left_margin" placeholder="<?php echo $gm_left; ?>" class="form-control custom-input-xsmall input-inline valid" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_input_field_left_margin', '0');" value="<?php echo isset($store_locator_input_field_margin[3]) ? intval($store_locator_input_field_margin[3]) : 0; ?>" maxlength="3" aria-invalid="false">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_input_field_padding; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_store_locator_input_field_padding_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <div>
                                             <input type="text" name="ux_txt_store_locator_input_field_padding[]" id="ux_txt_input_field_top_padding"  placeholder="<?php echo $gm_top; ?>" class="form-control custom-input-xsmall input-inline valid" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_input_field_top_padding', '0');" value="<?php echo isset($store_locator_input_field_padding[0]) ? intval($store_locator_input_field_padding[0]) : 0; ?>" maxlength="3" aria-invalid="false">
                                             <input type="text" name="ux_txt_store_locator_input_field_padding[]" id="ux_txt_input_field_right_padding" placeholder="<?php echo $gm_right; ?>" class="form-control custom-input-xsmall input-inline valid" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_input_field_right_padding', '0');" value="<?php echo isset($store_locator_input_field_padding[1]) ? intval($store_locator_input_field_padding[1]) : 0; ?>" maxlength="3" aria-invalid="false">
                                             <input type="text" name="ux_txt_store_locator_input_field_padding[]" id="ux_txt_input_field_bottom_padding" placeholder="<?php echo $gm_bottom; ?>"  class="form-control custom-input-xsmall input-inline valid" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_input_field_bottom_padding', '0');" value="<?php echo isset($store_locator_input_field_padding[2]) ? intval($store_locator_input_field_padding[2]) : 0; ?>" maxlength="3" aria-invalid="false">
                                             <input type="text" name="ux_txt_store_locator_input_field_padding[]" id="ux_txt_input_field_left_padding" placeholder="<?php echo $gm_left; ?>" class="form-control custom-input-xsmall input-inline valid" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_input_field_left_padding', '0');" value="<?php echo isset($store_locator_input_field_padding[3]) ? intval($store_locator_input_field_padding[3]) : 0; ?>" maxlength="3" aria-invalid="false">
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_directions_input_field_from; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_directions_input_field_from_tooltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                    </label>
                                    <input type="text" name="ux_txt_directions_from" id="ux_txt_directions_from" class="form-control" placeholder="<?php echo $gm_directions_input_field_from_placeholder; ?>" value="<?php echo isset($details_store_locator["store_locator_input_field_placeholder_form"]) ? esc_attr($details_store_locator["store_locator_input_field_placeholder_form"]) : "Please enter loction address"; ?>">
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_input_field_style; ?>
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_input_field_style_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <select class="form-control custom-input-medium" name="ux_txt_input_field_placeholder_style[]" id="ux_ddl_input_field_placeholder_size" value="<?php isset($store_locator_input_field_placeholder_style[0]) ? esc_attr($store_locator_input_field_placeholder_style[0]) : ""; ?>">
                                             <?php
                                             for ($font_size = 1; $font_size <= 200; $font_size++) {
                                                ?>
                                                <option value="<?php echo $font_size; ?>"><?php echo $font_size . "px"; ?></option>
                                                <?php
                                             }
                                             ?>
                                          </select>
                                          <input type="text" class="form-control custom-input-medium" name="ux_txt_input_field_placeholder_style[]" id="ux_txt_input_placeholder_style_color" onblur="default_value_google_maps('#ux_txt_input_placeholder_style_color', '#000000');" onfocus="google_map_color_picker('#ux_txt_input_placeholder_style_color', this.value);" placeholder="Please choose Background Color" aria-invalid="false" value="<?php echo isset($store_locator_input_field_placeholder_style[1]) ? esc_attr($store_locator_input_field_placeholder_style[1]) : "#000000"; ?>">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_input_field_style_font_family; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_input_field_font_family_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <select name="ux_ddl_input_field_placeholder_font_family" id="ux_ddl_store_locator_input_field_placeholder_font_family" class="form-control">
                                             <?php
                                             foreach ($web_font_list as $key => $font_names) {
                                                ?>
                                                <option value="<?php echo $key; ?>"><?php echo $font_names; ?></option>
                                                <?php
                                             }
                                             ?>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_show_default_location; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_show_default_location_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <select name="ux_ddl_default_location" id="ux_ddl_default_location" class="form-control" onchange="enable_disable_controls_google_maps('#ux_ddl_default_location', '#ux_div_default_location');">
                                             <option value="enable"><?php echo $gm_enable; ?></option>
                                             <option value="disable"><?php echo $gm_disable; ?></option>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 <div id="ux_div_default_location">
                                    <div class="form-group">
                                       <label class="control-label">
                                          <?php echo $gm_default_location; ?> :
                                          <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_default_location_tooltips; ?>" data-placement="right"></i>
                                          <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                       </label>
                                       <div class="row" style="margin-top:10px;">
                                          <div class="col-md-3">
                                             <input type="radio" name="ux_chk_map_formatted_address" id="ux_chk_formatted_address" value="formatted_address"  <?php echo isset($details_store_locator["store_locator_input_field_default_location"]) && esc_attr($details_store_locator["store_locator_input_field_default_location"]) == "formatted_address" ? "checked = checked" : (!isset($details_store_locator["store_locator_input_field_default_location"]) ? "checked = checked" : ""); ?> onclick="choose_address_type_google_maps('formatted_address', '#ux_div_map_address', '#ux_div_latitude_longitude');">
                                             <?php echo $gm_formatted_address; ?>
                                          </div>
                                          <div class="col-md-3">
                                             <input type="radio" name="ux_chk_map_formatted_address" id="ux_chk_by_latitude_longitude" value="latitude_longitude" <?php echo isset($details_store_locator["store_locator_input_field_default_location"]) && esc_attr($details_store_locator["store_locator_input_field_default_location"]) == "latitude_longitude" ? "checked = checked" : ""; ?> onclick="choose_address_type_google_maps('latitude_longitude', '#ux_div_map_address', '#ux_div_latitude_longitude');" >
                                             <?php echo $gm_by_latitude_longitude; ?>
                                          </div>
                                       </div>
                                    </div>
                                    <div id="ux_div_map_address">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_add_map_address; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_Formatted_store_locator_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <input type="text" class="form-control" name="ux_txt_address" id="ux_txt_address" value="<?php echo isset($details_store_locator["store_locator_input_field_formatted"]) ? esc_html($details_store_locator["store_locator_input_field_formatted"]) : ""; ?>" placeholder="<?php echo $gm_add_map_address_placeholder; ?>">
                                       </div>
                                    </div>
                                    <div id="ux_div_latitude_longitude" style="display:none;">
                                       <div class="row">
                                          <div class="col-md-6">
                                             <div class="form-group">
                                                <label class="control-label">
                                                   <?php echo $gm_map_latitude; ?> :
                                                   <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_Latitude_store_locator_tooltips; ?>" data-placement="right"></i>
                                                   <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                                </label>
                                                <input type="text" class="form-control ux_txt_latitude" name="ux_txt_latitude" id="ux_txt_latitude" value="<?php echo isset($details_store_locator["store_locator_input_field_latitude"]) ? floatval($details_store_locator["store_locator_input_field_latitude"]) : ""; ?>" placeholder="<?php echo $gm_add_map_latitude_placeholder; ?>">
                                             </div>
                                          </div>
                                          <div class="col-md-6">
                                             <div class="form-group">
                                                <label class="control-label">
                                                   <?php echo $gm_map_longitude; ?> :
                                                   <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_Longitude_store_locator_tooltips; ?>" data-placement="right"></i>
                                                   <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                                </label>
                                                <input type="text" class="form-control ux_txt_longitude" name="ux_txt_longitude" id="ux_txt_longitude" value="<?php echo isset($details_store_locator["store_locator_input_field_longitude"]) ? floatval($details_store_locator["store_locator_input_field_longitude"]) : ""; ?>" placeholder="<?php echo $gm_add_map_longitude_placeholder; ?>">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="tab-pane" id="button_settings">
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_height_and_width; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_store_locator_button_height_and_width_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <div class="input-icon right">
                                             <input type="text" class="form-control custom-input-medium" name="ux_txt_store_locator_button_height_width[]" id="ux_txt_store_locator_button_height" onblur="default_value_google_maps('#ux_txt_store_locator_button_height', '50', '');" maxlength="3" onkeypress="only_digits_google_maps(event);" placeholder="<?php echo $gm_height; ?>" value="<?php echo isset($store_locator_height_width[0]) ? intval($store_locator_height_width[0]) : 50; ?>" onfocus="paste_prevent_google_maps(this.id);">
                                             <input type="text" class="form-control custom-input-medium" name="ux_txt_store_locator_button_height_width[]" id="ux_txt_store_locator_button_width" onblur="default_value_google_maps('#ux_txt_store_locator_button_width', '100', '');" maxlength="3" onkeypress="only_digits_google_maps(event);" placeholder="<?php echo $gm_width; ?>" value="<?php echo isset($store_locator_height_width[1]) ? intval($store_locator_height_width[1]) : 100; ?>" onfocus="paste_prevent_google_maps(this.id);">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_map_alignment; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_store_locator_button_alignment_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <select id="ux_ddl_store_locator_button_alignment" name="ux_txt_store_locator_button_alignment" class="form-control">
                                             <option value="left"><?php echo $gm_left; ?></option>
                                             <option value="center"><?php echo $gm_center; ?></option>
                                             <option value="right"><?php echo $gm_right; ?></option>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_style; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_store_locator_button_textstyle_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <div class="input-icon right">
                                             <select name="ux_txt_store_locator_button_text_style[]" id="ux_ddl_store_locator_button_text_size" class="form-control custom-input-medium">
                                                <?php
                                                for ($font_size = 1; $font_size <= 200; $font_size++) {
                                                   ?>
                                                   <option value="<?php echo $font_size; ?>"><?php echo $font_size . "px"; ?></option>
                                                   <?php
                                                }
                                                ?>
                                             </select>
                                             <input type="text" class="form-control custom-input-medium" name="ux_txt_store_locator_button_text_style[]" id="ux_txt_store_locator_button_text_style_color" placeholder="<?php echo $gm_background_color_placeholder; ?>" onblur="default_value_google_maps('#ux_txt_store_locator_button_text_style_color', '#ffffff');" value="<?php echo isset($store_locator_button_text_style[1]) ? esc_attr($store_locator_button_text_style[1]) : "#ffffff"; ?>" onfocus="google_map_color_picker('#ux_txt_store_locator_button_text_style_color', this.value);">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_font_family; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_store_locator_button_font_family_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <select name="ux_ddl_store_locator_button_font_family" id="ux_ddl_store_locator_button_font_family" class="form-control">
                                             <?php
                                             foreach ($web_font_list as $key => $font_names) {
                                                ?>
                                                <option value="<?php echo $key; ?>"><?php echo $font_names; ?></option>
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
                                             <?php echo $gm_background_color; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_store_locator_button_background_color_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <input type="text" class="form-control" name="ux_txt_store_locator_button_background_color" id="ux_txt_store_locator_button_background_color"  onblur="default_value_google_maps('#ux_txt_store_locator_button_background_color', '#a4cd39');" value="<?php echo isset($details_store_locator["store_locator_button_background_color"]) ? esc_attr($details_store_locator["store_locator_button_background_color"]) : "#a4cd39"; ?>" onfocus="google_map_color_picker('#ux_txt_store_locator_button_background_color', this.value);" placeholder="<?php echo $gm_background_color_placeholder; ?>">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_background_color_opacity; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_store_locator_button_background_color_opacity_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <input type="text" class="form-control" name="ux_txt_store_locator_button_background_color_opacity" id="ux_txt_store_locator_button_background_color_opacity"  onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_store_locator_button_background_color_opacity', '75', 'width');" value="<?php echo isset($details_store_locator["store_locator_button_background_color_opacity"]) ? intval($details_store_locator["store_locator_button_background_color_opacity"]) : 75; ?>" maxlength="3" onkeypress="only_digits_google_maps(event);" placeholder="<?php echo $gm_background_color_opacity_placeholder; ?>">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="tab-pane" id="circle_settings">
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_shortcode_store_locator_distance; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_store_locator_distance_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <select name="ux_ddl_store_locator_distance" id="ux_ddl_store_locator_distance" class="form-control">
                                             <option value="kilometers"><?php echo $gm_kilometers; ?></option>
                                             <option value="miles"><?php echo $gm_miles; ?></option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_shortcode_store_locator_circle_line_width; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_store_locator_circle_line_width_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <input type="text" class="form-control" name="ux_txt_store_locator_circle_line_width" id="ux_txt_store_locator_circle_line_width"  onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_store_locator_circle_line_width', '3', 'width');" value="<?php echo isset($details_store_locator["store_locator_circle_line_width"]) ? intval($details_store_locator["store_locator_circle_line_width"]) : ""; ?>" maxlength="3" onkeypress="only_digits_google_maps(event);" placeholder="<?php echo $gm_circle_line_width_placeholder; ?>">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_shortcode_line_color; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_store_locator_line_color_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <input type="text" class="form-control" name="ux_txt_store_locator_line_color" id="ux_txt_store_locator_line_color" onblur="default_value_google_maps('#ux_txt_store_locator_line_color', '#000000');" value="<?php echo isset($details_store_locator["store_locator_circle_line_color"]) ? esc_attr($details_store_locator["store_locator_circle_line_color"]) : "#000000"; ?>" onfocus="google_map_color_picker('#ux_txt_store_locator_line_color', this.value);" placeholder="<?php echo $gm_line_color_placeholder; ?>">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_shortcode_store_locator_circle_line_opacity; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_store_locator_circle_line_opacity_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <input type="text" class="form-control" name="ux_txt_store_locator_circle_line_opacity" id="ux_txt_store_locator_circle_line_opacity" onfocus="paste_prevent_google_maps(this.id);"  onblur="default_value_google_maps('#ux_txt_store_locator_circle_line_opacity', '75', 'width');" value="<?php echo isset($details_store_locator["store_locator_circle_line_color_opacity"]) ? intval($details_store_locator["store_locator_circle_line_color_opacity"]) : 75; ?>" maxlength="3" onkeypress="only_digits_google_maps(event);" placeholder="<?php echo $gm_line_color_opacity_placeholder; ?>">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_fill_color; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_store_locator_circle_fill_color_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <input type="text" class="form-control" name="ux_txt_store_locator_circle_fill_color" id="ux_txt_store_locator_circle_fill_color"  onblur="default_value_google_maps('#ux_txt_store_locator_circle_fill_color', '#fafafa');" value="<?php echo isset($details_store_locator["store_locator_circle_fill_color"]) ? esc_attr($details_store_locator["store_locator_circle_fill_color"]) : "#000000"; ?>" onfocus="google_map_color_picker('#ux_txt_store_locator_circle_fill_color', this.value);" placeholder="<?php echo $gm_store_locator_circle_fill_color_placeholder; ?>">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_fill_opacity; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_store_locator_circle_fill_color_opacity_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <input type="text" class="form-control" name="ux_txt_store_locator_circle_fill_color_opacity" id="ux_txt_store_locator_circle_fill_color_opacity" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_store_locator_circle_fill_color_opacity', '75', 'width');" value="<?php echo isset($details_store_locator["store_locator_circle_fill_color_opacity"]) ? intval($details_store_locator["store_locator_circle_fill_color_opacity"]) : 75; ?>" maxlength="3" onkeypress="only_digits_google_maps(event);" placeholder="<?php echo $gm_store_locator_circle_fill_color_opacity_placeholder; ?>">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="tab-pane" id="store_locator_table_settings">
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_map_store_table_width; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_map_store_table_width_tootltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                    </label>
                                    <input type="text" name="ux_txt_store_locator_table_width" id="ux_txt_store_locator_table_width" class="form-control" maxlength="3" onblur="default_value_google_maps('#ux_txt_store_locator_table_width', 100, 'width');"  placeholder="<?php echo $gm_map_store_table_width_placeholder; ?>" value="<?php echo isset($details_store_locator["store_locator_table_width"]) ? intval($details_store_locator["store_locator_table_width"]) : 100; ?>" onkeypress="only_digits_google_maps(event);">
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_style; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_map_store_table_style_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <div class="input-icon right">
                                             <select name="ux_txt_store_locator_table_style[]" id="ux_txt_store_locator_table_font_size" class="form-control custom-input-medium">
                                                <?php
                                                for ($font_size = 1; $font_size <= 200; $font_size++) {
                                                   ?>
                                                   <option value="<?php echo $font_size; ?>"><?php echo $font_size . "px"; ?></option>
                                                   <?php
                                                }
                                                ?>
                                             </select>
                                             <input type="text" class="form-control custom-input-medium" name="ux_txt_store_locator_table_style[]" id="ux_txt_store_locator_table_font_color" placeholder="<?php echo $gm_marker_font_color_placeholder; ?>" value="<?php echo isset($store_locator_table_style[1]) ? esc_attr($store_locator_table_style[1]) : "#000000"; ?>" onblur="default_value_google_maps('#ux_txt_store_locator_table_font_color', '#000000');" onfocus="google_map_color_picker('#ux_txt_store_locator_table_font_color', this.value);">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_text_font_family; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_map_store_table_font_family_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <select name="ux_ddl_store_locator_table_font_family" id="ux_ddl_store_locator_table_font_family" class="form-control">
                                             <?php
                                             foreach ($web_font_list as $key => $font_names) {
                                                ?>
                                                <option value="<?php echo $key; ?>"><?php echo $font_names; ?></option>
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
                                             <?php echo $gm_background_color; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_map_store_table_bg_color_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <input type="text" class="form-control" name="ux_txt_store_locator_table_bg_color" id="ux_txt_store_locator_table_bg_color" value="<?php echo isset($details_store_locator["store_locator_table_background_color"]) ? esc_attr($details_store_locator["store_locator_table_background_color"]) : "#ffffff"; ?>" onblur="default_value_google_maps('#ux_txt_store_locator_table_bg_color', '#ffffff');" onfocus="google_map_color_picker('#ux_txt_store_locator_table_bg_color', this.value);" placeholder="<?php echo $gm_background_color_placeholder; ?>">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_background_opacity; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_map_store_table_bg_opacity_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <input type="text" class="form-control" name="ux_txt_store_locator_table_bg_opacity" id="ux_txt_store_locator_table_bg_opacity"  onfocus="paste_prevent_google_maps(this.id);" value='<?php echo isset($details_store_locator["store_locator_table_background_color_opacity"]) ? intval($details_store_locator["store_locator_table_background_color_opacity"]) : 75; ?>' maxlength="3" onkeypress="only_digits_google_maps(event);" onblur="default_value_google_maps('#ux_txt_store_locator_table_bg_opacity', '100', 'width');" placeholder="<?php echo $gm_background_color_opacity_placeholder; ?>">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_border_style; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_map_store_table_border_style_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <div class="input-icon right">
                                             <input type="text" class="form-control input-width-25 input-inline" name="ux_txt_store_locator_table_border_style[]" id="ux_txt_store_locator_table_border_style_size" onfocus="paste_prevent_google_maps(this.id);" placeholder="<?php echo $gm_width; ?>"  maxlength="3" onkeypress="only_digits_google_maps(event);" onblur="default_value_google_maps('#ux_txt_store_locator_table_border_style_size', '0');" value="<?php echo isset($store_locator_table_display_border_style[0]) ? intval($store_locator_table_display_border_style[0]) : 0; ?>">
                                             <select id="ux_ddl_store_locator_table_border_style_type" name="ux_txt_store_locator_table_border_style[]" class="form-control input-width-25 input-inline">
                                                <option value="none"><?php echo $gm_none; ?></option>
                                                <option value="solid"><?php echo $gm_solid; ?></option>
                                                <option value="dotted"><?php echo $gm_dotted; ?></option>
                                                <option value="dashed"><?php echo $gm_dashed; ?></option>
                                             </select>
                                             <input type="text" class="form-control input-normal input-inline" name="ux_txt_store_locator_table_border_style[]" id="ux_txt_store_locator_table_border_style_color" placeholder="<?php echo $gm_marker_font_color_placeholder; ?>" value="<?php echo isset($direction_display_border_style[2]) ? esc_attr($direction_display_border_style[2]) : "#a4cd39"; ?>" onfocus="google_map_color_picker('#ux_txt_store_locator_table_border_style_color', this.value);" onblur="default_value_google_maps('#ux_txt_store_locator_table_border_style_color', '#a4cd39');">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_border_radius; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_map_store_table_border_radius_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                                          </label>
                                          <input type="text" class="form-control" name="ux_txt_store_locator_table_border_radius" id="ux_txt_store_locator_table_border_radius" onfocus="paste_prevent_google_maps(this.id);" value="<?php echo isset($details_store_locator["store_locator_table_border_radius"]) ? intval($details_store_locator["store_locator_table_border_radius"]) : 0; ?>" maxlength="3" onkeypress="only_digits_google_maps(event);" onblur="default_value_google_maps('#ux_txt_store_locator_table_border_radius', '0');" placeholder="<?php echo $gm_border_radius_placeholder; ?>">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="line-separator"></div>
                        <div class="form-actions">
                           <div class="pull-right">
                              <input type="submit" class="btn vivid-green" name="ux_btn_store_locator_settings" id="ux_btn_store_locator_settings" value="<?php echo $gm_save_changes; ?>">
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
                  <?php echo $gm_store_locator; ?>
               </span>
            </li>
         </ul>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="portlet box vivid-green">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="icon-custom-tag"></i>
                     <?php echo $gm_store_locator; ?>
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