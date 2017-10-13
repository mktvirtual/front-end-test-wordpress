<?php
/**
 * WooCommerce functions.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */


/* ---------------------------------------------------------------------------
 * WooCommerce - Theme support & actions
 * --------------------------------------------------------------------------- */
add_theme_support( 'woocommerce' );

// WooCommerce 2.7+ single product gallery
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);					// breadcrumbs
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);								// sidebar

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);		// content wrapper begin
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);		// content wrapper end

if( mfn_opts_get( 'shop-catalogue' ) ){
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);	// add to cart button
}

add_action( 'woocommerce_before_main_content', 'mfn_woocommerce_output_content_wrapper', 10);		// content wrapper begin
add_action( 'woocommerce_after_main_content', 'mfn_woocommerce_output_content_wrapper_end', 10);	// content wrapper end


/* ---------------------------------------------------------------------------
 * WooCommerce - Styles
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_woo_styles' ) )
{
	function mfn_woo_styles()
	{
		wp_enqueue_style( 'mfn-woo', THEME_URI .'/css/woocommerce.css', 'woocommerce-general-css', THEME_VERSION, 'all' );
	}
	add_action( 'wp_enqueue_scripts', 'mfn_woo_styles', 100 );
}


/* ---------------------------------------------------------------------------
 * WooCommerce - Define image sizes
* --------------------------------------------------------------------------- */
global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) add_action( 'init', 'mfn_woocommerce_image_dimensions', 1 );

if( ! function_exists( 'mfn_woocommerce_image_dimensions' ) )
{
	function mfn_woocommerce_image_dimensions() {
		$catalog = array(
			'width' 	=> '500',	// px
			'height'	=> '500',	// px
			'crop'		=> 1 		// true
		);
	
		$single = array(
			'width' 	=> '500',	// px
			'height'	=> '500',	// px
			'crop'		=> 1 		// true
		);
	
		$thumbnail = array(
			'width' 	=> '200',	// px
			'height'	=> '200',	// px
			'crop'		=> 1 		// true
		);
	
		// Image sizes
		update_option( 'shop_catalog_image_size', $catalog );		// Product category thumbs
		update_option( 'shop_single_image_size', $single ); 		// Single product image
		update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
	}
}


/* ---------------------------------------------------------------------------
 * WooCommerce - Before Main Content
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_woocommerce_output_content_wrapper' ) )
{
	function mfn_woocommerce_output_content_wrapper()
	{
		?>
		<!-- #Content -->
		<div id="Content">
			<div class="content_wrapper clearfix">
		
				<!-- .sections_group -->
				<div class="sections_group">
					<div class="section">
						<div class="section_wrapper clearfix">
							<div class="items_group clearfix">
								<div class="column one woocommerce-content">
		<?php 
	}
}


/* ---------------------------------------------------------------------------
 * WooCommerce - After Main Content
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_woocommerce_output_content_wrapper_end' ) )
{
	function mfn_woocommerce_output_content_wrapper_end()
	{
		?>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<!-- .four-columns - sidebar -->
				<?php 
					$layout = get_post_meta( mfn_ID(), 'mfn-post-layout', true);
					
			 		// Page | Search
					if( is_search() ){
						
						echo '<div class="sidebar four columns">';
							echo '<div class="widget-area clearfix '. mfn_opts_get('sidebar-lines') .'">';
								dynamic_sidebar( 'mfn-search' );
							echo '</div>';
						echo '</div>';	
						
					} elseif( is_active_sidebar( 'shop' ) && $layout != 'no-sidebar' ){
						
						if( is_product() && mfn_opts_get('shop-sidebar') ){
							// product page without sidebar
						} else {
							echo '<div class="sidebar four columns">';
								echo '<div class="widget-area clearfix '. mfn_opts_get('sidebar-lines') .'">';
									dynamic_sidebar( 'shop' );
								echo '</div>';
							echo '</div>';						
						}
						
					}		
				?>
		
			</div>
		</div>
		<?php
	}
}


/* ---------------------------------------------------------------------------
 *	WooCommerce - Products per line/page
 * --------------------------------------------------------------------------- */
add_filter( 'loop_shop_columns', create_function( false, 'return 3;' ) );

if( ! function_exists( 'mfn_woo_per_page' ) )
{
	function mfn_woo_per_page( $cols ){
		return mfn_opts_get( 'shop-products', 12 );
	}
}
add_filter( 'loop_shop_per_page', 'mfn_woo_per_page', 20 );


/* ---------------------------------------------------------------------------
 *	WooCommerce - Change number of related products on product page
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_woo_related_products_args' ) )
{
	function mfn_woo_related_products_args( $args ) {
		$args['posts_per_page'] = intval( mfn_opts_get( 'shop-related', 3 ) );
		return $args;
	}
}
add_filter( 'woocommerce_output_related_products_args', 'mfn_woo_related_products_args' );


/* ---------------------------------------------------------------------------
 *	WooCommerce - Ensure cart contents update when products are added to the cart via AJAX
 * --------------------------------------------------------------------------- */
global $woocommerce;
if( version_compare( $woocommerce->version, '2.3', '<' ) ){
	// WooCommerce 2.2 -
	add_filter( 'add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );
} else {
	// WooCommerce 2.3 +
	add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );
}

if( ! function_exists( 'woocommerce_header_add_to_cart_fragment' ) )
{
	function woocommerce_header_add_to_cart_fragment( $fragments ) {
		global $woocommerce;
		
		$cart_icon = mfn_opts_get('shop-cart');
		if( $cart_icon == 1 ) $cart_icon = 'icon-bag-fine'; // Be < 4.9 compatibility
	
		// header
		ob_start();
		echo '<a id="header_cart" href="'. $woocommerce->cart->get_cart_url() .'"><i class="'. $cart_icon .'"></i><span>'. $woocommerce->cart->cart_contents_count .'</span></a>';
		$fragments['a#header_cart'] = ob_get_clean();
		
		// side slide
		ob_start();
		echo '<a class="icon cart" id="slide-cart" href="'. $woocommerce->cart->get_cart_url() .'"><i class="'. $cart_icon .'"></i><span>'. $woocommerce->cart->cart_contents_count .'</span></a>';
		$fragments['a#slide-cart'] = ob_get_clean();
		
		return $fragments;
	}
}
