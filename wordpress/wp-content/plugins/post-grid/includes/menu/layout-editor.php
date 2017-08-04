<?php	


/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access



if(empty($_POST['post_grid_hidden']))
	{
		$post_grid_layout_content = get_option( 'post_grid_layout_content' );


	}
else
	{	
		$nonce = $_POST['_wpnonce'];

	
		if(wp_verify_nonce( $nonce, 'nonce_layout_content' ) && $_POST['post_grid_hidden'] == 'Y')  {
			//Form data sent
			
			//$post_grid_layout_content = stripslashes_deep($_POST['post_grid_layout_content']);			
			$post_grid_layout_content = get_option( 'post_grid_layout_content' );
			
			if(empty($post_grid_layout_content)){
				$post_grid_layout_content = array();
				}
				
			if(!empty($_POST['post_grid_layout_content']) && is_array($_POST['post_grid_layout_content'])){
				
				//var_dump($_POST['post_grid_layout_content']);
				
				$post_grid_layout_content_new = stripslashes_deep($_POST['post_grid_layout_content']);
				}
			else{
				$post_grid_layout_content_new = array();
				}
				
			
			$post_grid_layout_content = array_merge($post_grid_layout_content, $post_grid_layout_content_new);
			update_option('post_grid_layout_content', $post_grid_layout_content);
		

			?>
			<div class="updated"><p><strong><?php _e('Changes Saved.', post_grid_textdomain ); ?></strong></p></div>
	
			<?php
			} 
		else{
			?>
			<div class="updated"><p><strong><?php _e('Something is not right.', post_grid_textdomain ); ?></strong></p></div>
	
			<?php
			
			}
			
			
			
	}

?>

<div class="wrap">

	<div id="icon-tools" class="icon32"><br></div><?php echo "<h2>".post_grid_plugin_name.__(' - Layout Editor', post_grid_textdomain)."</h2>";?>
		<form  method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
            <input type="hidden" name="post_grid_hidden" value="Y">
            <?php //settings_fields( 'post_grid_plugin_options' );
                   // do_settings_sections( 'post_grid_plugin_options' );
                
				
				if(!empty($_GET['layout_content'])){
					$layout_content = sanitize_text_field($_GET['layout_content']); 
					}
				else{
					$layout_content = 'flat'; 
					}
				
				
				//var_dump($layout_content);
				
				$class_post_grid_functions = new class_post_grid_functions();
				
            ?>
		<div class="layout-editor post-grid-layout-editor para-settings">
        
        
        
			<?php
            
            ?>

            <div class="layout-items">
            
            <?php
            
            $layout_items = $class_post_grid_functions->layout_items();
            
            foreach($layout_items as $item_key=>$name){
                
                ?>
                <div class="item" layout="<?php echo $layout_content; ?>" item_key="<?php echo $item_key; ?>" ><i class="fa fa-plus"></i> <?php echo $name; ?></div>
                <?php
                
                }
            ?>
            
            </div>


            
            <div class="layout-list">
            
            <?php if(isset($_GET['layout_content'])) {?>
                <div class="idle  ">
                <div class="name">Content: <?php echo $layout_content; ?></div>     
       
                <div class="layer-content">
                <div id="layout-container" class="<?php echo $layout_content; ?>">
                <?php
                
                
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
                            
                        elseif($item_key=='thumb_link'){
                            
                            ?>
                            <a href="#"><img style="width:100%; height:auto;" src="<?php echo post_grid_plugin_url; ?>assets/admin/images/thumb.png" /></a>
                            <?php
                            }								
							
							
                        elseif($item_key=='title'){
                            
                            ?>
                            Lorem Ipsum is simply
                            <?php
                            }	
							
                        elseif($item_key=='title_link'){
                            
                            ?>
                            <a href="#">Lorem Ipsum is simply</a>
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
                
                <?php } ?>
                   
            </div>
                    
        	<br />
            <div class="css-editor expandable">
            
                <?php
				
				$layout_content_list = $class_post_grid_functions->layout_content_list();
				
				
					if(empty($layout)){$layout = array(); 
					
					echo 'you haven\'t selected any layout. please select here';
					
					
					?>
					<select class="layout-content">
                    <option selected value=""></option>                    
                    <option value="create-new">Create New</option>
						<?php
                        
					$post_grid_layout_content = get_option('post_grid_layout_content');
					if(empty($post_grid_layout_content)){
						
						$layout_content_list = $class_post_grid_functions->layout_content_list();
						}
					else{
						
						$layout_content_list = $post_grid_layout_content;
						
						}
						
						
                       // $layout_content_list = $class_post_grid_functions->layout_content_list();
                        foreach($layout_content_list as $layout_key=>$layout_info){
                            ?>
                            <option <?php if($layout_content==$layout_key) echo 'selected'; else "" ?>  value="<?php echo $layout_key; ?>"><?php echo $layout_key; ?></option>
                            <?php
                            
                            }
                        ?>
					</select>
	
   
<script>
jQuery(document).ready(function($)
	{
		
		$(document).on('change', '.layout-content', function()
			{

				var layout = $(this).val();
				
				if(layout=='create-new'){
					
					layout = prompt('(Must be unique) Layout name ?');
					
					//layout = $.now();
					
					if(layout!=null){
						window.location.href = "<?php echo admin_url().'edit.php?post_type=post_grid&page=post_grid_layout_editor&layout_content=';?>"+layout;
						}
					
					
					}
				else{
					window.location.href = "<?php echo admin_url().'edit.php?post_type=post_grid&page=post_grid_layout_editor&layout_content=';?>"+layout;
					}
				
				
				
					
			})
		
		})
</script>
    
    
                    
                    <?php
					
					
					
					
					}
					$i=0;
					foreach($layout as $key=>$items){
						
						?>
                        <div class="items" id="<?php echo $key; ?>">
                        <div class="header"><span class="remove"><i class="fa fa-times"></i></span><?php echo $items['name']; ?></div>
                        	<div class="options">
							<?php
                            
                             foreach($items as $item_key=>$item_info){
                                 

								 if($item_key=='css'){
									 
									?>
	<br />
    								<?php _e('CSS:',post_grid_textdomain ); ?> <br />
                                    <a target="_blank" href="http://www.pickplugins.com/demo/post-grid/sample-css-for-layout-editor/">Sample css</a><br />
									<textarea autocorrect="off" autocapitalize="off" spellcheck="false"  style="width:50%" class="custom_css" item_id="<?php echo $items['key']; ?>" name="post_grid_layout_content[<?php echo $layout_content; ?>][<?php echo $i; ?>][<?php echo $item_key; ?>]"><?php echo $item_info; ?></textarea><br />
		
									
		
									<?php
									 
									 
									 
									 
									 
									 }
								elseif($item_key=='css_hover'){
									 
									?>
								<br />
    								 <?php _e('CSS Hover:',post_grid_textdomain ); ?><br />
                                    
									<textarea autocorrect="off" autocapitalize="off" spellcheck="false"  style="width:50%" class="custom_css" item_id="<?php echo $items['key']; ?>" name="post_grid_layout_content[<?php echo $layout_content; ?>][<?php echo $i; ?>][<?php echo $item_key; ?>]"><?php echo $item_info; ?></textarea><br />
		
									
		
									<?php
									 
									 
									 
									 
									 
									 }
									  
								elseif($item_key=='char_limit'){
										?>
                                        	
                                        	<?php _e('Character limit:',post_grid_textdomain ); ?> <br />
											<input type="text"  name="post_grid_layout_content[<?php echo $layout_content; ?>][<?php echo $i; ?>][<?php echo $item_key; ?>]" value="<?php echo $items['char_limit']; ?>" /><br /><br />
	
										<?php
										
										} 
									 
									 
								elseif($item_key=='link_target'){
									
									
									//var_dump($items['link_target']);
										?>
                                        	
                                        	<?php _e('Link target:',post_grid_textdomain ); ?> <br />
                                            
                                        <select name="post_grid_layout_content[<?php echo $layout_content; ?>][<?php echo $i; ?>][<?php echo $item_key; ?>]" >
                                        
                                        <option <?php if($items['link_target']=='_blank') echo 'selected'; ?> value="_blank">_blank</option>
                                        <option <?php if($items['link_target']=='_parent') echo 'selected'; ?> value="_parent">_parent</option>
                                        <option <?php if($items['link_target']=='_self') echo 'selected'; ?> value="_self">_self</option>
                                        <option <?php if($items['link_target']=='_top') echo 'selected'; ?> value="_top">_top</option>
                                        <option <?php if($items['link_target']=='new') echo 'selected'; ?> value="new">new</option>
                                        </select> 
                                        <br />                             
                                            
											
	
										<?php
										
										} 									 
									 
									 
									 
									 
									 
									 
									 
									 
									 
								else{
									?>
										<input type="hidden"  name="post_grid_layout_content[<?php echo $layout_content; ?>][<?php echo $i; ?>][<?php echo $item_key; ?>]" value="<?php echo $item_info; ?>" />

									<?php

									}
									
									if($item_key=='field_id'){
										?>
                                        	
                                        	<?php _e('Meta Key:',post_grid_textdomain ); ?> <br />
											<input type="text"  name="post_grid_layout_content[<?php echo $layout_content; ?>][<?php echo $i; ?>][<?php echo $item_key; ?>]" value="<?php echo $item_info; ?>" /><br />
	
										<?php
										
										}
										
									if($item_key=='wrapper'){
										?>
                                        	
                                            
                                            <?php //var_dump($item_info);
											
											$key_value = htmlentities($item_info);
											
											if(empty($key_value)){
												$key_value = '%s';
												}
											
											 ?>
                                            <br />
                                        	<?php _e('Wrapper:',post_grid_textdomain ); ?>  
                                            <br />
                                            <?php _e('use %s where you want to repalce the meta value.<pre>&lt;div&gt;Before %s - %s After&lt;/div&gt;</pre>',post_grid_textdomain ); ?>
                                            <br />
											<input type="text"  name="post_grid_layout_content[<?php echo $layout_content; ?>][<?php echo $i; ?>][<?php echo $item_key; ?>]" value="<?php echo $key_value; ?>" /><br />
	
										<?php
										
										}										
										
										
									if($item_key=='html'){
										?>
                                        	
                                            
                                            <?php //var_dump($item_info);
											
											$custom_html = htmlentities($item_info);
											
											if(empty($custom_html)){
												$custom_html = '';
												}
											
											 ?>
                                            <br />
                                        	<?php _e('HTML:', post_grid_textdomain ); ?><br />
											<input type="text"  name="post_grid_layout_content[<?php echo $layout_content; ?>][<?php echo $i; ?>][<?php echo $item_key; ?>]" value="<?php echo $custom_html; ?>" /><br />
	
										<?php
										
										}										
										
										
										
										
										
										

									if($item_key=='read_more_text'){
										?>
                                        	
                                        	<?php _e('Read more text:',post_grid_textdomain ); ?> <br />
											<input type="text"  name="post_grid_layout_content[<?php echo $layout_content; ?>][<?php echo $i; ?>][<?php echo $item_key; ?>]" value="<?php echo htmlentities($item_info); ?>" /><br />
	
										<?php
										
										}										
                                
                                 }
                            ?>
							</div>
                        </div>
                        
                        <?php
						
						 $i++;
						}
				
				?>
            
            </div>
        
       
        
        </div>
    


 <script>
 jQuery(document).ready(function($)
	{
		$(function() {
		$( ".css-editor" ).sortable({ handle: '.header' });
		//$( ".items-container" ).disableSelection();
		});

})

</script>

        <p class="submit">
        
        	<?php wp_nonce_field( 'nonce_layout_content' ); ?>
            
            <input class="button button-primary" type="submit" name="Submit" value="<?php _e('Save Changes',post_grid_textdomain ); ?>" />
        </p>


		</form>


</div>
