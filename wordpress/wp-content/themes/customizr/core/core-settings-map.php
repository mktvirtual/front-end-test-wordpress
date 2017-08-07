<?php
/**
* Defines the customizer setting map
* On live context, used to generate the default option values
*
*
*/


/**
* Defines sections, settings and function of customizer and return and array
* Also used to get the default options array, in this case $get_default = true and we DISABLE the __get_option (=>infinite loop)
*
* @package Customizr
* @since Customizr 3.0
*/
function czr_fn_get_customizer_map( $get_default = null,  $what = null ) {
    if ( ! ( defined( 'CZR_IS_MODERN_STYLE' ) && CZR_IS_MODERN_STYLE ) ) {
        return CZR_utils_settings_map::$instance -> czr_fn_get_customizer_map( $get_default, $what );
    }

    if ( ! empty( CZR___::$customizer_map ) ) {
        $_customizer_map = CZR___::$customizer_map;
    } else {
        //POPULATE THE MAP WITH DEFAULT CUSTOMIZR SETTINGS
        add_filter( 'czr_add_panel_map'           , 'czr_fn_popul_panels_map');
        add_filter( 'czr_remove_section_map'      , 'czr_fn_popul_remove_section_map');
        //theme switcher's enabled when user opened the customizer from the theme's page
        add_filter( 'czr_remove_section_map'      , 'czr_fn_set_theme_switcher_visibility');
        add_filter( 'czr_add_section_map'         , 'czr_fn_popul_section_map');
        //add controls to the map
        add_filter( 'czr_add_setting_control_map' , 'czr_fn_popul_setting_control_map', 10, 2 );


        //FILTER SPECIFIC SETTING-CONTROL MAPS
        //ADDS SETTING / CONTROLS TO THE RELEVANT SECTIONS
        add_filter( 'czr_fn_front_page_option_map', 'czr_fn_generates_featured_pages', 10, 2 );

        //MAYBE FORCE REMOVE SECTIONS (e.g. CUSTOM CSS section for wp >= 4.7 )
        add_filter( 'czr_add_section_map'         , 'czr_fn_force_remove_section_map' );

        //CACHE THE GLOBAL CUSTOMIZER MAP
        $_customizer_map = array_merge(
            array( 'add_panel'           => apply_filters( 'czr_add_panel_map', array() ) ),
            array( 'remove_section'      => apply_filters( 'czr_remove_section_map', array() ) ),
            array( 'add_section'         => apply_filters( 'czr_add_section_map', array() ) ),
            array( 'add_setting_control' => apply_filters( 'czr_add_setting_control_map', array(), $get_default ) )
        );
        CZR___::$customizer_map = $_customizer_map;
    }
    if ( is_null($what) ) {
        return apply_filters( 'tc_customizer_map', $_customizer_map );
    }

    $_to_return = $_customizer_map;
    switch ( $what ) {
        case 'add_panel':
          $_to_return = $_customizer_map['add_panel'];
        break;
        case 'remove_section':
          $_to_return = $_customizer_map['remove_section'];
        break;
        case 'add_section':
          $_to_return = $_customizer_map['add_section'];
        break;
        case 'add_setting_control':
          $_to_return = $_customizer_map['add_setting_control'];
        break;
    }
    return $_to_return;
}



/**
* Populate the control map
* hook : 'czr_add_setting_control_map'
* => loops on a callback list, each callback is a section setting group
* @return array()
*
* @package Customizr
* @since Customizr 3.3+
*/
function czr_fn_popul_setting_control_map( $_map, $get_default = null ) {
  $_new_map = array();
  $_settings_groups = array(
    //GLOBAL SETTINGS
    'czr_fn_site_identity_option_map',
    'czr_fn_skin_option_map',
    'czr_fn_fonts_option_map',
    'czr_fn_social_option_map',

    'czr_fn_formatting_option_map',
    'czr_fn_images_option_map',
    'czr_fn_sliders_option_map',
    'czr_fn_authors_option_map',
    'czr_fn_smoothscroll_option_map',

    //HEADER
    'czr_fn_header_design_option_map',
    'czr_fn_header_desktop_option_map',
    'czr_fn_header_mobile_option_map',
    'czr_fn_navigation_option_map',

    //CONTENT
    'czr_fn_front_page_option_map',
    'czr_fn_layout_option_map',
    'czr_fn_comment_option_map',
    'czr_fn_breadcrumb_option_map',
    'czr_fn_post_metas_option_map',
    'czr_fn_post_list_option_map',
    'czr_fn_single_post_option_map',
    'czr_fn_single_page_option_map',
    'czr_fn_gallery_option_map', //No gallery options in modern style ( v4+ ) as of now
    'czr_fn_post_navigation_option_map',

    //SIDEBARS
    'czr_fn_sidebars_option_map',

    //FOOTER
    'czr_fn_footer_global_settings_option_map',

    //ADVANCED OPTIONS
    'czr_fn_custom_css_option_map',
    'czr_fn_performance_option_map',
    'czr_fn_placeholders_notice_map',
    'czr_fn_external_resources_option_map',
    'czr_fn_responsive_option_map',
    'czr_fn_style_option_map'
  );

  $_settings_groups = apply_filters( 'czr_settings_sections', $_settings_groups );

  foreach ( $_settings_groups as $_group_cb ) {
    if ( ! function_exists( $_group_cb ) )
      continue;
    //applies a filter to each section settings map => allows plugins (featured pages for ex.) to add/remove settings
    //each section map takes one boolean param : $get_default
    $_group_map = apply_filters(
      $_group_cb,
      call_user_func( $_group_cb, $get_default )
    );

    if ( ! is_array( $_group_map) )
      continue;

    $_new_map = array_merge( $_new_map, $_group_map );
  }//foreach
  return array_merge( $_map, $_new_map );
}


/******************************************************************************************************
*******************************************************************************************************
* PANEL : GLOBAL SETTINGS
*******************************************************************************************************
******************************************************************************************************/

/*-----------------------------------------------------------------------------------------------------
                              SITE IDENTITY LOGO & FAVICON SECTION
------------------------------------------------------------------------------------------------------*/
function czr_fn_site_identity_option_map( $get_default = null ) {
  global $wp_version;
  return array(
          'tc_logo_upload'  => array(
                            'control'   =>  version_compare( $wp_version, '4.3', '>=' ) ? 'CZR_Customize_Cropped_Image_Control' : 'CZR_Customize_Upload_Control',
                            'label'     =>  __( 'Logo Upload (supported formats : .jpg, .png, .gif, svg, svgz)' , 'customizr' ),
                            'title'     => __( 'LOGO' , 'customizr'),
                            'section'   => 'title_tagline',
                            'sanitize_callback' => 'czr_fn_sanitize_number',
                            'priority'  => 12,
                    //we can define suggested cropping area and allow it to be flexible (def 150x150 and not flexible)
                            'width'     => 250,
                            'height'    => 100,
                            'flex_width' => true,
                            'flex_height' => true,
                            //to keep the selected cropped size
                            'dst_width'  => false,
                            'dst_height'  => false,
                            //'notice'    => __( "Uncheck this option to keep your original logo dimensions." , 'customizr')
          ),
          //force logo resize 250 * 85
          'tc_logo_resize'  => array(
                            'default'   =>  1,
                            'label'     =>  __( 'Force logo dimensions to max-width:250px and max-height:100px' , 'customizr' ),
                            'control'   =>  'CZR_controls' ,
                            'section'   =>  'title_tagline' ,
                            'type'        => 'checkbox' ,
                            'priority'  => 15,
                            'notice'    => __( "Uncheck this option to keep your original logo dimensions." , 'customizr')
          ),

  );
}

/*-----------------------------------------------------------------------------------------------------
                                  SKIN SECTION
------------------------------------------------------------------------------------------------------*/
function czr_fn_skin_option_map( $get_default = null ) {
      return array(
            'tc_skin_color' => array(
                              'default'     => '#5a5a5a',
                              'control'     => 'WP_Customize_Color_Control',
                              'label'       => __( 'Primary color' , 'customizr' ),
                              'section'     => 'skins_sec',
                              'type'        =>  'color' ,
                              'priority'    => 30,
                              'sanitize_callback'    => 'czr_fn_sanitize_hex_color',
                              'sanitize_js_callback' => 'maybe_hash_hex_color',
                              'transport'   => 'refresh', //postMessage
                              'notice'    => __( "This is the color used to style your links and other clickable elements of the theme like buttons and slider arrows." , 'customizr')
            ),
      );//end of skin options
}



/*-----------------------------------------------------------------------------------------------------
                                 FONT SECTION
------------------------------------------------------------------------------------------------------*/
function czr_fn_fonts_option_map( $get_default = null ) {
      return array(
            'tc_fonts'      => array(
                            'default'       => czr_fn_user_started_before_version( '3.4.39' , '1.2.39') ? '_g_fjalla_cantarell': '_g_sourcesanspro',
                            'label'         => __( 'Select a beautiful font pair (headings &amp; default fonts) or single font for your website.' , 'customizr' ),
                            'control'       =>  'CZR_controls',
                            'section'       => 'fonts_sec',
                            'type'          => 'select' ,
                            'choices'       => $get_default ? null : czr_fn_get_font( 'list' , 'name' ),
                            'priority'      => 10,
                            'transport'     => 'postMessage',
                            'notice'        => __( "This font picker allows you to preview and select among a handy selection of font pairs and single fonts. If you choose a pair, the first font will be applied to the site main headings : site name, site description, titles h1, h2, h3., while the second will be the default font of your website for any texts or paragraphs." , 'customizr' )
            ),
            'tc_body_font_size'      => array(
                            'default'       => czr_fn_user_started_before_version( '3.2.9', '1.0.1' ) ? 14 : 15,
                            'sanitize_callback' => 'czr_fn_sanitize_number',
                            'label'         => __( 'Set your website default font size in pixels.' , 'customizr' ),
                            'control'       =>  'CZR_controls',
                            'section'       => 'fonts_sec',
                            'type'          => 'number' ,
                            'step'          => 0.5,
                            'min'           => 0,
                            'priority'      => 20,
                            'transport'     => 'postMessage',
                            'notice'        => __( "This option sets the default font size applied to any text element of your website, when no font size is already applied." , 'customizr' )
          )
      );
}


/*-----------------------------------------------------------------------------------------------------
                         SOCIAL NETWORKS + POSITION SECTION
------------------------------------------------------------------------------------------------------*/
function czr_fn_social_option_map( $get_default = null ) {
  return array(
      'tc_social_links' => array(
            'default'   => array(),//empty array by default
            'control'   => 'CZR_Customize_Modules',
            'label'     => __('Create and organize your social links', 'customizr'),
            'section'   => 'socials_sec',
            'type'      => 'czr_module',
            'module_type' => 'czr_social_module',
            'transport' => czr_fn_is_partial_refreshed_on() ? 'postMessage' : 'refresh',
            'priority'  => 10,
      )
  );
}


/*-----------------------------------------------------------------------------------------------------
                               FORMATTING SECTION
------------------------------------------------------------------------------------------------------*/
function czr_fn_formatting_option_map( $get_default = null ) {
  return array(
          'tc_link_scroll'  =>  array(
                            'default'       => 0,
                            'control'   => 'CZR_controls' ,
                            'label'       => __( 'Smooth scroll on click' , 'customizr' ),
                            'section'     => 'formatting_sec' ,
                            'type'        => 'checkbox' ,
                            'notice'      => sprintf( '%s<br/><strong>%s</strong> : %s', __( 'If enabled, this option activates a smooth page scroll when clicking on a link to an anchor of the same page.' , 'customizr' ), __( 'Important note' , 'customizr' ), __('this option can create conflicts with some plugins, make sure that your plugins features (if any) are working fine after enabling this option.', 'customizr') )
          ),
          'tc_link_hover_effect'  =>  array(
                            'default'       => 1,
                            'control'     => 'CZR_controls' ,
                            'label'         => CZR_IS_MODERN_STYLE ?  __( 'Animated underline effect on link hover' , 'customizr' ) : __( 'Fade effect on link hover' , 'customizr' ),
                            'section'       => 'formatting_sec' ,
                            'type'          => 'checkbox' ,
                            'transport'   => czr_fn_is_ms() ? 'refresh' : 'postMessage'
          )
  );
}




/*-----------------------------------------------------------------------------------------------------
                               IMAGE SECTION
------------------------------------------------------------------------------------------------------*/
function czr_fn_images_option_map( $get_default = null ) {
  global $wp_version;

  $_image_options =  array(
          'tc_fancybox' =>  array(
                            'default'       => 1,
                            'control'   => 'CZR_controls' ,
                            'label'       => __( 'Lightbox effect on images' , 'customizr' ),
                            'section'     => 'images_sec' ,
                            'type'        => 'checkbox' ,
                            'priority'    => 1,
                            'notice'    => __( 'If enabled, this option activates a popin window whith a zoom effect when an image is clicked. Note : to enable this effect on the images of your pages and posts, images have to be linked to the Media File.' , 'customizr' ),
          ),

          'tc_retina_support' =>  array(
                            'default'       => 0,
                            'control'   => 'CZR_controls' ,
                            'label'       => __( 'High resolution (Retina) support' , 'customizr' ),
                            'section'     => 'images_sec' ,
                            'type'        => 'checkbox' ,
                            'priority'    => 5,
                            'notice'    => sprintf('%1$s <strong>%2$s</strong> : <a href="%4$splugin-install.php?tab=plugin-information&plugin=regenerate-thumbnails" title="%5$s" target="_blank">%3$s</a>.',
                                __( 'If enabled, your website will include support for high resolution devices.' , 'customizr' ),
                                __( "It is strongly recommended to regenerate your media library images in high definition with this free plugin" , 'customizr'),
                                __( "regenerate thumbnails" , 'customizr'),
                                admin_url(),
                                __( "Open the description page of the Regenerate thumbnails plugin" , 'customizr')
                            )
          ),
          'tc_center_slider_img'  =>  array(
                            'default'       => 1,
                            'control'   => 'CZR_controls' ,
                            'label'       => __( "Dynamic slider images centering on any devices" , "customizr" ),
                            'section'     => 'images_sec' ,
                            'type'        => 'checkbox' ,
                            'priority'    => 15,
                            //'notice'    => __( 'This option dynamically centers your images on any devices vertically or horizontally (without stretching them) according to their initial dimensions.' , 'customizr' ),
          ),
          'tc_center_img'  =>  array(
                            'default'       => 1,
                            'control'   => 'CZR_controls' ,
                            'label'       => __( "Dynamic thumbnails centering on any devices" , "customizr" ),
                            'section'     => 'images_sec' ,
                            'type'        => 'checkbox' ,
                            'priority'    => 20,
                            'notice'    => __( 'This option dynamically centers your images on any devices, vertically or horizontally according to their initial aspect ratio.' , 'customizr' ),
          )
  );//end of images options
  //add responsive image settings for wp >= 4.4
  if ( version_compare( $wp_version, '4.4', '>=' ) ) {
    $_image_options[ 'tc_resp_thumbs_img' ] =  array(
                            'default'     => czr_fn_user_started_before_version( '4.0.0', '2.0.0' ) ? 0 : 1,
                            'control'     => 'CZR_controls' ,
                            //'title'       => __( 'Responsive settings', 'customizr' ),
                            'label'       => __( "Improve your page speed by loading smaller images for mobile devices" , "customizr" ),
                            'section'     => 'images_sec',
                            'type'        => 'checkbox',
                            'priority'    => 25,
                            'notice'      => __( 'This feature has been introduced in WordPress v4.4+ (dec-2015), and might have minor side effects on some of your existing images. Check / uncheck this option to safely verify that your images are displayed nicely.' , 'customizr' ),
                            'ubq_section'   => array(
                                'section' => 'performances_sec',
                                'priority' => '2'
                            )
    );
  }

  return $_image_options;
}


/*-----------------------------------------------------------------------------------------------------
                              SLIDERS SECTION
------------------------------------------------------------------------------------------------------*/
function czr_fn_sliders_option_map( $get_default = null ) {
  return array(
          'tc_slider_parallax'  =>  array(
                            'default'       => 1,
                            'control'   => 'CZR_controls' ,
                            'label'       => __( "Sliders : use parallax scrolling" , "customizr" ),
                            'section'     => 'sliders_sec' ,
                            'type'        => 'checkbox' ,
                            'priority'    => 10,
                            'notice'    => __( 'If enabled, your slides scroll slower than the page (parallax effect).' , 'customizr' ),
          )
  );
}




/*-----------------------------------------------------------------------------------------------------
                              AUTHORS SECTION
------------------------------------------------------------------------------------------------------*/
function czr_fn_authors_option_map( $get_default = null ) {
  return array(
          'tc_show_author_info'  =>  array(
                            'default'       => 1,
                            'control'       => 'CZR_controls' ,
                            'label'         => __( "Display an author box after each single post content" , "customizr" ),
                            'section'       => 'authors_sec',
                            'type'          => 'checkbox',
                            'priority'      => 1,
                            'notice'        =>  __( 'Check this option to display an author info block after each single post content. Note : the Biographical info field must be filled out in the user profile.' , 'customizr' ),
          )
  );
}





/*-----------------------------------------------------------------------------------------------------
                              SMOOTH SCROLL SECTION
------------------------------------------------------------------------------------------------------*/
function czr_fn_smoothscroll_option_map( $get_default = null ) {
  return array(
          'tc_smoothscroll'  =>  array(
                            'default'       => 1,
                            'control'       => 'CZR_controls' ,
                            'label'         => __("Enable Smooth Scroll", "customizr"),
                            'section'       => 'smoothscroll_sec',
                            'type'          => 'checkbox',
                            'priority'      => 1,
                            'notice'    => __( 'This option enables a smoother page scroll.' , 'customizr' ),
                            'transport'     => czr_fn_is_ms() ? 'refresh' : 'postMessage'
          )
  );
}

/******************************************************************************************************
*******************************************************************************************************
* PANEL : HEADER
*******************************************************************************************************
******************************************************************************************************/
/*-----------------------------------------------------------------------------------------------------
                               HEADER DESIGN AND LAYOUT
------------------------------------------------------------------------------------------------------*/
function czr_fn_header_design_option_map( $get_default = null ) {
  return array(
          'tc_header_skin'  =>  array(
                            'default'       => 'light',
                            'control'       => 'CZR_controls' ,
                            'label'         => __( 'Header style', 'customizr'),
                            'choices'       => array(
                                  'dark'   => __( 'Dark' , 'customizr' ),
                                  'light'  => __( 'Light' , 'customizr')
                            ),
                            'section'       => 'header_layout_sec' ,
                            'type'          => 'select' ,
                            'priority'      => 6,
          ),
          //enable/disable top border
          'tc_top_border' => array(
                            'default'       =>  1,//top border on by default
                            'label'         =>  __( 'Display top border' , 'customizr' ),
                            'control'       =>  'CZR_controls' ,
                            'section'       =>  'header_layout_sec' ,
                            'type'          =>  'checkbox' ,
                            'notice'        =>  __( 'Uncheck this option to remove the colored top border.' , 'customizr' ),
                            'priority'      => 10
          ),
          'tc_header_title_underline'  => array(
                            'default' =>  1,
                            'label'     =>  __( 'Underline the site title in the header' , 'customizr' ),
                            'control'   =>  'CZR_controls' ,
                            'section'   =>  'header_layout_sec' ,
                            'type'        => 'checkbox' ,
                            'priority'  => 15,
                            'ubq_section'   => array(
                                'section' => 'title_tagline',
                                'priority' => '10'
                            )
          ),
          'tc_sticky_transparent_on_scroll'  =>  array(
                            'default'       => 1,
                            'control'       => 'CZR_controls' ,
                            'label'         => __( "Sticky header : semi-transparent on scroll" , "customizr" ),
                            'section'       => 'header_layout_sec' ,
                            'type'          => 'checkbox' ,
                            'priority'      => 67,
                            'transport'     => czr_fn_is_ms() ? 'refresh' : 'postMessage',
          ),
          'tc_sticky_z_index'  =>  array(
                            'default'       => 100,
                            'control'       => 'CZR_controls' ,
                            'sanitize_callback' => 'czr_fn_sanitize_number',
                            'label'         => __( "Set the header z-index" , "customizr" ),
                            'section'       => 'header_layout_sec' ,
                            'type'          => 'number' ,
                            'step'          => 1,
                            'min'           => 0,
                            'priority'      => 70,
                            'transport'     => czr_fn_is_ms() ? 'refresh' : 'postMessage',
                            'notice'    => sprintf('%1$s <a href="%2$s" target="_blank">%3$s</a> ?',
                                __( "What is" , 'customizr' ),
                                esc_url('https://developer.mozilla.org/en-US/docs/Web/CSS/z-index'),
                                __( "the z-index" , 'customizr')
                            ),
          )

  );
}


/*-----------------------------------------------------------------------------------------------------
                               HEADER OPTIONS FOR DESKTOP AND LAPTOP DEVICES
------------------------------------------------------------------------------------------------------*/
function czr_fn_header_desktop_option_map() {
    return array(
        'tc_header_layout'  =>  array(
                        'default'       => 'left',
                        //'title'         => __( 'Header design and layout' , 'customizr'),
                        'control'       => 'CZR_controls' ,
                        'label'         => __( "Choose a layout for the header" , "customizr" ),
                        'section'       => czr_fn_is_ms() ? 'header_desktop_sec' : 'header_layout_sec',
                        'type'          =>  'select' ,
                        'choices'       => array(
                                'left'      => __( 'Logo / title on the left' , 'customizr' ),
                                'right'     => __( 'Logo / title on the right' , 'customizr' ),
                                'centered'  => __( 'Logo / title centered' , 'customizr'),
                        ),
                        'priority'      => 5,
                        'transport'    => ( ! czr_fn_is_ms() && czr_fn_is_partial_refreshed_on() ) ? 'postMessage' : 'refresh',
                        'notice'    => __( 'This setting might impact the side on which the menu is revealed.' , 'customizr' ),
        ),
        'tc_header_desktop_topbar'  =>  array(
                          'default'       => 0,
                          'control'       => 'CZR_controls' ,
                          'label'         => __( "Display a topbar" , "customizr" ),
                          'section'       => 'header_desktop_sec' ,
                          'type'          => 'checkbox' ,
                          'priority'      => 10,
                          'notice'    => __( 'You can display a topbar above the header including various blocks like a menu, your social links, the search icon or the WooCommerce cart.' , 'customizr' ),
        ),
        'tc_social_in_header' =>  array(
                          'default'       => 1,
                          'label'       => __( 'Social links in header' , 'customizr' ),
                          'control'   =>  'CZR_controls' ,
                          'section'     => czr_fn_is_ms() ? 'header_desktop_sec' : 'header_layout_sec',
                          'type'        => 'checkbox' ,
                          'priority'      => 11,
                          'transport'    => ( ! czr_fn_is_ms() && czr_fn_is_partial_refreshed_on() ) ? 'postMessage' : 'refresh',
                          'ubq_section'   => array(
                              'section' => 'socials_sec',
                              'priority' => '1'
                          ),
                          'notice'    => czr_fn_is_ms() ? sprintf( __('You need to enable your topbar to display social links in your header. Enable the topbar in this option panel, or %s.' , "customizr"),
                              sprintf( '<a href="%1$s" title="%2$s">%2$s &raquo;</a>',
                                  "javascript:wp.customize.control('tc_theme_options[tc_header_desktop_topbar]').focus();",
                                  __("jump to the topbar option" , "customizr")
                              )
                          ) : ''

        ),
        'tc_header_desktop_tagline' => array(
                          'default'   => 'brand_below',
                          'label'     => sprintf( '%1$s : %2$s', __('Desktop devices', 'customizr' ) , __( 'set the tagline location' , 'customizr' ) ),
                          //'title'     => sprintf( '%1$s %2$s', __( 'Header settings for', 'customizr' ) , __('Desktop devices', 'customizr' ) ),
                          'control'   => 'CZR_controls' ,
                          'section'   => 'header_desktop_sec',
                          'type'      => 'select',
                          'priority'      => 12,
                          'choices'   => array(
                              'none'          => __( 'Do not display', 'customizr'),
                              'topbar'        => __( 'In the topbar', 'customizr'),
                              'brand_below'   => __( 'Below the logo', 'customizr'),
                              'brand_next'    => __( 'Next to the logo', 'customizr')
                          ),
                          'ubq_section'   => array(
                                'section' => 'title_tagline',
                                'priority' => '11'
                            )
                          //'priority'  => 29,
        ),

        'tc_header_desktop_search' => array(
                          'default'   => 'navbar',
                          'label'     => sprintf( '%1$s : %2$s', __('Desktop devices', 'customizr' ) , __( 'set the search button location' , 'customizr' ) ),
                          'control'   => 'CZR_controls' ,
                          'section'   => 'header_desktop_sec',
                          'type'      => 'select',
                          'choices'   => array(
                              'none'          => __( 'Do not display', 'customizr'),
                              'topbar'        => __( 'Display in the topbar', 'customizr'),
                              'navbar'        => __( 'Display in the primary navbar', 'customizr')
                          ),
                          'priority'  => 15,

        ),

        'tc_header_desktop_wc_cart' => array(
                          'default'   => 'topbar',
                          'label'     => sprintf( '%1$s : %2$s', __('Desktop devices', 'customizr' ) , sprintf('<span class="dashicons dashicons-cart"></span> %s', __( "Display the shopping cart in the header" , "customizr" ) ) ),
                          'control'   => 'CZR_controls' ,
                          'section'   => 'header_desktop_sec',
                          'notice'    => __( "WooCommerce: check to display a cart icon showing the number of items in your cart next to your header's tagline.", 'customizr' ),
                          'type'      => 'select',
                          'choices'   => array(
                              'none'          => __( 'Do not display', 'customizr'),
                              'topbar'        => __( 'Display in the topbar', 'customizr'),
                              'navbar'        => __( 'Display in the primary navbar', 'customizr')
                          ),
                          'priority'  => 20,
                          'active_callback' => apply_filters( 'tc_woocommerce_options_enabled', '__return_false' )
        ),

        'tc_header_desktop_sticky' => array(
                          'default'   => 'stick_up',
                          'control'   => 'CZR_controls',
                          'label'     => sprintf( '%1$s : %2$s', __('Desktop devices', 'customizr' ) , __('set the header visibility on scroll', 'customizr') ),
                          'section'   => 'header_desktop_sec',
                          'type'      => 'select',
                          'choices'   => array(
                              'no_stick'      => __( 'Not visible when scrolling the page', 'customizr'),
                              'stick_up'      => __( 'Reveal on scroll up', 'customizr'),
                              'stick_always'  => __( 'Always visible', 'customizr')
                          ),
                          'priority'  => 25,
        ),

        'tc_header_desktop_to_stick' => array(
                          'default'   => 'primary',
                          'control'   => 'CZR_controls',
                          'label'     => sprintf( '%1$s : %2$s', __('Desktop devices', 'customizr' ) , __('select the header block to stick on scroll', 'customizr') ),
                          'section'   => 'header_desktop_sec',
                          'type'      => 'select',
                          'choices'   => array(
                              'topbar'        => __( 'Topbar', 'customizr'),
                              'primary'       => __( 'Primary navbar', 'customizr'),
                          ),
                          'priority'  => 30,
        ),

        'tc_sticky_shrink_title_logo'  =>  array(
                            'default'       => 1,
                            'control'       => 'CZR_controls' ,
                            'label'         => __( "Sticky header : shrink title / logo" , "customizr" ),
                            'section'       => czr_fn_is_ms() ? 'header_desktop_sec' : 'header_layout_sec',
                            'type'          => 'checkbox' ,
                            'transport'     => czr_fn_is_ms() ? 'refresh' : 'postMessage',
                            'ubq_section'   => array(
                                'section' => 'title_tagline',
                                'priority' => '20'
                            ),
                            'priority'  => 35,
                            'notice'    => __( 'When your header ( containing the site title or logo ) is gluing to the top of a page, this option will make the title or logo smaller.' , 'customizr' ),
          ),
    );

}

/*-----------------------------------------------------------------------------------------------------
                               HEADER OPTIONS FOR SMARTPHONES
------------------------------------------------------------------------------------------------------*/
function czr_fn_header_mobile_option_map() {
    return array(
        'tc_header_mobile_menu_layout' => array(
                          'default'   => 'mobile_menu',
                          'control'   => 'CZR_controls',
                          'title'     => sprintf( '%1$s %2$s', __( 'Header settings for', 'customizr' ) , __('Mobile devices', 'customizr' ) ),
                          'label'     => sprintf( '%1$s : %2$s', __( 'Mobile devices', 'customizr' ) , __( 'Select the menu(s) to use for mobile devices', 'customizr') ),
                          'section'   => 'header_mobile_sec',
                          'type'      => 'select',
                          'choices'   => array(
                              'mobile_menu'    => __( 'Specific Mobile Menu', 'customizr' ),
                              'main_menu'      => __( 'Main Menu', 'customizr' ),
                              'secondary_menu' => __( 'Secondary', 'customizr' ),
                              'top_menu'       => __( 'Topbar Menu', 'customizr' ),
                          ),
                          'notice'    => sprintf( '%1$s<br/>%2$s <br/>',
                              __( 'When your visitors are using a smartphone or a tablet, the header becomes a thin bar on top, where the menu is revealed when clicking on the hamburger button. This option let you choose which menu will be displayed.' , 'customizr' ),
                              __( 'If the selected menu location has no menu assigned, the theme will try to assign another menu in this order : mobile, main, secondary, topbar.' , 'customizr' )
                          ),
                          'priority'  => 28,
                          'ubq_section'   => array(
                              'section' => 'menu_locations',
                              'priority' => '100'
                          ),
        ),
        'tc_header_mobile_tagline'  =>  array(
                          'default'       => 0,
                          'control'       => 'CZR_controls' ,
                          'label'         => sprintf( '%1$s : %2$s', __('Mobile devices', 'customizr' )  , __( 'Display the tagline in the header' , 'customizr' ) ),
                          'section'       => 'header_mobile_sec',
                          'type'          => 'checkbox' ,
                          'priority'      => 28,
                          'ubq_section'   => array(
                                              'section' => 'title_tagline',
                                              'priority' => '11'
                                           )
        ),

        'tc_header_mobile_search' => array(
                          'default'   => 1,
                          'label'     => sprintf( '%1$s : %2$s', __('Mobile devices', 'customizr' )  , __( 'Display a search button in the header' , 'customizr' ) ),
                          'control'   => 'CZR_controls' ,
                          'section'   => 'header_mobile_sec',
                          'type'      => 'checkbox',
                          'priority'  => 28,

        ),
        'tc_header_mobile_wc_cart' => array(
                          'default'   => 1,
                          'label'     => sprintf( '%1$s : %2$s', __('Mobile devices', 'customizr' ) , sprintf('<span class="dashicons dashicons-cart"></span> %s', __( "Display the shopping cart in the header" , "customizr" ) ) ),
                          'control'   => 'CZR_controls' ,
                          'section'   => 'header_mobile_sec',
                          'notice'    => __( "WooCommerce: check to display a cart icon showing the number of items in your cart next to your header's tagline.", 'customizr' ),
                          'type'      => 'checkbox',
                          'priority'  => 28,
                          'active_callback' => apply_filters( 'tc_woocommerce_options_enabled', '__return_false' )
        ),

        'tc_header_mobile_sticky' => array(
                          'default'   => 'stick_up',
                          'control'   => 'CZR_controls',
                          'label'     => sprintf( '%1$s : %2$s', __('Mobile devices', 'customizr' ) , __('header menu visibility on scroll', 'customizr') ),
                          'section'   => 'header_mobile_sec',
                          'type'      => 'select',
                          'choices'   => array(
                              'no_stick'      => __( 'Not visible when scrolling the page', 'customizr'),
                              'stick_up'      => __( 'Reveal on scroll up', 'customizr'),
                              'stick_always'  => __( 'Always visible', 'customizr')
                          ),
                          'priority'  => 29,
                          'ubq_section'   => array(
                              'section' => 'menu_locations',
                              'priority' => '120'
                          )
        )
    );
}


/*-----------------------------------------------------------------------------------------------------
                                NAVIGATION SECTION
------------------------------------------------------------------------------------------------------*/
//NOTE : priorities 10 and 20 are "used" bu menus main and secondary
function czr_fn_navigation_option_map( $get_default = null ) {
  $menu_style = czr_fn_user_started_before_version( '3.4.0', '1.2.0' ) ? 'navbar' : 'aside';
  if ( czr_fn_is_ms() ) {
      $menu_style = czr_fn_user_started_before_version( '4.0.0', '2.0.0' ) ? $menu_style : 'navbar';
  }

  return array(
          'tc_display_second_menu'  =>  array(
                            'default'       => 0,
                            'control'       => 'CZR_controls' ,
                            'label'         => __( "Display a secondary (horizontal) menu in the header." , "customizr" ),
                            'section'       => 'nav' ,
                            'type'          => 'checkbox' ,
                            'priority'      => 15,//must be located between the two menus
                            'notice'        => __( 'An horizontal menu can be displayed in the main header with this option. Make sure you have assigned a menu to this location in the menu panel.' , 'customizr' ),
                            //For old customizr < 4.0
                            //'notice'        => __( "When you've set your main menu as a vertical side navigation, you can check this option to display a complementary horizontal menu in the header." , 'customizr' ),
          ),
          'tc_menu_style'  =>  array(
                          'default'       => $menu_style,
                          'control'       => 'CZR_controls' ,
                          'title'         => __( 'Main menu design' , 'customizr'),
                          'label'         => __( 'Select a design : side menu (vertical) or regular (horizontal)' , 'customizr' ),
                          'section'       => 'nav' ,
                          'type'          => 'select',
                          'choices'       => array(
                                  'navbar'   => __( 'Regular (horizontal)'   ,  'customizr' ),
                                  'aside'    => __( 'Side Menu (vertical)' ,  'customizr' ),
                          ),
                          'priority'      => 30,
                          'notice'        => sprintf( __("Make sure that you have assigned your menus to the relevant locations %s." , "customizr"),
                              sprintf( '<strong><a href="%1$s" title="%3$s">%2$s &raquo;</a><strong>',
                                  "javascript:wp.customize.section('nav').container.find('.customize-section-back').trigger('click'); wp.customize.panel('nav_menus').focus();",
                                  __("in the menu panel" , "customizr"),
                                  __("create/edit menus", "customizr")
                              )
                          )
          ),
          'tc_menu_position'  =>  array(
                            'default'       => czr_fn_user_started_before_version( '3.4.0', '1.2.0' ) ? 'pull-menu-left' : 'pull-menu-right',
                            'control'       => 'CZR_controls' ,
                            'label'         => __( 'Menu position (for "main" menu)' , "customizr" ),
                            'section'       => 'nav' ,
                            'type'          =>  'select' ,
                            'choices'       => array(
                                    'pull-menu-left'      => __( 'Menu on the left' , 'customizr' ),
                                    'pull-menu-right'     => __( 'Menu on the right' , 'customizr' )
                            ),
                            'priority'      => 50,
                            'transport'     => czr_fn_is_ms() ? 'refresh' : 'postMessage',
          ),
          'tc_second_menu_position'  =>  array(
                            'default'       => 'pull-menu-left',
                            'control'       => 'CZR_controls' ,
                            'title'         => __( 'Secondary (horizontal) menu design' , 'customizr'),
                            'label'         => __( 'Menu position (for the horizontal menu)' , "customizr" ),
                            'section'       => 'nav' ,
                            'type'          =>  'select' ,
                            'choices'       => array(
                                    'pull-menu-left'      => __( 'Menu on the left' , 'customizr' ),
                                    'pull-menu-right'     => __( 'Menu on the right' , 'customizr' )
                            ),
                            'priority'      => 55,
                            'transport'     => czr_fn_is_ms() ? 'refresh' : 'postMessage'
          ),
          //The hover menu type has been introduced in v3.1.0.
          //For users already using the theme (no theme's option set), the default choice is click, for new users, it is hover.
          'tc_menu_type'  => array(
                            'default'   =>  czr_fn_user_started_before_version( '3.1.0' , '1.0.0' ) ? 'click' : 'hover',
                            'control'   =>  'CZR_controls' ,
                            'label'     =>  __( 'Select a submenu expansion option' , 'customizr' ),
                            'section'   =>  'nav' ,
                            'type'      =>  'select' ,
                            'choices'     => array(
                                    'click'   => __( 'Expand submenus on click' , 'customizr'),
                                    'hover'   => __( 'Expand submenus on hover' , 'customizr'  ),
                            ),
                            'priority'  =>   60
          ),
          'tc_menu_submenu_fade_effect'  =>  array(
                            'default'       => 1,
                            'control'       => 'CZR_controls' ,
                            'label'         => __( "Reveal the sub-menus blocks with a fade effect" , "customizr" ),
                            'section'       => 'nav' ,
                            'type'          => 'checkbox' ,
                            'priority'      => 70,
                            'transport'     => czr_fn_is_ms() ? 'refresh' : 'postMessage',
          ),
          'tc_menu_submenu_item_move_effect'  =>  array(
                            'default'       => 1,
                            'control'       => 'CZR_controls' ,
                            'label'         => __( "Hover move effect for the sub menu items" , "customizr" ),
                            'section'       => 'nav' ,
                            'type'          => 'checkbox' ,
                            'priority'      => 80,
                            'transport'     => czr_fn_is_ms() ? 'refresh' : 'postMessage',
          ),
          'tc_hide_all_menus'  =>  array(
                            'default'       => 0,
                            'control'       => 'CZR_controls' ,
                            'title'         => __( 'Remove all the menus.' , 'customizr'),
                            'label'         => __( "Don't display any menus in the header of your website" , "customizr" ),
                            'section'       => 'nav' ,
                            'type'          => 'checkbox' ,
                            'priority'      => 100,//must be located between the two menus
                            'notice'        => __( 'Use with caution : provide an alternative way to navigate in your website for your users.' , 'customizr' ),
          ),
  ); //end of navigation options
}






/******************************************************************************************************
*******************************************************************************************************
* PANEL : CONTENT
*******************************************************************************************************
******************************************************************************************************/
/*-----------------------------------------------------------------------------------------------------
                               FRONT PAGE SECTION
------------------------------------------------------------------------------------------------------*/
function czr_fn_front_page_option_map( $get_default = null ) {
  //prepare the cat picker notice
  global $wp_version;
  $_cat_picker_notice = sprintf( '%1$s <a href="%2$s" target="_blank">%3$s<span style="font-size: 17px;" class="dashicons dashicons-external"></span></a>' ,
    __( "Click inside the above field and pick post categories you want to display. No filter will be applied if empty.", 'customizr'),
    esc_url('codex.wordpress.org/Posts_Categories_SubPanel'),
    __('Learn more about post categories in WordPress' , 'customizr')
  );
  //for wp version >= 4.3 add deep links
  if ( ! version_compare( $wp_version, '4.3', '<' ) ) {
    $_cat_picker_notice = sprintf( '%1$s<br/><br/><ul><li>%2$s</li><li>%3$s</li></ul>',
      $_cat_picker_notice,
      sprintf( '%1$s <a href="%2$s">%3$s &raquo;</a>',
        __("Set the number of posts to display" , "customizr"),
        "javascript:wp.customize.section('frontpage_sec').container.find('.customize-section-back').trigger('click'); wp.customize.control('posts_per_page').focus();",
        __("here", "customizr")
      ),
      sprintf( '%1$s <a href="%2$s">%3$s &raquo;</a>',
        __('Jump to the blog design options' , 'customizr'),
        "javascript:wp.customize.section('frontpage_sec').container.find('.customize-section-back').trigger('click'); wp.customize.control('tc_theme_options[tc_post_list_grid]').focus();",
        __("here", "customizr")
      )
    );
  }


  return array(
          //title
          'homecontent_title'         => array(
                  'setting_type'  =>  null,
                  'control'   =>  'CZR_controls' ,
                  'title'       => __( 'Choose content and layout' , 'customizr' ),
                  'section'     => 'frontpage_sec' ,
                  'type'      => 'title' ,
                  'priority'      => 0,
          ),

          //show on front
          'show_on_front'           => array(
                            'label'     =>  __( 'Front page displays' , 'customizr' ),
                            'section'     => 'frontpage_sec' ,
                            'type'      => 'select' ,
                            'priority'      => 1,
                            'choices'     => array(
                                    'nothing'   => __( 'Don\'t show any posts or page' , 'customizr'),
                                    'posts'   => __( 'Your latest posts' , 'customizr'),
                                    'page'    => __( 'A static page' , 'customizr'  ),
                            ),
          ),

          //page on front
          'page_on_front'           => array(
                            'label'     =>  __( 'Front page' , 'customizr'  ),
                            'section'     => 'frontpage_sec' ,
                            'type'        => 'dropdown-pages' ,
                            'priority'      => 1,
          ),

          //page for posts
          'page_for_posts'          => array(
                            'label'     =>  __( 'Posts page' , 'customizr'  ),
                            'section'     => 'frontpage_sec' ,
                            'type'        => 'dropdown-pages' ,
                            'priority'      => 1,
          ),
          'tc_show_post_navigation_home'  =>  array(
                            'default'       => 1,
                            'control'     => 'CZR_controls' ,
                            'label'         => __( "Display navigation in your home blog" , "customizr" ),
                            'section'       => 'frontpage_sec',
                            'type'          => 'checkbox',
                            'priority'      => 1,
                            'transport'     => czr_fn_is_ms() ? 'refresh' : 'postMessage',
          ),
          //page for posts
          'tc_blog_restrict_by_cat'       => array(
                            'default'     => array(),
                            'label'       =>  __( 'Apply a category filter to your home / blog posts' , 'customizr'  ),
                            'section'     => 'frontpage_sec',
                            'control'     => 'CZR_Customize_Multipicker_Categories_Control',
                            'type'        => 'czr_multiple_picker',
                            'priority'    => 1,
                            'notice'      => $_cat_picker_notice
          ),
          //layout
          'tc_front_layout' => array(
                            'default'       => 'f' ,//Default layout for home page is full width
                            'label'       =>  __( 'Set up the front page layout' , 'customizr' ),
                            'section'     => 'frontpage_sec' ,
                            'control'     => 'CZR_controls' ,
                            'type'        => 'select' ,
                            'choices'     => czr_fn_layout_choices(),
                            'priority'    => 2,
                            'ubq_section'   => array(
                                'section' => 'post_layout_sec',
                                'priority' => '0'
                            )
          ),

          //select slider
          'tc_front_slider' => array(
                            'default'     => 'tc_posts_slider' ,
                            'control'     => 'CZR_controls' ,
                            'title'       => __( 'Slider options' , 'customizr' ),
                            'label'       => __( 'Select front page slider' , 'customizr' ),
                            'section'     => 'frontpage_sec' ,
                            'type'        => 'select' ,
                            //!important
                            'choices'     => ( true == $get_default ) ? null : czr_fn_slider_choices(),
                            'priority'    => 20
          ),
          //posts slider
          'tc_posts_slider_number' => array(
                            'default'     => 4,
                            'control'     => 'CZR_controls',
                            'label'       => __('Number of posts to display', 'customizr'),
                            'section'     => 'frontpage_sec' ,
                            'type'        => 'number',
                            'step'        => 1,
                            'min'         => 1,
                            'priority'    => 22,
                            'notice'      => __( "Only the posts with a featured image or at least an image inside their content will qualify for the slider. The number of post slides displayed won't exceed the number of available posts in your website.", 'customizr' )
          ),
          'tc_posts_slider_stickies' => array(
                            'default'     => 0,
                            'control'     => 'CZR_controls',
                            'label'       => __( 'Include only sticky posts' , 'customizr' ),
                            'section'     => 'frontpage_sec' ,
                            'type'        => 'checkbox' ,
                            'priority'    => 23,
                            'notice'      => sprintf('%1$s <a href="https://codex.wordpress.org/Sticky_Posts" target="_blank">%2$s</a>',
                                __( 'You can choose to display only the sticky posts. If you\'re not sure how to set a sticky post, check', 'customizr' ),
                                __('the WordPress documentation.', 'customizr' )
                            )

          ),
          'tc_posts_slider_title' => array(
                            'default'     => 1,
                            'control'     => 'CZR_controls',
                            'label'       => __( 'Display the title' , 'customizr' ),
                            'section'     => 'frontpage_sec' ,
                            'type'        => 'checkbox' ,
                            'priority'    => 24,
                            'notice'      => __( 'The title will be limited to 80 chars max', 'customizr' ),
          ),
          'tc_posts_slider_text' => array(
                            'default'     => 1,
                            'control'     => 'CZR_controls',
                            'label'       => __( 'Display the excerpt' , 'customizr' ),
                            'section'     => 'frontpage_sec' ,
                            'type'        => 'checkbox' ,
                            'priority'    => 25,
                            'notice'      => __( 'The excerpt will be limited to 80 chars max', 'customizr' ),
          ),
          'tc_posts_slider_link' => array(
                            'default'     => 'cta',
                            'control'     => 'CZR_controls',
                            'label'       => __( 'Link post with' , 'customizr' ),
                            'section'     => 'frontpage_sec' ,
                            'type'        => 'select' ,
                            'choices'     => array(
                                'cta'        => __('Call to action button', 'customizr' ),
                                'slide'      => __('Entire slide', 'customizr' ),
                                'slide_cta'  => __('Entire slide and call to action button', 'customizr' )
                            ),
                            'priority'    => 26,

          ),
          'tc_posts_slider_button_text' => array(
                            'default'     => __( 'Read more &raquo;' , 'customizr' ),
                            'label'       => __( 'Button text' , 'customizr' ),
                            'section'     => 'frontpage_sec' ,
                            'type'        => 'text' ,
                            'priority'    => 28,
                            'notice'      => __( 'The button text will be limited to 80 chars max. Leave this field empty to hide the button', 'customizr' ),
          ),

          //select slider
          'tc_slider_width' => array(
                            'default'      => 1,
                            'control'     => 'CZR_controls' ,
                            'label'       => __( 'Full width slider' , 'customizr' ),
                            'section'     => 'frontpage_sec' ,
                            'type'        => 'checkbox' ,
                            'priority'    => 30,
                            'notice'      => __( "When checked, the front page slider occupies the full viewport's width", 'customizr' ),
          ),

          //Delay between each slides
          'tc_slider_delay' => array(
                            'default'       => 5000,
                            'sanitize_callback' => 'czr_fn_sanitize_number',
                            'control'   => 'CZR_controls' ,
                            'label'       => __( 'Delay between each slides' , 'customizr' ),
                            'section'     => 'frontpage_sec' ,
                            'type'        => 'number' ,
                            'step'      => 500,
                            'min'     => 1000,
                            'notice'    => __( 'in ms : 1000ms = 1s' , 'customizr' ),
                            'priority'      => 50,
          ),
          'tc_home_slider_overlay'  =>  array(
                            'default'       => 'on',
                            'control'     => 'CZR_controls' ,
                            'label'         => __( "Apply a dark overlay on your slider's images" , 'customizr' ),
                            'section'       => 'frontpage_sec',
                            'type'      =>  'select' ,
                            'choices'     => array(
                                    'on'       => __( 'Yes' , 'customizr'),
                                    'off'      => __( 'No' , 'customizr'),
                            ),
                            'priority'      => 51
          ),

          'tc_slider_default_height' => array(
                            'default'       => 500,
                            'sanitize_callback' => 'czr_fn_sanitize_number',
                            'control'   => 'CZR_controls' ,
                            'label'       => __( "Set slider's height in pixels" , 'customizr' ),
                            'section'     => 'frontpage_sec' ,
                            'type'        => 'number' ,
                            'step'      => 1,
                            'min'       => 0,
                            'priority'      => 52,
                            'transport' => czr_fn_is_ms() ? 'refresh' : 'postMessage'
          ),
          'tc_slider_default_height_apply_all'  =>  array(
                            'default'       => 1,
                            'label'       => __( 'Apply this height to all sliders' , 'customizr' ),
                            'control'   =>  'CZR_controls' ,
                            'section'     => 'frontpage_sec' ,
                            'type'        => 'checkbox' ,
                            'priority'       => 53,
          ),
          'tc_slider_change_default_img_size'  =>  array(
                            'default'       => 0,
                            'label'       => __( "Replace the default image slider's height" , 'customizr' ),
                            'control'   =>  'CZR_controls' ,
                            'section'     => 'frontpage_sec' ,
                            'type'        => 'checkbox' ,
                            'priority'       => 54,
                            'notice'    => sprintf('%1$s <a href="http://docs.presscustomizr.com/article/74-recommended-plugins-for-the-customizr-wordpress-theme/#images" target="_blank">%2$s</a>',
                                __( "If this option is checked, your images will be resized with your custom height on upload. This is better for your overall loading performance." , 'customizr' ),
                                __( "You might want to regenerate your thumbnails." , 'customizr')
                            ),
          ),

          //Front page widget area
          'tc_show_featured_pages'  => array(
                            'default'       => 1,
                            'control'   => 'CZR_controls' ,
                            'title'       => __( 'Featured pages options' , 'customizr' ),
                            'label'       => __( 'Display home featured pages area' , 'customizr' ),
                            'section'     => 'frontpage_sec' ,
                            'type'        => 'select' ,
                            'choices'     => array(
                                    1 => __( 'Enable' , 'customizr' ),
                                    0 => __( 'Disable' , 'customizr' ),
                            ),
                            'priority'        => 55,
          ),

          //display featured page images
          'tc_show_featured_pages_img' => array(
                            'default'       => 1,
                            'control'   => 'CZR_controls' ,
                            'label'       => __( 'Show images' , 'customizr' ),
                            'section'     => 'frontpage_sec' ,
                            'type'        => 'checkbox' ,
                            'notice'    => __( 'The images are set with the "featured image" of each pages (in the page edit screen). Uncheck the option above to disable the featured page images.' , 'customizr' ),
                            'priority'      => 60,
          ),

          //display featured page images
          'tc_featured_page_button_text' => array(
                            'default'       => __( 'Read more &raquo;' , 'customizr' ),
                            'transport'     =>  czr_fn_is_ms() ? 'refresh' : 'postMessage',
                            'label'       => __( 'Button text' , 'customizr' ),
                            'section'     => 'frontpage_sec' ,
                            'type'        => 'text' ,
                            'priority'      => 65,
          )

  );//end of front_page_options
}





/*-----------------------------------------------------------------------------------------------------
                               PAGES AND POST LAYOUT SETTINGS
------------------------------------------------------------------------------------------------------*/
function czr_fn_layout_option_map( $get_default = null ) {
  return array(
          //Global sidebar layout
          'tc_sidebar_global_layout' => array(
                          'default'       => 'l' ,//Default sidebar layout is on the left
                          'label'         => __( 'Choose the global default layout' , 'customizr' ),
                          'section'     => 'post_layout_sec' ,
                          'type'          => 'select' ,
                          'choices'     => $get_default ? null : czr_fn_layout_choices(),
                          'notice'      => __( 'Note : the home page layout has to be set in the home page section' , 'customizr' ),
                          'priority'      => 10
           ),

          //force default layout on every posts
          'tc_sidebar_force_layout' =>  array(
                          'default'       => 0,
                          'control'     => 'CZR_controls' ,
                          'label'         => __( 'Force default layout everywhere' , 'customizr' ),
                          'section'       => 'post_layout_sec' ,
                          'type'          => 'checkbox' ,
                          'notice'      => __( 'This option will override the specific layouts on all posts/pages, including the front page.' , 'customizr' ),
                          'priority'      => 20
          ),

          //Post sidebar layout
          'tc_sidebar_post_layout'  =>  array(
                          'default'       => 'l' ,//Default sidebar layout is on the left
                          'label'       => __( 'Choose the posts default layout' , 'customizr' ),
                          'section'     => 'post_layout_sec' ,
                          'type'        => 'select' ,
                          'choices'   => $get_default ? null : czr_fn_layout_choices(),
                          'priority'      => 30
          ),

          //Post per page
          'posts_per_page'  =>  array(
                          'default'     => get_option( 'posts_per_page' ),
                          'sanitize_callback' => 'czr_fn_sanitize_number',
                          'control'     => 'CZR_controls' ,
                          'title'         => __( 'Global Post Lists Settings' , 'customizr' ),
                          'label'         => __( 'Maximum number of posts per page' , 'customizr' ),
                          'section'       => 'post_lists_sec' ,
                          'type'          => 'number' ,
                          'step'        => 1,
                          'min'         => 1,
                          'priority'       => 10,
                          'notice'      => __( 'This option defines the maximum number of posts or search results displayed in any list of posts of your website : blog page, archive page, search page. If the number of items to displayed is greater than your setting, the theme will automatically add a pagination link block at the bottom of the page.' , 'customizr' ),
          ),

          //Page sidebar layout
          'tc_sidebar_page_layout'  =>  array(
                            'default'       => 'l' ,//Default sidebar layout is on the left
                            'label'       => __( 'Choose the pages default layout' , 'customizr' ),
                            'section'     => 'post_layout_sec' ,
                            'type'        => 'select' ,
                            'choices'   => $get_default ? null : czr_fn_layout_choices(),
                            'priority'       => 40,
                            'notice'    => sprintf('<br/> %s<br/>%s',
                                sprintf( __("The above layout options will set your layout globally for your post and pages. But you can also define the layout for each post and page individually. Learn how in the %s.", "customizr"),
                                    sprintf('<a href="%1$s" title="%2$s" target="_blank">%2$s<span style="font-size: 17px;" class="dashicons dashicons-external"></span></a>' , esc_url('http://docs.presscustomizr.com/article/107-customizr-theme-options-pages-and-posts-layout'), __("Customizr theme documentation" , "customizr" )
                                    )
                                ),
                                sprintf( __("If you need to change the layout design of the front page, then open the 'Front Page' section above this one.", "customizr") )
                            )
          ),
  );//end of layout_options

}


/*-----------------------------------------------------------------------------------------------------
                              POST LISTS SECTION
------------------------------------------------------------------------------------------------------*/
function czr_fn_post_list_option_map( $get_default = null ) {
  $_post_list_type = ( CZR_IS_PRO && czr_fn_is_ms() ) ? 'masonry' : 'grid';
  if ( czr_fn_user_started_before_version( '3.2.18', '1.0.13' ) ) {
      $_post_list_type = 'alternate';
  } else if ( czr_fn_user_started_before_version( '4.0.0', '2.0.0' ) ) {
      $_post_list_type = 'grid';
  }

  return array(
          'tc_post_list_excerpt_length'  =>  array(
                            'default'       => 50,
                            'sanitize_callback' => 'czr_fn_sanitize_number',
                            'control'       => 'CZR_controls' ,
                            'label'         => __( "Set the excerpt length (in number of words) " , "customizr" ),
                            'section'       => 'post_lists_sec' ,
                            'type'          => 'number' ,
                            'step'          => 1,
                            'min'           => 0,
                            'priority'      => 23
          ),
          'tc_post_list_show_thumb'  =>  array(
                            'default'       => 1,
                            'control'       => 'CZR_controls' ,
                            'title'         => __( 'Thumbnails options' , 'customizr' ),
                            'label'         => __( "Display the post thumbnails" , "customizr" ),
                            'section'       => 'post_lists_sec' ,
                            'type'          => 'checkbox',
                            'priority'      => 68,
                            'notice'        => sprintf( '%s %s' , __( 'When this option is checked, the post thumbnails are displayed in all post lists : blog, archives, author page, search pages, ...' , 'customizr' ), __( 'Note : thumbnails are always displayed when the grid layout is choosen.' , 'customizr') )
          ),
          'tc_post_list_use_attachment_as_thumb'  =>  array(
                            'default'       => 1,
                            'control'     => 'CZR_controls' ,
                            'label'         => __( "If no featured image is set for a post, use the last image attached to this post." , "customizr" ),
                            'section'       => 'post_lists_sec' ,
                            'type'          => 'checkbox',
                            'priority'      => 70
          ),

          /* Not used anymore in modern style ( v4+ ) */
          'tc_post_list_thumb_shape'  =>  array(
                            'default'       => 'rounded',
                            'control'     => 'CZR_controls' ,
                            'title'         => __( 'Thumbnails options for the alternate thumbnails layout' , 'customizr' ),
                            'label'         => __( "Thumbnails shape" , "customizr" ),
                            'section'       => 'post_lists_sec' ,
                            'type'      =>  'select' ,
                            'choices'     => array(
                                    'rounded'               => __( 'Rounded, expand on hover' , 'customizr'),
                                    'rounded-expanded'      => __( 'Rounded, no expansion' , 'customizr'),
                                    'regular'               => __( 'Regular', 'customizr' ),
                            ),
                            'priority'      => 77
          ),
          'tc_post_list_thumb_position'  =>  array(
                            'default'       => 'right',
                            'control'     => 'CZR_controls' ,
                            'label'         => __( "Thumbnails position" , "customizr" ),
                            'section'       => 'post_lists_sec' ,
                            'type'      =>  'select' ,
                            'choices'     => array(
                                    //Since Customizr4 you can only have thumb first/second
                                    //hence, only right/left
                                    'right'   => __( 'Right' , 'customizr' ),
                                    'left'    => __( 'Left' , 'customizr' ),
                            ),
                            'priority'      => 90
          ),
          'tc_post_list_thumb_alternate'  =>  array(
                            'default'       => 1,
                            'control'     => 'CZR_controls' ,
                            'label'         => __( "Alternate thumbnail/content" , "customizr" ),
                            'section'       => 'post_lists_sec' ,
                            'type'          => 'checkbox',
                            'priority'      => 95
          ),

          /* ARCHIVE TITLES */
          'tc_cat_title'  =>  array(
                            'default'       => '',
                            'title'         => __( 'Archive titles' , 'customizr' ),
                            'label'       => __( 'Category pages titles' , 'customizr' ),
                            'control'   =>  'CZR_controls' ,
                            'section'     => 'post_lists_sec' ,
                            'type'        => 'text' ,
                            'priority'       => 100
                            //'notice'    => __( 'Will be hidden if empty' , 'customizr' )
          ),
          'tc_tag_title'  =>  array(
                            'default'         => '',
                            'label'       => __( 'Tag pages titles' , 'customizr' ),
                            'control'   =>  'CZR_controls' ,
                            'section'     => 'post_lists_sec' ,
                            'type'        => 'text' ,
                            'priority'       => 105
                            //'notice'    => __( 'Will be hidden if empty' , 'customizr' )
          ),
          'tc_author_title'  =>  array(
                            'default'         => '',
                            'label'       => __( 'Author pages titles' , 'customizr' ),
                            'control'   =>  'CZR_controls' ,
                            'section'     => 'post_lists_sec' ,
                            'type'        => 'text' ,
                            'priority'       => 110
                            //'notice'    => __( 'Will be hidden if empty' , 'customizr' )
          ),
          'tc_search_title'  =>  array(
                            'default'         => __( 'Search Results for :' , 'customizr' ),
                            'label'       => __( 'Search results page titles' , 'customizr' ),
                            'control'   =>  'CZR_controls' ,
                            'section'     => 'post_lists_sec' ,
                            'type'        => 'text' ,
                            'priority'       => 115
                            //'notice'    => __( 'Will be hidden if empty' , 'customizr' )
          ),

          'tc_post_list_grid'  =>  array(
                            'default'       => $_post_list_type,
                            'control'       => 'CZR_controls' ,
                            'title'         => __( 'Post List Design' , 'customizr' ),
                            'label'         => __( 'Select a Layout' , "customizr" ),
                            'section'       => 'post_lists_sec' ,
                            'type'          => 'select',
                            'choices'       => array(
                                    'alternate'       => __( 'Alternate thumbnails layout' , 'customizr'),
                                    'grid'            => __( 'Grid layout' , 'customizr'),
                                    //new
                                    'plain'           => __( 'Plain full layout' , 'customizr'),

                            ),
                            'priority'      => 40,
                            'notice'    => __( 'When you select the grid Layout, the post content is limited to the excerpt.' , 'customizr' ),
          ),
          'tc_grid_columns'  =>  array(
                            'default'       => '3',
                            'control'       => 'CZR_controls' ,
                            'label'         => __( 'Number of columns per row' , "customizr" ),
                            'section'       => 'post_lists_sec' ,
                            'type'          => 'select',
                            'choices'       => array(
                                    '1'                     => __( '1' , 'customizr'),
                                    '2'                     => __( '2' , 'customizr'),
                                    '3'                     => __( '3' , 'customizr'),
                                    '4'                     => __( '4' , 'customizr')
                            ),
                            'priority'      => 45,
                            'notice'        => __( 'Note : columns are limited to 3 for single sidebar layouts and to 2 for double sidebar layouts.' , 'customizr' )
          ),
          'tc_grid_expand_featured'  =>  array(
                            'default'       => 1,
                            'control'       => 'CZR_controls' ,
                            'label'         => __( 'Expand the last sticky post (for home and blog page only)' , "customizr" ),
                            'section'       => 'post_lists_sec' ,
                            'type'          => 'checkbox',
                            'priority'      => 47
          ),

          'tc_grid_shadow'  =>  array(
                            'default'       => 1,
                            'control'       => 'CZR_controls' ,
                            'label'         => __( 'Apply a shadow to each grid items' , "customizr" ),
                            'section'       => 'post_lists_sec' ,
                            'type'          => 'checkbox',
                            'priority'      => 61,
                            'transport'   => czr_fn_is_ms() ? 'refresh' : 'postMessage'
          ),
          'tc_grid_bottom_border'  =>  array(
                            'default'       => 1,
                            'control'       => 'CZR_controls' ,
                            'label'         => __( 'Apply a colored bottom border to each grid items' , "customizr" ),
                            'section'       => 'post_lists_sec' ,
                            'type'          => 'checkbox',
                            'priority'      => 62,
                            'transport'   => czr_fn_is_ms() ? 'refresh' : 'postMessage'
          ),

          'tc_grid_num_words'  =>  array(
                            'default'       => 10,
                            'sanitize_callback' => 'czr_fn_sanitize_number',
                            'control'       => 'CZR_controls' ,
                            'label'         => __( 'Max. length for post titles (in words)' , "customizr" ),
                            'section'       => 'post_lists_sec' ,
                            'type'          => 'number' ,
                            'step'          => 1,
                            'min'           => 1,
                            'priority'      => 64
          ),

          /* new:
          In customizr 4 used only for the Classical grid */
          'tc_post_list_thumb_placeholder'  =>  array(
                            'default'       => 1,
                            'control'     => 'CZR_controls' ,
                            'label'         => __( "Display thumbnail placeholder if no images available" , "customizr" ),
                            'section'       => 'post_lists_sec' ,
                            'type'          => 'checkbox',
                            'priority'      => 99
          ),

  );
}



/*-----------------------------------------------------------------------------------------------------
                               SINGLE POSTS SECTION
------------------------------------------------------------------------------------------------------*/
function czr_fn_single_post_option_map( $get_default = null ) {
  return array(
      'tc_single_post_thumb_location'  =>  array(
                        'default'       => 'hide',
                        'control'     => 'CZR_controls' ,
                        'label'         => __( 'Post thumbnail position' , 'customizr' ),
                        'title'         => __( 'Featured Image' , 'customizr' ),
                        'section'       => 'single_posts_sec' ,
                        'type'      =>  'select' ,
                        'choices'     => array(
                                'hide'                    => __( "Don't display" , 'customizr' ),
                                '__before_main_wrapper|200'   => __( 'Before the title in full width' , 'customizr' ),
                                '__before_content|0'     => __( 'Before the title boxed' , 'customizr' ),
                                '__after_content_title|10'    => __( 'After the title' , 'customizr' ),
                        ),
                        'priority'      => 10,
                        'notice'    => sprintf( '%s<br/>%s',
                          __( 'You can display the featured image (also called the post thumbnail) of your posts before their content, when they are displayed individually.' , 'customizr' ),
                          sprintf( __( "Don't know how to set a featured image to a post? Learn how in the %s.", "customizr" ),
                              sprintf('<a href="%1$s" title="%2$s" target="_blank">%2$s<span style="font-size: 17px;" class="dashicons dashicons-external"></span></a>' , esc_url('codex.wordpress.org/Post_Thumbnails#Setting_a_Post_Thumbnail'), __("WordPress documentation" , "customizr" ) )
                          )
                        )
      ),
      'tc_single_post_thumb_height' => array(
                        'default'       => 250,
                        'sanitize_callback' => 'czr_fn_sanitize_number',
                        'control'   => 'CZR_controls' ,
                        'label'       => __( "Set the thumbnail's max height in pixels" , 'customizr' ),
                        'section'     => 'single_posts_sec' ,
                        'type'        => 'number' ,
                        'step'        => 1,
                        'min'         => 0,
                        'priority'      => 20,
                        'transport'   => czr_fn_is_ms() ? 'refresh' : 'postMessage'
      ),
      'tc_related_posts' => array(
                        'default'   => 'categories',
                        'control'   => 'CZR_controls',
                        'title'     => __( 'Related posts', 'customizr'),
                        'label'     => __( 'Single - Related Posts', 'customizr'),
                        'section'   => 'single_posts_sec',
                        'type'      => 'select',
                        'priority'  => 20,
                        'choices' => array(
                          'disabled'    => __( 'Disable' , 'customizr' ),
                          'categories'  => __( 'Related by categories' , 'customizr' ),
                          'tags'        => __( 'Related by tags' , 'customizr' )
                        ),
                        'notice'    => __( 'Display randomized related articles below the post' , 'customizr'),
      ),

  );

}


/*-----------------------------------------------------------------------------------------------------
                               SINGLE PAGESS SECTION
------------------------------------------------------------------------------------------------------*/
function czr_fn_single_page_option_map( $get_default = null ) {
  return array(
      'tc_single_page_thumb_location'  =>  array(
                        'default'       => 'hide',
                        'control'     => 'CZR_controls' ,
                        'label'         => __( 'Post thumbnail position', 'customizr' ),
                        'title'         => __( 'Featured Image' , 'customizr' ),
                        'section'       => 'single_pages_sec' ,
                        'type'      =>  'select' ,
                        'choices'     => array(
                                'hide'                    => __( "Don't display" , 'customizr' ),
                                '__before_main_wrapper|200'   => __( 'Before the title in full width' , 'customizr' ),
                                '__before_content|0'     => __( 'Before the title boxed' , 'customizr' ),
                                '__after_content_title|10'    => __( 'After the title' , 'customizr' ),
                        ),
                        'priority'      => 10,
                        'notice'    => sprintf( '%s<br/>%s',
                          __( 'You can display the featured image (also called the post thumbnail) of your pages before their content, when they are displayed individually.' , 'customizr' ),
                          sprintf( __( "Don't know how to set a featured image to a page? Learn how in the %s.", "customizr" ),
                              sprintf('<a href="%1$s" title="%2$s" target="_blank">%2$s<span style="font-size: 17px;" class="dashicons dashicons-external"></span></a>' , esc_url('codex.wordpress.org/Post_Thumbnails#Setting_a_Post_Thumbnail'), __("WordPress documentation" , "customizr" ) )
                          )
                        )
      ),
      'tc_single_page_thumb_height' => array(
                        'default'       => 250,
                        'sanitize_callback' => 'czr_fn_sanitize_number',
                        'control'   => 'CZR_controls' ,
                        'label'       => __( "Set the thumbnail's max height in pixels" , 'customizr' ),
                        'section'     => 'single_pages_sec' ,
                        'type'        => 'number' ,
                        'step'        => 1,
                        'min'         => 0,
                        'priority'      => 20,
                        'transport'   => czr_fn_is_ms() ? 'refresh' : 'postMessage'
      )
  );

}




/*-----------------------------------------------------------------------------------------------------
                               BREADCRUMB SECTION
------------------------------------------------------------------------------------------------------*/
function czr_fn_breadcrumb_option_map( $get_default = null ) {
    return array(
          'tc_breadcrumb' => array(
                          'default'       => 1,//Breadcrumb is checked by default
                          'label'         => __( 'Display Breadcrumb' , 'customizr' ),
                          'control'     =>  'CZR_controls' ,
                          'section'       => 'breadcrumb_sec' ,
                          'type'          => 'checkbox' ,
                          'priority'      => 1,
          ),
          'tc_show_breadcrumb_home'  =>  array(
                            'default'       => 0,
                            'control'     => 'CZR_controls' ,
                            'label'         => __( "Display the breadcrumb on home page" , "customizr" ),
                            'section'       => 'breadcrumb_sec' ,
                            'type'          => 'checkbox' ,
                            'priority'      => 20
          ),
          'tc_show_breadcrumb_in_pages'  =>  array(
                            'default'       => 1,
                            'control'     => 'CZR_controls' ,
                            'label'         => __( "Display the breadcrumb in pages" , "customizr" ),
                            'section'       => 'breadcrumb_sec' ,
                            'type'          => 'checkbox' ,
                            'priority'      => 30

          ),
          'tc_show_breadcrumb_in_single_posts'  =>  array(
                            'default'       => 1,
                            'control'     => 'CZR_controls' ,
                            'label'         => __( "Display the breadcrumb in single posts" , "customizr" ),
                            'section'       => 'breadcrumb_sec' ,
                            'type'          => 'checkbox' ,
                            'priority'      => 40

          ),
          'tc_show_breadcrumb_in_post_lists'  =>  array(
                            'default'       => 1,
                            'control'     => 'CZR_controls' ,
                            'label'         => __( "Display the breadcrumb in posts lists : blog page, archives, search results..." , "customizr" ),
                            'section'       => 'breadcrumb_sec' ,
                            'type'          => 'checkbox' ,
                            'priority'      => 50

          ),
          'tc_breadcrumb_yoast' => array(
                            'default'   => czr_fn_user_started_before_version( '3.4.39' , '1.2.39' ) ? 0 : 1,
                            'label'     => __( "Use Yoast SEO breadcrumbs" , "customizr" ),
                            'control'   => 'CZR_controls' ,
                            'section'   => 'breadcrumb_sec',
                            'notice'    => sprintf( __( "Jump to the Yoast SEO breadcrumbs %s" , "customizr"),
                                            sprintf( '<a href="%1$s" title="%3$s">%2$s &raquo;</a>',
                                              "javascript:wp.customize.section('wpseo_breadcrumbs_customizer_section').focus();",
                                              __("customization panel" , "customizr"),
                                              esc_attr__("Yoast SEO breadcrumbs settings", "customizr")
                                            )
                                          ),
                            'type'      => 'checkbox' ,
                            'priority'  => 60,
                            'active_callback' => apply_filters( 'tc_yoast_breadcrumbs_option_enabled', '__return_false' )
          ),
  );

}

/*-----------------------------------------------------------------------------------------------------
                              POST METAS SECTION
------------------------------------------------------------------------------------------------------*/
function czr_fn_post_metas_option_map( $get_default = null ){
  return array(
          'tc_show_post_metas'  =>  array(
                            'default'       => 1,
                            'control'     => 'CZR_controls' ,
                            'label'         => __( "Display posts metas" , "customizr" ),
                            'section'       => 'post_metas_sec' ,
                            'type'          => 'checkbox',
                            'notice'    => __( 'When this option is checked, the post metas (like taxonomies, date and author) are displayed below the post titles.' , 'customizr' ),
                            'priority'      => 5,
                            'transport'   => czr_fn_is_ms() ? 'refresh' : 'postMessage'
          ),
          'tc_show_post_metas_home'  =>  array(
                            'default'       => 0,
                            'control'     => 'CZR_controls' ,
                            'title'         => __( 'Select the contexts' , 'customizr' ),
                            'label'         => __( "Display posts metas on home" , "customizr" ),
                            'section'       => 'post_metas_sec' ,
                            'type'          => 'checkbox',
                            'priority'      => 15,
                            'transport'   => czr_fn_is_ms() ? 'refresh' : 'postMessage'
          ),
          'tc_show_post_metas_single_post'  =>  array(
                            'default'       => 1,
                            'control'     => 'CZR_controls' ,
                            'label'         => __( "Display posts metas for single posts" , "customizr" ),
                            'section'       => 'post_metas_sec' ,
                            'type'          => 'checkbox',
                            'priority'      => 20,
                            'transport'   => czr_fn_is_ms() ? 'refresh' : 'postMessage'
          ),
          'tc_show_post_metas_post_lists'  =>  array(
                            'default'       => 1,
                            'control'     => 'CZR_controls' ,
                            'label'         => __( "Display posts metas in post lists (archives, blog page)" , "customizr" ),
                            'section'       => 'post_metas_sec' ,
                            'type'          => 'checkbox',
                            'priority'      => 25,
                            'transport'   => czr_fn_is_ms() ? 'refresh' : 'postMessage'
          ),

          'tc_show_post_metas_categories'  =>  array(
                            'default'       => 1,
                            'control'     => 'CZR_controls',
                            'title'         => __( 'Select the metas to display' , 'customizr' ),
                            'label'         => __( "Display hierarchical taxonomies (like categories)" , "customizr" ),
                            'section'       => 'post_metas_sec',
                            'type'          => 'checkbox',
                            'priority'      => 30
          ),

          'tc_show_post_metas_tags'  =>  array(
                            'default'       => 1,
                            'control'     => 'CZR_controls',
                            'label'         => __( "Display non-hierarchical taxonomies (like tags)" , "customizr" ),
                            'section'       => 'post_metas_sec',
                            'type'          => 'checkbox',
                            'priority'      => 35
          ),

          'tc_show_post_metas_author'  =>  array(
                            'default'       => 1,
                            'control'     => 'CZR_controls',
                            'label'         => __( "Display the author" , "customizr" ),
                            'section'       => 'post_metas_sec',
                            'type'          => 'checkbox',
                            'priority'      => 40
          ),
          'tc_show_post_metas_publication_date'  =>  array(
                            'default'       => 1,
                            'control'     => 'CZR_controls',
                            'label'         => __( "Display the publication date" , "customizr" ),
                            'section'       => 'post_metas_sec',
                            'type'          => 'checkbox',
                            'priority'      => 45
          ),
          //Think about displaying this only in singles like hueman does!
          //it's very ugly in post lists :/
          'tc_show_post_metas_update_date'  =>  array(
                            'default'       => 0,
                            'control'     => 'CZR_controls',
                            'label'         => __( "Display the update date" , "customizr" ),
                            'section'       => 'post_metas_sec',
                            'type'          => 'checkbox',
                            'priority'      => 50,
          ),

  );
}



/*-----------------------------------------------------------------------------------------------------
                               GALLERY SECTION
-----------------------------------------------------------------------------------------------------*/
/* Totally removed in modern style ( v4+ ) */
function czr_fn_gallery_option_map( $get_default = null ){
  return array(
          'tc_enable_gallery'  =>  array(
                            'default'       => 1,
                            'label'         => __('Enable Customizr galleries' , 'customizr'),
                            'control'       => 'CZR_controls' ,
                            'notice'         => __( "Apply Customizr effects to galleries images" , "customizr" ),
                            'section'       => 'galleries_sec' ,
                            'type'          => 'checkbox',
                            'priority'      => 1
          ),
          'tc_gallery_fancybox'=>  array(
                            'default'       => 1,
                            'label'         => __('Enable Lightbox effect in galleries' , 'customizr'),
                            'control'       => 'CZR_controls' ,
                            'notice'         => __( "Apply lightbox effects to galleries images" , "customizr" ),
                            'section'       => 'galleries_sec' ,
                            'type'          => 'checkbox',
                            'priority'      => 1
          ),
          'tc_gallery_style'=>  array(
                            'default'       => 1,
                            'label'         => __('Enable Customizr effects on hover' , 'customizr'),
                            'control'       => 'CZR_controls' ,
                            'notice'         => __( "Apply nice on hover expansion effect to the galleries images" , "customizr" ),
                            'section'       => 'galleries_sec' ,
                            'type'          => 'checkbox',
                            'transport'     => czr_fn_is_ms() ? 'refresh' : 'postMessage',
                            'priority'      => 1
          )
  );
}



/*-----------------------------------------------------------------------------------------------------
                               COMMENTS SECTION
------------------------------------------------------------------------------------------------------*/
function czr_fn_comment_option_map( $get_default = null ) {
  return array(
          'tc_comment_show_bubble'  =>  array(
                            'default'       => 1,
                            //'title'         => __('Comments bubbles' , 'customizr'),
                            'control'       => 'CZR_controls' ,
                            'label'         => czr_fn_is_ms() ? __( "Display the number of comments below the post titles" , "customizr" ) : __( "Display the number of comments in a bubble next to the post title" , "customizr" ),
                            'section'       => 'comments_sec' ,
                            'type'          => 'checkbox',
                            'priority'      => 1
          ),
          'tc_page_comments'  =>  array(
                            'default'     => 0,
                            'control'     => 'CZR_controls',
                            'title'       => __( 'Other comments settings' , 'customizr'),
                            'label'       => __( 'Enable comments on pages' , 'customizr' ),
                            'section'     => 'comments_sec',
                            'type'        => 'checkbox',
                            'priority'    => 40,
                            'notice'      => sprintf('%1$s<br/> %2$s <a href="%3$s" target="_blank">%4$s</a>',
                                __( 'If checked, this option will enable comments on pages. You can disable comments for a single page in the quick edit mode of the page list screen.' , 'customizr' ),
                                __( "You can also change other comments settings in :" , 'customizr'),
                                admin_url() . 'options-discussion.php',
                                __( 'the discussion settings page.' , 'customizr' )
                            ),
          ),
          'tc_post_comments'  =>  array(
                            'default'     => 1,
                            'control'     => 'CZR_controls',
                            'label'       => __( 'Enable comments on posts' , 'customizr' ),
                            'section'     => 'comments_sec',
                            'type'        => 'checkbox',
                            'priority'    => 45,
                            'notice'      => sprintf('%1$s <a href="%2$s" target="_blank">%3$s<span style="font-size: 17px;" class="dashicons dashicons-external"></span></a>.<br/>%4$s <a href="%5$s" target="_blank">%6$s</a>',
                                __( 'If checked, this option enables comments on all types of single posts. You can disable comments for a single post in quick edit mode from the' , 'customizr' ),
                                esc_url('codex.wordpress.org/Posts_Screen'),
                                __( 'post screen', 'customizr'),
                                __( "You can also change other comments settings in the" , 'customizr'),
                                admin_url('options-discussion.php'),
                                __( 'discussion settings page.' , 'customizr' )
                            ),
          ),
          'tc_show_comment_list'  =>  array(
                            'default'     => 1,
                            'control'     => 'CZR_controls',
                            'label'       => __( 'Display the comment list' , 'customizr' ),
                            'section'     => 'comments_sec',
                            'type'        => 'checkbox',
                            'priority'    => 50,
                            'notice'      =>__( 'By default, WordPress displays the past comments, even if comments are disabled in posts or pages. Unchecking this option allows you to not display this comment history.' , 'customizr' )
          )
  );
}



/*-----------------------------------------------------------------------------------------------------
                               POST NAVIGATION SECTION
------------------------------------------------------------------------------------------------------*/
function czr_fn_post_navigation_option_map( $get_default = null ) {
  return array(
          'tc_show_post_navigation'  =>  array(
                            'default'       => 1,
                            'control'     => 'CZR_controls' ,
                            'label'         => __( "Display posts navigation" , "customizr" ),
                            'section'       => 'post_navigation_sec' ,
                            'type'          => 'checkbox',
                            'notice'    => __( 'When this option is checked, the posts navigation is displayed below the posts' , 'customizr' ),
                            'priority'      => 5,
                            'transport'   => czr_fn_is_ms() ? 'refresh' : 'postMessage'
          ),

          'tc_show_post_navigation_page'  =>  array(
                            'default'       => 0,
                            'control'     => 'CZR_controls' ,
                            'title'         => __( 'Select the contexts' , 'customizr' ),
                            'label'         => __( "Display navigation in pages" , "customizr" ),
                            'section'       => 'post_navigation_sec' ,
                            'type'          => 'checkbox',
                            'priority'      => 10,
                            'transport'   => czr_fn_is_ms() ? 'refresh' : 'postMessage'
          ),
          'tc_show_post_navigation_single'  =>  array(
                            'default'       => 1,
                            'control'     => 'CZR_controls' ,
                            'label'         => __( "Display posts navigation in single posts" , "customizr" ),
                            'section'       => 'post_navigation_sec' ,
                            'type'          => 'checkbox',
                            'priority'      => 20,
                            'transport'   => czr_fn_is_ms() ? 'refresh' : 'postMessage'
          ),
          'tc_show_post_navigation_archive'  =>  array(
                            'default'       => 1,
                            'control'     => 'CZR_controls' ,
                            'label'         => __( "Display posts navigation in post lists (archives, blog page, categories, search results ..)" , "customizr" ),
                            'section'       => 'post_navigation_sec' ,
                            'type'          => 'checkbox',
                            'priority'      => 25,
                            'transport'   => czr_fn_is_ms() ? 'refresh' : 'postMessage'
          ),
  );
}



/******************************************************************************************************
*******************************************************************************************************
* PANEL : SIDEBARS
*******************************************************************************************************
******************************************************************************************************/
/*-----------------------------------------------------------------------------------------------------
                               SIDEBAR SOCIAL LINKS SETTINGS SECTION
------------------------------------------------------------------------------------------------------*/
function czr_fn_sidebars_option_map( $get_default = null ) {
  return array(
          'tc_social_in_left-sidebar' =>  array(
                            'default'       => 0,
                            'label'       => __( 'Social links in left sidebar' , 'customizr' ),
                            'control'   =>  'CZR_controls' ,
                            'section'     => 'sidebar_socials_sec',
                            'type'        => 'checkbox' ,
                            'priority'       => 20,
                            'ubq_section'   => array(
                                                'section' => 'socials_sec',
                                                'priority' => '2'
                                             )
          ),

          'tc_social_in_right-sidebar'  =>  array(
                            'default'       => 0,
                            'label'       => __( 'Social links in right sidebar' , 'customizr' ),
                            'control'   =>  'CZR_controls' ,
                            'section'     => 'sidebar_socials_sec',
                            'type'        => 'checkbox' ,
                            'priority'       => 25,
                            'ubq_section'   => array(
                                                'section' => 'socials_sec',
                                                'priority' => '3'
                                             )
          ),
  );
}



/******************************************************************************************************
*******************************************************************************************************
* PANEL : FOOTER
*******************************************************************************************************
******************************************************************************************************/
/*-----------------------------------------------------------------------------------------------------
                               FOOTER GLOBAL SETTINGS SECTION
------------------------------------------------------------------------------------------------------*/
function czr_fn_footer_global_settings_option_map( $get_default = null ) {
  return array(
          /* new */
          'tc_footer_skin'  =>  array(
                            'default'       => 'dark',
                            'control'       => 'CZR_controls' ,
                            'label'         => __( 'Footer style', 'customizr'),
                            'choices'       => array(
                                  'dark'   => __( 'Dark' , 'customizr' ),
                                  'light'  => __( 'Light' , 'customizr')
                            ),
                            'section'       => 'footer_global_sec' ,
                            'type'          => 'select' ,
                            'priority'      => 0
          ),
          'tc_social_in_footer' =>  array(
                            'default'       => 1,
                            'label'       => __( 'Social links in footer' , 'customizr' ),
                            'control'   =>  'CZR_controls' ,
                            'section'     => 'footer_global_sec' ,
                            'type'        => 'checkbox' ,
                            'priority'       => 0,
                            'ubq_section'  => array(
                                                'section' => 'socials_sec',
                                                'priority' => '4'
                                             )
          ),
          'tc_sticky_footer'  =>  array(
                            'default'       => czr_fn_user_started_before_version( '3.4.0' , '1.1.14' ) ? 0 : 1,
                            'control'       => 'CZR_controls' ,
                            'label'         => __( "Stick the footer to the bottom of the page", "customizr" ),
                            'section'       => 'footer_global_sec' ,
                            'type'          => 'checkbox',
                            'priority'      => 1,
                            'transport'     => czr_fn_is_ms() ? 'refresh' : 'postMessage',
                            'notice'      =>__( "Enabling this option will glue your footer to the bottom of the screen, when pages are shorter than the viewport's height." , 'customizr' )
          ),
          'tc_show_back_to_top'  =>  array(
                            'default'       => 1,
                            'control'       => 'CZR_controls' ,
                            'label'         => __( "Display a back to top arrow on scroll" , "customizr" ),
                            'section'       => 'footer_global_sec' ,
                            'type'          => 'checkbox',
                            'priority'      => 5
                        ),
          'tc_back_to_top_position'  =>  array(
                            'default'       => 'right',
                            'control'       => 'CZR_controls' ,
                            'label'         => __( "Back to top arrow position" , "customizr" ),
                            'section'       => 'footer_global_sec' ,
                            'type'          => 'select',
                            'choices'       => array(
                                  'left'      => __( 'Left' , 'customizr' ),
                                  'right'     => __( 'Right' , 'customizr'),
                            ),
                            'priority'      => 5,
                            'transport'     => czr_fn_is_ms() ? 'refresh' : 'postMessage'
          ),
  );
}




/******************************************************************************************************
*******************************************************************************************************
* PANEL : ADVANCED OPTIONS
*******************************************************************************************************
******************************************************************************************************/
/*-----------------------------------------------------------------------------------------------------
                               CUSTOM CSS SECTION
------------------------------------------------------------------------------------------------------*/
function czr_fn_custom_css_option_map( $get_default = null ) {
  global $wp_version;

  return version_compare( $wp_version, '4.7', '>=' ) ? array() : array(
          'tc_custom_css' =>  array(
                            'sanitize_callback' => 'wp_filter_nohtml_kses',
                            'sanitize_js_callback' => 'wp_filter_nohtml_kses',
                            'control'   => 'CZR_controls' ,
                            'label'       => __( 'Add your custom css here and design live! (for advanced users)' , 'customizr' ),
                            'section'     => 'custom_sec' ,
                            'type'        => 'textarea' ,
                            'notice'    => sprintf('%1$s <a href="%4$ssnippet/creating-child-theme-customizr/" title="%3$s" target="_blank">%2$s</a>',
                                __( "Use this field to test small chunks of CSS code. For important CSS customizations, you'll want to modify the style.css file of a" , 'customizr' ),
                                __( 'child theme.' , 'customizr'),
                                __( 'How to create and use a child theme ?' , 'customizr'),
                                CZR_WEBSITE
                            ),
                            'transport'   => czr_fn_is_ms() ? 'refresh' : 'postMessage'
          ),
  );//end of custom_css_options
}


/*-----------------------------------------------------------------------------------------------------
                          WEBSITE PERFORMANCES SECTION
------------------------------------------------------------------------------------------------------*/
function czr_fn_performance_option_map( $get_default = null ) {
  return array(
          'tc_minified_skin'  =>  array(
                            'default'       => 1,
                            'control'   => 'CZR_controls' ,
                            'label'       => __( "Performance : use the minified CSS stylesheets", 'customizr' ),
                            'section'     => 'performances_sec' ,
                            'type'        => 'checkbox' ,
                            'notice'    => __( 'Using the minified version of the stylesheets will speed up your webpage load time.' , 'customizr' ),
          ),
          'tc_img_smart_load'  =>  array(
                            'default'       => 0,
                            'label'       => __( 'Load images on scroll' , 'customizr' ),
                            'control'     =>  'CZR_controls',
                            'section'     => 'performances_sec',
                            'type'        => 'checkbox',
                            'priority'    => 20,
                            'notice'      => __('Check this option to delay the loading of non visible images. Images below the viewport will be loaded dynamically on scroll. This can boost performances by reducing the weight of long web pages with images.' , 'customizr')
          )
  );
}

/*-----------------------------------------------------------------------------------------------------
                          FRONT END NOTICES AND PLACEHOLDERS SECTION
------------------------------------------------------------------------------------------------------*/
function czr_fn_placeholders_notice_map( $get_default = null ) {
  return array(
          'tc_display_front_help'  =>  array(
                            'default'       => 1,
                            'control'   => 'CZR_controls',
                            'label'       => __( "Display help notices on front-end for logged in users.", 'customizr' ),
                            'section'     => 'placeholder_sec',
                            'type'        => 'checkbox',
                            'notice'    => __( 'When this options is enabled, various help notices and some placeholder blocks are displayed on the front-end of your website. They are only visible by logged in users with administration capabilities.' , 'customizr' )
          )
  );
}

/*-----------------------------------------------------------------------------------------------------
                          FRONT END EXTERNAL RESOURCES SECTION
------------------------------------------------------------------------------------------------------*/
function czr_fn_external_resources_option_map( $get_default = null ) {
  return array(
          'tc_font_awesome_icons'  =>  array(
                            'default'       => 1,
                            'control'   => 'CZR_controls',
                            'label'       => __( "Load Font Awesome resources", 'customizr' ),
                            'section'     => 'extresources_sec',
                            'type'        => 'checkbox',
                            'notice'      => sprintf('<strong>%1$s</strong>. %2$s</br>%3$s',
                                __( 'Use with caution' , 'customizr'),
                                __( 'When checked, the Font Awesome icons and CSS will be loaded on front end. You might want to load the Font Awesome icons with a custom code, or let a plugin do it for you.', 'customizr' ),
                                sprintf('%1$s <a href="%2$s" target="_blank">%3$s<span style="font-size: 17px;" class="dashicons dashicons-external"></span></a>.',
                                                                    __( "Check out some example of uses", 'customizr'),
                                                                    esc_url('http://fontawesome.io/examples/'),
                                                                    __('here', 'customizr')
                                )
                            )
          )

  );
}

/*-----------------------------------------------------------------------------------------------------
                          RESPONSIVE SECTION
------------------------------------------------------------------------------------------------------*/
function czr_fn_responsive_option_map( $get_default = null ) {
  return array(
          'tc_ms_respond_css'  =>  array(
                            'default'     => 1,
                            'control'     => 'CZR_controls',
                            'label'       => __( 'Automatically adapt the font size to the width of the devices', 'customizr' ),
                            'section'     => 'responsive_sec',
                            'type'        => 'checkbox',
                            'notice'    => __( 'When this options is enabled, your font size will automatically resize to be better displayed in mobile devices.' , 'customizr' )
          )

  );
}



/*-----------------------------------------------------------------------------------------------------
                          THEME STYLE SECTION
------------------------------------------------------------------------------------------------------*/
function czr_fn_style_option_map( $get_default = null ) {
  $_notice = __( 'The Modern style provides a "material design" look and feel. It relies on the flexbox css mode, offering a better support for the most recent mobile devices and browsers. The Classical style provides a more "flat design" feeling, with icons next to titles for example. It supports both modern and older devices and browsers.', 'customizr' );
  return array(
          'tc_style'  =>  array(
                            'default'    => ! czr_fn_is_ms() ? 'classic' : 'modern',
                            'control'   => 'CZR_controls',
                            'label'       => is_child_theme() ? __( "Set the Modern or Classical design style", 'customizr' ) : __( "Select a design style for the theme", 'customizr' ),
                            'section'     => 'style_sec',
                            'type'        => 'select',
                            'choices'       => array(
                                  'modern'      => __( 'Modern' , 'customizr' ),
                                  'classic'     => __( 'Classical' , 'customizr' ),
                            ),
                            'notice'      => ! is_child_theme() ? $_notice :  sprintf( '%1$s <br/><br/> %2$s', $_notice, __( "Add the the following code to your wp-config.php file to switch between the classical and modern styles : <br/>define( 'CZR_MODERN_STYLE', true );.<br/><br/>The two styles can use different template files. If you have overriden templates in your child theme, it is recommended to switch style in a staging site before production.", 'customizr' ) )
          )

  );
}


/***************************************************************
* POPULATE PANELS
***************************************************************/
/**
* hook : tc_add_panel_map
* @return  associative array of customizer panels
*/
function czr_fn_popul_panels_map( $panel_map ) {
  $_new_panels = array(
    'tc-global-panel' => array(
              'priority'       => 10,
              'capability'     => 'edit_theme_options',
              'title'          => __( 'Global settings' , 'customizr' ),
              'czr_subtitle'   => __( 'Title, Logo, Fonts, Primary color, Social, ...', 'customizr'),
              'type'           => 'czr_panel'
    ),
    'tc-header-panel' => array(
              'priority'       => 20,
              'capability'     => 'edit_theme_options',
              'title'          => __( 'Header' , 'customizr' ),
              'czr_subtitle'   => __( 'Style, Desktops and mobiles layout, Menus, Search, ...', 'customizr'),
              'type'           => 'czr_panel'
    ),
    'tc-content-panel' => array(
              'priority'       => 30,
              'capability'     => 'edit_theme_options',
              'title'          => __( 'Main Content' , 'customizr' ),
              'czr_subtitle'   => __( 'Column layout, Post lists design, Thumbnails, Post Metas, Navigation, ...', 'customizr'),
              'type'           => 'czr_panel'
    ),
    'tc-sidebars-panel' => array(
              'priority'       => 30,
              'capability'     => 'edit_theme_options',
              'title'          => __( 'Sidebars' , 'customizr' ),
              'type'           => 'czr_panel'
    ),
    'tc-footer-panel' => array(
              'priority'       => 40,
              'capability'     => 'edit_theme_options',
              'title'          => __( 'Footer' , 'customizr' ),
              'czr_subtitle'   => __( 'Style, Back to top button, Sticky mode, ... ', 'customizr'),
              'type'           => 'czr_panel'
    ),
    'tc-advanced-panel' => array(
              'priority'       => 1000,
              'capability'     => 'edit_theme_options',
              'title'          => __( 'Advanced options' , 'customizr' ),
              'czr_subtitle'   => __( 'Performances, Custom CSS ...', 'customizr'),
              'type'           => 'czr_panel'
    )
  );
  return array_merge( $panel_map, $_new_panels );
}





/***************************************************************
* POPULATE REMOVE SECTIONS
***************************************************************/
/**
 * hook : czr_remove_section_map
 */
function czr_fn_popul_remove_section_map( $_sections ) {
  //customizer option array
  $remove_section = array(
    'static_front_page' ,
    'nav',
    'title_tagline',
    'tc_page_comments'
  );
  return array_merge( $_sections, $remove_section );
}


/***************************************************************
* HANDLES THE THEME SWITCHER (since WP 4.2)
***************************************************************/
/**
* Print the themes section (themes switcher) when previewing the themes from wp-admin/themes.php
* hook : czr_remove_section_map
*/
function czr_fn_set_theme_switcher_visibility( $_sections) {
  //Don't do anything is in preview frame
  //=> because once the preview is ready, a postMessage is sent to the panel frame to refresh the sections and panels
  //Do nothing if WP version under 4.2
  global $wp_version;
  if ( czr_fn_is_customize_preview_frame() || ! version_compare( $wp_version, '4.2', '>=') )
    return $_sections;

  if ( ! CZR_IS_PRO )
    return $_sections;
  else {
    array_push( $_sections, 'themes');
    return $_sections;
  }
}



/***************************************************************
* POPULATE SECTIONS
***************************************************************/
/**
* hook : tc_add_section_map
*/
function czr_fn_popul_section_map( $_sections ) {
  //declare a var to check wp version >= 4.0
  global $wp_version;
  $_is_wp_version_before_4_0 = ( ! version_compare( $wp_version, '4.0', '>=' ) ) ? true : false;

  //For nav menus option
  $locations                = get_registered_nav_menus();
  $menus                    = wp_get_nav_menus();
  $num_locations            = count( array_keys( $locations ) );


  $nav_section_desc =  sprintf( _n('Your theme supports %s menu. Select which menu you would like to use.', 'Your theme supports %s menus. Select which menu appears in each location.', $num_locations, 'customizr' ), number_format_i18n( $num_locations ) );
  //adapt the nav section description for v4.3 (menu in the customizer from now on)
  if ( version_compare( $wp_version, '4.3', '<' ) ) {
    $nav_section_desc .= "<br/>" . sprintf( __("You can create new menu and edit your menu's content %s." , "customizr"),
      sprintf( '<strong><a href="%1$s" target="_blank" title="%3$s">%2$s &raquo;</a></strong>',
        admin_url('nav-menus.php'),
        __("on the Menus screen in the Appearance section" , "customizr"),
        __("create/edit menus", "customizr")
      )
    );
  } else {
    $nav_section_desc .= "<br/>" . sprintf( __("You can create new menu and edit your menu's content %s." , "customizr"),
      sprintf( '<strong><a href="%1$s" title="%3$s">%2$s &raquo;</a><strong>',
        "javascript:wp.customize.section('nav').container.find('.customize-section-back').trigger('click'); wp.customize.panel('nav_menus').focus();",
        __("in the menu panel" , "customizr"),
        __("create/edit menus", "customizr")
      )
    );
  }

  if ( ! czr_fn_is_ms() ) {
      $nav_section_desc .= "<br/><br/>". __( 'If a menu location has no menu assigned to it, a default page menu will be used.', 'customizr');
  }

  $_new_sections = array(
    /*---------------------------------------------------------------------------------------------
    -> PANEL : GLOBAL SETTINGS
    ----------------------------------------------------------------------------------------------*/
    //the title_tagline section holds the default WP setting for the Site Title and the Tagline
    //This section has been previously removed from its initial location and is added back here
    'title_tagline'         => array(
                        'title'    => __( 'Site Identity : Logo, Title, Tagline and Site Icon', 'customizr' ),
                        'priority' => $_is_wp_version_before_4_0 ? 7 : 0,
                        'panel'   => 'tc-global-panel',
                        'section_class' => 'CZR_Customize_Sections',
                        'ubq_panel'   => array(
                            'panel' => 'tc-header-panel',
                            'priority' => '1'
                        )
    ),
    'skins_sec'         => array(
                        'title'     =>  __( 'Primary color of the theme' , 'customizr' ),
                        'priority'    =>  $_is_wp_version_before_4_0 ? 1 : 7,
                        'description' =>  __( 'Pick a primary color for the theme' , 'customizr' ),
                        'panel'   => 'tc-global-panel'
    ),
    'fonts_sec'          => array(
                        'title'     =>  __( 'Fonts' , 'customizr' ),
                        'priority'    =>  $_is_wp_version_before_4_0 ? 40 : 10,
                        //'description' =>  __( 'Set up the font global settings' , 'customizr' ),
                        'panel'   => 'tc-global-panel'
    ),
    'socials_sec'        => array(
                        'title'     =>  __( 'Social links' , 'customizr' ),
                        'priority'    =>  $_is_wp_version_before_4_0 ? 9 : 20,
                        //'description' =>  __( 'Set up your social links' , 'customizr' ),
                        'panel'   => 'tc-global-panel'
    ),
    'formatting_sec'         => array(
                        'title'     =>  __( 'Formatting : links, paragraphs ...' , 'customizr' ),
                        'priority'    =>  $_is_wp_version_before_4_0 ? 22 : 30,
                        //'description' =>  __( 'Various links settings' , 'customizr' ),
                        'panel'   => 'tc-global-panel'
    ),
    'images_sec'         => array(
                        'title'     =>  __( 'Image settings' , 'customizr' ),
                        'priority'    =>  $_is_wp_version_before_4_0 ? 95 : 50,
                        //'description' =>  __( 'Various images settings' , 'customizr' ),
                        'section_class' => 'CZR_Customize_Sections',
                        'panel'   => 'tc-global-panel',
                        'ubq_panel'   => array(
                            'panel' => 'tc-content-panel',
                            'priority' => '100'
                        )
    ),
    'sliders_sec'               => array(
                        'title'     =>  __( 'Sliders options' , 'customizr' ),
                        'priority'    =>  $_is_wp_version_before_4_0 ? 96 : 60,
                        //'description' =>  __( 'Post authors settings' , 'customizr' ),
                        'panel'   => 'tc-global-panel'
    ),
    'authors_sec'               => array(
                        'title'     =>  __( 'Authors' , 'customizr' ),
                        'priority'    =>  $_is_wp_version_before_4_0 ? 220 : 70,
                        //'description' =>  __( 'Post authors settings' , 'customizr' ),
                        'panel'   => 'tc-global-panel'
    ),
    'smoothscroll_sec'          => array(
                        'title'     =>  __( 'Smooth Scroll' , 'customizr' ),
                        'priority'    =>  $_is_wp_version_before_4_0 ? 97 : 75,
                        //'description' =>  __( 'Smooth Scroll settings' , 'customizr' ),
                        'panel'   => 'tc-global-panel'
    ),

    /*---------------------------------------------------------------------------------------------
    -> PANEL : HEADER
    ----------------------------------------------------------------------------------------------*/
    'header_layout_sec'         => array(
                        'title'    => $_is_wp_version_before_4_0 ? __( 'Header design and layout', 'customizr' ) : __( 'General design settings', 'customizr' ),
                        'priority' => 10,//$_is_wp_version_before_4_0 ? 5 : 20,
                        'panel'   => 'tc-header-panel'
    ),
    'header_desktop_sec'         => array(
                        'title'    => __( 'Design settings for desktop and laptops', 'customizr' ),
                        'priority' => 20,
                        'panel'   => 'tc-header-panel'
    ),
    'header_mobile_sec'         => array(
                        'title'    => __( 'Design settings for smartphones and tablets in portrait orientation', 'customizr' ),
                        'priority' => 30,
                        'panel'   => 'tc-header-panel'
    ),
    'nav'           => array(
                        'title'          => __( 'Navigation Menus' , 'customizr' ),
                        'theme_supports' => 'menus',
                        'priority'       => 40,//$_is_wp_version_before_4_0 ? 10 : 40,
                        'description'    => $nav_section_desc,
                        'panel'   => 'tc-header-panel'
    ),


    /*---------------------------------------------------------------------------------------------
    -> PANEL : CONTENT
    ----------------------------------------------------------------------------------------------*/
    'frontpage_sec'       => array(
                        'title'     =>  __( 'Front Page Content' , 'customizr' ),
                        'priority'    =>  $_is_wp_version_before_4_0 ? 12 : 10,
                        //'description' =>  __( 'Set up front page options' , 'customizr' ),
                        'section_class' => 'CZR_Customize_Sections',
                        'panel'   => '',//tc-content-panel',
                        'active_callback' => 'czr_fn_is_home',
                        'ubq_panel'   => array(
                            'panel' => 'tc-content-panel',
                            'priority' => '10'
                        )
    ),

    'post_layout_sec'        => array(
                        'title'     =>  __( 'Pages &amp; Posts Layout' , 'customizr' ),
                        'priority'    =>  $_is_wp_version_before_4_0 ? 15 : 15,
                        //'description' =>  __( 'Set up layout options' , 'customizr' ),
                        'panel'   => 'tc-content-panel'
    ),

    'post_lists_sec'        => array(
                        'title'     =>  __( 'Post lists : blog, archives, ...' , 'customizr' ),
                        'priority'    =>  $_is_wp_version_before_4_0 ? 16 : 20,
                        //'description' =>  __( 'Set up post lists options : blog page, archives like tag or category, search results.' , 'customizr' ),
                        'panel'   => 'tc-content-panel'
    ),
    'single_posts_sec'        => array(
                        'title'     =>  __( 'Single posts' , 'customizr' ),
                        'priority'    =>  $_is_wp_version_before_4_0 ? 17 : 24,
                        //'description' =>  __( 'Set up single posts options' , 'customizr' ),
                        'panel'   => 'tc-content-panel'
    ),
    'single_pages_sec'        => array(
                        'title'     =>  __( 'Single pages' , 'customizr' ),
                        'priority'    =>  $_is_wp_version_before_4_0 ? 17 : 24,
                        //'description' =>  __( 'Set up single pages options' , 'customizr' ),
                        'panel'   => 'tc-content-panel'
    ),
    'breadcrumb_sec'        => array(
                        'title'     =>  __( 'Breadcrumb' , 'customizr' ),
                        'priority'    =>  $_is_wp_version_before_4_0 ? 11 : 30,
                        //'description' =>  __( 'Set up breadcrumb options' , 'customizr' ),
                        'panel'   => 'tc-content-panel'
    ),
    'post_metas_sec'        => array(
                        'title'     =>  __( 'Post metas (category, tags, custom taxonomies)' , 'customizr' ),
                        'priority'    =>  $_is_wp_version_before_4_0 ? 20 : 50,
                        //'description' =>  __( 'Set up post metas options' , 'customizr' ),
                        'panel'   => 'tc-content-panel'
    ),
    'galleries_sec'        => array(
                        'title'     =>  __( 'Galleries' , 'customizr' ),
                        'priority'    =>  $_is_wp_version_before_4_0 ? 20 : 55,
                        //'description' =>  __( 'Set up gallery options' , 'customizr' ),
                        'panel'   => 'tc-content-panel'
    ),
    'comments_sec'          => array(
                        'title'     =>  __( 'Comments' , 'customizr' ),
                        'priority'    =>  $_is_wp_version_before_4_0 ? 25 : 60,
                        //'description' =>  __( 'Set up comments options' , 'customizr' ),
                        'panel'   => 'tc-content-panel',
                        'section_class' => 'CZR_Customize_Sections',
                        'ubq_panel'   => array(
                            'panel' => 'tc-global-panel',
                            'priority' => '100'
                        )
    ),
    'post_navigation_sec'          => array(
                        'title'     =>  __( 'Post/Page Navigation' , 'customizr' ),
                        'priority'    =>  $_is_wp_version_before_4_0 ? 30 : 65,
                        //'description' =>  __( 'Set up post/page navigation options' , 'customizr' ),
                        'panel'   => 'tc-content-panel'
    ),


    /*---------------------------------------------------------------------------------------------
    -> PANEL : SIDEBARS
    ----------------------------------------------------------------------------------------------*/
    'sidebar_socials_sec'          => array(
                        'title'     =>  __( 'Socials in Sidebars' , 'customizr' ),
                        'priority'    =>  110,
                        //'description' =>  __( 'Set up your social profiles links in the sidebar(s).' , 'customizr' ),
                        'panel'   => 'tc-content-panel'
    ),
    /*---------------------------------------------------------------------------------------------
    -> PANEL : FOOTER
    ----------------------------------------------------------------------------------------------*/
    'footer_global_sec'          => array(
                        'title'     =>  __( 'Footer global settings' , 'customizr' ),
                        'priority'    =>  $_is_wp_version_before_4_0 ? 40 : 10,
                        //'description' =>  __( 'Set up footer global options' , 'customizr' ),
                        'panel'   => 'tc-footer-panel'
    ),


    /*---------------------------------------------------------------------------------------------
    -> PANEL : ADVANCED
    ----------------------------------------------------------------------------------------------*/
    'custom_sec'           => array(
                        'title'     =>  __( 'Custom CSS' , 'customizr' ),
                        'priority'    =>  $_is_wp_version_before_4_0 ? 100 : 10,
                        'panel'   => 'tc-advanced-panel'
    ),
    'performances_sec'      => array(
                        'title'     =>  __( 'Website Performances' , 'customizr' ),
                        'priority'    => 20,
                        //'description' =>  __( 'On the web, speed is key ! Improve the load time of your pages with those options.' , 'customizr' ),
                        'panel'   => 'tc-advanced-panel'
    ),
    'placeholder_sec'     => array(
                        'title'     =>  __( 'Front-end placeholders and help blocks' , 'customizr' ),
                        'priority'    => 30,
                        'panel'   => 'tc-advanced-panel'
    ),
    'extresources_sec'    => array(
                        'title'     =>  __( 'Front-end Icons (Font Awesome)' , 'customizr' ),
                        'priority'    => 40,
                        'panel'   => 'tc-advanced-panel'
    ),
    'responsive_sec'    => array(
                        'title'     =>  __( 'Mobile devices' , 'customizr' ),
                        'priority'    => 40,
                        'panel'   => 'tc-advanced-panel'
    ),
    'style_sec'    => array(
                        'title'     =>  __( 'Theme style' , 'customizr' ),
                        'priority'    => 40,
                        'panel'   => 'tc-advanced-panel'
    )
  );

  if ( czr_fn_is_pro_section_on() ) {
    $_new_sections = array_merge( $_new_sections, array(
        /*---------------------------------------------------------------------------------------------
        -> SECTION : GO-PRO
        ----------------------------------------------------------------------------------------------*/
        'go_pro_sec'   => array(
                            'title'         => esc_html__( 'Upgrade to Customizr Pro', 'customizr' ),
                            'pro_text'      => esc_html__( 'Go Pro', 'customizr' ),
                            'pro_url'       => sprintf('%scustomizr-pro/', CZR_WEBSITE ),
                            'priority'      => 0,
                            'section_class' => 'CZR_Customize_Section_Pro',
                            'active_callback' => 'czr_fn_pro_section_active_cb'
        ),
    ) );
  }

  return array_merge( $_sections, $_new_sections );
}



function czr_fn_force_remove_section_map( $_sections ) {
  global $wp_version;

  // FORCE REMOVE SECTIONS
  // CUSTOM CSS section for wp >= 4.7
  if ( version_compare( $wp_version, '4.7', '>=' ) )
    unset( $_sections[ 'custom_sec' ] );

  return $_sections;
}

/***************************************************************
* CONTROLS HELPERS
***************************************************************/
/**
* Generates the featured pages options
* add the settings/controls to the relevant section
* hook : tc_front_page_option_map
*
* @package Customizr
* @since Customizr 3.0.15
*
*/
function czr_fn_generates_featured_pages( $_original_map ) {
  $default = array(
    'dropdown'  =>  array(
          'one'   => __( 'Home featured page one' , 'customizr' ),
          'two'   => __( 'Home featured page two' , 'customizr' ),
          'three' => __( 'Home featured page three' , 'customizr' )
    ),
    'text'    => array(
          'one'   => __( 'Featured text one (200 char. max)' , 'customizr' ),
          'two'   => __( 'Featured text two (200 char. max)' , 'customizr' ),
          'three' => __( 'Featured text three (200 char. max)' , 'customizr' )
    )
  );

  //declares some loop's vars and the settings array
  $priority       = 70;
  $incr         = 0;
  $fp_setting_control = array();

  //gets the featured pages id from init
  $fp_ids       = apply_filters( 'tc_featured_pages_ids' , CZR___::$instance -> fp_ids);

  //dropdown field generator
  foreach ( $fp_ids as $id ) {
    $priority = $priority + $incr;
    $fp_setting_control['tc_featured_page_'. $id]    =  array(
                  'default'     => 0,
                  'label'       => isset($default['dropdown'][$id]) ? $default['dropdown'][$id] :  sprintf( __('Custom featured page %1$s' , 'customizr' ) , $id ),
                  'section'     => 'frontpage_sec' ,
                  'type'        => 'dropdown-pages' ,
                  'priority'      => $priority
                );
    $incr += 10;
  }

  //text field generator
  $incr         = 10;
  foreach ( $fp_ids as $id ) {
    $priority = $priority + $incr;
    $fp_setting_control['tc_featured_text_' . $id]   = array(
                  'sanitize_callback' => 'czr_fn_sanitize_textarea',
                  'transport'   => czr_fn_is_ms() ? 'refresh' : 'postMessage',
                  'control'   => 'CZR_controls' ,
                  'label'       => isset($default['text'][$id]) ? $default['text'][$id] : sprintf( __('Featured text %1$s (200 char. max)' , 'customizr' ) , $id ),
                  'section'     => 'frontpage_sec' ,
                  'type'        => 'textarea' ,
                  'notice'    => __( 'You need to select a page first. Leave this field empty if you want to use the page excerpt.' , 'customizr' ),
                  'priority'      => $priority,
                );
    $incr += 10;
  }

  return array_merge( $_original_map , $fp_setting_control );
}
