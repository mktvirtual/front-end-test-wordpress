<?php
/**
 * AccessPress Pro Custom Widgets
 *
 * @package Accesspress Pro
 */

/**
 * Include helper functions that display widget fields in the dashboard
 *
 * @since Accesspress Store Widget Pack 1.0.0
 */
require $accesspress_store_widget_fields_file_path = accesspress_store_file_directory('inc/widgets/widget-fields.php');

/**
 * Load Icon Text Widget File
 *
 * @since Accesspress Store Widget Pack 1.0.0
 */
require $accesspress_store_widget_icon_file_path = accesspress_store_file_directory('inc/widgets/widget-icon-text.php');

/**
 * Load Call To Action Widget File
 *
 * @since Accesspress Store Widget Pack 1.0.0
 */
require $accesspress_store_widget_calltoaction_file_path = accesspress_store_file_directory('inc/widgets/widget-cta-simple.php');


/**
 * Load Promo Widget file
 *
 * @since Accesspress Store Widget Pack 1.0.0
 */
require $accesspress_store_widget_promo_file_path = accesspress_store_file_directory('inc/widgets/widget-promo.php');

/**
 * Load the WooCommerce Custom Widget file
 *
 * @since Accesspress Store Widget Pack 1.0.0
 */

/**
 * Check if WooCommerce is active
*/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	require $accesspress_store_widget_product1_file_path = accesspress_store_file_directory('inc/widgets/widget-product1.php');
	require $accesspress_store_widget_product2_file_path = accesspress_store_file_directory('inc/widgets/widget-product2.php');
}

/**
 * Load Video Call To Action Widget File
 *
 * @since Accesspress Store Widget Pack 1.0.0
 */
require $accesspress_store_widget_vidoe_calltoaction_file_path = accesspress_store_file_directory('inc/widgets/widget-cta-video.php');

/**
 * Load Full Promo Widget File
 *
 * @since Accesspress Store Widget Pack 1.0.0
 */
require $accesspress_store_widget_full_promo_file_path = accesspress_store_file_directory('inc/widgets/widget-full-promo.php');