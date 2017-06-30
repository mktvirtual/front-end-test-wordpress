<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Palm Beach
 */

get_header(); ?>

	<section id="primary" class="content-single content-area">
		<main id="main" class="site-main" role="main">

			<div class="error-404 not-found type-page">

				<div class="entry-content clearfix">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search or one of the links below?', 'palm-beach' ); ?></p>

					<?php get_search_form(); ?>

					<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

					<?php the_widget( 'WP_Widget_Archives', 'dropdown=1' ); ?>

					<?php the_widget( 'WP_Widget_Categories', 'dropdown=1' ); ?>

					<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>

					<?php the_widget( 'WP_Widget_Pages' ); ?>

				</div>

			</div>

		</main><!-- #main -->
	</section><!-- #primary -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
