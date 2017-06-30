<?php
/**
 * The template for displaying single posts
 *
 * @package Palm Beach
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content clearfix">

		<?php the_content(); ?>

		<?php wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'palm-beach' ),
			'after'  => '</div>',
		) ); ?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php palm_beach_entry_tags(); ?>
		<?php palm_beach_post_navigation(); ?>

	</footer><!-- .entry-footer -->

</article>
