<?php
function accesspress_slider_setting($wp_customize){
  
    $wp_customize->add_panel( 'slider_setting', array(
      'priority'        =>      '20',
      'capability' => 'edit_theme_options',
	    'theme_supports' => '',
	    'title' => __( 'Slider Setting', 'accesspress-store' ),
	    'description' => __( 'This allows to edit the Slider', 'accesspress-store' ),
    ));
    
      $wp_customize->add_section( 'slider_basic', array(
        'title'           =>      __('Basic Slider Settings', 'accesspress-store'),
        'priority'        =>      '2',
        'panel' => 'slider_setting'
      ));
                                
        $wp_customize->add_setting( 'show_slider', array(
            'default'       =>      '0',
            'sanitize_callback' => 'accesspress_store_integer_sanitize'
        ));

        $wp_customize->add_control(new AccessPress_Store_WP_Customize_Switch_Control_YesNo( $wp_customize, 'show_slider', array(
          'section'       =>      'slider_basic',
          'label'         =>      __('Show Slider', 'accesspress-store'),
          'type'          =>      'switch_yesno',
          'output'        =>      array('Yes', 'No')
        )));

        $wp_customize->add_setting( 'show_pager', array(
          'default'       =>      '0',
          'sanitize_callback' => 'accesspress_store_integer_sanitize'
        ));

        $wp_customize->add_control(new AccessPress_Store_WP_Customize_Switch_Control_YesNo( $wp_customize, 'show_pager', array(
          'section'       =>      'slider_basic',
          'label'         =>      __('Show Pager', 'accesspress-store'),
          'type'          =>      'switch_yesno',
          'output'        =>      array('Yes', 'No')
        )));

        $wp_customize->add_setting('show_controls', array(
          'default'       =>      '0',
          'sanitize_callback' => 'accesspress_store_integer_sanitize'
        ));

        $wp_customize->add_control(new AccessPress_Store_WP_Customize_Switch_Control_YesNo( $wp_customize, 'show_controls', array(
          'section'       =>      'slider_basic',
          'label'         =>      __('Show Controls', 'accesspress-store'),
          'type'          =>      'switch_yesno',
          'output'        =>      array('Yes', 'No')
        )));

        $wp_customize->add_setting( 'auto_transition', array(
          'default'       =>      '0',
          'sanitize_callback' => 'accesspress_store_integer_sanitize'
        ));

        $wp_customize->add_control(new AccessPress_Store_WP_Customize_Switch_Control_YesNo( $wp_customize, 'auto_transition', array(
          'section'       =>      'slider_basic',
          'label'         =>      __('Auto Transition', 'accesspress-store'),
          'type'          =>      'switch_yesno',
          'output'        =>      array('Yes', 'No')
        )));

    //transition type
        $wp_customize->add_setting('slider_transition', array(
          'default' => 'true',
          'capability' => 'edit_theme_options',
          'sanitize_callback' => 'accesspress_store_slider_transition_sanitize'
        ));

        $wp_customize->add_control('slider_transition', array(
          'type' => 'select',
          'label' => __('Slider Transitions (Slide/Fade)', 'accesspress-store'),
          'section' => 'slider_basic',
          'choices' => array(
             'true' => __('Fade', 'accesspress-store'),
             'false' => __('Slide', 'accesspress-store'),
        )));
 
        $wp_customize->add_setting('slider_speed', array(
          'default'       =>      '1000',
          'sanitize_callback' => 'accesspress_store_sanitize_text'
        ));

        $wp_customize->add_control( 'slider_speed', array(
          'section'       =>      'slider_basic',
          'label'         =>      __('Slider Speed', 'accesspress-store'),
          'type'          =>      'text',
        ));

        $wp_customize->add_setting( 'slider_pause', array(
          'default'       =>      '1000',
          'sanitize_callback' => 'accesspress_store_sanitize_text'
        ));

        $wp_customize->add_control( 'slider_pause', array(
          'section'       =>      'slider_basic',
          'label'         =>      __('Slider Pause', 'accesspress-store'),
          'type'          =>      'text',
        ));    
                              
        $wp_customize->add_setting( 'show_caption', array(
          'default'       =>      '0',
          'sanitize_callback' => 'accesspress_store_integer_sanitize'
        ));

        $wp_customize->add_control(new AccessPress_Store_WP_Customize_Switch_Control_YesNo( $wp_customize, 'show_caption', array(
          'section'       =>      'slider_basic',
          'label'         =>      __('Show Caption', 'accesspress-store'),
          'type'          =>      'switch_yesno',
          'output'        =>      array('Yes', 'No')
        )));
    
        $wp_customize->add_section( 'slider_1', array(
          'title'           =>      __('Slider 1', 'accesspress-store'),
          'priority'        =>      '2',
          'panel' => 'slider_setting'
        ));

        $wp_customize->add_section( 'slider_2', array(
          'title'           =>      __('Slider 2', 'accesspress-store'),
          'priority'        =>      '2',
          'panel' => 'slider_setting'
        ));
                                
        $wp_customize->add_section( 'slider_3', array(
          'title'           =>      __('Slider 3', 'accesspress-store'),
          'priority'        =>      '2',
          'panel' => 'slider_setting'
        ));
                                
        $wp_customize->add_section( 'slider_4', array(
          'title'           =>      __('Slider 4', 'accesspress-store'),
          'priority'        =>      '2',
          'panel' => 'slider_setting'
        ));

        $wp_customize->add_section('slider_5', array(
          'title'           =>      __('Slider 5', 'accesspress-store'),
          'priority'        =>      '2',
          'panel' => 'slider_setting'
        ));

    //select Page for Our Services
    $args = array( 'posts_per_page'   => 10 );
    $pages = get_posts( $args );
    $fg_pages = array();
    $fg_pages[] = __('Select Slider Post','accesspress-store');
    foreach ( $pages as $page ) {
       $fg_pages[$page->ID] = $page->post_title;     
    }

    $wp_customize->add_setting('slider_1_post', array(
        'default'        => '',
        'sanitize_callback' => 'accesspress_store_integer_sanitize',
    ));

    $wp_customize->add_control( 'slider_1_post', array(
        'settings' => 'slider_1_post',
        'label'   => __('Select Post For Slider One','accesspress-store'),
        'section'  => 'slider_1',
        'type'    => 'select',
        'choices' => $fg_pages,
    ));   
   
                                
    $wp_customize->add_setting( 'slider1_button_link', array(
      'default'       =>      '',
      'transport'     =>      'postMessage',
      'sanitize_callback' => 'accesspress_store_sanitize_text'
    ));
    
    $wp_customize->add_control( 'slider1_button_link',array(
      'section'       =>      'slider_1',
      'label'         =>      __('Slider 1 Button Link', 'accesspress-store'),
      'type'          =>      'text',
    ));

    $wp_customize->add_setting( 'slider1_button_text', array(
      'default'       =>      '',
      'transport'     =>      'postMessage',
      'sanitize_callback' => 'accesspress_store_sanitize_text'
    ));
    
    $wp_customize->add_control( 'slider1_button_text',array(
      'section'       =>      'slider_1',
      'label'         =>      __('Slider 1 Button Text', 'accesspress-store'),
      'type'          =>      'text',
    ));
                                
    $wp_customize->add_setting('slider_2_post', array(
        'default'        => '',
        'sanitize_callback' => 'accesspress_store_integer_sanitize',
    ));

    $wp_customize->add_control( 'slider_2_post', array(
        'settings' => 'slider_2_post',
        'label'   => __('Select Post For Slider Two','accesspress-store'),
        'section'  => 'slider_2',
        'type'    => 'select',
        'choices' => $fg_pages,
    ));
                                
    $wp_customize->add_setting('slider2_button_link', array(
      'default'       =>      '',
      'transport'     =>      'postMessage',
      'sanitize_callback' => 'accesspress_store_sanitize_text'
    ));
    
    $wp_customize->add_control( 'slider2_button_link',array(
      'section'       =>      'slider_2',
      'label'         =>      __('Slider 2 Button Link', 'accesspress-store'),
      'type'          =>      'text',
    ));

    $wp_customize->add_setting('slider2_button_text', array(
      'default'       =>      '',
      'transport'     =>      'postMessage',
      'sanitize_callback' => 'accesspress_store_sanitize_text'
    ));
    
    $wp_customize->add_control( 'slider2_button_text',array(
      'section'       =>      'slider_2',
      'label'         =>      __('Slider 2 Button Text', 'accesspress-store'),
      'type'          =>      'text',
    ));
                                    
    $wp_customize->add_setting('slider_3_post', array(
        'default'        => 'default',
        'sanitize_callback' => 'accesspress_store_integer_sanitize',
    ));

    $wp_customize->add_control( 'slider_3_post', array(
        'settings' => 'slider_3_post',
        'label'   => __('Select Post For Slider Three','accesspress-store'),
        'section'  => 'slider_3',
        'type'    => 'select',
        'choices' => $fg_pages,
    ));

    $wp_customize->add_setting('slider3_button_link', array(
      'default'       =>      '',
      'transport'     =>      'postMessage',
      'sanitize_callback' => 'accesspress_store_sanitize_text'
    ));
    
    $wp_customize->add_control( 'slider3_button_link',array(
      'section'       =>      'slider_3',
      'label'         =>      __('Slider 3 Button Link', 'accesspress-store'),
      'type'          =>      'text',
    ));

    $wp_customize->add_setting('slider3_button_text', array(
      'default'       =>      '',
      'transport'     =>      'postMessage',
      'sanitize_callback' => 'accesspress_store_sanitize_text'
    ));
    
    $wp_customize->add_control( 'slider3_button_text',array(
      'section'       =>      'slider_3',
      'label'         =>      __('Slider 3 Button Text', 'accesspress-store'),
      'type'          =>      'text',
    ));
    
                                
    $wp_customize->add_setting('slider_4_post', array(
        'default'        => '',
        'sanitize_callback' => 'accesspress_store_integer_sanitize',
    ));

    $wp_customize->add_control( 'slider_4_post', array(
        'settings' => 'slider_4_post',
        'label'   => __('Select Post For Slider Four','accesspress-store'),
        'section'  => 'slider_4',
        'type'    => 'select',
        'choices' => $fg_pages,
    ));

    $wp_customize->add_setting('slider4_button_link', array(
      'default'       =>      '',
      'transport'     =>      'postMessage',
      'sanitize_callback' => 'accesspress_store_sanitize_text'
    ));
    
    $wp_customize->add_control( 'slider4_button_link',array(
      'section'       =>      'slider_4',
      'label'         =>      __('Slider 4 Button Link', 'accesspress-store'),
      'type'          =>      'text',
    ));

    $wp_customize->add_setting( 'slider4_button_text', array(
      'default'       =>      '',
      'transport'     =>      'postMessage',
      'sanitize_callback' => 'accesspress_store_sanitize_text'
    ));
    
    $wp_customize->add_control( 'slider4_button_text',array(
      'section'       =>      'slider_4',
      'label'         =>      __('Slider 4 Button Text', 'accesspress-store'),
      'type'          =>      'text',
    ));
    
    $wp_customize->add_setting('slider_5_post', array(
        'default'        => '',
        'sanitize_callback' => 'accesspress_store_integer_sanitize',
    ));

    $wp_customize->add_control( 'slider_5_post', array(
        'settings' => 'slider_5_post',
        'label'   => __('Select Post For Slider Five','accesspress-store'),
        'section'  => 'slider_5',
        'type'    => 'select',
        'choices' => $fg_pages,
    ));

    $wp_customize->add_setting( 'slider5_button_link', array(
      'default'       =>      '',
      'transport'     =>      'postMessage',
      'sanitize_callback' => 'accesspress_store_sanitize_text'
    ));
    
    $wp_customize->add_control( 'slider5_button_link',array(
      'section'       =>      'slider_5',
      'label'         =>      __('Slider 5 Button Link', 'accesspress-store'),
      'type'          =>      'text',
    ));

    $wp_customize->add_setting( 'slider5_button_text', array(
        'default'       =>      '',
        'transport'     =>      'postMessage',
        'sanitize_callback' => 'accesspress_store_sanitize_text'
    ));
    
    $wp_customize->add_control( 'slider5_button_text',array(
        'section'       =>      'slider_5',
        'label'         =>      __('Slider 5 Button Text', 'accesspress-store'),
        'type'          =>      'text',
    ));


    $wp_customize->add_panel('breadcrumb_setting', array('priority'   =>      '30',
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
        'title' => __( 'Breadcrumb Setting', 'accesspress-store' ),
        'description' => __( 'This allows to upload breadcrumb background image', 'accesspress-store' ),
    ));
        
        $wp_customize->add_section('woo_archive_page', array(
            'title'   => __('WooCommerce Archive Page', 'accesspress-store'),
            'priority'=> '2',
            'panel'   => 'breadcrumb_setting', 
        ));
                                    
        $wp_customize->add_setting('breadcrumb_options', array(
            'default'           =>      '1',
            'sanitize_callback' => 'accesspress_store_integer_sanitize'
        ));

        $wp_customize->add_control(new AccessPress_Store_WP_Customize_Switch_Control( $wp_customize,'breadcrumb_options', array(
            'section' =>      'woo_archive_page',
            'label'   =>      __('Enable/Disable Breadcrumb', 'accesspress-store'),
            'type'    =>      'switch',
            'output'  =>      array('Enable','Disable')
        )));

        $wp_customize->add_setting('breadcrumb_archive_image', array(
            'default' =>      '',
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'postMessage'
        ));

        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,'breadcrumb_archive_image', array(
            'section'  => 'woo_archive_page',
            'label'    => __('Upload Background Image', 'accesspress-store'),
            'type'     => 'image',
            'description' => __('Uplaod Breadcrumb Background Image, Breadcrumb Background Image Size of 2000 &times; 156 Pixels.','accesspress-store')
        )));

        $wp_customize->add_section('woo_single_page', array(
            'title'   => __('WooCommerce Single Product Page', 'accesspress-store'),
            'priority'=> '4',
            'panel'   => 'breadcrumb_setting', 
        ));
                                    
        $wp_customize->add_setting('breadcrumb_options_single', array(
            'default'           =>      '1',
            'sanitize_callback' => 'accesspress_store_integer_sanitize'
        ));

        $wp_customize->add_control(new AccessPress_Store_WP_Customize_Switch_Control( $wp_customize,'breadcrumb_options_single', array(
            'section' =>      'woo_single_page',
            'label'   =>      __('Enable/Disable Breadcrumb', 'accesspress-store'),
            'type'    =>      'switch',
            'output'  =>      array('Enable','Disable')
        )));

        $wp_customize->add_setting('breadcrumb_single_image', array(
            'default' =>      '',
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'postMessage'
        ));

        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,'breadcrumb_single_image', array(
            'section'  => 'woo_single_page',
            'label'    => __('Upload Background Image', 'accesspress-store'),
            'type'     => 'image',
            'description' => __('Uplaod Breadcrumb Background Image, Breadcrumb Background Image Size of 2000 &times; 156 Pixels.','accesspress-store')
        )));

        $wp_customize->add_section('breadcrumb_page_options', array(
            'title'   => __('Breadcrumb Page Options', 'accesspress-store'),
            'priority'=> '6',
            'panel'   => 'breadcrumb_setting', 
        ));
                                    
        $wp_customize->add_setting('breadcrumb_options_page', array(
            'default'           =>      '1',
            'sanitize_callback' => 'accesspress_store_integer_sanitize'
        ));

        $wp_customize->add_control(new AccessPress_Store_WP_Customize_Switch_Control( $wp_customize,'breadcrumb_options_page', array(
            'section' =>      'breadcrumb_page_options',
            'label'   =>      __('Enable/Disable Breadcrumb', 'accesspress-store'),
            'type'    =>      'switch',
            'output'  =>      array('Enable','Disable')
        )));

        $wp_customize->add_setting('breadcrumb_page_image', array(
            'default' =>      '',
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'postMessage'
        ));

        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,'breadcrumb_page_image', array(
            'section'  => 'breadcrumb_page_options',
            'label'    => __('Upload Background Image', 'accesspress-store'),
            'type'     => 'image',
            'description' => __('Uplaod Breadcrumb Background Image, Breadcrumb Background Image Size of 2000 &times; 156 Pixels.','accesspress-store')
        )));

        $wp_customize->add_section('breadcrumb_post_options', array(
            'title'   => __('Breadcrumb Post Options', 'accesspress-store'),
            'priority'=> '6',
            'panel'   => 'breadcrumb_setting', 
        ));
                                    
        $wp_customize->add_setting('breadcrumb_options_post', array(
            'default'           =>      '1',
            'sanitize_callback' => 'accesspress_store_integer_sanitize'
        ));

        $wp_customize->add_control(new AccessPress_Store_WP_Customize_Switch_Control( $wp_customize,'breadcrumb_options_post', array(
            'section' =>      'breadcrumb_post_options',
            'label'   =>      __('Enable/Disable Breadcrumb', 'accesspress-store'),
            'type'    =>      'switch',
            'output'  =>      array('Enable','Disable')
        )));

        $wp_customize->add_setting('breadcrumb_post_image', array(
            'default' =>      '',
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'postMessage'
        ));

        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,'breadcrumb_post_image', array(
            'section'  => 'breadcrumb_post_options',
            'label'    => __('Upload Background Image', 'accesspress-store'),
            'type'     => 'image',
            'description' => __('Uplaod Breadcrumb Background Image, Breadcrumb Background Image Size of 2000 &times; 156 Pixels.','accesspress-store')
        )));                                
                                
}
add_action('customize_register', 'accesspress_slider_setting');