<?php
/**
 * Page custom meta fields.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

 
/*-----------------------------------------------------------------------------------*
 * Define Metabox Fields & Add metabox to edit page		 
 * 
 * version 1.1 | Custom Menu 
 * version 1.2 | Layouts
 *-----------------------------------------------------------------------------------*/
if( ! function_exists( 'mfn_page_meta_add' ) )
{
	function mfn_page_meta_add(){
		global $mfn_page_meta_box;
	
		// Custom menu ------------------------------
		$aMenus = array( 0 => '-- Default --' );
		$oMenus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
		
	
		if( is_array($oMenus) ){
	
			foreach( $oMenus as $menu ){
				$aMenus[$menu->term_id] = $menu->name;
	
				$term_trans_id = apply_filters( 'wpml_object_id', $menu->term_id, 'nav_menu', false );
				if( $term_trans_id != $menu->term_id ){
					unset( $aMenus[$menu->term_id] );
				}
			}
		}
		
		// Layouts ----------------------------------
		$layouts = array( 0 => '-- Theme Options --' );
		$args = array(
			'post_type' => 'layout',
			'posts_per_page'=> -1,
		);
		$lay = get_posts( $args );
		
		if( is_array( $lay ) ){
			foreach ( $lay as $v ){
				$layouts[$v->ID] = $v->post_title;
			}
		}
		
		$mfn_page_meta_box = array(
			'id' 		=> 'mfn-meta-page',
			'title' 	=> __('Page Options','mfn-opts'),
			'page' 		=> 'page',
			'context' 	=> 'normal',
			'priority' 	=> 'default',
			'fields'	=> array(
		
				// layout -----	
				array(
					'id' 		=> 'mfn-meta-info-layout',
					'type' 		=> 'info',
					'title' 	=> '',
					'desc' 		=> __('Layout', 'mfn-opts'),
					'class' 	=> 'mfn-info',
				),
					
				array(
					'id'		=> 'mfn-post-hide-content',
					'type'		=> 'switch',
					'title'		=> __('Hide The Content', 'mfn-opts'), 
					'sub_desc'	=> __('Hide the content from the WordPress editor', 'mfn-opts'),
					'desc'		=> __('<strong>Turn it ON if you build content using Content Builder</strong><br />Use the Content item if you want to display the Content from editor within the Content Builder', 'mfn-opts'),
					'options'	=> array('1' => 'On', '0' => 'Off'),
					'std'		=> '0'
				),
	
				array(
					'id' 		=> 'mfn-post-layout',
					'type' 		=> 'radio_img',
					'title' 	=> __('Layout', 'mfn-opts'),
					'desc' 		=> __('<b>Full width</b> sections works only <b>without</b> sidebars', 'mfn-opts'),
					'options' 	=> array(
						'no-sidebar' 	=> array('title' => 'Full width No sidebar', 'img' => MFN_OPTIONS_URI.'img/1col.png'),
						'left-sidebar'	=> array('title' => 'Left Sidebar', 'img' => MFN_OPTIONS_URI.'img/2cl.png'),
						'right-sidebar' => array('title' => 'Right Sidebar', 'img' => MFN_OPTIONS_URI.'img/2cr.png'),
						'both-sidebars' => array('title' => 'Both Sidebars', 'img' => MFN_OPTIONS_URI.'img/2sb.png'),
					),
					'std' 		=> mfn_opts_get( 'sidebar-layout' ),
				),
					
				array(
					'id' 		=> 'mfn-post-sidebar',
					'type' 		=> 'select',
					'title' 	=> __('Sidebar', 'mfn-opts'),
					'desc' 		=> __('Shows only if layout with sidebar is selected', 'mfn-opts'),
					'options' 	=> mfn_opts_get( 'sidebars' ),
				),
				
				array(
					'id' 		=> 'mfn-post-sidebar2',
					'type' 		=> 'select',
					'title' 	=> __('Sidebar 2nd', 'mfn-opts'),
					'desc' 		=> __('Shows only if layout with both sidebars is selected', 'mfn-opts'),
					'options' 	=> mfn_opts_get( 'sidebars' ),
				),		
					
				// media -----
				array(
					'id' 		=> 'mfn-meta-info-media',
					'type' 		=> 'info',
					'title' 	=> '',
					'desc' 		=> __('Media', 'mfn-opts'),
					'class' 	=> 'mfn-info',
				),
		
				array(
					'id' 		=> 'mfn-post-slider',
					'type' 		=> 'select',
					'title' 	=> __('Slider | Revolution Slider', 'mfn-opts'),
					'desc' 		=> __('Select one from the list of available <a target="_blank" href="admin.php?page=revslider">Revolution Sliders</a>', 'mfn-opts'),
					'options' 	=> mfn_get_sliders(),
				),
				
				array(
					'id' 		=> 'mfn-post-slider-layer',
					'type' 		=> 'select',
					'title' 	=> __('Slider | Layer Slider', 'mfn-opts'), 
					'desc' 		=> __('Select one from the list of available <a target="_blank" href="admin.php?page=layerslider">Layer Sliders</a>', 'mfn-opts'),
					'options' 	=> mfn_get_sliders_layer(),
				),
					
				array(
					'id' 		=> 'mfn-post-slider-shortcode',
					'type' 		=> 'text',
					'title' 	=> __('Slider | Shortcode', 'mfn-opts'), 
					'desc' 		=> __('Paste your slider shortcode here if you use slider other than Revolution or Layer', 'mfn-opts'),
				),
					
				array(
					'id'		=> 'mfn-post-subheader-image',
					'type'		=> 'upload',
					'title'		=> __('Subheader | Image', 'mfn-opts'),
				),
	
				// options -----
				array(
					'id' 		=> 'mfn-meta-info-options',
					'type' 		=> 'info',
					'title' 	=> '',
					'desc' 		=> __('Options', 'mfn-opts'),
					'class' 	=> 'mfn-info',
				),
					
				array(
					'id'		=> 'mfn-post-one-page',
					'type'		=> 'switch',
					'title'		=> __('One Page', 'mfn-opts'),
					'options'	=> array( '0' => 'Off', '1' => 'On' ),
					'std'		=> '0'
				),
	
				array(
					'id'		=> 'mfn-post-hide-title',
					'type'		=> 'switch',
					'title'		=> __('Subheader | Hide', 'mfn-opts'),
					'options'	=> array('1' => 'On', '0' => 'Off'),
					'std'		=> '0'
				),
					
				array(
					'id' 		=> 'mfn-post-remove-padding',
					'type' 		=> 'switch',
					'title' 	=> __('Content | Remove Padding', 'mfn-opts'),
					'desc' 		=> __('Remove default Content Padding', 'mfn-opts'),
					'options' 	=> array('1' => 'On','0' => 'Off'),
					'std' 		=> '0'
				),
				
				array(
					'id' 		=> 'mfn-post-custom-layout',
					'type' 		=> 'select',
					'title' 	=> __('Custom | Layout', 'mfn-opts'),
					'desc' 		=> __('Custom Layout overwrites Theme Options', 'mfn-opts'),
					'options' 	=> $layouts,
				),
				
				array(
					'id' 		=> 'mfn-post-menu',
					'type' 		=> 'select',
					'title' 	=> __('Custom | Menu', 'mfn-opts'),
					'desc' 		=> __('Do <b>not</b> work with Split Menu', 'mfn-opts'),
					'options' 	=> $aMenus,
				),
		
				// seo -----
				array(
					'id' 		=> 'mfn-meta-info-seo',
					'type' 		=> 'info',
					'title' 	=> '',
					'desc' 		=> __('SEO', 'mfn-opts'),
					'class' 	=> 'mfn-info',
				),
		
				array(
					'id' 		=> 'mfn-meta-seo-title',
					'type' 		=> 'text',
					'title' 	=> __('SEO | Title', 'mfn-opts'),
					'desc' 		=> __('These settings overriddes theme options settings', 'mfn-opts'),
				),
				
				array(
					'id' 		=> 'mfn-meta-seo-description',
					'type' 		=> 'text',
					'title' 	=> __('SEO | Description', 'mfn-opts'),
					'desc' 		=> __('These settings overriddes theme options settings', 'mfn-opts'),
				),
				
				array(
					'id' 		=> 'mfn-meta-seo-keywords',
					'type' 		=> 'text',
					'title' 	=> __('SEO | Keywords', 'mfn-opts'),
					'desc' 		=> __('These settings overriddes theme options settings', 'mfn-opts'),
				),
					
				// custom -----	
				array(
					'id' 		=> 'mfn-meta-info-custom',
					'type' 		=> 'info',
					'title' 	=> '',
					'desc' 		=> __('Custom CSS', 'mfn-opts'),
					'class' 	=> 'mfn-info',
				),
				
				array(
					'id' 		=> 'mfn-post-css',
					'type' 		=> 'textarea',
					'title' 	=> __('Custom | CSS', 'mfn-opts'),
					'desc' 		=> __('Paste your custom CSS code for this page', 'mfn-opts'),
					'class' 	=> 'full-width',
				),
				
			),
		);
		
		add_meta_box($mfn_page_meta_box['id'], $mfn_page_meta_box['title'], 'mfn_page_show_box', $mfn_page_meta_box['page'], $mfn_page_meta_box['context'], $mfn_page_meta_box['priority']);
	}
}
add_action('admin_menu', 'mfn_page_meta_add');


/*-----------------------------------------------------------------------------------*/
/*	Callback function to show fields in meta box
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'mfn_page_show_box' ) )
{
	function mfn_page_show_box() {
		global $MFN_Options, $mfn_page_meta_box, $post;
		$MFN_Options->_enqueue();
	 	
		// Use nonce for verification
		echo '<div id="mfn-wrapper">';
			echo '<input type="hidden" name="mfn_page_meta_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
			
			mfn_builder_show();
	
			echo '<table class="form-table">';
				echo '<tbody>';		
		 
					foreach ($mfn_page_meta_box['fields'] as $field) {
						$meta = get_post_meta($post->ID, $field['id'], true);
						if( ! key_exists('std', $field) ) $field['std'] = false;
						$meta = ( $meta || $meta==='0' ) ? $meta : stripslashes(htmlspecialchars(($field['std']), ENT_QUOTES ));
						mfn_meta_field_input( $field, $meta );
					}
		 
				echo '</tbody>';
			echo '</table>';
			
		echo '</div>';
	}
}


/*-----------------------------------------------------------------------------------*/
/*	Save data when page is edited
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'mfn_page_save_data' ) )
{
	function mfn_page_save_data($post_id) {
		global $mfn_page_meta_box;
	 
		// verify nonce
		if( key_exists( 'mfn_page_meta_nonce',$_POST ) ) {
			if ( ! wp_verify_nonce( $_POST['mfn_page_meta_nonce'], basename(__FILE__) ) ) {
				return $post_id;
			}
		}
	 
		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}
	 
		// check permissions
		if ( (key_exists('post_type', $_POST)) && ('page' == $_POST['post_type']) ) {
			if (!current_user_can('edit_page', $post_id)) {
				return $post_id;
			}
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
		}
		
		mfn_builder_save($post_id);
	
		// check and save fields ( $mfn_page_meta_box['fields'] )
		foreach ( (array)$mfn_page_meta_box['fields'] as $field ) {
			$old = get_post_meta($post_id, $field['id'], true);
			if( key_exists($field['id'], $_POST) ) {
				$new = $_POST[$field['id']];
			} else {
	//			$new = ""; // problem with "quick edit"
				continue;
			}
	 
			if ( isset($new) && $new != $old) {
				update_post_meta($post_id, $field['id'], $new);
			} elseif ('' == $new && $old) {
				delete_post_meta($post_id, $field['id'], $old);
			}
		}
	}
}
add_action('save_post', 'mfn_page_save_data');
