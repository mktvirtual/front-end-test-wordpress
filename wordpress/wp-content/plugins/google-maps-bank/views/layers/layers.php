<?php
/**
 * This Template is used for adding layers.
 *
 * @author  Tech Banker
 * @package google-maps-bank/views/layers
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
   } else if (layers_google_map == "1") {
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
               <span>
                  <?php echo $gm_layers; ?>
               </span>
            </li>
         </ul>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="portlet box vivid-green">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="icon-custom-layers"></i>
                     <?php echo $gm_layers; ?>
                  </div>
                  <a href="http://beta.tech-banker.com/products/google-maps-bank/" target="_blank" class="premium-editions"><?php echo $mb_upgrade_to ?></a>
               </div>
               <div class="portlet-body form">
                  <form id="ux_frm_add_layers">
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
                        <div style="max-height:350px; display:none; margin-bottom: 4%;" id="ux_map_canvas">
                           <div id="ux_div_map_canvas" class="map_canvas"></div>
                           <div class="line-separator"></div>
                        </div>
                        <div class="form-group">
                           <label class="control-label">
                              <?php echo $gm_choose_map; ?> :
                              <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_choose_add_layers_tooltips; ?>" data-placement="right"></i>
                              <span class="required" aria-required="true">*</span>
                           </label>
                           <select name="ux_ddl_choose_map" id="ux_ddl_choose_map" class="form-control" onchange="get_url_google_maps('#ux_ddl_choose_map', '', 'gmb_layers');">
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
                        <div id="ux_div_ddl_choose_map" style="display:none;">
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_enable_bicycling_layer; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_enable_bicycling_layer_tooltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " )"; ?></span>
                                    </label>
                                    <select name="ux_ddl_enable_bicycling_layer" id="ux_ddl_enable_bicycling_layer" class="form-control">
                                       <option value="hide"><?php echo $gm_hide; ?></option>
                                       <option value="show"><?php echo $gm_show; ?></option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_enable_traffic_layer; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_enable_traffic_layer_tooltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " )"; ?></span>
                                    </label>
                                    <select name="ux_ddl_enable_traffic_layer" id="ux_ddl_enable_traffic_layer" class="form-control">
                                       <option value="hide"><?php echo $gm_hide; ?></option>
                                       <option value="show"><?php echo $gm_show; ?></option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_enable_transit_layer; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_enable_transit_layer_tooltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " )"; ?></span>
                                    </label>
                                    <select name="ux_ddl_enable_transit_layer" id="ux_ddl_enable_transit_layer" class="form-control">
                                       <option value="hide"><?php echo $gm_hide; ?></option>
                                       <option value="show"><?php echo $gm_show; ?></option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_enable_heatmap_layer; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_enable_heatmap_layer_tooltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " )"; ?></span>
                                    </label>
                                    <select name="ux_ddl_enable_heatmap_layer" id="ux_ddl_enable_heatmap_layer" class="form-control" onchange="show_hide_controls_google_maps('#ux_ddl_enable_heatmap_layer', '#ux_div_enable_heatmap_layer');">
                                       <option value="hide"><?php echo $gm_hide; ?></option>
                                       <option value="show"><?php echo $gm_show; ?></option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div id="ux_div_enable_heatmap_layer" style="display:none;">
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_heatmap_gradient_color; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_heatmap_gradient_color_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " )"; ?></span>
                                 </label>
                                 <select name="ux_ddl_enable_gradient_heatmap" id="ux_ddl_enable_gradient_heatmap" class="form-control">
                                    <option value="hide"><?php echo $gm_hide; ?></option>
                                    <option value="show"><?php echo $gm_show; ?></option>
                                 </select>
                              </div>
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_heatmap_coordinates; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_heatmap_coordinates_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " )"; ?></span>
                                 </label>
                                 <textarea class="form-control" name="ux_txt_coordinates" id="ux_txt_coordinates" rows="4"  placeholder="<?php echo $gm_heatmap_coordinates_placeholder; ?>"><?php echo isset($layers_data_unserialized["heatmap_coordinates"]) ? esc_attr($layers_data_unserialized["heatmap_coordinates"]) : ""; ?></textarea>
                              </div>
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="control-label">
                                          <?php echo $gm_heatmap_opacity; ?> :
                                          <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_heatmap_opacity_tooltips; ?>" data-placement="right"></i>
                                          <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " )"; ?></span>
                                       </label>
                                       <input type="text" class="form-control" name="ux_txt_heatmap_opacity" id="ux_txt_heatmap_opacity" maxlength="3" value="<?php echo isset($layers_data_unserialized["heatmap_opacity"]) ? intval($layers_data_unserialized["heatmap_opacity"]) : 75; ?>" placeholder="<?php echo $gm_heatmap_opacity_placeholder; ?>" onblur="default_value_google_maps('#ux_txt_heatmap_opacity', '75', 'width');" onkeypress="only_digits_google_maps(event);">
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="control-label">
                                          <?php echo $gm_heatmap_radius; ?> :
                                          <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_heatmap_radius_tooltips; ?>" data-placement="right"></i>
                                          <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " )"; ?></span>
                                       </label>
                                       <input type="text" class="form-control" name="ux_txt_heatmap_radius" id="ux_txt_heatmap_radius" maxlength="3" value="<?php echo isset($layers_data_unserialized["heatmap_radius"]) ? intval($layers_data_unserialized["heatmap_radius"]) : 20; ?>" placeholder="<?php echo $gm_heatmap_radius_placeholder; ?>" onblur="default_value_google_maps('#ux_txt_heatmap_radius', '20', 'width');" onkeypress="only_digits_google_maps(event)" onfocus="paste_prevent_google_maps(this.id);">
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="control-label">
                                 <?php echo $gm_enable_fusion_table_layer; ?> :
                                 <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_enable_fusion_table_tooltips; ?>" data-placement="right"></i>
                                 <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " )"; ?></span>
                              </label>
                              <select name="ux_ddl_enable_fusion_table_layer" id="ux_ddl_enable_fusion_table_layer" class="form-control" onChange="show_hide_controls_google_maps('#ux_ddl_enable_fusion_table_layer', '#ux_div_enable_fusion_table_layer');">
                                 <option value="hide"><?php echo $gm_hide; ?></option>
                                 <option value="show"><?php echo $gm_show; ?></option>
                              </select>
                           </div>
                           <div class="form-group" id="ux_div_enable_fusion_table_layer">
                              <label class="control-label">
                                 <?php echo $gm_fusion_table_id; ?> :
                                 <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_fusion_table_id_tooltips; ?>" data-placement="right"></i>
                                 <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " )"; ?></span>
                              </label>
                              <input type="text" class="form-control" name="ux_txt_fusion_table_id" id="ux_txt_fusion_table_id" value="<?php echo isset($layers_data_unserialized["fusion_table_id"]) ? esc_attr($layers_data_unserialized["fusion_table_id"]) : ""; ?>" placeholder="<?php echo $gm_fusion_table_id_placeholder; ?>">
                           </div>
                           <div class="form-group">
                              <label class="control-label">
                                 <?php echo $gm_enable_kml_layer; ?> :
                                 <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_enable_kml_layer_tooltips; ?>" data-placement="right"></i>
                                 <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " )"; ?></span>
                              </label>
                              <select name="ux_ddl_enable_kml_layer" id="ux_ddl_enable_kml_layer" class="form-control" onchange="show_hide_controls_google_maps('#ux_ddl_enable_kml_layer', '#ux_div_enable_kml_layer');">
                                 <option value="hide"><?php echo $gm_hide; ?></option>
                                 <option value="show"><?php echo $gm_show; ?></option>
                              </select>
                           </div>
                           <div id="ux_div_enable_kml_layer" style="display:none;">
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_kml_url; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_kml_url_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " )"; ?></span>
                                 </label>
                                 <input type="text" class="form-control" name="ux_txt_kml_url" id="ux_txt_kml_url" value="<?php echo isset($layers_data_unserialized["kml_url"]) ? esc_attr($layers_data_unserialized["kml_url"]) : ""; ?>" placeholder="<?php echo $gm_kml_url_placeholder; ?>">
                              </div>
                           </div>
                        </div>
                        <div class="line-separator"></div>
                        <div class="form-actions">
                           <div class="pull-right">
                              <input type="submit" class="btn vivid-green" name="ux_btn_add_layer" id="ux_btn_add_layer" value="<?php echo $gm_save_changes; ?>">
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
               <span>
                  <?php echo $gm_layers; ?>
               </span>
            </li>
         </ul>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="portlet box vivid-green">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="icon-custom-layers"></i>
                     <?php echo $gm_layers; ?>
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