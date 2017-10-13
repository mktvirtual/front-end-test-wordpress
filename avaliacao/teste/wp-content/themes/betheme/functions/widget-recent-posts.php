<?php
/**
 * Widget Muffin Recent Posts
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

if ( ! class_exists( 'Mfn_Recent_Posts_Widget' ) ){
	class Mfn_Recent_Posts_Widget extends WP_Widget {
	
		
		/* ---------------------------------------------------------------------------
		 * Constructor
		 * --------------------------------------------------------------------------- */
		function __construct(){
			
			$widget_ops = array( 'classname' => 'widget_mfn_recent_posts', 'description' => __( 'The most recent posts on your site.', 'mfn-opts' ) );
			
			parent::__construct( 'widget_mfn_recent_posts', __( 'Muffin Recent Posts', 'mfn-opts' ), $widget_ops );
			
			$this->alt_option_name = 'widget_mfn_recent_posts';
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
			
			$args = array(
				'posts_per_page'		=> $instance['count'] ? intval($instance['count']) : 0,
				'no_found_rows'			=> true,
				'post_status'			=> 'publish',
				'ignore_sticky_posts'	=> true
			);
			if( $instance['category'] ) $args['category_name'] = $instance['category'];
			
			$r = new WP_Query( apply_filters( 'widget_posts_args', $args ) );
			
			$output = false;
			if ($r->have_posts()){           
				$output .= '<div class="Recent_posts">';
					$output .= '<ul>';
						while ( $r->have_posts() ){
							$r->the_post();
							
							$class = ' format-'. get_post_format();
							if( ! has_post_thumbnail( get_the_ID() ) ){
								if( ! in_array( get_post_format(), array('quote','link') ) ){
									$class .= ' no-img';
								}
							}
								
							$output .= '<li class="post'. $class .'">';
								$output .= '<a href="'. get_permalink() .'">';
								
									$output .= '<div class="photo">';
										if( has_post_thumbnail() ) $output .= get_the_post_thumbnail( get_the_ID(), 'blog-navi', array('class'=>'scale-with-grid' ) );
										if( comments_open() ) $output .= '<span class="c">'. get_comments_number() .'</span>';
									$output .= '</div>';
						
									$output .= '<div class="desc">';
										$output .= '<h6>'. get_the_title() .'</h6>';
										$output .= '<span class="date"><i class="icon-clock"></i>'. get_the_date() .'</span>';
			                       	$output .= '</div>';
			                       	
		                       	$output .= '</a>';
	                       	$output .= '</li>';
	                       	
						}
						wp_reset_postdata();
					$output .= '</ul>';
				$output .= '</div>'."\n";
			}
			echo $output;
	
			echo $after_widget;
		}
	
	
		/* ---------------------------------------------------------------------------
		 * Deals with the settings when they are saved by the admin.
		 * --------------------------------------------------------------------------- */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			
			$instance['title'] 		= strip_tags( $new_instance['title'] );
			$instance['count'] 		= (int) $new_instance['count'];
			$instance['category'] 	= strip_tags( $new_instance['category'] );
			
			return $instance;
		}
	
		
		/* ---------------------------------------------------------------------------
		 * Displays the form for this widget on the Widgets page of the WP Admin area.
		 * --------------------------------------------------------------------------- */
		function form( $instance ) {
			
			$title		= isset( $instance['title']) ? esc_attr( $instance['title'] ) : '';
			$count		= isset( $instance['count'] ) ? absint( $instance['count'] ) : 5;
			$category	= isset( $instance['category']) ? esc_attr( $instance['category'] ) : '';
	
			?>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'mfn-opts' ); ?></label>
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
				</p>
				
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php _e( 'Category:', 'mfn-opts' ); ?></label>
					<select id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>" class="widefat" >
						<?php 
							$categories = mfn_get_categories( 'category' );
							foreach( $categories as $k=>$v ){
								$selected = ( $category == $k ) ? 'selected="selected"' : false;
								echo '<option value="'. $k .'" '. $selected .'>'. $v .'</option>';
							}
						?>
					</select>
				</p>
				
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php _e( 'Number of posts:', 'mfn-opts' ); ?></label>
					<input id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" size="3"/>
				</p>
				
			<?php
		}
		
		
	}
}
