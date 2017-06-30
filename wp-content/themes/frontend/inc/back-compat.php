<?php
/**
 * Palm Beach back compat functionality
 *
 * Prevents Palm Beach from running on WordPress versions prior to 4.4,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.4.
 *
 * @package Palm Beach
 *
 * Original Code: Twenty Sixteen http://wordpress.org/themes/twentysixteen
 * Original Copyright: the WordPress team and contributors.
 *
 * The following code is a derivative work of the code from the Twenty Sixteen theme,
 * which is licensed GPLv2 or later. This code therefore is also licensed under the terms
 * of the GNU Public License, version 2.
 */

/**
 * Prevent switching to Palm Beach on old versions of WordPress.
 * Switches to the default theme.
 */
function palm_beach_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );

	unset( $_GET['activated'] );

	add_action( 'admin_notices', 'palm_beach_upgrade_notice' );
}
add_action( 'after_switch_theme', 'palm_beach_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Palm Beach on WordPress versions prior to 4.4.
 *
 * @global string $wp_version WordPress version.
 */
function palm_beach_upgrade_notice() {
	$message = sprintf( esc_html__( '%1$s requires at least WordPress version %2$s. You are running version %3$s. Please upgrade and try again.', 'palm-beach' ), 'Palm Beach', '4.4', $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.4.
 *
 * @global string $wp_version WordPress version.
 */
function palm_beach_customize() {
	wp_die( sprintf( esc_html__( '%1$s requires at least WordPress version %2$s. You are running version %3$s. Please upgrade and try again.', 'palm-beach' ), 'Palm Beach', '4.4', $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'palm_beach_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.4.
 *
 * @global string $wp_version WordPress version.
 */
function palm_beach_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( esc_html__( '%1$s requires at least WordPress version %2$s. You are running version %3$s. Please upgrade and try again.', 'palm-beach' ), 'Palm Beach', '4.4', $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'palm_beach_preview' );
