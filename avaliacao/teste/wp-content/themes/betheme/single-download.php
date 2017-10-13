<?php
/**
 * The template for displaying Easy Digital Download
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

get_header();

$classes = 'no-share';

$translate['published'] 	= mfn_opts_get('translate') ? mfn_opts_get('translate-published','Published by') : __('Published by','betheme');
$translate['at'] 			= mfn_opts_get('translate') ? mfn_opts_get('translate-at','at') : __('at','betheme');
?>
	
<!-- #Content -->
<div id="Content">
	<div class="content_wrapper clearfix">

		<!-- .sections_group -->
		<div class="sections_group">
			<div id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
			
			
				<div class="section section-post-header">
					<div class="section_wrapper clearfix">
					
						<div class="column one post-header">
							<div class="title_wrapper">
							
								<?php
									if( mfn_opts_get( 'blog-title' ) ){
										$h = mfn_opts_get( 'title-heading', 1 );
										echo '<h'. $h .' class="entry-title" itemprop="headline">'. get_the_title() .'</h'. $h .'>';
									}	
								?>
								
								<?php if( mfn_opts_get( 'blog-meta' ) ): ?>
									<div class="post-meta clearfix">
									
										<div class="author-date">
											<span class="vcard author post-author">
												<?php echo $translate['published']; ?> <i class="icon-user"></i>
												<span class="fn"><a href="<?php echo get_author_posts_url( get_the_author_meta('ID') ); ?>"><?php the_author_meta( 'display_name' ); ?></a></span>
											</span> 
											<span class="date">
												<?php echo $translate['at']; ?> <i class="icon-clock"></i>
												<time class="entry-date" datetime="<?php the_date('c'); ?>" itemprop="datePublished" pubdate><?php echo get_the_date(); ?></time>
											</span>	
										</div>
				
									</div>
								<?php endif; ?>
								
							</div>	
						</div>
			
						<div class="column one single-photo-wrapper">
							<div class="image_frame scale-with-grid <?php if( ! mfn_opts_get('blog-single-zoom') ) echo 'disabled'; ?>">
								<div class="image_wrapper">
									<?php echo mfn_post_thumbnail( get_the_ID() ); ?>
								</div>
							</div>
						</div>
			
					</div>
				</div>
				
				
				<div class="post-wrapper-content">
				
					<div class="section the_content">			
						<div class="section_wrapper">
						
							<div class="the_content_wrapper">
								<?php 
									while ( have_posts() ){
										the_post();		// Post Loop	
										the_content();	// WordPress Editor Content
									}
								?>
							</div>
							
						</div>
					</div>
				
					<div class="section section-post-footer">
						<div class="section_wrapper clearfix">
						
							<div class="column one post-pager">
								<?php
									// List of pages
									wp_link_pages(array(
										'before'			=> '<div class="pager-single">',
										'after'				=> '</div>',
										'link_before'		=> '<span>',
										'link_after'		=> '</span>',
										'next_or_number'	=> 'number'
									));
								?>
							</div>
							
						</div>
					</div>

					<div class="section section-post-about">
						<div class="section_wrapper clearfix">
						
							<?php if( mfn_opts_get( 'blog-author' ) ): ?>
								<div class="column one author-box">
									<div class="author-box-wrapper">
										<div class="avatar-wrapper">
											<?php 
												global $user;
												echo get_avatar( get_the_author_meta('email'), '64', false, get_the_author_meta('display_name', $user['ID']) );
											?>
										</div>
										<div class="desc-wrapper">
											<h5><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author_meta( 'display_name' ); ?></a></h5>
											<div class="desc"><?php the_author_meta('description'); ?></div>
										</div>
									</div>
								</div>
							<?php endif; ?>
							
						</div>	
					</div>
				
				</div>
				

			</div>
		</div>
		
		
		<!-- .four-columns - sidebar -->
		
		<?php if( is_active_sidebar( 'edd' ) ):  ?>
			<div class="sidebar four columns">
				<div class="widget-area clearfix <?php mfn_opts_show('sidebar-lines'); ?>">
					<?php dynamic_sidebar( 'edd' ); ?>
				</div>
			</div>
		<?php endif; ?>
		

	</div>
</div>

<?php get_footer();

// Omit Closing PHP Tags