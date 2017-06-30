<?php
/**
 * The template for displaying search results pages.
 *
 * @package AccessPress Store
 */
get_header();
?>


<div class="page_header_wrap clearfix">
    <div class="ak-container">
        <?php if ( have_posts() ) : ?>
            <header class="page-header">
                <h2 class="page-title"><?php printf( __('Search Results for: %s', 'accesspress-store'), '<span>' . get_search_query() . '</span>'); ?></h2>
            </header><!-- .page-header -->
        <?php endif; ?>
        <?php accesspress_breadcrumbs() ?>
    </div>
</div>

<div class="inner">
    <main id="main" class="site-main clearfix <?php echo @esc_attr( $single_page_layout ); ?>">
        <div id="primary" class="content-area">
            <?php if ( have_posts() ) : ?>
                <?php /* Start the Loop */ ?>
                <?php while ( have_posts() ) : the_post(); ?>

                    <?php
                    /**
                     * Run the loop for the search to output the results.
                     * If you want to overload this in a child theme then include a file
                     * called content-search.php and that will be used instead.
                     */
                    get_template_part('content', 'search');
                    ?>

                <?php endwhile; ?>

                <?php the_posts_navigation(); ?>

            <?php else : ?>

                <?php get_template_part('content', 'none'); ?>

            <?php endif; ?>


        </div><!-- #primary -->
        <?php get_sidebar('right'); ?>
    </main><!-- #main -->
</div>
<?php get_footer();