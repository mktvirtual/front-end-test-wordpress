<?php
/**
 * General Settings
 *
 * Register General section, settings and controls for Theme Customizer
 *
 * @package Palm Beach
 */

/**
 * Adds all general settings to the Customizer
 *
 * @param object $wp_customize / Customizer Object.
 */
function palm_beach_customize_register_general_settings( $wp_customize ) {

	// Add Section for Theme Options.
	$wp_customize->add_section( 'palm_beach_section_general', array(
		'title'    => esc_html__( 'General Settings', 'palm-beach' ),
		'priority' => 10,
		'panel' => 'palm_beach_options_panel',
		)
	);

	// Add Settings and Controls for Layout.
	$wp_customize->add_setting( 'palm_beach_theme_options[layout]', array(
		'default'           => 'right-sidebar',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'palm_beach_sanitize_select',
		)
	);
	$wp_customize->add_control( 'palm_beach_theme_options[layout]', array(
		'label'    => esc_html__( 'Theme Layout', 'palm-beach' ),
		'section'  => 'palm_beach_section_general',
		'settings' => 'palm_beach_theme_options[layout]',
		'type'     => 'radio',
		'priority' => 1,
		'choices'  => array(
			'left-sidebar' => esc_html__( 'Left Sidebar', 'palm-beach' ),
			'right-sidebar' => esc_html__( 'Right Sidebar', 'palm-beach' ),
			),
		)
	);

	// Add Sticky Header Setting.
	$wp_customize->add_setting( 'palm_beach_theme_options[sticky_header_title]', array(
		'default'           => '',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'esc_attr',
		)
	);
	$wp_customize->add_control( new Palm_Beach_Customize_Header_Control(
		$wp_customize, 'palm_beach_theme_options[sticky_header_title]', array(
		'label' => esc_html__( 'Sticky Header', 'palm-beach' ),
		'section' => 'palm_beach_section_general',
		'settings' => 'palm_beach_theme_options[sticky_header_title]',
		'priority' => 2,
		)
	) );
	$wp_customize->add_setting( 'palm_beach_theme_options[sticky_header]', array(
		'default'           => false,
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'palm_beach_sanitize_checkbox',
		)
	);
	$wp_customize->add_control( 'palm_beach_theme_options[sticky_header]', array(
		'label'    => esc_html__( 'Enable sticky header feature', 'palm-beach' ),
		'section'  => 'palm_beach_section_general',
		'settings' => 'palm_beach_theme_options[sticky_header]',
		'type'     => 'checkbox',
		'priority' => 3,
		)
	);

}
add_action( 'customize_register', 'palm_beach_customize_register_general_settings' );
