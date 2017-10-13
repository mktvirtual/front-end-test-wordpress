<?php
/**
 * Widget Muffin Flickr
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

if ( ! class_exists( 'Mfn_Flickr_Widget' ) ){
	class Mfn_Flickr_Widget extends WP_Widget {
	
		
		/* ---------------------------------------------------------------------------
		 * Constructor
		 * --------------------------------------------------------------------------- */
		function __construct(){
			
			$widget_ops = array( 'classname' => 'widget_mfn_flickr', 'description' => __( 'Use this widget on pages to display photos from Flickr photostream.', 'mfn-opts' ) );
		
			parent::__construct( 'widget_mfn_flickr', __( 'Muffin Flickr', 'mfn-opts' ), $widget_ops );
	
			$this->alt_option_name = 'widget_mfn_flickr';
		}
		
		
		/* ---------------------------------------------------------------------------
		 * Outputs the HTML for this widget.
		 * --------------------------------------------------------------------------- */
		function widget( $args, $instance ) {
	
			if ( ! isset( $args['widget_id'] ) ) $args['widget_id'] = null;
			extract( $args, EXTR_SKIP );
	
			echo $before_widget;
			
			$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base);
			if( $title ) echo $before_title . $title . $after_title;
			
			echo '<div class="Flickr">';
				echo'<script src="http'. mfn_ssl() .'://www.flickr.com/badge_code_v2.gne?count='. $instance['count'] .'&amp;display='. $instance['order'] .'&amp;size=s&amp;layout=x&amp;source=user&amp;user='. $instance['userID'] .'"></script>';
			echo '</div>';
	
			echo $after_widget;
		}
	
	
		/* ---------------------------------------------------------------------------
		 * Deals with the settings when they are saved by the admin.
		 * --------------------------------------------------------------------------- */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['userID'] = strip_tags( $new_instance['userID'] );
			$instance['count'] = (int) $new_instance['count'];
			$instance['order'] = strip_tags( $new_instance['order'] );
			
			return $instance;
		}
	
		
		/* ---------------------------------------------------------------------------
		 * Displays the form for this widget on the Widgets page of the WP Admin area.
		 * --------------------------------------------------------------------------- */
		function form( $instance ) {
			
			$title = isset( $instance['title']) ? esc_attr( $instance['title'] ) : '';
			$userID = isset( $instance['userID']) ? esc_attr( $instance['userID'] ) : '71865026@N00';
			$count = isset( $instance['count'] ) ? absint( $instance['count'] ) : 6;
			$order = isset( $instance['order']) ? esc_attr( $instance['order'] ) : 'latest';
	
			?>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'mfn-opts' ); ?></label>
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
				</p>
				
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'userID' ) ); ?>"><?php _e( 'Flickr User ID:', 'mfn-opts' ); ?></label>
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'userID' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'userID' ) ); ?>" type="text" value="<?php echo esc_attr( $userID ); ?>" />
					<?php _e( 'Use <a href="http://idgettr.com/" target="_blank">this</a> tool to find your Flickr user ID', 'mfn-opts' ); ?>
				</p>
				
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php _e( 'Number of photos:', 'mfn-opts' ); ?></label>
					<input id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" size="3"/>
					[1-10]
				</p>
				
				<p>
					<input id="<?php echo esc_attr( $this->get_field_id( 'order_latest' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" type="radio" value="latest" <?php if( $order=="latest" ) echo "checked='checked'" ?>" />
					<label for="<?php echo esc_attr( $this->get_field_id( 'order_latest' ) ); ?>"><?php _e( 'Latest uploads', 'mfn-opts' ); ?></label>	
					<br/>
					<input id="<?php echo esc_attr( $this->get_field_id( 'order_random' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" type="radio" value="random" <?php if( $order=="random" ) echo "checked='checked'" ?>" />
					<label for="<?php echo esc_attr( $this->get_field_id( 'order_random' ) ); ?>"><?php _e( 'Random photos', 'mfn-opts' ); ?></label>	
				</p>
			<?php
		}
		
		
	}
}
