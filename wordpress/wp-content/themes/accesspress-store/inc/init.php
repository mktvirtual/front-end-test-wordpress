<?php
/**
 * Main include functions ( to support child theme )
 *
 * @since Accesspress Store 1.0.0
 *
 * @param string $file_path, path from the theme
 * @return string full path of file inside theme
 *
 */
if( !function_exists('accesspress_store_file_directory') ){

    function accesspress_store_file_directory( $file_path ){
        if( file_exists( trailingslashit( get_stylesheet_directory() ) . $file_path) ) {
            return trailingslashit( get_stylesheet_directory() ) . $file_path;
        }
        else{
            return trailingslashit( get_template_directory() ) . $file_path;
        }
    }
}


/**
 * Implement the Custom Functions.
*/
require $accesspress_store_custom_functions_file_path = accesspress_store_file_directory('inc/accesspress-function.php');

/**
 * Custom template tags for this theme.
*/
require $accesspress_store_template_tag_file_path = accesspress_store_file_directory('inc/core/template-tags.php');

/**
 * Custom functions that act independently of the theme templates.
*/
require $accesspress_store_extras_file_path = accesspress_store_file_directory('inc/core/extras.php');

/**
 * Load Jetpack compatibility file.
*/
require $accesspress_store_jetpack_file_path = accesspress_store_file_directory('inc/core/jetpack.php');

/**
 * Load General Setting
*/
require $accesspress_store_custom_header_file_path = accesspress_store_file_directory('inc/core/custom-header.php');

/**
 * Implement the Custom Metabox feature.
*/
require $accesspress_store_custom_metabox_file_path = accesspress_store_file_directory('inc/custom-metabox.php');

/**
 * Customizer additions.
*/
require $accesspress_store_customizer_file_path = accesspress_store_file_directory('inc/customizer/customizer.php');

/**
 * Load Custom Widget
*/
require $accesspress_store_widget_file_path = accesspress_store_file_directory('inc/widgets/accesspress-widget.php');

/**
 * Load Welcome Page
*/
require $accesspress_store_plugin_activation_file_path = accesspress_store_file_directory('welcome/welcome.php');