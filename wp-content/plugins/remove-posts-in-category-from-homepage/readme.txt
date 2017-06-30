=== Plugin Name ===
Contributors: davidwalsh83
Tags: categories, posts
Requires at least: 3.0.1
Tested up to: 4.4.2
Stable tag: 1.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin allows WordPres admins to prevent posts in a given category from displaying on the homepage / main loop as well as the RSS feed.

== Description ==

This plugin allows WordPres admins to prevent posts in a given category from displaying on the homepage / main loop as well as the RSS feed.

Two new checkbox will display on the "Add New Category" and "Edit Category" screens -- it's that simple!

== Installation ==

Installation is easy:

1. Upload `remove-category-from-loop.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Will posts in given categories still display within the RSS feed? =

A new option has been added to additionally remove posts in a category from the main RSS feed

= What are the plugin's option keys? =

The option keys are `remove-loop-cats` and `remove-loop-rss`;  all categories marked not to display in the main loop are stored in this option to keep the DB footprint as low as possible.

== Screenshots ==

1. The checkbox appears on the "Add New Category" and "Edit Category" forms.

== Changelog ==

= 1.3 =
* Bump to ensure it's current

= 1.2 =
* Bump to ensure it's current

= 1.1 =
* Added feature which allows posts from being remove from the RSS feed

= 1.02 =
* Additional logical check at time of install to ensure an array is present

= 1.01 =
* Improved layout of both the "Add Category" and "Edit Category" screens
* Fixed option key value within the FAQ

= 1.0 =
* Initial release of plugin
