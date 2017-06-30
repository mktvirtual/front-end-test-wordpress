<div class="theme-steps-list">

	<div class="theme-steps">
		<h3><?php echo esc_html__('Step 1 - Recommended Actions', 'accesspress-store'); ?></h3>
		<p><?php echo esc_html__('Before you start setting up the theme, there are few recommended action that you need to follow. These recommendation helps you to set up the theme more easily and quickly.', 'accesspress-store'); ?></p>
		<a class="button" href="<?php echo esc_url(admin_url('/themes.php?page=accesspressstore-welcome&section=import_demo')); ?>"><?php echo esc_html__('Recommended Actions', 'accesspress-store'); ?></a>
	</div>

	<div class="theme-steps">
		<h3><?php echo esc_html__('Step 2 - Customizer Options Panel', 'accesspress-store'); ?></h3>
		<p><?php echo esc_html__('Using the WordPress Customizer you can easily customize every aspect of the theme.', 'accesspress-store'); ?></p>
		<a class="button button-primary" href="<?php echo esc_url(admin_url('customize.php')); ?>"><?php echo esc_html__('Go to Customizer Panels', 'accesspress-store'); ?></a>
	</div>

</div>

<div class="theme-image">
	<img src="<?php echo get_template_directory_uri() ?>/screenshot.png">
</div>