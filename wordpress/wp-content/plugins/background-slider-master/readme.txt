=== Background Slider Master ===
Contributors: devcon1, devcon2
Tags: background slider, responsive background slider, full width background slider, full page background slider, multi page background slider, full screen slider gallery, thumbnail gallery
Requires at least: 4.1
Tested up to: 4.5.3
Stable tag: trunk
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Creates easy to use fully responsive background sliders that can be applied globally, or to individual pages and posts.

== Description ==
Background Slider Master is designed with a very simple interface so anyone can easily upload images and attach a fast loading responsive background slider to any page or post. This background slider was designed for flexibility. You can choose to create a single slider that displays globally on every page, or create as many background sliders as you want, and attach them to each page individually to show something different.

This plugin can easily show a large gallery with the convenient thumbnail navigation. There is also an option in the top right corner to show the original image ratio for galleries. Or choose to disable the thumbnail navigation for beautiful looking background images behind your content.

Please submit any feature request or support. Our team is eager to make this plugin the best background slider plugin with quick support and upgrades.

For advanced features and demo for our premium version, please checkout the <a href="https://icanwp.com/plugins/background-slider-gallery/">Background Slider Gallery</a> at https://icanwp.com/plugins/background-slider-gallery/

Quick Notes:
Special thanks to John Anderson, kellmb, and other users who reported us the issue and the inconvenience of creating slider sets.
We've heard from the users and we've made the improvements!
Now, you can use the media uploader to use and reuse without any duplicates from the media library to create the slider image sets and using drag and drop to remove or reorder the slide images.

== Installation ==
This section describes how to install the plugin and get it working.

1. Upload 'background-slider-master' directory to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Press "Add New Background Slide Set" to create a slider and start adding images.
4. Choose to globally apply a slider from the Background Slider settings, or go into edit a page/post and you will see an option to individually apply a background slider to that page only.

Please see the detailed screenshots and guide in the plugin settings or from our website https://icanwp.com/plugins/background-slider-master/
For advanced features and demo for our premium version, please checkout the <a href="https://icanwp.com/plugins/background-slider-gallery/">demo</a> at https://icanwp.com/plugins/background-slider-gallery/

== Uninstall ==

* All saved options will be deleted from the database. Use disable plugin if you are going to use the plugin again.


== Frequently Asked Questions ==

1. Can I create multiple background sliders and choose which pages to display them on?
Yes.

2. Can I apply a single background slider globally to all pages?
Yes.

3. Is the background slider responsive?
Yes.

4. Does it work on mobile setting?
Yes.

5. Can I disable the thumbnail navigation?
Yes.

6. Can I disable the original image ratio feature?
Yes.

7. Is this slider compatible with other major plugins?
Yes, this the Background Slider Master is compatible with the following major plugins:
-WooCommerce
-Gravity Forms
-WPTouch Pro
-Jetpack
-Many more

8. Can the navigation be shown overthe white or black background images?
Yes. You can choose different skin for the color of navigation and the scale change mode icon.

== Screenshots ==

1. screenshot-1.png shows an example of a full width gallery with the thumbnail navigation.
2. screenshot-2.png shows an example of the original image ratio enabled on a gallery.
3. screenshot-3.png shows an example of a traditional background slider without the thumbnail navigation.
4. screenshot-4.png shows an example of the original image ratio enabled on a traditional background slider without the thumbnail navigation.

== Changelog ==
= 1.0.0 =
* Base version was released

= 1.0.1 =
* Bug Fix: When this plugin is activated and no slider set is defined, it runs all the images attached to a post or pages. This fix will only display the defined set of images through the Background Slider Set options.

= 1.2.0 =
* Global Slider Settings are now available to control:
1. Default View Mode
2. Hide View Mode Change Button
3. Hide Arrow Navigation
4. Hide Thumbnail Navigation
5. Set Slider Show Interval
6. Set Slider Easing Delay

= 1.3.0 =
* Bug Fixes: 
1. When a speicific slider set is selected from Posts, it overrides the permalink with the title of the slider set. - Fixed.
2. The autoplay on load wasn't working from firefox. - Fixed.
3. Autosave is back for post contents, but doesn't save the metabox settings.

= 1.3.1 =
* Update
1. Add directions to the top of the settings tab: Apply slider to all pages and posts globally below, or click into your pages and posts individually and look for the "Select Background Slider Master Gallery" option on the side. This will apply the Background Slider to that page or post only.

= 1.4.0 =
* Feature Added
1. Users can choose different color skin to show the navigation arrow and the image scaling mode change icon over the black or white background color.

= 2.0.0 =
* Major Update on Creating Sets of images
1. Users can choose images to be shown in the background from uploaded galleries or from a new upload.
2. Drag and drop style background slider order.

= 2.0.1 =
Missing icons are added and unecessary files are removed.

= 2.0.2 =
Parse error: syntax error, unexpected [ in .../plugins/background-slider-master/includes/class-background-slider-master-activator.php on line 49
Has been fixed. The issue was created by older version of php not supporting creation of array using []. Now, the line has been changed to use the conventional method.

= 2.0.3 =
Very Minor Update: When debug mode is turned on, admin settings page display a notice "Notice: Undefined offset: 0." This issue has been resolved.

= 2.0.3 =
Woocommerce conflict fixed. Detail: 
https://icanwp.com/developer-blog/syntaxerror-json-parse-unexpected-character-line-1-column-1-json-data/

= 2.1.0 =
1. Tested up to WordPress version 4.5.3
2. Added extra animation
3. Added premium link
4. Enforcing strict mode in the public facing javascript

= 2.1.1 =
1. License upgraded to GPL v3.
2. Added PHP version checking to give warning when using the version out of support.
3. Added recommendation panel and upgrade notice to support our development.

= 2.1.2 =
* Admin notice can be muted until next login.
* Settings menu link fixed.

== Upgrade Notice ==

= 1.4.0 =
Icon and navigation arrow color can be changed from the settings > "Select Controller Skin"

= 2.0.0 =
Automatically upgrades the method of attaching slides to the Background Slider Sets. 


== Support ==
* This plugin is provided as is without any warranty.
* All supports maybe available voluntarily by the development team.
* Any suggestions, complaints, support requests are happily accepted via email at support@icanwp.com

== Limitation ==
* No limitations at this time.