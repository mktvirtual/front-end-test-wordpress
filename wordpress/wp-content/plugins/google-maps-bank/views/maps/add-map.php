<?php
/**
 * This Template is used for add maps.
 *
 * @author  Tech Banker
 * @package google-maps-bank/views/maps
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
   } else if (map_settings_google_map == "1") {
      $google_maps_delete_nonce = wp_create_nonce("google_maps_delete_nonce");
      $google_maps_add_maps_nonce = wp_create_nonce("google_maps_add_maps_nonce");
      $google_maps_add_marker_nonce = wp_create_nonce("google_maps_add_marker_nonce");
      $google_maps_polygon_nonce = wp_create_nonce("google_maps_polygon_nonce");
      $google_maps_add_polyline_nonce = wp_create_nonce("google_maps_add_polyline_nonce");
      $google_map_add_circle_nonce = wp_create_nonce("google_map_add_circle_nonce");
      $add_maps_layers_nonce = wp_create_nonce("add_maps_layers_nonce");
      $rectangle_color_and_opacity = explode(",", isset($serialize_rectangle_edit_data["stroke_color_and_opacity"]) ? esc_attr($serialize_rectangle_edit_data["stroke_color_and_opacity"]) : "#000000,75");
      $rectangle_fill_color_and_opacity = explode(",", isset($serialize_rectangle_edit_data["fill_color_and_opacity"]) ? esc_attr($serialize_rectangle_edit_data["fill_color_and_opacity"]) : "#000000,75");
      $mapid = isset($_REQUEST["google_map_id"]) ? "&google_map_id=" . $_REQUEST["google_map_id"] : "";
      $polygon_stroke_color_style = isset($serialize_polygon_edit_data["polygon_stroke_color_style"]) ? explode(",", esc_attr($serialize_polygon_edit_data["polygon_stroke_color_style"])) : "";
      $polygon_fill_color_style = isset($serialize_polygon_edit_data["polygon_fill_color_style"]) ? explode(",", esc_attr($serialize_polygon_edit_data["polygon_fill_color_style"])) : "";
      $polyline_stroke_color = isset($serialize_polyline_edit_data["polyline_stroke_color_opacity"]) ? explode(",", esc_attr($serialize_polyline_edit_data["polyline_stroke_color_opacity"])) : "";
      $gmb_circle_stroke_color = isset($serialize_circle_edit_data["circle_stroke_color"]) ? explode(",", esc_attr($serialize_circle_edit_data["circle_stroke_color"])) : "";
      $gmb_circle_fill_color = isset($serialize_circle_edit_data["circle_fill_color"]) ? explode(",", esc_attr($serialize_circle_edit_data["circle_fill_color"])) : "";
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
               <a href="admin.php?page=gmb_google_maps">
                  <?php echo $gm_google_maps; ?>
               </a>
               <span>></span>
            </li>
            <li>
               <span>
                  <?php echo $gm_add_map; ?>
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
                     <?php echo $gm_add_map; ?>
                  </div>
                  <a href="http://beta.tech-banker.com/products/google-maps-bank/" target="_blank" class="premium-editions"><?php echo $mb_upgrade_to ?></a>
               </div>
               <div class="portlet-body form">
                  <div class="form-body">
                     <div class="form-wizard" id="ux_div_frm_wizard">
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
                        <ul class="nav nav-pills nav-justified steps">
                           <li class="active">
                              <a aria-expanded="true" href="javascript:void(0);" class="step">
                                 <span class="number"> 1 </span>
                                 <span class="desc"> <?php echo $gm_basic; ?> </span>
                              </a>
                           </li>
                           <li>
                              <a href="javascript:void(0);" class="step">
                                 <span class="number"> 2 </span>
                                 <span class="desc"><?php echo $gm_overlays; ?> </span>
                              </a>
                           </li>
                           <li>
                              <a href="javascript:void(0);" class="step">
                                 <span class="number"> 3 </span>
                                 <span class="desc"><?php echo $gm_layers; ?> </span>
                              </a>
                           </li>
                        </ul>
                     </div>
                     <div id="ux_div_step_progres_bar" class="progress progress-striped" role="progressbar">
                        <div id="ux_div_step_progres_bar_width" style="width: 33%;" class="progress-bar progress-bar-success"></div>
                     </div>
                     <div class="line-separator"></div>
                     <div id="ux_div_map_ability" style="margin-bottom: 4%;">
                        <div id="ux_div_map_canvas" class="map_canvas"></div>
                        <div class="line-separator"></div>
                     </div>
                     <div class="tab-content" id="maps_settings">
                        <form id="ux_frm_maps_settings">
                           <div id="ux_div_first_step_basic">
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_map_title; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_add_map_title_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*</span>
                                 </label>
                                 <input type="text" class="form-control" name="ux_txt_map_title" id="ux_txt_map_title" value="<?php echo isset($serialized_map_data["map_title"]) ? esc_attr($serialized_map_data["map_title"]) : ""; ?>" placeholder="<?php echo $gm_add_map_title_placeholder; ?>">
                              </div>
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_add_map_description; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_add_map_description_tooltips; ?>" data-placement="right"></i>
                                 </label>
                                 <textarea class="form-control" name="ux_txt_map_description" id="ux_txt_map_description" rows="4" placeholder="<?php echo $gm_add_map_description_placeholder; ?>"><?php echo isset($serialized_map_data["map_description"]) ? esc_html($serialized_map_data["map_description"]) : ""; ?></textarea>
                              </div>
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_map_type; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_map_type_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*</span>
                                 </label>
                                 <div class="row" style="margin-top:10px;">
                                    <div class="col-md-3">
                                       <input type="radio" name="ux_chk_map_formatted_address" id="ux_chk_formatted_address" value="formatted_address"  onclick="choose_address_type_google_maps('formatted_address', '#ux_div_map_address', '#ux_div_latitude_longitude');" <?php echo isset($serialized_map_data["map_address_type"]) && esc_attr($serialized_map_data["map_address_type"]) == "formatted_address" ? "checked = checked" : !isset($serialized_map_data["map_address_type"]) ? "checked = checked" : ""; ?>>
                                       <?php echo $gm_formatted_address; ?>
                                    </div>
                                    <div class="col-md-3">
                                       <input type="radio" name="ux_chk_map_formatted_address" id="ux_chk_by_latitude_longitude" value="latitude_longitude" onclick="choose_address_type_google_maps('latitude_longitude', '#ux_div_map_address', '#ux_div_latitude_longitude');" <?php echo isset($serialized_map_data["map_address_type"]) && esc_attr($serialized_map_data["map_address_type"]) == "latitude_longitude" ? "checked = checked" : ""; ?>>
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
                                    <input type="text" class="form-control" name="ux_txt_address" id="ux_txt_address" value="<?php echo isset($serialized_map_data["formatted_address"]) ? esc_html($serialized_map_data["formatted_address"]) : ""; ?>" placeholder="<?php echo $gm_add_map_address_placeholder; ?>">
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
                                          <input type="text" class="form-control ux_txt_latitude" name="ux_txt_latitude" id="ux_txt_latitude" value="<?php echo isset($serialized_map_data["map_latitude"]) ? floatval($serialized_map_data["map_latitude"]) : ""; ?>" placeholder="<?php echo $gm_add_map_latitude_placeholder; ?>" onblur="geocode_latitude_longitude_google_maps('map');">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_map_longitude; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_add_map_longitude_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">*</span>
                                          </label>
                                          <input type="text" class="form-control ux_txt_longitude" name="ux_txt_longitude" id="ux_txt_longitude" value="<?php echo isset($serialized_map_data["map_longitude"]) ? floatval($serialized_map_data["map_longitude"]) : ""; ?>" placeholder="<?php echo $gm_add_map_longitude_placeholder; ?>" onblur="geocode_latitude_longitude_google_maps('map');">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="control-label">
                                          <?php echo $gm_map_type; ?> :
                                          <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_add_map_type_tooltips; ?>" data-placement="right"></i>
                                          <span class="required" aria-required="true">*</span>
                                       </label>
                                       <select name="ux_ddl_map_type" id="ux_ddl_map_type" class="form-control" onchange="gmb_change_map_setting();">
                                          <option value="roadmap"><?php echo $gm_add_map_type_roadmap; ?></option>
                                          <option value="satellite"><?php echo $gm_add_map_type_satellite; ?></option>
                                          <option value="hybrid"><?php echo $gm_add_map_type_hybrid; ?></option>
                                          <option value="terrain"><?php echo $gm_add_map_type_terrain; ?></option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="control-label">
                                          <?php echo $gm_add_map_zoom_level; ?> :
                                          <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_add_map_zoom_level_tooltips; ?>" data-placement="right"></i>
                                          <span class="required" aria-required="true">*</span>
                                       </label>
                                       <select name="ux_ddl_map_zoom_level" id="ux_ddl_map_zoom_level" class="form-control" onchange="gmb_change_map_setting();">
                                          <?php
                                          for ($zoom_level = 0; $zoom_level <= 21; $zoom_level++) {
                                             ?>
                                             <option value="<?php echo $zoom_level; ?>"><?php echo $zoom_level; ?></option>
                                             <?php
                                          }
                                          ?>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="line-separator"></div>
                              <div class="form-actions">
                                 <div class="pull-right">
                                    <input type="submit" class="btn vivid-green" name="ux_btn_next_step_overlay" id="ux_btn_next_step_overlay" value="<?php echo $gm_next_step . ' >>'; ?>">
                                 </div>
                              </div>
                           </div>
                           <div id="ux_div_second_step_overlay" style="display:none">
                              <div id="ux_div_overlay_type">
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_overlays_type; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_overlays_type_tooltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">*</span>
                                    </label>
                                    <div class="row custom-top">
                                       <div class="col-md-2">
                                          <input type="radio" id="ux_chk_overlay_type_marker" checked="checked" class="ux_chk_overlay_type" name="ux_chk_overlay_type" value="marker" onclick="get_url_google_maps('<?php echo $mapid; ?>', 'marker', 'gmb_add_map');">
                                          <span class="ovelay_type">
                                             <?php echo $gm_marker; ?>
                                          </span>
                                       </div>
                                       <div class="col-md-2">
                                          <input type="radio" id="ux_chk_overlay_type_polygon" class="ux_chk_overlay_type" name="ux_chk_overlay_type" value="polygon" onclick="get_url_google_maps('<?php echo $mapid; ?>', 'polygon', 'gmb_add_map');">
                                          <span class="ovelay_type">
                                             <?php echo $gm_polygon; ?>
                                          </span>
                                       </div>
                                       <div class="col-md-2">
                                          <input type="radio" id="ux_chk_overlay_type_polyline" class="ux_chk_overlay_type" name="ux_chk_overlay_type" value="polyline" onclick="get_url_google_maps('<?php echo $mapid; ?>', 'polyline', 'gmb_add_map');">
                                          <span class="ovelay_type">
                                             <?php echo $gm_polyline; ?>
                                          </span>
                                       </div>
                                       <div class="col-md-2">
                                          <input type="radio" id="ux_chk_overlay_type_circle" class="ux_chk_overlay_type" name="ux_chk_overlay_type" value="circle" onclick="get_url_google_maps('<?php echo $mapid; ?>', 'circle', 'gmb_add_map');">
                                          <span class="ovelay_type">
                                             <?php echo $gm_circle; ?>
                                          </span>
                                       </div>
                                       <div class="col-md-4">
                                          <input type="radio" id="ux_chk_overlay_type_rectangle" class="ux_chk_overlay_type" name="ux_chk_overlay_type" value="rectangle" onclick="get_url_google_maps('<?php echo $mapid; ?>', 'rectangle', 'gmb_add_map');">
                                          <span class="ovelay_type">
                                             <?php echo $gm_rectangle; ?>
                                          </span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div id="ux_div_marker_settings">
                                 <div class="line-separator"></div>
                                 <div class="table-top-margin">
                                    <select name="ux_ddl_manage_marker" id="ux_ddl_manage_marker" class="custom-bulk-width">
                                       <option value=""><?php echo $gm_bulk_action; ?></option>
                                       <option value="delete" style="color: red;"><?php echo $gm_map_delete . " ( " . $gm_premium_edition_label . " ) "; ?></option>
                                    </select>
                                    <input type="button" class="btn vivid-green" name="ux_btn_apply" id="ux_btn_apply" value="<?php echo $gm_manage_map_apply; ?>" onclick="premium_edition_notification_google_maps_bank()">
                                    <a class="btn vivid-green" name="ux_btn_add_marker_setting" id="ux_btn_add_marker_setting" onclick="show_settings_google_maps('<?php echo $mapid; ?>', 'marker');"> <?php echo $gm_add_marker; ?></a>
                                 </div>
                                 <div class="line-separator"></div>
                                 <table class="table table-striped table-bordered table-hover table-margin-top" id="ux_tbl_maps_marker">
                                    <thead>
                                       <tr>
                                          <th style="text-align:center;" class="chk-action" style="width:5%;">
                                             <input type="checkbox" name="ux_chk_all_maps_marker" id="ux_chk_all_maps_marker">
                                          </th>
                                          <th style="width:7%;">
                                             <label>
                                                <?php echo $gm_icons; ?>
                                             </label>
                                          </th>
                                          <th style="width:20%;">
                                             <label>
                                                <?php echo $gm_title; ?>
                                             </label>
                                          </th>
                                          <th style="width:34%;">
                                             <label>
                                                <?php echo $gm_add_map_address; ?>
                                             </label>
                                          </th>
                                          <th style="width:13%;">
                                             <label>
                                                <?php echo $gm_map_latitude; ?>
                                             </label>
                                          </th>
                                          <th style="width:13%;">
                                             <label>
                                                <?php echo $gm_map_longitude; ?>
                                             </label>
                                          </th>
                                          <th style="width:8%;" class="chk-action">
                                             <label>
                                                <?php echo $gm_action; ?>
                                             </label>
                                          </th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       if (isset($google_maps_marker_data) && count($google_maps_marker_data) > 0) {
                                          foreach ($google_maps_marker_data as $data) {
                                             ?>
                                             <tr>
                                                <td class="chk-action" style="text-align:center;width: 5%;">
                                                   <input type="checkbox" name="ux_chk_manage_marker_<?php echo intval($data['id']); ?>" id="ux_chk_manage_marker_<?php echo intval($data['id']); ?>" onclick="all_check_google_maps('#ux_chk_all_maps_marker', oTable_marker)" value="<?php echo isset($data["id"]) ? intval($data["id"]) : ""; ?>">
                                                </td>
                                                <td style="text-align:left;width:7%;">
                                                   <?php
                                                   if (esc_attr($data["marker_icon_type"]) == "choose_icon") {
                                                      $url = isset($data["marker_icon_url"]) && $data["marker_icon_url"] != "" ? esc_attr($data["marker_icon_url"]) : GOOGLE_MAP_DEFAULT_MARKER_ICON;
                                                      ?>
                                                      <img src="<?php echo GOOGLE_MAP_CUSTOM_MARKER_ICON . $url; ?>">
                                                      <?php
                                                   } elseif (esc_attr($data["marker_icon_type"]) == "upload") {
                                                      ?>
                                                      <img src="<?php echo esc_url($data["marker_icon_upload"]); ?>" style="height:30px;width:30px">
                                                      <?php
                                                   } else {
                                                      ?>
                                                      <img src="<?php echo plugins_url("assets/global/img/marker-logo.png", dirname(dirname(__FILE__))); ?>">
                                                      <?php
                                                   }
                                                   ?>
                                                </td>
                                                <td style="width:20%;">
                                                   <?php echo isset($data["marker_title"]) ? esc_attr($data["marker_title"]) : ""; ?>
                                                </td>
                                                <td style="width:34%;">
                                                   <?php echo isset($data["marker_address"]) ? esc_html($data["marker_address"]) : ""; ?>
                                                </td>
                                                <td style="width:13%;">
                                                   <?php echo isset($data["marker_latitude"]) ? floatval($data["marker_latitude"]) : ""; ?>
                                                </td>
                                                <td style="width:13%;">
                                                   <?php echo isset($data["marker_longitude"]) ? floatval($data["marker_longitude"]) : ""; ?>
                                                </td>
                                                <td style="text-align:center;width:8% !important;">
                                                   <a href="admin.php?page=gmb_add_map&google_map_id=<?php echo $mapid; ?>&overlay=marker&edit=<?php echo intval($data["id"]); ?>" class="icon-custom-note tooltips" data-original-title="<?php echo $gm_edit_tooltip; ?>" data-placement="top"></a> |
                                                   <a href="javascript:void(0);" class="icon-custom-trash tooltips custom-delete-icon-custom-live" data-original-title="<?php echo $gm_map_delete; ?>" onclick="delete_data_google_maps('<?php echo isset($data["id"]) ? intval($data["id"]) : ""; ?>', '<?php echo $gm_marker_delete_message; ?>', 'admin.php?page=gmb_add_map&google_map_id=<?php echo $data["meta_id"]; ?>&overlay=marker', '<?php echo $google_maps_delete_nonce; ?>', 'delete_data_google_maps');" data-placement="top"></a>
                                                </td>
                                             </tr>
                                             <?php
                                          }
                                       }
                                       ?>
                                    </tbody>
                                 </table>
                              </div>
                              <div id="ux_div_overlay_marker_settings" style="display:none;">
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_marker_title; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_marker_title_tooltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="ux_txt_marker_title" onblur="initialize_google_map_setttings('marker');" id="ux_txt_marker_title" value="<?php echo isset($serialize_edit_data['marker_title']) ? esc_attr($serialize_edit_data['marker_title']) : ""; ?>" placeholder="<?php echo $gm_marker_title_placeholder; ?>">
                                 </div>
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_marker_description; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_marker_description_tooltips; ?>" data-placement="right"></i>
                                    </label>
                                    <textarea class="form-control" name="ux_txt_marker_desc" onblur="initialize_google_map_setttings('marker');" id="ux_txt_marker_desc" rows="4" placeholder="<?php echo $gm_marker_description_placeholder; ?>"><?php echo isset($serialize_edit_data['marker_description']) ? esc_html($serialize_edit_data['marker_description']) : ""; ?></textarea>
                                 </div>
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_marker_type; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_marker_type_tooltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">*</span>
                                    </label>
                                    <div class="row" style="margin-top:10px;">
                                       <div class="col-md-3">
                                          <input type="radio" name="ux_chk_formatted_address" id="ux_chk_formatted_address" value="formatted_address" checked="checked" onclick="choose_address_type_google_maps('formatted_address', '#ux_div_marker_address', '#ux_div_marker_latitude_longitude');" <?php echo isset($serialize_edit_data["marker_type"]) && esc_attr($serialize_edit_data["marker_type"]) == "formatted_address" ? 'checked="checked"' : ""; ?>>
                                          <?php echo $gm_formatted_address; ?>
                                       </div>
                                       <div class="col-md-3">
                                          <input type="radio" name="ux_chk_formatted_address" id="ux_chk_by_latitude_longitude" value="latitude_longitude" onclick="choose_address_type_google_maps('latitude_longitude', '#ux_div_marker_address', '#ux_div_marker_latitude_longitude');" <?php echo isset($serialize_edit_data["marker_type"]) && esc_attr($serialize_edit_data["marker_type"]) == "latitude_longitude" ? 'checked="checked"' : ""; ?>>
                                          <?php echo $gm_by_latitude_longitude; ?>
                                       </div>
                                    </div>
                                 </div>
                                 <div id="ux_div_marker_address">
                                    <div class="form-group">
                                       <label class="control-label">
                                          <?php echo $gm_add_map_address; ?> :
                                          <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_add_marker_address_tooltips; ?>" data-placement="right"></i>
                                          <span class="required" aria-required="true">*</span>
                                       </label>
                                       <input type="text" class="form-control" name="ux_txt_marker_address" id="ux_txt_marker_address" value="<?php echo (isset($serialize_edit_data["marker_address"]) && esc_html($serialize_edit_data["marker_address"]) != "") ? esc_html($serialize_edit_data["marker_address"]) : (isset($serialized_map_data["formatted_address"]) && esc_html($serialized_map_data["formatted_address"]) ? esc_html($serialized_map_data["formatted_address"]) : ""); ?>" placeholder="<?php echo $gm_add_marker_address_placeholder; ?>">
                                    </div>
                                 </div>
                                 <div id="ux_div_marker_latitude_longitude" style="display:none;">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label class="control-label">
                                                <?php echo $gm_map_latitude; ?> :
                                                <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_add_marker_latitude_tooltips; ?>" data-placement="right"></i>
                                                <span class="required" aria-required="true">*</span>
                                             </label>
                                             <input type="text" class="form-control" name="ux_txt_marker_latitude" id="ux_txt_marker_latitude" value="<?php echo (isset($serialize_edit_data["marker_latitude"]) && floatval($serialize_edit_data["marker_latitude"]) != 0) ? floatval($serialize_edit_data["marker_latitude"]) : (isset($serialized_map_data["map_latitude"]) && floatval($serialized_map_data["map_latitude"]) ? floatval($serialized_map_data["map_latitude"]) : ""); ?>" placeholder="<?php echo $gm_add_marker_latitude_placeholder; ?>" onblur="geocode_latitude_longitude_google_maps('marker');" >
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label class="control-label">
                                                <?php echo $gm_map_longitude; ?> :
                                                <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_add_marker_longitude_tooltips; ?>" data-placement="right"></i>
                                                <span class="required" aria-required="true">*</span>
                                             </label>
                                             <input type="text" class="form-control" name="ux_txt_marker_longitude" id="ux_txt_marker_longitude" value="<?php echo (isset($serialize_edit_data['marker_longitude']) && floatval($serialize_edit_data['marker_longitude']) != 0) ? floatval($serialize_edit_data["marker_longitude"]) : (isset($serialized_map_data["map_longitude"]) && floatval($serialized_map_data["map_longitude"]) ? floatval($serialized_map_data["map_longitude"]) : ""); ?>" placeholder="<?php echo $gm_add_marker_longitude_placeholder; ?>" onblur="geocode_latitude_longitude_google_maps('marker');" >
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
                                 <div class="form-group" id="ux_div_marker_icon_ablity" style="display:none">
                                    <label class="control-label">
                                       <?php echo $gm_marker_images; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_marker_img_upload_tooltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">*</span>
                                    </label>
                                    <div class="input-icon right">
                                       <input type="text" class="form-control custom-input-large input-inline" readonly="true" name="ux_txt_marker_icon_path" id="ux_txt_marker_icon_path" placeholder="<?php echo $gm_marker_upload_icon_placeholder; ?>" value="<?php echo isset($serialize_edit_data['marker_icon_upload']) ? esc_attr($serialize_edit_data['marker_icon_upload']) : ""; ?>">
                                       <input type="button" class="btn vivid-green custom-top" name="ux_upload_marker_icon" id="ux_upload_marker_icon" onclick="google_maps_upload_image('ux_txt_marker_icon_path');" value="<?php echo $gm_upload; ?>">
                                    </div>
                                 </div>
                                 <p id="wp_media_upload_error" class="wp-media-error-message"><?php echo $gm_media_error_settings_message; ?></p>
                                 <div id="ux_div_marker_icon_choose" style="display:none !important;">
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
                                    <div class="form-group" id="ux_div_show_map_icons_ability" style="display:none;">
                                       <?php
                                       if (file_exists(GOOGLE_MAP_DIR_PATH . "/includes/map-icons.php")) {
                                          include_once GOOGLE_MAP_DIR_PATH . "/includes/map-icons.php";
                                       }
                                       ?>
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
                                          <input type="text" class="form-control custom-input-middle input-inline" readonly="true" name="ux_txt_image_upload_path" id="ux_txt_image_upload_path" placeholder="<?php echo $gm_info_window_images_upload_placeholder; ?>" value="<?php echo isset($serialize_edit_data['marker_info_window_upload_path']) ? esc_attr($serialize_edit_data['marker_info_window_upload_path']) : ""; ?>">
                                          <input type="button" class="btn vivid-green custom-top" name="ux_upload_info_image" id="ux_upload_info_image" onclick="google_maps_upload_image('ux_txt_image_upload_path');" value="<?php echo $gm_upload; ?>">
                                          <input type="button" class="btn vivid-green custom-top" name="ux_clear_info_image" id="ux_clear_info_image"  onclick='google_maps_clear_info_window_image("#ux_txt_image_upload_path");' value="<?php echo $gm_clear; ?>">
                                       </div>
                                    </div>
                                 </div>
                                 <p id="wp_media_upload_error_info" class="wp-media-error-message"><?php echo $gm_media_error_settings_message; ?></p>
                                 <div class="line-separator"></div>
                                 <div class="form-actions">
                                    <div class="pull-right">
                                       <input type="button" name="ux_btn_cancel_marker" class="btn vivid-green" id="ux_btn_cancel_marker" value="<?php echo $gm_cancel_button; ?>" onclick="google_maps_cancel_maps_overlay_settings('admin.php?page=gmb_add_map<?php echo $mapid; ?>&overlay=marker');">
                                       <input type="submit" name="ux_btn_add_marker" class="btn vivid-green" id="ux_btn_add_marker" value="<?php echo isset($_REQUEST["edit"]) ? $gm_update_marker : $gm_add_marker; ?>">
                                    </div>
                                 </div>
                              </div>
                              <div id="ux_div_polygon_settings" style="display:none">
                                 <div class="line-separator"></div>
                                 <div class="table-top-margin">
                                    <select name="ux_ddl_manage_polygon" id="ux_ddl_manage_polygon" class="custom-bulk-width">
                                       <option value=""><?php echo $gm_bulk_action; ?></option>
                                       <option value="delete" style="color: red;"><?php echo $gm_map_delete . " ( " . $gm_premium_edition_label . " ) "; ?></option>
                                    </select>
                                    <input type="button" class="btn vivid-green" name="ux_btn_apply" id="ux_btn_apply" value="<?php echo $gm_manage_map_apply; ?>" onclick="premium_edition_notification_google_maps_bank()">
                                    <a class="btn vivid-green" name="ux_btn_add_polygon_settings" id="ux_btn_add_polygon_settings" onclick="show_settings_google_maps('<?php echo $mapid; ?>', 'polygon');"> <?php echo $gm_add_polygon; ?></a>
                                 </div>
                                 <div class="line-separator"></div>
                                 <table class="table table-striped table-bordered table-hover table-margin-top" id="ux_tbl_maps_polygon">
                                    <thead>
                                       <tr>
                                          <th style="text-align: center;" class="chk-action" style="width:5%;">
                                             <input type="checkbox" name="ux_chk_all_maps_polygon" id="ux_chk_all_maps_polygon">
                                          </th>
                                          <th style="width:20% !important;">
                                             <label>
                                                <?php echo $gm_title; ?>
                                             </label>
                                          </th>
                                          <th style="width:60%;">
                                             <label>
                                                <?php echo $gm_coordinates; ?>
                                             </label>
                                          </th>
                                          <th style="width:5%;" class="chk-action">
                                             <label>
                                                <?php echo $gm_action; ?>
                                             </label>
                                          </th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       if (isset($google_maps_polygon_data) && count($google_maps_polygon_data) > 0) {
                                          foreach ($google_maps_polygon_data as $data) {
                                             ?>
                                             <tr>
                                                <td class="chk-action" style="text-align:center;width: 5%;">
                                                   <input type="checkbox" name="ux_chk_polygon_maps_<?php echo intval($data['id']); ?>" id="ux_chk_polygon_maps_<?php echo intval($data['id']); ?>" value="<?php echo isset($data["id"]) ? intval($data["id"]) : ""; ?>"  onclick="all_check_google_maps('#ux_chk_all_maps_polygon', oTable_polygon);">
                                                </td>
                                                <td style="width:27% !important;">
                                                   <?php echo esc_attr($data["polygon_title"]); ?>
                                                </td>
                                                <td style="width:60%;">
                                                   <?php
                                                   $polygon_coordinates = explode("\n", $data["polygon_coordinates"]);
                                                   foreach ($polygon_coordinates as $coordinates) {
                                                      echo $coordinates . "<br>";
                                                   }
                                                   ?>
                                                </td>
                                                <td style="text-align:center;width:8% !important;">
                                                   <a href="admin.php?page=gmb_add_map&google_map_id=<?php echo intval($data["meta_id"]); ?>&overlay=polygon&edit=<?php echo intval($data["id"]); ?>" class="icon-custom-note tooltips" data-original-title="<?php echo $gm_edit_tooltip; ?>" data-placement="top"></a> |
                                                   <a href="javascript:void(0);" class="icon-custom-trash tooltips custom-delete-icon-custom-live" data-original-title="<?php echo $gm_map_delete; ?>" onclick="delete_data_google_maps('<?php echo isset($data["id"]) ? intval($data["id"]) : ""; ?>', '<?php echo $gm_polygon_delete_message; ?>', 'admin.php?page=gmb_add_map&google_map_id=<?php echo $data["meta_id"]; ?>&overlay=polygon', '<?php echo $google_maps_delete_nonce; ?>', 'delete_data_google_maps');" data-placement="top"></a>
                                                </td>
                                             </tr>
                                             <?php
                                          }
                                       }
                                       ?>
                                    </tbody>
                                 </table>
                              </div>
                              <div id="ux_div_overlay_polygon_settings" style="display:none">
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_polygon_title; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_polygon_tooltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="ux_txt_polygon_title" id="ux_txt_polygon_title" value="<?php echo isset($serialize_polygon_edit_data["polygon_title"]) ? esc_attr($serialize_polygon_edit_data["polygon_title"]) : ""; ?>" placeholder="<?php echo $gm_polygon_placeholder; ?>">
                                 </div>
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_polygon_description; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_polygon_description_tooltips; ?>" data-placement="right"></i>
                                    </label>
                                    <textarea class="form-control" name="ux_txt_polygon_desc" id="ux_txt_polygon_desc" rows="4" placeholder="<?php echo $gm_polygon_description_placeholder; ?>"><?php echo isset($serialize_polygon_edit_data['polygon_description']) ? esc_html($serialize_polygon_edit_data['polygon_description']) : ''; ?></textarea>
                                 </div>
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_stroke_weight; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_polygon_stroke_width_tooltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">*</span>
                                    </label>
                                    <select name="ux_ddl_polygon_weight" id="ux_ddl_polygon_weight" class="form-control" onChange="initialize_google_map_setttings('polygon');">
                                       <?php
                                       for ($stroke_weight = 0; $stroke_weight <= 50; $stroke_weight++) {
                                          ?>
                                          <option value="<?php echo$stroke_weight; ?>"><?php echo $stroke_weight; ?></option>
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
                                             <input type="text" class="form-control custom-input-medium" name="ux_txt_polygon_stroke_color_style[]" id="ux_txt_polygon_stroke_color" onblur="default_value_google_maps('#ux_txt_polygon_stroke_color', '#000000');initialize_google_map_setttings('polygon');" onfocus="google_map_color_picker('#ux_txt_polygon_stroke_color', this.value)" value="<?php echo isset($polygon_stroke_color_style[0]) ? esc_attr($polygon_stroke_color_style[0]) : '#000000'; ?>" placeholder="<?php echo $gm_stroke_color_placeholder; ?>">
                                             <input type="text" class="form-control custom-input-medium" name="ux_txt_polygon_stroke_color_style[]" id="ux_txt_polygon_stroke_opacity" maxlength="3"  onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_polygon_stroke_opacity', '75', 'width');initialize_google_map_setttings('polygon');" onkeypress="only_digits_google_maps(event);" value="<?php echo isset($polygon_stroke_color_style[1]) ? intval($polygon_stroke_color_style[1]) : 75; ?>" placeholder="<?php echo $gm_stroke_opacity_placeholder; ?>">
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
                                             <input type="text" class="form-control custom-input-medium" name="ux_txt_polygon_fill_color_style[]" id="ux_txt_polygon_fill_color_opacity" maxlength="3"  onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_polygon_fill_color_opacity', '75', 'width');initialize_google_map_setttings('polygon');" onkeypress="only_digits_google_maps(event);" value="<?php echo isset($polygon_fill_color_style[1]) ? intval($polygon_fill_color_style[1]) : 75; ?>" placeholder="<?php echo $gm_fill_opacity_placeholder; ?>">
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-group" style='margin-top:15px;'>
                                    <label class="control-label">
                                       <?php echo $gm_coordinates; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_polygon_coordinate_tooltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">*</span>
                                    </label>
                                    <textarea class="form-control" name="ux_txt_polygon_coordinate" id="ux_txt_polygon_coordinate" rows="4" readonly="true" placeholder="<?php echo $gm_coordinate_placeholder; ?>"><?php echo isset($serialize_polygon_edit_data["polygon_coordinates"]) ? esc_attr($serialize_polygon_edit_data["polygon_coordinates"]) : ""; ?></textarea>
                                 </div>
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_info_window; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_info_window_tooltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">*<?php echo " ( " . $gm_premium_edition_label . " )"; ?> </span>
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
                                          <span class="required" aria-required="true"> <?php echo " ( " . $gm_premium_edition_label . " )"; ?> </span>
                                       </label>
                                       <div class="input-icon right">
                                          <input type="text" class="form-control custom-input-middle input-inline" readonly="true" name="ux_txt_image_upload_polygon_path" id="ux_txt_image_upload_polygon_path" placeholder="<?php echo $gm_info_window_images_upload_placeholder; ?>" value="<?php echo isset($serialize_polygon_edit_data["polygon_image_upload_path"]) ? esc_attr($serialize_polygon_edit_data["polygon_image_upload_path"]) : ""; ?>">
                                          <input type="button" class="btn vivid-green custom-top" name="ux_upload_info_image" id="ux_upload_info_image" onclick="premium_edition_notification_google_maps_bank();" value="<?php echo $gm_upload; ?>">
                                          <input type="button" class="btn vivid-green custom-top" name="ux_clear_info_image" id="ux_clear_info_image" onclick="premium_edition_notification_google_maps_bank();"value="<?php echo $gm_clear; ?>">
                                       </div>
                                    </div>
                                 </div>
                                 <p id="wp_media_upload_polygon_error_info" class="wp-media-error-message"><?php echo $gm_media_error_settings_message; ?></p>
                                 <div class="line-separator"></div>
                                 <div class="form-actions">
                                    <div class="pull-right">
                                       <input type="button" name="ux_btn_cancel_polygon" class="btn vivid-green" id="ux_btn_cancel_polygon" value="<?php echo $gm_cancel_button; ?>" onclick="google_maps_cancel_maps_overlay_settings('admin.php?page=gmb_add_map<?php echo $mapid; ?>&overlay=polygon');">
                                       <input type="submit" name="ux_btn_add_polygon" class="btn vivid-green" id="ux_btn_add_polygon" value="<?php echo isset($_REQUEST["edit"]) ? $gm_update_polygon : $gm_add_polygon; ?>">
                                    </div>
                                 </div>
                              </div>
                              <div id="ux_div_polyline_settings" style="display:none">
                                 <div class="line-separator"></div>
                                 <div class="table-top-margin">
                                    <select name="ux_ddl_manage_polyline" id="ux_ddl_manage_polyline" class="custom-bulk-width">
                                       <option value=""><?php echo $gm_bulk_action; ?></option>
                                       <option value="delete" style="color: red;"><?php echo $gm_map_delete . " ( " . $gm_premium_edition_label . " ) "; ?></option>
                                    </select>
                                    <input type="button" class="btn vivid-green" name="ux_btn_apply" id="ux_btn_apply" value="<?php echo $gm_manage_map_apply; ?>" onclick="premium_edition_notification_google_maps_bank()">
                                    <a class="btn vivid-green" name="ux_btn_add_polyline_setting" id="ux_btn_add_polyline_setting" onclick="show_settings_google_maps('<?php echo $mapid; ?>', 'polyline');"> <?php echo $gm_add_polyline; ?></a>
                                 </div>
                                 <div class="line-separator"></div>
                                 <table class="table table-striped table-bordered table-hover table-margin-top" id="ux_tbl_maps_polyline">
                                    <thead>
                                       <tr>
                                          <th style="text-align: center;" class="chk-action" style="width:5%;">
                                             <input type="checkbox" name="ux_chk_all_maps_polyline" id="ux_chk_all_maps_polyline">
                                          </th>
                                          <th style="width:20px;">
                                             <label>
                                                <?php echo $gm_title; ?>
                                             </label>
                                          </th>
                                          <th style="width:60%;">
                                             <label>
                                                <?php echo $gm_coordinates; ?>
                                             </label>
                                          </th>
                                          <th style="width:15%;" class="chk-action">
                                             <label>
                                                <?php echo $gm_action; ?>
                                             </label>
                                          </th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       if (isset($google_polyline_unserialize_data) && count($google_polyline_unserialize_data) > 0) {
                                          foreach ($google_polyline_unserialize_data as $key => $value) {
                                             ?>
                                             <tr>
                                                <td class="chk-action" style="text-align:center;width: 5%;">
                                                   <input type="checkbox" name="ux_chk_polyline_data_<?php echo intval($value["id"]); ?>" id="ux_chk_polyline_data_<?php echo intval($value["id"]); ?>" value="<?php echo isset($value["id"]) ? intval($value["id"]) : ""; ?>" onclick="all_check_google_maps('#ux_chk_all_maps_polyline', oTable_polyline);">
                                                </td>
                                                <td style="width:27% !important;">
                                                   <?php echo esc_attr($value["polyline_title"]); ?>
                                                </td>
                                                <td style="width:60%;">
                                                   <?php
                                                   $polyline_coordinates = explode("\n", esc_attr($value["polyline_cordinates"]));
                                                   foreach ($polyline_coordinates as $coordinates) {
                                                      echo $coordinates . "<br>";
                                                   }
                                                   ?>
                                                </td>
                                                <td style="text-align:center;width:8% !important;">
                                                   <a href="admin.php?page=gmb_add_map&google_map_id=<?php echo intval($value["meta_id"]); ?>&overlay=polyline&edit=<?php echo $value["id"]; ?>" class="icon-custom-note tooltips" data-placement="top" data-original-title="<?php echo $gm_edit_tooltip; ?>"></a>|
                                                   <a href="javascript:void(0);" class="icon-custom-trash tooltips custom-delete-icon-custom-live" data-placement="top" data-original-title="<?php echo $gm_map_delete; ?>" onclick="delete_data_google_maps('<?php echo isset($value["id"]) ? intval($value["id"]) : ""; ?>', '<?php echo $gm_delete_single_map_data_message; ?>', 'admin.php?page=gmb_add_map&google_map_id=<?php echo intval($value["meta_id"]); ?>&overlay=polyline', '<?php echo $google_maps_delete_nonce; ?>', 'delete_data_google_maps');"></a>
                                                </td>
                                             </tr>
                                             <?php
                                          }
                                       }
                                       ?>
                                    </tbody>
                                 </table>
                              </div>
                              <div id="ux_div_overlay_polyline_settings" style="display:none;">
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_polyline_title; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_polyline_title_tooltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="ux_txt_polyline_title" id="ux_txt_polyline_title"  value="<?php echo isset($serialize_polyline_edit_data["polyline_title"]) ? esc_attr($serialize_polyline_edit_data["polyline_title"]) : ""; ?>" placeholder="<?php echo $gm_polyline_title_placeholder; ?>">
                                 </div>
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_polyline_description; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_polyline_description_tooltips; ?>" data-placement="right"></i>
                                    </label>
                                    <textarea rows="4" class="form-control" name="ux_txt_polyline_description" id="ux_txt_polyline_description"  placeholder="<?php echo $gm_polyline_description_placeholder; ?>"><?php echo isset($serialize_polyline_edit_data["polyline_description"]) ? esc_html($serialize_polyline_edit_data["polyline_description"]) : ""; ?></textarea>
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
                                             <input type="text" class="form-control custom-input-medium" name="ux_txt_polyline_line_color[]" id="ux_txt_polyline_line_color" onfocus="google_map_color_picker('#ux_txt_polyline_line_color', this.value)" onblur="default_value_google_maps('#ux_txt_polyline_line_color', '#000000'); initialize_google_map_setttings('polyline');" value="<?php echo isset($polyline_stroke_color[0]) ? esc_attr($polyline_stroke_color[0]) : "#000000"; ?>" placeholder="<?php echo $gm_stroke_color_placeholder; ?>">
                                             <input type="text" class="form-control custom-input-medium" name="ux_txt_polyline_line_color[]" id="ux_txt_polyline_line_opacity" onfocus="paste_prevent_google_maps(this.id);" value="<?php echo isset($polyline_stroke_color[1]) ? esc_attr($polyline_stroke_color[1]) : 75; ?>" placeholder="<?php echo $gm_stroke_opacity_placeholder; ?>" maxlength="3" onkeypress="only_digits_google_maps(event);" onblur="default_value_google_maps('#ux_txt_polyline_line_opacity', '75', 'width'); initialize_google_map_setttings('polyline');">
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
                                    <textarea class="form-control" id="ux_div_polyline_coordinate" name="ux_div_polyline_coordinate" rows="4" readonly="true" placeholder="<?php echo $gm_coordinate_placeholder; ?>" onfocus="paste_prevent_google_maps(this.id);"><?php echo isset($serialize_polyline_edit_data["polyline_cordinates"]) ? $serialize_polyline_edit_data["polyline_cordinates"] : ""; ?></textarea>
                                 </div>
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_info_window; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_info_window_tooltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " )"; ?></span>
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
                                          <span class="required" aria-required="true"> <?php echo " ( " . $gm_premium_edition_label . " )"; ?> </span>
                                       </label>
                                       <div class="input-icon right">
                                          <input type="text" class="form-control custom-input-middle input-inline" readonly="true" name="ux_txt_image_upload_polyline_path" id="ux_txt_image_upload_polyline_path" placeholder="<?php echo $gm_info_window_images_upload_placeholder; ?>" value="<?php echo isset($serialize_polyline_edit_data['image_upload_polyline_path']) ? esc_attr($serialize_polyline_edit_data['image_upload_polyline_path']) : ""; ?>">
                                          <input type="button" class="btn vivid-green custom-top" name="ux_upload_info_image" id="ux_upload_info_image" onclick="premium_edition_notification_google_maps_bank();" value="<?php echo $gm_upload; ?>">
                                          <input type="button" class="btn vivid-green custom-top" name="ux_clear_info_image" id="ux_clear_info_image"  onclick='premium_edition_notification_google_maps_bank();' value="<?php echo $gm_clear; ?>">
                                       </div>
                                    </div>
                                 </div>
                                 <p id="wp_media_upload_polyline_error_info" class="wp-media-error-message"><?php echo $gm_media_error_settings_message; ?></p>
                                 <div class="line-separator"></div>
                                 <div class="form-actions">
                                    <div class="pull-right">
                                       <input type="button" name="ux_btn_cancel_polyline" class="btn vivid-green" id="ux_btn_cancel_polyline" value="<?php echo $gm_cancel_button; ?>" onclick="google_maps_cancel_maps_overlay_settings('admin.php?page=gmb_add_map<?php echo $mapid; ?>&overlay=polyline');">
                                       <input type="submit" name="ux_btn_add_polyline" class="btn vivid-green" id="ux_btn_add_polyline" value="<?php echo isset($_REQUEST["edit"]) ? $gm_update_polyline : $gm_add_polyline; ?>">
                                    </div>
                                 </div>
                              </div>
                              <div id="ux_div_circle_settings" style="display:none">
                                 <div class="line-separator"></div>
                                 <div class="table-top-margin">
                                    <select name="ux_ddl_manage_circle" id="ux_ddl_manage_circle" class="custom-bulk-width">
                                       <option value=""><?php echo $gm_bulk_action; ?></option>
                                       <option value="delete" style="color: red;"><?php echo $gm_map_delete . " ( " . $gm_premium_edition_label . " ) "; ?></option>
                                    </select>
                                    <input type="button" class="btn vivid-green" name="ux_btn_apply" id="ux_btn_apply" value="<?php echo $gm_manage_map_apply; ?>" onclick="premium_edition_notification_google_maps_bank()">
                                    <a class="btn vivid-green" name="ux_btn_add_circle_settings" id="ux_btn_add_circle_settings" onclick="show_settings_google_maps('<?php echo $mapid; ?>', 'circle');"> <?php echo $gm_add_circle; ?></a>
                                 </div>
                                 <div class="line-separator"></div>
                                 <table class="table table-striped table-bordered table-hover table-margin-top" id="ux_tbl_maps_circle">
                                    <thead>
                                       <tr>
                                          <th style="text-align: center;" class="chk-action" style="width:5%;">
                                             <input type="checkbox" name="ux_chk_all_maps_circle" id="ux_chk_all_maps_circle">
                                          </th>
                                          <th style="width:20% !important;">
                                             <label>
                                                <?php echo $gm_title; ?>
                                             </label>
                                          </th>
                                          <th style="width:60%;">
                                             <label>
                                                <?php echo $gm_coordinates; ?>
                                             </label>
                                          </th>
                                          <th style="width:15%;" class="chk-action">
                                             <label>
                                                <?php echo $gm_action; ?>
                                             </label>
                                          </th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       if (isset($google_map_circle_data) && count($google_map_circle_data) > 0) {
                                          foreach ($google_map_circle_data as $data) {
                                             ?>
                                             <tr>
                                                <td class="chk-action" style="text-align:center;width: 5%;">
                                                   <input type="checkbox" name="ux_chk_manage_circle_data_<?php echo intval($data["id"]) ?>" id="ux_chk_manage_circle_data_<?php echo intval($data["id"]) ?>" value="<?php echo isset($data["id"]) ? intval($data["id"]) : ""; ?>" onclick="all_check_google_maps('#ux_chk_all_maps_circle', oTable_circle);">
                                                </td>
                                                <td style="width:27% !important;">
                                                   <?php echo esc_attr($data["circle_title"]); ?>
                                                </td>
                                                <td style="width:60%;">
                                                   <?php
                                                   $circle_coordinates = explode("\n", esc_attr($data["circle_coordinates"]));
                                                   foreach ($circle_coordinates as $coordinates) {
                                                      echo $coordinates . "<br>";
                                                   }
                                                   ?>
                                                </td>
                                                <td style="text-align:center;width:8% !important;">
                                                   <a href="admin.php?page=gmb_add_map&google_map_id=<?php echo intval($data["meta_id"]); ?>&overlay=circle&edit=<?php echo intval($data["id"]); ?>" class="icon-custom-note tooltips" data-original-title="<?php echo $gm_edit_tooltip; ?>" data-placement="top"></a> |
                                                   <a href="javascript:void(0);" class="icon-custom-trash tooltips custom-delete-icon-custom-live" data-original-title="<?php echo $gm_map_delete; ?>" onclick="delete_data_google_maps('<?php echo isset($data["id"]) ? intval($data["id"]) : ""; ?>', '<?php echo $gm_delete_single_circle_data_message; ?>', 'admin.php?page=gmb_add_map&google_map_id=<?php echo intval($data["meta_id"]); ?>&overlay=circle', '<?php echo $google_maps_delete_nonce; ?>', 'delete_data_google_maps');" data-placement="top"></a>
                                                </td>
                                             </tr>
                                             <?php
                                          }
                                       }
                                       ?>
                                    </tbody>
                                 </table>
                              </div>
                              <div id="ux_div_overlay_circle_settings" style="display:none">
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_circle_title; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_circle_title_tooltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="ux_txt_circle_title" id="ux_txt_circle_title" value="<?php echo isset($serialize_circle_edit_data["circle_title"]) ? esc_attr($serialize_circle_edit_data["circle_title"]) : ""; ?>" placeholder="<?php echo $gm_circle_title_placeholder; ?>">
                                 </div>
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_circle_description; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_circle_description_tooltips; ?>" data-placement="right"></i>
                                    </label>
                                    <textarea class="form-control" name="ux_txt_circle_desc" id="ux_txt_circle_desc"  rows="4" placeholder="<?php echo $gm_circle_description_placeholder; ?>"><?php echo isset($serialize_circle_edit_data['circle_description']) ? esc_html($serialize_circle_edit_data['circle_description']) : ''; ?></textarea>
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
                                             <input type="text" class="form-control custom-input-medium" name="ux_txt_circle_stroke_color[]" id="ux_txt_circle_stroke_color" onfocus="google_map_color_picker('#ux_txt_circle_stroke_color', this.value)" onblur="default_value_google_maps('#ux_txt_circle_stroke_color', '#000000');initialize_google_map_setttings('circle');" value="<?php echo isset($gmb_circle_stroke_color[0]) ? esc_attr($gmb_circle_stroke_color[0]) : "#000000"; ?>" placeholder="<?php echo $gm_stroke_color_placeholder; ?>">
                                             <input type="text" class="form-control custom-input-medium" name="ux_txt_circle_stroke_color[]" id="ux_txt_circle_stroke_opacity" onfocus="paste_prevent_google_maps(this.id);" value="<?php echo isset($gmb_circle_stroke_color[1]) ? intval($gmb_circle_stroke_color[1]) : 75; ?>" placeholder="<?php echo $gm_stroke_opacity_placeholder; ?>" maxlength="3" onkeypress="only_digits_google_maps(event);" onblur="default_value_google_maps('#ux_txt_circle_stroke_opacity', '75', 'width');initialize_google_map_setttings('circle');">
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
                                             <input type="text" class="form-control custom-input-medium" name="ux_txt_circle_fill_color[]" id="ux_txt_circle_fill_color" onfocus="google_map_color_picker('#ux_txt_circle_fill_color', this.value)" onblur="default_value_google_maps('#ux_txt_circle_fill_color', '#000000');initialize_google_map_setttings('circle');" value="<?php echo isset($gmb_circle_fill_color[0]) ? esc_attr($gmb_circle_fill_color[0]) : "#000000"; ?>" placeholder="<?php echo $gm_fill_color_placeholder; ?>">
                                             <input type="text" class="form-control custom-input-medium" name="ux_txt_circle_fill_color[]" id="ux_txt_circle_fill_color_opacity" onfocus="paste_prevent_google_maps(this.id);" value="<?php echo isset($gmb_circle_fill_color[1]) ? intval($gmb_circle_fill_color[1]) : 75; ?>" placeholder="<?php echo $gm_fill_opacity_placeholder; ?>" maxlength="3" onkeypress="only_digits_google_maps(event);" onblur="default_value_google_maps('#ux_txt_circle_fill_color_opacity', '75', 'width');initialize_google_map_setttings('circle');">
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
                                          <input type="text" class="form-control" name="ux_txt_circle_radius_value" id="ux_txt_circle_radius_value" maxlength="7" value="<?php echo isset($serialize_circle_edit_data["circle_radius_value"]) ? intval($serialize_circle_edit_data["circle_radius_value"]) : 30; ?>" placeholder="<?php echo $gm_circle_radius_value_placeholder; ?>" onkeypress="only_digits_google_maps(event);" onblur="default_value_google_maps('#ux_txt_circle_radius_value', '30');initialize_google_map_setttings('circle');">
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
                                             <option value="kilometers" selected="selected"><?php echo $gm_kilometers; ?></option>
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
                                    <textarea class="form-control" name="ux_txt_circle_coordinate" id="ux_txt_circle_coordinate" rows="4" readonly="true"  placeholder="<?php echo $gm_coordinate_placeholder; ?>"><?php echo isset($serialize_circle_edit_data["circle_coordinates"]) ? esc_attr($serialize_circle_edit_data["circle_coordinates"]) : ""; ?></textarea>
                                 </div>
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_info_window; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_info_window_tooltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " )"; ?></span>
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
                                          <span class="required" aria-required="true"> <?php echo " ( " . $gm_premium_edition_label . " )"; ?> </span>
                                       </label>
                                       <div class="input-icon right">
                                          <input type="text" class="form-control custom-input-middle input-inline" readonly="true" name="ux_txt_image_upload_circle_path" id="ux_txt_image_upload_circle_path" placeholder="<?php echo $gm_info_window_images_upload_placeholder; ?>" value="<?php echo isset($serialize_circle_edit_data["image_upload_circle_path"]) ? esc_attr($serialize_circle_edit_data["image_upload_circle_path"]) : ""; ?>">
                                          <input type="button" class="btn vivid-green custom-top" name="ux_upload_info_image" id="ux_upload_info_image" onclick="premium_edition_notification_google_maps_bank();" value="<?php echo $gm_upload; ?>">
                                          <input type="button" class="btn vivid-green custom-top" name="ux_clear_info_image" id="ux_clear_info_image" onclick="premium_edition_notification_google_maps_bank();" value="<?php echo $gm_clear; ?>">
                                       </div>
                                    </div>
                                 </div>
                                 <p id="wp_media_upload_circle_error_info" class="wp-media-error-message"><?php echo $gm_media_error_settings_message; ?></p>
                                 <div class="line-separator"></div>
                                 <div class="form-actions">
                                    <div class="pull-right">
                                       <input type="button" name="ux_btn_cancel_circle" class="btn vivid-green" id="ux_btn_cancel_circle" value="<?php echo $gm_cancel_button; ?>" onclick="google_maps_cancel_maps_overlay_settings('admin.php?page=gmb_add_map<?php echo $mapid; ?>&overlay=circle');">
                                       <input type="submit" name="ux_btn_add_circle" class="btn vivid-green" id="ux_btn_add_circle" value="<?php echo isset($_REQUEST["edit"]) ? $gm_update_circle : $gm_add_circle; ?>">
                                    </div>
                                 </div>
                              </div>
                              <div id="ux_div_rectangle_settings" style="display:none">
                                 <div class="line-separator"></div>
                                 <div class="table-top-margin">
                                    <select name="ux_ddl_manage_rectangle" id="ux_ddl_manage_rectangle" class="custom-bulk-width">
                                       <option value=""><?php echo $gm_bulk_action; ?></option>
                                       <option value="delete" style="color: red;"><?php echo $gm_map_delete . " ( " . $gm_premium_edition_label . " ) "; ?></option>
                                    </select>
                                    <input type="button" class="btn vivid-green" name="ux_btn_apply" id="ux_btn_apply" value="<?php echo $gm_manage_map_apply; ?>" onclick="premium_edition_notification_google_maps_bank()">
                                    <a class="btn vivid-green" name="ux_btn_add_rectangle_settings" id="ux_btn_add_rectangle_settings" onclick="show_settings_google_maps('<?php echo $mapid; ?>', 'rectangle');"> <?php echo $gm_add_rectangle; ?></a>
                                 </div>
                                 <div class="line-separator"></div>
                                 <table class="table table-striped table-bordered table-hover table-margin-top" id="ux_tbl_maps_rectangle">
                                    <thead>
                                       <tr>
                                          <th style="text-align: center;" class="chk-action" style="width:5%;">
                                             <input type="checkbox" name="ux_chk_all_maps_rectangle" id="ux_chk_all_maps_rectangle">
                                          </th>
                                          <th style="width:20% !important;">
                                             <label>
                                                <?php echo $gm_title; ?>
                                             </label>
                                          </th>
                                          <th style="width:60%;">
                                             <label>
                                                <?php echo $gm_coordinates; ?>
                                             </label>
                                          </th>
                                          <th style="width:15%;">
                                             <label>
                                                <?php echo $gm_action; ?>
                                             </label>
                                          </th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       if (isset($google_map_rectangle_data) && count($google_map_rectangle_data) > 0) {
                                          foreach ($google_map_rectangle_data as $data) {
                                             ?>
                                             <tr>
                                                <td class="chk-action" style="text-align:center;width: 5%;">
                                                   <input type="checkbox" name="ux_chk_rectangle_data_<?php echo intval($data['id']); ?>" id="ux_chk_rectangle_data_<?php echo intval($data['id']); ?>" onclick="all_check_google_maps('#ux_chk_all_maps_rectangle', oTable_rectangle);" value="<?php echo isset($data["id"]) ? intval($data["id"]) : ""; ?>">
                                                </td>
                                                <td style="width:27% !important;">
                                                   <?php echo esc_attr($data["rectangle_title"]); ?>
                                                </td style="width:60%;">
                                                <td>
                                                   <?php
                                                   $rectangle_coordinate = explode("\n", esc_attr($data["coordinates"]));
                                                   foreach ($rectangle_coordinate as $coordinate) {
                                                      echo $coordinate . "<br>";
                                                   }
                                                   ?>
                                                </td>
                                                <td style="text-align:center;width:8% !important;">
                                                   <a href="javascript:void(0);" class="icon-custom-note tooltips" data-original-title="<?php echo $gm_edit_tooltip; ?>" data-placement="top"></a> |
                                                   <a href="javascript:void(0);" class="icon-custom-trash tooltips custom-delete-icon-custom-live" data-original-title="<?php echo $gm_map_delete; ?>" onclick="premium_edition_notification_google_maps_bank();" data-placement="top"></a>
                                                </td>
                                             </tr>
                                             <?php
                                          }
                                       }
                                       ?>
                                    </tbody>
                                 </table>
                              </div>
                              <div id="ux_div_overlay_rectangle_settings" style="display:none">
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_rectangle_title; ?>
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_rectangle_title_tooltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " )"; ?></span>
                                    </label>
                                    <input type="text" class="form-control" name="ux_txt_rectangle_title" id="ux_txt_rectangle_title"  value="<?php echo isset($serialize_rectangle_edit_data["rectangle_title"]) ? esc_attr($serialize_rectangle_edit_data["rectangle_title"]) : ""; ?>" placeholder="<?php echo $gm_rectangle_title_placeholder; ?>">
                                 </div>
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_rectangle_description; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_rectangle_description_tooltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true"> <?php echo " ( " . $gm_premium_edition_label . " )"; ?> </span>
                                    </label>
                                    <textarea class="form-control" name="ux_txt_rectangle_desc" id="ux_txt_rectangle_desc" rows="4" placeholder="<?php echo $gm_rectangle_description_placeholder; ?>"><?php echo isset($serialize_rectangle_edit_data['rectangle_description']) ? esc_html($serialize_rectangle_edit_data['rectangle_description']) : ""; ?></textarea>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_stroke_color; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_rectangle_stroke_color_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " )"; ?></span>
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
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " )"; ?></span>
                                          </label>
                                          <div class="input-icon right">
                                             <input type="text" class="form-control custom-input-medium valid" name="ux_txt_rectangle_fill_color_opacity[]" id="ux_txt_rectangle_fill_color" onblur="default_value_google_maps('#ux_txt_rectangle_fill_color', '#000000');" onfocus="google_map_color_picker('#ux_txt_rectangle_fill_color', this.value)" value="<?php echo isset($rectangle_fill_color_and_opacity[0]) ? esc_attr($rectangle_fill_color_and_opacity[0]) : "#000000"; ?>" placeholder="<?php echo $gm_fill_color_placeholder; ?>">
                                             <input type="text" class="form-control custom-input-medium valid" name="ux_txt_rectangle_fill_color_opacity[]" id="ux_txt_rectangle_fill_color_opacity" maxlength="3" onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_rectangle_fill_color_opacity', '75', 'width');" onkeypress="only_digits_google_maps(event);" value="<?php echo isset($rectangle_fill_color_and_opacity[1]) ? intval($rectangle_fill_color_and_opacity[1]) : 75; ?>" placeholder="<?php echo $gm_fill_opacity_placeholder; ?>">
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-group" style="margin-top:15px;">
                                    <label class="control-label">
                                       <?php echo $gm_coordinates; ?>
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_rectangle_coordinate_tooltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " )"; ?></span>
                                    </label>
                                    <textarea class="form-control" name="ux_txt_rectangle_coordinate" id="ux_txt_rectangle_coordinate" rows="4" readonly="true" placeholder="<?php echo $gm_coordinate_placeholder; ?>" onfocus="paste_prevent_google_maps(this.id);"><?php echo isset($serialize_rectangle_edit_data["coordinates"]) ? esc_attr($serialize_rectangle_edit_data["coordinates"]) : ""; ?></textarea>
                                 </div>
                                 <div class="form-group">
                                    <label class="control-label">
                                       <?php echo $gm_info_window; ?> :
                                       <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_info_window_tooltips; ?>" data-placement="right"></i>
                                       <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " )"; ?></span>
                                    </label>
                                    <select name="ux_ddl_rectangle_info_window" id="ux_ddl_rectangle_info_window" class="form-control" onchange='google_maps_info_window("#ux_ddl_rectangle_info_window", "#ux_div_rectangle_info_window_image", "#wp_media_upload_rectangle_error_info");'>
                                       <option value="enable"><?php echo $gm_enable; ?></option>
                                       <option value="disable"><?php echo $gm_disable; ?></option>
                                    </select>
                                 </div>
                                 <div id="ux_div_rectangle_info_window_image" style="display:none;">
                                    <div class="form-group">
                                       <label class="control-label">
                                          <?php echo $gm_info_window_images; ?> :
                                          <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_info_window_images_tooltips; ?>" data-placement="right"></i>
                                          <span class="required" aria-required="true"> <?php echo " ( " . $gm_premium_edition_label . " )"; ?> </span>
                                       </label>
                                       <div class="input-icon right">
                                          <input type="text" class="form-control custom-input-middle input-inline" readonly="true" name="ux_txt_image_upload_rectangle_path" id="ux_txt_image_upload_rectangle_path" placeholder="<?php echo $gm_info_window_images_upload_placeholder; ?>" value="<?php echo isset($serialize_rectangle_edit_data["image_upload_rectangle_path"]) ? esc_attr($serialize_rectangle_edit_data["image_upload_rectangle_path"]) : ""; ?>">
                                          <input type="button" class="btn vivid-green custom-top" name="ux_upload_info_image" id="ux_upload_info_image" onclick="premium_edition_notification_google_maps_bank();" value="<?php echo $gm_upload; ?>">
                                          <input type="button" class="btn vivid-green custom-top" name="ux_clear_info_image" id="ux_clear_info_image" onclick="premium_edition_notification_google_maps_bank();"  value="<?php echo $gm_clear; ?>">
                                       </div>
                                    </div>
                                 </div>
                                 <p id="wp_media_upload_rectangle_error_info" class="wp-media-error-message"><?php echo $gm_media_error_settings_message; ?></p>
                                 <div class="line-separator"></div>
                                 <div class="form-actions">
                                    <div class="pull-right">
                                       <input type="button" name="ux_btn_cancel_rectangle" class="btn vivid-green" id="ux_btn_cancel_rectangle" value="<?php echo $gm_cancel_button; ?>" onclick="google_maps_cancel_maps_overlay_settings('admin.php?page=gmb_add_map<?php echo $mapid; ?>&overlay=rectangle');">
                                       <input type="submit" name="ux_btn_add_rectangle" class="btn vivid-green" id="ux_btn_add_rectangle" value="<?php echo isset($_REQUEST["edit"]) ? $gm_update_rectangle : $gm_add_rectangle; ?>">
                                    </div>
                                 </div>
                              </div>
                              <div id="ux_div_maps_action">
                                 <div class="line-separator"></div>
                                 <div class="form-actions">
                                    <div class="pull-left">
                                       <a class="btn vivid-green" name="ux_btn_previous_step_basic" id="ux_btn_previous_step_basic" onclick="google_maps_move_to_first_step(); window.location.href = 'admin.php?page=gmb_add_map<?php echo $mapid; ?>'"><?php echo "<< " . $gm_previous_step; ?></a>
                                    </div>
                                    <div class="pull-right">
                                       <a class="btn vivid-green" name="ux_btn_next_step_layers" id="ux_btn_next_step_layers" onclick="window.location.href = 'admin.php?page=gmb_add_map<?php echo $mapid; ?>&layers'"><?php echo $gm_next_step . " >>"; ?></a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div id="ux_div_third_step_layers" style="display:none">
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
                                    <textarea class="form-control" name="ux_txt_coordinates" id="ux_txt_coordinates" rows="4" placeholder="<?php echo $gm_heatmap_coordinates_placeholder; ?>"><?php echo isset($google_map_layers_data["heatmap_coordinates"]) ? esc_attr($google_map_layers_data["heatmap_coordinates"]) : ""; ?></textarea>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_heatmap_opacity; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_heatmap_opacity_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " )"; ?></span>
                                          </label>
                                          <input type="text" class="form-control" name="ux_txt_heatmap_opacity" id="ux_txt_heatmap_opacity" maxlength="3" value="<?php echo isset($google_map_layers_data["heatmap_opacity"]) ? intval($google_map_layers_data["heatmap_opacity"]) : 75; ?>" placeholder="<?php echo $gm_heatmap_opacity_placeholder; ?>"  onfocus="paste_prevent_google_maps(this.id);" onblur="default_value_google_maps('#ux_txt_heatmap_opacity', '75', 'width');" onkeypress="only_digits_google_maps(event);">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="control-label">
                                             <?php echo $gm_heatmap_radius; ?> :
                                             <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_heatmap_radius_tooltips; ?>" data-placement="right"></i>
                                             <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " )"; ?></span>
                                          </label>
                                          <input type="text" class="form-control" name="ux_txt_heatmap_radius" id="ux_txt_heatmap_radius" maxlength = "3" value="<?php echo isset($google_map_layers_data["heatmap_radius"]) ? intval($google_map_layers_data["heatmap_radius"]) : 20; ?>" placeholder="<?php echo $gm_heatmap_radius_placeholder; ?>" onblur="default_value_google_maps('#ux_txt_heatmap_radius', '20', 'width');" onkeypress="only_digits_google_maps(event);" onfocus="paste_prevent_google_maps(this.id);">
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
                                 <select name="ux_ddl_enable_fusion_table_layer" id="ux_ddl_enable_fusion_table_layer" class="form-control" onchange="show_hide_controls_google_maps('#ux_ddl_enable_fusion_table_layer', '#ux_div_enable_fusion_table_layer');">
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
                                 <input type="text" class="form-control" name="ux_txt_fusion_table_id" id="ux_txt_fusion_table_id" value="<?php echo isset($google_map_layers_data["fusion_table_id"]) ? esc_attr($google_map_layers_data["fusion_table_id"]) : ""; ?>" placeholder="<?php echo $gm_fusion_table_id_placeholder; ?>">
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
                                    <input type="text" class="form-control" name="ux_txt_kml_url" id="ux_txt_kml_url" value="<?php echo isset($google_map_layers_data["kml_url"]) ? esc_attr($google_map_layers_data["kml_url"]) : ""; ?>" placeholder="<?php echo $gm_kml_url_placeholder; ?>">
                                 </div>
                              </div>
                              <div class="line-separator"></div>
                              <div class="form-actions">
                                 <div class="pull-left">
                                    <a class="btn vivid-green" name="ux_btn_previous_step_overlays" id="ux_btn_previous_step_overlays" onclick="google_maps_move_to_second_step();"><?php echo "<< " . $gm_previous_step; ?></a>
                                 </div>
                                 <div class="pull-right">
                                    <input type="submit" class="btn vivid-green" name="ux_btn_add_maps_settings" id="ux_btn_add_maps_settings" value="<?php echo $gm_save_changes; ?>">
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
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
               <a href="admin.php?page=gmb_google_maps">
                  <?php echo $gm_google_maps; ?>
               </a>
               <span>></span>
            </li>
            <li>
               <span>
                  <?php echo $gm_add_map; ?>
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
                     <?php echo $gm_add_map; ?>
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