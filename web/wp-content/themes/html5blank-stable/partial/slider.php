<?php 
    $slider =  new WP_Query(
        array(
            'post_type' => 'slider',
            'orderby' => 'ASC',
            'post_status' => 'publish',
        )
    );
    $sliderTotal = $slider->found_posts;
    $bullets = '';
    $isActiveBullet = false;
    $bulletClass = $isActiveBullet ? 'active' : ' ';
    for($i=0; $i < $sliderTotal; $i++ ){
        if($i == 0) $bulletClass = true;

        $bullets .= '<li data-target="#carouselExampleIndicators" data-slide-to="'.$i.'" class="'.$bulletClass.' bullets"></li>';
    }
?>
<?php 
if($slider->have_posts()) : ?>
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php echo $bullets; ?>
            </ol>
            <div class="carousel-inner" role="listbox">
            <?php while( $slider->have_posts() ) : $slider->the_post(); 
                $sliderImg = get_field('imagem', $slider->ID);
                $sliderPos = get_field('pos_imagem',$slider->ID);
            ?>
                <div class="carousel-item <?php echo $sliderPos == 0 ?  'active' :  '' ?>" style="background-image: url('<?php echo $sliderImg; ?>')">
                    <div class="carousel-caption d-none d-md-block"></div>
                </div>
            <?php endwhile; ?>   
            <a class="carousel-control-prev slider-icon" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">«</span>
            </a>
            <a class="carousel-control-next slider-icon" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">»</span>
            </a>
</div>
<?php endif; wp_reset_query();  ?>