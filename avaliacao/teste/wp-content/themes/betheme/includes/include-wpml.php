<?php
/**
 * WPML Custom Switcher
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

if( has_nav_menu( 'lang-menu' ) ){
	
	// Custom Languages Menu

	echo '<div class="wpml-languages custom">';
	echo '<a class="active" href="#">'. mfn_get_menu_name( 'lang-menu' ) .'<i class="icon-down-open-mini"></i></a>';
	mfn_wp_lang_menu();
	echo '</div>';

} elseif( function_exists( 'icl_get_languages' ) ){
	
	// WPML - Custom Languages Menu

	$lang_args = '';
	$lang_options = mfn_opts_get( 'header-wpml-options' );
	$wmpl_flags = mfn_opts_get( 'header-wpml' );
						
	if( isset( $lang_options['link-to-home'] )){
		$lang_args .= 'skip_missing=0';
	} else {
		$lang_args .= 'skip_missing=1';
	}
	$languages = icl_get_languages( $lang_args );

	if( ( $wmpl_flags != 'hide' ) && $languages && is_array( $languages ) ){
			
		if( ! $wmpl_flags || $wmpl_flags == 'dropdown-name'  ){
			// dropdown ------------

			$active_lang = false;
			foreach( $languages as $lang_k=>$lang ){
				if( $lang['active'] ){
					$active_lang = $lang;
					unset( $languages[$lang_k] );
				}
			}

			// disabled
			if( count( $languages ) ){
				$lang_status = 'enabled';
			} else {
				$lang_status = 'disabled';
			}

			if( $active_lang ){
				$translate[ 'wpml-no' ] = mfn_opts_get( 'translate' ) ? mfn_opts_get( 'translate-wpml-no', 'No translations available for this page' ) : __( 'No translations available for this page', 'betheme' );

				echo '<div class="wpml-languages '. $lang_status .'">';
					
				echo '<a class="active tooltip" ontouchstart="this.classList.toggle(\'hover\');" data-tooltip="'. $translate['wpml-no'] .'">';
					
				if( $wmpl_flags == "dropdown-name" ){
					echo $active_lang['native_name'];
				} else {
					echo '<img src="'. $active_lang['country_flag_url'] .'" alt="'. $active_lang['translated_name'] .'" width="18" height="12"/>';
				}
					
				if( count( $languages ) ) echo '<i class="icon-down-open-mini"></i>';
					
				echo '</a>';

				if( count( $languages ) ){
					echo '<ul class="wpml-lang-dropdown">';
					foreach( $languages as $lang ){
							
						if( $wmpl_flags == 'dropdown-name' ){
							echo '<li><a href="'. $lang['url'] .'">'. $lang['native_name'] .'</a></li>';
						} else {
							echo '<li><a href="'. $lang['url'] .'"><img src="'. $lang['country_flag_url'] .'" alt="'. $lang['translated_name'] .'" width="18" height="12"/></a></li>';
						}

					}
					echo '</ul>';
				}

				echo '</div>';
			}

		} else {
			// horizontal ------------

			echo '<div class="wpml-languages horizontal">';
			echo '<ul>';
			foreach( $languages as $lang ){
					
				if( $lang['active'] ){
					$lang_class = 'lang-active';
				} else {
					$lang_class = false;
				}
					
				if( $wmpl_flags == 'horizontal-code' ){
					echo '<li class="'. $lang_class .'"><a href="'. $lang['url'] .'">'. strtoupper( $lang['language_code'] ) .'</a></li>';
				} else {
					echo '<li class="'. $lang_class .'"><a href="'. $lang['url'] .'"><img src="'. $lang['country_flag_url'] .'" alt="'. $lang['translated_name'] .'" width="18" height="12"/></a></li>';
				}

			}
			echo '</ul>';
			echo '</div>';

		}
			
	}

}