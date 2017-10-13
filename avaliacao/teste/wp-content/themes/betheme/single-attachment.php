<?php
/**
 * Search template file.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

get_header(); 
?>

<div id="Content">
	<div class="content_wrapper clearfix">

		<!-- .sections_group -->
		<div class="sections_group">
		
			<div class="section">
				<div class="section_wrapper clearfix">
				
					<div class="column one">
						<?php 
							while ( have_posts() )
							{
								the_post();
								?>
									<div id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>					
										<?php the_content( false ); ?>		
									</div>
								<?php 
							}
							
							mfn_pagination(); // pagination
						?>	
					</div>
					
				</div>
			</div>
			
		</div>

	</div>
</div>

<?php get_footer();

// Omit Closing PHP Tags