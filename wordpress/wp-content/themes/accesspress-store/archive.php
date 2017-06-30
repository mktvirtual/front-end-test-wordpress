<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package AccessPress Store
 */
get_header();
$archive_page_layout = esc_attr( get_theme_mod('archive_page_layout','right-sidebar') );
?>
<?php 
$breadcrumb = intval ( get_theme_mod('breadcrumb_options_post','1') );
$archive_bread = esc_url( get_theme_mod('breadcrumb_post_image') );
if($archive_bread){
    $bread_archive = $archive_bread;
}else{
  $bread_archive = esc_url( get_template_directory_uri().'/images/about-us-bg.jpg' );
}
if($breadcrumb == '1') :
?>
    <div class="page_header_wrap clearfix" style="background:url('<?php echo $bread_archive; ?>') no-repeat center; background-size: cover;">
        <div class="ak-container">
            <header class="page-header">
                <?php
                the_archive_title('<h2 class="entry-title">', '</h2>');
                the_archive_description('<div class="taxonomy-description">', '</div>');
                ?>
            </header><!-- .page-header -->
            <?php accesspress_breadcrumbs() ?>
        </div>
    </div>
<?php endif; ?>
<div class="inner">
    <main id="main" class="site-main clearfix <?php echo $archive_page_layout; ?>">

        <?php if ($archive_page_layout == 'both-sidebar'): ?>
            <div id="primary-wrap" class="clearfix">
        <?php endif; ?>

            <?php
                $blog_post_layouts = get_theme_mod('blog_post_layout');
            ?>
            <div id="primary" class="content-area <?php echo get_theme_mod('archive_page_view_type') . " " . $blog_post_layouts; ?>">
                <?php if ( have_posts() ) : ?>
                    <?php /* Start the Loop */ ?>
                    <?php while ( have_posts() ) : the_post(); ?>

                            <?php
                                /* Include the Post-Format-specific template for the content.
                                 * If you want to override this in a child theme, then include a file
                                 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                                 */
                                get_template_part('content', 'blog');
                            ?>

                    <?php endwhile; ?>

                    <?php the_posts_navigation(); ?>

                <?php else : ?>

                    <?php get_template_part('content', 'none'); ?>

                <?php endif; ?>

            </div><!-- #primary -->

            <?php
                if ($archive_page_layout == 'both-sidebar' || $archive_page_layout == 'left-sidebar'):
                    get_sidebar('left');
                endif;
            ?>

        <?php if ($archive_page_layout == 'both-sidebar'): ?>
            </div>
        <?php endif; ?>

        <?php
            if ($archive_page_layout == 'both-sidebar' || $archive_page_layout == 'right-sidebar'):
                get_sidebar('right');
            endif;
        ?>

    </main><!-- #main -->
</div>
<?php get_footer();