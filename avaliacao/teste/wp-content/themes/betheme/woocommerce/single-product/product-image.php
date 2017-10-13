<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product;

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
$thumbnail_post    = get_post( $post_thumbnail_id );
$image_title       = $thumbnail_post->post_content;
$placeholder       = has_post_thumbnail() ? 'with-images' : 'without-images';
$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . $placeholder,
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'images',
) );

?>	
<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>">
	<figure class="woocommerce-product-gallery__wrapper">
	
		<?php

			if( version_compare( WC_VERSION, '2.7', '<' ) ){
			
				// WC < 2.7 backward compatibility
				
				if ( has_post_thumbnail() ) {
	
					$attachment_count = count( $product->get_gallery_attachment_ids() );
					$gallery          = $attachment_count > 0 ? '[product-gallery]' : '';
					$props            = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
					$image            = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
						'title'	 => $props['title'],
						'alt'    => $props['alt'],
						'class'  => 'scale-with-grid',
					) );

					if( mfn_opts_get( 'shop-product-images' ) == 'plugin' ){
						
						// Disable Image Frames if use external plugin for Featured Images
						
						echo apply_filters(
							'woocommerce_single_product_image_html',
							sprintf(
								'<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto%s">%s</a>',
								esc_url( $props['url'] ),
								esc_attr( $props['caption'] ),
								$gallery,
								$image
							),
							$post->ID
						);	
								
					} else {	
					
						echo '<div class="image_frame scale-with-grid" ontouchstart="this.classList.toggle(\'hover\');">';
							echo '<div class="image_wrapper">';
							
								echo '<a href="'. esc_url( $props['url'] ) .'" itemprop="image" class="woocommerce-main-image zoom" title="'. esc_attr( $props['caption'] ) .'" data-rel="prettyPhoto' . $gallery . '">';
									echo '<div class="mask"></div>';
									echo $image;
								echo '</a>';
								
								echo '<div class="image_links">';
									echo '<a href="'. esc_url( $props['url'] ) .'" itemprop="image" class="woocommerce-main-image zoom" title="'. esc_attr( $props['caption'] ) .'"><i class="icon-search"></i></a>';
								echo '</div>';
							
							echo '</div>';
						echo '</div>';
					}
						
				} else {
					
					echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );
				
				}
			
			} else {
			
				// WC 2.7+
			
				$attributes = array(
					'title'                   => $image_title,
					'data-large-image'        => $full_size_image[0],
					'data-large-image-width'  => $full_size_image[1],
					'data-large-image-height' => $full_size_image[2],
				);
				
				if ( has_post_thumbnail() ) {
					$html  = '<figure data-thumb="' . get_the_post_thumbnail_url( $post->ID, 'shop_thumbnail' ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_size_image[0] ) . '">';
					$html .= get_the_post_thumbnail( $post->ID, 'shop_single', $attributes );
					$html .= '</a></figure>';
				} else {
					$html  = '<figure class="woocommerce-product-gallery__image--placeholder">';
					$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
					$html .= '</figure>';
				}
				
				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, get_post_thumbnail_id( $post->ID ) );

			}
			
			do_action( 'woocommerce_product_thumbnails' );

		?>

	</figure>
</div>
