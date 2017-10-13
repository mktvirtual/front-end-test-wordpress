<?php
	$translate['wpml-no'] = mfn_opts_get('translate') ? mfn_opts_get('translate-wpml-no','No translations available for this page') : __('No translations available for this page','betheme');

	$creative_classes = '';
	$creative_options = mfn_opts_get( 'menu-creative-options' );
	
	if( is_array( $creative_options ) ){
		
		if( isset( $creative_options['scroll'] ) ){
			$creative_classes .= ' scroll';
		}
		if( isset( $creative_options['dropdown'] ) ){
			$creative_classes .= ' dropdown';
		}
		
	} 
?>

<div id="Header_creative" class="<?php echo $creative_classes; ?>">	
	<a href="#" class="creative-menu-toggle"><i class="icon-menu-fine"></i></a>

	<?php 
		echo '<div class="creative-social">';
			get_template_part( 'includes/include', 'social' );
		echo '</div>';
	?>
	
	<div class="creative-wrapper">
	
		<!-- .header_placeholder 4sticky  -->
		<div class="header_placeholder"></div>
	
		<div id="Top_bar">
			<div class="one">
		
				<div class="top_bar_left">
				
					<!-- Logo -->
					<?php get_template_part( 'includes/include', 'logo' ); ?>
			
					<div class="menu_wrapper">
						<?php 
							// #menu --------------------------
							mfn_wp_nav_menu(); 
						
							$mb_class = '';
							if( mfn_opts_get('header-menu-mobile-sticky') ) $mb_class .= ' is-sticky';
													
							// responsive menu button ---------
							echo '<a class="responsive-menu-toggle '. $mb_class .'" href="#">';
								if( $menu_text = mfn_opts_get( 'header-menu-text' ) ){
									echo '<span>'. $menu_text .'</span>';
								} else {
									echo '<i class="icon-menu-fine"></i>';
								}  
							echo '</a>';
						?>					
					</div>		
				
					<div class="search_wrapper">
						<!-- #searchform -->
						<?php $translate['search-placeholder'] = mfn_opts_get('translate') ? mfn_opts_get('translate-search-placeholder','Enter your search') : __('Enter your search','betheme'); ?>
						<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<?php if( mfn_opts_get('header-search') == 'shop' ): ?>
								<input type="hidden" name="post_type" value="product" />
							<?php endif;?>
							<i class="icon_search icon-search-fine"></i>
							<a href="#" class="icon_close"><i class="icon-cancel-fine"></i></a>
							<input type="text" class="field" name="s" id="s" placeholder="<?php echo $translate['search-placeholder']; ?>" />			
							<input type="submit" class="submit" value="" style="display:none;" />
						</form>
					</div>

				</div>
			
				<?php get_template_part( 'includes/header', 'top-bar-right' ); ?>
				
				<div class="banner_wrapper">
					<?php mfn_opts_show( 'header-banner' ); ?>
				</div>
					
			</div>
		</div>

		<div id="Action_bar">
			<?php get_template_part( 'includes/include', 'social' ); ?>
		</div>
					
	</div>
	
</div>