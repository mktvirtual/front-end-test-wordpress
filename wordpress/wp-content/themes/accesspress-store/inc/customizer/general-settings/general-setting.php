<?php
function accesspress_ticker_setting($wp_customize){
  
  $wp_customize->add_section( 'accesspress_widget_header_layout', array(
      'title'           =>      __('Widget Title Layout Settings', 'accesspress-store'),
      'priority'        =>      '3',
  ));

  $wp_customize->add_setting( 'accesspress_widget_layout_type', array(
      'default'       =>      'title_style_one',
      'sanitize_callback' => 'accesspress_store_radio_sanitize_widget_layout'
  ));
                          
  $wp_customize->add_control( 'accesspress_widget_layout_type', array(
      'section'       =>      'accesspress_widget_header_layout',
      'label'         =>      __('Widget Title Layout Type', 'accesspress-store'),
      'description'   =>  __('Theme have two different widget title layout select layout as you want', 'accesspress-store'),
      'type'          =>      'radio',
      'choices'       =>      array( 
        'title_style_one' => __('Widget Title Style One', 'accesspress-store'),
        'title_style_two' => __('Widget Title Style Two', 'accesspress-store') 
  )));

  $wp_customize->add_section( 'accesspress_header_layout', array(
      'title'           =>      __('Header Layout Settings', 'accesspress-store'),
      'priority'        =>      '3',
  ));

  $wp_customize->add_setting( 'accesspress_header_layout_type', array(
      'default'       =>      'headerone',
      'sanitize_callback' => 'accesspress_store_radio_sanitize_header_layout'
  ));
                          
  $wp_customize->add_control( 'accesspress_header_layout_type', array(
      'section'       =>      'accesspress_header_layout',
      'label'         =>      __('Header Layout Type', 'accesspress-store'),
      'description'   =>  __('Theme have two different heder layout select you header layout as you want', 'accesspress-store'),
      'type'          =>      'radio',
      'choices'       =>      array( 
        'headerone' => __('Header Style One', 'accesspress-store'),
        'headertwo' => __('Header Style Two', 'accesspress-store') 
  )));

  $wp_customize->add_panel('general_setting', array(
     'priority'         =>      '2',
     'capability'       =>      'edit_theme_options',
     'theme_supports'   =>      '',
     'title'            =>      __( 'General Setting', 'accesspress-store' ),
     'description'      =>      __( 'This allows to edit the header', 'accesspress-store' ),
  ));

    $wp_customize->add_section( 'accesspress_ticker', array(
        'title'           =>      __('Ticker Setting', 'accesspress-store'),
        'priority'        =>      '2',
        'panel' => 'general_setting'
    ));

      $wp_customize->add_setting( 'accesspress_ticker_checkbox', array(
          'default' =>  '1',
          'sanitize_callback'     =>  'accesspress_store_checkbox_sanitize'
      ));

      $wp_customize->add_control(new AccessPress_Store_WP_Customize_Switch_Control( $wp_customize, 'accesspress_ticker_checkbox', array(
          'section'       =>      'accesspress_ticker',
          'label'         =>      __('Enable Disable Ticker', 'accesspress-store'),
          'type'          =>      'switch',
          'output'        =>      array('Enable', 'Disable')
      )));

      $wp_customize->add_setting( 'accesspress_ticker_title', array(
          'default'       =>      'Latest',
          'sanitize_callback'     =>  'accesspress_store_sanitize_text'
      ));

      $wp_customize->add_control( 'accesspress_ticker_title', array(
          'section'       =>      'accesspress_ticker',
          'label'         =>      __('Ticker Title', 'accesspress-store'),
          'type'          =>      'text'
      ));

      $wp_customize->add_setting( 'accesspress_ticker_text1',  array(
          'default'       =>      '',
          'sanitize_callback'     =>  'accesspress_store_sanitize_text'
      ));

      $wp_customize->add_control( 'accesspress_ticker_text1', array(
          'section'       =>      'accesspress_ticker',
          'label'         =>      __('Ticker Text 1', 'accesspress-store'),
          'type'          =>      'text'
      ));

      $wp_customize->add_setting( 'accesspress_ticker_text2', array(
          'default'       =>      '',
          'sanitize_callback'     => 'accesspress_store_sanitize_text'
      ));

      $wp_customize->add_control( 'accesspress_ticker_text2', array(
          'section'       =>      'accesspress_ticker',
          'label'         =>      __('Ticker Text2', 'accesspress-store'),
          'type'          =>      'text'
      ));

      $wp_customize->add_setting( 'accesspress_ticker_text3', array(
          'default'       =>      '',
          'sanitize_callback'     =>      'accesspress_store_sanitize_text'
      ));

      $wp_customize->add_control( 'accesspress_ticker_text3', array(
          'section'       =>      'accesspress_ticker',
          'label'         =>      __('Ticker Text3', 'accesspress-store'),
          'type'          =>      'text'
      ));

      $wp_customize->add_setting( 'accesspress_ticker_text4', array(
          'default'       =>      '',
          'sanitize_callback'     =>      'accesspress_store_sanitize_text'
      ));

      $wp_customize->add_control( 'accesspress_ticker_text4', array(
          'section'       =>      'accesspress_ticker',
          'label'         =>      __('Ticker Text4', 'accesspress-store'),
          'type'          =>      'text'
      ));

//moving default sections to custom panel
      $wp_customize->get_section('title_tagline')->panel = 'general_setting';
      $wp_customize->get_section('header_image')->panel = 'general_setting';
      $wp_customize->get_section('header_image')->title = __( 'Header Logo','accesspress-store' );
      $wp_customize->remove_section('nav');
      $wp_customize->get_section( 'colors')->panel = 'general_setting';
      $wp_customize->get_section( 'static_front_page')->panel = 'general_setting';
  
      $wp_customize->add_section('background_image', array(
          'title'           =>      __('Background', 'accesspress-store'),
          'priority'        =>      '40',
          'panel'           => 'general_setting'
      ));


        $wp_customize->add_setting( 'accesspress_background_type', array(
            'default'       =>      'none',
            'sanitize_callback' => 'accesspress_store_bkg_type'
        ));

        $wp_customize->add_control( 'accesspress_background_type', array(
          'section'       =>      'background_image',
          'label'         =>      __('Select the Background type', 'accesspress-store'),
          'description'   =>      __('Select the Background type for your website', 'accesspress-store'),
          'type'          =>      'select',
          'priority'      =>      '2',
          'choices'       =>      array(
            'color' => __('Color', 'accesspress-store'),
            'image' => __('Image', 'accesspress-store'),
            'pattern' => __('Pattern', 'accesspress-store')),
        ));

      $wp_customize->add_setting( 'accesspress_background_image_pattern', array(
          'default'       =>      '',
          'sanitize_callback' => 'accesspress_store_bkg_pattern'
      ));

      $imagepath =  get_template_directory_uri() . '/inc/images/';                           
      
      $wp_customize->add_control( new AccessPress_Store_WP_Customize_Radioimage_Control( $wp_customize, 'accesspress_background_image_pattern', array(
        'section'       =>      'background_image',
        'label'         =>      __('Background Pattern', 'accesspress-store'),
        'type'          =>      'radioimage',
        'choices'       =>      array( 
          'pattern1' => $imagepath.'patterns/80X80/pattern1.png',  
          'pattern2' =>  $imagepath.'patterns/80X80/pattern2.png', 
          'pattern3' =>  $imagepath.'patterns/80X80/pattern3.png', 
          'pattern4' => $imagepath.'patterns/80X80/pattern4.png', 
          'pattern5' =>  $imagepath.'patterns/80X80/pattern5.png',  
          'pattern6' => $imagepath.'patterns/80X80/pattern6.png', 
          ))
      ));            

      $wp_customize->add_section('webpage_layout', array(
         'title'            =>       __('Layout Setting', 'accesspress-store'),
         'priority'         =>      '110',
         'panel'            =>      'general_setting',
      ));

      $wp_customize->add_setting( 'accesspress_webpage_layout', array(
          'default'       =>  'fullwidth',
          'sanitize_callback' => 'accesspress_store_radio_sanitize_webpagelayout'
      ));

      $wp_customize->add_control( 'accesspress_webpage_layout', array(
        'section'       =>      'webpage_layout',
        'label'         =>      __('Website Layout', 'accesspress-store'),
        'description'   =>      __('Make your website either box layout or full width from click away', 'accesspress-store'),
        'type'          =>      'radio',
        'setting'       =>      'accesspress_webpage_layout',
        'choices'        =>      array(
          'boxed' => __('Boxed Layout', 'accesspress-store'),
          'fullwidth' => __('Full Width', 'accesspress-store')
          )
      ));  

  //Custom css section
      $wp_customize->add_section('accesspress_store_setting', array(
         'priority'         =>      '115',
          'title' => __('Custom CSS Section', 'accesspress-store'),
          'panel' => 'general_setting',
      ));

      $wp_customize->add_setting( 'accesspress_store_css', array(
          'default' => '',
          'capability' => 'edit_theme_options',
          'sanitize_callback' => 'wp_filter_nohtml_kses',
      ));
   
      $wp_customize->add_control('accesspress_store_css', array(
        'type' => 'textarea',
        'label' => __('Custom CSS', 'accesspress-store'),
        'section' => 'accesspress_store_setting',
        'setting' => 'accesspress_store_css',
        'description' => '',
      ));

  //Copyright section
      $wp_customize->add_section('accesspress_store_copyright_section', array(
         'priority'         =>      '120',
          'title' => __('Footer Copyright', 'accesspress-store'),
          'panel' => 'general_setting',
      ));

      $wp_customize->add_setting( 'accesspress_store_copyright', array(
          'default' => '',
          'capability' => 'edit_theme_options',
          'sanitize_callback' => 'accesspress_store_sanitize_text',
      ));
 
      $wp_customize->add_control('accesspress_store_copyright', array(
        'type' => 'textarea',
        'label' => __('Copyright Text', 'accesspress-store'),
        'section' => 'accesspress_store_copyright_section',
        'setting' => 'accesspress_store_copyright',
        'description' => '',
      ));

}
add_action( 'customize_register', 'accesspress_ticker_setting' );