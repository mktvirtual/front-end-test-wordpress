<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package AccessPress Store
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="entry-content">
        <?php if (has_post_thumbnail()): ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail('accesspress-blog-big-thumbnail'); ?>
            </div>
        <?php endif; ?>
        <div class="content-inner clearfix">
            <h2 class="post-title"><?php the_title(); ?></h2>
            <div class="content-page">
                <?php the_content(); ?>
            </div>
            <?php
            wp_link_pages(array(
                'before' => '<div class="page-links">' . __('Pages:', 'accesspress-store'),
                'after' => '</div>',
            ));
            ?>
        </div>
    </div><!-- .entry-content -->

</article><!-- #post-## -->
