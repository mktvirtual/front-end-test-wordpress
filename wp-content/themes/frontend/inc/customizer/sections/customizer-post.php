<?php
/**
 * Post Settings
 *
 * Register Post Settings section, settings and controls for Theme Customizer
 *
 * @package Palm Beach
 */

/**
 * Adds post settings in the Customizer
 *
 * @param object $wp_customize / Customizer Object.
 */
function palm_beach_customize_register_post_settings( $wp_customize ) {

	// Add Sections for Post Settings.
	$wp_customize->add_section( 'palm_beach_section_post', array(
		'title'    => esc_html__( 'Post Settings', 'palm-beach' ),
		'priority' => 30,
		'panel' => 'palm_beach_options_panel',
		)
	);

	// Add Post Meta Settings.
	$wp_customize->add_setting( 'palm_beach_theme_options[post_meta_headline]', array(
		'default'           => '',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'esc_attr',
		)
	);
	$wp_customize->add_control( new Palm_Beach_Customize_Header_Control(
		$wp_customize, 'palm_beach_theme_options[post_meta_headline]', array(
		'label' => esc_html__( 'Post Meta', 'palm-beach' ),
		'section' => 'palm_beach_section_post',
		'settings' => 'palm_beach_theme_options[post_meta_headline]',
		'priority' => 1,
		)
	) );

	$wp_customize->add_setting( 'palm_beach_theme_options[meta_date]', array(
		'default'           => true,
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'palm_beach_sanitize_checkbox',
		)
	);
	$wp_customize->add_control( 'palm_beach_theme_options[meta_date]', array(
		'label'    => esc_html__( 'Display post date', 'palm-beach' ),
		'section'  => 'palm_beach_section_post',
		'settings' => 'palm_beach_theme_options[meta_date]',
		'type'     => 'checkbox',
		'priority' => 2,
		)
	);

	$wp_customize->add_setting( 'palm_beach_theme_options[meta_author]', array(
		'default'           => true,
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'palm_beach_sanitize_checkbox',
		)
	);
	$wp_customize->add_control( 'palm_beach_theme_options[meta_author]', array(
		'label'    => esc_html__( 'Display post author', 'palm-beach' ),
		'section'  => 'palm_beach_section_post',
		'settings' => 'palm_beach_theme_options[meta_author]',
		'type'     => 'checkbox',
		'priority' => 3,
		)
	);

	// Add Setting and Control for Excerpt Length.
	$wp_customize->add_setting( 'palm_beach_theme_options[excerpt_length]', array(
		'default'           => 20,
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control( 'palm_beach_theme_options[excerpt_length]', array(
		'label'    => esc_html__( 'Excerpt Length', 'palm-beach' ),
		'section'  => 'palm_beach_section_post',
		'settings' => 'palm_beach_theme_options[excerpt_length]',
		'type'     => 'text',
		'priority' => 4,
		)
	);

	// Add Single Post Meta Settings.
	$wp_customize->add_setting( 'palm_beach_theme_options[single_post_meta_headline]', array(
		'default'           => '',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'esc_attr',
		)
	);
	$wp_customize->add_control( new Palm_Beach_Customize_Header_Control(
		$wp_customize, 'palm_beach_theme_options[single_post_meta_headline]', array(
		'label' => esc_html__( 'Single Post Meta', 'palm-beach' ),
		'section' => 'palm_beach_section_post',
		'settings' => 'palm_beach_theme_options[single_post_meta_headline]',
		'priority' => 5,
		)
	) );

	$wp_customize->add_setting( 'palm_beach_theme_options[meta_category]', array(
		'default'           => true,
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'palm_beach_sanitize_checkbox',
		)
	);
	$wp_customize->add_control( 'palm_beach_theme_options[meta_category]', array(
		'label'    => esc_html__( 'Display post categories on single posts', 'palm-beach' ),
		'section'  => 'palm_beach_section_post',
		'settings' => 'palm_beach_theme_options[meta_category]',
		'type'     => 'checkbox',
		'priority' => 6,
		)
	);

	$wp_customize->add_setting( 'palm_beach_theme_options[meta_comments]', array(
		'default'           => true,
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'palm_beach_sanitize_checkbox',
		)
	);
	$wp_customize->add_control( 'palm_beach_theme_options[meta_comments]', array(
		'label'    => esc_html__( 'Display post comments on single posts', 'palm-beach' ),
		'section'  => 'palm_beach_section_post',
		'settings' => 'palm_beach_theme_options[meta_comments]',
		'type'     => 'checkbox',
		'priority' => 6,
		)
	);

	$wp_customize->add_setting( 'palm_beach_theme_options[meta_tags]', array(
		'default'           => true,
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'palm_beach_sanitize_checkbox',
		)
	);
	$wp_customize->add_control( 'palm_beach_theme_options[meta_tags]', array(
		'label'    => esc_html__( 'Display post tags on single posts', 'palm-beach' ),
		'section'  => 'palm_beach_section_post',
		'settings' => 'palm_beach_theme_options[meta_tags]',
		'type'     => 'checkbox',
		'priority' => 7,
		)
	);

	$wp_customize->add_setting( 'palm_beach_theme_options[post_navigation]', array(
		'default'           => true,
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'palm_beach_sanitize_checkbox',
		)
	);
	$wp_customize->add_control( 'palm_beach_theme_options[post_navigation]', array(
		'label'    => esc_html__( 'Display post navigation on single posts', 'palm-beach' ),
		'section'  => 'palm_beach_section_post',
		'settings' => 'palm_beach_theme_options[post_navigation]',
		'type'     => 'checkbox',
		'priority' => 8,
		)
	);

}
add_action( 'customize_register', 'palm_beach_customize_register_post_settings' );
