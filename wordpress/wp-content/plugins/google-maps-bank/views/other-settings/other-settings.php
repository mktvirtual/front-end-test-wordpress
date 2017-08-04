<?php
/**
 * This Template is used for manage other settings.
 *
 * @author  Tech Banker
 * @package google-maps-bank/views/other-settings
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
   } else if (other_settings_google_map == "1") {
      $other_settings_nonce = wp_create_nonce("other_settings_nonce");
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
                  <?php echo $gm_other_settings ?>
               </span>
            </li>
         </ul>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="portlet box vivid-green">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="icon-custom-wrench"></i>
                     <?php echo $gm_other_settings; ?>
                  </div>
                  <a href="http://beta.tech-banker.com/products/google-maps-bank/" target="_blank" class="premium-editions"><?php echo $mb_upgrade_to ?></a>
               </div>
               <div class="portlet-body form">
                  <form id="ux_frm_other_settings">
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
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_other_settings_remove_tables_uninstall; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_other_settings_remove_tables_uninstall_tooltip; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*</span>
                                 </label>
                                 <select name="ux_ddl_remove_tables" id="ux_ddl_remove_tables" class="form-control">
                                    <option value="enable"><?php echo $gm_enable; ?></option>
                                    <option value="disable"><?php echo $gm_disable; ?></option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label class="control-label">
                                    <?php echo $gm_shortcode_map_language; ?> :
                                    <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_shortcode_map_language_tooltips; ?>" data-placement="right"></i>
                                    <span class="required" aria-required="true">*</span>
                                 </label>
                                 <select id="ux_ddl_map_language" name="ux_ddl_map_language" class="form-control" onchange="">
                                    <option value="af"><?php _e("Afrikaans", "google-maps-bank"); ?></option>
                                    <option value="sq"><?php _e("Albanian", "google-maps-bank"); ?></option>
                                    <option value="ar"><?php _e("Arabic", "google-maps-bank"); ?></option>
                                    <option value="eu"><?php _e("Basque", "google-maps-bank"); ?></option>
                                    <option value="be"><?php _e("Belarusian", "google-maps-bank"); ?></option>
                                    <option value="bn"><?php _e("Bengali", "google-maps-bank"); ?></option>
                                    <option value="bg"><?php _e("Bulgarian", "google-maps-bank"); ?></option>
                                    <option value="ca"><?php _e("Catalan", "google-maps-bank"); ?></option>
                                    <option value="zh-cn"><?php _e("Chinese (Simplified)", "google-maps-bank"); ?></option>
                                    <option value="zh-tw"><?php _e("Chinese (Traditional)", "google-maps-bank"); ?></option>
                                    <option value="hr"><?php _e("Croatian", "google-maps-bank"); ?></option>
                                    <option value="cs"><?php _e("Czech", "google-maps-bank"); ?></option>
                                    <option value="da"><?php _e("Danish", "google-maps-bank"); ?></option>
                                    <option value="nl"><?php _e("Dutch", "google-maps-bank"); ?></option>
                                    <option value="nl-be"><?php _e("Dutch (Belgium)", "google-maps-bank"); ?></option>
                                    <option value="nl-nl"><?php _e("Dutch (Netherlands)", "google-maps-bank"); ?></option>
                                    <option value="en"><?php _e("English", "google-maps-bank"); ?></option>
                                    <option value="en-au"><?php _e("English (Australia)", "google-maps-bank"); ?></option>
                                    <option value="en-bz"><?php _e("English (Belize)", "google-maps-bank"); ?></option>
                                    <option value="en-ca"><?php _e("English (Canada)", "google-maps-bank"); ?></option>
                                    <option value="en-ie"><?php _e("English (Ireland)", "google-maps-bank"); ?></option>
                                    <option value="en-jm"><?php _e("English (Jamaica)", "google-maps-bank"); ?></option>
                                    <option value="en-nz"><?php _e("English (New Zealand)", "google-maps-bank"); ?></option>
                                    <option value="en-ph"><?php _e("English (Phillipines)", "google-maps-bank"); ?></option>
                                    <option value="en-za"><?php _e("English (South Africa)", "google-maps-bank"); ?></option>
                                    <option value="en-tt"><?php _e("English (Trinidad)", "google-maps-bank"); ?></option>
                                    <option value="en-gb"><?php _e("English (United Kingdom)", "google-maps-bank"); ?></option>
                                    <option value="en-us"><?php _e("English (United States)", "google-maps-bank"); ?></option>
                                    <option value="en-zw"><?php _e("English (Zimbabwe)", "google-maps-bank"); ?></option>
                                    <option value="et"><?php _e("Estonian", "google-maps-bank"); ?></option>
                                    <option value="fo"><?php _e("Faeroese", "google-maps-bank"); ?></option>
                                    <option value="fa"><?php _e("Farsi", "google-maps-bank"); ?></option>
                                    <option value="fi"><?php _e("Finnish", "google-maps-bank"); ?></option>
                                    <option value="fil"><?php _e("Filipino", "google-maps-bank"); ?></option>
                                    <option value="fr"><?php _e("French", "google-maps-bank"); ?></option>
                                    <option value="fr-be"><?php _e("French (Belgium)", "google-maps-bank"); ?></option>
                                    <option value="fr-ca"><?php _e("French (Canada)", "google-maps-bank"); ?></option>
                                    <option value="fr-fr"><?php _e("French (France)", "google-maps-bank"); ?></option>
                                    <option value="fr-lu"><?php _e("French (Luxembourg)", "google-maps-bank"); ?></option>
                                    <option value="fr-mc"><?php _e("French (Monaco)", "google-maps-bank"); ?></option>
                                    <option value="fr-ch"><?php _e("French (Switzerland)", "google-maps-bank"); ?></option>
                                    <option value="gl"><?php _e("Galician", "google-maps-bank"); ?></option>
                                    <option value="gd"><?php _e("Gaelic", "google-maps-bank"); ?></option>
                                    <option value="de"><?php _e("German", "google-maps-bank"); ?></option>
                                    <option value="de-at"><?php _e("German (Austria)", "google-maps-bank"); ?></option>
                                    <option value="de-de"><?php _e("German (Germany)", "google-maps-bank"); ?></option>
                                    <option value="de-li"><?php _e("German (Liechtenstein)", "google-maps-bank"); ?></option>
                                    <option value="de-lu"><?php _e("German (Luxembourg)", "google-maps-bank"); ?></option>
                                    <option value="de-ch"><?php _e("German (Switzerland)", "google-maps-bank"); ?></option>
                                    <option value="el"><?php _e("Greek", "google-maps-bank"); ?></option>
                                    <option value="gu"><?php _e("Gujarati", "google-maps-bank"); ?></option>
                                    <option value="hi"><?php _e("Hindi", "google-maps-bank"); ?></option>
                                    <option value="haw"><?php _e("Hawaiian", "google-maps-bank"); ?></option>
                                    <option value="iw"><?php _e("Hebrew", "google-maps-bank"); ?></option>
                                    <option value="hu"><?php _e("Hungarian", "google-maps-bank"); ?></option>
                                    <option value="is"><?php _e("Icelandic", "google-maps-bank"); ?></option>
                                    <option value="in"><?php _e("Indonesian", "google-maps-bank"); ?></option>
                                    <option value="ga"><?php _e("Irish", "google-maps-bank"); ?></option>
                                    <option value="it"><?php _e("Italian", "google-maps-bank"); ?></option>
                                    <option value="it-it"><?php _e("Italian (Italy)", "google-maps-bank"); ?></option>
                                    <option value="it-ch"><?php _e("Italian (Switzerland)", "google-maps-bank"); ?></option>
                                    <option value="ja"><?php _e("Japanese", "google-maps-bank"); ?></option>
                                    <option value="kn"><?php _e("Kannada", "google-maps-bank"); ?></option>
                                    <option value="ko"><?php _e("Korean", "google-maps-bank"); ?></option>
                                    <option value="lt"><?php _e("Lithuanian", "google-maps-bank"); ?></option>
                                    <option value="lv"><?php _e("Latvian", "google-maps-bank"); ?></option>
                                    <option value="mk"><?php _e("Macedonian", "google-maps-bank"); ?></option>
                                    <option value="ml"><?php _e("Malayalam", "google-maps-bank"); ?></option>
                                    <option value="mr"><?php _e("Marathi", "google-maps-bank"); ?></option>
                                    <option value="no"><?php _e("Norwegian", "google-maps-bank"); ?></option>
                                    <option value="pl"><?php _e("Polish", "google-maps-bank"); ?></option>
                                    <option value="pt"><?php _e("Portuguese", "google-maps-bank"); ?></option>
                                    <option value="pt-br"><?php _e("Portuguese (Brazil)", "google-maps-bank"); ?></option>
                                    <option value="pt-pt"><?php _e("Portuguese (Portugal)", "google-maps-bank"); ?></option>
                                    <option value="ro"><?php _e("Romanian", "google-maps-bank"); ?></option>
                                    <option value="ro-mo"><?php _e("Romanian (Moldova)", "google-maps-bank"); ?></option>
                                    <option value="ro-ro"><?php _e("Romanian (Romania)", "google-maps-bank"); ?></option>
                                    <option value="ru"><?php _e("Russian", "google-maps-bank"); ?></option>
                                    <option value="ru-mo"><?php _e("Russian (Moldova)", "google-maps-bank"); ?></option>
                                    <option value="ru-ru"><?php _e("Russian (Russia)", "google-maps-bank"); ?></option>
                                    <option value="sr"><?php _e("Serbian", "google-maps-bank"); ?></option>
                                    <option value="sk"><?php _e("Slovak", "google-maps-bank"); ?></option>
                                    <option value="sl"><?php _e("Slovenian", "google-maps-bank"); ?></option>
                                    <option value="es"><?php _e("Spanish", "google-maps-bank"); ?></option>
                                    <option value="es-ar"><?php _e("Spanish (Argentina)", "google-maps-bank"); ?></option>
                                    <option value="es-bo"><?php _e("Spanish (Bolivia)", "google-maps-bank"); ?></option>
                                    <option value="es-cl"><?php _e("Spanish (Chile)", "google-maps-bank"); ?></option>
                                    <option value="es-co"><?php _e("Spanish (Colombia)", "google-maps-bank"); ?></option>
                                    <option value="es-cr"><?php _e("Spanish (Costa Rica)", "google-maps-bank"); ?></option>
                                    <option value="es-do"><?php _e("Spanish (Dominican Republic)", "google-maps-bank"); ?></option>
                                    <option value="es-ec"><?php _e("Spanish (Ecuador)", "google-maps-bank"); ?></option>
                                    <option value="es-sv"><?php _e("Spanish (El Salvador)", "google-maps-bank"); ?></option>
                                    <option value="es-gt"><?php _e("Spanish (Guatemala)", "google-maps-bank"); ?></option>
                                    <option value="es-hn"><?php _e("Spanish (Honduras)", "google-maps-bank"); ?></option>
                                    <option value="es-mx"><?php _e("Spanish (Mexico)", "google-maps-bank"); ?></option>
                                    <option value="es-ni"><?php _e("Spanish (Nicaragua)", "google-maps-bank"); ?></option>
                                    <option value="es-pa"><?php _e("Spanish (Panama)", "google-maps-bank"); ?></option>
                                    <option value="es-py"><?php _e("Spanish (Paraguay)", "google-maps-bank"); ?></option>
                                    <option value="es-pe"><?php _e("Spanish (Peru)", "google-maps-bank"); ?></option>
                                    <option value="es-pr"><?php _e("Spanish (Puerto Rico)", "google-maps-bank"); ?></option>
                                    <option value="es-es"><?php _e("Spanish (Spain)", "google-maps-bank"); ?></option>
                                    <option value="es-uy"><?php _e("Spanish (Uruguay)", "google-maps-bank"); ?></option>
                                    <option value="es-ve"><?php _e("Spanish (Venezuela)", "google-maps-bank"); ?></option>
                                    <option value="sv"><?php _e("Swedish", "google-maps-bank"); ?></option>
                                    <option value="sv-fi"><?php _e("Swedish (Finland)", "google-maps-bank"); ?></option>
                                    <option value="sv-se"><?php _e("Swedish (Sweden)", "google-maps-bank"); ?></option>
                                    <option value="tl"><?php _e("Tagalog", "google-maps-bank"); ?></option>
                                    <option value="ta"><?php _e("Tamil", "google-maps-bank"); ?></option>
                                    <option value="te"><?php _e("Telugu", "google-maps-bank"); ?>TELUGU</option>
                                    <option value="th"><?php _e("Thai", "google-maps-bank"); ?></option>
                                    <option value="tr"><?php _e("Turkish", "google-maps-bank"); ?></option>
                                    <option value="uk"><?php _e("Ukranian", "google-maps-bank"); ?></option>
                                    <option value="vi"><?php _e("Vietnamese", "google-maps-bank"); ?></option>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="control-label">
                              <?php echo $gm_api_key; ?> :
                              <i class="icon-custom-question tooltips" data-original-title="<?php echo $gm_other_api_key_tooltip; ?>" data-placement="right"></i>
                              <span class="required" aria-required="true">*</span>
                           </label>
                           <input class="form-control" name="ux_txt_other_api_key" id="ux_txt_other_api_key" placeholder="<?php echo $gm_other_api_key_placeholder; ?>" value="<?php echo isset($details_other_settings["other_api_key"]) ? esc_attr($details_other_settings["other_api_key"]) : "AIzaSyDKiOeLPhYwOiJ8fvtwE3a0nKZBeiSJ8gQ" ?>">
                        </div>
                        <div class="form-group">
                           <label class="control-label">
                              <?php echo $gm_other_settings_ip_address_fetching_method; ?> :
                              <i class="icon-custom-question tooltips" data-original-title= "<?php echo $gm_other_settings_ip_address_tooltips; ?>" data-placement="right"></i>
                              <span class="required" aria-required="true">*</span>
                           </label>
                           <select name="ux_ddl_fetching_method" id="ux_ddl_fetching_method" class="form-control">
                              <option value=""><?php echo $gm_other_settings_ip_address_fetching_option1; ?></option>
                              <option value="REMOTE_ADDR"><?php echo $gm_other_settings_ip_address_fetching_option2; ?></option>
                              <option value="HTTP_X_FORWADED_FOR"><?php echo $gm_other_settings_ip_address_fetching_option3; ?></option>
                              <option value="HTTP_X_REAL_IP"><?php echo $gm_other_settings_ip_address_fetching_option4; ?></option>
                              <option value="HTTP_CF_CONNECTING_IP"><?php echo $gm_other_settings_ip_address_fetching_option5; ?></option>
                           </select>
                        </div>
                        <div class="line-separator"></div>
                        <div class="form-actions">
                           <div class="pull-right">
                              <input type="submit" class="btn vivid-green" name="ux_btn_save_changes" id="ux_btn_save_changes" value="<?php echo $gm_save_changes; ?>">
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
                  <?php echo $google_maps_bank ?>
               </a>
               <span>></span>
            </li>
            <li>
               <span>
                  <?php echo $gm_other_settings ?>
               </span>
            </li>
         </ul>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="portlet box vivid-green">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="icon-custom-wrench"></i>
                     <?php echo $gm_other_settings; ?>
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