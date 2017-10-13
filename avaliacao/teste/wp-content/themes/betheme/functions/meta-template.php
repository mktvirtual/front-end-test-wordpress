<?php
/**
 * Builder Template custom meta fields.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

/* ---------------------------------------------------------------------------
 * Create new post type
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_template_post_type' ) )
{
	function mfn_template_post_type() 
	{
		$labels = array(
			'name' 					=> __('Templates','mfn-opts'),
			'singular_name' 		=> __('Template','mfn-opts'),
			'add_new'				=> __('Add New','mfn-opts'),
			'add_new_item' 			=> __('Add New Template','mfn-opts'),
			'edit_item' 			=> __('Edit Template','mfn-opts'),
			'new_item' 				=> __('New Template','mfn-opts'),
			'view_item' 			=> __('View Template','mfn-opts'),
			'search_items' 			=> __('Search Template','mfn-opts'),
			'not_found' 			=> __('No templates found','mfn-opts'),
			'not_found_in_trash'	=> __('No templates found in Trash','mfn-opts'), 
			'parent_item_colon' 	=> ''
		  );
			
		$args = array(
			'labels' 				=> $labels,
			'menu_icon'				=> 'dashicons-schedule',
			'public' 				=> true,
			'publicly_queryable'	=> true,
			'show_ui' 				=> true, 
			'query_var' 			=> true,
			'capability_type' 		=> 'post',
			'hierarchical' 			=> false,
			'menu_position' 		=> null,
			'rewrite' 				=> array( 'slug' => 'template-item', 'with_front'=>true ),
			'supports' 				=> array( 'title' ),
		); 
		  
		register_post_type( 'template', $args );
	}
}
add_action( 'init', 'mfn_template_post_type' ); 


/*-----------------------------------------------------------------------------------*/
/*	Define Metabox Fields
/*-----------------------------------------------------------------------------------*/
$mfn_template_meta_box = array(
		
	'id' 		=> 'mfn-meta-template',
	'title' 	=> __('Template Options','mfn-opts'),
	'page' 		=> 'template',
	'context' 	=> 'normal',
	'priority'	=> 'high',
	'fields' 	=> array(),
);


/*-----------------------------------------------------------------------------------*/
/*	Add metabox to edit page
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'mfn_template_meta_add' ) )
{
	function mfn_template_meta_add() {
		global $mfn_template_meta_box;
		add_meta_box($mfn_template_meta_box['id'], $mfn_template_meta_box['title'], 'mfn_template_show_box', $mfn_template_meta_box['page'], $mfn_template_meta_box['context'], $mfn_template_meta_box['priority']);
	}
}
add_action('admin_menu', 'mfn_template_meta_add');


/*-----------------------------------------------------------------------------------*/
/*	Callback function to show fields in meta box
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'mfn_template_show_box' ) )
{
	function mfn_template_show_box() {
		global $MFN_Options, $mfn_template_meta_box, $post;
		$MFN_Options->_enqueue();
	 	
		// Use nonce for verification
		echo '<div id="mfn-wrapper">';
			echo '<input type="hidden" name="mfn_template_meta_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
			
			mfn_builder_show();
			
		echo '</div>';
	}
}


/*-----------------------------------------------------------------------------------*/
/*	Save data when post is edited
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'mfn_template_save_data' ) )
{
	function mfn_template_save_data($post_id) {
		global $mfn_template_meta_box;
	 
		// verify nonce
		if( key_exists( 'mfn_template_meta_nonce',$_POST ) ) {
			if ( ! wp_verify_nonce( $_POST['mfn_template_meta_nonce'], basename(__FILE__) ) ) {
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
	}
}
add_action('save_post', 'mfn_template_save_data');
