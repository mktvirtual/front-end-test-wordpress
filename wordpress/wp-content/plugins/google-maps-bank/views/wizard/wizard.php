<?php
/**
 * This Template is used for Wizard
 *
 * @author  Tech Banker
 * @package google-maps-bank/views/wizard
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
      $google_maps_check_status = wp_create_nonce("google_maps_check_status");
      ?>
      <html>
         <body>
            <div><div><div>
                     <div class="page-container header-wizard">
                        <div class="page-content">
                           <div class="row row-custom row-bg">
                              <div class="col-md-1">
                              </div>
                              <div class="col-md-4 center">
                                 <b>
                                    <i class="dashicons dashicons-wordpress"></i>
                                 </b>
                              </div>
                              <div class="col-md-2 center">
                                 <i class="dashicons dashicons-plus"></i>
                              </div>
                              <div class="col-md-4 center">
                                 <img src="<?php echo plugins_url("assets/global/img/google-map-icon.png", dirname(dirname(__FILE__))); ?>" height="110" width="110">
                              </div>
                              <div class="col-md-1">
                              </div>
                           </div>
                           <div class="row row-custom">
                              <div class="col-md-12 textalign">
                                 <p>Hi there!</p>
                                 <p>Don't ever miss an opportunity to opt in for Email Notifications / Announcements about exciting New Features and Update Releases.</p>
                                 <p>Contribute in helping us making our plugin compatible with most plugins and themes by allowing to share non-sensitive information about your website.</p>
                                 <p>If you're not ready to Opt-In, that's ok too!</p>
                                 <p><strong>Google Maps Bank will still work fine.</strong></p>
                              </div>
                           </div>
                           <div class="row row-custom">
                              <div class="col-md-12">
                                 <a class="permissions" onclick="show_hide_details_google_maps();">What permissions are being granted?</a>
                              </div>
                              <div class="col-md-12" style="display:none;" id="ux_div_wizard_set_up">
                                 <div class="col-md-6">
                                    <ul>
                                       <li>
                                          <i class="dashicons dashicons-admin-users"></i>
                                          <div class="admin">
                                             <span><strong>User Details</strong></span>
                                             <p>Name and Email Address</p>
                                          </div>
                                       </li>
                                    </ul>
                                 </div>
                                 <div class="col-md-6 align align2">
                                    <ul>
                                       <li>
                                          <i class="dashicons dashicons-admin-plugins"></i>
                                          <div class="admin-plugins">
                                             <span><strong>Current Plugin Status</strong></span>
                                             <p>Activation, Deactivation and Uninstall</p>
                                          </div>
                                       </li>
                                    </ul>
                                 </div>
                                 <div class="col-md-6">
                                    <ul>
                                       <li>
                                          <i class="dashicons dashicons-testimonial"></i>
                                          <div class="testimonial">
                                             <span><strong>Notifications</strong></span>
                                             <p>Updates &amp; Announcements</p>
                                          </div>
                                       </li>
                                    </ul>
                                 </div>
                                 <div class="col-md-6 align2">
                                    <ul>
                                       <li>
                                          <i class="dashicons dashicons-welcome-view-site"></i>
                                          <div class="settings">
                                             <span><strong>Website Overview</strong></span>
                                             <p>Site URL, WP Version, PHP Info, Plugins &amp; Themes Info</p>
                                          </div>
                                       </li>
                                    </ul>
                                 </div>
                              </div>
                              <div class="col-md-12 allow">
                                 <div class="tech-banker-actions">
                                    <a onclick="plugin_stats_google_maps('opt_in');" class="button button-primary-wizard">
                                       <strong>Opt-In &amp; Continue </strong>
                                       <i class="dashicons dashicons-arrow-right-alt"></i>
                                    </a>
                                    <a onclick="plugin_stats_google_maps('skip');" class="button button-secondary-wizard" tabindex="2">
                                       <strong>Skip &amp; Continue </strong>
                                       <i class="dashicons dashicons-arrow-right-alt"></i>
                                    </a>
                                    <div class="clearfix"></div>
                                 </div>
                              </div>
                              <div class="col-md-12 terms">
                                 <a href="http://beta.tech-banker.com/privacy-policy/" target="_blank">Privacy Policy</a>
                                 <span> - </span>
                                 <a href="http://beta.tech-banker.com/terms-conditions/" target="_blank">Terms &amp; Conditions</a>
                              </div>
                           </div>
                        </div>
                     </div>
                     </body>
                     </html>
                     <?php
                  }
               }