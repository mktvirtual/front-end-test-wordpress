<div id="posts">
    <div class="container">
        <div class="row">
            <div class="col-md-4 hidden-sm hidden-xs">
                
                <?php $superbanner = get_posts( array(
                    'posts_per_page'   => 1,
                    'offset'         => 2,
                    'category__not_in' => array(4, 5)
                ))[0];setup_postdata( $superbanner );?>
                <div class="superbanner">
                    <a href=""><img class="img-responsive" src="<?php the_post_thumbnail_url() ?>"></img></a>
                </div>
            </div>
            <div class="grid-vertical col-md-4 col-xs">
            <?php $myposts = get_posts( array(
                'posts_per_page'   => 2,
                 'category__not_in' => array(4, 5)
            ));
            foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
                <?php get_template_part('template-parts/home/home', 'post'); ?>
	        <?php endforeach; ?>
            </div>
            <div class="grid-vertical col-md-4 col-xs">
                <?php $myposts = get_posts( array(
                    'posts_per_page'   => 1,
                    'category' => 4
                ));
                foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
                    <?php get_template_part('template-parts/home/home', 'post'); ?>
    	        <?php endforeach; ?>
                <?php $myposts = get_posts( array(
                    'posts_per_page'   => 1,
                    'offset'         => 2,
                    'category__not_in' => array(4, 5)
                ));
                foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
                    <?php get_template_part('template-parts/home/home', 'post'); ?>
    	        <?php endforeach; ?>
            </div>
            
        </div>
    </div>
</div>