<?php
/**
 * The template for displaying search results pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Palm Beach
 */

get_header();

if ( have_posts() ) : ?>

	<header class="page-header clearfix">

		<h1 class="archive-title"><?php printf( esc_html__( 'Search Results for: %s', 'palm-beach' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
		<p><?php get_search_form(); ?></p>

	</header>

<?php endif; ?>

	<section id="primary" class="content-archive content-area">
		<main id="main" class="site-main" role="main">

			<?php
			if ( have_posts() ) : ?>

				<div id="post-wrapper" class="post-wrapper clearfix">

					<?php while ( have_posts() ) : the_post();

						if ( 'post' === get_post_type() ) :

							get_template_part( 'template-parts/content' );

						else :

							get_template_part( 'template-parts/content', 'search' );

						endif;

					endwhile; ?>

				</div>

				<?php palm_beach_pagination(); ?>

			<?php
			else :

				get_template_part( 'template-parts/content', 'none' );

			endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
