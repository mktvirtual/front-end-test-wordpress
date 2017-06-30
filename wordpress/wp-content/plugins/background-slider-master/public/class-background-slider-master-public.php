<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://icanwp.com/plugins/background-slider-master/
 * @since      1.0.0
 *
 * @package    Background_Slider_Master
 * @subpackage Background_Slider_Master/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Background_Slider_Master
 * @subpackage Background_Slider_Master/public
 * @author     iCanWP Team, Sean Roh, Chris Couweleers
 */
class Background_Slider_Master_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	 
	private $sliderID;
	
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->sliderID = 0;
	}

	public function enqueue_scripts_styles() {
		$global_slider_id = 0;
		$post_slider_id = 0;
			
		if (is_single() || is_page()) { //check if loaded post or page
			$post_slider_id = intval( get_post_meta( get_the_ID(), '_bsm_selected_gallery', true ) );
			if ( $post_slider_id !== 0 ){ //check post or page level slider option
				$this->load_slider_scripts( $post_slider_id );
			} else { //use global background slider set, if post or page level slider option is not set
				$global_slider_id = intval( get_option( 'bsm_select_gallery_settings_field' ) );
				if ( $global_slider_id !== 0 ){ //check if global slider is set
					$this->load_slider_scripts( $global_slider_id );
				}
			}
		} else { //if current page is neither the post nor the page
			$global_slider_id = intval( get_option( 'bsm_select_gallery_settings_field' ) );
			if ( $global_slider_id !== 0 ){ //use global setting if set
				$this->load_slider_scripts( $global_slider_id );
			}
		}
	}
	
	//function to enqueue script to run the background slider
	public function load_slider_scripts( $slider_id ){
		$slider_id = intval($slider_id);
		if ( $slider_id !== 0 ) {
			$bsm_images = get_post_meta( $slider_id, 'bsm-image-id', false );
			$bsm_image_set = $bsm_images[0];

			if( count($bsm_image_set) > 0 ){ //check if chosen slider set has any images to show
				$this->sliderID = $slider_id;
				wp_register_script( $this->plugin_name . '_bsm_script', plugin_dir_url( __FILE__ ) . 'js/background-slider-master-public.js', array('jquery','jquery-effects-core'), $this->version, true );
				wp_enqueue_script( $this->plugin_name . '_bsm_script' );
				$bsm_loc = 	array( 
								'bsm_plugin_url' => plugin_dir_url( __FILE__ ),
								'bsm_view_mode' => get_option('bsm_view_mode_settings_field'), // full screen, original ratio
								'bsm_animation' => get_option('bsm_animation_settings_field'), // slider advance animation
								'bsm_skin' => get_option('bsm_skin_settings_field'), // arrows and icons skin color
								'bsm_thumb_nav' => get_option('bsm_thumb_nav_settings_field'), // true or false
								'bsm_slider_delay' => get_option('bsm_slider_delay_settings_field'), //time between the slider changes
								'bsm_easing_option_duration' => get_option('bsm_easing_option_duration_settings_field'), // time for animation transition
								'bsm_auto_play' => get_option('bsm_auto_play_settings_field') // true or false
							);
				wp_localize_script( $this->plugin_name . '_bsm_script', 'bsm_loc', $bsm_loc);
				
				wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/background-slider-master-public.css', array(), $this->version, 'all' );
				add_action( 'wp_head', array( $this, 'load_bsm' ) );
			}
		} 
	}

	public function load_bsm(){
		$slider_id = 0;
		if (is_single() || is_page()) {
			$slider_id = get_post_meta( get_the_ID(), '_bsm_selected_gallery', true ); // load slider set from page/post settings
			if ( $slider_id < 1) {
				$slider_id = get_option( 'bsm_select_gallery_settings_field' ); //load slider set from main default settings
			}
		} else {
			$slider_id = get_option( 'bsm_select_gallery_settings_field' );
		}
		
		$bsm_images = get_post_meta( $slider_id, 'bsm-image-id', false );
		$bsm_image_set = $bsm_images[0];
		
		$first_image = reset($bsm_image_set); // get the first element in the array
		$first_image_src = wp_get_attachment_image_src( $first_image, 'full' );
		$image_title = get_the_title( $first_image );					


		$html = '';
		if( intval( get_option( 'bsm_arrow_nav_settings_field' ) ) !== 1 ){
			$html .= '
				<a href="#" class="BSMnextImageBtn" title="next"></a>
				<a href="#" class="BSMprevImageBtn" title="previous"></a>
			';
		}
		
		$html .= '
			<div id="bsm-bg">
				<img src="'. $first_image_src[0] .'" alt="'. $image_title .'" title="'. $image_title.'" id="bsm-bgimg" />
			</div>
			<div id="bsm-preloader">
				<img src="'. plugin_dir_url( __FILE__ ) .'assets/ajax-loader_dark.gif" width="32" height="32" />
			</div>';
		
		if( intval( get_option( 'bsm_disable_ratio_settings_field' ) ) !== 1 ){
			$html .= '
				<div id="bsm-toolbar">
					<a href="#">
						<img src="'. plugin_dir_url( __FILE__ ) .'assets/toolbar_fs_icon-default.png" width="50" height="50" />
					</a>
				</div>';
		}
		$html .= '
			<div id="bsm-thumbnails-wrapper" ';
		if ( intval( get_option( 'bsm_thumb_nav_settings_field' ) ) === 1 ) {
			$html .= 'style="display:none;"';
		} 
		$html .= '">
				<div id="bsm-outer-container">
					<div class="thumbScroller">
						<div class="container">
		';
		
		foreach ( $bsm_image_set as $image_id ){
			$image_file = wp_get_attachment_image_src( $image_id, 'full' );
			$image_thumb = wp_get_attachment_image_src( $image_id, 'thumbnail' );
			$image_title = get_the_title( $image_file );
			$html .= '<div class="content">
							<div>
								<a href="'. $image_file[0] .'"><img src="'. $image_thumb[0] .'" title="'. $image_title .'" alt="'. $image_title .'" class="thumb" /></a>
							</div>
						</div>
			';
		}
		
		$html .= '
						</div>
					</div>
				</div>
			</div>
		';

		echo $html;
	}

}
