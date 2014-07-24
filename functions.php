<?php
/**
 * Odin functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package Odin
 * @since 2.2.0
 */

/**
 * Sets content width.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 600;
}
/**
Redimensionar imagens 
**/

function wp_image_resize($url, $width = null, $height = null, $crop = null, $single = true, $upscale = false) {
	// Validate inputs.
	if ( ! $url || ( ! $width && ! $height ) ) return false;

	// Caipt'n, ready to hook.
	if ( true === $upscale ) add_filter( 'image_resize_dimensions', 'wp_image_upscale', 10, 6 );

	// Define upload path & dir.
	$upload_info = wp_upload_dir();
	$upload_dir = $upload_info['basedir'];
	$upload_url = $upload_info['baseurl'];
	// Check if $img_url is local.
	if ( false === strpos( $url, $upload_url ) ) return false;
	// Define path of image.
	$rel_path = str_replace( $upload_url, '', $url );
	$img_path = $upload_dir . $rel_path;

	// Check if img path exists, and is an image indeed.
	if ( ! file_exists( $img_path ) or ! getimagesize( $img_path ) ) return false;

	// Get image info.
	$info = pathinfo( $img_path );
	$ext = $info['extension'];
	list( $orig_w, $orig_h ) = getimagesize( $img_path );

	// Get image size after cropping.
	$dims = image_resize_dimensions( $orig_w, $orig_h, $width, $height, $crop );
	$dst_w = $dims[4];
	$dst_h = $dims[5];

	// Return the original image only if it exactly fits the needed measures.
	if ( ! $dims && ( ( ( null === $height && $orig_w == $width ) xor ( null === $width && $orig_h == $height ) ) xor ( $height == $orig_h && $width == $orig_w ) ) ) {
		$img_url = $url;
		$dst_w = $orig_w;
		$dst_h = $orig_h;
	} else {
		// Use this to check if cropped image already exists, so we can return that instead.
		$suffix = "{$dst_w}x{$dst_h}";
		$dst_rel_path = str_replace( '.' . $ext, '', $rel_path );
		$destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";

		if ( ! $dims || ( true == $crop && false == $upscale && ( $dst_w < $width || $dst_h < $height ) ) ) {
			// Can't resize, so return false saying that the action to do could not be processed as planned.
			return false;
		}
		// Else check if cache exists.
		elseif ( file_exists( $destfilename ) && getimagesize( $destfilename ) ) {
			$img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
		}
		// Else, we resize the image and return the new resized image url.
		else {

			// Note: This pre-3.5 fallback check will edited out in subsequent version.
			if ( function_exists( 'wp_get_image_editor' ) ) {

				$editor = wp_get_image_editor( $img_path );

				if ( is_wp_error( $editor ) || is_wp_error( $editor->resize( $width, $height, $crop ) ) )
					return false;

				$resized_file = $editor->save();

				if ( ! is_wp_error( $resized_file ) ) {
					$resized_rel_path = str_replace( $upload_dir, '', $resized_file['path'] );
					$img_url = $upload_url . $resized_rel_path;
				} else {
					return false;
				}

			} else {

				$resized_img_path = image_resize( $img_path, $width, $height, $crop ); // Fallback foo.
				if ( ! is_wp_error( $resized_img_path ) ) {
					$resized_rel_path = str_replace( $upload_dir, '', $resized_img_path );
					$img_url = $upload_url . $resized_rel_path;
				} else {
					return false;
				}

			}
		}
	}

	// Okay, leave the ship.
	if ( true === $upscale ) remove_filter( 'image_resize_dimensions', 'wp_image_upscale' );

	// Return the output.
	if ( $single ) {
		// str return.
		$image = $img_url;
	} else {
		// array return.
		$image = array (
			0 => $img_url,
			1 => $dst_w,
			2 => $dst_h
		);
	}
	return $image;
}

/**
 * Odin Classes.
 */
require_once get_template_directory() . '/core/classes/class-bootstrap-nav.php';
require_once get_template_directory() . '/core/classes/class-shortcodes.php';
require_once get_template_directory() . '/core/classes/class-thumbnail-resizer.php';
// require_once get_template_directory() . '/core/classes/class-theme-options.php';
// require_once get_template_directory() . '/core/classes/class-options-helper.php';
// require_once get_template_directory() . '/core/classes/class-post-type.php';
// require_once get_template_directory() . '/core/classes/class-taxonomy.php';
// require_once get_template_directory() . '/core/classes/class-metabox.php';
// require_once get_template_directory() . '/core/classes/abstracts/abstract-front-end-form.php';
// require_once get_template_directory() . '/core/classes/class-contact-form.php';
// require_once get_template_directory() . '/core/classes/class-post-form.php';
// require_once get_template_directory() . '/core/classes/class-user-meta.php';

/**
 * Odin Widgets.
 */
require_once get_template_directory() . '/core/classes/widgets/class-widget-like-box.php';

if ( ! function_exists( 'odin_setup_features' ) ) {

	/**
	 * Setup theme features.
	 *
	 * @since  2.2.0
	 *
	 * @return void
	 */
	function odin_setup_features() {

		/**
		 * Add support for multiple languages.
		 */
		load_theme_textdomain( 'odin', get_template_directory() . '/languages' );

		/**
		 * Register nav menus.
		 */
		register_nav_menus(
			array(
				'main-menu' => __( 'Main Menu', 'odin' )
			)
		);

		/*
		 * Add post_thumbnails suport.
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * Add feed link.
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Support Custom Header.
		 */
		$default = array(
			'width'         => 0,
			'height'        => 0,
			'flex-height'   => false,
			'flex-width'    => false,
			'header-text'   => false,
			'default-image' => '',
			'uploads'       => true,
		);

		add_theme_support( 'custom-header', $default );

		/**
		 * Support Custom Background.
		 */
		$defaults = array(
			'default-color' => '',
			'default-image' => '',
		);

		add_theme_support( 'custom-background', $defaults );

		/**
		 * Support Custom Editor Style.
		 */
		add_editor_style( 'assets/css/editor-style.css' );

		/**
		 * Add support for infinite scroll.
		 */
		add_theme_support(
			'infinite-scroll',
			array(
				'type'           => 'scroll',
				'footer_widgets' => false,
				'container'      => 'content',
				'wrapper'        => false,
				'render'         => false,
				'posts_per_page' => get_option( 'posts_per_page' )
			)
		);

		/**
		 * Add support for Post Formats.
		 */
		// add_theme_support( 'post-formats', array(
		//     'aside',
		//     'gallery',
		//     'link',
		//     'image',
		//     'quote',
		//     'status',
		//     'video',
		//     'audio',
		//     'chat'
		// ) );

		/**
		 * Support The Excerpt on pages.
		 */
		// add_post_type_support( 'page', 'excerpt' );
	}
}

add_action( 'after_setup_theme', 'odin_setup_features' );

/**
 * Register widget areas.
 *
 * @since  2.2.0
 *
 * @return void
 */
function odin_widgets_init() {
	register_sidebar(
		array(
			'name' => __( 'Main Sidebar', 'odin' ),
			'id' => 'main-sidebar',
			'description' => __( 'Site Main Sidebar', 'odin' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widgettitle widget-title">',
			'after_title' => '</h3>',
		)
	);
}

add_action( 'widgets_init', 'odin_widgets_init' );

/**
 * Flush Rewrite Rules for new CPTs and Taxonomies.
 *
 * @since  2.2.0
 *
 * @return void
 */
function odin_flush_rewrite() {
	flush_rewrite_rules();
}

add_action( 'after_switch_theme', 'odin_flush_rewrite' );

/**
 * Load site scripts.
 *
 * @since  2.2.0
 *
 * @return void
 */
function odin_enqueue_scripts() {
	$template_url = get_template_directory_uri();

	// Loads Odin main stylesheet.
	wp_enqueue_style( 'odin-style', get_stylesheet_uri(), array(), null, 'all' );

	// jQuery.
	wp_enqueue_script( 'jquery' );

	// Twitter Bootstrap.
	wp_enqueue_script( 'bootstrap', $template_url . '/assets/js/libs/bootstrap.min.js', array(), null, true );

	// General scripts.
	// FitVids.
	wp_enqueue_script( 'fitvids', $template_url . '/assets/js/libs/jquery.fitvids.js', array(), null, true );

	// Main jQuery.
	wp_enqueue_script( 'odin-main', $template_url . '/assets/js/main.js', array(), null, true );

	// Grunt main file with Bootstrap, FitVids and others libs.
	// wp_enqueue_script( 'odin-main-min', $template_url . '/assets/js/main.min.js', array(), null, true );

	// Load Thread comments WordPress script.
	if ( is_singular() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'odin_enqueue_scripts', 1 );

/**
 * Odin custom stylesheet URI.
 *
 * @since  2.2.0
 *
 * @param  string $uri Default URI.
 * @param  string $dir Stylesheet directory URI.
 *
 * @return string      New URI.
 */
function odin_stylesheet_uri( $uri, $dir ) {
	return $dir . '/assets/css/style.css';
}

add_filter( 'stylesheet_uri', 'odin_stylesheet_uri', 10, 2 );

/**
 * Core Helpers.
 */
require_once get_template_directory() . '/core/helpers.php';

/**
 * WP Custom Admin.
 */
require_once get_template_directory() . '/inc/admin.php';

/**
 * Comments loop.
 */
require_once get_template_directory() . '/inc/comments-loop.php';

/**
 * WP optimize functions.
 */
require_once get_template_directory() . '/inc/optimize.php';

/**
 * WP Custom Admin.
 */
require_once get_template_directory() . '/inc/plugins-support.php';

/**
 * Custom template tags.
 */
require_once get_template_directory() . '/inc/template-tags.php';
/**
Desabilitar comentários
**/
// Disable support for comments and trackbacks in post types
function df_disable_comments_post_types_support() {
	$post_types = get_post_types();
	foreach ($post_types as $post_type) {
		if(post_type_supports($post_type, 'comments')) {
			remove_post_type_support($post_type, 'comments');
			remove_post_type_support($post_type, 'trackbacks');
		}
	}
}
add_action('admin_init', 'df_disable_comments_post_types_support');

// Close comments on the front-end
function df_disable_comments_status() {
	return false;
}
add_filter('comments_open', 'df_disable_comments_status', 20, 2);
add_filter('pings_open', 'df_disable_comments_status', 20, 2);

// Hide existing comments
function df_disable_comments_hide_existing_comments($comments) {
	$comments = array();
	return $comments;
}
add_filter('comments_array', 'df_disable_comments_hide_existing_comments', 10, 2);

// Remove comments page in menu
function df_disable_comments_admin_menu() {
	remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'df_disable_comments_admin_menu');

// Redirect any user trying to access comments page
function df_disable_comments_admin_menu_redirect() {
	global $pagenow;
	if ($pagenow === 'edit-comments.php') {
		wp_redirect(admin_url()); exit;
	}
}
add_action('admin_init', 'df_disable_comments_admin_menu_redirect');

// Remove comments metabox from dashboard
function df_disable_comments_dashboard() {
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'df_disable_comments_dashboard');

// Remove comments links from admin bar
function df_disable_comments_admin_bar() {
	if (is_admin_bar_showing()) {
		remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
	}
}
add_action('init', 'df_disable_comments_admin_bar');
/**
Opções do tema 
**/
//Função
function add_global_custom_options(){
    add_menu_page('Mkt options', 'Mkt options', 'manage_options', 'functions','global_custom_options',get_template_directory_uri().'/assets/images/menu.png',6);
}

function global_custom_options()
{
?>
<div class="wrap">
        <h2>Adicionar ou editar o Logo</h2>
        <form method="post" action="options.php">
            <?php wp_nonce_field('update-options') ?>
            <?php 
              if(function_exists( 'wp_enqueue_media' )){
                  wp_enqueue_media();
              }else{
                  wp_enqueue_style('thickbox');
                  wp_enqueue_script('media-upload');
                  wp_enqueue_script('thickbox');
              }
            ?>
            <p>
              <strong><h3>logo:</h3></strong><br />
              <input class="logo_url" type="text" name="logo" size="60" value="<?php echo get_option('logo'); ?>">
              <a href="#" class="logo_upload">Upload</a>
              <br>Preview: <br> <img style="" class="logo" src="<?php echo get_option('logo'); ?>"/>             
            </p> 
<script>
jQuery(document).ready(function($) {
	$('.logo_upload').click(function(e) {
            e.preventDefault();

            var custom_uploader = wp.media({
                title: 'Custom Image',
                button: {
                    text: 'Upload Image'
                },
                multiple: false  // Set this to true to allow multiple files to be selected
            })
            .on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                $('.logo').attr('src', attachment.url);
                $('.logo_url').val(attachment.url);

            })
            .open();
        });
});
</script>
<?php 
}
add_action('admin_menu', 'add_global_custom_options');

/**
Mosaico
**/

function add_mosaico_posts(){
	function new_excerpt_more($more) {
       global $post;
	return ' <a href="'. get_permalink($post->ID) . '"></a>';
}
add_filter('excerpt_more', 'new_excerpt_more');
	function novo_tamanho_do_resumo($length) {

	return 8;

}
add_filter('excerpt_length', 'novo_tamanho_do_resumo');

?>
	<div class="mosaico">

		<ul style="list-style: none;padding-left: 0;">
		 <?php 
		 $recent = new WP_Query("category_name=destaques&showposts=4&orderby=id"); 
		 $contador = 1;
		 while($recent->have_posts()) : $recent->the_post();
		 ?> 
		 	<li>
		 		<div class="wrap">
		 			<div class="wrap_thumbnail thumb<?php echo $contador++ . '';?>"style="background: url(<?php echo wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ); ?>) no-repeat center center">

		 				<?php //the_post_thumbnail();?>
		 				<a href="<?php the_permalink(); ?>">
		 				<div class="titulo_mosaico">

		 					
		 						<?php the_title();?>
		 							<div class="mosaico_linha"></div>
		 					
		 					<?php the_excerpt();?>
		 					</a>
		 				</div>
		 			</div>
		 					
		 		</div>
		 	</li> 
		 	<?php endwhile; ?> </ul>


	</div>
<?php
}
add_shortcode('mosaico', 'add_mosaico_posts');

/**
Últimos posts
**/
function add_ultimos_posts(){

?>
		<div class="ultimos_posts">
			<h2 class="titulo">ÚLTIMAS</h2>
			<?php 
			$recent = new WP_Query("showposts=4"); 
			while($recent->have_posts()) : $recent->the_post();
			 ?>
			 <ul>
			 	<li>
			 		<a href="<?php the_permalink(); ?>">
			 		<div class="post_thumbnail" style="background: url(<?php echo wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ); ?>) no-repeat center center"></div>
			 		</a>
			 		<div class="post_content">
			 			<a href="<?php the_permalink(); ?>">
			 			<p class="post_title"><?php the_title();?></p></a>
			 			<span class="post_excerpt"><?php the_excerpt();?></span>
			 			<p class="post_time"><?php the_time('j \d\e F \d\e Y');?></p>
			 		</div>
			 		
			 	</li>
			 </ul>
			 <?php endwhile;?>
		</div>

<?php
}
add_shortcode('ultimos', 'add_ultimos_posts');

/**
Lorem
**/
function add_lorem(){

?>
		<div class="ultimos_posts">
			<h2 class="titulo">LOREM</h2>
			<?php 
			$recent = new WP_Query("category_name=lorem&showposts=4&orderby=id"); 
			while($recent->have_posts()) : $recent->the_post();
			 ?>
			 <ul>
			 	<li>
			 		<a href="<?php the_permalink(); ?>">
			 		<div class="post_thumbnail" style="background: url(<?php echo wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ); ?>) no-repeat center center"></div>
			 		</a>
			 		<div class="post_content">
			 			<a href="<?php the_permalink(); ?>">
			 			<p class="post_title"><?php the_title();?></p></a>
			 			<span class="post_excerpt"><?php the_excerpt();?></span>
			 			<p class="post_time"><?php the_time('j \d\e F \d\e Y');?></p>
			 		</div>
			 		
			 	</li>
			 </ul>
			 <?php endwhile;?>
		</div>

<?php
}
add_shortcode('lorem', 'add_lorem');

/**
ipsum
**/
function add_ipsum(){

?>
		<div class="ultimos_posts">
			<h2 class="titulo">IPSUM</h2>
			<?php 
			$recent = new WP_Query("category_name=ipsum&showposts=4&orderby=id"); 
			while($recent->have_posts()) : $recent->the_post();
			 ?>
			 <ul>
			 	<li>
			 		<a href="<?php the_permalink(); ?>">
			 		<div class="post_thumbnail" style="background: url(<?php echo wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ); ?>) no-repeat center center"></div>
			 		</a>
			 		<div class="post_content">
			 			<a href="<?php the_permalink(); ?>">
			 			<p class="post_title"><?php the_title();?></p></a>
			 			<span class="post_excerpt"><?php the_excerpt();?></span>
			 			<p class="post_time"><?php the_time('j \d\e F \d\e Y');?></p>
			 		</div>
			 		
			 	</li>
			 </ul>
			 <?php endwhile;?>
		</div>

<?php
}
add_shortcode('ipsum', 'add_ipsum');