<?php include('header.php') ?>

<section class="highlights wrap header-margin-top">

    <?php query_posts('showposts=4&cat=2'); ?>
    <?php if(have_posts()): while(have_posts()): the_post(); ?>

        <article class="article">

            <div class="article-thumb">
                <?php the_post_thumbnail('thumb-large'); ?>
            </div>

            <div class="box">
                <span class="article-category"><?php SingleCategory(array("Destaques", "Sem categoria"), " | ") ?></span>
                <div class="article-tags">
                    <span class="tag white"></span>
                </div>
                <div class="clearfix"></div>
                <a href="<?php the_permalink(); ?>"><h2 class="article-title"><?php the_title(); ?></h2></a>
            </div>

        </article>

        <?php endwhile; else: ?>

        <p>Ops... nenhum post! :(</p>

    <?php endif ?>

</section>

<div class="wrap">

    <section class="list-categories">

        <h3 class="title">ÚLTIMAS</h3>

        <?php query_posts('showposts=4&cat=-2'); ?>
        <?php if(have_posts()): while(have_posts()): the_post(); ?>

            <article class="article" itemscope itemtype="http://schema.org/BlogPosting">

                <div class="article-thumb">
                    <?php the_post_thumbnail('thumb-small'); ?>
                </div>

                <a href="<?php the_permalink(); ?>" class="category-link">
                    <p class="article-category"><?php the_category(' , '); ?></p>
                </a>

                <a href="<?php the_permalink(); ?>" itemprop="url">
                    <h4 class="article-title" itemprop="name">
                        <?php $shorttitle = substr(the_title('','',FALSE),0,70); ?>
                        <?php echo $shorttitle; if (strlen($shorttitle) > 69){ echo '&hellip;'; } ?>
                        <?php //the_title(); ?>
                    </h4 class="article-title">
                </a>

                <p class="article-date"><?php the_date(); ?></p>

            </article>

            <?php endwhile; else: ?>

            <p>Ops... nenhum post! :(</p>

        <?php endif ?>

    </section>

    <section class="list-categories">

        <h5 class="title">LOREM </h5>

        <?php query_posts('showposts=4&category_name=Lorem'); ?>
        <?php if(have_posts()): while(have_posts()): the_post(); ?>

            <article class="article">

                <div class="article-thumb">
                    <?php the_post_thumbnail('thumb-small'); ?>
                </div>

                <a href="<?php the_permalink(); ?>">
                    <h4 class="article-title">
                        <?php $shorttitle = substr(the_title('','',FALSE),0,70); ?>
                        <?php echo $shorttitle; if (strlen($shorttitle) > 69){ echo '&hellip;'; } ?>
                        <?php //the_title(); ?>
                    </h4>
                </a>

                <p class="article-date"><?php the_date(''); ?></p>

            </article>

            <?php endwhile; else: ?>

            <p>Ops... nenhum post! :(</p>

        <?php endif ?>

    </section>

    <section class="list-categories">

        <h5 class="title">IPSUM </h5>

        <?php query_posts('showposts=4&category_name=Ipsum'); ?>
        <?php if(have_posts()): while(have_posts()): the_post(); ?>

        <article class="article">

            <div class="article-thumb">
                <?php the_post_thumbnail('thumb-small'); ?>
            </div>

            <a href="<?php the_permalink(); ?>">
                <h4 class="article-title">
                    <?php $shorttitle = substr(the_title('','',FALSE),0,70); ?>
                    <?php echo $shorttitle; if (strlen($shorttitle) > 69){ echo '&hellip;'; } ?>
                    <?php //the_title(); ?>
                </h4>
            </a>

            <p class="article-date"><?php the_date(''); ?></p>

        </article>

        <?php endwhile; else: ?>

        <p>Ops... nenhum post! :(</p>

    <?php endif ?>

    </section>

</div>

<?php get_footer(); ?>