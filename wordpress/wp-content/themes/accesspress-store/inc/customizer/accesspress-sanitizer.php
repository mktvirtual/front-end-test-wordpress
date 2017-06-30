<?php

  function accesspress_store_sanitize_text( $input ) {
      return wp_kses_post( force_balance_tags( $input ) );
  }
  
  function accesspress_store_radio_sanitize_webpagelayout($input) {
    $valid_keys = array(
       'boxed' => __('Boxed', 'accesspress-store'),
       'fullwidth' => __('Full Width', 'accesspress-store')
    );
    if ( array_key_exists( $input, $valid_keys ) ) {
       return $input;
    } else {
       return '';
    }
  }

  function accesspress_store_radio_sanitize_archive_view($input) {
    $valid_keys = array(
       'list' => __('List', 'accesspress-store'),
       'grid' => __('Grid', 'accesspress-store')
    );
    if ( array_key_exists( $input, $valid_keys ) ) {
       return $input;
    } else {
       return '';
    }
  }

  function accesspress_store_blog_layout($input) {
    $valid_keys = array( 
              		'blog_layout1' => __('Blog Image Large', 'accesspress-store'),
              		'blog_layout2' => __('Blog Image Medium', 'accesspress-store'),
                  'blog_layout3' => __('Blog Image Medium Alternate', 'accesspress-store'),
              		'blog_layout4' => __('Blog Full Content', 'accesspress-store'),
              		);
    if ( array_key_exists( $input, $valid_keys ) ) {
       return $input;
    } else {
       return '';
    }
  }

  function accesspress_store_bkg_type($input) {
    $valid_keys = array(
      'color' => __('Color', 'accesspress-store'),
      'image' => __('Image', 'accesspress-store'),
      'pattern' => __('Pattern', 'accesspress-store')
    );
    if ( array_key_exists( $input, $valid_keys ) ) {
       return $input;
    } else {
       return '';
    }
  }

  function accesspress_store_bkg_pattern($input) {
      $imagepath =  get_template_directory_uri() . '/inc/images/';
      $valid_keys = array( 
              		'pattern1' => $imagepath.'patterns/80X80/pattern1.png',  
              		'pattern2' =>  $imagepath.'patterns/80X80/pattern2.png', 
              		'pattern3' =>  $imagepath.'patterns/80X80/pattern3.png', 
              		'pattern4' => $imagepath.'patterns/80X80/pattern4.png', 
              		'pattern5' =>  $imagepath.'patterns/80X80/pattern5.png',  
             		   'pattern6' => $imagepath.'patterns/80X80/pattern6.png', 
              		);
        if ( array_key_exists( $input, $valid_keys ) ) {
           return $input;
        } else {
           return '';
        }
  }
   
  function accesspress_store_page_layouts($input) {
    $imagepath =  get_template_directory_uri() . '/inc/images/';
    $valid_keys = array(
      'left-sidebar' => $imagepath.'left-sidebar.png',  
      'right-sidebar' => $imagepath.'right-sidebar.png', 
       'both-sidebar' => $imagepath.'both-sidebar.png',
      'no-sidebar' => $imagepath.'no-sidebar.png',
    );
    if ( array_key_exists( $input, $valid_keys ) ) {
       return $input;
    } else {
       return '';
    }
  }
   
  function accesspress_store_slider_transition_sanitize($input) {
    $valid_keys = array(
      'true' => __('Fade', 'accesspress-store'),
      'false' => __('Slide', 'accesspress-store'),
    );
    if ( array_key_exists( $input, $valid_keys ) ) {
       return $input;
    } else {
       return '';
    }
  }

  function accesspress_store_radio_sanitize_header_layout($input) {
    $valid_keys = array(
      'headerone' => __('Header Style One', 'accesspress-store'),
      'headertwo' => __('Header Style Two', 'accesspress-store') 
    );
    if ( array_key_exists( $input, $valid_keys ) ) {
       return $input;
    } else {
       return '';
    }
  } 

  function accesspress_store_radio_sanitize_widget_layout($input) {
    $valid_keys = array(
      'title_style_one' => __('Widget Title Style One', 'accesspress-store'),
      'title_style_two' => __('Widget Title Style Two', 'accesspress-store')  
    );
    if ( array_key_exists( $input, $valid_keys ) ) {
       return $input;
    } else {
       return '';
    }
  } 
      
  function accesspress_store_radio_sanitize_enabledisable($input) {
    $valid_keys = array(
      'enable'=>__('Enable', 'accesspress-store'),
      'disable'=>__('Disable', 'accesspress-store')
    );
    if ( array_key_exists( $input, $valid_keys ) ) {
       return $input;
    } else {
       return '';
    }
  }
   
  function accesspress_store_radio_sanitize_yesno($input) {
    $valid_keys = array(
      'yes'=>__('Yes', 'accesspress-store'),
      'no'=>__('No', 'accesspress-store')
      );
    if ( array_key_exists( $input, $valid_keys ) ) {
     return $input;
    } else {
     return '';
    }
  }
   
  function accesspress_store_checkbox_sanitize($input) {
    if ( $input == 1 ) {
       return 1;
    } else {
       return '';
    }
  }
    
  function accesspress_store_integer_sanitize($input){
      return intval( $input );
  }