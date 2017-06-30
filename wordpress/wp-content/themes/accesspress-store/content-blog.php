<?php
/**
 * @package AccessPress Store
 */
?>
<?php

$blog_post_layout = esc_attr( get_theme_mod('blog_post_layout') );

if (has_post_thumbnail()):
    switch ($blog_post_layout) {
        case 'blog_layout1':
            $image_size = 'accesspress-blog-big-thumbnail';
            break;

        case 'blog_layout2':
            $image_size = 'accesspress-service-thumbnail';
            break;

        case 'blog_layout3':
            $image_size = 'accesspress-service-thumbnail';
            break;

        case 'blog_layout4':
            $image_size = 'accesspress-blog-big-thumbnail';
            break;

        default:
            $image_size = 'accesspress-blog-big-thumbnail';
            break;
    }

    $image = wp_get_attachment_image_src(get_post_thumbnail_id(), $image_size);
endif;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

    <div class="content-inner clearfix">
        <div class="inner_article clearfix">
            <?php if ( has_post_thumbnail() ): ?>
                <div class="entry-thumbanil">
                    <img src="<?php echo esc_url( $image[0] ); ?>" alt="<?php the_title(); ?>">
                    <a class="img-over-link" href="<?php the_permalink(); ?>"><span class="thumb_outer"><span class="thumb_inner"><i class="fa fa-link"></i></span></span></a>
                </div>
            <?php endif; ?>
            <div class="blog_desc">
                <header class="entry-header">
                    <span class="cat-name">
                        <?php
                            $category = get_the_category();
                            echo $category[0]->cat_name;
                        ?>
                    </span>
                    <?php the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>
                        <?php if ('post' == get_post_type()) : ?>
                        <div class="entry-meta">
                            <?php //accesspress_store_posted_on(); ?>
                                <?php //accesspress_store_entry_footer();    ?>
                            <p class="meta-info">
                                <?php echo __('Posted On', 'accesspress-store'); ?> 
                                <?php the_time('F j, Y'); ?> 
                                <?php echo __('at', 'accesspress-store'); ?>
                                <?php the_time('g:i a'); ?> 
                                <?php echo __('by', 'accesspress-store'); ?>
                                <?php the_author_posts_link(); ?> /  <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?>
                            </p>
                        </div><!-- .entry-meta -->
                    <?php endif; ?>
                </header><!-- .entry-header -->
                <div class="entry-content">
                    <div class="desc">
                        <?php
                        if ($blog_post_layout == 'blog_layout4'):
                            echo get_the_content();
                        else:
                            echo accesspress_letter_count( get_the_content(), '200');
                        endif;
                        ?>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="bttn read-more">
                        <?php echo __('Read More', 'accesspress-store'); ?>
                    </a>
                    <?php
                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . __('Pages:', 'accesspress-store'),
                            'after' => '</div>',
                        ));
                    ?>
                </div><!-- .entry-content -->
            </div><!-- .blog_desc -->
        </div><!-- .blog_desc -->
    </div>
    <div class="clearfix"></div>
</article><!-- #post-## -->