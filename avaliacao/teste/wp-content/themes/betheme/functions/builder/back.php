<?php
/**
 * Custom meta fields | Backend
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */


/*
 * Enqueue Styles & Scripts
 */

if( ! function_exists( 'mfn_builder_styles' ) )
{
	/**
	 * Styles
	 */
	function mfn_builder_styles() {
		wp_enqueue_style( 'mfn-builder', LIBS_URI. '/builder/css/style.css', false, time(), 'all');
	}
}
add_action('admin_print_styles', 'mfn_builder_styles');

if( ! function_exists( 'mfn_builder_scripts' ) )
{
	/**
	 * Scripts
	 */
	function mfn_builder_scripts() {
		wp_enqueue_script( 'mfn-builder', LIBS_URI. '/builder/js/scripts.js', false, time(), true );
	}
}
add_action('admin_print_scripts', 'mfn_builder_scripts');



/*
 * Print functions
 *
 * Print fields, items, wraps, sections
 */

if( ! function_exists( 'mfn_meta_field_input' ) )
{
	/**
	 * PRINT single FIELD
	 * 
	 * @global $MFN_Options
	 * @param array $field
	 * @param array $meta
	 */
	function mfn_meta_field_input( $field, $meta, $type = 'meta' ){
		global $MFN_Options;
	
		if( isset( $field['type'] ) ){		
			
			// Table Row class
			if( isset( $field['class'] ) ){
				$class = $field['class'];
			} else {
				$class = '';
			}
				
			echo '<tr class="'. $class .'">';
			
				// LABEL title, sub_desc
				echo '<th>';
					if( key_exists('title', $field) ) echo $field['title'];
					if( key_exists('sub_desc', $field) ) echo '<span class="description">'. $field['sub_desc'] .'</span>';
				echo '</th>';
				
				// OPTIONS field render
				echo '<td>';
					$field_class = 'MFN_Options_'.$field['type'];
					require_once( $MFN_Options->dir.'fields/'.$field['type'].'/field_'.$field['type'].'.php' );
					
					if( class_exists( $field_class ) ){
						$field_object = new $field_class( $field, $meta );
						$field_object->render( $type );
					}
					
				echo '</td>';
				
			echo '</tr>';
			
		}	
	}
}


if( ! function_exists( 'mfn_builder_section' ) )
{
	/**
	 * PRINT single SECTION
	 * 
	 * @param string $section
	 * @param string $section_id
	 */
	function mfn_builder_section( $section = false, $section_id = false, &$wrap_id = false ) {
		
		// Hide
		if( $section && key_exists('attr', $section) && key_exists('hide', $section['attr']) && $section['attr']['hide'] ){
			
			$hide = 'hide';
			$icon = 'hidden';
			
		} else {
			
			$hide = false;
			$icon = 'visibility';
			
		}
				
		// Input Names - only for existing sections, not for section to clone -----------
		$n_row_id = $section ? 'mfn-row-id[]' : '';

		
		echo '<div class="mfn-element mfn-row '. $hide .'" data-title="'. __('Section','mfn-opts') .'">';
	
			// Section | Content
			echo '<div class="mfn-element-content">';
				echo '<input type="hidden" class="mfn-row-id" name="'. $n_row_id .'" value="'. $section_id .'" />';
	
				// Section | Content > Header
				echo '<div class="mfn-element-header mfn-row-header">';
				
					echo '<div class="mfn-element-btns">';
						echo '<a class="mfn-element-btn mfn-add-wrap" href="javascript:void(0);">'. __('Add Wrap','mfn-opts') .'</a>';
						echo '<a class="mfn-element-btn mfn-add-divider" href="javascript:void(0);">'. __('Add Divider','mfn-opts') .'</a>';
					echo '</div>';
				
					$section_label 	= ( $section && key_exists('attr', $section) && key_exists('title', $section['attr']) ) ? $section['attr']['title'] : ''; // section label - visible only in backend
					echo '<span class="mfn-item-label">'. $section_label .'</span>';
					
					echo '<div class="mfn-element-tools">';			
						echo '<a class="mfn-element-btn mfn-element-edit dashicons dashicons-edit" title="'. __('Edit','mfn-opts') .'" href="javascript:void(0);"></a>';
						echo '<a class="mfn-element-btn mfn-element-clone mfn-row-clone dashicons dashicons-share-alt2" title="'. __('Clone','mfn-opts') .'" href="javascript:void(0);"></a>';
						echo '<a class="mfn-element-btn mfn-element-hide dashicons dashicons-'. $icon .'" title="'. __('Hide','mfn-opts') .'" href="javascript:void(0);"></a>';
						echo '<a class="mfn-element-btn mfn-element-delete dashicons dashicons-no" title="'. __('Delete','mfn-opts') .'" href="javascript:void(0);"></a>';
					echo '</div>';
					
				echo '</div>';
				
				// Section | Content > Sortable
				echo '<div class="mfn-sortable mfn-sortable-row clearfix">';
	
					// Sections | Existing Wraps

					if( $section ){
						
						
						// FIX | Muffin Builder 2.0 Compatibility						
						if( ! key_exists( 'wraps', $section ) && is_array( $section['items'] ) ){
							
							$fix_wrap = array(
								'size'	=> '1/1',
								'items'	=> $section['items'],
							);
							
							$section['wraps'] = array( $fix_wrap );
							
						}
						
						
						if( key_exists( 'wraps', $section ) && is_array( $section['wraps'] ) ){
							
							foreach( $section['wraps'] as $wrap ){
								mfn_builder_wrap( $wrap, $wrap_id, $section_id );
								$wrap_id++;
							}
							
						}
						
						
					}

				echo '</div>';
	
			echo '</div>';
			
			// Section | Meta
			echo '<div class="mfn-element-meta">';
			
				echo '<table class="form-table">';
					echo '<tbody>';
						
						// Section | Meta > Fields
						$section_fields = mfn_get_fields_section();
						
						foreach( $section_fields as $field ){

							// Values - only for Existing sections
							if( $section && key_exists( $field['id'], $section['attr'] ) ){
								$meta = $section['attr'][$field['id']];
							} else {
								$meta = false;
							}
						
							if( ! key_exists('std', $field) ) $field['std'] = false;
							$meta = ( $meta || $meta === '0' ) ? $meta : stripslashes( htmlspecialchars( $field['std'], ENT_QUOTES ));
						
							// field ID
							$field['id'] = 'mfn-rows['. $field['id'] .']';
						
							// field ID except accordion, faq & tabs
							if( $field['type'] != 'tabs' ){
								$field['id'] .= '[]';
							}
						
							// PRINT Single Muffin Options FIELD
							if( $section ){
								$input_type = 'existing';
							} else {
								$input_type = 'new';
							}
							mfn_meta_field_input( $field, $meta, $input_type );

						}
						
					echo '</tbody>';
				echo '</table>';
				
			echo '</div>';
			
		echo '</div>';
	
	}
}


if( ! function_exists( 'mfn_builder_wrap' ) )
{
	/**
	 * PRINT single WRAP
	 *
	 * @param array $item_std
	 * @param string $wrap
	 * @param string $wrap_id
	 */
	function mfn_builder_wrap( $wrap = false, $wrap_id = false, $parent_id = false ) {

		
		// input names - only for existing wraps, not for wraps to clone -----------
		$n_wrap_id 		= $wrap ? 'mfn-wrap-id[]' : '';
		$n_wrap_parent 	= $wrap ? 'mfn-wrap-parent[]' : '';
		$n_wrap_size 	= $wrap ? 'mfn-wrap-size[]' : '';
		
		$sizes 			= array( '1/6' => 0.1666, '1/5' => 0.2, '1/4' => 0.25, '1/3' => 0.3333, '2/5' => 0.4, '1/2' => 0.5,
								'3/5' => 0.6, '2/3' => 0.6667, '3/4' => 0.75, '4/5' => 0.8, '5/6' => 0.8333, '1/1' => 1, 'divider' => 1 );
		$size 			= $wrap ? $wrap['size'] : '1/1';

		$class = '';
		if( $wrap && ( $wrap['size'] == 'divider' ) ){
			$class .= ' divider';
		}

		echo '<div class="mfn-element mfn-wrap '. $class .'" data-size="'. $sizes[$size] .'" data-title="'. __('Wrap','mfn-opts') .'">';

		
			// Wrap | Content
			echo '<div class="mfn-element-content">';
	
				echo '<input type="hidden" class="mfn-wrap-id" name="'. $n_wrap_id .'" value="'. $wrap_id .'" />';
				echo '<input type="hidden" class="mfn-wrap-parent" name="'. $n_wrap_parent .'" value="'. $parent_id .'" />';
				echo '<input type="hidden" class="mfn-wrap-size" name="'. $n_wrap_size .'" value="'. $size .'" />';
		
				// Wrap | Content > Header
				echo '<div class="mfn-element-header mfn-wrap-header">';
		
					echo '<div class="mfn-item-size">';
						echo '<a class="mfn-element-btn mfn-item-size-dec" href="javascript:void(0);">-</a>';
						echo '<a class="mfn-element-btn mfn-item-size-inc" href="javascript:void(0);">+</a>';	
						echo '<a class="mfn-element-btn mfn-add-item" href="javascript:void(0);">Add Item</a>';
						echo '<span class="mfn-element-btn mfn-item-desc">'. $size .'</span>';
					echo '</div>';
						
					echo '<div class="mfn-element-tools">';
						echo '<a class="mfn-element-btn mfn-element-edit mfn-wrap-edit dashicons dashicons-edit" title="'. __('Edit','mfn-opts') .'" href="javascript:void(0);"></a>';
						echo '<a class="mfn-element-btn mfn-element-clone mfn-wrap-clone dashicons dashicons-share-alt2" title="'. __('Clone','mfn-opts') .'" href="javascript:void(0);"></a>';
						echo '<a class="mfn-element-btn mfn-element-delete dashicons dashicons-no" title="'. __('Delete','mfn-opts') .'" href="javascript:void(0);"></a>';
					echo '</div>';
						
					echo '</div>';
			
					// Wrap | Content > Sortable
					echo '<div class="mfn-sortable mfn-sortable-wrap clearfix">';
			
					if( $wrap && key_exists('items', $wrap) && is_array($wrap['items']) ){
						foreach( $wrap['items'] as $item ){
							mfn_builder_item( $item['type'], $item, $wrap_id );
						}
					}
		
				echo '</div>';
	
			echo '</div>';
			
			
			// Wrap | Meta
			echo '<div class="mfn-element-meta">';
				
				echo '<table class="form-table">';
					echo '<tbody>';
					
					// Wrap | Meta > Fields
					$wrap_fields = mfn_get_fields_wrap();
					
					foreach( $wrap_fields as $field ){
					
						// Values - only for Existing wraps
						if( $wrap && key_exists( 'attr', $wrap ) && key_exists( $field['id'], $wrap['attr'] ) ){
							$meta = $wrap['attr'][$field['id']];
						} else {
							$meta = false;
						}
					
						if( ! key_exists('std', $field) ) $field['std'] = false;
						$meta = ( $meta || $meta === '0' ) ? $meta : stripslashes( htmlspecialchars( $field['std'], ENT_QUOTES ));
					
						// field ID
						$field['id'] = 'mfn-wraps['. $field['id'] .']';
					
						// field ID except accordion, faq & tabs
						if( $field['type'] != 'tabs' ){
							$field['id'] .= '[]';
						}
					
						// PRINT Single Muffin Options FIELD
						if( $wrap ){
							$input_type = 'existing';
						} else {
							$input_type = 'new';
						}
						mfn_meta_field_input( $field, $meta, $input_type );
					
					}
					
					echo '</tbody>';
				echo '</table>';
			
			echo '</div>';
			
			
		echo '</div>';

	}
}


if( ! function_exists( 'mfn_builder_item' ) )
{
	/**
	 * PRINT single ITEM
	 *
	 * @param array $item_std
	 * @param string $item
	 * @param string $section_id
	 */
	function mfn_builder_item( $item_type, $item = false, $parent_id = false ) {

		$item_std 			= mfn_get_fields_item( $item_type );
		
		
		// input names - only for existing items, not for items to clone -----------
		$n_item_type 		= $item ? 'mfn-item-type[]' 	: '';
		$n_item_size 		= $item ? 'mfn-item-size[]' 	: '';
		$n_item_parent		= $item ? 'mfn-item-parent[]' 	: '';
			
		$sizes 				= array( '1/6' => 0.1666, '1/5' => 0.2, '1/4' => 0.25, '1/3' => 0.3333, '2/5' => 0.4, '1/2' => 0.5, 
									'3/5' => 0.6, '2/3' => 0.6667, '3/4' => 0.75, '4/5' => 0.8, '5/6' => 0.8333, '1/1' => 1 );
		$item_std['size'] 	= $item['size'] ? $item['size'] : $item_std['size'];
		

		echo '<div class="mfn-element mfn-item mfn-item-'. $item_std['type'] .'" data-size="'. $sizes[$item_std['size']] .'" data-title="'. $item_std['title'] .'">';

			echo '<div class="mfn-element-content">';
			
				echo '<input type="hidden" class="mfn-item-type" name="'. $n_item_type .'" value="'. $item_std['type'] .'">';
				echo '<input type="hidden" class="mfn-item-size" name="'. $n_item_size .'" value="'. $item_std['size'] .'">';
				echo '<input type="hidden" class="mfn-item-parent" name="'. $n_item_parent .'" value="'. $parent_id .'" />';
		
				echo '<div class="mfn-element-header">';
		
					echo '<div class="mfn-item-size">';
					
						echo '<a class="mfn-element-btn mfn-item-size-dec" href="javascript:void(0);">-</a>';
						echo '<a class="mfn-element-btn mfn-item-size-inc" href="javascript:void(0);">+</a>';
						echo '<span class="mfn-element-btn mfn-item-desc">'. $item_std['size'] .'</span>';
						
					echo '</div>';
						
					echo '<div class="mfn-element-tools">';
					
						echo '<a class="mfn-element-btn mfn-fr mfn-element-edit dashicons dashicons-edit" title="'. __('Edit','mfn-opts') .'" href="javascript:void(0);"></a>';
						echo '<a class="mfn-element-btn mfn-fr mfn-element-clone mfn-item-clone dashicons dashicons-share-alt2" title="'. __('Clone','mfn-opts') .'" href="javascript:void(0);"></a>';
						echo '<a class="mfn-element-btn mfn-fr mfn-element-delete dashicons dashicons-no" title="'. __('Delete','mfn-opts') .'" href="javascript:void(0);"></a>';
						
					echo '</div>';
					
				echo '</div>';
		
				echo '<div class="mfn-item-content">';
					echo '<div class="mfn-item-inside">';
					
						echo '<div class="mfn-item-icon"></div>';
							
						echo '<div class="mfn-item-inside-desc">';
							
							echo '<span class="mfn-item-title">'. $item_std['title'] .'</span>';
							
							$item_label = ( $item && key_exists( 'fields', $item ) && key_exists( 'title', $item['fields'] ) ) ? $item['fields']['title'] : '';
							echo '<span class="mfn-item-label">'. $item_label .'</span>';

						echo '</div>';
					
					echo '</div>';
					
					if( $item && key_exists( 'fields', $item ) && key_exists( 'content', $item['fields'] ) ){
						
						$item_excerpt = strip_shortcodes( strip_tags( $item['fields']['content'] ) );
						
						$item_excerpt = preg_split( '/\b/', $item_excerpt, 16 * 2 + 1 );
						$item_excerpt_waste = array_pop( $item_excerpt );
						$item_excerpt = implode( $item_excerpt );
							
						echo '<p class="mfn-item-excerpt">'. esc_html( $item_excerpt ) .'</p>';
					}
					
				echo '</div>';
		
			echo '</div>';
					
			echo '<div class="mfn-element-meta">';
				
				echo '<table class="form-table">';
					echo '<tbody>';
			
						// Fields for Item
						foreach( $item_std['fields'] as $field ){
				
							
							// values for existing items
							if( $item && key_exists( 'fields', $item ) && key_exists( $field['id'], $item['fields'] ) ){
								
								$meta = $item['fields'][$field['id']];
								
							} else {
								
								if( ! key_exists('std', $field) ) $field['std'] = false;
								$meta = stripslashes( htmlspecialchars( $field['std'], ENT_QUOTES ) );
								
							}


							// field ID
							$field['id'] = 'mfn-items['. $item_std['type'] .']['. $field['id'] .']';
								
							// field ID except accordion, faq & tabs
							if( $field['type'] != 'tabs' ){
								$field['id'] .= '[]';
							}
								
							
							// PRINT Single Muffin Options FIELD
							if( $item ){
								$input_type = 'existing';
							} else {
								$input_type = 'new';
							}
							mfn_meta_field_input( $field, $meta, $input_type );
								
						}
			
					echo '</tbody>';
				echo '</table>';
				
			echo '</div>';

		echo '</div>';
	}
}


/*
 * Muffin Builder
 * 
 * Main backend builder function
 */

if( ! function_exists( 'mfn_builder_show' ) )
{
	/**
	 * PRINT Muffin Builder
	 * 
	 * Main function
	 * 
	 * @global $post
	 */
	function mfn_builder_show() {
		global $post;
		
		
		// Visibility -------------------------------------------------------------------
		
		if( $visibility = mfn_opts_get('builder-visibility') ){
			if( $visibility == 'hide' || ( ! current_user_can( $visibility ) ) ){
				return false;
			}
		}


		// GET | Muffin Items - $mfn_items ----------------------------------------------
		
		$mfn_items = get_post_meta( $post->ID, 'mfn-page-items', true );
		
// 		print_r( $mfn_items );
		
		
		// FIX | Muffin Builder 2.0 Compatibility
				
		if( $mfn_items && ! is_array( $mfn_items ) ){
			$mfn_items = unserialize( call_user_func( 'base'.'64_decode', $mfn_items ) );
		}
		
		
		$mfn_items_serial = call_user_func( 'base'.'64_encode', serialize( $mfn_items ) );

		
		// Debug ------------------------------------------------------------------------
		
// 		print_r( $mfn_items );


		// ID | sections, wraps ------------------------------------------------------	
		
		$section_id = 1;
		$wrap_id 	= 1;

		
		?>
		<div id="mfn-builder">
		
			<input type="hidden" name="mfn-items-save" value="1"/>
			
			<a id="mfn-go-to-top" class="dashicons dashicons-arrow-up-alt" href="javascript:void(0);"></a>

			<div id="mfn-content">
	
	
				<!-- Header | Add Section ___________________________________________ -->		
				<div class="mfn-row-add">
					<table class="form-table">
						<tbody>
							<tr valign="top">
								<td>
									<a class="mfn-row-add-btn" href="javascript:void(0);">
										<span class="dashicons dashicons-align-center"></span>
										<?php _e('Add Section','mfn-opts'); ?>
									</a>
									<div class="logo">Muffin Group | Muffin Builder</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				

				<!-- Builder Desktop ________________________________________________ -->
				<div id="mfn-desk" class="clearfix">	
					<?php
						if( is_array( $mfn_items ) ){
							foreach( $mfn_items as $section ){
								mfn_builder_section( $section, $section_id, $wrap_id );
								$section_id++;
							}
						}
					?>				
				</div>
				
				
				<!-- New | Section __________________________________________________ -->
				<div id="mfn-rows" class="clearfix">
					<?php mfn_builder_section(); ?>
				</div>
				
				
				<!-- New | Wrap _____________________________________________________ -->
				<div id="mfn-wraps" class="clearfix">
					<?php mfn_builder_wrap(); ?>
				</div>
							
				
				<!-- New | Items ____________________________________________________ -->
				<div id="mfn-items" class="clearfix">
					<?php
						$items = mfn_get_fields_item();
						foreach( $items as $item ){
							mfn_builder_item( $item['type'] );
							echo "\n";
						}
					?>				
				</div>
				
				
				<!-- Popup | Add Item ______________________________________________ -->		
				<div id="mfn-item-add" class="mfn-popup mfn-popup-item-add">
					<div class="mfn-popup-inside">
			
						<div class="mfn-popup-header">
	
							<div class="mfn-ph-left">
								<span class="mfn-ph-btn mfn-ph-desc"><?php _e( 'Add Item', 'mfn-opts' ); ?></span>						
							</div>
							
							<div class="mfn-ph-right">			
								<a class="mfn-ph-btn mfn-ph-close dashicons dashicons-no" title="<?php _e( 'Close', 'mfn-opts' ); ?>" href="javascript:void(0);"></a>
							</div>
	
						</div>
						
						<div class="mfn-popup-content">
						
							<div class="mfn-popup-subheader">
							
								<ul class="mfn-popup-tabs">
									<li data-filter="*" class="active"><a href="javascript:void(0);"><?php _e( 'All', 'mfn-opts' ); ?></a></li>
									<li data-filter="typography"><a href="javascript:void(0);"><?php _e( 'Typography', 'mfn-opts' ); ?></a></li>
									<li data-filter="boxes"><a href="javascript:void(0);"><?php _e( 'Boxes & Infographics', 'mfn-opts' ); ?></a></li>
									<li data-filter="blocks"><a href="javascript:void(0);"><?php _e( 'Content Blocks', 'mfn-opts' ); ?></a></li>
									<li data-filter="elements"><a href="javascript:void(0);"><?php _e( 'Content Elements', 'mfn-opts' ); ?></a></li>
									<li data-filter="loops"><a href="javascript:void(0);"><?php _e( 'Loops', 'mfn-opts' ); ?></a></li>
									<li data-filter="other"><a href="javascript:void(0);"><?php _e( 'Other', 'mfn-opts' ); ?></a></li>
								</ul>
								
								<div class="mfn-popup-search">
									<span class="dashicons dashicons-search"></span>
									<input class="mfn-search-item" placeholder="<?php _e( 'Search Item', 'mfn-opts' ); ?>" />
								</div>
							
							</div>
						
							<ul class="mfn-popup-items clear">
								<?php 
									$items = mfn_get_fields_item();
									foreach( $items as $item ){
										
										$category = isset( $item['cat'] ) ? 'category-'. $item['cat'] : '' ;
										
										echo '<li class="mfn-item-'. $item['type'] .' '. $category .'" data-type="'. $item['type'] .'">';
											echo '<a data-type="'. $item['type'] .'" href="javascript:void(0);">';
												echo '<span class="title">'. $item['title'] .'</span>';
												echo '<div class="mfn-item-icon"></div>';
											echo '</a>';
										echo '</li>';
									}	
								?>
							</ul>
							
						</div>
						
					</div>
				</div>	
				
				
				<!-- Migrate _______________________________________________________ -->
				<div id="mfn-migrate">

					<div class="btn-wrapper">
						<a href="javascript:void(0);" class="mfn-btn-migrate btn-exp"><?php _e('Export','mfn-opts'); ?></a>
						<a href="javascript:void(0);" class="mfn-btn-migrate btn-imp"><?php _e('Import','mfn-opts'); ?></a>
						<a href="javascript:void(0);" class="mfn-btn-migrate btn-tem btn-primary"><?php _e('Templates','mfn-opts'); ?></a>
					</div>
					<div class="migrate-wrapper export-wrapper hide">
						<textarea id="mfn-items-export" placeholder="Please remember to Publish/Update your post before Export."><?php echo $mfn_items_serial; ?></textarea>
						<span class="description"><?php _e('Copy to clipboard: Ctrl+C (Cmd+C for Mac)','mfn-opts'); ?></span>
					</div>
					
					<div class="migrate-wrapper import-wrapper hide">
						<textarea id="mfn-items-import" placeholder="Paste import data here."></textarea>
						<a href="javascript:void(0);" class="mfn-btn-migrate btn-primary btn-import"><?php _e('Import','mfn-opts'); ?></a>	
						<select name="mfn-items-import-type">
							<option value="before"><?php _e('Insert BEFORE current builder content','mfn-opts'); ?></option>
							<option value="after"><?php _e('Insert AFTER current builder content','mfn-opts'); ?></option>
							<option value="replace"><?php _e('REPLACE current builder content','mfn-opts'); ?></option>
						</select>			
					</div>
					
					<div class="migrate-wrapper templates-wrapper hide">
						<a href="javascript:void(0);" class="mfn-btn-migrate btn-primary btn-template"><?php _e('Use Template','mfn-opts'); ?></a>	
						<select name="mfn-items-import-template-type">						
							<option value="before"><?php _e('Insert BEFORE current builder content','mfn-opts'); ?></option>
							<option value="after"><?php _e('Insert AFTER current builder content','mfn-opts'); ?></option>
							<option value="replace"><?php _e('REPLACE current builder content','mfn-opts'); ?></option>
						</select>
						<select id="mfn-items-import-template">
							<option value=""><?php _e('-- Select --','mfn-opts'); ?></option>
							<?php 
								$args = array(
									'post_type' => 'template',
									'posts_per_page'=> -1,
								);
								$templates = get_posts( $args );
									
								if( is_array( $templates ) ){
									foreach ( $templates as $v ){
										echo '<option value="'. $v->ID .'">'. $v->post_title .'</options>';
									}
								}
							?>
						</select>					
					</div>
					
				</div>
				
		
			</div>
			
			
			<!-- #mfn-items-seo -->
			<div id="mfn-items-seo">
				<?php 
					$mfn_items_seo = get_post_meta($post->ID, 'mfn-page-items-seo', true);
					echo '<textarea id="mfn-items-seo-data">'. esc_attr( $mfn_items_seo ) .'</textarea>'; 
				?>
			</div>
				
			
			<input type="hidden" id="mfn-row-id" value="<?php echo $section_id; ?>"/>
			<input type="hidden" id="mfn-wrap-id" value="<?php echo $wrap_id; ?>"/>

		</div>
		<?php 
	
	}
}


if( ! function_exists( 'mfn_builder_save' ) )
{
	/**
	 * SAVE Muffin Builder
	 * 
	 * @param int $post_id
	 */
	function mfn_builder_save( $post_id ){

		
// 		print_r($_POST);
// 		exit;
		
		
		// Fix | Visual Composer Frontend
		
		if( isset( $_POST['vc_inline'] ) ){
			return false;
		}
		
		
		$mfn_items = array();
		$mfn_wraps = array();

		
		// Sections ---------------------------------------------------------------------
		
		if( key_exists( 'mfn-row-id', $_POST ) && is_array( $_POST['mfn-row-id']) )
		{
			foreach( $_POST['mfn-row-id'] as $sectionID_k => $sectionID )
			{
				$section = array();
					
				// $section['attr'] - section attributes
				if( key_exists('mfn-rows', $_POST) && is_array($_POST['mfn-rows'])){
					foreach ( $_POST['mfn-rows'] as $section_attr_k => $section_attr ){
						
// 						$section['attr'][$section_attr_k] = $section_attr[$sectionID_k];	// before 16.6. TO REMOVE
						
						$section['attr'][$section_attr_k] = stripslashes( $section_attr[$sectionID_k] );

					}
				}
				
				$section['wraps'] = '';	// $section['wraps'] - section wraps will be added in next loop
		
				$mfn_items[] = $section;
			}
		
			$row_IDs 		= $_POST['mfn-row-id'];
			$row_IDs_key 	= array_flip( $row_IDs );
		}
		

		// Wraps ------------------------------------------------------------------------
		
		if( key_exists( 'mfn-wrap-id', $_POST ) && is_array( $_POST['mfn-wrap-id'] ) )
		{
			foreach( $_POST['mfn-wrap-id'] as $wrapID_k => $wrapID )
			{
				$wrap = array();
				
				$wrap['size'] 	= $_POST['mfn-wrap-size'][$wrapID_k];
				$wrap['items'] 	= '';	// $wrap['items'] - items will be added in the next loop
				
				// $wrap['attr'] - wrap attributes
				if( key_exists('mfn-wraps', $_POST) && is_array($_POST['mfn-wraps'])){
					foreach ( $_POST['mfn-wraps'] as $wrap_attr_k => $wrap_attr ){
						$wrap['attr'][$wrap_attr_k] = $wrap_attr[$wrapID_k];
					}
				}
					
				$mfn_wraps[$wrapID] = $wrap;
			}
		
			$wrap_IDs = $_POST['mfn-wrap-id'];
			$wrap_IDs_key = array_flip( $wrap_IDs );
			$wrap_parents = $_POST['mfn-wrap-parent'];
		}
		
		
		// Items ------------------------------------------------------------------------
		
		if( key_exists('mfn-item-type', $_POST) && is_array($_POST['mfn-item-type']))
		{
			$count = array();
			$tabs_count = array();
		
			$seo_content = '';
				
			foreach( $_POST['mfn-item-type'] as $type_k => $type )
			{
				$item = array();
				$item['type'] = $type;
				$item['size'] = $_POST['mfn-item-size'][$type_k];
					
				// init count for specified item type
				if( ! key_exists($type, $count) ){
					$count[$type] = 0;
				}
		
				// init count for specified tab type
				if( ! key_exists($type, $tabs_count) ){
					$tabs_count[$type] = 0;
				}
		
				if( key_exists($type, $_POST['mfn-items']) ){
					foreach( (array) $_POST['mfn-items'][$type] as $attr_k => $attr ){
		
						if( $attr_k == 'tabs' ){
							
							// Accordion, FAQ & Tabs --------------------------
							
							$item['fields']['count'] = $attr['count'][$count[$type]];
							
							if( $item['fields']['count'] ){
								for ($i = 0; $i < $item['fields']['count']; $i++) {
									
									$tab = array();
									$tab['title'] 	= stripslashes( $attr['title'][$tabs_count[$type]] );
									
									if( mfn_opts_get( 'builder-storage' ) ){
										
										$tab['content'] = stripslashes( $attr['content'][$tabs_count[$type]] );
										
									} else {
										
										// core.trac.wordpress.org/ticket/34845
										$tab['content'] = preg_replace( '~\R~u', "\n", stripslashes( $attr['content'][$tabs_count[$type]] ) );
										
									}

									$item['fields']['tabs'][] = $tab;								
									
									
									// FIX | Yoast SEO
									$seo_val = trim( $attr['title'][$tabs_count[$type]] );
									if( $seo_val && $seo_val != 1 ) $seo_content .= $attr['title'][$tabs_count[$type]] .": ";
									$seo_val = trim( $attr['content'][$tabs_count[$type]] );
									if( $seo_val && $seo_val != 1 ) $seo_content .= $attr['content'][$tabs_count[$type]] ."\n\n";
									
									
									$tabs_count[$type]++;
								}
							}
							
						} else {
							
							// All other items --------------------------------

							if( mfn_opts_get( 'builder-storage' ) ){
								
								$item['fields'][$attr_k] = stripslashes( $attr[$count[$type]] );
								
							} else {
								
								// core.trac.wordpress.org/ticket/34845
								$item['fields'][$attr_k] = preg_replace( '~\R~u', "\n", stripslashes( $attr[$count[$type]] ) );
								
							}

							
							// FIX | Yoast SEO
							$seo_val = trim( $attr[$count[$type]] );
							if( $seo_val && $seo_val != 1 ){
								
								if( in_array( $attr_k, array( 'image', 'src' ) ) ){
									
									// Image
									$seo_content .= '<img src="'. $seo_val .'" alt="'. mfn_get_attachment_data( $seo_val, 'alt' ) .'"/>'."\n\n";	
											
								} elseif( $attr_k == 'link' ){
									
									// Link
									$seo_content .= '<a href="'. $seo_val .'">'. $seo_val .'</a>'."\n\n";
									
								} else {
									
									$seo_content .= $seo_val ."\n\n";
									
								}
							}
							
							
						}
		
					}
				}
					
				// increase count for specified item type
				$count[$type] ++;
					
				// parent wrap
				$parent_wrap_ID = $_POST['mfn-item-parent'][$type_k];
				
				if( ! isset( $mfn_wraps[ $parent_wrap_ID ]['items'] ) || ! is_array( $mfn_wraps[ $parent_wrap_ID ]['items'] ) ){
					$mfn_wraps[ $parent_wrap_ID ]['items'] = array();
				}
				$mfn_wraps[ $parent_wrap_ID ]['items'][] = $item;
			}
		}
		
		
		// $mfn_items | Wraps with Items => Sections ------------------------------------
		
		foreach( $mfn_wraps as $wrap_ID => $wrap ){
			$wrap_key 		= $wrap_IDs_key[ $wrap_ID ];
			$section_ID 	= $wrap_parents[ $wrap_key ];
			$section_key 	= $row_IDs_key[ $section_ID ];
		
			if( ! isset( $mfn_items[ $section_key ]['wraps']) || ! is_array( $mfn_items[ $section_key ]['wraps'] ) ){
				$mfn_items[ $section_key ]['wraps'] = array();
			}
			$mfn_items[ $section_key ]['wraps'][] = $wrap;
		}

		
		// $new = wp_slash( $mfn_items ) -----------------------------------------------
		
		if( $mfn_items ){
			
			if( mfn_opts_get( 'builder-storage' ) == 'encode' ){
				
				$new = call_user_func( 'base'.'64_encode', serialize( $mfn_items ) );
				
			} else {
				
				// codex.wordpress.org/Function_Reference/update_post_meta
				$new = wp_slash( $mfn_items );
				
			}
			
		}
		
		
		// migrate --------------------------------------------
		if( key_exists('mfn-items-import', $_POST) || key_exists('mfn-items-import-template', $_POST)  ){
		
			if( key_exists('mfn-items-import', $_POST) ){
				
				// Import -----------------------
		
				$import_type 	= htmlspecialchars(stripslashes( $_POST['mfn-items-import-type'] ));
				
				$import 		= htmlspecialchars(stripslashes( $_POST['mfn-items-import'] ));		
		
			} else {
				
				// Template ---------------------
		
				$import_type 	= htmlspecialchars(stripslashes( $_POST['mfn-items-import-template-type'] ));
				$template 		= htmlspecialchars(stripslashes( $_POST['mfn-items-import-template'] ));
				
				$import			= get_post_meta( $template, 'mfn-page-items', true );
				
			}
		
			if( $import ){
				
				if( $import_type == 'replace' ){
					
					// REPLACE current builder content
						
					$new = $import;
						
				} else {
					
					// Insert BEFORE/AFTER current builder content

					// FIX | Muffin Builder 2.0 Compatibility
					
					if( $import && ! is_array( $import ) ){
						$import = unserialize( call_user_func( 'base'.'64_decode', $import ) );
					}
	
					if( $import_type == 'before' ){
						$mfn_items = array_merge ( $import, $mfn_items );
					} else {
						$mfn_items = array_merge ( $mfn_items, $import );
					}
						
					$new = call_user_func( 'base'.'64_encode', serialize( $mfn_items ) );
						
				}
			}
		}
	
		
		// FIX | Quick Edit -----------------------------------
		if( key_exists('mfn-items-save', $_POST) )
		{	
			$field['id'] 	= 'mfn-page-items';
			$old 			= get_post_meta( $post_id, $field['id'], true );
	
			
			if( isset($new) && $new != $old ) {
	
				// update post meta if there is at least one builder section
				update_post_meta( $post_id, $field['id'], $new );
	
			} elseif( $old && ( ! isset($new) || ! $new ) ) {
	
				// delete post meta if builder is empty
				delete_post_meta( $post_id, $field['id'], $old );
				
			}
			
			// "Yoast SEO" fix
			if( isset($new) ){
				update_post_meta( $post_id, 'mfn-page-items-seo', $seo_content );
			}
			
		}
		
	
	}
}


/* --------------------------------------------------------------------------------------------------------------------------------------------------
 * 
 * Helper functions
 * 
 * Get data for some meta fields
 * 
 */

if( ! function_exists( 'mfn_get_animations' ) )
{
	/**
	 * GET Animations | Entrance animations for items
	 *
	 * @return array
	 */
	function mfn_get_animations() {

		$array = array(
			'' 					=> __('- Not Animated -','mfn-opts'),
			'fadeIn' 			=> __('Fade In','mfn-opts'),
			'fadeInUp' 			=> __('Fade In Up','mfn-opts'),
			'fadeInDown' 		=> __('Fade In Down ','mfn-opts'),
			'fadeInLeft' 		=> __('Fade In Left','mfn-opts'),
			'fadeInRight' 		=> __('Fade In Right ','mfn-opts'),
			'fadeInUpLarge' 	=> __('Fade In Up Large','mfn-opts'),
			'fadeInDownLarge' 	=> __('Fade In Down Large','mfn-opts'),
			'fadeInLeftLarge' 	=> __('Fade In Left Large','mfn-opts'),
			'fadeInRightLarge' 	=> __('Fade In Right Large','mfn-opts'),
			'zoomIn' 			=> __('Zoom In','mfn-opts'),
			'zoomInUp' 			=> __('Zoom In Up','mfn-opts'),
			'zoomInDown' 		=> __('Zoom In Down','mfn-opts'),
			'zoomInLeft' 		=> __('Zoom In Left','mfn-opts'),
			'zoomInRight' 		=> __('Zoom In Right','mfn-opts'),
			'zoomInUpLarge' 	=> __('Zoom In Up Large','mfn-opts'),
			'zoomInDownLarge' 	=> __('Zoom In Down Large','mfn-opts'),
			'zoomInLeftLarge' 	=> __('Zoom In Left Large','mfn-opts'),
			'bounceIn' 			=> __('Bounce In','mfn-opts'),
			'bounceInUp' 		=> __('Bounce In Up','mfn-opts'),
			'bounceInDown' 		=> __('Bounce In Down','mfn-opts'),
			'bounceInLeft' 		=> __('Bounce In Left','mfn-opts'),
			'bounceInRight' 	=> __('Bounce In Right','mfn-opts'),
		);
			
		return $array;
	}
}


if( ! function_exists( 'mfn_get_categories' ) )
{
	/**
	 * GET Categories | Categories for posts or specified taxonomy
	 *
	 * @param string $category Category slug
	 * @return array
	 */
	function mfn_get_categories( $category ) {
		$categories = get_categories( array( 'taxonomy' => $category ));

		$array = array( '' => __( 'All', 'mfn-opts' ) );
		foreach( $categories as $cat ){
			if( is_object($cat) ) $array[$cat->slug] = $cat->name;
		}
			
		return $array;
	}
}


if( ! function_exists( 'mfn_get_sliders' ) )
{
	/**
	 * GET Sliders | Revolution Slider
	 *
	 * @global $wpdb
	 * @return array
	 */
	function mfn_get_sliders() {
		global $wpdb;
	
		$sliders = array( 0 => __('-- Select --', 'mfn-opts') );
	
		// Revolution Slider ----------------------------------
		if( function_exists( 'rev_slider_shortcode' ) ){
			
			
			// table prefix -----
			$table_prefix = mfn_opts_get( 'table_prefix', 'base_prefix' );
			if( $table_prefix == 'base_prefix' ){
				$table_prefix = $wpdb->base_prefix;
			} else {
				$table_prefix = $wpdb->prefix;
			}
			
			$table_name = $table_prefix . "revslider_sliders";
			
			
			$rs5 = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'type'");
			if( $rs5 ){			
				// Revolution Slider 5.x
				$array = $wpdb->get_results("SELECT * FROM $table_name WHERE type != 'template' ORDER BY title ASC");
			} else {			
				// Revolution Slider 4.x
				$array = $wpdb->get_results("SELECT * FROM $table_name ORDER BY title ASC");
			}
			
			
			if( is_array( $array ) ){
				foreach( $array as $v ){
					$sliders[$v->alias] = $v->title;
				}
			}
			
		}
		
		return $sliders;
	}
}


if( ! function_exists( 'mfn_get_sliders_layer' ) )
{
	/**
	 * GET Sliders | Layer Slider
	 *
	 * @global $wpdb
	 * @return array
	 */
	function mfn_get_sliders_layer(){
		global $wpdb;
	
		$sliders = array( 0 => __('-- Select --', 'mfn-opts') );
	
		// Layer Slider ----------------------------------
		if( function_exists( 'layerslider' ) ){
			
			
			// table prefix -----
			$table_prefix = mfn_opts_get( 'table_prefix', 'base_prefix' );
			if( $table_prefix == 'base_prefix' ){
				$table_prefix = $wpdb->base_prefix;
			} else {
				$table_prefix = $wpdb->prefix;
			}
				
			$table_name = $table_prefix . "layerslider";
			
			
			$array = $wpdb->get_results("SELECT * FROM $table_name WHERE flag_hidden = '0' AND flag_deleted = '0' ORDER BY name ASC");
			
			if( is_array( $array ) ){
				foreach( $array as $v ){
					$sliders[$v->id] = $v->name;
				}
			}
		}
		
		return $sliders;
	}
}
