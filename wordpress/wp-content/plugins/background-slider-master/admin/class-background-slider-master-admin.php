<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://icanwp.com/plugins/background-slider-master/
 * @since      1.0.0
 *
 * @package    Background_Slider_Master
 * @subpackage Background_Slider_Master/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Background_Slider_Master
 * @subpackage Background_Slider_Master/admin
 * @author     iCanWP Team, Sean Roh, Chris Couweleers
 */
class Background_Slider_Master_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		//add_action( 'save_post', array( $this, 'bsm_save_bsm_meta_boxes' ) );
		//add_filter( 'is_protected_meta', array( $this, 'bsm_protected_meta_filter'), 10, 2 );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name . 'admin-css', plugin_dir_url( __FILE__ ) . 'css/background-slider-master-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . 'jquery-ui-css', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . 'jquery-ui-structure-css', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.structure.min.css', array(), $this->version, 'all' );
	}
	
	/**
	 * Register the javascript for the admin area.
	 *
	 * @since    1.0.0
	 */
	 
	public function enqueue_scripts() {
		wp_enqueue_media();
		wp_register_script( $this->plugin_name . '-bsm-admin-js', plugin_dir_url( __FILE__ ) . 'js/background-slider-master-admin.js', array('jquery','jquery-ui-sortable'), $this->version, 'all' );
		$bsm_variables = array(
			'plugin_admin_url' => plugin_dir_url( __FILE__ ),
			'admin_ajax_url' => admin_url( 'admin-ajax.php' )
		);
		wp_localize_script( $this->plugin_name . '-bsm-admin-js', 'bsm_admin_localized', $bsm_variables );
		wp_enqueue_script( $this->plugin_name . '-bsm-admin-js' );
	}

	public function bsm_add_admin_menu(){
		add_menu_page(
			'Background Slider Master', // The title to be displayed on this menu's corresponding page
			'Background Slider', // The text to be displayed for this actual menu item
			'manage_options', // Which type of users can see this menu
			'bsm_admin_menu', // The unique ID - that is, the slug - for this menu item
			'', // The name of the function to call when rendering this menu's page
			plugin_dir_url( __FILE__ ) . 'assets/admin-icon.png', // icon url
			138.831 // position
		);
		add_submenu_page(
			'bsm_admin_menu',                  // Register this submenu with the menu defined above
			'Background Slider Master Settings',          // The text to the display in the browser when this menu item is active
			'Settings',                  // The text for this menu item
			'manage_options',            // Which type of users can see this menu
			'bsm_settings_menu',          // The unique ID - the slug - for this menu item
			array($this, 'display_bsm_settings_menu_page')   // The function used to render this menu's page to the screen
		);
	}
	public function bsm_plugin_options(){
		update_option( 'bsm_easing_option_duration_settings_field', 500 );
	}
	
	public function bsm_init_options(){
		add_settings_section(
			'bsm_select_gallery_settings_section', // ID used to identify this section and with which to register options
			'Main Settings',
			'',
			'bsm_settings_menu' // Page on which to add this section of options
		);
		add_settings_field( 
			'bsm_select_gallery_settings_field',
			'Choose global background slider image set',
			array($this, 'callback_bsm_select_gallery_settings_field'),
			'bsm_settings_menu',
			'bsm_select_gallery_settings_section'
		);		
		add_settings_field( 
			'bsm_animation_settings_field',
			'Select Slide Animation',
			array($this, 'callback_bsm_animation_settings_field'),
			'bsm_settings_menu',
			'bsm_select_gallery_settings_section',
			array('Supports fadeout and crossfading.')
		);		
		add_settings_field( 
			'bsm_view_mode_settings_field',
			'Select Default View Mode',
			array($this, 'callback_bsm_view_mode_settings_field'),
			'bsm_settings_menu',
			'bsm_select_gallery_settings_section',
			array('Default will display the image as a "cover", the other option will display image in full screen mode, but keeping the original ratio.')
		);
		add_settings_field( 
			'bsm_skin_settings_field',
			'Select Controller Skin',
			array($this, 'callback_bsm_skin_settings_field'),
			'bsm_settings_menu',
			'bsm_select_gallery_settings_section',
			array('Default will display dark grey.')
		);
		add_settings_field( 
			'bsm_disable_ratio_settings_field',
			'Disable View Mode Change',
			array($this, 'callback_bsm_disable_ratio_settings_field'),
			'bsm_settings_menu',
			'bsm_select_gallery_settings_section',
			array('Check to disable view mode change by front-end users.')
		);
		add_settings_field( 
			'bsm_arrow_nav_settings_field',
			'Hide Arrow Navigation',
			array($this, 'callback_bsm_arrow_nav_settings_field'),
			'bsm_settings_menu',
			'bsm_select_gallery_settings_section',
			array('')
		);
		add_settings_field( 
			'bsm_thumb_nav_settings_field',
			'Hide Thumbnail Navigation',
			array($this, 'callback_bsm_thumb_nav_settings_field'),
			'bsm_settings_menu',
			'bsm_select_gallery_settings_section',
			array('')
		);
		add_settings_field( 
			'bsm_slider_delay_settings_field',
			'Slide Change Interval',
			array($this, 'callback_bsm_slider_delay_settings_field'),
			'bsm_settings_menu',
			'bsm_select_gallery_settings_section',
			array('Time until loading the next slide in milliseconds - 2 Seconds Minimum. (1,000 milliseconds = 1 second)')
		);
		add_settings_field( 
			'bsm_easing_option_duration_settings_field',
			'Easing Delay',
			array($this, 'callback_bsm_easing_option_duration_settings_field'),
			'bsm_settings_menu',
			'bsm_select_gallery_settings_section',
			array('Time for easing of the slider image before gets changed to the next one in milliseconds. (1,000 milliseconds = 1 second)')
		);
		
		register_setting(
			'bsm_settings_menu',
			'bsm_select_gallery_settings_field'
		);
		
		register_setting(
			'bsm_settings_menu',
			'bsm_animation_settings_field'
		);
		register_setting(
			'bsm_settings_menu',
			'bsm_view_mode_settings_field'
		);
		register_setting(
			'bsm_settings_menu',
			'bsm_skin_settings_field'
		);
		register_setting(
			'bsm_settings_menu',
			'bsm_disable_ratio_settings_field'
		);
		register_setting(
			'bsm_settings_menu',
			'bsm_arrow_nav_settings_field'
		);
		register_setting(
			'bsm_settings_menu',
			'bsm_thumb_nav_settings_field'
		);
		register_setting(
			'bsm_settings_menu',
			'bsm_slider_delay_settings_field',
			array( $this, 'set_slider_delay' )
		);
		register_setting(
			'bsm_settings_menu',
			'bsm_easing_option_duration_settings_field',
			array( $this, 'set_easing_delay' )
		);
		
		// Sets the default value of the time delay
		if ( get_option( 'bsm_slider_delay_settings_field' ) === false ) {
			update_option( 'bsm_slider_delay_settings_field', 5000 );
		}
		if ( get_option( 'bsm_easing_option_duration_settings_field' ) === false ) {
			update_option( 'bsm_easing_option_duration_settings_field', 500 );
		}
		
	}
	public function bsm_register_custom_post_type(){
		$labels = array(
			'name'               => 'Background Slides',
			'singular_name'      => 'Background Slide',
			'menu_name'          => 'Background Slider Master',
			'name_admin_bar'     => 'Background Slider Master',
			'add_new'            => 'Add New Background Slide Set',
			'add_new_item'       => 'Add New Background Slide',
			'new_item'           => 'New Background Slide Set',
			'edit_item'          => 'Edit Background Slide Set',
			'view_item'          => 'View Background Slide Set',
			'all_items'          => 'Background Slide Sets',
			'search_items'       => 'Search Background Slide Set',
			'parent_item_colon'  => 'Parent Background Slide Set:',
			'not_found'          => 'No Background Slide Set Found',
			'not_found_in_trash' => 'No Background Slide Set Found in Trash.'
		);

		$args = array(
			'labels'             => $labels,
			'description'        => 'Background Slider Master Slide Set',
			'public'             => true,
			'publicly_queryable' => false,
			'exclude_from_search' => true,
			'show_ui'            => true,
			'show_in_menu'       => 'bsm_admin_menu',
			'menu_position'			=> 20.41,
			'query_var'          => false,
			'rewrite'            => false,
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'supports'           => array( 'title')
		);

		register_post_type( 'bsm-gallery-slides', $args );
	}
	public function bsm_add_meta_boxes($post_type){
		add_meta_box(
			'bsm_files', 
			'Background Slider Master Images', 
			array($this, 'callback_add_meta_box'),
			'bsm-gallery-slides'
		);
		
		$default_post_types = array( 'post', 'page' );
		if ( in_array( $post_type, $default_post_types )) {
			add_meta_box(
			'bsm_gallery',
			'Select Background Slider Master Gallery',
			array($this, 'callback_add_meta_bsm_selector'),
			$post_type,
			'side',
			'default'
			);
		}
	}
	public function bsm_save_bsm_meta_boxes ( $post_id ){

		// Check if our nonce is set.
		if ( ! isset( $_POST['bsm_custom_box_nonce'] ) ) {
			return $post_id;
		} else {
			$nonce = $_POST['bsm_custom_box_nonce'];
			if ( ! wp_verify_nonce( $nonce, 'bsm_custom_box' ) ){
				die('[This is not a critical warning.] Background Slider Master Session Authentication Does Not Match. Please go back to the form, refresh the session, then try it again.');
			}
		}
		// If this is an autosave, our form has not been submitted,
		//     so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
		
		if (isset($_POST["bsm-image-id"])) {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				die("You do not have sufficient previlliege to edit the post.");
			}
			$result = $_POST['bsm-image-id'];
			update_post_meta( $post_id, 'bsm-image-id', $result );
		}
		
		if (isset($_POST["bsm_field_select_gallery"])) {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				die("You do not have sufficient previlliege to edit the post.");
			}
			$bsm_selected = sanitize_text_field( $_POST['bsm_field_select_gallery'] );
			update_post_meta( $post_id, '_bsm_selected_gallery', $bsm_selected );
		}
	}
	//Metaboxes for Posts and Pages
	public function callback_add_meta_bsm_selector( $post ){
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'bsm_custom_box', 'bsm_custom_box_nonce' );
		// Use get_post_meta to retrieve an existing value from the database.
		$bsm_selected_id = get_post_meta( $post->ID, '_bsm_selected_gallery', true );
		$bsm_slide_set_option = array(
			'posts_per_page'   => -1,
			'order'            => 'ASC',
			'post_type'        => 'bsm-gallery-slides',
			'post_status'      => 'publish'
		);
		
		$bsm_slide_set = get_posts( $bsm_slide_set_option );
		
		$html = '<select name="bsm_field_select_gallery" id="bsm_field_select_gallery">';
		$html .= '<option value="0">Disabled</option>';
		
		foreach ( $bsm_slide_set as $bsm_slide ){
			$bsm_slide_ID = intval( $bsm_slide -> ID );
			$bsm_slide_title = $bsm_slide -> post_title;
			$html .= '<option value="'. $bsm_slide_ID . '" ';
			if( $bsm_slide_ID === intval($bsm_selected_id) ){
				$html .= ' selected="selected" >';
			} else {
				$html .= '>';
			}
			if( $bsm_slide_title === '' ){
				$html .= '(no title)</option>';
			} else {
				$html .= esc_attr( $bsm_slide_title ) . '</option>';
			}
		}
		$html .= '</select>';		
		echo $html;
	}
	public function callback_add_meta_box($post){
		//require_once('partials/meta-box-bsm-upload.php');
		
		$html = '
			<div id="bsm-add-media-instruction">
				<h3>Instruction</h3>
				<p>1. Click "Upload Background Images" to add images.<br />
				   2. <strong>Click "Publish" or "Update" to save your slider!</strong><br />
				   3. Go to the slider "Settings" to apply it globally, or visit your pages individually and choose what slider to display on each page.
				</p>
			</div>
			<div class="clearfix"></div>
			<label for="upload_image">
				<input id="upload_image_button" class="button" type="button" value="Add Images" />
			</label>
			<div class="clearfix"></div>
			<div class="icanwp-promo">
				<p class="icanwp-desc">Do you want more features? Check out the <a href="https://codecanyon.net/item/icanwp-background-slider-gallery/16820854?ref=iCanWP" class="icanwp-promo-line" target="_blank">iCanWP Background Slider Gallery.</a></p>
			</div>
			<div class="clearfix"></div>
			<br />
			<hr />
			<div class="clearfix"></div>
			<div id="bsm-messages">
				<p class="bsm-notice">You can drag drop loaded images to rearrange the order.</p>
				<p class="bsm-warning">Please click "Publish" or "Update" to save the change.</p>
			</div>
			<div class="clearfix"></div>
			
			
			<ul id="bsm-images-container" class="clearfix">
		';	
		
		$bsm_images = get_post_meta( $post->ID, 'bsm-image-id', false );
		$bsm_image_set = $bsm_images[0];
		if( !empty($bsm_image_set) ){
			foreach( $bsm_image_set as $image_id ){
				//Check whether the id stored is the image type media
				if( wp_attachment_is_image( $image_id ) ){
					$image_url = wp_get_attachment_image_src( $image_id, 'medium' ); 
					$image_url = $image_url[0];
					$image_title = get_the_title( $image_id );					
					$html .='
						<li class="bsm-image-container">
							<img src="'. $image_url .'" class="bsm-image bsm-thumbnail" />
							<input type="hidden" name="bsm-image-id[]" value="'. $image_id .'" />
							<label class="bsm-image-title">' . $image_title . '</label>
							<img src="' . plugin_dir_url( __FILE__ ) . 'assets/drag-icon.png" class="bsm-image-move" title="move" alt="Drag and Drop to Move" />
							<img src="' . plugin_dir_url( __FILE__ ) . 'assets/remove-icon.png" class="bsm-image-remove" title="remove" alt="Click to remove image" />
						</li>
					';
				}
			}
		}
		$html .= '</ul><div class="clearfix"></div>';
		$html .= wp_nonce_field( 'bsm_custom_box', 'bsm_custom_box_nonce' );
		$html .='</div>';

		echo $html;
	}
	
	public function display_bsm_settings_menu_page(){
		require_once('partials/menu-page-bsm-settings.php');
	}
	
	//Slider options in the admin settings
	public function callback_bsm_select_gallery_settings_field( $options ){
		$selected = get_option('bsm_select_gallery_settings_field');
		
		$bsm_slide_set_option = array(
			'posts_per_page'   => -1,
			'order'            => 'ASC',
			'post_type'        => 'bsm-gallery-slides',
			'post_status'      => 'publish'
		);
		
		$bsm_slide_set = get_posts( $bsm_slide_set_option ); //call all bsm slider sets
		
		$html = '<select name="bsm_select_gallery_settings_field" id="bsm_select_gallery_settings_field">';
		$html .= '<option value="0">Disabled</option>';
		
		foreach ( $bsm_slide_set as $bsm_slide ){
			$bsm_slide_ID = intval( $bsm_slide -> ID );
			$bsm_slide_title = $bsm_slide -> post_title;
			$html .= '<option value="'. $bsm_slide_ID . '" ';
			if( $bsm_slide_ID === intval($selected) ){
				$html .= ' selected="selected" >';
			} else {
				$html .= '>';
			}
			if( $bsm_slide_title === '' ){
				$html .= '(no title)</option>';
			} else {
				$html .= esc_attr( $bsm_slide_title ) . '</option>';
			}
		}
		$html .= '</select>';
		echo $html;
	}
	
	public function callback_bsm_view_mode_settings_field( $options ){
		$selected = get_option('bsm_view_mode_settings_field');
		$view_modes = array(
			'full' => 'Default - Full Width',
			'normal' => 'Original Image Ratio'
		);
		$html = '<select class="bsm_view_mode_settings_field" name="bsm_view_mode_settings_field">';
		foreach($view_modes as $view_mode => $view_name){
			$html .= '<option value="' . $view_mode . '" name="' . $view_mode . '" ';
			if($view_mode == $selected){
				$html .= 'selected="selected"';
			}
			$html .= '>' . $view_name . '</option>';
		}
		$html .= '</selected>';
		$html .= '<label for="bsm_view_mode_settings_field"> '  . $options[0] . '</label>'; 
		echo $html;
	}
	
	public function callback_bsm_animation_settings_field( $options ){
		$selected = get_option('bsm_animation_settings_field');
		$animations = array(
			'fadeout' => 'Fadeout',
			'cross' => 'Cross-fading',
		);
		$html = '<select class="bsm_animation_settings_field" name="bsm_animation_settings_field">';
		foreach($animations as $animation => $animation_name){
			$html .= '<option value="' . $animation . '" name="' . $animation . '" ';
			if($animation == $selected){
				$html .= 'selected="selected"';
			}
			$html .= '>' . $animation_name . '</option>';
		}
		$html .= '</selected>';
		$html .= '<label for="bsm_animation_settings_field"> '  . $options[0] . '</label>'; 
		echo $html;		
	}
	
	public function callback_bsm_skin_settings_field( $options ){
		$selected = get_option('bsm_skin_settings_field');
		$skins = array(
			'default' => 'Default - Dark Grey',
			'white' => 'White - White Arrows and Icons',
			'black' => 'Black - Black Arrows and Icons'
		);
		$html = '<select class="bsm_skin_settings_field" name="bsm_skin_settings_field">';
		foreach($skins as $skin => $skin_name){
			$html .= '<option value="' . $skin . '" name="' . $skin . '" ';
			if($skin == $selected){
				$html .= 'selected="selected"';
			}
			$html .= '>' . $skin_name . '</option>';
		}
		$html .= '</selected>';
		$html .= '<label for="bsm_skin_settings_field"> '  . $options[0] . '</label>'; 
		echo $html;		
	}
	
	public function callback_bsm_disable_ratio_settings_field( $options ){
		$html = '<input type="checkbox" id="bsm_disable_ratio_settings_field" name="bsm_disable_ratio_settings_field" value="1" ' . checked(1, get_option('bsm_disable_ratio_settings_field'), false) . '/>'; 
		$html .= '<label for="bsm_disable_ratio_settings_field"> '  . $options[0] . '</label>'; 
		echo $html;
	}
	public function callback_bsm_arrow_nav_settings_field( $options ){
		$html = '<input type="checkbox" id="bsm_arrow_nav_settings_field" name="bsm_arrow_nav_settings_field" value="1" ' . checked(1, get_option('bsm_arrow_nav_settings_field'), false) . '/>'; 
		$html .= '<label for="bsm_arrow_nav_settings_field"> '  . $options[0] . '</label>'; 
		echo $html;
	}
	public function callback_bsm_thumb_nav_settings_field( $options ){
		$html = '<input type="checkbox" id="bsm_thumb_nav_settings_field" name="bsm_thumb_nav_settings_field" value="1" ' . checked(1, get_option('bsm_thumb_nav_settings_field'), false) . '/>'; 
		$html .= '<label for="bsm_thumb_nav_settings_field"> '  . $options[0] . '</label>'; 
		echo $html;
	}
	public function callback_bsm_slider_delay_settings_field( $options ){
		$html = '<input type="text" class="bsm-number-field" id="bsm_slider_delay_settings_field" name="bsm_slider_delay_settings_field" value="' . get_option('bsm_slider_delay_settings_field') .'" />';
		$html .= '<label for="bsm_slider_delay_settings_field"> '  . $options[0] . '</label>'; 
		echo $html;
	}
	public function callback_bsm_easing_option_duration_settings_field( $options ){
		$html = '<input type="text" class="bsm-number-field" id="bsm_easing_option_duration_settings_field" name="bsm_easing_option_duration_settings_field" value="' . get_option('bsm_easing_option_duration_settings_field') .'" />';
		$html .= '<label for="bsm_easing_option_duration_settings_field"> '  . $options[0] . '</label>'; 
		echo $html;	
	}

	public function set_slider_delay( $input ){
		if ( $input === '' ){
			return 5000;
		} elseif ( intval($input) < 2000) {
			return 2000;
		} else {
			return intval($input);
		}
	}
	public function set_easing_delay( $input ){
		if ( $input === '' ){
			return 500;
		} else {
			return intval($input);
		}
	}

	public function bsm_protected_meta_filter($protected, $meta_key) {
		return $meta_key == 'bsm-image-id' ? true : $protected;
	}
	
	public function bsm_notice_php_version_critical(){
		$notice = '<div class="notice notice-error is-dismissible wpcdd-notice-error"><p>
		<strong>Your PHP Version ' . phpversion() . '	is <a href="http://php.net/supported-versions.php" target="_blank">out of support</a></strong> and there could be <a href="https://www.cvedetails.com/vulnerability-list/vendor_id-74/product_id-128/PHP-PHP.html" target="_blank">serious security issues</a>. We strongly recommend that you upgrade your PHP version. If security and performance of your website is important, please checkout the <a href="https://icanwp.com/_link?a=we" target="_blank">Managed WordPress Hosting</a> we recommend.</p></div>';
		echo $notice;
	}
	
	public function bsm_notice_get_pro_version(){
		$notice = '<div class="notice notice-warning is-dismissible wpcdd-notice-warning bsm-pro-notification"><p>
		If you like our Background Slider Master, please support us by purchasing our pro version <a href="https://icanwp.com/_link?a=ccbs" target="_blank">iCanWP Background Slider</a> that has many more features.</div>';
		echo $notice;
	}

	public function bsm_portfolio_dismiss_pro_notice(){
		update_option( 'bsm_notice_get_pro_version_dismissed', '1' );
	}
	
	public function bsm_user_logins(){
		delete_option( 'bsm_notice_get_pro_version_dismissed' );
	}
	
}