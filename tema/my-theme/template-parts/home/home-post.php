<?php
    $meta = get_post_custom(get_the_ID());
    $v = $meta['vertical'][0];
    $h = $meta['horizontal'][0];
    
    $classes = [];
    if($v == 'center'){
        $classes[] = 'middle-xs';
    }elseif($v == 'bottom'){
        $classes[] = 'bottom-xs';
    }else{
        $classes[] = 'top-xs';
    }
    
    
    if($h == 'center'){
        $classes[] = 'center-xs';
    }elseif($h == 'left'){
        $classes[] = 'start-xs';
    }else{
        $classes[] = 'end-xs';
    }
    
    $classes = implode(' ', $classes);
    $cat = get_the_category()[0]->name;
?>
<div class="row">
    <div class="col-xs">
        <div class="post" style="background-image:url('<?php the_post_thumbnail_url() ?>')">
            <div class="post-dimmer row <?php echo $classes ?>">
                <div class="info">
                    <h4><?php echo $cat == 'Principal'? '':$cat ?></h4>
                    <h3><?php the_title()?></h3>
                    <?php the_excerpt('<p class="font2">', '</p>') ?>
                    <a href="" class="btn"><?php echo $cat == 'Principal'?'Continue lendo':'Saiba mais' ?></a>
                </div>
            </div>
        </div>
    </div>
</div>