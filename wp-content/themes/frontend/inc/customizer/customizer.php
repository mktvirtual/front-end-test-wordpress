<?php
/**
 * Implement theme options in the Customizer
 *
 * @package Palm Beach
 */

// Load Customizer Helper Functions.
require( get_template_directory() . '/inc/customizer/functions/custom-controls.php' );
require( get_template_directory() . '/inc/customizer/functions/sanitize-functions.php' );
require( get_template_directory() . '/inc/customizer/functions/callback-functions.php' );

// Load Customizer Section Files.
require( get_template_directory() . '/inc/customizer/sections/customizer-general.php' );
require( get_template_directory() . '/inc/customizer/sections/customizer-post.php' );
require( get_template_directory() . '/inc/customizer/sections/customizer-slider.php' );
require( get_template_directory() . '/inc/customizer/sections/customizer-upgrade.php' );

/**
 * Registers Theme Options panel and sets up some WordPress core settings
 *
 * @param object $wp_customize / Customizer Object.
 */
function palm_beach_customize_register_options( $wp_customize ) {

	// Add Theme Options Panel.
	$wp_customize->add_panel( 'palm_beach_options_panel', array(
		'priority'       => 180,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => esc_html__( 'Theme Options', 'palm-beach' ),
		'description'    => palm_beach_customize_theme_links(),
	) );

	// Add postMessage support for site title and description.
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	// Change default background section.
	$wp_customize->get_control( 'background_color' )->section   = 'background_image';
	$wp_customize->get_section( 'background_image' )->title     = esc_html__( 'Background', 'palm-beach' );

	// Add Display Site Title Setting.
	$wp_customize->add_setting( 'palm_beach_theme_options[site_title]', array(
		'default'           => true,
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'palm_beach_sanitize_checkbox',
		)
	);
	$wp_customize->add_control( 'palm_beach_theme_options[site_title]', array(
		'label'    => esc_html__( 'Display Site Title', 'palm-beach' ),
		'section'  => 'title_tagline',
		'settings' => 'palm_beach_theme_options[site_title]',
		'type'     => 'checkbox',
		'priority' => 10,
		)
	);

} // palm_beach_customize_register_options()
add_action( 'customize_register', 'palm_beach_customize_register_options' );


/**
 * Embed JS file to make Theme Customizer preview reload changes asynchronously.
 */
function palm_beach_customize_preview_js() {
	wp_enqueue_script( 'palm-beach-customizer-preview', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151202', true );
}
add_action( 'customize_preview_init', 'palm_beach_customize_preview_js' );


/**
 * Embed CSS styles for the theme options in the Customizer
 */
function palm_beach_customize_preview_css() {
	wp_enqueue_style( 'palm-beach-customizer-css', get_template_directory_uri() . '/css/customizer.css', array(), '20160915' );
}
add_action( 'customize_controls_print_styles', 'palm_beach_customize_preview_css' );

/**
 * Returns Theme Links
 */
function palm_beach_customize_theme_links() {

	ob_start();
	?>

		<div class="theme-links">

			<span class="customize-control-title"><?php esc_html_e( 'Theme Links', 'palm-beach' ); ?></span>

			<p>
				<a href="<?php echo esc_url( __( 'https://themezee.com/themes/palm-beach/', 'palm-beach' ) ); ?>?utm_source=customizer&utm_medium=textlink&utm_campaign=palm-beach&utm_content=theme-page" target="_blank">
					<?php esc_html_e( 'Theme Page', 'palm-beach' ); ?>
				</a>
			</p>

			<p>
				<a href="http://preview.themezee.com/palm-beach/?utm_source=theme-info&utm_medium=textlink&utm_campaign=palm-beach&utm_content=demo" target="_blank">
					<?php esc_html_e( 'Theme Demo', 'palm-beach' ); ?>
				</a>
			</p>

			<p>
				<a href="<?php echo esc_url( __( 'https://themezee.com/docs/palm-beach-documentation/', 'palm-beach' ) ); ?>?utm_source=customizer&utm_medium=textlink&utm_campaign=palm-beach&utm_content=documentation" target="_blank">
					<?php esc_html_e( 'Theme Documentation', 'palm-beach' ); ?>
				</a>
			</p>

			<p>
				<a href="<?php echo esc_url( __( 'https://wordpress.org/support/theme/palm-beach/reviews/?filter=5', 'palm-beach' ) ); ?>" target="_blank">
					<?php esc_html_e( 'Rate this theme', 'palm-beach' ); ?>
				</a>
			</p>

		</div>

	<?php
	$theme_links = ob_get_contents();
	ob_end_clean();

	return $theme_links;
}
