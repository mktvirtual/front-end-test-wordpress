=== ACF: Google Map Extended ===
Contributors: codewahoo
Tags: admin, acf, advanced custom field, custom field, map field, google maps, maps, gmap, map, map zoom, map scroll, coordinates
Requires at least: 3.8
Tested up to: 4.4
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

ACF field. Saves map center, zoom level. Disables map zooming on scroll. Shows location coordinates. Bonus for programmers.

== Description ==

This plugin creates a new field for [Advanced Custom Fields (ACF)](https://wordpress.org/plugins/advanced-custom-fields/ "Advanced Custom Fields") 
extending the functionality of the built-in Google Map field with several handy features:

* Saves map center. You can center your maps wherever you want and indicate that you want to save that place as map center. This can be handy, if you want your front-end map to show some specific place in the center of the map (not necessary the location marker).
* Saves zoom level.
* Disables (optionally) map zooming with a scrollwheel. Sometimes you can get annoyed with your maps starting to zoom, when you scroll the post in the admin area. This feature comes handy here.
* Shows location coordinates. It is easy to get any place's location coordinates (latitude and longitude) with this plugin by setting a marker to the place you need using user friendly map interface.
* Compatible with the data format of the Google Map field coming with ACF. See F.A.Q. for details.
* Saves all maps shown at a page in the global array. This is a bonus for programmers. See F.A.Q. for details.

The plugin makes use of the Google Maps API version 3.
The plugin doesn't use an API key and is therefore operating under the [restrictions of the free Google Maps API](https://developers.google.com/maps/faq#usage_pricing),
which should be more than enough for most websites.

= Compatibility =

This ACF field type is compatible with:

* ACF 4
* ACF 5 (PRO version)
* Google Map field coming with ACF 4/5. See F.A.Q.

= Translations =

The plugin is translated to:

* French
* German
* Netherlands
* Russian
* Ukrainian

There is a POT file under the `lang` directory holding all translation strings, so it should be pretty easy to translate to other languages.

= Website =
http://code.fish

= Please Vote and Enjoy =
Your votes really make a difference! Thanks.

= License =

This plugin is licensed under the GPLv2. See http://www.gnu.org/licenses/gpl-2.0.html

== Installation ==

1. Download [the source](https://github.com/codewahoo/acf-gme/archive/master.zip)
2. Extract the archive into the plugin folder in your WordPress installation (usually `/wp-content/plugins/` directory)
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Make sure to also have [Advanced Custom Fields](https://wordpress.org/plugins/advanced-custom-fields/ "Advanced Custom Fields") plugin installed.


== Frequently Asked Questions ==

= Q. How do I use this plugin? =

**A.** This plugin mimics the behavior of the Google Map field coming with the woderful Advanced Custom Fields plugin made by Elliot Condon.
Make sure you read [the documentation](http://www.advancedcustomfields.com/resources/google-map/) for the original field first.
In order to benefit from the extended functionality set the field type to **Google Map Extended**, when you create a new custom field with ACF. 
If you do everything correctly, you will see a togglable 'Map data' label below your map when editting a post/page with your custom fields.

To get the map data in the front-end code, simply request the field value with ACF API call and you will get the latitude, longitude, address, map center and map zoom.

`
<?php
  $values = get_field('*****FIELD_NAME*****');
  $lat = $values['lat'];
  $lng = $values['lng'];
  $address = $values['address'];
  $map_center_lat = $values['center_lat'];
  $map_center_lng = $values['center_lng'];
  $map_zoom = $values['zoom'];
?>
`

= Q. Can I upgrade the Google Map fields I had created using just ACF with this plugin? =

**A.** Yes, you can. First, you should delete the built-in Google Map fields you want to upgrade in the corresponding field groups under Custom Fields. 
Then you should create replacement Google Map Extended fields with **the same *Field Name***.
Once done and field group saved, you can refresh the back-end pages making use of ACF Google Map fields and enjoy the extended functionality.

= Q. Can I change the map's look/behavior in the back-end using JavaScript? =

**A.** Yes. All maps are saved to the global array called acf_gme_maps. The array contains instances of acf_gme class and is indexed with the field IDs. You can use all class methods or get direct access to the map through *map* property.
`acf_gme['acf-field-acf_extended_map-564232b63c93e'].map.setZoom(10)`
This code will set the map's zoom to 10.


= Q. How do I get the plugin to show a map on the website? =

**A.** You should do some front-end coding to do that, as this plugin (likewise Advanced Custom Fields itself) gives you the back-end features only and stores the data in your website's database.
Please see [code examples at ACF website](http://www.advancedcustomfields.com/resources/google-map/#code-examples).

== Screenshots ==

1. The extended options the plugin provides in the back-end.

2. Field options include optional map zooming disabling with mouse scrollwheel.

3. The plugin in action within a repeater field in the backend.


== Changelog ==

= 1.0.1 =

* Fix minor UI bugs
* Language: Updated POT file
* Language: Updated Netherlands translation
* Language: Updated Russian translation
* Language: Updated Ukrainian translation
* Language: Added French translation
* Language: Added German translation

= 1.0.0 =

* Initial Release