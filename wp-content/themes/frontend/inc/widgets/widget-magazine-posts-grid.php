<?php
/**
 * Magazine Posts Grid Widget
 *
 * Display the latest posts from a selected category in a grid layout.
 * Intented to be used in the Magazine Homepage widget area to built a magazine layouted page.
 *
 * @package Palm Beach
 */

/**
 * Magazine Widget Class
 */
class Palm_Beach_Magazine_Posts_Grid_Widget extends WP_Widget {

	/**
	 * Widget Constructor
	 */
	function __construct() {

		// Setup Widget.
		parent::__construct(
			'palm-beach-magazine-posts-grid', // ID.
			sprintf( esc_html__( 'Magazine Posts: Grid (%s)', 'palm-beach' ), wp_get_theme()->Name ), // Name.
			array(
				'classname' => 'palm_beach_magazine_posts_grid',
				'description' => esc_html__( 'Displays your posts from a selected category in a grid layout. Please use this widget ONLY in the Magazine Homepage widget area.', 'palm-beach' ),
				'customize_selective_refresh' => true,
			) // Args.
		);

		// Delete Widget Cache on certain actions.
		add_action( 'save_post', array( $this, 'delete_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'delete_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'delete_widget_cache' ) );

	}


	/**
	 * Set default settings of the widget
	 */
	private function default_settings() {

		$defaults = array(
			'title'				=> '',
			'category'			=> 0,
			'layout'			=> 'three-columns',
			'number'			=> 6,
			'excerpt'			=> false,
			'post_meta'			=> true,
		);

		return $defaults;

	}


	/**
	 * Main Function to display the widget
	 *
	 * @uses this->render()
	 *
	 * @param array $args / Parameters from widget area created with register_sidebar().
	 * @param array $instance / Settings for this widget instance.
	 */
	function widget( $args, $instance ) {

		$cache = array();

		// Get Widget Object Cache.
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'widget_palm_beach_magazine_posts_grid', 'widget' );
		}
		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		// Display Widget from Cache if exists.
		if ( isset( $cache[ $this->id ] ) ) {
			echo $cache[ $this->id ];
			return;
		}

		// Start Output Buffering.
		ob_start();

		// Get Widget Settings.
		$settings = wp_parse_args( $instance, $this->default_settings() );

		// Set Widget class.
		$class = ( 'three-columns' === $settings['layout'] ) ? 'magazine-grid-three-columns' : 'magazine-grid-two-columns';

		// Output.
		echo $args['before_widget'];
		?>

		<div class="widget-magazine-posts-grid widget-magazine-posts clearfix">

			<?php // Display Title.
			$this->widget_title( $args, $settings ); ?>

			<div class="widget-magazine-posts-content <?php echo $class; ?> magazine-grid">

				<?php $this->render( $settings ); ?>

			</div>

		</div>

		<?php
		echo $args['after_widget'];

		// Set Cache.
		if ( ! $this->is_preview() ) {
			$cache[ $this->id ] = ob_get_flush();
			wp_cache_set( 'widget_palm_beach_magazine_posts_grid', $cache, 'widget' );
		} else {
			ob_end_flush();
		}

	} // widget()


	/**
	 * Renders the Widget Content
	 *
	 * Switches between two or three column layout style based on widget settings
	 *
	 * @uses this->magazine_posts_two_column_grid() or this->magazine_posts_three_column_grid()
	 * @used-by this->widget()
	 *
	 * @param array $settings / Settings for this widget instance.
	 */
	function render( $settings ) {

		// Get latest posts from database.
		$query_arguments = array(
			'posts_per_page' => (int) $settings['number'],
			'ignore_sticky_posts' => true,
			'cat' => (int) $settings['category'],
		);
		$posts_query = new WP_Query( $query_arguments );
		$i = 0;

		// Set template.
		$template = ( 'three-columns' === $settings['layout'] ) ? 'medium-post' : 'large-post';

		// Check if there are posts.
		if ( $posts_query->have_posts() ) :

			// Limit the number of words for the excerpt.
			add_filter( 'excerpt_length', 'palm_beach_magazine_posts_excerpt_length' );

			// Display Posts.
			while ( $posts_query->have_posts() ) :

				$posts_query->the_post();

				set_query_var( 'palm_beach_post_meta', (bool) $settings['post_meta'] );
				set_query_var( 'palm_beach_post_excerpt', (bool) $settings['excerpt'] );
				?>

				<div class="post-column">

					<?php get_template_part( 'template-parts/widgets/magazine-content', $template ); ?>

				</div>

				<?php
			endwhile;

			// Remove excerpt filter.
			remove_filter( 'excerpt_length', 'palm_beach_magazine_posts_excerpt_length' );

		endif;

		// Reset Postdata.
		wp_reset_postdata();

	} // render()


	/**
	 * Displays Widget Title
	 *
	 * @param array $args / Parameters from widget area created with register_sidebar().
	 * @param array $settings / Settings for this widget instance.
	 */
	function widget_title( $args, $settings ) {

		// Add Widget Title Filter.
		$widget_title = apply_filters( 'widget_title', $settings['title'], $settings, $this->id_base );

		if ( ! empty( $widget_title ) ) :

			// Link Category Title.
			if ( $settings['category'] > 0 ) :

				// Set Link URL and Title for Category.
				$link_title = sprintf( __( 'View all posts from category %s', 'palm-beach' ), get_cat_name( $settings['category'] ) );
				$link_url = get_category_link( $settings['category'] );

				// Display Widget Title with link to category archive.
				echo '<div class="widget-header">';
				echo '<h3 class="widget-title"><a class="category-archive-link" href="' . esc_url( $link_url ) . '" title="' . esc_attr( $link_title ) . '">' . $widget_title . '</a></h3>';
				echo '</div>';

			else :

				// Display default Widget Title without link.
				echo $args['before_title'] . $widget_title . $args['after_title'];

			endif;

		endif;

	} // widget_title()


	/**
	 * Update Widget Settings
	 *
	 * @param array $new_instance / New Settings for this widget instance.
	 * @param array $old_instance / Old Settings for this widget instance.
	 * @return array $instance
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['category'] = (int) $new_instance['category'];
		$instance['layout'] = esc_attr( $new_instance['layout'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['excerpt'] = ! empty( $new_instance['excerpt'] );
		$instance['post_meta'] = ! empty( $new_instance['post_meta'] );

		$this->delete_widget_cache();

		return $instance;
	}


	/**
	 * Displays Widget Settings Form in the Backend
	 *
	 * @param array $instance / Settings for this widget instance.
	 */
	function form( $instance ) {

		// Get Widget Settings.
		$settings = wp_parse_args( $instance, $this->default_settings() );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'palm-beach' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $settings['title'] ); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e( 'Category:', 'palm-beach' ); ?></label><br/>
			<?php // Display Category Select.
				$args = array(
					'show_option_all'    => esc_html__( 'All Categories', 'palm-beach' ),
					'show_count' 		 => true,
					'hide_empty'		 => false,
					'selected'           => $settings['category'],
					'name'               => $this->get_field_name( 'category' ),
					'id'                 => $this->get_field_id( 'category' ),
				);
				wp_dropdown_categories( $args );
			?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'layout' ); ?>"><?php esc_html_e( 'Grid Layout:', 'palm-beach' ); ?></label><br/>
			<select id="<?php echo $this->get_field_id( 'layout' ); ?>" name="<?php echo $this->get_field_name( 'layout' ); ?>">
				<option <?php selected( $settings['layout'], 'two-columns' ); ?> value="two-columns" ><?php esc_html_e( 'Two Columns Grid', 'palm-beach' ); ?></option>
				<option <?php selected( $settings['layout'], 'three-columns' ); ?> value="three-columns" ><?php esc_html_e( 'Three Columns Grid', 'palm-beach' ); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of posts:', 'palm-beach' ); ?>
				<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo absint( $settings['number'] ); ?>" size="3" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'post_meta' ); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $settings['post_meta'] ); ?> id="<?php echo $this->get_field_id( 'post_meta' ); ?>" name="<?php echo $this->get_field_name( 'post_meta' ); ?>" />
				<?php esc_html_e( 'Display post meta', 'palm-beach' ); ?>
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'excerpt' ); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $settings['excerpt'] ); ?> id="<?php echo $this->get_field_id( 'excerpt' ); ?>" name="<?php echo $this->get_field_name( 'excerpt' ); ?>" />
				<?php esc_html_e( 'Display post excerpt', 'palm-beach' ); ?>
			</label>
		</p>



		<?php

	} // form()


	/**
	 * Delete Widget Cache
	 */
	public function delete_widget_cache() {

		wp_cache_delete( 'widget_palm_beach_magazine_posts_grid', 'widget' );

	}
}

/**
 * Register Widget
 */
function palm_beach_register_magazine_posts_grid_widget() {

	register_widget( 'Palm_Beach_Magazine_Posts_Grid_Widget' );

}
add_action( 'widgets_init', 'palm_beach_register_magazine_posts_grid_widget' );
