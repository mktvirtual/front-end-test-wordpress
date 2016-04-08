<?php get_header(); ?>

	<div class="row" id="inner-content">
		<div id="proposta-adesao" class="col-md-4">
			<img src="<?= get_bloginfo('template_url') ?>/images/content/superbanana.jpg">
			<a href="#">
				<div class="col-md-12">
					<p> Preencha a proposta de adesão </p>
				</div>
			</a>
		</div> <!-- #proposta-adesao -->

		<?php 

		global $post;

		$args=array(
		    'orderby'=> 'id',
		    'order' => 'asc',
   		);
  		$my_query = new WP_Query($args);


		if ( $my_query->have_posts() ) {
				while ( $my_query->have_posts() ) { ?>
				<?php $my_query->the_post(); ?>
				<div class="post-box col-md-4" id="post-<?= $post->ID?>">

					<div class="post-content">
						<?php if($post->ID != 24){ ?>
						<div class="categoria">
							<?php
								$categories = get_the_category();
	 
								if ( ! empty( $categories ) ) {
								    echo esc_html( $categories[0]->name );   
								}
							?>
						</div>
						<?php } ?>
						<h1> <?php the_title(); ?> </h1>
						<?php the_excerpt(); ?>
						<a href="<?php echo post_permalink( $post->ID ); ?> " class="bt">
							<?php if($post->ID != 24){ ?> Saiba Mais <?php }else{ ?> Continue Lendo <?php } ?>
						</a>
					</div> <!-- .post-content -->

					<?php the_post_thumbnail(); ?>
				</div> <!-- .post-box -->
		<?php 
				} // end while
			} // end if
		?>
	</div> <!-- .row -->

<?php get_footer(); ?>