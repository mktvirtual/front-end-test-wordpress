<?php
/**
 * Slider Settings
 *
 * Register Post Slider section, settings and controls for Theme Customizer
 *
 * @package Palm Beach
 */

/**
 * Adds slider settings in the Customizer
 *
 * @param object $wp_customize / Customizer Object.
 */
function palm_beach_customize_register_slider_settings( $wp_customize ) {

	// Add Sections for Slider Settings.
	$wp_customize->add_section( 'palm_beach_section_slider', array(
		'title'    => esc_html__( 'Post Slider', 'palm-beach' ),
		'priority' => 60,
		'panel' => 'palm_beach_options_panel',
		)
	);

	// Add settings and controls for Post Slider.
	$wp_customize->add_setting( 'palm_beach_theme_options[slider_activate]', array(
		'default'           => '',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'esc_attr',
		)
	);
	$wp_customize->add_control( new Palm_Beach_Customize_Header_Control(
		$wp_customize, 'palm_beach_theme_options[slider_activate]', array(
		'label' => esc_html__( 'Activate Post Slider', 'palm-beach' ),
		'section' => 'palm_beach_section_slider',
		'settings' => 'palm_beach_theme_options[slider_activate]',
		'priority' => 1,
		)
	) );
	$wp_customize->add_setting( 'palm_beach_theme_options[slider_magazine]', array(
		'default'           => false,
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'palm_beach_sanitize_checkbox',
		)
	);
	$wp_customize->add_control( 'palm_beach_theme_options[slider_magazine]', array(
		'label'    => esc_html__( 'Show Slider on Magazine Homepage', 'palm-beach' ),
		'section'  => 'palm_beach_section_slider',
		'settings' => 'palm_beach_theme_options[slider_magazine]',
		'type'     => 'checkbox',
		'priority' => 2,
		)
	);
	$wp_customize->add_setting( 'palm_beach_theme_options[slider_blog]', array(
		'default'           => false,
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'palm_beach_sanitize_checkbox',
		)
	);
	$wp_customize->add_control( 'palm_beach_theme_options[slider_blog]', array(
		'label'    => esc_html__( 'Show Slider on blog index', 'palm-beach' ),
		'section'  => 'palm_beach_section_slider',
		'settings' => 'palm_beach_theme_options[slider_blog]',
		'type'     => 'checkbox',
		'priority' => 3,
		)
	);

	// Add Setting and Control for Slider Category.
	$wp_customize->add_setting( 'palm_beach_theme_options[slider_category]', array(
		'default'           => 0,
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control( new Palm_Beach_Customize_Category_Dropdown_Control(
		$wp_customize, 'palm_beach_theme_options[slider_category]', array(
		'label' => esc_html__( 'Slider Category', 'palm-beach' ),
		'section' => 'palm_beach_section_slider',
		'settings' => 'palm_beach_theme_options[slider_category]',
		'active_callback' => 'palm_beach_slider_activated_callback',
		'priority' => 4,
		)
	) );

	// Add Setting and Control for Number of Posts.
	$wp_customize->add_setting( 'palm_beach_theme_options[slider_limit]', array(
		'default'           => 8,
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control( 'palm_beach_theme_options[slider_limit]', array(
		'label'    => esc_html__( 'Number of Posts', 'palm-beach' ),
		'section'  => 'palm_beach_section_slider',
		'settings' => 'palm_beach_theme_options[slider_limit]',
		'type'     => 'text',
		'active_callback' => 'palm_beach_slider_activated_callback',
		'priority' => 5,
		)
	);

	// Add Setting and Control for Slider Animation.
	$wp_customize->add_setting( 'palm_beach_theme_options[slider_animation]', array(
		'default'           => 'slide',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'palm_beach_sanitize_select',
		)
	);
	$wp_customize->add_control( 'palm_beach_theme_options[slider_animation]', array(
		'label'    => esc_html__( 'Slider Animation', 'palm-beach' ),
		'section'  => 'palm_beach_section_slider',
		'settings' => 'palm_beach_theme_options[slider_animation]',
		'type'     => 'radio',
		'priority' => 6,
		'active_callback' => 'palm_beach_slider_activated_callback',
		'choices'  => array(
			'slide' => esc_html__( 'Slide Effect', 'palm-beach' ),
			'fade' => esc_html__( 'Fade Effect', 'palm-beach' ),
			),
		)
	);

	// Add Setting and Control for Slider Speed.
	$wp_customize->add_setting( 'palm_beach_theme_options[slider_speed]', array(
		'default'           => 7000,
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control( 'palm_beach_theme_options[slider_speed]', array(
		'label'    => esc_html__( 'Slider Speed (in ms)', 'palm-beach' ),
		'section'  => 'palm_beach_section_slider',
		'settings' => 'palm_beach_theme_options[slider_speed]',
		'type'     => 'number',
		'active_callback' => 'palm_beach_slider_activated_callback',
		'priority' => 7,
		'input_attrs' => array(
			'min'   => 1000,
			'step'  => 100,
			),
		)
	);

}
add_action( 'customize_register', 'palm_beach_customize_register_slider_settings' );
