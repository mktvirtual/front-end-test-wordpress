<?php
function accesspress_paymentlogo_setting($wp_customize){
    $wp_customize->add_panel(
        'paymentlogo_setting',
        array(
            'priority'        =>      '60',
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __( 'Payment/Certification Logo Setting', 'accesspress-store' ),
            'description' => __( 'This allows to edit the paymentlogo', 'accesspress-store' ),
            )
        );
    
    $wp_customize->add_section(
        'paymentlogo_images',
        array(
          'title'           =>      __('Payment Logo Images', 'accesspress-store'),
          'priority'        =>      '2',
          'panel' => 'paymentlogo_setting', )
        );
    
    $wp_customize->add_setting(
        'paymentlogo1_image',
        array(
            'default'       =>      '',
            'sanitize_callback' => 'esc_url_raw'
            )
        );
    
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,
        'paymentlogo1_image',
        array(
            'section'       =>      'paymentlogo_images',
            'label'         =>      __('Upload Payment Logo 1 Image', 'accesspress-store'),
            'type'          =>      'image',
            )
        ));
    
    $wp_customize->add_setting(
        'paymentlogo2_image',
        array(
            'default'       =>      '',
            'sanitize_callback' => 'esc_url_raw'
            )
        );
    
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,
        'paymentlogo2_image',
        array(
            'section'       =>      'paymentlogo_images',
            'label'         =>      __('Upload Payment Logo 2 Image', 'accesspress-store'),
            'type'          =>      'image',
            )
        ));
    
    $wp_customize->add_setting(
        'paymentlogo3_image',
        array(
            'default'       =>      '',
            'sanitize_callback' => 'esc_url_raw'
            )
        );
    
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,
        'paymentlogo3_image',
        array(
            'section'       =>      'paymentlogo_images',
            'label'         =>      __('Upload Payment Logo 3 Image', 'accesspress-store'),
            'type'          =>      'image',
            )
        ));
    
    $wp_customize->add_setting(
        'paymentlogo4_image',
        array(
            'default'       =>      '',
            'sanitize_callback' => 'esc_url_raw'
            )
        );

    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,
        'paymentlogo4_image',
        array(
            'section'       =>      'paymentlogo_images',
            'label'         =>      __('Upload Payment Logo 4 Image', 'accesspress-store'),                                        'type'          =>      'image',
            )
        ));
    $wp_customize->add_section(
        'other_images',
        array(
          'title'           =>      __('Other Logo Images', 'accesspress-store'),
          'priority'        =>      '2',
          'panel' => 'paymentlogo_setting', )
        );
    
    $wp_customize->add_setting(
        'other1_image',
        array(
            'default'       =>      '',
            'sanitize_callback' => 'esc_url_raw'
            )
        );

    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,
        'other1_image',
        array(
            'section'       =>      'other_images',
            'label'         =>      __('Upload SSL Seal Image', 'accesspress-store'),                                        'type'          =>      'image',
            )
        )); 
    $wp_customize->add_setting(
        'other2_image',
        array(
            'default'       =>      '',
            'sanitize_callback' => 'esc_url_raw'
            )
        );

    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,
        'other2_image',
        array(
            'section'       =>      'other_images',
            'label'         =>      __('Upload Other Seal 2 Image', 'accesspress-store'),                                        'type'          =>      'image',
            )
        ));
    $wp_customize->add_setting(
        'other3_image',
        array(
            'default'       =>      '',
            'sanitize_callback' => 'esc_url_raw'
            )
        );

    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,
        'other3_image',
        array(
            'section'       =>      'other_images',
            'label'         =>      __('Upload Other Seal 2 Image', 'accesspress-store'),                                        'type'          =>      'image',
            )
        ));
/**
 * Custom Themes Info
*/
    $wp_customize->add_section(
        'accesspress_store_pro_features',
        array(
          'title'           =>  __('Important Links', 'accesspress-store'),
          'priority'        =>  1,
    ));

    $wp_customize->add_setting('theme_info_theme',array(
        'default' => '',
        'sanitize_callback' => 'accesspress_store_sanitize_text',
    ));

    $wp_customize->add_control( new AccessPress_Store_Theme_Info_Custom_Control( $wp_customize ,'theme_info_theme',array(
        'label' => __( 'Store Pro Features' , 'accesspress-store' ),
        'section' => 'accesspress_store_pro_features',
    )));

}
add_action('customize_register', 'accesspress_paymentlogo_setting');