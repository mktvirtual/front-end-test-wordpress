<?php get_header(); ?>
	<div class="container margin-topo">
		<article class="mosaico-destaques">
			<?php 
				$destaque_recente = new WP_Query ("category_name=destaques&showposts=4");
				while ($destaque_recente->have_posts()) : $destaque_recente->the_post();
			?>
			<section class="mosaico">
				<a href="<?php the_permalink(); ?>">
					<figure>
						<?php the_post_thumbnail(); ?>
					</figure>
					<div class="infos-post">
						<h2 class="categoria-mosaico"><?php the_category( ', '); ?></h2>
						<span><?php conteudo_pequeno(); ?></span>
					</div>
				</a>
			</section>
			<?php endwhile; ?>
			<?php wp_reset_query(); ?>
		</article>
		<article class="ultimas">
			<h1>Últimas</h1>
			<?php 
				$ultimos_posts = new WP_Query ("showposts=4");
				while ($ultimos_posts->have_posts()) : $ultimos_posts->the_post();
			?>
			<section class="post-lista">
				<a href="<?php the_permalink(); ?>">
					<figure>
						<?php the_post_thumbnail(); ?>
					</figure>
					<div>
						<h2 class="categoria"><?php the_category(', '); ?></h2>
						<span><?php conteudo_pequeno(); ?></span>
						<span class="data-post"><?php the_time('d \d\e F \d\e Y'); ?></span>
					</div>
				</a>
			</section>
			<?php endwhile; ?>
			<?php wp_reset_query(); ?>
		</article>
		<article class="ultimas">
			<?php
				$args = array(
					'orderby' => 'name',
					'include' => '3',
					'parent' => 0
				);
				$categories = get_categories( $args );
				foreach ( $categories as $category ) {
					echo '<h1><a href="' . get_category_link( $category->term_id ) . '">' . $category->name . '</a></h1>';
				}

				$args = array( 'posts_per_page' => 4, 'category' => 3, 'order'=> 'ASC' );
				$post_lorem = get_posts( $args );
				foreach ( $post_lorem as $post ) : setup_postdata( $post );
			?> 
			<section class="post-lista">
				<a href="<?php the_permalink(); ?>">
					<figure>
						<?php the_post_thumbnail(); ?>
					</figure>
					<div>
						<h2 class="categoria"><?php the_category(', '); ?></h2>
						<span><?php conteudo_pequeno(); ?></span>
						<span class="data-post"><?php the_time('d \d\e F \d\e Y'); ?></span>
					</div>
				</a>
			</section>
			<?php
				endforeach; 
				wp_reset_postdata();
			?>
		</article>
		<article class="ultimas">
			<?php
				$args = array(
					'orderby' => 'name',
					'include' => '4',
					'parent' => 0
				);
				$categories = get_categories( $args );
				foreach ( $categories as $category ) {
					echo '<h1><a href="' . get_category_link( $category->term_id ) . '">' . $category->name . '</a></h1>';
				}

				$args = array( 'posts_per_page' => 4, 'category' => 4, 'order'=> 'ASC' );
				$post_lorem = get_posts( $args );
				foreach ( $post_lorem as $post ) : setup_postdata( $post );
			?> 
			<section class="post-lista">
				<a href="<?php the_permalink(); ?>">
					<figure>
						<?php the_post_thumbnail(); ?>
					</figure>
					<div>
						<h2 class="categoria"><?php the_category(', '); ?></h2>
						<span><?php conteudo_pequeno(); ?></span>
						<span class="data-post"><?php the_time('d \d\e F \d\e Y'); ?></span>
					</div>
				</a>
			</section>
			<?php
				endforeach; 
				wp_reset_postdata();
			?>
		</article>
	</div>
<?php get_footer(); ?>