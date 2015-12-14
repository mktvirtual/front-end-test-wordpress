<?php /* Template Name: Home */ ?>

<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
  	<?php the_content(); ?>

<?php endwhile; else: ?>
	<p><?php _e('Sorry, this page does not exist.'); ?></p>
<?php endif; ?>
<!-- <div class="container-fluid slider">
	<div class="row">
		<div id="myCarousel" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators">
		      <li data-slide-to="0" data-target="#myCarousel" class="active"></li>
		      <li data-slide-to="1" data-target="#myCarousel"></li>
		    </ol>
			<div class="carousel-inner" role="listbox">
				<div class="item active">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/vitrine1.jpg" alt="vitrine1" class="fullscreen">
				</div>
				<div class="item">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/vitrine2.jpg" alt="vitrine2" class="fullscreen">
				</div>
			</div>
			<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
			    <span class="slider-btn sprite-slider-left" aria-hidden="true"></span>
			    <span class="sr-only">Próximo</span>
			  </a>
			  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
			    <span class="slider-btn sprite-slider-right" aria-hidden="true"></span>
			    <span class="sr-only">Anterior</span>
			  </a>
		</div>
	</div>
</div> -->
<!-- <div class="container">
  	<div class="row">
		<div class="col-md-4 col-sm-4"><a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/proposta.jpg" alt="proposta"><div class="adesao">Preencha a Proposta de Adesão</div></a></div>
		<div class="col-md-4 col-sm-4 post_box"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ruiva.jpg" alt="ruiva"></div>
		<div class="col-md-4 col-sm-4 post_box"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/bob.jpg" alt="bob"></div>
		<div class="col-md-4 col-sm-4 post_box"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/jeans.jpg" alt="jeans"></div>
		<div class="col-md-4 col-sm-4 post_box"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/poder.jpg" alt="poder"></div>
  	</div>
</div> -->
<!-- <div class="container-fluid">
	<div class="row">
		<div class="localizacao">
			<div class="box col-md-6 col-sm-6 col-sm-offset-3 col-md-offset-3">
				<div class="box_left col-md-5">
					<div class="box_localizacao">
						<div class="col_icon_map col-md-2 col-sm-2 col-xs-2">
							<i class="fa fa-map-marker fa-2x"></i>
						</div>
						<div class="col-md-10 col-sm-10 col-xs-10">
							<p>Achar minha localização automaticamente</p>
						</div>
					</div>
					<span class="ou">ou</span>
				</div>
				
				<div class="box_right col-md-7">
					<p>Digite o CEP de onde você está</p>
					<form action="#" class="cep-form" method="get">
						<label>
							<input type="search" title="CEP" value="" placeholder="CEP" class="cep-field">
						</label>
						<input type="submit" value="Procurar" class="cep-submit">
					</form>
				</div>
			</div>
		</div>
	</div>
</div> -->
<!-- <div class="container social">
  	<div class="row">
		<div class="col-md-6 col-sm-6">
			<p>Assine a Newsletter do Logo</p>
			<form method="get" class="news-form" action="#">
				<label>
					<input type="search" class="news-field" placeholder="Seu e-mail" value="" title="news">
				</label>
				<input type="submit" class="news-submit" value="Enviar">
			</form>
		</div>
		<div class="col-md-6 col-sm-6">
			<p>Siga lojas Logo nas redes sociais</p>
			<ul class="list-inline">
				<li>
					<div class="rede"><a href="https://facebook.com" target="_blank"><i class="fa fa-facebook fa-2x"></i></a></div>
				</li>
				<li>
					<div class="rede"><a href="https://youtube.com" target="_blank"><i class="fa fa-youtube-play fa-2x"></i></a></div>
				</li>
				<li>
					<div class="rede"><a href="https://instagram.com" target="_blank"><i class="fa fa-instagram fa-2x"></i></a></div>
				</li>
			</ul>
		</div>
	</div>
</div> -->

<?php get_footer(); ?>