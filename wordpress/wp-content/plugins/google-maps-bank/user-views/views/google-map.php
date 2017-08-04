<?php
/**
 * This File displays Google Maps in frontend.
 *
 * @author  Tech Banker
 * @package google-maps-bank/user-views/views
 * @version 2.0.0
 */
if (!defined("ABSPATH")) {
   exit;
} //exit if accessed directly
if (isset($map_title) && $map_title == "show") {
   ?>
   <div class="ux_div_title_container_<?php echo $random; ?>" style="clear:both;">
      <<?php echo isset($map_customization_settings["map_title_html_tag"]) ? esc_attr($map_customization_settings["map_title_html_tag"]) : "h1" ?> class="map_customization_title">
      <?php echo isset($map_unserialized_data["map_title"]) ? esc_attr($map_unserialized_data["map_title"]) : ""; ?>
      </<?php echo isset($map_customization_settings["map_title_html_tag"]) ? esc_attr($map_customization_settings["map_title_html_tag"]) : "h1" ?>>
   </div>
   <?php
}
if (isset($map_description) && $map_description == "show") {
   ?>
   <div class="ux_div_description_container_<?php echo $random; ?>" style="clear:both;">
      <<?php echo isset($map_customization_settings["map_description_html_tag"]) ? esc_attr($map_customization_settings["map_description_html_tag"]) : "p"; ?> class="map_customization_description">
      <?php echo isset($map_unserialized_data["map_description"]) ? esc_attr($map_unserialized_data["map_description"]) : ""; ?>
      </<?php echo isset($map_customization_settings["map_description_html_tag"]) ? esc_attr($map_customization_settings["map_description_html_tag"]) : "p"; ?>>
   </div>
   <?php
}
?>
<div id="ux_div_map_canvas_front_end_<?php echo $random; ?>" style="margin-top:5% !important;">
</div>