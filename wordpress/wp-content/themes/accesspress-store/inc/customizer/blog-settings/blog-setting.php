<?php
function accesspress_blog_setting($wp_customize){
  
  $wp_customize->add_section(
    'blog_setting',
    array(
      'title'           =>      __('Blog Settings', 'accesspress-store'),
      'priority'        =>      '41',
      )
    );  
  
  $wp_customize->add_setting(
    'blog_post_layout',
    
    array(
      'default'       =>      '',
      'sanitize_callback'     =>  'accesspress_store_blog_layout'
      )
    );
  
  $wp_customize->add_control( 'blog_post_layout',
    array(
      'section'       =>      'blog_setting',
      'label'         =>      __('Blog Layout', 'accesspress-store'),
      'type'          =>      'select',
      'choices'       =>      array( 
        'blog_layout1' => __('Blog Image Large', 'accesspress-store'),
        'blog_layout2' => __('Blog Image Medium', 'accesspress-store'),
        'blog_layout3' => __('Blog Image Medium Alternate', 'accesspress-store'),
        'blog_layout4' => __('Blog Full Content', 'accesspress-store'),
        )
      )
    );

$categories = array();
$categories_obj = get_categories();
foreach ($categories_obj as $category) {
  $categories[$category->term_id] = $category->name;
}

  $wp_customize->add_setting(
    'blog_exclude_categories',
    array(
      'default'       =>      '',
      'sanitize_callback'     =>'sanitize_text_field'
      )
    );
  
  $wp_customize->add_control( new AccessPress_Store_WP_Category_Checkboxes_Control(
    $wp_customize,
    'blog_exclude_categories',
    array(
      'label' => 'Exclude From Blog',
      'type' => 'category-checkboxes',
      'section' => 'blog_setting',
      'choices' => $categories
      )
    ));
  
}
add_action('customize_register', 'accesspress_blog_setting');