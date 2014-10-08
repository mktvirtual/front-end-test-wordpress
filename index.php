<?php get_header(); ?>
<div class="conteudo">
                 <article>
              <?php $destaques = new WP_Query ("category_name=Destaques&showposts=4");
				while ($destaques->have_posts()) : $destaques->the_post();?>
					<section class="destaque">
					<a href="<?php the_permalink(); ?>">
					<figure><?php the_post_thumbnail(); ?></figure></a>
                    
                    <div class="destaque_titulo">
						<h2><?php the_category( ', '); ?><br/>
						<?php the_title(); ?></h2>
					</div>
					</section>
            <?php endwhile; ?>
			<?php wp_reset_query(); ?>
		</article> 
        <article class="ultimas">
        	<h1>Últimas</h1>
            	<?php $aRecentPosts = new WP_Query("showposts=4"); while($aRecentPosts->have_posts()) : $aRecentPosts->the_post();?>
        	<section class="artigo">
            		<?php the_post_thumbnail(); ?>
                    <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                    <p> <?php the_time('j \d\e F \d\e Y') ?></p>         
            
            </section><?php endwhile?>
        </article>
        <article class="categoria">
        	<h1>Lorem</h1>
            	<?php query_posts("category_name=Lorem"); while(have_posts()) : the_post();?>
        	<section class="artigo">
            		<?php the_post_thumbnail(); ?>
                    <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                    <p> <?php the_time('j \d\e F \d\e Y') ?></p>         
            
            </section><?php endwhile?>
        </article>
        
  <article class="categoria">
        	<h1>Ipsum</h1>
            	<?php query_posts("category_name=Ipsum"); while(have_posts()) : the_post();?>
    <section class="artigo">
            		<?php the_post_thumbnail(); ?>
                    <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
      <p> <?php the_time('j \d\e F \d\e Y') ?></p>         
            
    </section><?php endwhile?>
  </article>
</div>
<?php get_footer(); ?>