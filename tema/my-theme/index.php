<?php get_header(); ?>
<?php get_template_part('template-parts/home/home','carousel')?>
<?php get_template_part('template-parts/home/home','posts')?>
<?php get_template_part('template-parts/home/home','mapa')?>
<?php get_template_part('template-parts/home/home','newsletter')?>
    <?php /* if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>

			<?php
			// Start the loop.
			while ( have_posts() ) : the_post();
			the_title('<h2>','</h2>');
			    the_content();
			// End the loop.
			endwhile;

		// If no content, include the "No posts found" template.
		else :
			echo '<p>Sem conteúdo</p>';

		endif;
		?>
<?php */get_footer(); ?>