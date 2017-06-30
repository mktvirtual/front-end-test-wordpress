<?php
/**
 * Pro Version Upgrade Section
 *
 * Registers Upgrade Section for the Pro Version of the theme
 *
 * @package Palm Beach
 */

/**
 * Adds pro version description and CTA button
 *
 * @param object $wp_customize / Customizer Object.
 */
function palm_beach_customize_register_upgrade_settings( $wp_customize ) {

	// Add Upgrade / More Features Section.
	$wp_customize->add_section( 'palm_beach_section_upgrade', array(
		'title'    => esc_html__( 'More Features', 'palm-beach' ),
		'priority' => 70,
		'panel' => 'palm_beach_options_panel',
		)
	);

	// Add custom Upgrade Content control.
	$wp_customize->add_setting( 'palm_beach_theme_options[upgrade]', array(
		'default'           => '',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'esc_attr',
		)
	);
	$wp_customize->add_control( new Palm_Beach_Customize_Upgrade_Control(
		$wp_customize, 'palm_beach_theme_options[upgrade]', array(
		'section' => 'palm_beach_section_upgrade',
		'settings' => 'palm_beach_theme_options[upgrade]',
		'priority' => 1,
		)
	) );

}
add_action( 'customize_register', 'palm_beach_customize_register_upgrade_settings' );
