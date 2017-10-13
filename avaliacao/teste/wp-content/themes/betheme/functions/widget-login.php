<?php
/**
 * Widget Muffin Login
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

if ( ! class_exists( 'Mfn_Login_Widget' ) ){
	class Mfn_Login_Widget extends WP_Widget {
		
		
		/* ---------------------------------------------------------------------------
		 * Constructor
		 * --------------------------------------------------------------------------- */
		function __construct(){
			
			$widget_ops = array( 'classname' => 'widget_mfn_login', 'description' => __( 'Displays Login Form.', 'mfn-opts' ) );
			
			parent::__construct( 'widget_mfn_login', __( 'Muffin Login', 'mfn-opts' ), $widget_ops );
			
			$this->alt_option_name = 'widget_mfn_login';
		}
		
		
		/* ---------------------------------------------------------------------------
		 * Outputs the HTML for this widget.
		 * --------------------------------------------------------------------------- */
		function widget( $args, $instance ) {
			global $user_login;
	
			if ( ! isset( $args['widget_id'] ) ) $args['widget_id'] = null;
			extract( $args, EXTR_SKIP );
			extract( $instance );
	
			echo $before_widget;
			
			$title = apply_filters( 'widget_title', $title, $instance, $this->id_base);
			
			if( is_user_logged_in() ){
				$user = get_user_by('login', $user_login);
				$title = __('Welcome','mfn-opts').' '.$user->data->display_name;
			}
			
			echo '<div class="mfn-login">';
			
				if( $title ) echo $before_title . $title . $after_title;
				
				// validation
				if( isset( $_GET['login'] ) && $_GET['login'] == 'failed'){
					$errcode = $_GET['errcode'];
						
					if( $errcode == "empty_username" || $errcode == "empty_password" ){
						$error = __('Please enter Username and Password', 'mfn-opts');
					}
					elseif( $errcode == 'invalid_username' ){
						$error = __('Invalid Username', 'mfn-opts');
					}
					elseif( $errcode == 'incorrect_password' ){
						$error = __('Incorrect Password', 'mfn-opts');
					}
			
					echo '<div class="alert alert_error">'. $error .'</div>';
				}
			
				if( is_user_logged_in() ){
		
					echo '<div class="avatar-wrapper">'. get_avatar( $user->ID, 64 ) .'</div>';
					
					echo '<div class="author">';
					
						_e('Logged in as ','mfn-opts');
						echo '<strong>' . ucfirst( implode(', ', $user->roles)) . '</strong><br />';
						echo '<a href="' . admin_url() . '">'. __('Dashboard','mfn-opts') .'</a>';
						echo '<span class="sep">|</span>';
						echo '<a href="' . admin_url() . 'profile.php">'. __('Profile','mfn-opts') .'</a>';
						echo '<span class="sep">|</span>';
						echo '<a href="' . wp_logout_url(site_url()) . '">'. __('Logout','mfn-opts') .'</a>';
						
					echo '</div>';
		
				} else {
	
					wp_login_form(array( 'value_remember' => 0,
						'redirect' 			=> site_url(),
	// 					'label_username' 	=> __( 'Username', 'mfn-opts' ),
	// 					'label_password' 	=> __( 'Password', 'mfn-opts' ),
	// 					'label_remember' 	=> __( 'Remember Me', 'mfn-opts' ),
	// 					'label_log_in'   	=> __( 'Log In', 'mfn-opts' ),
						'remember' 			=> false
					));
					
					echo '<div class="links">';
						if( $show_register ) echo '<a href="' . wp_registration_url() . '">'. __('Register','mfn-opts') .'</a>';
						if( $show_register && $show_forgotten_password ) echo '<span class="sep">|</span>';
						if( $show_forgotten_password ) echo '<a href="' . wp_registration_url() . '">'. __('Lost your password?','mfn-opts') .'</a>';
					echo '</div>';
	
				}
			
			echo '</div>'."\n";
			
			echo $after_widget;
		}
	
	
		/* ---------------------------------------------------------------------------
		 * Deals with the settings when they are saved by the admin.
		 * --------------------------------------------------------------------------- */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			
			$instance['title']						= strip_tags( $new_instance['title'] );
	// 		$instance['show_remember_me']			= (int) $new_instance['show_remember_me'];
			$instance['show_register']				= (int) $new_instance['show_register'];
			$instance['show_forgotten_password']	= (int) $new_instance['show_forgotten_password'];
			
			return $instance;
		}
	
		
		/* ---------------------------------------------------------------------------
		 * Displays the form for this widget on the Widgets page of the WP Admin area.
		 * --------------------------------------------------------------------------- */
		function form( $instance ) {
			
			$title 						= isset( $instance['title']) ? esc_attr( $instance['title'] ) : '';
	// 		$show_remember_me 			= isset( $instance['show_remember_me'] ) ? absint( $instance['show_remember_me'] ) : 0;
			$show_register 				= isset( $instance['show_register'] ) ? absint( $instance['show_register'] ) : 0;
			$show_forgotten_password 	= isset( $instance['show_forgotten_password'] ) ? absint( $instance['show_forgotten_password'] ) : 0;
	?>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'mfn-opts' ); ?></label>
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
				</p>
	
				<p>
					<!-- 
					<input id="<?php echo esc_attr( $this->get_field_id( 'show_remember_me' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_remember_me' ) ); ?>" type="checkbox" value="1" <?php if( esc_attr( $show_remember_me ) ) echo "checked='checked'" ?>" />
					<label for="<?php echo esc_attr( $this->get_field_id( 'show_remember_me' ) ); ?>"><?php _e( 'Show Remember Me checkbox', 'mfn-opts' ); ?></label>	
					<br />
					 -->
					<input id="<?php echo esc_attr( $this->get_field_id( 'show_register' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_register' ) ); ?>" type="checkbox" value="1" <?php if( esc_attr( $show_register ) ) echo "checked='checked'" ?> />
					<label for="<?php echo esc_attr( $this->get_field_id( 'show_register' ) ); ?>"><?php _e( 'Show Register link', 'mfn-opts' ); ?></label>	
					<br />
					<input id="<?php echo esc_attr( $this->get_field_id( 'show_forgotten_password' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_forgotten_password' ) ); ?>" type="checkbox" value="1" <?php if( esc_attr( $show_forgotten_password ) ) echo "checked='checked'" ?> />
					<label for="<?php echo esc_attr( $this->get_field_id( 'show_forgotten_password' ) ); ?>"><?php _e( 'Show Forgotten Password link', 'mfn-opts' ); ?></label>	
				</p>
			<?php
		}
		
		
	}

}
