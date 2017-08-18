<?php
$promocao =  new WP_Query(
    array(
        'post_type' => 'promocao',
        'orderby' => 'ASC',
        'post_status' => 'publish',
        'post_per_page' => 4 
    )
);
// $sliderTotal = $slider->found_posts;
if($promocao->have_posts()) :
?> 
    <div class="row box-promocao">
		<div class="col-md-4">
			<?php get_sidebar(); ?>
		</div>
		<div class="col-md-8">
            <ul>
                <?php 
                    while( $promocao->have_posts() ) : $promocao->the_post(); 
                    $imagem = get_field('bg_img', $promocao->ID);
                    
                    if(count(get_the_category($promocao->ID) ) != 0 ) {
                        $category = get_the_category($promocao->ID);
                        $categoryName = $category[0]->name;
                    }

                ?>
                    <li>
                        <div class="promocao-content" style="background-image: url('<?php echo $imagem;  ?>') ">
                            <div class="txt-dinamico <?php echo get_field('txt_align', $promocao->ID); ?>">
                            <span class="category">
                                <?php echo $categoryName; ?>
                            </span>
                                <h3>
                                    <?php the_title(); ?>
                                </h3>
                                <p><?php echo get_field('desc', $promocao->ID); ?></p>
                                <div class="btn-default">
                                    <button><?php echo get_field('txt_btn', $promocao->ID); ?></button>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
		</div>
	</div>
<?php endif; wp_reset_query(); ?>