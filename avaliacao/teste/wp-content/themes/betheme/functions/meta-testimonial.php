<?php
/**
 * Testimonial custom meta fields.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

/* ---------------------------------------------------------------------------
 * Create new post type
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_testimonial_post_type' ) )
{
	function mfn_testimonial_post_type() 
	{
		$testimonial_item_slug = mfn_opts_get( 'testimonial-slug', 'testimonial-item' );
		
		$labels = array(
			'name' 					=> __('Testimonials','mfn-opts'),
			'singular_name' 		=> __('Testimonial','mfn-opts'),
			'add_new' 				=> __('Add New','mfn-opts'),
			'add_new_item' 			=> __('Add New Testimonial','mfn-opts'),
			'edit_item' 			=> __('Edit Testimonial','mfn-opts'),
			'new_item' 				=> __('New Testimonial','mfn-opts'),
			'view_item' 			=> __('View Testimonials','mfn-opts'),
			'search_items' 			=> __('Search Testimonials','mfn-opts'),
			'not_found' 			=> __('No testimonials found','mfn-opts'),
			'not_found_in_trash' 	=> __('No testimonials found in Trash','mfn-opts'), 
			'parent_item_colon' 	=> ''
		  );
			
		$args = array(
			'labels' 				=> $labels,
			'menu_icon'				=> 'dashicons-format-quote',
			'public' 				=> true,
			'publicly_queryable' 	=> true,
			'show_ui' 				=> true, 
			'query_var' 			=> true,
			'capability_type'		=> 'post',
			'hierarchical' 			=> false,
			'menu_position' 		=> null,
			'rewrite' 				=> array( 'slug' => $testimonial_item_slug, 'with_front'=>true ),
			'supports' 				=> array( 'title', 'editor', 'page-attributes', 'thumbnail' ),
		); 
		  
		register_post_type( 'testimonial', $args );
		  
		register_taxonomy( 'testimonial-types' , 'testimonial' , array(
			'hierarchical' 			=> true, 
			'label' 				=>  __('Testimonial categories','mfn-opts'), 
			'singular_label' 		=>  __('Testimonial category','mfn-opts'), 
			'rewrite' 				=> true,
			'query_var' 			=> true
		));
	}
}
add_action( 'init', 'mfn_testimonial_post_type' );


/* ---------------------------------------------------------------------------
 * Edit columns
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_testimonial_edit_columns' ) )
{
	function mfn_testimonial_edit_columns($columns)
	{
		$newcolumns = array(
			"cb" => "<input type='checkbox' />",
			"testimonial_thumbnail" => __('Photo','mfn-opts'),
			"title" => 'Title',
			"testimonial_types" => __('Categories','mfn-opts'),
			"testimonial_order" =>  __('Order','mfn-opts'),
		);
		$columns = array_merge($newcolumns, $columns);	
		
		return $columns;
	}
}
add_filter("manage_edit-testimonial_columns", "mfn_testimonial_edit_columns");  


/* ---------------------------------------------------------------------------
 * Custom columns
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_testimonial_custom_columns' ) )
{
	function mfn_testimonial_custom_columns($column)
	{
		global $post;
		switch ($column)
		{
			case "testimonial_thumbnail":
				if ( has_post_thumbnail() ) { the_post_thumbnail('50x50'); }
				break;
			case "testimonial_types":
				echo get_the_term_list($post->ID, 'testimonial-types', '', ', ','');
				break;
			case "testimonial_order":
				echo $post->menu_order;
				break;		
		}
	}
}
add_action("manage_posts_custom_column",  "mfn_testimonial_custom_columns"); 


/*-----------------------------------------------------------------------------------*/
/*	Define Metabox Fields
/*-----------------------------------------------------------------------------------*/

$mfn_testimonial_meta_box = array(
	'id' => 'mfn-meta-testimonial',
	'title' => __('Testimonial Options','mfn-opts'),
	'page' => 'testimonial',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(

		array(
			'id' 		=> 'mfn-post-desc',
			'type' 		=> 'custom',
			'title' 	=> __('Featured Image size', 'mfn-opts'),
			'sub_desc' 	=> __('recommended', 'mfn-opts'),
			'desc'		=> __('85px x 85px', 'mfn-opts'),
			'action'	=> 'description',
		),
			
		array(
			'id' 		=> 'mfn-post-author',
			'type' 		=> 'text',
			'title' 	=> __('Author', 'mfn-opts'),
		),
		
		array(
			'id'		=> 'mfn-post-company',
			'type' 		=> 'text',
			'title' 	=> __('Company', 'mfn-opts'),
		),
		
		array(
			'id' 		=> 'mfn-post-link',
			'type' 		=> 'text',
			'title' 	=> __('Link', 'mfn-opts'),
			'sub_desc' 	=> __('Link to company page', 'mfn-opts'),
		),

	),
);


/*-----------------------------------------------------------------------------------*/
/*	Add metabox to edit page
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'mfn_testimonial_meta_add' ) )
{
	function mfn_testimonial_meta_add() {
		global $mfn_testimonial_meta_box;
		add_meta_box($mfn_testimonial_meta_box['id'], $mfn_testimonial_meta_box['title'], 'mfn_testimonial_show_box', $mfn_testimonial_meta_box['page'], $mfn_testimonial_meta_box['context'], $mfn_testimonial_meta_box['priority']);
	}
}
add_action('admin_menu', 'mfn_testimonial_meta_add');


/*-----------------------------------------------------------------------------------*/
/*	Callback function to show fields in meta box
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'mfn_testimonial_show_box' ) )
{
	function mfn_testimonial_show_box() {
		global $MFN_Options, $mfn_testimonial_meta_box, $post;
		$MFN_Options->_enqueue();
	 	
		// Use nonce for verification
		echo '<div id="mfn-wrapper">';
			echo '<input type="hidden" name="mfn_testimonial_meta_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
			echo '<table class="form-table">';
				echo '<tbody>';
		 
					foreach ($mfn_testimonial_meta_box['fields'] as $field) {
						$meta = get_post_meta($post->ID, $field['id'], true);
						if( ! key_exists( 'std', $field ) ) $field['std'] = '';
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
if( ! function_exists( 'mfn_testimonial_save_data' ) )
{
	function mfn_testimonial_save_data($post_id) {
		global $mfn_testimonial_meta_box;
	 
		// verify nonce
		if( key_exists( 'mfn_testimonial_meta_nonce',$_POST ) ) {
			if ( ! wp_verify_nonce( $_POST['mfn_testimonial_meta_nonce'], basename(__FILE__) ) ) {
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
	 
		foreach ($mfn_testimonial_meta_box['fields'] as $field) {
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
add_action('save_post', 'mfn_testimonial_save_data');
