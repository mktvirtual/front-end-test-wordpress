<?php

/**
 * Fired during plugin activation
 *
 * @link       https://icanwp.com/plugins/background-slider-master/
 * @since      1.0.0
 *
 * @package    Background_Slider_Master
 * @subpackage Background_Slider_Master/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Background_Slider_Master
 * @subpackage Background_Slider_Master/includes
 * @author     iCanWP Team, Sean Roh, Chris Couweleers
 */
class Background_Slider_Master_Activator {

	/**
	 * Checks for gallery slides created from previous settings and convert them to be compatible with the new setting.
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		
		$bsm_slide_set_option = array(
			'posts_per_page'   => -1,
			'order'            => 'ASC',
			'post_type'        => 'bsm-gallery-slides',
			'post_status'      => 'publish'
		);
		
		$bsm_slide_set = get_posts( $bsm_slide_set_option ); //call all posts with bsm-gallery-slides post type
		$count = count( $bsm_slide_set ); //count how many bsm-gallery-slides posts exist
		if( count( $bsm_slide_set ) > 0 ) { //if any of the bsm-gallery-slides post exist - checking for first time use/ new install
			foreach( $bsm_slide_set as $bsm_slide ){
				$bsm_slide_id = $bsm_slide->ID; // get each bsm post's id
				$bsm_meta_check = get_post_meta( $bsm_slide_id, 'bsm-image-id', true ); // check if the bsm post has post meta (v2.0.0 update)
				if( empty( $bsm_meta_check ) ){ //if bsm meta doesn't exist - plugin upgraded from old version
					$bsm_slide_images = get_attached_media( 'image', $bsm_slide_id ); // get all the attached media from the old version
					$bsm_arr = array();
					foreach( $bsm_slide_images as $bsm_slide_image ){
						array_push( $bsm_arr, $bsm_slide_image->ID ); // store all attached media into an array
					}
					update_post_meta( $bsm_slide_id, 'bsm-image-id', $bsm_arr ); // assign all attached meida to the post meta to use in v2
				}
			}
			
		}
	}
	
}
