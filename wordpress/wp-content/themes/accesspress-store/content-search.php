<?php
/**
 * The template part for displaying results in search pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package AccessPress Store
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>
    </header><!-- .entry-header -->
    <div class="clearfix"></div>
    <div class="entry-summary">
        <?php if ('post' == get_post_type()) : ?>
            <div class="entry-meta">
                <?php accesspress_store_posted_on(); ?>
            </div><!-- .entry-meta -->
        <?php endif; ?>
        <?php the_excerpt(); ?>
    </div><!-- .entry-summary -->
    <div class="clearfix"></div>
    <footer class="entry-footer clearfix">
        <?php accesspress_store_entry_footer(); ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-## -->
