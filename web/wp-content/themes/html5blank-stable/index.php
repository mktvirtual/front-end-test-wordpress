<?php get_header(); ?>

	<main role="main">
		<!-- section -->
		<section>
			<?php get_template_part('partial/promocao'); ?>
		</section>
		<!-- /section -->
		<section>
			<div class="box-widgets-2">
				<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-area-2')) ?>
			</div>
		</section>
	</main>



<?php get_footer(); ?>
