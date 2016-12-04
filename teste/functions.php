<?php

/**
 * testetheme's functions and definitions
 *
 * @package testetheme
 * @since testetheme 1.0
 */

/**
 * First, let's set the maximum content width based on the theme's design and stylesheet.
 * This will limit the width of all uploaded images and embeds.
 */
if ( ! isset( $content_width ) )
    $content_width = 800; /* pixels */

if ( ! function_exists( 'teste_theme_setup' ) ) :
    function teste_theme_setup() {
        /**
         * Make theme available for translation.
         * Translations can be placed in the /languages/ directory.
         */
        load_theme_textdomain( 'testetheme', get_template_directory() . '/languages' );

        /**
         * Add default posts and comments RSS feed links to <head>.
         */
        add_theme_support( 'automatic-feed-links' );

        /**
         * Enable support for post thumbnails and featured images.
         */
        add_theme_support( 'post-thumbnails' );

        /**
         * Add support for two custom navigation menus.
         */
        register_nav_menus( array(
            'primary'   => __( 'Primary Menu', 'testetheme' ),
            'secondary' => __('Secondary Menu', 'testetheme' )
        ) );

        /**
         * Enable support for the following post formats:
         * aside, gallery, quote, image, and video
         */
        add_theme_support( 'post-formats', array ( 'aside', 'gallery', 'quote', 'image', 'video' ) );
    }
endif; // teste_theme_setup

add_action( 'after_setup_theme', 'teste_theme_setup' );

add_filter('show_admin_bar', '__return_false');
add_post_type_support( 'page', 'excerpt' );


function slider() {
  $labels = array(
    'name' => __('Slider', 'post type general name'),
    'singular_name' => __('slider')
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'public_queryable' => true,
    'supports' => array('title', 'thumbnail')
  );

  register_post_type( 'slider' , $args );
  flush_rewrite_rules();
}

// Change position 'feature image'

add_action('do_meta_boxes', 'move_meta_box');

function move_meta_box(){
  remove_meta_box( 'postimagediv', 'slider', 'side' );
  add_meta_box('postimagediv', __('adicionar imagem ao banner'), 'post_thumbnail_meta_box', 'slider', 'normal', 'high');
}

// Customizacao super banner
function theme_customize( $wp_customize ) {
    $wp_customize->add_section('theme_images', array(
        'title' => __('super banner','theme'),
        'description' => 'midifca o banner principal'
    ));
    $wp_customize->add_setting('superBanner', array(
        'default' => '../wp-content/themes/teste/public/images/superbanner.png',
    ));
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'superBanner', array(
        'label'    => __('Change logo site', 'theme'),
        'section'  => 'theme_images',
        'settings' => 'superBanner'
    )));


  // Custom colors

  $wp_customize->add_section('theme_colors', array(
    'title' => __('Colors','theme'),
    'description' => 'modify theme colors'
  ));

  $wp_customize->add_setting('background_navtop', array(
    'default' => '#f47d31'
  ));

  $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'background_navtop', array(
    'label'    => __('background navtop', 'theme'),
    'section'  => 'theme_colors',
    'settings' => 'background_navtop'
  )));
}

function theme_css_customizer() {
  ?>
  <style type="text/css">
    .nav-top {
      background-color: <?php echo get_theme_mod('background_navtop') ?>
    }

  </style>
  <?php
}





function scripts() {
  wp_enqueue_script( 'my-script',
  get_bloginfo('template_directory') . '/app/scripts/app.js', array('jquery') );
}

function theme_css() {
    $plugin_url = get_template_directory_uri();
    //wp_enqueue_style( 'style', $plugin_url . '/public/styles/styles.css' );
    wp_enqueue_style( 'style', $plugin_url . '/app/styles/styles.css' );
}

//ADICIONANDO O META BOX
add_action( 'add_meta_boxes', 'metabox_position_content' );
function metabox_position_content() {
  add_meta_box( 'my-meta-box-id', __('Posição do conteudo no card', 'teste'), 'metabox_position_content_card', 'post', 'side', 'high' );
}

function metabox_position_content_card() {
  $values = get_post_custom( get_the_ID() );
  $selected = isset( $values['meta_box_select'] ) ? esc_attr( $values['meta_box_select'][0] ) : '';
  wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); ?>

  <div id="0" style="display:inline;">
    <p>
      <label for="meta_box_select"><?php _e( 'Posicao:', 'teste' ); ?></label>
      <select name="meta_box_select" id="meta_box_select" style="height: 25px; width: 100px;">
      <option value="topLeft"    <?php selected( $selected, 'topLeft' ); ?>><?php _e( 'topLeft', 'teste' ); ?></option>
      <option value="bottomRight"  <?php selected( $selected, 'bottomRight' ); ?>><?php _e( 'bottomRight', 'teste' ); ?></option>
      <option value="bottom" <?php selected( $selected, 'bottom' ); ?>><?php _e( 'bottom', 'teste' ); ?></option>
      </select>
    </p>
  </div>

  <?php
}
add_action( 'save_post', 'pluginwp_meta_box_save' );
function pluginwp_meta_box_save( $post_id ) {
  if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
  if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
  if( !current_user_can( 'edit_post', $post_id ) ) return;

  $allowed = array( 'a' => array( 'href' => array() ));

  if( isset( $_POST['link_meta_box'] ) )
    update_post_meta( $post_id, 'link_meta_box', wp_kses( $_POST['link_meta_box'], $allowed ) ) ;
  if( isset( $_POST['meta_box_select'] ) )
    update_post_meta( $post_id, 'meta_box_select', esc_attr( $_POST['meta_box_select'] ) );
  $chk = ( isset( $_POST['meta_box_check_the_excerpt_on_off'] ) && $_POST['meta_box_check_the_excerpt_on_off'] ) ? '1' : '0';
    update_post_meta( $post_id, 'meta_box_check_the_excerpt_on_off', $chk );
}

add_action('wp_head', 'theme_css_customizer');
add_action( 'wp_enqueue_scripts', 'theme_css' );
add_action('init', 'slider');
add_action('template_redirect', 'scripts');
add_action( 'customize_register', 'theme_customize' );
?>





