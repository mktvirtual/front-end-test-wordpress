<?php
/**
 * Theme Info
 *
 * Adds a simple Theme Info page to the Appearance section of the WordPress Dashboard.
 *
 * @package Palm Beach
 */

/**
 * Add Theme Info page to admin menu
 */
function palm_beach_theme_info_menu_link() {

	// Get theme details.
	$theme = wp_get_theme();

	add_theme_page(
		sprintf( esc_html__( 'Welcome to %1$s %2$s', 'palm-beach' ), $theme->get( 'Name' ), $theme->get( 'Version' ) ),
		esc_html__( 'Theme Info', 'palm-beach' ),
		'edit_theme_options',
		'palm-beach',
		'palm_beach_theme_info_page'
	);

}
add_action( 'admin_menu', 'palm_beach_theme_info_menu_link' );

/**
 * Display Theme Info page
 */
function palm_beach_theme_info_page() {

	// Get theme details.
	$theme = wp_get_theme();
	?>

	<div class="wrap theme-info-wrap">

		<h1><?php printf( esc_html__( 'Welcome to %1$s %2$s', 'palm-beach' ), $theme->get( 'Name' ), $theme->get( 'Version' ) ); ?></h1>

		<div class="theme-description"><?php echo $theme->get( 'Description' ); ?></div>

		<hr>
		<div class="important-links clearfix">
			<p><strong><?php esc_html_e( 'Theme Links', 'palm-beach' ); ?>:</strong>
				<a href="<?php echo esc_url( __( 'https://themezee.com/themes/palm-beach/', 'palm-beach' ) . '?utm_source=theme-info&utm_medium=textlink&utm_campaign=palm-beach&utm_content=theme-page' ); ?>" target="_blank"><?php esc_html_e( 'Theme Page', 'palm-beach' ); ?></a>
				<a href="http://preview.themezee.com/palm-beach/?utm_source=theme-info&utm_medium=textlink&utm_campaign=palm-beach&utm_content=demo" target="_blank"><?php esc_html_e( 'Theme Demo', 'palm-beach' ); ?></a>
				<a href="<?php echo esc_url( __( 'https://themezee.com/docs/palm-beach-documentation/', 'palm-beach' ) . '?utm_source=theme-info&utm_medium=textlink&utm_campaign=palm-beach&utm_content=documentation' ); ?>" target="_blank"><?php esc_html_e( 'Theme Documentation', 'palm-beach' ); ?></a>
				<a href="<?php echo esc_url( __( 'https://wordpress.org/support/theme/palm-beach/reviews/?filter=5', 'palm-beach' ) ); ?>" target="_blank"><?php esc_html_e( 'Rate this theme', 'palm-beach' ); ?></a>
			</p>
		</div>
		<hr>

		<div id="getting-started">

			<h3><?php printf( esc_html__( 'Getting Started with %s', 'palm-beach' ), $theme->get( 'Name' ) ); ?></h3>

			<div class="columns-wrapper clearfix">

				<div class="column column-half clearfix">

					<div class="section">
						<h4><?php esc_html_e( 'Theme Documentation', 'palm-beach' ); ?></h4>

						<p class="about">
							<?php esc_html_e( 'You need help to setup and configure this theme? We got you covered with an extensive theme documentation on our website.', 'palm-beach' ); ?>
						</p>
						<p>
							<a href="<?php echo esc_url( __( 'https://themezee.com/docs/palm-beach-documentation/', 'palm-beach' ) . '?utm_source=theme-info&utm_medium=button&utm_campaign=palm-beach&utm_content=documentation' ); ?>" target="_blank" class="button button-secondary">
								<?php printf( esc_html__( 'View %s Documentation', 'palm-beach' ), 'Palm Beach' ); ?>
							</a>
						</p>
					</div>

					<div class="section">
						<h4><?php esc_html_e( 'Theme Options', 'palm-beach' ); ?></h4>

						<p class="about">
							<?php printf( esc_html__( '%s makes use of the Customizer for all theme settings. Click on "Customize Theme" to open the Customizer now.', 'palm-beach' ), $theme->get( 'Name' ) ); ?>
						</p>
						<p>
							<a href="<?php echo wp_customize_url(); ?>" class="button button-primary"><?php esc_html_e( 'Customize Theme', 'palm-beach' ); ?></a>
						</p>
					</div>

				</div>

				<div class="column column-half clearfix">

					<img src="<?php echo get_template_directory_uri(); ?>/screenshot.jpg" />

				</div>

			</div>

		</div>

		<hr>

		<div id="more-features">

			<h3><?php esc_html_e( 'Get more features', 'palm-beach' ); ?></h3>

			<div class="columns-wrapper clearfix">

				<div class="column column-half clearfix">

					<div class="section">
						<h4><?php esc_html_e( 'Pro Version Add-on', 'palm-beach' ); ?></h4>

						<p class="about">
							<?php printf( esc_html__( 'Purchase the %s Pro Add-on and get additional features and advanced customization options.', 'palm-beach' ), 'Palm Beach' ); ?>
						</p>
						<p>
							<a href="<?php echo esc_url( __( 'https://themezee.com/addons/palm-beach-pro/', 'palm-beach' ) . '?utm_source=theme-info&utm_medium=button&utm_campaign=palm-beach&utm_content=pro-version' ); ?>" target="_blank" class="button button-secondary">
								<?php printf( esc_html__( 'Learn more about %s Pro', 'palm-beach' ), 'Palm Beach' ); ?>
							</a>
						</p>
					</div>

				</div>

				<div class="column column-half clearfix">

					<div class="section">
						<h4><?php esc_html_e( 'Recommended Plugins', 'palm-beach' ); ?></h4>

						<p class="about">
							<?php esc_html_e( 'Extend the functionality of your WordPress website with our free and easy to use plugins.', 'palm-beach' ); ?>
						</p>
						<p>
							<a href="<?php echo esc_url( admin_url( 'plugin-install.php?tab=search&type=author&s=themezee' ) ); ?>" class="button button-secondary">
								<?php esc_html_e( 'Install Plugins', 'palm-beach' ); ?>
							</a>
						</p>
					</div>

				</div>

			</div>

		</div>

		<hr>

		<div id="theme-author">

			<p>
				<?php printf( esc_html__( '%1$s is proudly brought to you by %2$s. If you like this theme, %3$s :)', 'palm-beach' ),
					$theme->get( 'Name' ),
					'<a target="_blank" href="' . __( 'https://themezee.com/', 'palm-beach' ) . '?utm_source=theme-info&utm_medium=footer&utm_campaign=palm-beach" title="ThemeZee">ThemeZee</a>',
					'<a target="_blank" href="' . __( 'https://wordpress.org/support/theme/palm-beach/reviews/?filter=5', 'palm-beach' ) . '" title="' . esc_attr__( 'Review Palm Beach', 'palm-beach' ) . '">' . esc_html__( 'rate it', 'palm-beach' ) . '</a>'
				); ?>
			</p>

		</div>

	</div>

	<?php
}

/**
 * Enqueues CSS for Theme Info page
 *
 * @param int $hook Hook suffix for the current admin page.
 */
function palm_beach_theme_info_page_css( $hook ) {

	// Load styles and scripts only on theme info page.
	if ( 'appearance_page_palm-beach' !== $hook ) {
		return;
	}

	// Embed theme info css style.
	wp_enqueue_style( 'palm-beach-theme-info-css', get_template_directory_uri() . '/css/theme-info.css' );

}
add_action( 'admin_enqueue_scripts', 'palm_beach_theme_info_page_css' );
