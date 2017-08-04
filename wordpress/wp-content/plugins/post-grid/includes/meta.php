<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access


function post_grid_posttype_register() {
 
        $labels = array(
                'name' => _x('Post Grid', post_grid_textdomain),
                'singular_name' => _x('Post Grid', post_grid_textdomain),
                'add_new' => _x('New Post Grid', post_grid_textdomain),
                'add_new_item' => __('New Post Grid', post_grid_textdomain),
                'edit_item' => __('Edit Post Grid', post_grid_textdomain),
                'new_item' => __('New Post Grid', post_grid_textdomain),
                'view_item' => __('View Post Grid', post_grid_textdomain),
                'search_items' => __('Search Post Grid', post_grid_textdomain),
                'not_found' =>  __('Nothing found', post_grid_textdomain),
                'not_found_in_trash' => __('Nothing found in Trash', post_grid_textdomain),
                'parent_item_colon' => ''
        );
 
        $args = array(
                'labels' => $labels,
                'public' => false,
                'publicly_queryable' => false,
                'show_ui' => true,
                'query_var' => true,
                'menu_icon' => null,
                'rewrite' => true,
                'capability_type' => 'post',
                'hierarchical' => false,
                'menu_position' => null,
                'supports' => array('title'),
				'menu_icon' => 'dashicons-media-spreadsheet',
				
          );
 
        register_post_type( 'post_grid' , $args );

}

add_action('init', 'post_grid_posttype_register');





/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function meta_boxes_post_grid()
	{
		$screens = array( 'post_grid' );
		foreach ( $screens as $screen )
			{
				add_meta_box('post_grid_metabox',__( 'Post Grid Options', post_grid_textdomain ),'meta_boxes_post_grid_input', $screen);
			}
	}
add_action( 'add_meta_boxes', 'meta_boxes_post_grid' );


function meta_boxes_post_grid_input( $post ) {
	
	global $post;
	wp_nonce_field( 'meta_boxes_post_grid_input', 'meta_boxes_post_grid_input_nonce' );
	
	
	$post_grid_meta_options = get_post_meta( $post->ID, 'post_grid_meta_options', true );
	

	if(!empty($post_grid_meta_options['post_types'])){
		$post_types = $post_grid_meta_options['post_types'];
		}
	else{
		$post_types = array('post');
		}	
	
	
		
		
	


	if(!empty($post_grid_meta_options['categories'])){
		$categories = $post_grid_meta_options['categories'];
		}
	else{
		$categories = array();
		}
		
		
		
	if(!empty($post_grid_meta_options['terms_relation'])){
		$terms_relation = $post_grid_meta_options['terms_relation'];
		}
	else{
		$terms_relation = 'IN';
		}		
		
		
		
		
	if(!empty($post_grid_meta_options['categories_relation'])){
		$categories_relation = $post_grid_meta_options['categories_relation'];
		}
	else{
		$categories_relation = 'OR';
		}








/*
	if(!empty($post_grid_meta_options['extra_query_parameter'])){
		$extra_query_parameter = $post_grid_meta_options['extra_query_parameter'];
		}
	else{
		$extra_query_parameter = '';
		}

*/	
	
	
	if(!empty($post_grid_meta_options['post_status'])){
		$post_status = $post_grid_meta_options['post_status'];
		}
	else{
		$post_status = array('publish');
		}	
	
	
	
	if(!empty($post_grid_meta_options['offset'])){
		$offset = $post_grid_meta_options['offset'];
		}
	else{
		$offset = '';
		}
	
	
	if(!empty($post_grid_meta_options['posts_per_page'])){
		$posts_per_page = $post_grid_meta_options['posts_per_page'];
		
		}
	else{
		$posts_per_page = 10;
		}
	
	
	if(!empty($post_grid_meta_options['exclude_post_id']))	
	$exclude_post_id = $post_grid_meta_options['exclude_post_id'];
	
	
	if(!empty($post_grid_meta_options['query_order'])){
		$query_order = $post_grid_meta_options['query_order'];
		}
	else{
		$query_order = 'DESC';
		}	
	
	if(!empty($post_grid_meta_options['query_orderby'])){
		$query_orderby = $post_grid_meta_options['query_orderby'];
		}
	else{
		$query_orderby = array('date');
		}

	
	if(!empty($post_grid_meta_options['query_orderby_meta_key']))
	$query_orderby_meta_key = $post_grid_meta_options['query_orderby_meta_key'];
	
	

/*

	if(!empty($post_grid_meta_options['meta_query'])){
		$meta_query = $post_grid_meta_options['meta_query'];
		}
	else{
		$meta_query = array();
		}


	if(!empty($post_grid_meta_options['meta_query_relation'])){
		$meta_query_relation = $post_grid_meta_options['meta_query_relation'];
		}
	else{
		$meta_query_relation = 'OR';
		}

*/
	
	if(!empty($post_grid_meta_options['keyword']))
	$keyword = $post_grid_meta_options['keyword'];		
	
	
	

	
	if(!empty($post_grid_meta_options['grid_layout']['name'])){
		
		$grid_layout_name = $post_grid_meta_options['grid_layout']['name'];	
		}
	else{
		$grid_layout_name = 'layout_grid';
		}	

	
/*

	if(!empty($post_grid_meta_options['grid_layout']['col_multi'])){
		
		$grid_layout_col_multi = $post_grid_meta_options['grid_layout']['col_multi'];	
		}
	else{
		$grid_layout_col_multi = 2;
		}

*/	
		
	
	
	if(!empty($post_grid_meta_options['layout']['content'])){
		
		$layout_content = $post_grid_meta_options['layout']['content'];	
		}
	else{
		$layout_content = 'flat';	
		}
	
	
	if(!empty($post_grid_meta_options['layout']['hover']))
	$layout_hover = $post_grid_meta_options['layout']['hover'];		
	
	
/*

	if(!empty($post_grid_meta_options['enable_multi_skin'])){
		$enable_multi_skin = $post_grid_meta_options['enable_multi_skin'];
		}
	else{
		$enable_multi_skin = 'no';
		}

*/	
	
	
	if(!empty($post_grid_meta_options['skin'])){
		$skin = $post_grid_meta_options['skin'];
		}
	else{
		$skin = 'flat';
		}
		
	
	if(!empty($post_grid_meta_options['custom_js'])){
		$custom_js = $post_grid_meta_options['custom_js'];
		}
	else{
		$custom_js = '/*Write your js code here*/';
		}
		
	
	if(!empty($post_grid_meta_options['custom_css'])){
		$custom_css = $post_grid_meta_options['custom_css'];
		}
	else{
		$custom_css = '/*Write your CSS code here*/';
		}
	
	
	if(!empty($post_grid_meta_options['masonry_enable'])){
		
		$masonry_enable = $post_grid_meta_options['masonry_enable'];
		}
	else{
		$masonry_enable = 'no';
		
		}
		
		
	
	if(!empty($post_grid_meta_options['lazy_load_enable'])){
		
		$lazy_load_enable = $post_grid_meta_options['lazy_load_enable'];
		}
	else{
		$lazy_load_enable = 'no';
		
		}
		
	if(!empty($post_grid_meta_options['lazy_load_image_src'])){
		
		$lazy_load_image_src = $post_grid_meta_options['lazy_load_image_src'];
		}
	else{
		$lazy_load_image_src = '';
		
		}		
			
		
	
	if(!empty($post_grid_meta_options['width']['desktop'])){
		
		$items_width_desktop = $post_grid_meta_options['width']['desktop'];
		}
	else{
		$items_width_desktop = '280px';
		
		}
		
		
	if(!empty($post_grid_meta_options['width']['tablet'])){
		
		$items_width_tablet = $post_grid_meta_options['width']['tablet'];
		}
	else{
		$items_width_tablet = '280px';
		
		}	
		
		
	if(!empty($post_grid_meta_options['item_height']['style'])){
		
		$items_height_style = $post_grid_meta_options['item_height']['style'];
		}
	else{
		$items_height_style = 'auto_height';
		
		}				
			
			
	if(!empty($post_grid_meta_options['item_height']['fixed_height'])){
		
		$items_fixed_height = $post_grid_meta_options['item_height']['fixed_height'];
		}
	else{
		$items_fixed_height = '220px';
		
		}		
		
		
		
			
		
	if(!empty($post_grid_meta_options['width']['mobile'])){
		
		$items_width_mobile = $post_grid_meta_options['width']['mobile'];
		}
	else{
		$items_width_mobile = '90%';
		
		}		
			
	if(!empty($post_grid_meta_options['media_height']['style'])){
		
		$items_media_height_style = $post_grid_meta_options['media_height']['style'];
		}
	else{
		$items_media_height_style = 'auto_height';
		
		}				
			
			
	if(!empty($post_grid_meta_options['media_height']['fixed_height'])){
		
		$items_media_fixed_height = $post_grid_meta_options['media_height']['fixed_height'];
		}
	else{
		$items_media_fixed_height = '220px';
		
		}	
		
	if(!empty($post_grid_meta_options['items_bg_color_type'])){
		
		$items_bg_color_type = $post_grid_meta_options['items_bg_color_type'];
		}
	else{
		$items_bg_color_type = 'fixed';
		
		}		
					
			
	if(!empty($post_grid_meta_options['items_bg_color'])){
		
		$items_bg_color = $post_grid_meta_options['items_bg_color'];
		}
	else{
		$items_bg_color = '#fff';
		
		}			
			
			
			
			
	if(!empty($post_grid_meta_options['media_source'])){
		
		$media_source = $post_grid_meta_options['media_source'];
		}
	else{
		$media_source = array();
		
		}			
			
	if(!empty($post_grid_meta_options['featured_img_size'])){
		
		$featured_img_size = $post_grid_meta_options['featured_img_size'];
		}
	else{
		$featured_img_size = 'medium';
		
		}				
			
	if(!empty($post_grid_meta_options['thumb_linked'])){
		
		$thumb_linked = $post_grid_meta_options['thumb_linked'];
		}
	else{
		$thumb_linked = 'yes';
		
		}				
			
			
			
			
	if(!empty($post_grid_meta_options['margin'])){
		
		$items_margin = $post_grid_meta_options['margin'];
		}
	else{
		$items_margin = '10px';
		
		}
		
	if(!empty($post_grid_meta_options['container']['padding'])){
		
		$container_padding = $post_grid_meta_options['container']['padding'];
		}
	else{
		$container_padding = '10px';
		
		}	
		
	if(!empty($post_grid_meta_options['container']['bg_color'])){
		
		$container_bg_color = $post_grid_meta_options['container']['bg_color'];
		}
	else{
		$container_bg_color = '#fff';
		
		}		
		
		
	if(!empty($post_grid_meta_options['container']['bg_image'])){
		
		$container_bg_image = $post_grid_meta_options['container']['bg_image'];
		}
	else{
		$container_bg_image = '';
		
		}				
		
		
		
	if(!empty($post_grid_meta_options['grid_type'])){
		
		$grid_type = $post_grid_meta_options['grid_type'];
		}
	else{
		$grid_type = 'grid';
		
		}		
		
		
		
/*

	if(!empty($post_grid_meta_options['nav_top']['filter'])){
		
		$nav_top_filter = $post_grid_meta_options['nav_top']['filter'];
		}
	else{
		$nav_top_filter = 'no';
		
		}

*/	
		
		
		

		
		

/*

	if(!empty($post_grid_meta_options['nav_top']['filterable_post_per_page'])){
		
		$filterable_post_per_page = $post_grid_meta_options['nav_top']['filterable_post_per_page'];
		}
	else{
		$filterable_post_per_page = '3';
		
		}	
				
	if(!empty($post_grid_meta_options['nav_top']['active_filter'])){
		
		$active_filter = $post_grid_meta_options['nav_top']['active_filter'];
		}
	else{
		$active_filter = 'all';
		
		}


		
	if(!empty($post_grid_meta_options['slider_navs'])){
		
		$slider_navs = $post_grid_meta_options['slider_navs'];
		}
	else{
		$slider_navs = 'true';
		
		}			
		
	if(!empty($post_grid_meta_options['slider_navs_positon'])){
		
		$slider_navs_positon = $post_grid_meta_options['slider_navs_positon'];
		}
	else{
		$slider_navs_positon = 'middle';
		
		}		
		
	if(!empty($post_grid_meta_options['slider_navs_style'])){
		
		$slider_navs_style = $post_grid_meta_options['slider_navs_style'];
		}
	else{
		$slider_navs_style = 'round';
		
		}		
		
		
		
	if(!empty($post_grid_meta_options['slider_dots'])){
		
		$slider_dots = $post_grid_meta_options['slider_dots'];
		}
	else{
		$slider_dots = 'true';
		
		}		
		
	if(!empty($post_grid_meta_options['slider_dots_style'])){
		
		$slider_dots_style = $post_grid_meta_options['slider_dots_style'];
		}
	else{
		$slider_dots_style = 'round';
		
		}		
		
	if(!empty($post_grid_meta_options['slider_dots_bg_color'])){
		
		$slider_dots_bg_color = $post_grid_meta_options['slider_dots_bg_color'];
		}
	else{
		$slider_dots_bg_color = '#e6e6e6';
		
		}		
		
		
	if(!empty($post_grid_meta_options['slider_auto_play'])){
		
		$slider_auto_play = $post_grid_meta_options['slider_auto_play'];
		}
	else{
		$slider_auto_play = 'true';
		
		}	
		
		
	if(!empty($post_grid_meta_options['slider_rewind'])){
		
		$slider_rewind = $post_grid_meta_options['slider_rewind'];
		}
	else{
		$slider_rewind = 'false';
		
		}		
		
		
	if(!empty($post_grid_meta_options['slider_loop'])){
		
		$slider_loop = $post_grid_meta_options['slider_loop'];
		}
	else{
		$slider_loop = 'true';
		
		}		
		
		
	if(!empty($post_grid_meta_options['slider_center'])){
		
		$slider_center = $post_grid_meta_options['slider_center'];
		}
	else{
		$slider_center = 'false';
		
		}		
		
		
	if(!empty($post_grid_meta_options['slider_autoplayHoverPause'])){
		
		$slider_autoplayHoverPause = $post_grid_meta_options['slider_autoplayHoverPause'];
		}
	else{
		$slider_autoplayHoverPause = 'true';
		
		}		
		
		
	if(!empty($post_grid_meta_options['slider_dotsSpeed'])){
		
		$slider_dotsSpeed = $post_grid_meta_options['slider_dotsSpeed'];
		}
	else{
		$slider_dotsSpeed = '1000';
		
		}		
		
		
	if(!empty($post_grid_meta_options['slider_navSpeed'])){
		
		$slider_navSpeed = $post_grid_meta_options['slider_navSpeed'];
		}
	else{
		$slider_navSpeed = '1000';
		
		}		
		
	if(!empty($post_grid_meta_options['slider_mouseDrag'])){
		
		$slider_mouseDrag = $post_grid_meta_options['slider_mouseDrag'];
		}
	else{
		$slider_mouseDrag = 'true';
		
		}		
		
	if(!empty($post_grid_meta_options['slider_touchDrag'])){
		
		$slider_touchDrag = $post_grid_meta_options['slider_touchDrag'];
		}
	else{
		$slider_touchDrag = 'true';
		
		}		
		
		
		
	if(!empty($post_grid_meta_options['slider_column_desktop'])){
		
		$slider_column_desktop = $post_grid_meta_options['slider_column_desktop'];
		}
	else{
		$slider_column_desktop = 4;
		
		}			
		
	if(!empty($post_grid_meta_options['slider_column_tablet'])){
		
		$slider_column_tablet = $post_grid_meta_options['slider_column_tablet'];
		}
	else{
		$slider_column_tablet = 2;
		
		}			
		
	if(!empty($post_grid_meta_options['slider_column_mobile'])){
		
		$slider_column_mobile = $post_grid_meta_options['slider_column_mobile'];
		}
	else{
		$slider_column_mobile = 1;
		
		}	

*/	
		

		
		
	if(!empty($post_grid_meta_options['nav_top']['search'])){
		
		$nav_top_search = $post_grid_meta_options['nav_top']['search'];
		}
	else{
		$nav_top_search = 'no';
		
		}		
		
		
	if(!empty($post_grid_meta_options['nav_bottom']['pagination_type'])){
		
		$pagination_type = $post_grid_meta_options['nav_bottom']['pagination_type'];
		}
	else{
		$pagination_type = 'normal';
		
		}		
		
		
	if(!empty($post_grid_meta_options['pagination']['max_num_pages'])){
		
		$max_num_pages = $post_grid_meta_options['pagination']['max_num_pages'];
		}
	else{
		$max_num_pages = 0;
		
		}		
		
		
	if(!empty($post_grid_meta_options['pagination']['prev_text'])){
		
		$pagination_prev_text = $post_grid_meta_options['pagination']['prev_text'];
		}
	else{
		$pagination_prev_text = '« Previous';
		
		}		
		
		
	if(!empty($post_grid_meta_options['pagination']['next_text'])){
		
		$pagination_next_text = $post_grid_meta_options['pagination']['next_text'];
		}
	else{
		$pagination_next_text = 'Next »';
		
		}		
		
		
		
	if(!empty($post_grid_meta_options['nav_bottom']['pagination_theme'])){
		
		$pagination_theme = $post_grid_meta_options['nav_bottom']['pagination_theme'];
		}
	else{
		$pagination_theme = 'lite';
		
		}			
		
		
		
		
		
		
		
		
		
?>

    <div class="para-settings post-grid-metabox">



        <ul class="tab-nav"> 
            <li nav="1" class="nav1 active"><i class="fa fa-code"></i> <?php _e('Shortcodes',post_grid_textdomain); ?></li>
            <li nav="2" class="nav2"><i class="fa fa-cubes"></i> <?php _e('Query Post',post_grid_textdomain); ?></li>
            <li nav="3" class="nav3"><i class="fa fa-object-group"></i> <?php _e('Layout',post_grid_textdomain); ?></li>
            <li nav="4" class="nav3"><i class="fa fa-magic"></i> <?php _e('Layout settings',post_grid_textdomain); ?></li>            
            <li nav="5" class="nav4"><i class="fa fa-sliders"></i> <?php _e('Navigations',post_grid_textdomain); ?></li>            
            <li nav="6" class="nav6"><i class="fa fa-css3"></i> <?php _e('Custom Scripts',post_grid_textdomain); ?></li>           
            
                     
                       
        </ul> <!-- tab-nav end -->
        
		<ul class="box">
            <li style="display: block;" class="box1 tab-box active">
                <div class="option-box">
                    <p class="option-title"><?php _e('Shortcode',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('Copy this shortcode and paste on page or post where you want to display post grid. <br />Use PHP code to your themes file to display post grid.',post_grid_textdomain); ?></p>
                    <textarea cols="50" rows="1" style="background:#bfefff" onClick="this.select();" >[post_grid <?php echo 'id="'.$post->ID.'"';?>]</textarea>
                <br /><br />

                <p class="option-info"><?php _e('PHP Code:',post_grid_textdomain); ?></p>
                <textarea cols="50" rows="1" style="background:#bfefff" onClick="this.select();" ><?php echo '<?php echo do_shortcode("[post_grid id='; echo "'".$post->ID."']"; echo '"); ?>'; ?></textarea>  
 

                </div>
               
            </li>
            <li style="display: none;" class="box2 tab-box ">
                <div class="option-box">
                    <p class="option-title"><?php _e('Post Types',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('Select post types you want to query post , can be select multiple. <br />Hint: Ctrl + click to select mulitple',post_grid_textdomain); ?></p>
                  
                    <div title="Clear post types selection." onClick="" class="button clear-post-types"> Clear</div>
                    <br/><br/>
                  
                    <?php
					echo post_grid_posttypes($post_types);
					?>

                </div>
                
                
                <div class="option-box">
                    <p class="option-title"><?php _e('Taxonomy & Terms (Categories)',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('Select categories. <br />Hint: Ctrl + click to select mulitple',post_grid_textdomain); ?></p>
                    
                    <div title="Clear categories selection." onClick="" class="button clear-categories"> Clear</div>
                    <br/><br/>
                    
                    <div class="categories-container">

                    <?php
					echo post_grid_get_categories(get_the_ID());
					?>
                    
                    </div>
                    
                    <p class="option-title"><?php _e('Terms relation',post_grid_textdomain); ?></p>
                    
                    <label><input type="radio" name="post_grid_meta_options[terms_relation]" <?php if($terms_relation == 'IN') echo 'checked';?> value="IN" >IN</label>   
                    <label><input type="radio" name="post_grid_meta_options[terms_relation]" <?php if($terms_relation == 'NOT IN') echo 'checked';?> value="NOT IN" >NOT IN</label>                    <label><input type="radio" name="post_grid_meta_options[terms_relation]" <?php if($terms_relation == 'AND') echo 'checked';?> value="AND" >AND</label>
                    <label><input type="radio" name="post_grid_meta_options[terms_relation]" <?php if($terms_relation == 'EXISTS') echo 'checked';?> value="EXISTS" >EXISTS</label>                    <label><input type="radio" name="post_grid_meta_options[terms_relation]" <?php if($terms_relation == 'NOT EXISTS') echo 'checked';?> value="NOT EXISTS" >NOT EXISTS</label>                    
                    
                    <p class="option-title"><?php _e('Taxonomy relation',post_grid_textdomain); ?></p>
                    
                    <label><input type="radio" name="post_grid_meta_options[categories_relation]" <?php if($categories_relation == 'OR') echo 'checked';?> value="OR" >OR</label>
                    <label><input type="radio" name="post_grid_meta_options[categories_relation]" <?php if($categories_relation == 'AND') echo 'checked';?> value="AND" >AND</label>                    
                    
                    
                    
                </div>   
                
                
                
                
                
                
    
                <div class="option-box">
                    <p class="option-title"><?php _e('Post Status',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('Display post from following post status, <br />Hint: Ctrl + click to select mulitple',post_grid_textdomain); ?></p>
                    
                    <select class="post_status" name="post_grid_meta_options[post_status][]" multiple >
                        <option value="publish" <?php if(in_array("publish",$post_status)) echo "selected"; ?>>Publish</option>
                        <option value="pending" <?php if(in_array("pending",$post_status)) echo "selected"; ?>>Pending</option>
                        <option value="draft" <?php if(in_array("draft",$post_status)) echo "selected"; ?>>Draft</option>
                        <option value="auto-draft" <?php if(in_array("auto-draft",$post_status)) echo "selected"; ?>>Auto draft</option>
                        <option value="future" <?php if(in_array("future",$post_status)) echo "selected"; ?>>Future</option>
                        <option value="private" <?php if(in_array("private",$post_status)) echo "selected"; ?>>Private</option>                    
                        <option value="inherit" <?php if(in_array("inherit",$post_status)) echo "selected"; ?>>Inherit</option>                    
                        <option value="trash" <?php if(in_array("trash",$post_status)) echo "selected"; ?>>Trash</option>
                        <option value="any" <?php if(in_array("any",$post_status)) echo "selected"; ?>>Any</option>                                          
                    </select> 
                    
                </div>                         
                        
                <div class="option-box">
                    <p class="option-title"><?php _e('Posts per page',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('Number of post each pagination. -1 to display all. default is 10 if you left empty.',post_grid_textdomain); ?></p>
                    <input type="text" placeholder="3" name="post_grid_meta_options[posts_per_page]" value="<?php if(!empty($posts_per_page)) echo $posts_per_page; ?>" />
                </div>                        
                        
                            
                <div class="option-box">
                    <p class="option-title"><?php _e('Offset',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('Display posts from the n\'th, if you set <b>Posts per page</b> to -1 will not work offset.',post_grid_textdomain); ?></p>
                    <input type="text" placeholder="3" name="post_grid_meta_options[offset]" value="<?php echo $offset; ?>" />  
                </div>
                
                              
                
                <div class="option-box">
                    <p class="option-title"><?php _e('Exclude by post ID',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('you can exclude post by ID, comma(,) separated',post_grid_textdomain); ?></p>
                    
                    <input type="text" placeholder="5,3" name="post_grid_meta_options[exclude_post_id]" value="<?php if(!empty($exclude_post_id)) echo $exclude_post_id; else echo ''; ?>" />  
                </div>
                              
                
                <div class="option-box">
                    <p class="option-title"><?php _e('Post query order',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('Query order ascending or descending',post_grid_textdomain); ?></p>
                    
                    <select class="query_order" name="post_grid_meta_options[query_order]" >
                    <option value="ASC" <?php if($query_order=="ASC") echo "selected"; ?>>Ascending</option>
                    <option value="DESC" <?php if($query_order=="DESC") echo "selected"; ?>>Descending</option>
                    </select>
                    
                </div>
                
                
                <div class="option-box">
                    <p class="option-title"><?php _e('Post query orderby',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('Query orderby parameter, can select multiple',post_grid_textdomain); ?></p>
                    
                        <select class="query_orderby" name="post_grid_meta_options[query_orderby][]"  multiple>
                        <option value="ID" <?php if(in_array("ID",$query_orderby)) echo "selected"; ?>><?php _e('ID',post_grid_textdomain); ?></option>
                        <option value="date" <?php if(in_array("date",$query_orderby)) echo "selected"; ?>><?php _e('Date',post_grid_textdomain); ?></option>
                        <option value="rand" <?php if(in_array("rand",$query_orderby)) echo "selected"; ?>><?php _e('Random',post_grid_textdomain); ?></option>                    
                        <option value="comment_count" <?php if(in_array("comment_count",$query_orderby)) echo "selected"; ?>><?php _e('Comment Count',post_grid_textdomain); ?></option>
                        <option value="author" <?php if(in_array("author",$query_orderby)) echo "selected"; ?>><?php _e('Author',post_grid_textdomain); ?></option>               
                        <option value="title" <?php if(in_array("title",$query_orderby)) echo "selected"; ?>><?php _e('Title',post_grid_textdomain); ?></option>
                        <option value="name" <?php if(in_array("name",$query_orderby)) echo "selected"; ?>><?php _e('Name',post_grid_textdomain); ?></option>                    
                        <option value="type" <?php if(in_array("type",$query_orderby)) echo "selected"; ?>><?php _e('Type',post_grid_textdomain); ?></option>
                        <option value="menu_order" <?php if(in_array("menu_order",$query_orderby)) echo "selected"; ?>><?php _e('Menu order',post_grid_textdomain); ?></option>                       
                        <option value="meta_value" <?php if(in_array("meta_value",$query_orderby)) echo "selected"; ?>><?php _e('Meta Value',post_grid_textdomain); ?></option>
                        <option value="meta_value_num" <?php if(in_array("meta_value_num",$query_orderby)) echo "selected"; ?>><?php _e('Meta Value(number)',post_grid_textdomain); ?></option>
                        </select>
                        <br />
                        
                        
                        <input type="text" placeholder="meta_key" name="post_grid_meta_options[query_orderby_meta_key]" id="query_orderby_meta_key" value="<?php if(!empty($query_orderby_meta_key)) echo $query_orderby_meta_key; ?>" />
                    
                </div>                 
                
                
                
                <div class="option-box">
                    <p class="option-title"><?php _e('Search keyword',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('Query post by search keyword, please follow the reference https://codex.wordpress.org/Class_Reference/WP_Query#Search_Parameter',post_grid_textdomain); ?></p>
                    
                    <input type="text" placeholder="Keyword" name="post_grid_meta_options[keyword]" value="<?php if(!empty($keyword)) echo $keyword; else echo ''; ?>" />
                    
                </div>                
                
            </li>
            <li style="display: none;" class="box3 tab-box ">
            
                <div class="option-box">
                    <p class="option-title"><?php _e('Grid Layout',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('Fancy style layouts.',post_grid_textdomain); ?></p>
                    
                    
                    <label>
                    <input  type="radio" <?php if($grid_layout_name=='layout_grid') echo 'checked' ?> name="post_grid_meta_options[grid_layout][name]" value="layout_grid"><img title="N - N" src="<?php echo post_grid_plugin_url; ?>assets/admin/images/layout_grid.png" />
                    </label>                    
                    

                    
                </div> 
            
            
            
                <div class="option-box">
                    <p class="option-title"><?php _e('Content Layout',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('Choose your Content layout',post_grid_textdomain); ?></p>
                    
                    <?php
                    $class_post_grid_functions = new class_post_grid_functions();
					?>

                    <div class="layout-list">
                    <div class="idle  ">
                    <div class="name">Content
                    
                    <select class="select-layout-content" name="post_grid_meta_options[layout][content]" >
                    <?php
					
					$post_grid_layout_content = get_option('post_grid_layout_content');
					if(empty($post_grid_layout_content)){
						
						$layout_content_list = $class_post_grid_functions->layout_content_list();
						}
					else{
						
						$layout_content_list = $post_grid_layout_content;
						
						}
					
					
					
					
					
                    foreach($layout_content_list as $layout_key=>$layout_info){
						?>
                        <option <?php if($layout_content==$layout_key) echo 'selected'; ?>  value="<?php echo $layout_key; ?>"><?php echo $layout_key; ?></option>
                        <?php
						
						}
					?>
                    </select>
                    <a target="_blank" class="edit-layout" href="<?php echo admin_url().'edit.php?post_type=post_grid&page=post_grid_layout_editor&layout_content='.$layout_content;?>" >Edit</a>
                    </div>     
                    
                    <script>
						jQuery(document).ready(function($)
							{
								$(document).on('change', '.select-layout-content', function()
									{
						
										
										var layout = $(this).val();		
										
										$('.edit-layout').attr('href', '<?php echo admin_url().'edit.php?post_type=post_grid&page=post_grid_layout_editor&layout_content='; ?>'+layout);
										})
								
							})
					</script>
                    
                    
                    
                    
                    
                    
                    
                    <?php
					
					if(empty($layout_content)){
						$layout_content = 'flat-left';
						}
					
                    
					?>
                    
                                   
                    <div class="layer-content">
                    <div class="<?php echo $layout_content; ?>">
                    <?php
					$post_grid_layout_content = get_option( 'post_grid_layout_content' );
					
					if(empty($post_grid_layout_content)){
						$layout = $class_post_grid_functions->layout_content($layout_content);
						}
					else{
							if(!empty($post_grid_layout_content[$layout_content])){
								$layout = $post_grid_layout_content[$layout_content];
								}
							else{
								$layout = array();
								}
						
						
						}
					
                  //  $layout = $class_post_grid_functions->layout_content($layout_content);
					
					//var_dump($layout);
					
					foreach($layout as $item_key=>$item_info){
						
						$item_key = $item_info['key'];
						
						
						
						?>
                        

							<div class="item <?php echo $item_key; ?>" style=" <?php echo $item_info['css']; ?> ">
							
                            <?php
                            
							if($item_key=='thumb'){
								
								?>
                                <img style="width:100%; height:auto;" src="<?php echo post_grid_plugin_url; ?>assets/admin/images/thumb.png" />
                                <?php
								}
								
							elseif($item_key=='title'){
								
								?>
                                Lorem Ipsum is simply
                                
                                <?php
								}								
								
							elseif($item_key=='excerpt'){
								
								?>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text
                                <?php
								}								
								
								
								
							else{
								
								echo $item_info['name'];
								
								}
							
							?>
                            
                            
                            
                            </div>
							<?php
						}
					
					
					?>
                    </div>
                    </div>
                    </div>
                    <div class="hover">
                    <div class="name">
                    
                    <select class="select-layout-hover" name="post_grid_meta_options[layout][hover]" >
                    <?php
					
					
					
					
					$layout_hover_list = $class_post_grid_functions->layout_hover_list();
                    foreach($layout_hover_list as $layout_key=>$layout_info){
						?>
                        <option  value="<?php echo $layout_key; ?>"><?php echo $layout_key; ?></option>
                        <?php
						
						}
					?>
                    </select>
                    
                    Hover</div>
                    <div class="layer-hover">
                    <div class="title">Hello Title</div>
                    <div class="content">There are many variations of passages of Lorem Ipsum available, but the majority have.</div> 
                    </div>
 
                    
                    </div>                    
                    </div>

                </div> 
            
            
            
                <div class="option-box">

                    <p class="option-title"><?php _e('Skins',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('Select grid Skins',post_grid_textdomain); ?></p>
                    
                    
                    
                    
                    <?php
                    
					
					$skins = $class_post_grid_functions->skins();
					
					
					?>
                    
                    <div class="skin-list">
                    
                    <?php 
					//var_dump($skin);
					foreach($skins as $skin_slug=>$skin_info){
						
						?>
                        <div class="skin-container">
                        
                        
                        <?php
                        
						if($skin==$skin_slug){
							
							$checked = 'checked';
							$selected_skin = 'selected';							
							}
						else{
							$checked = '';
							$selected_skin = '';	
							}
						
						?>
                        <div class="checked <?php echo $selected_skin; ?>">
                        
                        <label><input <?php echo $checked; ?> type="radio" name="post_grid_meta_options[skin]" value="<?php echo $skin_slug; ?>" ><?php echo $skin_info['name']; ?></label>

                        
                        </div>
                        
                        
                        <div class="skin <?php echo $skin_slug; ?>">
                        
                        
                        <?php
                        
						include post_grid_plugin_dir.'skins/index.php';
						
						?>
                        </div>
                        </div>
                        <?php
						
						}
					
					?>
                    
                    
                    
                    </div>
                    
                    
                </div>
                 
            </li>
            <li style="display: none;" class="box4 tab-box ">
            
            
                <div class="option-box">
                    <p class="option-title"><?php _e('Masonry enable',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('Enable masonry style grid',post_grid_textdomain); ?></p>
					
                    <label><input <?php if($masonry_enable=='yes') echo 'checked'; ?> type="radio" name="post_grid_meta_options[masonry_enable]" value="yes" /><?php _e('Yes',post_grid_textdomain); ?></label><br />
                    <label><input <?php if($masonry_enable=='no') echo 'checked'; ?> type="radio" name="post_grid_meta_options[masonry_enable]" value="no" /><?php _e('No',post_grid_textdomain); ?></label><br />

                </div>
                
                
                <div class="option-box">
                    <p class="option-title"><?php _e('Lazy Load Enable',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('Gif animation when loading grid',post_grid_textdomain); ?></p>
					
                    <label><input <?php if($lazy_load_enable=='yes') echo 'checked'; ?> type="radio" name="post_grid_meta_options[lazy_load_enable]" value="yes" /><?php _e('Yes',post_grid_textdomain); ?></label><br />
                    <label><input <?php if($lazy_load_enable=='no') echo 'checked'; ?> type="radio" name="post_grid_meta_options[lazy_load_enable]" value="no" /><?php _e('No',post_grid_textdomain); ?></label><br />




                    <p class="option-info"><?php _e('Gif image source:',post_grid_textdomain); ?></p>
                    <img class="lazy_load_image" onClick="lazy_load_image_src(this)" src="<?php echo post_grid_plugin_url; ?>assets/admin/gif/ajax-loader-1.gif" />
                    <img class="lazy_load_image" onClick="lazy_load_image_src(this)" src="<?php echo post_grid_plugin_url; ?>assets/admin/gif/ajax-loader-2.gif" />
                    <img class="lazy_load_image" onClick="lazy_load_image_src(this)" src="<?php echo post_grid_plugin_url; ?>assets/admin/gif/ajax-loader-3.gif" />                     
                    
                    <br>
                    
                    <input type="text" id="lazy_load_image_src" class="lazy_load_image_src" name="post_grid_meta_options[lazy_load_image_src]" value="<?php echo $lazy_load_image_src; ?>" /> <div onClick="clear_lazy_load_src()" class="button clear-lazy-load-src"> Clear</div>
                    
                    <script>
					
					function lazy_load_image_src(img){
						
						
						src =img.src;
						
						document.getElementById('lazy_load_image_src').value  = src;
						
						}
					
					function clear_lazy_load_src(){

						document.getElementById('lazy_load_image_src').value  = '';
						
						}					
					
					
					</script>







                </div>                        
            
            
            
            
            
                <div class="option-box">
                    <p class="option-title"><?php _e('Grid Items Width',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('Grid item width for different device',post_grid_textdomain); ?></p>
					
                    
                    
                    <div class="">
                    Desktop:(min-width:1024px)<br>
                    <input type="text" name="post_grid_meta_options[width][desktop]" value="<?php echo $items_width_desktop; ?>" />
                  	</div>                      
                    <br>
                    <div class="">
                    Tablet:( min-width:768px )<br>
                    <input type="text" name="post_grid_meta_options[width][tablet]" value="<?php echo $items_width_tablet; ?>" />
                  	</div>                   
                    <br>
                    <div class="">
                    Mobile:( min-width : 320px, )<br>
                    <input type="text" name="post_grid_meta_options[width][mobile]" value="<?php echo $items_width_mobile; ?>" />
                  	</div>

                </div>
                
                

                
                
                <div class="option-box">
                    <p class="option-title"><?php _e('Grid Items Background color',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('Grid item Background color',post_grid_textdomain); ?></p>
                    
                    Background color type:<br>
                    <label><input <?php if($items_bg_color_type=='fixed') echo 'checked'; ?> type="radio" name="post_grid_meta_options[items_bg_color_type]" value="fixed" /><?php _e('Fixed',post_grid_textdomain); ?></label><br />

                    <br><br>
                   <?php _e('Fixed Background color:',post_grid_textdomain); ?> <br>
                    <input type="text" class="post-grid-color" name="post_grid_meta_options[items_bg_color]" value="<?php echo $items_bg_color; ?>" />

                </div>                
                
                <div class="option-box">
                    <p class="option-title"><?php _e('Grid Items Height',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('Grid item height',post_grid_textdomain); ?></p>
                    <label><input <?php if($items_height_style=='auto_height') echo 'checked'; ?> type="radio" name="post_grid_meta_options[item_height][style]" value="auto_height" /><?php _e('Auto height',post_grid_textdomain); ?></label><br />
                    <label><input <?php if($items_height_style=='fixed_height') echo 'checked'; ?> type="radio" name="post_grid_meta_options[item_height][style]" value="fixed_height" /><?php _e('Fixed height',post_grid_textdomain); ?></label><br />
                    <label><input <?php if($items_height_style=='max_height') echo 'checked'; ?> type="radio" name="post_grid_meta_options[item_height][style]" value="max_height" /><?php _e('Max height',post_grid_textdomain); ?></label><br />                    

                    <div class="">

                    <input type="text" name="post_grid_meta_options[item_height][fixed_height]" value="<?php echo $items_fixed_height; ?>" />
                  	</div>                      

                </div>  
                
                
                
                
                
                <div class="option-box">
                    <p class="option-title"><?php _e('Grid Items Margin',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('Grid item margin',post_grid_textdomain); ?></p>
                    
                    <div class="">
                    <input type="text" name="post_grid_meta_options[margin]" value="<?php echo $items_margin; ?>" />
                  	</div>                      

                </div>  
                
                
                
                
                <div class="option-box">
                    <p class="option-title"><?php _e('Media Height',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('Grid item media height',post_grid_textdomain); ?></p>
                    <label><input <?php if($items_media_height_style=='auto_height') echo 'checked'; ?> type="radio" name="post_grid_meta_options[media_height][style]" value="auto_height" /><?php _e('Auto height',post_grid_textdomain); ?></label><br />
                    <label><input <?php if($items_media_height_style=='fixed_height') echo 'checked'; ?> type="radio" name="post_grid_meta_options[media_height][style]" value="fixed_height" /><?php _e('Fixed height',post_grid_textdomain); ?></label><br />
                    <label><input <?php if($items_media_height_style=='max_height') echo 'checked'; ?> type="radio" name="post_grid_meta_options[media_height][style]" value="max_height" /><?php _e('Max height',post_grid_textdomain); ?></label><br />                    

                    <div class="">

                    <input type="text" name="post_grid_meta_options[media_height][fixed_height]" value="<?php echo $items_media_fixed_height; ?>" />
                  	</div>                      

                </div>                
                
                
                <div class="option-box">


					<?php


					$get_intermediate_image_sizes =  get_intermediate_image_sizes();

					
					?>



                    <p class="option-title"><?php _e('Featured Image size',post_grid_textdomain); ?></p>
                    <select name="post_grid_meta_options[featured_img_size]" >
                    
                    <?php
                    
					foreach($get_intermediate_image_sizes as $size_key){
						
						?>
                        <option value="<?php echo $size_key; ?>" <?php if($featured_img_size==$size_key)echo "selected"; ?>>
						
						
						<?php 
						
						$size_key = str_replace('_', ' ',$size_key);
						$size_key = str_replace('-', ' ',$size_key);						
						$size_key = ucfirst($size_key);

						echo $size_key; 
						
						?>
                        
                        </option>
                        
                        
                        <?php
						
						
						}
					
					?>
                    
    
                       
                    </select>
                    
                     <p class="option-title"><?php _e('Featured Image linked to post',post_grid_textdomain); ?></p>
                    <select name="post_grid_meta_options[thumb_linked]" >
                    <option value="yes" <?php if($thumb_linked=="yes")echo "selected"; ?>><?php _e('Yes',post_grid_textdomain); ?></option>
                    <option value="no" <?php if($thumb_linked=="no")echo "selected"; ?>><?php _e('No',post_grid_textdomain); ?></option>
      
                       
                    </select>                    
                    
                    
                    <p class="option-title"><?php _e('Media source',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('Grid item media source <br />N.B. First gallery from content, First youtube video from content, First vimeo video from content, First MP3 from content, First SoundCloud from content will not retrive for "page"',post_grid_textdomain); ?></p>
                	<?php
                    if(empty($media_source)){
						
						$media_source = $class_post_grid_functions->media_source();
						}
					else{
						//$media_source_main = $class_post_grid_functions->media_source();
						$media_source = $media_source;
						
						}
					
					
					?>
                
                
                
                
                    
                    <div class="media-source-list expandable">
                    	
                        <?php
                        foreach($media_source as $source_key=>$source_info){
							?>
							<div class="items">
                                <div class="header">
                                <input type="hidden" name="post_grid_meta_options[media_source][<?php echo $source_info['id']; ?>][id]" value="<?php echo $source_info['id']; ?>" />
                                <input type="hidden" name="post_grid_meta_options[media_source][<?php echo $source_info['id']; ?>][title]" value="<?php echo $source_info['title']; ?>" />
                                <label>
                                <input <?php if(!empty($source_info['checked'])) echo 'checked'; ?> type="checkbox" name="post_grid_meta_options[media_source][<?php echo $source_info['id']; ?>][checked]" value="yes" />                                
                                                           
                                
                                <?php echo $source_info['title']; ?>
                                
                                </label>
                                </div>
                            </div>
	
							<?php
							
							
							}
						
						?>
                        
                        
                                           
                        
                        
                    
                  	</div>                      

<script>
jQuery(document).ready(function($)
	{
		$( ".media-source-list" ).sortable({revert: "invalid"});

	})
</script>

                </div>                 
                

                
                <div class="option-box">
                    <p class="option-title"><?php _e('Grid Container options',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('Grid container ',post_grid_textdomain); ?></p>
                    
                    <div class="">
                    Padding: <br>
                    <input type="text" name="post_grid_meta_options[container][padding]" value="<?php echo $container_padding; ?>" />
                  	</div>
                     <br>
                    <div class="">
                    Background color: <br>
                    <input type="text" class="post-grid-color" name="post_grid_meta_options[container][bg_color]" value="<?php echo $container_bg_color; ?>" />
                  	</div>
                    <br>
                    <div class="">
                    Background image: <br>
                    <img class="bg_image_src" onClick="bg_img_src(this)" src="<?php echo post_grid_plugin_url; ?>assets/admin/bg/dark_embroidery.png" />
                    <img class="bg_image_src" onClick="bg_img_src(this)" src="<?php echo post_grid_plugin_url; ?>assets/admin/bg/dimension.png" />
                    <img class="bg_image_src" onClick="bg_img_src(this)" src="<?php echo post_grid_plugin_url; ?>assets/admin/bg/eight_horns.png" />                     
                    
                    <br>
                    
                    <input type="text" id="container_bg_image" class="container_bg_image" name="post_grid_meta_options[container][bg_image]" value="<?php echo $container_bg_image; ?>" /> <div onClick="clear_container_bg_image()" class="button clear-container-bg-image"> Clear</div>
                    
                    <script>
					
					function bg_img_src(img){
						
						src =img.src;
						
						document.getElementById('container_bg_image').value  = src;
						
						}
					
					function clear_container_bg_image(){

						document.getElementById('container_bg_image').value  = '';
						
						}					
					
					
					</script>
                    
                    
                    
                    
                  	</div>                    
                    
                                                        

                </div>                           
            
            
            </li>
            <li style="display: none;" class="box5 tab-box ">
            
            
            
                <div class="option-box">
                    <p class="option-title"><?php _e('Grid Type',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('Select grid type.',post_grid_textdomain); ?></p>
                    
                    <div class="grid-canvas">
                    	
                        
                            
                         	<label><input class="grid_type" <?php if($grid_type=='grid') echo 'checked'; ?>  type="radio" name="post_grid_meta_options[grid_type]" value="grid" />Grid</label>    

                    
                    	<div class="grid-preview">
                        	
                            <div class="grid-type-grid grid-type" style="display:<?php if($grid_type=='grid') echo 'block'; else echo 'none'; ?>" >
                            
                                	<div class="nav-top-search">
                                    	<input type="text" placeholder="Search" value="" />
                                        
                                    </div>
                                    
<!-- 
                                	<div class="per-page-count">
                                    	<select >
                                        	<option >10</option>
                                        	<option >20</option>                                            
                                        	<option >30</option>                                            
                                        </select>
                                        
                                    </div> 

-->                                   
                                    
                            
                            
                            	<div class="items">
                                    <div class="item">
									<?php
                                    
                                    include post_grid_plugin_dir.'skins/index.php';
                                    ?>
                                    </div>
                                    
                                    <div class="item">
									<?php
                                    
                                    include post_grid_plugin_dir.'skins/index.php';
                                    ?>
                                    </div>                                    
                                    
                                    <div class="item">
									<?php
                                    
                                    include post_grid_plugin_dir.'skins/index.php';
                                    ?>
                                    </div>
                                </div>
                                
                                
                            	<div class="pagination">
                                
                                	<div class="pagination-none pagination-type">
                                    	
                                    </div>            
                                                        
                                	<div class="pagination-normal pagination-type">
                                    	<div class="page">Next </div><div class="page">1</div><div class="page">2</div><div class="page">3</div><div class="page">Prev </div>
                                    </div>
                                    
                                	<div class="pagination-jquery pagination-type">
                                    	<div class="page"><i class="fa fa-angle-double-left"></i></div><div class="page">1</div><div class="page">2</div><div class="page">3</div><div class="page"> <i class="fa fa-angle-double-right"></i></div>
                                    </div>
                                    
                                	<div class="pagination-loadmore pagination-type">
                                    	<div class="page">Load more</div>
                                    </div>                                    
                                                                      
                                	<div class="pagination-infinite pagination-type">
                                    	<div class="page">Infinite Scroll <i class="fa fa-arrow-down"></i></div>
                                    </div>                                     
                                
                                </div>                               
                                
                            </div>
                            
                            <div class="grid-type-filterable grid-type" style="display:<?php if($grid_type=='filterable') echo 'block'; else echo 'none'; ?>">
                            
                            	<div class="filter-menu yes">
                                	<div class="filter">All</div><div class="filter">Menu 1</div><div class="filter">Menu 2</div><div class="filter">Menu 3</div>
                                </div>   
                            
                            
                            	<div class="items">
                                	
                                    <div class="item">
									<?php
                                    
                                    include post_grid_plugin_dir.'skins/index.php';
                                    ?>
                                    </div>
                                    
                                    <div class="item">
									<?php
                                    
                                    include post_grid_plugin_dir.'skins/index.php';
                                    ?>
                                    </div>                                    
                                    
                                    <div class="item">
									<?php
                                    
                                    include post_grid_plugin_dir.'skins/index.php';
                                    ?>
                                    </div>                                    
                                    
                                    
                                    
                                    
                                	
                                </div>
                            
                            	<div class="pagination">
                                
                                	<div class="pagination-none pagination-type">
                                    	
                                    </div>            
                                    
                                	<div class="pagination-jquery pagination-type">
                                    	<div class="page"><i class="fa fa-angle-double-left"></i></div><div class="page">1</div><div class="page">2</div><div class="page">3</div><div class="page"> <i class="fa fa-angle-double-right"></i></div>
                                    </div>
                                                                         
                                
                                </div>
                            
                            
                            </div>                            
                        
                            <div class="grid-type-slider grid-type" style="display:<?php if($grid_type=='slider') echo 'block'; else echo 'none'; ?>">
                            
                            	<div class="navs slider-navs <?php echo $slider_navs_positon; ?>" style="display:<?php if($slider_navs=='true') echo 'block'; else echo 'none'; ?>">
                                	<div class="nav next"><i class="fa fa-angle-double-right"></i></div>
                                	<div class="nav prev"><i class="fa fa-angle-double-left"></i> </div>                                    
                                    
                                </div>
                            
                            	<div class="items">
                                    <div class="item">
									<?php
                                    
                                    include post_grid_plugin_dir.'skins/index.php';
                                    ?>
                                    </div>
                                    
                                    <div class="item">
									<?php
                                    
                                    include post_grid_plugin_dir.'skins/index.php';
                                    ?>
                                    </div>                                    
                                    
                                    <div class="item">
									<?php
                                    
                                    include post_grid_plugin_dir.'skins/index.php';
                                    ?>
                                    </div>
                                </div>
                            
                            	<div class="dots slider-dots <?php echo $slider_dots_style; ?>" style="display:<?php if($slider_dots=='true') echo 'block'; else echo 'none'; ?>" >
                                <div class="dot"></div><div class="dot"></div><div class="dot"></div>
                                </div>  
                            
                            
                            </div>                          
                        
                        </div>
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    </div>
                    
                    
                    
               </div>        
            
            
            
            
            
            
            
                <div class="option-box">
                    <p class="option-title"><?php _e('Navigation',post_grid_textdomain); ?></p>
                    
          
                    
                    
                    <p class="option-info"><?php _e('Pagination.',post_grid_textdomain); ?></p>
                    <label><input class="pagination_type" <?php if($pagination_type=='none') echo 'checked'; ?>  type="radio" name="post_grid_meta_options[nav_bottom][pagination_type]" value="none" />None</label>                       
                    <label><input class="pagination_type" <?php if($pagination_type=='normal') echo 'checked'; ?> type="radio" name="post_grid_meta_options[nav_bottom][pagination_type]" value="normal" />Normal Pagination</label>





                    <p class="option-info"><?php _e('Search.',post_grid_textdomain); ?></p>
                    <label><input class="nav_top_search" <?php if($nav_top_search=='yes') echo 'checked'; ?>  type="radio" name="post_grid_meta_options[nav_top][search]" value="yes" />Yes</label>
                    <label><input class="nav_top_search" <?php if($nav_top_search=='no') echo 'checked'; ?>  type="radio" name="post_grid_meta_options[nav_top][search]" value="no" />No</label>







                    
                </div>
                
                <div class="option-box">
                
                    <p class="option-title"><?php _e('Pagination',post_grid_textdomain); ?></p>
                                   
                    <p class="option-info"><?php _e('Max number of pagination, keep 0 (zero) for auto.',post_grid_textdomain); ?></p>
					<input type="text" name="post_grid_meta_options[pagination][max_num_pages]" value="<?php echo $max_num_pages; ?>" />


                    <p class="option-info"><?php _e('Pagination Previous text',post_grid_textdomain); ?></p>
					<input type="text" name="post_grid_meta_options[pagination][prev_text]" value="<?php echo $pagination_prev_text; ?>" />
                    
                    
                    <p class="option-info"><?php _e('Pagination Next text',post_grid_textdomain); ?></p>
					<input type="text" name="post_grid_meta_options[pagination][next_text]" value="<?php echo $pagination_next_text; ?>" />
                    
                    <p class="option-info"><?php _e('Pagination themes',post_grid_textdomain); ?></p>
                      
                    <label><input <?php if($pagination_theme=='lite') echo 'checked'; ?> type="radio" name="post_grid_meta_options[nav_bottom][pagination_theme]" value="lite" /><?php _e('Lite',post_grid_textdomain); ?></label>
                    <label><input <?php if($pagination_theme=='dark') echo 'checked'; ?> type="radio" name="post_grid_meta_options[nav_bottom][pagination_theme]" value="dark" /><?php _e('Dark',post_grid_textdomain); ?></label>     
                    

                </div>                 
                
             
                
 
                
            
            </li>
            
            <li style="display: none;" class="box6 tab-box ">
            
                <div class="option-box">
                    <p class="option-title"><?php _e('Custom Js',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('Add your custom js',post_grid_textdomain); ?></p>
                    
                    <textarea id="custom_js" name="post_grid_meta_options[custom_js]" ><?php echo $custom_js; ?></textarea>

                </div>
                
                
                <div class="option-box">
                    <p class="option-title"><?php _e('Custom CSS',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('Add your custom CSS',post_grid_textdomain); ?></p>
                    
                    <textarea id="custom_css" name="post_grid_meta_options[custom_css]" ><?php echo $custom_css; ?></textarea>
                    

                </div>                
                
    <script>
	

		var editor = CodeMirror.fromTextArea(document.getElementById("custom_js"), {
		  lineNumbers: true,
		  scrollbarStyle: "simple"
		});
		
		var editor = CodeMirror.fromTextArea(document.getElementById("custom_css"), {
		  lineNumbers: true,
		  scrollbarStyle: "simple"
		});		
		


    </script>
                
                
                
                
            
            </li>
            
            
        </ul>

    
    </div>
    
    
   
    
<?php


	
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function meta_boxes_post_grid_save( $post_id ) {

  /*
   * We need to verify this came from the our screen and with proper authorization,
   * because save_post can be triggered at other times.
   */

  // Check if our nonce is set.
  if ( ! isset( $_POST['meta_boxes_post_grid_input_nonce'] ) )
    return $post_id;

  $nonce = $_POST['meta_boxes_post_grid_input_nonce'];

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $nonce, 'meta_boxes_post_grid_input' ) )
      return $post_id;

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return $post_id;



	/* OK, its safe for us to save the data now. */
	
	// Sanitize user input.
	$post_grid_meta_options = stripslashes_deep( $_POST['post_grid_meta_options'] );
	update_post_meta( $post_id, 'post_grid_meta_options', $post_grid_meta_options );	
	
		
}
add_action( 'save_post', 'meta_boxes_post_grid_save' );






?>