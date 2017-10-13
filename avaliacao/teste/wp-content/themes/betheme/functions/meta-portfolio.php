<?php
/**
 * Portfolio custom meta fields.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

/* ---------------------------------------------------------------------------
 * Create new post type
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_portfolio_post_type' ) )
{
	function mfn_portfolio_post_type() 
	{
		$slug 	= mfn_opts_get( 'portfolio-slug', 'portfolio-item' );
		$tax	= mfn_opts_get( 'portfolio-tax', 'portfolio-types' );
		
		$labels = array(
			'name' 					=> __('Portfolio','mfn-opts'),
			'singular_name' 		=> __('Portfolio item','mfn-opts'),
			'add_new' 				=> __('Add New','mfn-opts'),
			'add_new_item' 			=> __('Add New Portfolio item','mfn-opts'),
			'edit_item' 			=> __('Edit Portfolio item','mfn-opts'),
			'new_item' 				=> __('New Portfolio item','mfn-opts'),
			'view_item' 			=> __('View Portfolio item','mfn-opts'),
			'search_items' 			=> __('Search Portfolio items','mfn-opts'),
			'not_found' 			=> __('No portfolio items found','mfn-opts'),
			'not_found_in_trash' 	=> __('No portfolio items found in Trash','mfn-opts'), 
			'parent_item_colon' 	=> '',
		  );
			
		$args = array(
			'labels' 				=> $labels,
			'menu_icon'				=> 'dashicons-portfolio',
			'public' 				=> true,
			'publicly_queryable' 	=> true,
			'show_ui' 				=> true, 
			'query_var' 			=> true,
			'capability_type' 		=> 'post',
			'hierarchical' 			=> false,
			'menu_position' 		=> null,
			'rewrite' 				=> array( 
				'slug' 			=> $slug, 
			),
			'supports' 				=> array( 'author', 'comments', 'editor', 'excerpt', 'page-attributes', 'thumbnail', 'title' ),
		); 
		  
		register_post_type( 'portfolio', $args );
		  
		register_taxonomy( 'portfolio-types', 'portfolio', array(
			'label' 				=>  __( 'Portfolio categories', 'mfn-opts' ),
			'hierarchical' 			=> true,
			'query_var' 			=> true,
			'rewrite'				=> array(
				'slug'			=> $tax,
			),
		));
	}
}
add_action( 'init', 'mfn_portfolio_post_type' );


/* ---------------------------------------------------------------------------
 * Edit columns
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_portfolio_edit_columns' ) )
{
	function mfn_portfolio_edit_columns($columns)
	{
		$newcolumns = array(
			"cb" 					=> "<input type=\"checkbox\" />",
			"portfolio_thumbnail" 	=> __('Thumbnail','mfn-opts'),
			"title" 				=> 'Title',
			"portfolio_types" 		=> __('Categories','mfn-opts'),
			"portfolio_order" 		=> __('Order','mfn-opts'),
		);
		$columns = array_merge($newcolumns, $columns);	
		
		return $columns;
	}
}
add_filter("manage_edit-portfolio_columns", "mfn_portfolio_edit_columns");  


/* ---------------------------------------------------------------------------
 * Custom columns
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_portfolio_custom_columns' ) )
{
	function mfn_portfolio_custom_columns($column)
	{
		global $post;
		switch ($column)
		{
			case "portfolio_thumbnail":
				if ( has_post_thumbnail() ) { the_post_thumbnail('50x50'); }
				break;
			case "portfolio_types":
				echo get_the_term_list($post->ID, 'portfolio-types', '', ', ','');
				break;
			case "portfolio_order":
				echo $post->menu_order;
				break;		
		}
	}
}
add_action("manage_posts_custom_column",  "mfn_portfolio_custom_columns"); 



/*-----------------------------------------------------------------------------------*/
/*	Add metabox to edit page
/*-----------------------------------------------------------------------------------*/ 
if( ! function_exists( 'mfn_portfolio_meta_add' ) )
{
	function mfn_portfolio_meta_add() {
		global $mfn_portfolio_meta_box;
		
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
		
		$mfn_portfolio_meta_box = array(
			'id' 		=> 'mfn-meta-portfolio',
			'title' 	=> __('Portfolio Item Options','mfn-opts'),
			'page' 		=> 'portfolio',
			'context' 	=> 'normal',
			'priority' 	=> 'high',
			'fields' 	=> array(
					
				// layout -----	
				array(
					'id' 		=> 'mfn-meta-info-layout',
					'type' 		=> 'info',
					'title' 	=> '',
					'desc' 		=> __('Layout', 'mfn-opts'),
					'class' 	=> 'mfn-info',
				),
		
				array(
					'id' 		=> 'mfn-post-hide-content',
					'type' 		=> 'switch',
					'title' 	=> __('Hide the content', 'mfn-opts'),
					'sub_desc' 	=> __('Hide the content from the WordPress editor', 'mfn-opts'),
					'desc' 		=> __('<strong>Turn it ON if you build content using Content Builder</strong><br />Use the Content item if you want to display the Content from editor within the Content Builder', 'mfn-opts'),
					'options' 	=> array('1' => 'On', '0' => 'Off'),
					'std' 		=> '0'
				),
				
				array(
					'id' 		=> 'mfn-post-layout',
					'type' 		=> 'radio_img',
					'title' 	=> __('Layout', 'mfn-opts'),
					'desc' 		=> __('<b>Full width</b> sections works only <b>without</b> sidebars', 'mfn-opts'),
					'options' 	=> array(
						'no-sidebar' 	=> array('title' => 'Full width. No sidebar', 'img' => MFN_OPTIONS_URI.'img/1col.png'),
						'left-sidebar' 	=> array('title' => 'Left Sidebar', 'img' => MFN_OPTIONS_URI.'img/2cl.png'),
						'right-sidebar'	=> array('title' => 'Right Sidebar', 'img' => MFN_OPTIONS_URI.'img/2cr.png'),
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
					
				array(
					'id' 		=> 'mfn-post-template',
					'type' 		=> 'select',
					'title' 	=> __('Template', 'mfn-opts'),
					'options' 	=> array(
						'' 			=> __( 'Default Template', 'mfn-opts' ),
						'builder' 	=> __( 'Builder', 'mfn-opts' ),
						'intro' 	=> __( 'Intro Header', 'mfn-opts' ),
					),
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
					'id' 		=> 'mfn-post-video',
					'type' 		=> 'text',
					'title' 	=> __('Video | ID', 'mfn-opts'),
					'sub_desc' 	=> __('YouTube or Vimeo', 'mfn-opts'),
					'desc' 		=> __('It`s placed in every YouTube & Vimeo video, for example:<br /><b>YouTube:</b> http://www.youtube.com/watch?v=<u>WoJhnRczeNg</u><br /><b>Vimeo:</b> http://vimeo.com/<u>62954028</u>', 'mfn-opts'),
					'class' 	=> 'small-text mfn-post-format video'
				),
				
				array(
					'id'		=> 'mfn-post-video-mp4',
					'type'		=> 'upload',
					'title'		=> __('Video | HTML5', 'mfn-opts'),
					'sub_desc'	=> __('m4v [.mp4]', 'mfn-opts'),
					'desc'		=> __('<strong>Notice:</strong> HTML5 video works only in moden browsers', 'mfn-opts'),
					'class'		=> __('video', 'mfn-opts'),
				),
					
				array(
					'id' 		=> 'mfn-post-header-bg',
					'type' 		=> 'upload',
					'title' 	=> __('Header Image', 'mfn-opts'),
				),	
	
				// description -----					
				array(
					'id' 		=> 'mfn-meta-info-desc',
					'type' 		=> 'info',
					'title' 	=> '',
					'desc' 		=> __('Description', 'mfn-opts'),
					'class' 	=> 'mfn-info',
				),
				
				array(
					'id' 		=> 'mfn-post-client',
					'type' 		=> 'text',
					'title' 	=> __('Client', 'mfn-opts'),
				),
				
				array(
					'id' 		=> 'mfn-post-link',
					'type' 		=> 'text',
					'title' 	=> __('Website', 'mfn-opts'),
				),
				
				array(
					'id' 		=> 'mfn-post-task',
					'type' 		=> 'text',
					'title' 	=> __('Task', 'mfn-opts'),
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
					'id' 		=> 'mfn-post-slider-header',
					'type' 		=> 'switch',
					'title' 	=> __('Slider | Show in Header', 'mfn-opts'),
					'sub_desc' 	=> __('Show slider in Header instead of the Content', 'mfn-opts'),
					'options' 	=> array( '1' => 'On', '0' => 'Off' ),
					'std' 		=> '0'
				),
				
				array(
					'id' 		=> 'mfn-post-custom-layout',
					'type' 		=> 'select',
					'title' 	=> __('Custom | Layout', 'mfn-opts'),
					'desc' 		=> __('Custom Layout overwrites Theme Options', 'mfn-opts'),
					'options' 	=> $layouts,
				),
					
	
				// advanced -----				
				array(
					'id' 		=> 'mfn-meta-info-advanced',
					'type' 		=> 'info',
					'title' 	=> '',
					'desc' 		=> __('Advanced', 'mfn-opts'),
					'class' 	=> 'mfn-info',
				),
					
				array(
					'id' 		=> 'mfn-post-bg',
					'type' 		=> 'upload',
					'title' 	=> __('Background | Image', 'mfn-opts'),
					'desc' 		=> __('for <b>Portfolio Layout: List</b>', 'mfn-opts'),
				),
					
				array(
					'id' 		=> 'mfn-post-bg-hover',
					'type' 		=> 'color',
					'title' 	=> __('Background | Color', 'mfn-opts'),
					'desc' 		=> __('for <b>Portfolio Layout: List & Masonry Hover Details</b>', 'mfn-opts'),
				),
					
				array(
					'id'		=> 'mfn-post-intro',
					'type' 		=> 'checkbox',
					'title' 	=> __('Intro | Options', 'mfn-opts'),
					'desc' 		=> __('for <b>Template: Intro</b>', 'mfn-opts'),
					'options' 	=> array(
						'light'			=> __( 'Light | light image, dark text', 'mfn-opts' ),
						'full-screen'	=> __( 'Full Screen', 'mfn-opts' ),
						'parallax'		=> __( 'Parallax', 'mfn-opts' ),
						'cover'			=> __( 'Background size: Cover<span>enabled by default in parallax</span>', 'mfn-opts' ),
					),
				),
					
				array(
					'id' 		=> 'mfn-post-size',
					'type' 		=> 'select',
					'title' 	=> __('Masonry Flat | Item Size', 'mfn-opts'),
					'desc' 		=> __('for <b>Portfolio Layout: Masonry Flat</b>', 'mfn-opts'),
					'options' 	=> array(
						''			=> __('Default','mfn-opts'),
						'wide'		=> __('Wide','mfn-opts'),
						'tall'		=> __('Tall','mfn-opts'),
						'wide tall'	=> __('Big','mfn-opts'),
					),
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
		
			),
		);
	
		add_meta_box($mfn_portfolio_meta_box['id'], $mfn_portfolio_meta_box['title'], 'mfn_portfolio_show_box', $mfn_portfolio_meta_box['page'], $mfn_portfolio_meta_box['context'], $mfn_portfolio_meta_box['priority']);
	}
}
add_action('admin_menu', 'mfn_portfolio_meta_add');


/*-----------------------------------------------------------------------------------*/
/*	Callback function to show fields in meta box
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'mfn_portfolio_show_box' ) )
{
	function mfn_portfolio_show_box() {
		global $MFN_Options, $mfn_portfolio_meta_box, $post;
		$MFN_Options->_enqueue();
	 	
		// Use nonce for verification
		echo '<div id="mfn-wrapper">';
			echo '<input type="hidden" name="mfn_portfolio_meta_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
			
			mfn_builder_show();
			
			echo '<table class="form-table">';
				echo '<tbody>';
		 
					foreach ($mfn_portfolio_meta_box['fields'] as $field) {
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
if( ! function_exists( 'mfn_portfolio_save_data' ) )
{
	function mfn_portfolio_save_data($post_id) {
		global $mfn_portfolio_meta_box;
	 
		// verify nonce
		if( key_exists( 'mfn_portfolio_meta_nonce',$_POST ) ) {
			if ( ! wp_verify_nonce( $_POST['mfn_portfolio_meta_nonce'], basename(__FILE__) ) ) {
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
	 
		if( $mfn_portfolio_meta_box && key_exists( 'fields', $mfn_portfolio_meta_box ) ){
			foreach ($mfn_portfolio_meta_box['fields'] as $field) {
				$old = get_post_meta($post_id, $field['id'], true);
				if( key_exists($field['id'], $_POST) ) {
					$new = $_POST[$field['id']];
				} else {
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
}
add_action('save_post', 'mfn_portfolio_save_data');
