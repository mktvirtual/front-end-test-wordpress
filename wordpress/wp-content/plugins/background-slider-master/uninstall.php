<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://icanwp.com/plugins/background-slider-master/
 * @since      1.0.0
 *
 * @package    Background_Slider_Master
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
$bsm_options = array(
	'bsm_select_gallery_settings_field',
	'bsm_view_mode_settings_field',
	'bsm_disable_ratio_settings_field',
	'bsm_arrow_nav_settings_field',
	'bsm_thumb_nav_settings_field',
	'bsm_slider_delay_settings_field',
	'bsm_easing_option_duration_settings_field',
	'bsm_skin_settings_field'
);

$metabox_added_post_types = array( 'post', 'page' );

foreach($bsm_options as $option){
	delete_option($option);
}


foreach ( $metabox_added_post_types as $metabox ){
	remove_meta_box('bsm_files', $metabox, 'side');
}
