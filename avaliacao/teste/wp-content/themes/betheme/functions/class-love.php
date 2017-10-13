<?php
if ( ! class_exists( 'mfnLove' ) ){
	class mfnLove {
	
		function __construct() {
			add_action( 'wp_ajax_mfn_love', array( &$this, 'ajax' ) );
			add_action( 'wp_ajax_nopriv_mfn_love', array( &$this, 'ajax' ) );
			add_action( 'wp_ajax_mfn_love_randomize', array( &$this, 'randomize' ) );
			add_action( 'wp_ajax_nopriv_mfn_love_randomize', array( &$this, 'randomize' ) );
		}
	
		function ajax( $post_id ) {
	
			if ( isset( $_POST['post_id'] ) ) {
				echo $this->love( intval($_POST['post_id']), 'update' );
			}
			else {
				echo $this->love( intval($_POST['post_id']), 'get' );
			}
	
			exit;
		}
		
		function randomize( ){
		
			$post_type = htmlspecialchars(stripslashes($_POST['post_type']));
		
			$aPosts = get_posts(array(
				'posts_per_page' 	=> -1,
				'post_type' 		=> $post_type ? $post_type : false,
				'fields'        	=> 'ids',
			));
		
			if( is_array( $aPosts ) ){
				foreach( $aPosts as $post ){
					$love_count = rand( 10, 100 );	// Random number of loves [min:10, max:100]
					update_post_meta( $post, 'mfn-post-love', $love_count );
				}
					
				_e( 'Love randomized',  'mfn-opts' );
			}
		
			exit;
		}
	
		function love( $post_id, $action = 'get' ) {
			if ( ! is_numeric( $post_id ) ) return;
	
			switch ( $action ) {
	
			case 'get':
				$love_count = get_post_meta( $post_id, 'mfn-post-love', true );
				if ( !$love_count ) {
					$love_count = 0;
					add_post_meta( $post_id, 'mfn-post-love', $love_count, true );
				}
	
				return $love_count;
				break;
	
			case 'update':
				$love_count = get_post_meta( $post_id, 'mfn-post-love', true );
				if ( isset( $_COOKIE['mfn-post-love-'. $post_id] ) ) return $love_count;
	
				$love_count++;
				update_post_meta( $post_id, 'mfn-post-love', $love_count );
				setcookie( 'mfn-post-love-'. $post_id, $post_id, time()*20, '/' );
	
				return $love_count;
				break;
	
			}
		}
	
		function get() {
			global $post;
	
			$output = $this->love( $post->ID );
			$class = '';
			if ( isset( $_COOKIE['mfn-post-love-'. $post->ID] ) ) {
				$class = 'loved';
			}
	
			return '<a href="#" class="mfn-love '. $class .'" data-id="'. $post->ID .'"><span class="icons-wrapper"><i class="icon-heart-empty-fa"></i><i class="icon-heart-fa"></i></span><span class="label">'. $output .'</span></a>';	
		}
	
	}
}

global $mfn_love;
$mfn_love = new mfnLove();

if( ! function_exists( 'mfn_love' ) )
{
	function mfn_love( $return = '' ) {
		global $mfn_love;
		return $mfn_love->get();
	}
}
