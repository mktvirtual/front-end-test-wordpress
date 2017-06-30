<?php
/**
 * This is the front page code
 * Template Name: Blog Page Template
 * @package AccessPress Store
 */
get_header();

global $post;

$archive_page_layout = esc_attr( get_post_meta($post->ID, 'accesspress_store_sidebar_layout', true));

if (empty($archive_page_layout)) {
    $archive_page_layout = esc_attr( get_theme_mod('archive_page_layout','right-sidebar') );
}

if (is_page('cart') || is_page('checkout')) {
    $archive_page_layout = "no-sidebar";
}

$breadcrumb = intval( get_theme_mod('breadcrumb_options_page','1') );
$archive_bread = esc_url( get_theme_mod('breadcrumb_page_image') );
if($archive_bread){
    $bread_archive = $archive_bread;
}else{
  $bread_archive = esc_url( get_template_directory_uri().'/images/about-us-bg.jpg' );
}

if($breadcrumb == '1') { ?>
<div class="page_header_wrap clearfix" style="background:url('<?php echo $bread_archive; ?>') no-repeat center; background-size: cover;">
    <div class="ak-container">
        <header class="entry-header">
            <?php the_title('<h2 class="entry-title">', '</h2>'); ?>
        </header><!-- .entry-header -->
        <?php accesspress_breadcrumbs() ?>
    </div>
</div>
<?php } ?>

<div class="inner">
    <main id="main" class="site-main clearfix <?php echo $archive_page_layout; ?>">
        <?php if ($archive_page_layout == 'both-sidebar'): ?>
            <div id="primary-wrap" class="clearfix">
        <?php endif; ?>
            
            <div id="primary" class="content-area <?php echo esc_attr( get_theme_mod('blog_post_layout') ); ?> ">
                <?php
                $exclude_cat = get_theme_mod('blog_exclude_categories');
                $exclude_cat = explode(',', $exclude_cat);
                $args = array('post_type' => 'post',
                  'posts_per_page' => 10,
                  'category__not_in' => $exclude_cat,
                );
                $query = new WP_Query($args);
                if ($query->have_posts()): while ($query->have_posts()) : $query->the_post();
                ?>
                <?php
                $blog_post_layout = esc_attr( get_theme_mod('blog_post_layout') );
                if (has_post_thumbnail()){
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

                } ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
                        <div class="content-inner clearfix">
                            <?php if (has_post_thumbnail()){ ?>
                                <div class="entry-thumbanil">
                                    <img src="<?php echo esc_url( $image[0] ); ?>" alt="<?php the_title(); ?>">

                                    <a class="img-over-link" href="<?php the_permalink(); ?>"><span class="thumb_outer"><span class="thumb_inner"><i class="fa fa-link"></i></span></span></a>

                                </div>
                            <?php } ?>
                                <div class="blog_desc">
                                    <header class="entry-header">
                                        <span class="cat-name">
                                            <?php 
                                                $category = get_the_category();
                                                echo $category[0]->cat_name;
                                             ?>
                                        </span>
                                        <?php the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() )), '</a></h2>'); ?>

                                        <?php if ('post' == get_post_type()) : ?>
                                            <div class="entry-meta">
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
                                                echo accesspress_letter_count(get_the_content(), '200');
                                            endif;
                                            ?>
                                        </div>
                                        <a href="<?php the_permalink(); ?>" class="bttn read-more">
                                            <?php _e('Read More', 'accesspress-store'); ?>
                                        </a>
                                    </div><!-- .entry-content -->
                                </div>
                        </div>
                    </article><!-- #post-## -->
                <?php  endwhile; endif; wp_reset_query(); ?>
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