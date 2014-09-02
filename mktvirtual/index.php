<!-- Template MktVirtual Entrevista -->
<?php global $post; ?>
<?php get_header(); ?>

<!-- MOSAICO -->
<div class="mosaico">
<div class="container">
<?php foreach (get_posts(array('category' => 'Destaque','posts_per_page'   => 4)) as $post): setup_postdata( $post ); ?>
	<?php if($i == 2 or $i==0): ?>
            <div class="row">
        <?php endif; ?>        
         
        <?php if($i == 3 or $i==0): ?>
        <div class="col-md-7">                                    
        <?php else: ?>
        <div class="col-md-5">
        <?php endif; ?>
             <?php
                    //Função para buscar a url da imagem
                    $thumb_id = get_post_thumbnail_id();
                    $thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail-size', true);
                    $url_image = $thumb_url[0];
                ?>
            <article style="background-image:url(<?php echo $url_image; ?>)" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( has_post_thumbnail()) : //Verificamos se tem imagem ?>               			                                
		<?php endif; ?>
            <div class="title-wrapper">
                <span class="category">
                    <?php the_category(); ?>
                </span>
		<h3>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
		</h3>                
            </div>                

	</article>
        </div>
        <?php $e = $i+1; ?>
        <?php if($e == 2 or $e == 4): ?>
            </div>
        <?php endif;?>
<?php $i++; ?>
<?php endforeach;  wp_reset_postdata();  ?>
</div>
</div>
    
<!-- ULTIMAS -->
<div class="ultimas">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <h2>Últimas</h2>                     
            </div>
        <?php if (have_posts()): $c = 0; while (have_posts() && $c <4) : the_post(); ?>
            <div class="col-md-3 col-xs-6">
            <?php
                //Função para buscar a url da imagem
                $thumb_id = get_post_thumbnail_id();
                $thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail-size', true);
                $url_image = $thumb_url[0];
            ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div style="background-image:url(<?php echo $url_image; ?>)" class="image-list">

            </div>
            <?php if ( has_post_thumbnail()) : //Verificamos se tem imagem ?>               			                                
            <?php endif; ?>
            <span class="category">
                <?php the_category(); ?>
            </span>
            <h3>
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
            </h3>                                
            <span class="date">
                <?php the_time('d \d\e F \d\e Y');?>
            </span>

        </article>
        </div>                    
        <?php $c++;endwhile;?>
        <?php endif; wp_reset_postdata();?>
        </div>        
    </div>        
</div>        

<!-- LOREM -->
<div class="um-categoria">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <h2>Lorem</h2>                     
            </div>
<?php foreach (get_posts(array('category' => 3,'posts_per_page'   => 4)) as $post): setup_postdata( $post ); ?>
            <div class="col-md-3 col-xs-6">
            <?php
                //Função para buscar a url da imagem
                $thumb_id = get_post_thumbnail_id();
                $thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail-size', true);
                $url_image = $thumb_url[0];
            ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div style="background-image:url(<?php echo $url_image; ?>)" class="image-list">

            </div>
            <?php if ( has_post_thumbnail()) : //Verificamos se tem imagem ?>               			                                
            <?php endif; ?>        
            <h3>
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
            </h3>                                
            <span class="date">
                <?php the_time('d \d\e F \d\e Y');?>
            </span>

        </article>
        </div>                    
        <?php $c++;endforeach;  wp_reset_postdata(); ?>
        </div>        
    </div>        
</div>

<!-- IPSUM -->
<div class="um-categoria">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <h2>Ipsum</h2>                     
            </div>
<?php foreach (get_posts(array('category' => 4,'posts_per_page'   => 4)) as $post): setup_postdata( $post ); ?>
            <div class="col-md-3 col-xs-6">
            <?php
                //Função para buscar a url da imagem
                $thumb_id = get_post_thumbnail_id();
                $thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail-size', true);
                $url_image = $thumb_url[0];
            ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div style="background-image:url(<?php echo $url_image; ?>)" class="image-list">

            </div>
            <?php if ( has_post_thumbnail()) : //Verificamos se tem imagem ?>               			                                
            <?php endif; ?>        
            <h3>
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
            </h3>                                
            <span class="date">
                <?php the_time('d \d\e F \d\e Y');?>
            </span>

        </article>
        </div>                    
        <?php $c++;endforeach;  wp_reset_postdata(); ?>
        </div>        
    </div>        
</div>
    
    
<?php get_footer(); ?>