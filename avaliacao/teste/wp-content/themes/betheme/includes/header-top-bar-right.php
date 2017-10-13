<?php
global $woocommerce;

// WooCommerce Cart
$show_cart = trim( mfn_opts_get( 'shop-cart' ) );
if( $show_cart == 1 ) $show_cart = 'icon-bag-fine';
$has_cart = ( $woocommerce && $show_cart ) ? true : false;

// Search
$header_search = mfn_opts_get( 'header-search' );

// Action Button
$action_link = mfn_opts_get( 'header-action-link' );

// WPML Icon
if( has_nav_menu( 'lang-menu' ) ){
	$wpml_icon = true;
} elseif( function_exists( 'icl_get_languages' ) && mfn_opts_get( 'header-wpml' ) != 'hide' ){
	$wpml_icon = true;
} else {
	$wpml_icon = false;
}

if( $has_cart || $header_search || $action_link || $wpml_icon ){
	echo '<div class="top_bar_right">';
		echo '<div class="top_bar_right_wrapper">';
		
			// WooCommerce Cart
			if( $has_cart ){
				echo '<a id="header_cart" href="'. $woocommerce->cart->get_cart_url() .'"><i class="'. $show_cart .'"></i><span>'. $woocommerce->cart->cart_contents_count .'</span></a>';
			}
			
			// Search Icon
			if( $header_search == 'input' ){
				
				$translate[ 'search-placeholder' ] = mfn_opts_get( 'translate' ) ? mfn_opts_get( 'translate-search-placeholder', 'Enter your search' ) : __( 'Enter your search', 'betheme' );
				
				echo '<a id="search_button" class="has-input">';
					echo '<form method="get" id="searchform" action="'. esc_url( home_url( '/' ) ) .'">';
					
						echo '<i class="icon-search-fine"></i>';
						echo '<input type="text" class="field" name="s" id="s" placeholder="'. $translate['search-placeholder'] .'" />';
						echo '<input type="submit" class="submit" value="" style="display:none;" />';	
										
					echo '</form>';
				echo '</a>';
				
			} elseif( $header_search ){
				
				echo '<a id="search_button" href="#"><i class="icon-search-fine"></i></a>';
				
			}
			
			// Languages menu
			get_template_part( 'includes/include', 'wpml' );

			// Action Button
			if( $action_link ){
			
				$action_options = mfn_opts_get( 'header-action-target' );
				
				if( isset( $action_options['target'] ) ){
					$action_target = 'target="_blank"';
				} else {
					$action_target = false;
				}
				
				if( isset( $action_options['scroll'] ) ){
					$action_class = 'scroll';
				} else {
					$action_class = false;
				}
			
				echo '<a href="'. $action_link .'" class="button button_theme button_js action_button '. $action_class .'" '. $action_target .'><span class="button_label">'. mfn_opts_get( 'header-action-title' ) .'</span></a>';
			}
						
		echo '</div>';
	echo '</div>';
}
