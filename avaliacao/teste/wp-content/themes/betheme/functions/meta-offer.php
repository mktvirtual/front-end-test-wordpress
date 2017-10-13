<?php
/**
 * Offer custom meta fields.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

/* ---------------------------------------------------------------------------
 * Create new post type
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_offer_post_type' ) )
{
	function mfn_offer_post_type() 
	{
		$offer_item_slug = mfn_opts_get( 'offer-slug', 'offer-item' );
		
		$labels = array(
			'name' 					=> __('Offer','mfn-opts'),
			'singular_name' 		=> __('Offer Item','mfn-opts'),
			'add_new' 				=> __('Add New','mfn-opts'),
			'add_new_item' 			=> __('Add New Item','mfn-opts'),
			'edit_item' 			=> __('Edit Item','mfn-opts'),
			'new_item' 				=> __('New Item','mfn-opts'),
			'view_item' 			=> __('View Item','mfn-opts'),
			'search_items' 			=> __('Search Offer Items','mfn-opts'),
			'not_found' 			=> __('No items found','mfn-opts'),
			'not_found_in_trash' 	=> __('No items found in Trash','mfn-opts'), 
			'parent_item_colon' 	=> ''
		  );
			
		$args = array(
			'labels' 				=> $labels,
			'menu_icon'				=> 'dashicons-clipboard',
			'public' 				=> true,
			'publicly_queryable' 	=> true,
			'show_ui' 				=> true, 
			'query_var' 			=> true,
			'capability_type' 		=> 'post',
			'hierarchical' 			=> false,
			'menu_position' 		=> null,
			'rewrite' 				=> array( 'slug' => $offer_item_slug, 'with_front'=>true ),
			'supports' 				=> array( 'editor', 'thumbnail', 'title', 'page-attributes' ),
		); 
		  
		register_post_type( 'offer', $args );
		
		register_taxonomy( 'offer-types', 'offer', array(
			'hierarchical' 			=> true,
			'label' 				=>  __('Offer categories','mfn-opts'),
			'singular_label' 		=>  __('Offer category','mfn-opts'),
			'rewrite'				=> true,
			'query_var' 			=> true
		));
	}
}
add_action( 'init', 'mfn_offer_post_type' );


/* ---------------------------------------------------------------------------
 * Edit columns
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_offer_edit_columns' ) )
{
	function mfn_offer_edit_columns($columns)
	{
		$newcolumns = array(
			"cb" 					=> "<input type=\"checkbox\" />",
			"offer_thumbnail" 		=> __('Thumbnail','mfn-opts'),
			"title" 				=> 'Title',
			"offer_types" 			=> __('Categories','mfn-opts'),
			"offer_order" 			=> __('Order','mfn-opts'),
		);
		$columns = array_merge($newcolumns, $columns);	
		
		return $columns;
	}
}
add_filter("manage_edit-offer_columns", "mfn_offer_edit_columns");  


/* ---------------------------------------------------------------------------
 * Custom columns
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_offer_custom_columns' ) )
{
	function mfn_offer_custom_columns($column)
	{
		global $post;
		switch ($column)
		{
			case "offer_thumbnail":
				if ( has_post_thumbnail() ) { the_post_thumbnail('50x50'); }
				break;
			case "offer_types":
				echo get_the_term_list($post->ID, 'offer-types', '', ', ','');
				break;
			case "offer_order":
				echo $post->menu_order;
				break;	
		}
	}
}
add_action("manage_posts_custom_column",  "mfn_offer_custom_columns"); 


/*-----------------------------------------------------------------------------------*/
/*	Define Metabox Fields
/*-----------------------------------------------------------------------------------*/

$mfn_offer_meta_box = array(
	'id' 		=> 'mfn-meta-offer',
	'title' 	=> __('Offer Item Options','mfn-opts'),
	'page' 		=> 'offer',
	'context' 	=> 'normal',
	'priority'	=> 'high',
	'fields' 	=> array(
			
		array(
			'id' 		=> 'mfn-post-desc',
			'type' 		=> 'custom',
			'title' 	=> __('Featured Image size', 'mfn-opts'),
			'sub_desc' 	=> __('recommended', 'mfn-opts'),
			'desc'		=> __('960px x 540px', 'mfn-opts'),
			'action'	=> 'description',
		),
			
		array(
			'id' 		=> 'mfn-post-link_title',
			'type' 		=> 'text',
			'title' 	=> __('Button text', 'mfn-opts'),
			'class'		=> 'small-text',
			'std' 		=> 'Read more',
		),
		
		array(
			'id' 		=> 'mfn-post-link',
			'type' 		=> 'text',
			'title' 	=> __('Button link', 'mfn-opts'),
		),
			
		array(
			'id' 		=> 'mfn-post-target',
			'type' 		=> 'switch',
			'title' 	=> __('Open link in a new window', 'mfn-opts'),
			'options' 	=> array( '1' => 'On', '0' => 'Off' ),
			'std' 		=> '0'
		),
			
		array(
			'id' 		=> 'mfn-post-thumbnail',
			'type' 		=> 'upload',
			'title' 	=> __('Thumbnail', 'mfn-opts'),
			'sub_desc' 	=> __('Thumbnail for Offer Slider Thumb Pager', 'mfn-opts'),
		),	

	),
);


/*-----------------------------------------------------------------------------------*/
/*	Add metabox to edit page
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'mfn_offer_meta_add' ) )
{
	function mfn_offer_meta_add() {
		global $mfn_offer_meta_box;
		add_meta_box($mfn_offer_meta_box['id'], $mfn_offer_meta_box['title'], 'mfn_offer_show_box', $mfn_offer_meta_box['page'], $mfn_offer_meta_box['context'], $mfn_offer_meta_box['priority']);
	}
}
add_action('admin_menu', 'mfn_offer_meta_add');


/*-----------------------------------------------------------------------------------*/
/*	Callback function to show fields in meta box
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'mfn_offer_show_box' ) )
{
	function mfn_offer_show_box() {
		global $MFN_Options, $mfn_offer_meta_box, $post;
		$MFN_Options->_enqueue();
	 	
		// Use nonce for verification
		echo '<div id="mfn-wrapper">';
			echo '<input type="hidden" name="mfn_offer_meta_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
			echo '<table class="form-table">';
				echo '<tbody>';
		 
					foreach ($mfn_offer_meta_box['fields'] as $field) {
						$meta = get_post_meta($post->ID, $field['id'], true);
						if( ! key_exists('std', $field) ) $field['std'] = false;
						$meta = ( $meta || $meta==='0' ) ? $meta : stripslashes(htmlspecialchars(( $field['std']), ENT_QUOTES ));
						mfn_meta_field_input( $field, $meta );
					}
		 
				echo '</tbody>';
			echo '</table>';
		echo '</div>';
	}
}


/*-----------------------------------------------------------------------------------*/
/*	Save data when post is edited
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'mfn_offer_save_data' ) )
{
	function mfn_offer_save_data($post_id) {
		global $mfn_offer_meta_box;
	 
		// verify nonce
		if( key_exists( 'mfn_offer_meta_nonce',$_POST ) ) {
			if ( ! wp_verify_nonce( $_POST['mfn_offer_meta_nonce'], basename(__FILE__) ) ) {
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
	 
		foreach ($mfn_offer_meta_box['fields'] as $field) {
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
add_action('save_post', 'mfn_offer_save_data');
