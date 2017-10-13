<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

?>

<div class="cart-empty alert alert_warning">
	<div class="alert_icon"><i class="icon-lamp"></i></div>
	<div class="alert_wrapper"><?php _e( 'Your cart is currently empty.', 'woocommerce' ) ?></div>
	<a class="close" href="#"><i class="icon-cancel"></i></a>
</div>

<?php do_action( 'woocommerce_cart_is_empty' ); ?>

<?php if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
	<p class="return-to-shop">
		<a class="button button_theme button_js" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
			<span class="button_icon"><i class="icon-basket"></i></span>
			<span class="button_label"><?php _e( 'Return To Shop', 'woocommerce' ) ?></span>
		</a>
	</p>
<?php endif; ?>