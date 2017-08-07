<?php
/**
 * This File contains frontend css.
 *
 * @author  Tech Banker
 * @package google-maps-bank/user-views/styles
 * @version 2.0.0
 */
if (!defined("ABSPATH")) {
   exit;
} //exit if accessed directly

$fonts_family_array = array(
    isset($layout_settings_info_window_settings["info_window_title_font_family"]) ? stripslashes(htmlspecialchars_decode($layout_settings_info_window_settings["info_window_title_font_family"])) : "Roboto Condensed",
    isset($layout_settings_info_window_settings["info_window_desc_font_family"]) ? stripslashes(htmlspecialchars_decode($layout_settings_info_window_settings["info_window_desc_font_family"])) : "Roboto Condensed",
    isset($map_customization_settings["map_title_font_family"]) ? stripslashes(htmlspecialchars_decode($map_customization_settings["map_title_font_family"])) : "Roboto Condensed",
    isset($map_customization_settings["map_description_font_family"]) ? stripslashes(htmlspecialchars_decode($map_customization_settings["map_description_font_family"])) : "Roboto Condensed"
);
$font_array = array_unique($fonts_family_array);
$url = is_ssl() ? "https://fonts.googleapis.com/css?family=" : "http://fonts.googleapis.com/css?family=";
if (isset($font_array) && count($font_array) > 0) {
   foreach ($font_array as $key) {
      ?>
      <link rel="stylesheet" type="text/css" href="<?php echo $url . htmlentities($key) ?>">
      <?php
   }
}

// InfoWindow
$info_store_title_font_family = google_maps_url_get_contents("http://fonts.googleapis.com/css?family=" . google_maps_urlencode(isset($layout_settings_info_window_settings["info_window_title_font_family"]) ? stripslashes(htmlspecialchars_decode($layout_settings_info_window_settings["info_window_title_font_family"])) : "Roboto Condensed"));
$info_store_title_font_family_class = str_replace(array("@font-face", ";"), array("store-title-style", " !important;"), $info_store_title_font_family);
$info_store_description_font_family = google_maps_url_get_contents("http://fonts.googleapis.com/css?family=" . google_maps_urlencode(isset($layout_settings_info_window_settings["info_window_desc_font_family"]) ? stripslashes(htmlspecialchars_decode($layout_settings_info_window_settings["info_window_desc_font_family"])) : "Roboto Condensed"));
$info_store_description_font_family_class = str_replace(array("@font-face", ";"), array("store-description-style", "!important;"), $info_store_description_font_family);

$info_window_title_style = isset($layout_settings_info_window_settings["info_window_title_style"]) ? explode(",", esc_attr($layout_settings_info_window_settings["info_window_title_style"])) : array("15", "#000000");
$info_window_description_style = isset($layout_settings_info_window_settings["info_window_desc_style"]) ? explode(",", esc_attr($layout_settings_info_window_settings["info_window_desc_style"])) : array("12", "#000000");
$infowindow_border_style = isset($layout_settings_info_window_settings["info_window_border_style"]) ? explode(",", esc_attr($layout_settings_info_window_settings["info_window_border_style"])) : array("0", "none", "#000000");

$info_window_image_padding = isset($layout_settings_info_window_settings["info_windows_image_padding"]) ? explode(",", esc_attr($layout_settings_info_window_settings["info_windows_image_padding"])) : array("10", "10", "0", "10");
$info_window_text_padding = isset($layout_settings_info_window_settings["info_windows_text_padding"]) ? explode(",", esc_attr($layout_settings_info_window_settings["info_windows_text_padding"])) : array("10", "0", "0", "10");

//Map Customization
$map_title_font_family = google_maps_url_get_contents("http://fonts.googleapis.com/css?family=" . google_maps_urlencode(isset($map_customization_settings["map_title_font_family"]) ? stripslashes(htmlspecialchars_decode($map_customization_settings["map_title_font_family"])) : "Roboto Condensed"));
$map_title_font_family_class = str_replace(array("@font-face", ";"), array("map_customization_title", " !important;"), $map_title_font_family);
$map_description_font_family = google_maps_url_get_contents("http://fonts.googleapis.com/css?family=" . google_maps_urlencode(isset($map_customization_settings["map_description_font_family"]) ? stripslashes(htmlspecialchars_decode($map_customization_settings["map_description_font_family"])) : "Roboto Condensed"));
$map_description_font_family_class = str_replace(array("@font-face", ";"), array("map_customization_description", " !important;"), $map_description_font_family);
$map_customization_title_margin = isset($map_customization_settings["map_title_margin"]) ? explode(",", esc_attr($map_customization_settings["map_title_margin"])) : array("0", "0", "0", "5");
$map_customization_title_padding = isset($map_customization_settings["map_title_padding"]) ? explode(",", esc_attr($map_customization_settings["map_title_padding"])) : array("5", "5", "5", "5");
$map_customization_desc_margin = isset($map_customization_settings["map_description_margin"]) ? explode(",", esc_attr($map_customization_settings["map_description_margin"])) : array("0", "0", "0", "5");
$map_customization_desc_padding = isset($map_customization_settings["map_description_padding"]) ? explode(",", esc_attr($map_customization_settings["map_description_padding"])) : array("5", "5", "5", "5");
$map_customization_text_title_style = isset($map_customization_settings["map_title_font_style"]) ? explode(",", esc_attr($map_customization_settings["map_title_font_style"])) : array("15", "#000000");
$map_customization_text_description_style = isset($map_customization_settings["map_description_font_style"]) ? explode(",", esc_attr($map_customization_settings["map_description_font_style"])) : array("15", "#000000");
?>
<style type="text/css">
   .site-content img
   {
      opacity:1 !important;
   }
   @media only screen and (max-width: 500px)
   {
      .gmb-style-infowindow
      {
         width: 100% !important;
      }
   }
   .form_div > select + div
   {
      display: none !important;
   }
   .gmb-image-padding-position,div
   {
      max-width: none !important;
      height: auto;
      border:none !important;
   }
   #ux_div_map_canvas_front_end_<?php echo $random; ?>
   {
      width: <?php echo isset($map_width) && $map_width != "" && $map_width > 0 && $map_width <= 100 ? $map_width : "100"; ?>% !important;
      height: <?php echo isset($map_height) && $map_height != "" ? $map_height : "350"; ?>px !important;
      border: 1px solid #000000 !important;
      /*        float: left !important;*/
      margin: 0px !important;
      display: block !important;
      margin-bottom: 5% !important;
   }
   .form_div
   {
      margin-bottom: 15px !important;
   }
   #ux_div_frm_body
   {
      padding:0px !important;
   }

   /* InfoWindow */
   .<?php echo $info_store_title_font_family_class; ?>
   .<?php echo $info_store_description_font_family_class; ?>

   /* Map Customization */
   .<?php echo $map_title_font_family_class; ?>
   .<?php echo $map_description_font_family_class; ?>

   .store-locator-style
   {
      text-align: left !important;
      line-height: 1.35 !important;
      margin-top: -2px !important;
      padding: <?php echo isset($info_window_text_padding[0]) ? intval($info_window_text_padding[0]) : "10"; ?>px <?php echo isset($info_window_text_padding[1]) ? intval($info_window_text_padding[1]) : "0"; ?>px <?php echo isset($info_window_text_padding[2]) ? intval($info_window_text_padding[2]) : "0"; ?>px <?php echo isset($info_window_text_padding[3]) ? intval($info_window_text_padding[3]) : "0"; ?>px !important;
   }
   .store-description-style
   {
      word-break: break-word !important;
      font-size : <?php echo isset($info_window_description_style[0]) ? intval($info_window_description_style[0]) : 0; ?>px !important;
      color: <?php echo isset($info_window_description_style[1]) ? esc_attr($info_window_description_style[1]) : ""; ?> !important;
   }
   .store-title-style
   {
      font-size: <?php echo isset($info_window_title_style[0]) ? ($info_window_title_style[0]) : 0; ?>px !important;
      color: <?php echo isset($info_window_title_style[1]) ? esc_attr($info_window_title_style[1]) : ""; ?> !important;
   }
   .gmb-style-infowindow
   {
      line-height: 1.35 !important;
      overflow: hidden !important;
      word-wrap: break-word !important;
      border: <?php echo intval($infowindow_border_style[0]); ?>px <?php echo esc_attr($infowindow_border_style[1]); ?> <?php echo esc_attr($infowindow_border_style[2]); ?> !important;
      border-radius: <?php echo isset($layout_settings_info_window_settings["info_window_border_radius"]) ? intval($layout_settings_info_window_settings["info_window_border_radius"]) : 0; ?>px !important;
      width: <?php echo isset($layout_settings_info_window_settings["info_window_width"]) ? intval($layout_settings_info_window_settings["info_window_width"]) : 0; ?>px;
   }
   .gmb-style-infowindow p
   {
      margin: 0 0 1em !important;
   }
   .gmb-image-padding-position
   {
      -webkit-box-shadow: 0 0px 0px 0px rgba(0,0,0,0.3) !important;
      box-shadow: 0 0px 0px 0px rgba(0,0,0,0.3) !important;
      margin: 0px !important;
      width: 120px !important;
      display: inline !important;
      padding: <?php echo isset($info_window_image_padding[0]) ? intval($info_window_image_padding[0]) : "10"; ?>px <?php echo isset($info_window_image_padding[1]) ? intval($info_window_image_padding[1]) : "10"; ?>px <?php echo isset($info_window_image_padding[2]) ? intval($info_window_image_padding[2]) : "0"; ?>px <?php echo isset($info_window_image_padding[3]) ? intval($info_window_image_padding[3]) : "10"; ?>px !important;
      float: <?php echo isset($layout_settings_info_window_settings["info_window_image_position"]) ? esc_attr($layout_settings_info_window_settings["info_window_image_position"]) : "left"; ?> !important;
      border:none !important;
   }

   /* Map Customization Styling*/
   .map_customization_title
   {
      text-transform: none !important;
      color: <?php echo isset($map_customization_text_title_style[1]) ? esc_attr($map_customization_text_title_style[1]) : "#000000"; ?> !important;
      font-size: <?php echo isset($map_customization_text_title_style[0]) ? intval($map_customization_text_title_style[0]) : "15"; ?>px !important;
      display: <?php echo isset($map_title) && $map_title == "hide" ? "none" : "block"; ?>;
      text-align: <?php echo isset($map_customization_settings["map_title_text_alignment"]) ? esc_attr($map_customization_settings["map_title_text_alignment"]) : "left" ?>!important;
      margin: <?php echo isset($map_customization_title_margin[0]) ? intval($map_customization_title_margin[0]) : "0"; ?>px <?php echo isset($map_customization_title_margin[1]) ? intval($map_customization_title_margin[1]) : "0"; ?>px <?php echo isset($map_customization_title_margin[2]) ? intval($map_customization_title_margin[2]) : "0"; ?>px <?php echo isset($map_customization_title_margin[3]) ? intval($map_customization_title_margin[3]) : "5"; ?>px !important;
      padding: <?php echo isset($map_customization_title_padding[0]) ? intval($map_customization_title_padding[0]) : "5"; ?>px <?php echo isset($map_customization_title_padding[1]) ? intval($map_customization_title_padding[1]) : "5"; ?>px <?php echo isset($map_customization_title_padding[2]) ? intval($map_customization_title_padding[2]) : "5"; ?>px <?php echo isset($map_customization_title_padding[3]) ? intval($map_customization_title_padding[3]) : "5"; ?>px !important;
   }
   .map_customization_description
   {
      color: <?php echo isset($map_customization_text_description_style[1]) ? esc_attr($map_customization_text_description_style[1]) : "#000000"; ?> !important;
      font-size: <?php echo isset($map_customization_text_description_style[0]) ? intval($map_customization_text_description_style[0]) : "15"; ?>px !important;
      display: <?php echo isset($map_description) && $map_description == "hide" ? "none" : "block"; ?> !important;
      text-align: <?php echo isset($map_customization_settings["map_description_text_alignment"]) ? $map_customization_settings["map_description_text_alignment"] : "left"; ?> !important;
      margin: <?php echo isset($map_customization_desc_margin[0]) ? intval($map_customization_desc_margin[0]) : "0"; ?>px <?php echo isset($map_customization_desc_margin[1]) ? intval($map_customization_desc_margin[1]) : "0"; ?>px <?php echo isset($map_customization_desc_margin[2]) ? intval($map_customization_desc_margin[2]) : "0"; ?>px <?php echo isset($map_customization_desc_margin[3]) ? intval($map_customization_desc_margin[3]) : "5"; ?>px !important;
      padding: <?php echo isset($map_customization_desc_padding[0]) ? intval($map_customization_desc_padding[0]) : "5"; ?>px <?php echo isset($map_customization_desc_padding[1]) ? intval($map_customization_desc_padding[1]) : "5"; ?>px <?php echo isset($map_customization_desc_padding[2]) ? intval($map_customization_desc_padding[2]) : "5"; ?>px <?php echo isset($map_customization_desc_padding[3]) ? intval($map_customization_desc_padding[3]) : "5"; ?>px !important;
      line-height: 1.3 !important;
   }
</style>