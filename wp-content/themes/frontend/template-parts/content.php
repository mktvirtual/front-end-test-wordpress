<?php
/**
 * The template for displaying articles in the loop with post excerpts
 *
 * @package Palm Beach
 */

?>

<div class="post-column clearfix">

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="position:relative;">

		<?php palm_beach_post_image(); ?>

		<div class="text-post">

			<?php the_title( sprintf( '<h2 class="entry-title">', esc_url( get_permalink() ) ), '</h2>' ); ?>

			<div class="entry-content entry-excerpt clearfix">
				<?php the_excerpt(); ?>
				<?php palm_beach_more_link(); ?>
			</div><!-- .entry-content -->

		</div>

	</article>

</div>
