<?php
/**
 * This Template is used for manage roles and capabilities.
 *
 * @author  Tech Banker
 * @package google-maps-bank/views/roles-and-capabilities
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
   } else if (roles_and_capabilities_google_map == "1") {
      $roles_and_capabilities = isset($details_roles_capabilities["roles_and_capabilities"]) ? explode(",", esc_attr($details_roles_capabilities["roles_and_capabilities"])) : "";
      $administrator = isset($details_roles_capabilities["administrator_privileges"]) ? explode(",", esc_attr($details_roles_capabilities["administrator_privileges"])) : "";
      $author = isset($details_roles_capabilities["author_privileges"]) ? explode(",", esc_attr($details_roles_capabilities["author_privileges"])) : "";
      $editor = isset($details_roles_capabilities["editor_privileges"]) ? explode(",", esc_attr($details_roles_capabilities["editor_privileges"])) : "";
      $contributor = isset($details_roles_capabilities["contributor_privileges"]) ? explode(",", esc_attr($details_roles_capabilities["contributor_privileges"])) : "";
      $subscriber = isset($details_roles_capabilities["subscriber_privileges"]) ? explode(",", esc_attr($details_roles_capabilities["subscriber_privileges"])) : "";
      $other = isset($details_roles_capabilities["other_roles_privileges"]) ? explode(",", esc_attr($details_roles_capabilities["other_roles_privileges"])) : "";
      ?>
      <div class="page-bar">
         <ul class="page-breadcrumb">
            <li>
               <i class="icon-custom-home"></i>
               <a href="admin.php?page=gmb_google_maps">
                  <?php echo $google_maps_bank ?>
               </a>
               <span>></span>
            </li>
            <li>
               <span>
                  <?php echo $gm_roles_and_capabilities_label ?>
               </span>
            </li>
         </ul>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="portlet box vivid-green">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="icon-custom-users"></i>
                     <?php echo $gm_roles_and_capabilities_label; ?>
                  </div>
                  <a href="http://beta.tech-banker.com/products/google-maps-bank/" target="_blank" class="premium-editions"><?php echo $mb_upgrade_to ?></a>
               </div>
               <div class="portlet-body form">
                  <form id="ux_frm_roles_and_capabilities">
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
                        <div class="form-group">
                           <label class="control-label">
                              <?php echo $gm_roles_and_capabilities_show_google_maps_menu_label; ?> :
                              <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_roles_and_capabilities_sidebar_menu_tooltip; ?>" data-placement="right"></i>
                              <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                           </label>
                           <table class="table table-striped table-bordered table-margin-top" id="ux_tbl_plugin_settings">
                              <thead>
                                 <tr>
                                    <th>
                                       <input type="checkbox" name="ux_chk_administrator" id="ux_chk_administrator" checked="checked" disabled="disabled" value="1" <?php echo $roles_and_capabilities[0] == "1" ? "checked = checked" : "" ?>>
                                       <?php echo $gm_roles_and_capabilities_administrator_label; ?>
                                    </th>
                                    <th>
                                       <input type="checkbox" name="ux_chk_author" id="ux_chk_author" value="1" onclick="show_roles_capabilities_google_maps(this, 'ux_div_author_roles');" <?php echo $roles_and_capabilities[1] == "1" ? "checked = checked" : "" ?>>
                                       <?php echo $gm_roles_and_capabilities_author_label; ?>
                                    </th>
                                    <th>
                                       <input type="checkbox" name="ux_chk_editor" id="ux_chk_editor" value="1" onclick="show_roles_capabilities_google_maps(this, 'ux_div_editor_roles');" <?php echo $roles_and_capabilities[2] == "1" ? "checked = checked" : "" ?>>
                                       <?php echo $gm_roles_and_capabilities_editor_label; ?>
                                    </th>
                                    <th>
                                       <input type="checkbox" name="ux_chk_contributor" id="ux_chk_contributor" value="1" onclick="show_roles_capabilities_google_maps(this, 'ux_div_contributor_roles');" <?php echo $roles_and_capabilities[3] == "1" ? "checked = checked" : "" ?>>
                                       <?php echo $gm_roles_and_capabilities_contributor_label; ?>
                                    </th>
                                    <th>
                                       <input type="checkbox" name="ux_chk_subscriber" id="ux_chk_subscriber" value="1" onclick="show_roles_capabilities_google_maps(this, 'ux_div_subscriber_roles');" <?php echo $roles_and_capabilities[4] == "1" ? "checked = checked" : "" ?>>
                                       <?php echo $gm_roles_and_capabilities_subscriber_label; ?>
                                    </th>
                                    <th>
                                       <input type="checkbox" name="ux_chk_other" id="ux_chk_other" value="1" onclick="show_roles_capabilities_google_maps(this, 'ux_div_other_roles');" <?php echo $roles_and_capabilities[5] == "1" ? "checked = checked" : "" ?>>
                                       <?php echo $gm_roles_and_capabilities_other_label; ?>
                                    </th>
                                 </tr>
                              </thead>
                           </table>
                        </div>
                        <div class="form-group">
                           <label class="control-label">
                              <?php echo $gm_roles_and_capabilities_show_google_maps_top_menu_label; ?> :
                              <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_roles_and_capabilities_top_bar_menu_tooltip; ?>" data-placement="right"></i>
                              <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                           </label>
                           <div class="input-icon right">
                              <select id="ux_ddl_top_bar" name="ux_ddl_top_bar" class="form-control">
                                 <option value="enable"><?php echo $gm_enable; ?></option>
                                 <option value="disable"><?php echo $gm_disable; ?></option>
                              </select>
                           </div>
                        </div>
                        <div class="line-separator"></div>
                        <div class="form-group">
                           <div id="ux_div_administrator_roles">
                              <label class="control-label">
                                 <?php echo $gm_roles_and_capabilities_administrator_role_label; ?> :
                                 <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_roles_and_capabilities_admin_access_tooltip; ?>" data-placement="right"></i>
                                 <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                              </label>
                              <div class="table-margin-top">
                                 <table class="table table-striped table-bordered table-hover" id="ux_tbl_administrator">
                                    <thead>
                                       <tr>
                                          <th style="width: 40% !important;">
                                             <input type="checkbox" name="ux_chk_full_control_administrator" id="ux_chk_full_control_administrator" checked="checked" disabled="disabled" value="1">
                                             <?php echo $gm_roles_and_capabilities_full_control_label; ?>
                                          </th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                          <td>
                                             <input type="checkbox" name="ux_chk_manage_maps_admin" disabled="disabled" checked="checked" id="ux_chk_manage_maps_admin" value="1">
                                             <?php echo $gm_google_maps; ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_overlays_admin" disabled="disabled" checked="checked" id="ux_chk_overlays_admin" value="1">
                                             <?php echo $gm_overlays; ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_layers_admin" disabled="disabled" checked="checked" id="ux_chk_layers_admin" value="1">
                                             <?php echo $gm_layers; ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <input type="checkbox" name="ux_chk_store_locator_admin" disabled="disabled" checked="checked" id="ux_chk_store_locator_admin" value="1">
                                             <?php echo $gm_store_locator; ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_layout_settings_admin" disabled="disabled" checked="checked" id="ux_chk_layout_settings_admin" value="1">
                                             <?php echo $gm_layout_settings; ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_custom_css_admin" disabled="disabled" checked="checked" id="ux_chk_custom_css_admin" value="1">
                                             <?php echo $gm_custom_css; ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <input type="checkbox" name="ux_chk_shortcode_admin" disabled="disabled" checked="checked" id="ux_chk_shortcode_admin" value="1">
                                             <?php echo $gm_shortcode ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_other_settings_admin" disabled="disabled" checked="checked" id="ux_chk_other_settings_admin" value="1">
                                             <?php echo $gm_other_settings ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_roles_and_capabilities_admin" disabled="disabled" checked="checked" id="ux_chk_roles_and_capabilities_admin" value="1">
                                             <?php echo $gm_roles_and_capabilities ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <input type="checkbox" name="ux_chk_system_information_admin" disabled="disabled" checked="checked" id="ux_chk_system_information_admin" value="1">
                                             <?php echo $gm_system_information ?>
                                          </td>
                                          <td>
                                          </td>
                                          <td>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                              <div class="line-separator"></div>
                           </div>
                        </div>
                        <div class="form-group">
                           <div id="ux_div_author_roles">
                              <label class="control-label">
                                 <?php echo $gm_roles_and_capabilities_author_role_label ?> :
                                 <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_roles_and_capabilities_author_access_tooltip; ?>" data-placement="right"></i>
                                 <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                              </label>
                              <div class="table-margin-top">
                                 <table class="table table-striped table-bordered table-hover" id="ux_tbl_author">
                                    <thead>
                                       <tr>
                                          <th style="width: 40% !important;">
                                             <input type="checkbox" name="ux_chk_full_control_author" id="ux_chk_full_control_author" value="1" onclick="full_control_function_google_maps(this, 'ux_div_author_roles');" <?php echo isset($author) && $author[0] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_roles_and_capabilities_full_control_label; ?>
                                          </th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                          <td>
                                             <input type="checkbox" name="ux_chk_manage_maps_author" id="ux_chk_manage_maps_author" value="1" <?php echo isset($author) && $author[1] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_google_maps; ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_overlays_author" id="ux_chk_overlays_author" value="1" <?php echo isset($author) && $author[2] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_overlays; ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_layers_author" id="ux_chk_layers_author" value="1" <?php echo isset($author) && $author[3] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_layers; ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <input type="checkbox" name="ux_chk_store_locator_author" id="ux_chk_store_locator_author" value="1" <?php echo isset($author) && $author[4] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_store_locator ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_layout_settings_author" id="ux_chk_layout_settings_author" value="1" <?php echo isset($author) && $author[5] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_layout_settings ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_custom_css_author" id="ux_chk_custom_css_author" value="1" <?php echo isset($author) && $author[6] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_custom_css; ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <input type="checkbox" name="ux_chk_shortcode_author" id="ux_chk_shortcode_author" value="1" <?php echo isset($author) && $author[7] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_shortcode; ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_other_settings_author" id="ux_chk_other_settings_author" value="1" <?php echo isset($author) && $author[8] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_other_settings; ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_roles_and_capabilities_author" id="ux_chk_roles_and_capabilities_author" value="1" <?php echo isset($author) && $author[9] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_roles_and_capabilities; ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <input type="checkbox" name="ux_chk_system_information_author" id="ux_chk_system_information_author" value="1" <?php echo isset($author) && $author[10] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_system_information; ?>
                                          </td>
                                          <td>
                                          </td>
                                          <td>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                              <div class="line-separator"></div>
                           </div>
                        </div>
                        <div class="form-group">
                           <div id="ux_div_editor_roles">
                              <label class="control-label">
                                 <?php echo $gm_roles_and_capabilities_editor_role_label ?> :
                                 <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_roles_and_capabilities_editor_access_tooltip; ?>" data-placement="right"></i>
                                 <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                              </label>
                              <div class="table-margin-top">
                                 <table class="table table-striped table-bordered table-hover" id="ux_tbl_editor">
                                    <thead>
                                       <tr>
                                          <th style="width: 40% !important;">
                                             <input type="checkbox" name="ux_chk_full_control_editor" id="ux_chk_full_control_editor" value="1" onclick="full_control_function_google_maps(this, 'ux_div_editor_roles');" <?php echo isset($editor) && $editor[0] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_roles_and_capabilities_full_control_label; ?>
                                          </th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                          <td>
                                             <input type="checkbox" name="ux_chk_manage_maps_editor" id="ux_chk_manage_maps_editor" value="1" <?php echo isset($editor) && $editor[1] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_google_maps; ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_overlays_editor" id="ux_chk_overlays_editor" value="1" <?php echo isset($editor) && $editor[2] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_overlays; ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_layers_editor" id="ux_chk_layers_editor" value="1" <?php echo isset($editor) && $editor[3] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_layers; ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <input type="checkbox" name="ux_chk_store_locator_editor" id="ux_chk_store_locator_editor" value="1" <?php echo isset($editor) && $editor[4] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_store_locator ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_layout_settings_editor" id="ux_chk_layout_settings_editor" value="1" <?php echo isset($editor) && $editor[5] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_layout_settings ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_custom_css_editor" id="ux_chk_custom_css_editor" value="1" <?php echo isset($editor) && $editor[6] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_custom_css; ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <input type="checkbox" name="ux_chk_shortcode_editor" id="ux_chk_shortcode_editor" value="1" <?php echo isset($editor) && $editor[7] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_shortcode; ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_other_settings_editor" id="ux_chk_other_settings_editor" value="1" <?php echo isset($editor) && $editor[8] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_other_settings; ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_roles_and_capabilities_editor" id="ux_chk_roles_and_capabilities_editor" value="1" <?php echo isset($editor) && $editor[9] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_roles_and_capabilities; ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <input type="checkbox" name="ux_chk_system_information_editor" id="ux_chk_system_information_editor" value="1" <?php echo isset($editor) && $editor[10] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_system_information; ?>
                                          </td>
                                          <td>
                                          </td>
                                          <td>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                              <div class="line-separator"></div>
                           </div>
                        </div>
                        <div class="form-group">
                           <div id="ux_div_contributor_roles">
                              <label class="control-label">
                                 <?php echo $gm_roles_and_capabilities_contributor_role_label ?> :
                                 <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_roles_and_capabilities_contributor_access_tooltip; ?>" data-placement="right"></i>
                                 <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                              </label>
                              <div class="table-margin-top">
                                 <table class="table table-striped table-bordered table-hover" id="ux_tbl_contributor">
                                    <thead>
                                       <tr>
                                          <th style="width: 40% !important;">
                                             <input type="checkbox" name="ux_chk_full_control_contributor" id="ux_chk_full_control_contributor" value="1" onclick="full_control_function_google_maps(this, 'ux_div_contributor_roles');" <?php echo isset($contributor) && $contributor[0] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_roles_and_capabilities_full_control_label; ?>
                                          </th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                          <td>
                                             <input type="checkbox" name="ux_chk_manage_maps_contributor" id="ux_chk_manage_maps_contributor" value="1" <?php echo isset($contributor) && $contributor[1] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_google_maps; ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_overlays_contributor" id="ux_chk_overlays_contributor" value="1" <?php echo isset($contributor) && $contributor[2] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_overlays; ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_layers_contributor" id="ux_chk_layers_contributor" value="1" <?php echo isset($contributor) && $contributor[3] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_layers; ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <input type="checkbox" name="ux_chk_store_locator_contributor" id="ux_chk_store_locator_contributor" value="1" <?php echo isset($contributor) && $contributor[4] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_store_locator ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_layout_settings_contributor" id="ux_chk_layout_settings_contributor" value="1" <?php echo isset($contributor) && $contributor[5] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_layout_settings ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_custom_css_contributor" id="ux_chk_custom_css_contributor" value="1" <?php echo isset($contributor) && $contributor[6] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_custom_css; ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <input type="checkbox" name="ux_chk_shortcode_contributor" id="ux_chk_shortcode_contributor" value="1" <?php echo isset($contributor) && $contributor[7] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_shortcode; ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_other_settings_contributor" id="ux_chk_other_settings_contributor" value="1" <?php echo isset($contributor) && $contributor[8] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_other_settings; ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_roles_and_capabilities_contributor" id="ux_chk_roles_and_capabilities_contributor" value="1" <?php echo isset($contributor) && $contributor[9] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_roles_and_capabilities; ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <input type="checkbox" name="ux_chk_system_information_contributor" id="ux_chk_system_information_contributor" value="1" <?php echo isset($contributor) && $contributor[10] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_system_information; ?>
                                          </td>
                                          <td>
                                          </td>
                                          <td>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                              <div class="line-separator"></div>
                           </div>
                        </div>
                        <div class="form-group">
                           <div id="ux_div_subscriber_roles">
                              <label class="control-label">
                                 <?php echo $gm_roles_and_capabilities_subscriber_role_label ?> :
                                 <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_roles_and_capabilities_subscriber_access_tooltip; ?>" data-placement="right"></i>
                                 <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                              </label>
                              <div class="table-margin-top">
                                 <table class="table table-striped table-bordered table-hover" id="ux_tbl_subscriber">
                                    <thead>
                                       <tr>
                                          <th style="width: 40% !important;">
                                             <input type="checkbox" name="ux_chk_full_control_subscriber" id="ux_chk_full_control_subscriber" value="1" onclick="full_control_function_google_maps(this, 'ux_div_subscriber_roles');" <?php echo isset($subscriber) && $subscriber[0] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_roles_and_capabilities_full_control_label; ?>
                                          </th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                          <td>
                                             <input type="checkbox" name="ux_chk_manage_maps_subscriber" id="ux_chk_manage_maps_subscriber" value="1" <?php echo isset($subscriber) && $subscriber[1] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_google_maps; ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_overlays_subscriber" id="ux_chk_overlays_subscriber" value="1" <?php echo isset($subscriber) && $subscriber[2] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_overlays; ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_layers_subscriber" id="ux_chk_layers_subscriber" value="1" <?php echo isset($subscriber) && $subscriber[3] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_layers; ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <input type="checkbox" name="ux_chk_store_locator_subscriber" id="ux_chk_store_locator_subscriber" value="1" <?php echo isset($subscriber) && $subscriber[4] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_store_locator ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_layout_settings_subscriber" id="ux_chk_layout_settings_subscriber" value="1" <?php echo isset($subscriber) && $subscriber[5] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_layout_settings ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_custom_css_subscriber" id="ux_chk_custom_css_subscriber" value="1" <?php echo isset($subscriber) && $subscriber[6] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_custom_css; ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <input type="checkbox" name="ux_chk_shortcode_subscriber" id="ux_chk_shortcode_subscriber" value="1" <?php echo isset($subscriber) && $subscriber[7] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_shortcode; ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_other_settings_subscriber" id="ux_chk_other_settings_subscriber" value="1" <?php echo isset($subscriber) && $subscriber[8] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_other_settings; ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_roles_and_capabilities_subscriber" id="ux_chk_roles_and_capabilities_subscriber" value="1" <?php echo isset($subscriber) && $subscriber[9] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_roles_and_capabilities; ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <input type="checkbox" name="ux_chk_system_information_subscriber" id="ux_chk_system_information_subscriber" value="1" <?php echo isset($subscriber) && $subscriber[10] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_system_information; ?>
                                          </td>
                                          <td>
                                          </td>
                                          <td>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                              <div class="line-separator"></div>
                           </div>
                        </div>
                        <div class="form-group">
                           <div id="ux_div_other_roles">
                              <label class="control-label">
                                 <?php echo $gm_roles_capabilities_other_role ?> :
                                 <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_roles_capabilities_other_role_tooltip; ?>" data-placement="right"></i>
                                 <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                              </label>
                              <div class="table-margin-top">
                                 <table class="table table-striped table-bordered table-hover" id="ux_tbl_other">
                                    <thead>
                                       <tr>
                                          <th style="width: 40% !important;">
                                             <input type="checkbox" name="ux_chk_full_control_other" id="ux_chk_full_control_other" value="1" onclick="full_control_function_google_maps(this, 'ux_div_other_roles');" <?php echo isset($other) && $other[0] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_roles_and_capabilities_full_control_label; ?>
                                          </th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                          <td>
                                             <input type="checkbox" name="ux_chk_manage_maps_other" id="ux_chk_manage_maps_other" value="1" <?php echo isset($other) && $other[1] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_google_maps; ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_overlays_other" id="ux_chk_overlays_other" value="1" <?php echo isset($other) && $other[2] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_overlays; ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_layers_other" id="ux_chk_layers_other" value="1" <?php echo isset($other) && $other[3] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_layers; ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <input type="checkbox" name="ux_chk_store_locator_other" id="ux_chk_store_locator_other" value="1" <?php echo isset($other) && $other[4] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_store_locator ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_layout_settings_other" id="ux_chk_layout_settings_other" value="1" <?php echo isset($other) && $other[5] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_layout_settings ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_custom_css_other" id="ux_chk_custom_css_other" value="1" <?php echo isset($other) && $other[6] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_custom_css; ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <input type="checkbox" name="ux_chk_shortcode_other" id="ux_chk_shortcode_other" value="1" <?php echo isset($other) && $other[7] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_shortcode; ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_other_settings_other" id="ux_chk_other_settings_other" value="1" <?php echo isset($other) && $other[8] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_other_settings; ?>
                                          </td>
                                          <td>
                                             <input type="checkbox" name="ux_chk_roles_and_capabilities_other" id="ux_chk_roles_and_capabilities_other" value="1" <?php echo isset($other) && $other[9] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_roles_and_capabilities; ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <input type="checkbox" name="ux_chk_system_information_other" id="ux_chk_system_information_other" value="1" <?php echo isset($other) && $other[10] == "1" ? "checked = checked" : "" ?>>
                                             <?php echo $gm_system_information; ?>
                                          </td>
                                          <td>
                                          </td>
                                          <td>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                              <div class="line-separator"></div>
                           </div>
                        </div>
                        <div class="form-group">
                           <div id="ux_div_other_roles_capabilities">
                              <label class="control-label">
                                 <?php echo $gm_roles_and_capabilities_other_roles_capabilities; ?> :
                                 <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_roles_and_capabilities_other_roles_capabilities_tooltip; ?>" data-placement="right"></i>
                                 <span class="required" aria-required="true">* <?php echo " ( " . $gm_premium_edition_label . " ) "; ?></span>
                              </label>
                              <div class="table-margin-top">
                                 <table class="table table-striped table-bordered table-hover" id="ux_tbl_other_roles">
                                    <thead>
                                       <tr>
                                          <th style="width: 40% !important;">
                                             <input type="checkbox" name="ux_chk_full_control_other_roles" id="ux_chk_full_control_other_roles" value="1" onclick="full_control_function_google_maps(this, 'ux_div_other_roles_capabilities')">
                                             <?php echo $gm_roles_and_capabilities_full_control_label; ?>
                                          </th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       $flag = 0;
                                       $user_capabilities = get_others_capabilities_google_maps();
                                       if (isset($user_capabilities) && count($user_capabilities) > 0) {
                                          foreach ($user_capabilities as $key => $value) {
                                             $other_roles = in_array($value, $other_roles_array) ? "checked=checked" : "";
                                             $flag++;
                                             if ($key % 3 == 0) {
                                                ?>
                                                <tr>
                                                   <?php
                                                }
                                                ?>
                                                <td>
                                                   <input type="checkbox" name="ux_chk_other_capabilities_<?php echo $value; ?>" id="ux_chk_other_capabilities_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php echo $other_roles; ?>>
                                                   <?php echo $value; ?>
                                                </td>
                                                <?php
                                                if (count($user_capabilities) == $flag && $flag % 3 == 1) {
                                                   ?>
                                                   <td>
                                                   </td>
                                                   <td>
                                                   </td>
                                                   <?php
                                                }
                                                ?>
                                                <?php
                                                if (count($user_capabilities) == $flag && $flag % 3 == 2) {
                                                   ?>
                                                   <td>
                                                   </td>
                                                   <?php
                                                }
                                                ?>
                                                <?php
                                                if ($flag % 3 == 0) {
                                                   ?>
                                                </tr>
                                                <?php
                                             }
                                          }
                                       }
                                       ?>
                                    </tbody>
                                 </table>
                              </div>
                              <div class="line-separator"></div>
                           </div>
                        </div>
                        <div class="form-actions">
                           <div class="pull-right">
                              <input type="submit" class="btn vivid-green" id="btn_save_roles_capabilities" name="btn_save_roles_capabilities" value="<?php echo $gm_save_changes; ?>">
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
                  <?php echo $gm_roles_and_capabilities_label; ?>
               </span>
            </li>
         </ul>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="portlet box vivid-green">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="icon-custom-user"></i>
                     <?php echo $gm_roles_and_capabilities_label; ?>
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