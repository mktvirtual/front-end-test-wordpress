<?php
/**
 * @package AccessPress Store
 */
?>        
<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
    <div class="content-inner clearfix">
        <?php if (has_post_thumbnail()): ?>
            <div class="entry-thumbanil">
            <?php the_post_thumbnail( 'accesspress-blog-big-thumbnail'); ?>
                <a class="img-over-link" href="<?php the_permalink(); ?>"><span class="thumb_outer"><span class="thumb_inner"><i class="fa fa-link"></i></span></span></a>
            </div>
        <?php endif; ?>

        <div class="blog_desc">
            <header class="entry-header">                                        
                <?php the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>
                <div class="entry-meta">                                        
                    <p class="meta-info">
                        <?php echo __('Posted On', 'accesspress-store'); ?> 
                        <?php the_time('F j, Y'); ?> 
                        <?php echo __('at', 'accesspress-store'); ?>
                        <?php the_time('g:i a'); ?> 
                        <?php echo __('by', 'accesspress-store'); ?>
                        <?php the_author_posts_link(); ?> /  <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?>
                        / <?php the_category(','); ?>
                    </p>
                </div><!-- .entry-meta -->
            </header><!-- .entry-header -->
            <div class="entry-content">
            	<div class="desc">
                	<?php the_excerpt(); ?>
               	</div>
               	<a href="<?php the_permalink(); ?>" class="bttn read-more">
                    <?php echo __('Read More', 'accesspress-store'); ?>
                </a>                        	                       	
            </div><!-- .entry-content -->                       
        </div>
    </div>
</article><!-- #post-## -->                   
        