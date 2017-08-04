<?php
/**
 * This Template is used for managing maps.
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
      $google_maps_delete_nonce = wp_create_nonce("google_maps_data_delete_nonce");
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
                  <?php echo $gm_manage_map; ?>
               </span>
            </li>
         </ul>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="portlet box vivid-green">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="icon-custom-grid"></i>
                     <?php echo $gm_manage_map; ?>
                  </div>
                  <a href="http://beta.tech-banker.com/products/google-maps-bank/" target="_blank" class="premium-editions"><?php echo $mb_upgrade_to ?></a>
               </div>
               <div class="portlet-body form">
                  <form id="ux_frm_manage_maps">
                     <div class="form-body">
                        <?php
                        if ($gm_message_translate_help != "" || $total_maps_data >= 5) {
                           ?>
                           <div class="note note-danger">
                              <h4 class="block">
                                 <?php echo $gm_important_disclaimer; ?>
                              </h4>
                              <?php
                              if ($total_maps_data >= 5) {
                                 echo $gm_create_maps_disaclaimer;
                              }
                              ?>
                              <strong><?php echo $gm_message_translate_help; ?><a href="javascript:void(0);" data-popup-open="ux_open_popup_translator" class="custom_links" onclick="show_pop_up_google_map();"><?php echo $gm_message_translate_here; ?></a></strong>
                           </div>
                           <?php
                        }
                        ?>
                        <div class="table-top-margin">
                           <select name="ux_ddl_manage_maps" id="ux_ddl_manage_maps" class="custom-bulk-width">
                              <option value=""><?php echo $gm_bulk_action; ?></option>
                              <option value="delete" style="color: red;"><?php echo $gm_map_delete . " ( " . $gm_premium_edition_label . " ) "; ?></option>
                           </select>
                           <input type="button" class="btn vivid-green" name="ux_btn_apply" id="ux_btn_apply" value="<?php echo $gm_manage_map_apply; ?>" onclick="premium_edition_notification_google_maps_bank();">
                           <a href="admin.php?page=gmb_add_map" class="btn vivid-green" name="ux_btn_add_map" id="ux_btn_add_map" style="display:<?php echo $total_maps_data >= 5 ? "none" : ""; ?>"> <?php echo $gm_add_map; ?></a>
                        </div>
                        <div class="line-separator"></div>
                        <table class="table table-striped table-bordered table-hover table-margin-top" id="ux_tbl_manage_maps">
                           <thead>
                              <tr>
                                 <th style="text-align: center;" class="chk-action" style="width:5%;">
                                    <input type="checkbox" name="ux_chk_all_manage_maps" id="ux_chk_all_manage_maps">
                                 </th>
                                 <th style="width:20%;">
                                    <label>
                                       <?php echo $gm_map_title; ?>
                                    </label>
                                 </th>
                                 <th style="width:34%;">
                                    <label>
                                       <?php echo $gm_map_address; ?>
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
                              foreach ($google_maps_unserialize_data as $data) {
                                 ?>
                                 <tr>
                                    <td class="chk-action" style="text-align:center;width: 5%;">
                                       <input type="checkbox" name="ux_chk_manage_maps_<?php echo intval($data['meta_id']); ?>" id="ux_chk_manage_maps<?php echo intval($data['meta_id']); ?>" onclick="all_check_google_maps('#ux_chk_all_manage_maps', oTable);" value="<?php echo isset($data["meta_id"]) ? intval($data["meta_id"]) : ""; ?>">
                                    </td>
                                    <td style="width:20%;">
                                       <?php echo isset($data["map_title"]) ? esc_attr($data["map_title"]) : ""; ?>
                                    </td>
                                    <td style="width:34%;">
                                       <?php echo isset($data["formatted_address"]) ? esc_html($data["formatted_address"]) : ""; ?>
                                    </td>
                                    <td style="width:13%;">
                                       <?php echo isset($data["map_latitude"]) ? floatval($data["map_latitude"]) : 0; ?>
                                    </td>
                                    <td style="width:13%;">
                                       <?php echo isset($data["map_longitude"]) ? floatval($data["map_longitude"]) : 0; ?>
                                    </td>
                                    <td style="text-align:center;width:8%;">
                                       <a href="admin.php?page=gmb_add_map&google_map_id=<?php echo intval($data["meta_id"]); ?>" class="icon-custom-note tooltips" data-original-title="<?php echo $gm_edit_tooltip; ?>" data-placement="top"></a> |
                                       <a href="javascript:void(0);" class="icon-custom-trash tooltips custom-delete-icon-custom-live" data-original-title="<?php echo $gm_map_delete; ?>" onclick='delete_data_google_maps(<?php echo intval($data["meta_id"]); ?>, "<?php echo $gm_delete_single_map_data_message; ?>", "admin.php?page=gmb_google_maps", "<?php echo $google_maps_delete_nonce; ?>", "delete_maps_data_google_maps");' data-placement="top"></a>
                                    </td>
                                 </tr>
                                 <?php
                              }
                              ?>
                           </tbody>
                        </table>
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
               <a href="admin.php?page=gmb_google_maps">
                  <?php echo $gm_google_maps; ?>
               </a>
               <span>></span>
            </li>
            <li>
               <span>
                  <?php echo $gm_manage_map; ?>
               </span>
            </li>
         </ul>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="portlet box vivid-green">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="icon-custom-grid"></i>
                     <?php echo $gm_manage_map; ?>
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