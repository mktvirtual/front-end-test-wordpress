<?php get_header(); ?>

	<content>

		<!-- Sessão do Slide -->
		<section id="slide">

			<div class="slide-container">

				<img src="<?php bloginfo('template_url') ?>/assets/images/slides/slide-home.jpg" alt="slide-home.jpg">
				<img src="<?php bloginfo('template_url') ?>/assets/images/slides/slide-pb.jpg" alt="slide-pb.jpg">

			</div>

		</section>

		<!-- Sessão do Blog e Superbanner -->
		<section id="blog">

			<div class="blog-container wrap">

				<div class="superbanner">

					<figure>
						<img src="<?php bloginfo('template_url') ?>/assets/images/superbanner.jpg" alt="superbanner.jpg">
						<figcaption>
							<a href="#" title="Preencha a proposta de adesão"><span>preencha a proposta de adesão</span></a>
						</figcaption>
					</figure>

				</div>

				<div class="blog-posts">

					<?php

						query_posts('post_type=post&post_status=publish&posts_per_page=4&paged='. get_query_var('paged'));
						if( have_posts() ): while( have_posts() ): the_post();

						$post_position = get_field('post-position');

					?>

					<div class="post">

						<figure>

							<?php the_post_thumbnail(); ?>

							<figcaption class="<?php echo $post_position; ?>">

								<?php if ( !in_category('promocao') ) : ?>
								<div class="category">
									<?php foreach((get_the_category()) as $category) { echo $category->cat_name; } ?>
								</div>
								<?php endif; ?>


								<div class="title">
									<h2><?php the_title(); ?></h2>
	        					</div>

								<div class="excerpt">
	        						<?php the_excerpt(); ?>
	        					</div>

								<a class="btn" href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php echo (!in_category('promocao')) ? 'Saiba mais' : 'Continue lendo'; ?></a>

							</figcaption>


						</figure>

					</div>

					<?php endwhile; endif; ?>

				</div>

			</div>

		</section>

		<!-- Sessão do Google Maps e Script de Localição e CEP -->
		<section id="maps">

			<div class="maps-control">

				<div class="map-control-location">

					<button class="map-location" type="button" onclick="askGeolocation()">
						<i class="fa fa-map-marker" aria-hidden="true"></i>
						<span>Achar minha localização automaticamente</span>
					</button>

				</div>

				<div class="map-control-separator"></div>

				<div class="map-control-cep">

					<h6>digite o cep de onde você está</h6>

					<div class="map-control-cep-form">

						<input id="cep" type="text" name="cep" placeholder="CEP" />
						<button class="map-cep" type="button" onclick="getCep(document.getElementById('cep').value)">Procurar</button>

					</div>

				</div>

			</div>

			<div id="map"></div>

		</section>

		<!-- Sessão Newsletter e Redes Sociais -->
		<section id="media">

			<div class="media-container wrap">

				<div class="newsletter">

					<h3>ASSINE A NEWSLETTER DO LOGO</h3>

					<div class="newsletter-form">

						<?php $widgetNL = new WYSIJA_NL_Widget(true); echo $widgetNL->widget(array('form' => 1, 'form_type' => 'php')); ?>

					</div>

				</div>

				<div class="socials">

					<h3>SIGA LOJAS LOGO NAS REDES SOCIAIS</h3>

					<div class="socials-btns">

						<a href="#" title="Facebook" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
						<a href="#" title="Youtube" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
						<a href="#" title="Instagram" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>

					</div>

				</div>

			</div>

		</section>

	</content>

<?php get_footer(); ?>
