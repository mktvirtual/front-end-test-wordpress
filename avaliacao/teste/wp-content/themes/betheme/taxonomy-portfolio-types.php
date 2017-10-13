<?php
/**
 * Taxanomy Portfolio Types
 *
 * @package Betheme
 * @author Muffin Group
 */

get_header(); 

// Class
$portfolio_classes 	= '';
$section_class 		= array();

// Class | Layout
if( $_GET && key_exists('mfn-p', $_GET) ){
	$portfolio_classes .= esc_html( $_GET['mfn-p'] ); // demo
} else {
	$portfolio_classes .= mfn_opts_get( 'portfolio-layout', 'grid' );
}

if( $portfolio_classes == 'list' ) $section_class[] = 'full-width';


// Class | Columns
if( $_GET && key_exists('mfn-pc', $_GET) ){
	$portfolio_classes .= ' col-'. esc_html( $_GET['mfn-pc'] ); // demo
} else {
	$portfolio_classes .= ' col-'. mfn_opts_get( 'portfolio-columns', 3 );
}


if( $_GET && key_exists('mfn-pfw', $_GET) )	$section_class[] = 'full-width'; // demo
if( mfn_opts_get('portfolio-full-width') )	$section_class[] = 'full-width';
$section_class = implode( ' ', $section_class );


// Ajax |  load more
$load_more = mfn_opts_get('portfolio-load-more');


// Translate
$translate['filter'] 		= mfn_opts_get('translate') ? mfn_opts_get('translate-filter','Filter by') : __('Filter by','betheme');
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
				?>
			</div>
		
			<?php if( $filters = mfn_opts_get('portfolio-filters') ): ?>
				<div class="section section-filters">
					<div class="section_wrapper clearfix">
					
						<?php 
							$filters_class = '';
							 if( $filters == 'only-categories' ) $filters_class .= ' only only-categories';
							 
							 $portfolio_page_id = mfn_wpml_ID( mfn_opts_get( 'portfolio-page' ) );
						?>
						
						<!-- #Filters -->
						<div id="Filters" class="column one <?php echo $filters_class; ?>">
	
							<ul class="filters_buttons">
								<li class="label"><?php echo $translate['filter']; ?></li>
								<li class="categories"><a class="open" href="#"><i class="icon-docs"></i><?php echo $translate['categories']; ?><i class="icon-down-dir"></i></a></li>
								<?php 
									echo '<li class="reset"><a class="close" data-rel="*" href="'.get_page_link( $portfolio_page_id ).'"><i class="icon-cancel"></i> '. $translate['all'] .'</a></li>';
								?>
							</ul>
	
							<div class="filters_wrapper">
								<ul class="categories">
									<?php 
										echo '<li class="reset-inner"><a class="close" data-rel="*" href="'.get_page_link( $portfolio_page_id ).'">'. $translate['item-all'] .'</a></li>';
									
										$menu_args = array(
											'taxonomy' 			=> 'portfolio-types',
											'orderby' 			=> 'name',
											'order' 			=> 'ASC',
											'show_count' 		=> 0,
											'hierarchical' 		=> 1,
											'hide_empty' 		=> 1,
											'title_li' 			=> '',
											'depth' 			=> 1,
											'walker' 			=> new New_Walker_Category(),
											'current_category' 	=> get_queried_object()->term_id,
										);			
										wp_list_categories( $menu_args ); 
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
					
					<div class="column one column_portfolio">	
						<div class="portfolio_wrapper isotope_wrapper">
	
							<?php 
								$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );				
								$args = array(
									'post_type' 			=> 'portfolio',
									'posts_per_page' 		=> mfn_opts_get( 'portfolio-posts', 6 ),
									'paged' 				=> $paged,
									'order' 				=> mfn_opts_get( 'portfolio-order', 'DESC' ),
									'orderby' 				=> mfn_opts_get( 'portfolio-orderby', 'date' ),
									'taxonomy' 				=> 'portfolio-types',
									'term' 					=> get_query_var( 'term' ),	// WordPress 4.0 Portfolio Categories FIX
									'ignore_sticky_posts' 	=> 1,
								);
									
								global $query_string;
								parse_str( $query_string, $qstring_array );
								$query_args = array_merge( $args, $qstring_array );

								$portfolio_types_query = new WP_Query( $query_args );
				
							 	echo '<ul class="portfolio_group lm_wrapper isotope '. $portfolio_classes .'">';
							 		echo mfn_content_portfolio( $portfolio_types_query );
								echo '</ul>';
								
								echo mfn_pagination( $portfolio_types_query, $load_more );
	
							 	wp_reset_query(); 
							?>
							
						</div>
					</div>
					
				</div>
			</div>

		</div>
		
		<!-- .four-columns - sidebar -->
		<?php get_sidebar( 'taxonomy' ); ?>
			
	</div>
</div>

<?php get_footer();

// Omit Closing PHP Tags