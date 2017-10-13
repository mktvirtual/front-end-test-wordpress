<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php
	/**
	 * woocommerce_before_single_product hook.
	 *
	 * @hooked wc_print_notices - 10
	 */
	do_action( 'woocommerce_before_single_product' );
	
	if ( post_password_required() ) {
		echo get_the_password_form();
		return;
	}
	
	
	// prev & next post -------------------
	$single_post_nav = array(
		'hide-header'	=> false,
		'hide-sticky'	=> false,
	);
	
	$opts_single_post_nav = mfn_opts_get( 'prev-next-nav' );
	if( is_array( $opts_single_post_nav ) ){
	
		if( isset( $opts_single_post_nav['hide-header'] ) ){
			$single_post_nav['hide-header'] = true;
		}
		if( isset( $opts_single_post_nav['hide-sticky'] ) ){
			$single_post_nav['hide-sticky'] = true;
		}
	
	}
	
	$post_prev = get_adjacent_post( false, '', true );
	$post_next = get_adjacent_post( false, '', false );
	
	// WC < 2.7 backward compatibility
	if( version_compare( WC_VERSION, '2.7', '<' ) ){
		$shop_page_id = woocommerce_get_page_id( 'shop' );
	} else {
		$shop_page_id = wc_get_page_id( 'shop' );
	}

	
	// post classes -----------------------
	$classes = array();
	
	if( mfn_opts_get( 'share' ) == 'hide-mobile' ){
		$classes[] = 'no-share-mobile';
	} elseif( ! mfn_opts_get( 'share' ) ) {
		$classes[] = 'no-share';
	}
	
	$single_product_style = mfn_opts_get( 'shop-product-style' );
	$classes[] = $single_product_style;
	 
	
	// translate
	$translate['all'] = mfn_opts_get('translate') ? mfn_opts_get('translate-all','Show all') : __('Show all','betheme');
	
	
	// WC < 2.7 backward compatibility
	if( version_compare( WC_VERSION, '2.7', '<' ) ){		
		$product_schema = 'itemscope itemtype="'. woocommerce_get_product_schema() .'"';
	} else {
		$product_schema = '';
	}
?>

<div <?php echo $product_schema; ?> id="product-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	
	<?php 
		// single post navigation | sticky
		if( ! $single_post_nav['hide-sticky'] ){
			echo mfn_post_navigation_sticky( $post_prev, 'prev', 'icon-left-open-big' ); 
			echo mfn_post_navigation_sticky( $post_next, 'next', 'icon-right-open-big' );
		} 
	?>
		
	<?php 
		// single post navigation | header
		if( ! $single_post_nav['hide-header'] ){
			echo mfn_post_navigation_header( $post_prev, $post_next, $shop_page_id, $translate );
		}
	?>

	
	<div class="product_wrapper clearfix">

		<div class="column one-second product_image_wrapper">
			<?php
				/**
				 * woocommerce_before_single_product_summary hook.
				 *
				 * @hooked woocommerce_show_product_sale_flash - 10
				 * @hooked woocommerce_show_product_images - 20
				 */
				do_action( 'woocommerce_before_single_product_summary' );	
			?>
		</div>
	
		<div class="summary entry-summary column one-second">
	
			<?php
				/**
				 * woocommerce_single_product_summary hook.
				 *
				 * @hooked woocommerce_template_single_title - 5
				 * @hooked woocommerce_template_single_rating - 10
				 * @hooked woocommerce_template_single_price - 10
				 * @hooked woocommerce_template_single_excerpt - 20
				 * @hooked woocommerce_template_single_add_to_cart - 30
				 * @hooked woocommerce_template_single_meta - 40
				 * @hooked woocommerce_template_single_sharing - 50
				 * @hooked WC_Structured_Data::generate_product_data() - 60
				 */
				do_action( 'woocommerce_single_product_summary' );
			?>
			
			<?php 
				// Description | Default - right column
				if( in_array( $single_product_style, array( 'wide', 'wide tabs') ) ) {
					remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
				}
				
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
			?>
			
			<?php
				/**
				 * woocommerce_after_single_product_summary hook.
				 *
				 * @hooked woocommerce_output_product_data_tabs - 10
				 * @hooked woocommerce_upsell_display - 15
				 * @hooked woocommerce_output_related_products - 20
				 */
				do_action( 'woocommerce_after_single_product_summary' );
			?>
	
		</div>
		
		<?php if( mfn_opts_get( 'share' ) ): ?>
			<div class="share_wrapper">
				<span class='st_facebook_vcount' displayText='Facebook'></span>
				<span class='st_twitter_vcount' displayText='Tweet'></span>
				<span class='st_pinterest_vcount' displayText='Pinterest'></span>
				
				<script src="http<?php mfn_ssl(1); ?>://w<?php mfn_ssl(1); ?>.sharethis.com/button/buttons.js"></script>
				<script>stLight.options({publisher: "1390eb48-c3c3-409a-903a-ca202d50de91", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
			</div>
		<?php endif; ?>
		
	</div>
	
	
	<?php 
		// Description | Default - wide below image
		if( in_array( $single_product_style, array( 'wide', 'wide tabs') ) ) {
			woocommerce_output_product_data_tabs(); 
		}
	?>
	
	
	<?php 
		woocommerce_upsell_display();
		if( mfn_opts_get( 'shop-related' ) ) woocommerce_output_related_products(); 
	?>
	
	
	<?php if( version_compare( WC_VERSION, '2.7', '<' ) ): ?>
		<meta itemprop="url" content="<?php the_permalink(); ?>" />
	<?php endif; ?>


</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
