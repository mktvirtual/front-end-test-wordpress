<?php	


/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access




?>





<div class="wrap">

	<div id="icon-tools" class="icon32"><br></div><?php echo "<h2>".post_grid_plugin_name.__(' - Settings', post_grid_textdomain)."</h2>";?>

    <div class="para-settings post-grid-settings">
    
        <ul class="tab-nav"> 
            <li nav="1" class="nav1 active"><?php _e('Options',post_grid_textdomain); ?></li>             
   
        </ul> <!-- tab-nav end --> 
		<ul class="box">

            <li style="display: block;" class="box1 tab-box active">
				<div class="option-box">
                    <p class="option-title"><?php _e('Reset Content Layouts',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('you can reset content layouts here, saved & customized layout will reset permanetly.',post_grid_textdomain); ?></p>
                    
                    <div class="button reset-content-layouts">Reset Layouts</div>

                </div>
                
				<div class="option-box">
                    <p class="option-title"><?php _e('Export Content Layouts',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('You can export content layouts here. please make a backup on your local mechine for future use.',post_grid_textdomain); ?></p>
                    
                    <div class="button export-content-layouts"><?php _e('Export Layouts',post_grid_textdomain); ?></div>


					
                    <?php
					
						$upload_dir = wp_upload_dir();
						$basedir = $upload_dir['basedir'];	
						$baseurl = $upload_dir['baseurl'];
						$post_grid_dir = $basedir.'/post-grid';
						
						//$dir_path = $post_grid_dir;
                    
                        $dir_path	= $basedir."/post-grid/";
                        $filenames	=glob($dir_path."*.txt*");
						$count		=count($filenames);
						
						
						//var_dump($filenames);
						
						if(!empty($filenames)){
							
							echo '<p class="option-info">Exported files.</p>';
							
							$i=0;
							while($i<$count)
								{
									$filename= str_replace($dir_path,"",$filenames[$i]);
									//var_dump($filelink);
									
									
									$filelink= $baseurl."/post-grid/".$filename;
									
									echo ($i+1).'. <a target="_blank" href="'.$filelink.'" >'.$filename.'</a> <span file-url="'.$basedir."/post-grid/".$filename.'" class="remove_export_content_layout">Delete</span><br />';

									$i++;
								}

							
							}
						
						
					
					?>


                </div> 
                
				<div class="option-box">
                    <p class="option-title"><?php _e('Remove Content Layouts',post_grid_textdomain); ?></p>
                    <p class="option-info"><?php _e('you can remove content layouts here.',post_grid_textdomain); ?></p>
					<ul class="layout-list">
					<?php
                    
					$post_grid_layout_content = get_option('post_grid_layout_content');


                    foreach($post_grid_layout_content as $layout_key=>$layout_info){
						?>
                        <li><span class="remove-layout" layout-id="<?php echo $layout_key; ?>" ><i class="fa fa-times"></i></span><b><?php echo $layout_key; ?></b></li>
                        <?php
						
						}

					
					?>
					</ul>
                </div>                
                

                
            </li>
          
        </ul>
    
    
		

        
    </div>










</div>
