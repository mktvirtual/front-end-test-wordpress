<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access








/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function post_grid_post_settings()
	{
		
		$post_types = get_post_types();
		unset($post_types['post_grid']);
		
		$screens = $post_types;
		foreach ( $screens as $screen )
			{
				add_meta_box('post_grid_post_settings',__( 'Post Grid - Post Options',post_grid_textdomain),'post_grid_post_settings_input', $screen);
			}
	}
add_action( 'add_meta_boxes', 'post_grid_post_settings' );


function post_grid_post_settings_input( $post ) {
	
	global $post;
	wp_nonce_field( 'post_grid_post_settings_input', 'post_grid_post_settings_input_nonce' );
	
	
	$post_grid_post_settings = get_post_meta( $post->ID, 'post_grid_post_settings', true );
	

	if(!empty($post_grid_post_settings['post_skin'])){
		$post_skin = $post_grid_post_settings['post_skin'];
		}
	else{
		$post_skin = 'flat';
		}	
	
	if(!empty($post_grid_post_settings['custom_thumb_source'])){
		$custom_thumb_source = $post_grid_post_settings['custom_thumb_source'];
		}
	else{
		$custom_thumb_source = post_grid_plugin_url.'assets/frontend/css/images/placeholder.png';
		}	
	
	
	if(!empty($post_grid_post_settings['font_awesome_icon'])){
		$font_awesome_icon = $post_grid_post_settings['font_awesome_icon'];
		}
	else{
		$font_awesome_icon = '';
		}		
	
	
	if(!empty($post_grid_post_settings['font_awesome_icon_color'])){
		$font_awesome_icon_color = $post_grid_post_settings['font_awesome_icon_color'];
		}
	else{
		$font_awesome_icon_color = '#737272';
		}
		
	if(!empty($post_grid_post_settings['font_awesome_icon_size'])){
		$font_awesome_icon_size = $post_grid_post_settings['font_awesome_icon_size'];
		}
	else{
		$font_awesome_icon_size = '50px';
	}
	
	
		
	if(!empty($post_grid_post_settings['custom_youtube_id'])){
		$custom_youtube_id = $post_grid_post_settings['custom_youtube_id'];
		}
	else{
		$custom_youtube_id = '';
	}	
		
		
		
	if(!empty($post_grid_post_settings['custom_vimeo_id'])){
		$custom_vimeo_id = $post_grid_post_settings['custom_vimeo_id'];
		}
	else{
		$custom_vimeo_id = '';
	}	


	if(!empty($post_grid_post_settings['custom_dailymotion_id'])){
		$custom_dailymotion_id = $post_grid_post_settings['custom_dailymotion_id'];
		}
	else{
		$custom_dailymotion_id = '';
	}



	if(!empty($post_grid_post_settings['custom_mp3_url'])){
		$custom_mp3_url = $post_grid_post_settings['custom_mp3_url'];
		}
	else{
		$custom_mp3_url = '';
	}	


	if(!empty($post_grid_post_settings['custom_soundcloud_id'])){
		$custom_soundcloud_id = $post_grid_post_settings['custom_soundcloud_id'];
		}
	else{
		$custom_soundcloud_id = '';
	}	


//var_dump($post_skin);
	
	

		
		
		
		
		
		
		
		
		
?>

    <div class="para-settings post-grid-metabox">



        <ul class="tab-nav"> 
            <li nav="1" class="nav1 active"><i class="fa fa-code"></i> <?php _e('Options',post_grid_textdomain); ?></li>
            
            
            <li nav="2" class="nav2"><i class="fa fa-bookmark-o"></i> <?php _e('Font Awesome',post_grid_textdomain); ?></li>
            <li nav="3" class="nav3"><i class="fa fa-play"></i> <?php _e('Custom Media',post_grid_textdomain); ?></li>           
            
                     
                       
        </ul> <!-- tab-nav end -->
        
		<ul class="box">
            <li style="display: block;" class="box1 tab-box active">
                <div class="option-box">
                    <p class="option-title"><?php _e('Post Skin',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('Default skin for this post only',post_grid_textdomain); ?></p>
                    

                    
                    
                    <select class="post_skin" name="post_grid_post_settings[post_skin]">
                    <option value="" <?php if($post_skin=='') echo "selected"; ?>>None</option>
                    	<?php
                        
						$class_post_grid_functions = new class_post_grid_functions();
						$post_grid_skins = $class_post_grid_functions->skins();
						
						//var_dump($post_grid_skins);
						
						foreach($post_grid_skins as $skin_key=>$skin_data){
							
							?>
                            <option value="<?php echo $skin_key; ?>" <?php if($post_skin==$skin_key) echo "selected"; ?>><?php echo $skin_data['name']; ?></option>
                            <?php
							
							
							}
						
						?>

                                          
                    </select> 
                    
                </div>
                
                
                
                <div class="option-box">
                    <p class="option-title"><?php _e('Custom thumbnail source',post_grid_textdomain); ?></p>
                    <p class="option-info"></p>
					<input type="text" name="post_grid_post_settings[custom_thumb_source]" value="<?php echo $custom_thumb_source; ?>" />
                    
                </div>                
                
                
                
                
                
                 
            </li>
            <li style="display: none;" class="box2 tab-box">
            
                <div class="option-box">
                    <p class="option-title"><?php _e('Font awesome icon ID',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('Font awesome icon id, ex: <b>fa-share-alt</b> , please check font awesome incon here <a href="http://fortawesome.github.io/Font-Awesome/icons/">http://fortawesome.github.io/Font-Awesome/icons/</a>',post_grid_textdomain); ?></p>
					<input placeholder="fa-share-alt" type="text" name="post_grid_post_settings[font_awesome_icon]" value="<?php echo $font_awesome_icon; ?>" />
                    
                    <p class="option-info"><?php _e('Icon Color',post_grid_textdomain); ?></p>
					<input placeholder="" class="color" type="text" name="post_grid_post_settings[font_awesome_icon_color]" value="<?php echo $font_awesome_icon_color; ?>" />                    
                    <p class="option-info"><?php _e('Icon size',post_grid_textdomain); ?></p>
					<input placeholder="50px" type="text" name="post_grid_post_settings[font_awesome_icon_size]" value="<?php echo $font_awesome_icon_size; ?>" />                    
                    
                </div> 
            
            </li>
            
            <li style="display: none;" class="box3 tab-box">
            
                <div class="option-box">
                    <p class="option-title"></p>
                    <p class="option-info"><?php _e('Custom youtube id',post_grid_textdomain); ?></p>
                    <input placeholder="S97MaG3kOMY" type="text" name="post_grid_post_settings[custom_youtube_id]" value="<?php echo $custom_youtube_id; ?>" /> 
                    
                    
                    <p class="option-info"><?php _e('Custom vimeo id',post_grid_textdomain); ?></p>
                    <input placeholder="152379391" type="text" name="post_grid_post_settings[custom_vimeo_id]" value="<?php echo $custom_vimeo_id; ?>" />
                    
                    <p class="option-info"><?php _e('Custom dailymotion id',post_grid_textdomain); ?></p>
                    <input placeholder="x4693dw" type="text" name="post_grid_post_settings[custom_dailymotion_id]" value="<?php echo $custom_dailymotion_id; ?>" />                    
                    
                    
                    <p class="option-info"><?php _e('Custom mp3 URL',post_grid_textdomain); ?></p>
                    <input placeholder="http://hello.com/file/song.mp3" type="text" name="post_grid_post_settings[custom_mp3_url]" value="<?php echo $custom_mp3_url; ?>" />                                        
                    
                    <p class="option-info"><?php _e('Custom soundcloud ID',post_grid_textdomain); ?></p>
                    <input placeholder="237668695" type="text" name="post_grid_post_settings[custom_soundcloud_id]" value="<?php echo $custom_soundcloud_id; ?>" />                     
                    
                    
                    
                    
                    
                </div> 
            
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
function post_grid_post_settings_save( $post_id ) {

  /*
   * We need to verify this came from the our screen and with proper authorization,
   * because save_post can be triggered at other times.
   */

  // Check if our nonce is set.
  if ( ! isset( $_POST['post_grid_post_settings_input_nonce'] ) )
    return $post_id;

  $nonce = $_POST['post_grid_post_settings_input_nonce'];

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $nonce, 'post_grid_post_settings_input' ) )
      return $post_id;

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return $post_id;



	/* OK, its safe for us to save the data now. */
	
	// Sanitize user input.
	$post_grid_post_settings = stripslashes_deep( $_POST['post_grid_post_settings'] );
	update_post_meta( $post_id, 'post_grid_post_settings', $post_grid_post_settings );	
	
		
}
add_action( 'save_post', 'post_grid_post_settings_save' );





