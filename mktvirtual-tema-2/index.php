<?php get_header(); ?>
	   	<section class="home-slider">
	      	<div class="slider">
	      		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
				  <!-- Indicators -->
				  <ol class="carousel-indicators">
				    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
				    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
				  </ol>

				  <!-- Wrapper for slides -->
				  <div class="carousel-inner" role="listbox">
				    <div class="item active">
				      <img src="<?php echo get_template_directory_uri() . '/images/home-banner/home-banner-1.jpg';?>" alt="home banner foto">
				    </div>

				    <div class="item">
				      <img src="<?php echo get_template_directory_uri() . '/images/home-banner/home-banner-2.jpg';?>" alt="home banner foto">
				    </div>
				  </div>

				  <!-- Controls -->
				  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
				    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				    <span class="sr-only">Previous</span>
				  </a>
				  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
				    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				    <span class="sr-only">Next</span>
				  </a>
				</div>
	      	</div>
	   	</section>

	   	<section class="posts">
	   		<div class="container">
	   			<div class="row">
		   	   		<div class="supper-banner col-md-4">
		   	   			<a href="#">
			   	   			<img src="<?php echo get_template_directory_uri() . '/images/super-banner.jpg';?>" alt="super banner">
		   	   				<div class="bt-banner">
		   	   					<p>preencha a proposta de adesão</p>
		   	   				</div>
	   	   				</a>
		   	   		</div>
		   	   		<div class="col-md-8">
		   	   			<div class="row">
		   	   				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			   	   			<div class="post-content">
			   	   				<div class="post-image"><?php the_post_thumbnail(); ?></div>
			   	   				<div class="post-info">
			   	   					<h6><?php the_category();?></h6>
			   	   					<h3><?php the_title(); ?></h3>
			   	   					<p><?php the_excerpt(); ?></p>
			   	   					<a class="link" href="<?php get_post_permalink(); ?>">Saiba mais</a>
			   	   				</div>
			   	   			</div>

			   	   			<?php endwhile; else: ?>
							<?php _e('Desculpe, não encontramos nenhuma postagem.'); ?>
							<?php endif; ?>

		   	   			</div>
		   	   		</div>
	   	   		</div>
	   	   	</div>
	   	</section>   
		
		<section class="map">
			<div class="mapa">
				<div id="map-canvas"></div>
			</div>
			<div class="content-overlay">
				<div class="container">
					<div class="box-padding">
						<div class="box col-md-8 col-md-offset-1">
							<div class="col-md-5">
								<a href="#">
									<div class="bt-local">
										<i class="fa fa-map-marker"></i>
										<h6>Achar minha localização automaticamente</h6>
									</div>
								</a>
							</div>
							<div class="col-md-2">
								<span>ou</span>
							</div>
							<div class="col-md-5">
								<div class="cep">
									<div class="title"><h6>digite o cep de onde você está</h6></div>
									<div class="form">
										<form><input type="text" placeholder="CEP"><button type="submit" class="bt-cep">Procurar</button></form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="newsletter">
			<div class="container">
				<div class="signature col-md-6">
					<div class="title">
						<h6>assine a newsletter do logo</h6>
					</div>
					<div class="mail">
						<form><input type="email" placeholder="Seu e-mail"><button type="submit" class="bt-newsletter">enviar</button></form>
					</div>
				</div>
				<div class="socials col-md-6">
					<div class="title">
						<h6>Siga lojas logo nas redes sociais</h6>
					</div>
					<div class="socials-btn">
						<a href="#"><img src="<?php echo get_template_directory_uri() . '/images/facebook-icon.png';?>" alt="facebook icon"></a>
						<a href="#"><img src="<?php echo get_template_directory_uri() . '/images/youtube-icon.png';?>" alt="youtube icon"></a>
						<a href="#"><img src="<?php echo get_template_directory_uri() . '/images/instagram-icon.png';?>" alt="instagram icon"></a>
					</div>
				</div>
			</div>
		</section>

<?php get_footer(); ?>