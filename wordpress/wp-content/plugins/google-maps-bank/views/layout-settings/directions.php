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
      $google_map_directions_nonce = wp_create_nonce("google_map_directions_nonce");
      $direction_header_title_style = isset($details_directions["directions_header_title_style"]) ? explode(",", esc_attr($details_directions["directions_header_title_style"])) : "";
      $direction_label_style = isset($details_directions["directions_label_style"]) ? explode(",", esc_attr($details_directions["directions_label_style"])) : "";
      $direction_input_field_text_style = isset($details_directions["directions_input_field_text_style"]) ? explode(",", esc_attr($details_directions["directions_input_field_text_style"])) : "";
      $direction_button_text_style = isset($details_directions["directions_button_text_style"]) ? explode(",", esc_attr($details_directions["directions_button_text_style"])) : "";
      $direction_button_height_width = isset($details_directions["directions_button_height_and_width"]) ? explode(",", esc_attr($details_directions["directions_button_height_and_width"])) : "";
      $text_direction_style = isset($details_directions["directions_display_text_style"]) ? explode(",", esc_attr($details_directions["directions_display_text_style"])) : "";
      $direction_display_border_style = isset($details_directions["directions_display_border_style"]) ? explode(",", esc_attr($details_directions["directions_display_border_style"])) : "";
      $directions_input_field_placeholder_style = isset($details_directions["directions_input_field_placeholder_style"]) ? explode(",", esc_attr($details_directions["directions_input_field_placeholder_style"])) : "";
      $directions_input_field_height = isset($details_directions["directions_input_field_height"]) ? explode(",", esc_attr($details_directions["directions_input_field_height"])) : "";
      $directions_input_field_margin = isset($details_directions["directions_input_field_margin"]) ? explode(",", esc_attr($details_directions["directions_input_field_margin"])) : "";
      $directions_input_field_padding = isset($details_directions["directions_input_field_padding"]) ? explode(",", esc_attr($details_directions["directions_input_field_padding"])) : "";
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
                  <?php echo $gm_directions; ?>
               </span>
            </li>
         </ul>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="portlet box vivid-green">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="icon-custom-directions"></i>
                     <?php echo $gm_directions; ?>
                  </div>
                  <a href="http://beta.tech-banker.com/products/google-maps-bank/" target="_blank" class="premium-editions"><?php echo $mb_upgrade_to ?></a>
               </div>
               <div class="portlet-body form">
                  <form id="ux_frm_directions">
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
                              <input type="submit" class="btn vivid-green" name="ux_btn_directions_settings" id="ux_btn_directions_settings" value="<?php echo $gm_save_changes; ?>">
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
                                 <a aria-expanded="false" href="#header_settings" data-toggle="tab">
                                    <?php echo $gm_header_settings; ?>
                                 </a>
                              </li>
                              <li>
                                 <a aria-expanded="false" href="#control_settings" data-toggle="tab">
                                    <?php echo $gm_control; ?>
                                 </a>
                              </li>
                              <li>
                                 <a aria-expanded="false" href="#button_settings" data-toggle="tab">
                                    <?php echo $gm_button_settings; ?>
                                 </a>
                              </li>
                              <li>
                                 <a aria-expanded="false" href="#text_directions_settings" data-toggle="tab">
                                    <?php echo $text_directions_settings; ?>
                                 </a>
                              </li>
                           </ul>
                           <div id="direction_map_canvas" style="display:none;"></div>
                           <div class="tab-content">
                              <div class="tab-pane active" id="general_settings">
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_background_color; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_window_background_color_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <input type="text" name="ux_txt_directions_background_color" id="ux_txt_directions_background_color" placeholder="<?php echo $gm_background_color_placeholder; ?>" class="form-control" onfocus="google_map_color_picker('#ux_txt_directions_background_color', this.value);" onblur="default_value_google_maps('#ux_txt_directions_background_color', '#ffffff');" value="<?php echo isset($details_directions["directions_general_background_color"]) ? esc_attr($details_directions["directions_general_background_color"]) : "#ffffff"; ?>">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_background_opacity; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_window_background_opacity_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <input type="text" name="ux_txt_directions_background_color_opacity" id= "ux_txt_directions_background_color_opacity" maxlength="3" placeholder="<?php echo $gm_background_color_opacity_placeholder; ?>" class="form-control" onblur="default_value_google_maps('#ux_txt_directions_background_color_opacity', '100', 'width');" value="<?php echo isset($details_directions["directions_general_background_opacity"]) ? intval($details_directions["directions_general_background_opacity"]) : 0; ?>" onkeypress="only_digits_google_maps(event);">
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
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_header_title_style_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <div class="input-icon right">
                                             <select name="ux_txt_direction_header_title_style[]" id="ux_ddl_direction_header_title_style_size" class="form-control custom-input-medium">
                                                <?php
                                                for ($font_size = 1; $font_size <= 200; $font_size++) {
                                                   ?>
                                                   <option value="<?php echo $font_size; ?>"><?php echo $font_size . "px"; ?></option>
                                                   <?php
                                                }
                                                ?>
                                             </select>
                                             <input type="text" class="form-control custom-input-medium" name="ux_txt_direction_header_title_style[]" id="ux_txt_direction_header_title_style_color" placeholder="<?php echo $gm_marker_font_color_placeholder; ?>" value="<?php echo isset($direction_header_title_style[1]) ? esc_attr($direction_header_title_style[1]) : "#000000"; ?>" onblur="default_value_google_maps('#ux_txt_direction_header_title_style_color', '#000000');" onfocus="google_map_color_picker('#ux_txt_direction_header_title_style_color', this.value);">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_font_family; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_header_font_family_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <select name="ux_ddl_direction_header_font_family" id="ux_ddl_direction_header_font_family" class="form-control">
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
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_direction_background_color_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <input type="text" class="form-control" name="ux_txt_direction_background_color" id="ux_txt_direction_background_color" placeholder="<?php echo $gm_background_color_placeholder; ?>" value="<?php echo isset($details_directions["directions_background_color"]) ? esc_attr($details_directions["directions_background_color"]) : "#ffffff"; ?>" onblur="default_value_google_maps('#ux_txt_direction_background_color', '#ffffff');" onfocus="google_map_color_picker('#ux_txt_direction_background_color', this.value);">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_background_color_opacity; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_direction_background_color_opacity_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <input type="text" class="form-control" name="ux_txt_direction_background_color_opacity" id="ux_txt_direction_background_color_opacity"  onfocus="paste_prevent_google_maps(this.id);" value="<?php echo isset($details_directions["directions_background_opacity"]) ? intval($details_directions["directions_background_opacity"]) : 100; ?>" maxlength="3" onblur="default_value_google_maps('#ux_txt_direction_background_color_opacity', '100', 'width');" onkeypress="only_digits_google_maps(event);" placeholder="<?php echo $gm_background_color_opacity_placeholder; ?>">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="tab-pane" id="control_settings">
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_title_style; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_direction_label_style_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <div class="input-icon right">
                                             <select name="ux_txt_direction_label_style[]" id="ux_ddl_direction_label_style_size" class="form-control custom-input-medium">
                                                <?php
                                                for ($font_size = 1; $font_size <= 200; $font_size++) {
                                                   ?>
                                                   <option value="<?php echo $font_size; ?>"><?php echo $font_size . "px"; ?></option>
                                                   <?php
                                                }
                                                ?>
                                             </select>
                                             <input type="text" class="form-control custom-input-medium" name="ux_txt_direction_label_style[]" id="ux_txt_direction_label_style_color" placeholder="<?php echo $gm_marker_font_color_placeholder; ?>" value="<?php echo isset($direction_label_style[1]) ? esc_attr($direction_label_style[1]) : "#000000"; ?>" onblur="default_value_google_maps('#ux_txt_direction_label_style_color', '#000000');" onfocus="google_map_color_picker('#ux_txt_direction_label_style_color', this.value);">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_font_family; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_direction_label_font_family_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <select name="ux_ddl_direction_label_font_family" id="ux_ddl_direction_label_font_family" class="form-control">
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
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_directions_input_field_height_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <input type="text" name="ux_txt_input_field_height" id="ux_txt_input_field_height" class="form-control" placeholder="<?php echo $gm_input_field_height_placeholder; ?>" value="<?php echo isset($details_directions["directions_input_field_height"]) ? intval($details_directions["directions_input_field_height"]) : 40; ?>" maxlength="4" onblur="default_value_google_maps('#ux_txt_input_field_height', 40);" onkeypress="only_digits_google_maps(event);">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_input_field_width; ?>
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_directions_input_field_width_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <input type="text" name="ux_txt_input_field_width" id="ux_txt_input_field_width" class="form-control" placeholder="<?php echo $gm_input_field_width_placeholder; ?>" value="<?php echo isset($details_directions["directions_input_field_width"]) ? intval($details_directions["directions_input_field_width"]) : 50; ?>"  maxlength="3" onblur="default_value_google_maps('#ux_txt_input_field_width', 100, 'width');" onkeypress="only_digits_google_maps(event);">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_input_field_text_style; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_input_field_text_style_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <div class="input-icon right">
                                             <select name="ux_txt_direction_input_field_text_style[]" id="ux_ddl_direction_input_field_text_style_size" class="form-control custom-input-medium">
                                                <?php
                                                for ($font_size = 1; $font_size <= 200; $font_size++) {
                                                   ?>
                                                   <option value="<?php echo $font_size; ?>"><?php echo $font_size . "px"; ?></option>
                                                   <?php
                                                }
                                                ?>
                                             </select>
                                             <input type="text" class="form-control custom-input-medium" name="ux_txt_direction_input_field_text_style[]" id="ux_txt_direction_input_field_text_style_color" placeholder="<?php echo $gm_marker_font_color_placeholder; ?>" value="<?php echo isset($direction_input_field_text_style[1]) ? esc_attr($direction_input_field_text_style[1]) : "#000000"; ?>" onblur="default_value_google_maps('#ux_txt_direction_input_field_text_style_color', '#000000');" onfocus="google_map_color_picker('#ux_txt_direction_input_field_text_style_color', this.value);">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_input_field_font_family; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_input_field_font_family_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <select name="ux_ddl_direction_input_field_font_family" id="ux_ddl_direction_input_field_font_family" class="form-control">
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
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_direction_input_field_background_color_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <input type="text" class="form-control" name="ux_txt_direction_input_field_background_color" id="ux_txt_direction_input_field_background_color" value="<?php echo isset($details_directions["directions_input_field_background_color"]) ? esc_attr($details_directions["directions_input_field_background_color"]) : "#ffffff"; ?>" onblur="default_value_google_maps('#ux_txt_direction_input_field_background_color', '#ffffff');" onfocus="google_map_color_picker('#ux_txt_direction_input_field_background_color', this.value);" placeholder="<?php echo $gm_background_color_placeholder; ?>">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_shortcode_direction_input_field_background_opacity; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_direction_input_field_background_opacity_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <input type="text" class="form-control" name="ux_txt_direction_input_field_background_color_opacity" id="ux_txt_direction_input_field_background_color_opacity" onfocus="paste_prevent_google_maps(this.id);" value="<?php echo isset($details_directions["directions_input_field_background_opacity"]) ? intval($details_directions["directions_input_field_background_opacity"]) : 75; ?>" maxlength="3" onblur="default_value_google_maps('#ux_txt_direction_input_field_background_color_opacity', '75', 'width');" onkeypress="only_digits_google_maps(event);" placeholder="<?php echo $gm_background_color_opacity_placeholder; ?>">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_input_field_margin; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_directions_input_field_margin_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <div>
                                             <input type="text" name="ux_txt_input_field_margin[]" id="ux_txt_input_field_top_margin" placeholder="<?php echo $gm_top; ?>" class="form-control custom-input-xsmall input-inline valid" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_input_field_top_margin', '0');" value="<?php echo isset($directions_input_field_margin[0]) ? intval($directions_input_field_margin[0]) : 0; ?>" maxlength="3" aria-invalid="false">
                                             <input type="text" name="ux_txt_input_field_margin[]" id="ux_txt_input_field_right_margin" placeholder="<?php echo $gm_right; ?>" class="form-control custom-input-xsmall input-inline valid" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_input_field_right_margin', '0');" value="<?php echo isset($directions_input_field_margin[1]) ? intval($directions_input_field_margin[1]) : 0; ?>" maxlength="3" aria-invalid="false">
                                             <input type="text" name="ux_txt_input_field_margin[]" id="ux_txt_input_field_bottom_margin" placeholder="<?php echo $gm_bottom; ?>" class="form-control custom-input-xsmall input-inline valid" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_input_field_bottom_margin', '10');" value="<?php echo isset($directions_input_field_margin[2]) ? intval($directions_input_field_margin[2]) : 10; ?>" maxlength="3" aria-invalid="false">
                                             <input type="text" name="ux_txt_input_field_margin[]" id="ux_txt_input_field_left_margin" placeholder="<?php echo $gm_left; ?>" class="form-control custom-input-xsmall input-inline valid" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_input_field_left_margin', '0');" value="<?php echo isset($directions_input_field_margin[3]) ? intval($directions_input_field_margin[3]) : 0; ?>" maxlength="3" aria-invalid="false">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_input_field_padding; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_directions_input_field_padding_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <div>
                                             <input type="text" name="ux_txt_input_field_padding[]" id="ux_txt_input_field_top_padding" placeholder="<?php echo $gm_top; ?>" class="form-control custom-input-xsmall input-inline valid" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_input_field_top_padding', '0');" value="<?php echo isset($directions_input_field_padding[0]) ? intval($directions_input_field_padding[0]) : 10; ?>" maxlength="3" aria-invalid="false">
                                             <input type="text" name="ux_txt_input_field_padding[]" id="ux_txt_input_field_right_padding" placeholder="<?php echo $gm_right; ?>" class="form-control custom-input-xsmall input-inline valid" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_input_field_right_padding', '0');" value="<?php echo isset($directions_input_field_padding[1]) ? intval($directions_input_field_padding[1]) : 0; ?>" maxlength="3" aria-invalid="false">
                                             <input type="text" name="ux_txt_input_field_padding[]" id="ux_txt_input_field_bottom_padding" placeholder="<?php echo $gm_bottom; ?>" class="form-control custom-input-xsmall input-inline valid" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_input_field_bottom_padding', '0');" value="<?php echo isset($directions_input_field_padding[2]) ? intval($directions_input_field_padding[2]) : 10; ?>" maxlength="3" aria-invalid="false">
                                             <input type="text" name="ux_txt_input_field_padding[]" id="ux_txt_input_field_left_padding" placeholder="<?php echo $gm_left; ?>" class="form-control custom-input-xsmall input-inline valid" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_input_field_left_padding', '0');" value="<?php echo isset($directions_input_field_padding[3]) ? intval($directions_input_field_padding[3]) : 0; ?>" maxlength="3" aria-invalid="false">
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_directions_input_field_from; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_directions_input_field_from_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <input type="text" name="ux_txt_directions_placeholder_from" id="ux_txt_directions_placeholder_from" class="form-control" placeholder="<?php echo $gm_directions_input_field_from_placeholder; ?>" value="<?php echo isset($details_directions["input_field_placeholder_from"]) ? esc_attr($details_directions["input_field_placeholder_from"]) : ""; ?>">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_directions_input_field_to; ?>
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_directions_input_field_to_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <input type="text" name="ux_txt_directions_to" id="ux_txt_directions_to" class="form-control" placeholder="<?php echo $gm_directions_input_field_to_placeholder; ?>" value="<?php echo isset($details_directions["input_field_placeholder_to"]) ? esc_attr($details_directions["input_field_placeholder_to"]) : ""; ?>">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_default_mode; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_default_mode_tooltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                    </label>
                                    <select class="form-control" name="ux_ddl_directions_default_mode" id="ux_ddl_directions_default_mode">
                                       <option value="driving"><?php echo $gm_driving; ?></option>
                                       <option value="walking"><?php echo $gm_walking; ?></option>
                                       <option value="bicycling"><?php echo $gm_bicycling; ?></option>
                                       <option value="transit"><?php echo $gm_transit; ?></option>
                                    </select>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_input_field_style; ?>
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_input_field_style_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">*<?php echo"( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <select class="form-control custom-input-medium" name="ux_txt_input_field_style[]" id="ux_ddl_input_field_size">
                                             <?php
                                             for ($font_size = 1; $font_size <= 200; $font_size++) {
                                                ?>
                                                <option value="<?php echo $font_size; ?>"><?php echo $font_size . "px"; ?></option>
                                                <?php
                                             }
                                             ?>
                                          </select>
                                          <input type="text" class="form-control custom-input-medium" name="ux_txt_input_field_style[]" id="ux_txt_input_style_color" onblur="default_value_google_maps('#ux_txt_input_style_color', '#000000');" onfocus="google_map_color_picker('#ux_txt_input_style_color', this.value);" placeholder="Please choose Background Color" aria-invalid="false" value="<?php echo isset($directions_input_field_placeholder_style[1]) ? esc_attr($directions_input_field_placeholder_style[1]) : "#000000"; ?>">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_input_field_style_font_family; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_input_field_font_family_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <select name="ux_ddl_direction_input_field_placeholder_font_family" id="ux_ddl_direction_input_field_placeholder_font_family" class="form-control">
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
                                             <?php echo $gm_shortcode_line_color; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_direction_line_color_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <input type="text" class="form-control" name="ux_txt_direction_line_color" id="ux_txt_direction_line_color" value="<?php echo isset($details_directions["directions_line_color"]) ? esc_attr($details_directions["directions_line_color"]) : "#000000"; ?>" onfocus="google_map_color_picker('#ux_txt_direction_line_color', this.value);" onblur="default_value_google_maps('#ux_txt_direction_line_color', '#000000');" placeholder="<?php echo $gm_line_color_placeholder; ?>">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_shortcode_direction_line_color_opacity; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_direction_line_color_opacity_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <input type="text" class="form-control" name="ux_txt_direction_line_color_opacity" onfocus="paste_prevent_google_maps(this.id);" id="ux_txt_direction_line_color_opacity" value="<?php echo isset($details_directions["directions_line_color_opacity"]) ? intval($details_directions["directions_line_color_opacity"]) : 75; ?>" maxlength="3" onkeypress="only_digits_google_maps(event);" placeholder="<?php echo $gm_line_color_opacity_placeholder; ?>" onblur="default_value_google_maps('#ux_txt_direction_line_color_opacity', '75', 'width');">
                                       </div>
                                    </div>
                                 </div>
                                 <div>
                                    <div class="form-group">
                                       <label class="control-label">
                                          <?php echo $gm_direction_show_default_location; ?>
                                          <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_direction_show_default_location_tooltips; ?>" data-placement="right"></i>
                                          <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                       </label>
                                       <select name="ux_ddl_direction" id="ux_ddl_direction" class="form-control" onchange="show_default_location_google_maps('#ux_ddl_direction', 'ux_div_default_location_direction');" >
                                          <option value="enable"><?php echo $gm_enable; ?></option>
                                          <option value="disable"><?php echo $gm_disable; ?></option>
                                       </select>
                                    </div>
                                    <div id="ux_div_default_location_direction" style="display:none !important;">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_direction_show_details; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_direction_show_details_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <div class="row" style="margin-top:10px;">
                                             <div class="col-md-3">
                                                <input type="radio" name="ux_chk_direction_formatted_address" id="ux_chk_formatted_address" value="formatted_address"  onclick="choose_address_type_google_maps('formatted_address', '#ux_div_map_address', '#ux_div_latitude_longitude');" <?php echo isset($details_directions["direction_address_type"]) && esc_attr($details_directions["direction_address_type"]) == "formatted_address" ? "checked = checked" : (!isset($details_directions["direction_address_type"]) ? "checked = checked" : ""); ?>>
                                                <?php echo $gm_formatted_address; ?>
                                             </div>
                                             <div class="col-md-3">
                                                <input type="radio" name="ux_chk_direction_formatted_address" id="ux_chk_by_latitude_longitude" value="latitude_longitude" onclick="choose_address_type_google_maps('latitude_longitude', '#ux_div_map_address', '#ux_div_latitude_longitude');" <?php echo isset($details_directions["direction_address_type"]) && esc_attr($details_directions["direction_address_type"]) == "latitude_longitude" ? "checked = checked" : ""; ?>>
                                                <?php echo $gm_by_latitude_longitude; ?>
                                             </div>
                                          </div>
                                       </div>
                                       <div id="ux_div_map_address">
                                          <div class="form-group">
                                             <label class="control-label">
                                                <?php echo $gm_add_map_address; ?> :
                                                <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_add_map_address_tooltips; ?>" data-placement="right"></i>
                                                <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                             </label>
                                             <input type="text" class="form-control" name="ux_txt_address" id="ux_txt_address" value="<?php echo isset($details_directions["direction_address"]) ? esc_html($details_directions["direction_address"]) : ""; ?>" placeholder="<?php echo $gm_add_map_address_placeholder; ?>">
                                          </div>
                                       </div>
                                       <div id="ux_div_latitude_longitude" >
                                          <div class="row">
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label class="control-label">
                                                      <?php echo $gm_map_latitude; ?> :
                                                      <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_add_map_latitude_tooltips; ?>" data-placement="right"></i>
                                                      <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                                   </label>
                                                   <input type="text" class="form-control ux_txt_latitude" name="ux_txt_latitude" id="ux_txt_latitude" value="<?php echo isset($details_directions["direction_latitude"]) ? floatval($details_directions["direction_latitude"]) : ""; ?>" placeholder="<?php echo $gm_add_map_latitude_placeholder; ?>" >
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label class="control-label">
                                                      <?php echo $gm_map_longitude; ?> :
                                                      <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_add_map_longitude_tooltips; ?>" data-placement="right"></i>
                                                      <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                                   </label>
                                                   <input type="text" class="form-control ux_txt_longitude" name="ux_txt_longitude" id="ux_txt_longitude" value="<?php echo isset($details_directions["direction_longitude"]) ? floatval($details_directions["direction_longitude"]) : ""; ?>" placeholder="<?php echo $gm_add_map_longitude_placeholder; ?>">
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label">
                                          <?php echo $gm_direction_show_to_default_location; ?>
                                          <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_direction_show_to_default_location_tooltips; ?>" data-placement="right"></i>
                                          <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                       </label>
                                       <select name="ux_ddl_default_location_to" id="ux_ddl_default_location_to" class="form-control" onchange="show_default_location_google_maps('#ux_ddl_default_location_to', 'ux_div_default_location_direction_to');">
                                          <option value="enable"><?php echo $gm_enable; ?></option>
                                          <option value="disable"><?php echo $gm_disable; ?></option>
                                       </select>
                                    </div>
                                 </div>
                                 <div id="ux_div_default_location_direction_to" style="display:none;">
                                    <div class="form-group">
                                       <label class="control-label">
                                          <?php echo $gm_direction_show_details; ?> :
                                          <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_direction_show_details_tooltips; ?>" data-placement="right"></i>
                                          <span class="required" aria-required="true">*<?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                       </label>
                                       <div class="row" style="margin-top:10px;">
                                          <div class="col-md-3">
                                             <input type="radio" name="ux_chk_direction_formatted_address_to" id="ux_chk_formatted_address" value="formatted_address"  onclick="choose_address_type_google_maps('formatted_address', '#ux_div_map_address_to', '#ux_div_latitude_longitude_to');" <?php echo isset($details_directions["direction_address_type_to"]) && esc_attr($details_directions["direction_address_type_to"]) == "formatted_address" ? "checked = checked" : (!isset($details_directions["direction_address_type_to"]) ? "checked = checked" : ""); ?>>
                                             <?php echo $gm_formatted_address; ?>
                                          </div>
                                          <div class="col-md-3">
                                             <input type="radio" name="ux_chk_direction_formatted_address_to" id="ux_chk_by_latitude_longitude" value="latitude_longitude" onclick="choose_address_type_google_maps('latitude_longitude', '#ux_div_map_address_to', '#ux_div_latitude_longitude_to');" <?php echo isset($details_directions["direction_address_type_to"]) && esc_attr($details_directions["direction_address_type_to"]) == "latitude_longitude" ? "checked = checked" : ""; ?>>
                                             <?php echo $gm_by_latitude_longitude; ?>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group" id="ux_div_map_address_to">
                                       <label class="control-label">
                                          <?php echo $gm_add_map_address; ?> :
                                          <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_add_map_address_tooltips; ?>" data-placement="right"></i>
                                          <span class="required" aria-required="true">*<?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                       </label>
                                       <input type="text" class="form-control" name="ux_txt_marker_address" id="ux_txt_marker_address" value="<?php echo isset($details_directions["direction_address_to"]) ? esc_html($details_directions["direction_address_to"]) : ""; ?>" placeholder="<?php echo $gm_add_map_address_placeholder; ?>">
                                    </div>
                                    <div id="ux_div_latitude_longitude_to" style="display:none;" >
                                       <div class="row">
                                          <div class="col-md-6">
                                             <div class="form-group">
                                                <label class="control-label">
                                                   <?php echo $gm_map_latitude; ?> :
                                                   <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_add_map_latitude_tooltips; ?>" data-placement="right"></i>
                                                   <span class="required" aria-required="true">*<?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                                </label>
                                                <input type="text" class="form-control ux_txt_latitude" name="ux_txt_marker_latitude" id="ux_txt_marker_latitude"  value="<?php echo isset($details_directions["direction_latitude_to"]) ? floatval($details_directions["direction_latitude_to"]) : ""; ?>" placeholder="<?php echo $gm_add_map_latitude_placeholder; ?>">
                                             </div>
                                          </div>
                                          <div class="col-md-6">
                                             <div class="form-group">
                                                <label class="control-label">
                                                   <?php echo $gm_map_longitude; ?> :
                                                   <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_add_map_longitude_tooltips; ?>" data-placement="right"></i>
                                                   <span class="required" aria-required="true">*<?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                                </label>
                                                <input type="text" class="form-control ux_txt_longitude" name="ux_txt_marker_longitude" id="ux_txt_marker_longitude" value="<?php echo isset($details_directions["direction_longitude_to"]) ? floatval($details_directions["direction_longitude_to"]) : ""; ?>" placeholder="<?php echo $gm_add_map_longitude_placeholder; ?>">
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
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_direction_button_height_and_width_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <div class="input-icon right">
                                             <input type="text" class="form-control custom-input-medium" name="ux_txt_direction_button_height_width[]" id="ux_txt_direction_button_height" placeholder="<?php echo $gm_height; ?>" maxlength="3" onkeypress="only_digits_google_maps(event);" value="<?php echo isset($direction_button_height_width[0]) ? intval($direction_button_height_width[0]) : 50; ?>" onblur="default_value_google_maps('#ux_txt_direction_button_height', '50', '');" onfocus="paste_prevent_google_maps(this.id);">
                                             <input type="text" class="form-control custom-input-medium" name="ux_txt_direction_button_height_width[]" id="ux_txt_direction_button_width" placeholder="<?php echo $gm_width; ?>" maxlength="3" onkeypress="only_digits_google_maps(event);" value="<?php echo isset($direction_button_height_width[1]) ? intval($direction_button_height_width[1]) : 100; ?>" onblur="default_value_google_maps('#ux_txt_direction_button_width', '100', '');" onfocus="paste_prevent_google_maps(this.id);">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_map_alignment; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_direction_button_alignment_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <select name="ux_ddl_direction_button_alignment" id="ux_ddl_direction_button_alignment" class="form-control">
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
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_direction_button_text_style_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <div class="input-icon right">
                                             <select name="ux_txt_direction_button_text_style[]" id="ux_ddl_direction_button_text_style_size" class="form-control custom-input-medium">
                                                <?php
                                                for ($font_size = 1; $font_size <= 200; $font_size++) {
                                                   ?>
                                                   <option value="<?php echo $font_size; ?>"><?php echo $font_size . "px"; ?></option>
                                                   <?php
                                                }
                                                ?>
                                             </select>
                                             <input type="text" class="form-control custom-input-medium" name="ux_txt_direction_button_text_style[]" id="ux_txt_direction_button_text_style_color" placeholder="<?php echo $gm_marker_font_color_placeholder; ?>" value="<?php echo isset($direction_button_text_style[1]) ? esc_attr($direction_button_text_style[1]) : "#ffffff"; ?>" onblur="default_value_google_maps('#ux_txt_direction_button_text_style_color', '#ffffff');" onfocus="google_map_color_picker('#ux_txt_direction_button_text_style_color', this.value);">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_text_font_family; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_direction_button_text_font_family_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <select name="ux_ddl_direction_button_text_font_family" id="ux_ddl_direction_button_text_font_family" class="form-control">
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
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_direction_button_background_color_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <input type="text" class="form-control" name="ux_txt_direction_button_background_color" id="ux_txt_direction_button_background_color" value="<?php echo isset($details_directions["directions_button_background_color"]) ? esc_attr($details_directions["directions_button_background_color"]) : "#a4cd39"; ?>" onblur="default_value_google_maps('#ux_txt_direction_button_background_color', '#a4cd39');" onfocus="google_map_color_picker('#ux_txt_direction_button_background_color', this.value);" placeholder="<?php echo $gm_background_color_placeholder; ?>">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_background_opacity; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_direction_button_background_opacity_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <input type="text" class="form-control" name="ux_txt_direction_button_background_opacity" id="ux_txt_direction_button_background_opacity" onfocus="paste_prevent_google_maps(this.id);" value="<?php echo isset($details_directions["directions_button_background_color_opacity"]) ? intval($details_directions["directions_button_background_color_opacity"]) : 75; ?>" maxlength="3" onblur="default_value_google_maps('#ux_txt_direction_button_background_opacity', '75', 'width');" onkeypress="only_digits_google_maps(event);" placeholder="<?php echo $gm_background_color_opacity_placeholder; ?>">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="tab-pane" id="text_directions_settings">
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_text_direction_width; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_text_direction_width_tootltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                    </label>
                                    <input type="text" name="ux_txt_text_direction_width" id="ux_txt_text_direction_width" class="form-control" maxlength="3" onblur="default_value_google_maps('#ux_txt_text_direction_width', 100, 'width');"  placeholder="<?php echo $gm_text_direction_width_placeholder; ?>" value="<?php echo isset($details_directions["text_direction_width"]) ? intval($details_directions["text_direction_width"]) : 100; ?>" onkeypress="only_digits_google_maps(event);">
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_style; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_text_direction_style_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <div class="input-icon right">
                                             <select name="ux_txt_text_direction_style[]" id="ux_ddl_text_direction_size" class="form-control custom-input-medium">
                                                <?php
                                                for ($font_size = 1; $font_size <= 200; $font_size++) {
                                                   ?>
                                                   <option value="<?php echo $font_size; ?>"><?php echo $font_size . "px"; ?></option>
                                                   <?php
                                                }
                                                ?>
                                             </select>
                                             <input type="text" class="form-control custom-input-medium" name="ux_txt_text_direction_style[]" id="ux_txt_text_direction_style_color" placeholder="<?php echo $gm_marker_font_color_placeholder; ?>" value="<?php echo isset($text_direction_style[1]) ? esc_attr($text_direction_style[1]) : "#000000"; ?>" onblur="default_value_google_maps('#ux_txt_text_direction_style_color', '#000000');" onfocus="google_map_color_picker('#ux_txt_text_direction_style_color', this.value);">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_text_font_family; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_text_direction_font_family_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <select name="ux_ddl_text_direction_font_family" id="ux_ddl_text_direction_font_family" class="form-control">
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
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_text_direction_background_color_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <input type="text" class="form-control" name="ux_txt_text_direction_background_color" id="ux_txt_text_direction_background_color" value="<?php echo isset($details_directions["directions_display_background_color"]) ? esc_attr($details_directions["directions_display_background_color"]) : "#ffffff"; ?>" onblur="default_value_google_maps('#ux_txt_text_direction_background_color', '#ffffff');" onfocus="google_map_color_picker('#ux_txt_text_direction_background_color', this.value);" placeholder="<?php echo $gm_background_color_placeholder; ?>">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_background_opacity; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_text_direction_background_opacity_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <input type="text" class="form-control" name="ux_txt_text_direction_background_opacity" id="ux_txt_text_direction_background_opacity"  onfocus="paste_prevent_google_maps(this.id);" value='<?php echo isset($details_directions["directions_display_background_color_opacity"]) ? intval($details_directions["directions_display_background_color_opacity"]) : 75; ?>' maxlength="3" onkeypress="only_digits_google_maps(event);" onblur="default_value_google_maps('#ux_txt_text_direction_background_opacity', '100', 'width');" placeholder="<?php echo $gm_background_color_opacity_placeholder; ?>">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_border_style; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_text_direction_border_style_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <div class="input-icon right">
                                             <input type="text" class="form-control input-width-25 input-inline" name="ux_txt_text_direction_border_style[]" id="ux_direction_input_field_border_style" onfocus="paste_prevent_google_maps(this.id);" placeholder="<?php echo $gm_width; ?>"  maxlength="3" onkeypress="only_digits_google_maps(event);" onblur="default_value_google_maps('#ux_direction_input_field_border_style', '0');" value="<?php echo isset($direction_display_border_style[0]) ? intval($direction_display_border_style[0]) : 0; ?>">
                                             <select id="ux_ddl_text_direction_border_style_size" name="ux_txt_text_direction_border_style[]" class="form-control input-width-25 input-inline">
                                                <option value="none"><?php echo $gm_none; ?></option>
                                                <option value="solid"><?php echo $gm_solid; ?></option>
                                                <option value="dotted"><?php echo $gm_dotted; ?></option>
                                                <option value="dashed"><?php echo $gm_dashed; ?></option>
                                             </select>
                                             <input type="text" class="form-control input-normal input-inline" name="ux_txt_text_direction_border_style[]" id="ux_txt_text_direction_border_style_color" placeholder="<?php echo $gm_marker_font_color_placeholder; ?>" value="<?php echo isset($direction_display_border_style[2]) ? esc_attr($direction_display_border_style[2]) : "#a4cd39"; ?>" onfocus="google_map_color_picker('#ux_txt_text_direction_border_style_color', this.value);" onblur="default_value_google_maps('#ux_txt_text_direction_border_style_color', '#a4cd39');">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_border_radius; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_text_direction_border_radius_tooltip; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo "( " . $gm_premium_edition_label . " )" ?></span>
                                          </label>
                                          <input type="text" class="form-control" name="ux_txt_text_direction_border_radius" id="ux_txt_text_direction_border_radius" onfocus="paste_prevent_google_maps(this.id);" value="<?php echo isset($details_directions["directions_display_border_radius"]) ? intval($details_directions["directions_display_border_radius"]) : 0; ?>" maxlength="3" onkeypress="only_digits_google_maps(event);" onblur="default_value_google_maps('#ux_txt_text_direction_border_radius', '0');" placeholder="<?php echo $gm_border_radius_placeholder; ?>">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="line-separator"></div>
                              <div class="form-actions">
                                 <div class="pull-right">
                                    <input type="submit" class="btn vivid-green" name="ux_btn_directions_settings" id="ux_btn_directions_settings" value="<?php echo $gm_save_changes; ?>">
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
               <a href="admin.php?page=gmb_info_window">
                  <?php echo $gm_layout_settings; ?>
               </a>
               <span>></span>
            </li>
            <li>
               <span>
                  <?php echo $gm_directions; ?>
               </span>
            </li>
         </ul>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="portlet box vivid-green">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="icon-custom-directions"></i>
                     <?php echo $gm_directions; ?>
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