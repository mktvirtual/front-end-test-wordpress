<?php
/**
 * The main template file.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

get_header();

// Class
$blog_classes 	= array();
$section_class 	= array();


// Class | Layout
if( $_GET && key_exists( 'mfn-b', $_GET ) ){
	$blog_layout = esc_html( $_GET['mfn-b'] ); // demo
} else {
	$blog_layout = mfn_opts_get( 'blog-layout', 'classic' );
}
$blog_classes[] = $blog_layout;

// Layout | Masonry Tiles | Quick Fix
if( $blog_layout == 'masonry tiles' ){
	$blog_layout = 'masonry';
}


// Class | Columns
if( $_GET && key_exists( 'mfn-bc', $_GET ) ){
	$blog_classes[] = 'col-'. esc_html( $_GET['mfn-bc'] ); // demo
} else {
	$blog_classes[] = 'col-'. mfn_opts_get( 'blog-columns', 3 );
}


if( $_GET && key_exists( 'mfn-bfw', $_GET ) ){
	$section_class[] = 'full-width'; // demo
}
if( mfn_opts_get( 'blog-full-width' ) && ( $blog_layout == 'masonry' ) ){
	$section_class[] = 'full-width';
}
$section_class = implode( ' ', $section_class );


// Isotope
if( $blog_layout == 'masonry' ) $blog_classes[] = 'isotope';


// Ajax | load more
$load_more = mfn_opts_get( 'blog-load-more' );


// Translate
$translate['filter'] 		= mfn_opts_get('translate') ? mfn_opts_get('translate-filter','Filter by') : __('Filter by','betheme');
$translate['tags'] 			= mfn_opts_get('translate') ? mfn_opts_get('translate-tags','Tags') : __('Tags','betheme');
$translate['authors'] 		= mfn_opts_get('translate') ? mfn_opts_get('translate-authors','Authors') : __('Authors','betheme');
$translate['all'] 			= mfn_opts_get('translate') ? mfn_opts_get('translate-all','Show all') : __('Show all','betheme');
$translate['categories'] 	= mfn_opts_get('translate') ? mfn_opts_get('translate-categories','Categories') : __('Categories','betheme');
$translate['item-all'] 		= mfn_opts_get('translate') ? mfn_opts_get('translate-item-all','All') : __('All','betheme');
?>

<!-- #Content -->
<div id="Content">
	<div class="content_wrapper clearfix">

		<!-- .sections_group -->
		<div class="sections_group">
			
			
			<div class="extra_content">
				<?php
					if( get_option( 'page_for_posts' ) || mfn_opts_get( 'blog-page' ) ){
						if( category_description() ){
							echo '<div class="section the_content category_description">';
								echo '<div class="section_wrapper">';
									echo '<div class="the_content_wrapper">';
										echo category_description();
									echo '</div>';
								echo '</div>';
							echo '</div>';
						} else {
							mfn_builder_print( mfn_ID(), true );
						}
					}
				?>
			</div>
			
			<?php if( ( $filters = mfn_opts_get( 'blog-filters' ) ) && in_array( get_post_type(), array( 'post', 'tribe_events' ) ) && ! is_singular() && get_option( 'page_for_posts' ) ): ?>
				<div class="section section-filters">
					<div class="section_wrapper clearfix">
					
						<?php 
							$filters_class = '';
							if( $blog_layout == 'masonry' ) $filters_class .= ' isotope-filters';
							if( $filters != 1 ){
								$filters_class .= ' only '. $filters;
							}
						?>
					
						<!-- #Filters -->
						<div id="Filters" class="column one <?php echo $filters_class; ?>">
						
							<ul class="filters_buttons">
								<li class="label"><?php echo $translate['filter']; ?></li>
								<li class="categories"><a class="open" href="#"><i class="icon-docs"></i><?php echo $translate['categories']; ?><i class="icon-down-dir"></i></a></li>
								<li class="tags"><a class="open" href="#"><i class="icon-tag"></i><?php echo $translate['tags']; ?><i class="icon-down-dir"></i></a></li>
								<li class="authors"><a class="open" href="#"><i class="icon-user"></i><?php echo $translate['authors']; ?><i class="icon-down-dir"></i></a></li>
								<li class="reset"><a class="close" data-rel="*" href="<?php echo get_permalink( mfn_ID() ); ?>"><i class="icon-cancel"></i><?php echo $translate['all']; ?></a></li>
							</ul>
							
							<div class="filters_wrapper">
								<ul class="categories">
									<?php 
										echo '<li class="reset-inner"><a data-rel="*" href="'. get_permalink( mfn_ID() ) .'">'. $translate['item-all'] .'</a></li>';
										if( $categories = get_categories() ){
											foreach( $categories as $category ){
												echo '<li><a data-rel=".category-'. $category->slug .'" href="'. get_term_link($category) .'">'. $category->name .'</a></li>';
											}
										}
									?>
									<li class="close"><a href="#"><i class="icon-cancel"></i></a></li>
								</ul>
								<ul class="tags">
									<?php
										echo '<li class="reset-inner"><a data-rel="*" href="'. get_permalink( mfn_ID() ) .'">'. $translate['item-all'] .'</a></li>';
										if( $tags = get_tags() ){
											foreach( $tags as $tag ){
												echo '<li><a data-rel=".tag-'. $tag->slug .'" href="'. get_tag_link($tag) .'">'. $tag->name .'</a></li>';
											}
										}
									?>
									<li class="close"><a href="#"><i class="icon-cancel"></i></a></li>
								</ul>
								<ul class="authors">
									<?php 
										echo '<li class="reset-inner"><a data-rel="*" href="'. get_permalink( mfn_ID() ) .'">'. $translate['item-all'] .'</a></li>';
									
										$authors = mfn_get_authors();
										if( is_array( $authors ) ){
											foreach( $authors as $auth ){
												echo '<li><a data-rel=".author-'. mfn_slug( $auth->data->user_login ) .'" href="'. get_author_posts_url($auth->ID) .'">'. $auth->data->display_name .'</a></li>';
											}
										
										}
									?>
									<li class="close"><a href="#"><i class="icon-cancel"></i></a></li>
								</ul>
							</div>
									
						</div>
						
					</div>
				</div>
			<?php endif; ?>

			
			<div class="section <?php echo $section_class; ?>">
				<div class="section_wrapper clearfix">
					
					<div class="column one column_blog">	
						<div class="blog_wrapper isotope_wrapper">
						
							<div class="posts_group lm_wrapper <?php echo implode(' ', $blog_classes); ?>">
								<?php
									
									$images_only = false;
									if( $load_more || mfn_opts_get( 'blog-images' ) ){
										$images_only = 'images_only';
									}
								
									echo mfn_content_post( false, false, $images_only );
								?>
							</div>
						
							<?php	
								// pagination
								if( function_exists( 'mfn_pagination' ) ):

									echo mfn_pagination( false, $load_more );
								
								else:
									?>
										<div class="nav-next"><?php next_posts_link(__('&larr; Older Entries', 'betheme')) ?></div>
										<div class="nav-previous"><?php previous_posts_link(__('Newer Entries &rarr;', 'betheme')) ?></div>
									<?php
								endif;
							?>
						
						</div>
					</div>

				</div>	
			</div>
			
			
		</div>	
		
		<!-- .four-columns - sidebar -->
		<?php get_sidebar( 'blog' ); ?>

	</div>
</div>

<?php get_footer();

// Omit Closing PHP Tags