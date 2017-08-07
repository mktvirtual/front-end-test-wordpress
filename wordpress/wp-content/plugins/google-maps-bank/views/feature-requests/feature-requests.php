<?php
/**
 * This Template is used for sending feature request.
 *
 * @author  Tech Banker
 * @package google-maps-bank/views/feature-request
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
   } else {
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
                  <?php echo $gm_feature_requests ?>
               </span>
            </li>
         </ul>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="portlet box vivid-green">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="icon-custom-call-out"></i>
                     <?php echo $gm_feature_requests; ?>
                  </div>
                  <a href="http://beta.tech-banker.com/products/google-maps-bank/" target="_blank" class="premium-editions"><?php echo $mb_upgrade_to ?></a>
               </div>
               <div class="portlet-body form">
                  <form id="ux_frm_feature_request">
                     <div class="form-body">
                        <div class="note note-warning">
                           <h4 class="block">
                              <?php echo $gm_feature_requests_thank_you_label; ?>
                           </h4>
                           <p>
                              <?php echo $gm_feature_requests_fill_form_label; ?>
                           </p>
                           <p>
                              <?php echo $gm_feature_requests_suggestion_complaint_label; ?>
                           </p>
                           <p>
                              <?php echo $gm_feature_requests_write_us_label; ?>
                              <a href="mailto:support@tech-banker.com" target="_blank">support@tech-banker.com</a>
                           </p>
                           <?php
                           if ($gm_message_translate_help != "") {
                              ?>
                              <h4 class="block"
                                  <strong><?php echo $gm_message_translate_help; ?> <a href="javascript:void(0);" data-popup-open="ux_open_popup_translator" class="custom_links_feature" onclick="show_pop_up_google_map();"><?php echo $gm_message_translate_here; ?></a></strong>
                              </h4>
                              <?php
                           }
                           ?>
                        </div>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_feature_requests_your_name_label; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_feature_requests_your_name_tooltip; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*</span>
                                 </label>
                                 <input type="text" class="form-control" name="ux_txt_your_name" id="ux_txt_your_name" value="" placeholder="<?php echo $gm_feature_requests_your_name_placeholder; ?>">
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_feature_requests_your_email_label; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_feature_requests_your_email_tooltip; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*</span>
                                 </label>
                                 <input type="text" class="form-control" name="ux_txt_email_address" id="ux_txt_email_address" value=""  placeholder="<?php echo $gm_feature_requests_your_email_placeholder; ?>">
                              </div>
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="control-label">
                              <?php echo $gm_feature_request_label; ?> :
                              <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_feature_requests_tooltip; ?>" data-placement="right"></i>
                              <span class="required" aria-required="true">*</span>
                           </label>
                           <textarea class="form-control" name="ux_txtarea_feature_request" id="ux_txtarea_feature_request" rows="8"  placeholder="<?php echo $gm_feature_requests_placeholder; ?>"></textarea>
                        </div>
                        <div class="line-separator"></div>
                        <div class="form-actions">
                           <div class="pull-right">
                              <input type="submit" class="btn vivid-green" value="<?php echo $gm_send_request; ?>">
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <?php
   }
}