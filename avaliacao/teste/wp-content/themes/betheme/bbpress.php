<?php
/**
 * The template for displaying bbPress
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

get_header();
?>
	
<!-- #Content -->
<div id="Content">
	<div class="content_wrapper clearfix">

		<!-- .sections_group -->
		<div class="sections_group">
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
		</div>
		
		<!-- .four-columns - sidebar -->
		<?php if( is_active_sidebar( 'forum' ) ):  ?>
			<div class="sidebar four columns">
				<div class="widget-area clearfix <?php mfn_opts_show('sidebar-lines'); ?>">
					<?php dynamic_sidebar( 'forum' ); ?>
				</div>
			</div>
		<?php endif; ?>

	</div>
</div>

<?php get_footer();

// Omit Closing PHP Tags