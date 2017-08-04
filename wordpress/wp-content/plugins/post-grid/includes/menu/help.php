<?php	


/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access


?>





<div class="wrap">

	<div id="icon-tools" class="icon32"><br></div><?php echo "<h2>".post_grid_plugin_name.__(' - Settings', post_grid_textdomain)."</h2>";?>
		<form  method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="post_grid_hidden" value="Y">
        <?php settings_fields( 'post_grid_plugin_options' );
				do_settings_sections( 'post_grid_plugin_options' );
			
		?>

    <div class="para-settings post-grid-settings">
    
        <ul class="tab-nav"> 
      
            <li nav="1" class="nav1 active"><?php _e('Help & support',post_grid_textdomain ); ?></li>       
   
        </ul> <!-- tab-nav end --> 
		<ul class="box">

            <li style="display: block;" class="box2 tab-box active">
				<div class="option-box">
                    <p class="option-title"><?php _e('Need Help ?',post_grid_textdomain ); ?></p>
                    <p class="option-info"><?php _e('Feel free to contact with any issue for this plugin, Ask any question via forum',post_grid_textdomain ); ?> <a href="<?php echo post_grid_qa_url; ?>"><?php echo post_grid_qa_url; ?></a><br />

					<?php
                
                    if(post_grid_customer_type=="free")
                        {
                    
                            echo 'You are using <strong> '.post_grid_customer_type.' version  '.post_grid_version.'</strong> of <strong>'.post_grid_plugin_name.'</strong>, To get more feature you could try our premium version. ';
                            echo '<br /><a href="'.post_grid_pro_url.'">'.post_grid_pro_url.'</a>';
                            
                        }
                    else
                        {
                    
                            echo 'Thanks for using <strong> premium version  '.post_grid_version.'</strong> of <strong>'.post_grid_plugin_name.'</strong> ';	
                            
                            
                        }
                    
                     ?>       

                    
                    </p>

                </div>
                
                
				<div class="option-box">
                    <p class="option-title"><?php _e('Video Tutorial',post_grid_textdomain ); ?></p>
                    <p class="option-info"><?php _e('Please watch video tutorial, some features may not available in Free version.',post_grid_textdomain ); ?></p>
                    
                    <div class="tutorials expandable">
                    	<div class="items">
                        	<div class="header "><i class="fa fa-play"></i>  <?php _e('How to install activate & license',post_grid_textdomain ); ?></div>
                            <div class="options">
                           		<iframe width="640" height="480" src="//www.youtube.com/embed/gzH0uO6IReE" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                        
                    	<div class="items">
                        	<div class="header "><i class="fa fa-play"></i>  <?php _e('How to create Post Grid',post_grid_textdomain ); ?></div>
                            <div class="options">
                           		<iframe width="640" height="480" src="//www.youtube.com/embed/6HwLUBqT7i4" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>                        
                        
                    	<div class="items">
                        	<div class="header "><i class="fa fa-play"></i>  <?php _e('Post Grid - Query Post',post_grid_textdomain ); ?></div>
                            <div class="options">
                           		<iframe width="640" height="480" src="//www.youtube.com/embed/FKIcey0ujgo" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>                        
                        
                    	<div class="items">
                        	<div class="header "><i class="fa fa-play"></i>  <?php _e('Post Grid - Grid Layout',post_grid_textdomain ); ?></div>
                            <div class="options">
                           		<iframe width="640" height="480" src="//www.youtube.com/embed/g2GSb4chGXQ" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>       
                        
                        
                    	<div class="items">
                        	<div class="header "><i class="fa fa-play"></i>  <?php _e('Post Grid - Navigations',post_grid_textdomain ); ?></div>
                            <div class="options">
                           		<iframe width="640" height="480" src="//www.youtube.com/embed/B12CglBCLJY" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>                          
                        
                        
                    	<div class="items">
                        	<div class="header "><i class="fa fa-play"></i>  <?php _e('Post Grid - Layout Editor',post_grid_textdomain ); ?></div>
                            <div class="options">
                           		<iframe width="640" height="480" src="//www.youtube.com/embed/z_tygQ12aJk" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>        
                        
                        
                    	<div class="items">
                        	<div class="header "><i class="fa fa-play"></i>  <?php _e('Post Grid - Settings',post_grid_textdomain ); ?></div>
                            <div class="options">
                           		<iframe width="640" height="480" src="//www.youtube.com/embed/JsPKfENJL8I" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>                                           
                                          
                    
                    </div>
                	
                </div> 
                
                
                
                
				<div class="option-box">
                    <p class="option-title"><?php _e('Submit Reviews.',post_grid_textdomain ); ?></p>
                    <p class="option-info"><?php _e('We are working hard to build some awesome plugins for you and spend thousand hour for plugins. we wish your three(3) minute by submitting five star reviews at wordpress.org. if you have any issue please submit at forum.',post_grid_textdomain ); ?></p>
                	<img class="post_grid-pro-pricing" src="<?php echo post_grid_plugin_url."assets/admin/images/five-star.png";?>" /><br />
                    <a target="_blank" href="<?php echo post_grid_wp_reviews; ?>">
                		<?php echo post_grid_wp_reviews; ?>
               		</a>

                </div>
                
                
				<div class="option-box">
                    <p class="option-title"><?php _e('Please Share',post_grid_textdomain ); ?></p>
                    <p class="option-info"><?php _e('If you like this plugin please share with your social share network.',post_grid_textdomain ); ?></p>
                    <?php
                    
						echo post_grid_share_plugin();
					?>
                </div>
                

                
                
                
                
            </li>            
        </ul>
    
    
		

        
    </div>




<!-- 

<p class="submit">
	<input class="button button-primary" type="submit" name="Submit" value="<?php _e('Save Changes',post_grid_textdomain ); ?>" />
</p>

-->


		</form>


</div>
