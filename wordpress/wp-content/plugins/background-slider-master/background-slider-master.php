<?php

/**
 *
 * @link              https://icanwp.com/plugins/background-slider-master/
 * @since             1.0.0
 * @package           Background_Slider_Master
 *
 * @wordpress-plugin
 * Plugin Name:       Background Slider Master
 * Plugin URI:        https://icanwp.com/plugins/background-slider-master/
 * Description:       Background Slider Master is designed with a very simple interface so anyone can easily upload images and attach a fast loading responsive background slider to any page or post. This background slider features full width responsive and designed for flexibility. You can choose to create a single slider that displays globally on every page, or create as many background sliders as you want, and attach them to each page individually to show something different.
 * Version:           2.1.2
 * Author:            iCanWP Team, Sean Roh, Chris Couweleers
 * Author URI:        https://icanwp.com/plugins/background-slider-master/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       background-slider-master
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-background-slider-master-activator.php
 */
function activate_background_slider_master() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-background-slider-master-activator.php';
	Background_Slider_Master_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-background-slider-master-deactivator.php
 */
function deactivate_background_slider_master() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-background-slider-master-deactivator.php';
	Background_Slider_Master_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_background_slider_master' );
register_deactivation_hook( __FILE__, 'deactivate_background_slider_master' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-background-slider-master.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_background_slider_master() {

	$plugin = new Background_Slider_Master();
	$plugin->run();

}
run_background_slider_master();
