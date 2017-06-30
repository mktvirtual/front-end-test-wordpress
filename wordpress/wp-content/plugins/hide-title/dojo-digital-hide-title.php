<?php
/*
Plugin Name: Hide Title
Plugin URI: http://dojodigital.com
Description: Allows authors to hide the title tag on single pages and posts via the edit post screen.
Version: 1.0.4
Author: Brandon Kraft & Randall Runnels
Author URI: http://dojodigital.com
*/

if ( !class_exists( 'DojoDigitalHideTitle' ) ) {

    class DojoDigitalHideTitle {

    	private $slug = 'dojodigital_toggle_title';
    	private $selector = '.entry-title';
    	private $title;
    	private $afterHead = false;

        /**
        * PHP 5 Constructor
        */
        function __construct(){

	        add_action( 'add_meta_boxes', array( $this, 'add_box' ) );
			add_action( 'save_post', array( $this, 'on_save' ) );
			add_action( 'delete_post', array( $this, 'on_delete' ) );
			add_action( 'wp_head', array( $this, 'head_insert' ), 3000 );
			add_action( 'the_title', array( $this, 'wrap_title' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ) );

        } // __construct()


		private function is_hidden(  ){

			if( is_singular() ){

				global $post;

				$toggle = get_post_meta( $post->ID, $this->slug, true );

				if( (bool) $toggle ){
					return true;
				} else {
					return false;
				}

			} else {
				return false;
			}

		} // is_hidden()


    	public function head_insert(){

			if( $this->is_hidden() ){ ?>
<!-- Dojo Digital Hide Title -->
<script type="text/javascript">
	jQuery(document).ready(function($){

		if( $('<?php echo $this->selector; ?>').length != 0 ) {
			$('<?php echo $this->selector; ?> span.<?php echo $this->slug; ?>').parents('<?php echo $this->selector; ?>:first').hide();
		} else {
			$('h1 span.<?php echo $this->slug; ?>').parents('h1:first').hide();
			$('h2 span.<?php echo $this->slug; ?>').parents('h2:first').hide();
		}

	});
</script>
<noscript><style type="text/css"> <?php echo $this->selector; ?> { display:none !important; }</style></noscript>
<!-- END Dojo Digital Hide Title -->

			<?php }

			// Indicate that the header has run so we can hopefully prevent adding span tags to the meta attributes, etc.
			$this->afterHead = true;

		} // head_insert()


		public function add_box(){

			$posttypes = array( 'post', 'page' );

			foreach ( $posttypes as $posttype ){
				add_meta_box( $this->slug, 'Hide Title', array( $this, 'build_box' ), $posttype, 'side' );
			}

		} // add_box()


		public function build_box( $post ){

			$value = get_post_meta( $post->ID, $this->slug, true );

			$checked = '';

			if( (bool) $value ){ $checked = ' checked="checked"'; }

			wp_nonce_field( $this->slug . '_dononce', $this->slug . '_noncename' );

			?>
			<label><input type="checkbox" name="<?php echo $this->slug; ?>" <?php echo $checked; ?> /> Hide the title on singular page views.</label>
			<?php

		} // build_box()


		public function wrap_title( $content ){

			if( $this->is_hidden() && $content == $this->title && $this->afterHead ){
				$content = '<span class="' . $this->slug . '">' . $content . '</span>';
			}

			return $content;

		} // wrap_title()


		public function load_scripts(){


			// Grab the title early in case it's overridden later by extra loops.
			global $post;
			$this->title = $post->post_title;

			if( $this->is_hidden() ){
				wp_enqueue_script( 'jquery' );

			}

		} // load_scripts()


		public function on_save( $postID ){

			if ( ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
				|| !isset( $_POST[ $this->slug . '_noncename' ] )
				|| !wp_verify_nonce( $_POST[ $this->slug . '_noncename' ], $this->slug . '_dononce' ) ) {
				return $postID;
			}

			$old = get_post_meta( $postID, $this->slug, true );
			$new = $_POST[ $this->slug ] ;

			if( $old ){
				if ( is_null( $new ) ){
					delete_post_meta( $postID, $this->slug );
				} else {
					update_post_meta( $postID, $this->slug, $new, $old );
				}
			} elseif ( !is_null( $new ) ){
				add_post_meta( $postID, $this->slug, $new, true );
			}

			return $postID;

		} // on_save()


		public function on_delete( $postID ){
			delete_post_meta( $postID, $this->slug );
			return $postID;
		} // on_delete()


		public function set_selector( $selector ){

			if( isset( $selector ) && is_string( $selector ) ){
				$this->selector = $selector;
			}

		} // set_selector()


    } // DojoDigitalHideTitle

    $DojoDigitalHideTitle = new DojoDigitalHideTitle;

} // !class_exists( 'DojoDigitalHideTitle' )