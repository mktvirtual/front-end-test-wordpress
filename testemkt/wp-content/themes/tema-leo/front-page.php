<!DOCTYPE html>
<html>
<head>
	<?php include 'assets/includes/head.php';?>
	<!-- SLIDER -->
	<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/assets/build/css/slippry.css">
	<title>Teste MKT</title>
</head>

<body>
	
	<div id="top-anchor"></div>
	<a href="#top-anchor" id="upArrow" class="go"><i class="fa fa-chevron-up" aria-hidden="true"></i></a>

	<?php include 'assets/includes/header.php';?>



	<!-- SLIDER -->
	<div class="mg-40--top">
		<a href="javascript:void(0)" title="">
			<figure class="mobile-slider">
				<img src="<?php echo get_template_directory_uri() ?>/assets/build/image/mobile-slider.png" alt="">
			</figure> 
		</a>


<?php 

	$args = array(
		'post_type' => 'slider',
		'posts_per_page' => 2,
		'orderby' => 'ID',
		'order' => 'ASC'
		);

	$the_query_slider = new WP_Query($args);


	?>

		<article class="demo_block">
			<ul id="slider" class="slider">
				<?php
				if ( $the_query_slider->have_posts() ) {

					while($the_query_slider->have_posts()) {

						$the_query_slider->the_post();

						$titulo = get_the_title();
						$imagem = get_field('imagem');

						?>


						<li>
							<a href="javascript:void(0)">
								<img src="<?php echo $imagem; ?>">
							</a>
						</li>

						<?php
					}
				}
				?>
				<!-- <li>
					<a href="javascript:void(0)">
						<img src="<?php echo get_template_directory_uri() ?>/assets/build/image/image-1.jpg" alt="">
					</a>
				</li>
				<li>
					<a href="javascript:void(0)">
						<img src="<?php echo get_template_directory_uri() ?>/assets/build/image/image-2.jpg" alt="">
					</a>
				</li> -->
			</ul>
		</article>  
	</div>

	<?php 

	$args = array(
		'post_type' => 'blog',
		'posts_per_page' => 4,
		'orderby' => 'ID',
		'order' => 'ASC'
		);

	$the_query_blog = new WP_Query($args);


	?>

	<div class="wrapper">
		<section class="flex-grid--wrap valign-top">
			<section class="flex-grid--wrap col product-destaque">
				<ul class="flex-grid--wrap--col halign-top valign-middle col product--list">
					<li class="product--item flex-grid--col">
						<a href="javascript:void(0);" class="product--link">
							<div class="product--content">
								<h3>preencha a proposta de adesão</h3>
							</div>
							<figure class="product--img">
								<img  src="<?php echo get_template_directory_uri() ?>/assets/build/image/img-content-1.jpg" alt="">
							</figure>
						</a>
					</li>

					<?php

					if ( $the_query_blog->have_posts() ) {

						while($the_query_blog->have_posts()) {

							$the_query_blog->the_post();

							$titulo = get_the_title();

							$descricao = get_field('descricao');
							$categoria = get_field('categoria');
							$imagem = get_field('imagem');

							?>

							<li class="product--item">
								<a href="javascript:void(0);" class="product--link">
									<div class="product--content">
										<strong><?php echo $categoria; ?></strong>
										<h3><?php echo $titulo; ?></h3>
										<p><?php echo $descricao; ?></p>
										<span>Saiba Mais</span>
									</div>
									<figure class="product--img">
										<img src="<?php echo $imagem; ?>" alt="">
									</figure>
								</a>
							</li>

							<?php

						}

					}
					?>

					<!-- <li class="product--item">
						<a href="javascript:void(0);" class="product--link">
							<div class="product--content">
								<h3>Promõção Bob Esponja</h3>
								<p>Na compra de uma peça Bob Esponja, ganhe um brinde. </p>
								<span>Continue Lendo</span>
							</div>
							<figure class="product--img">
								<img src="<?php echo get_template_directory_uri() ?>/assets/build/image/product-example-2.jpg" alt="">
							</figure>
						</a>
					</li>
					<li class="product--item">
						<a href="javascript:void(0);" class="product--link">
							<div class="product--content">
								<strong>Moda Logo</strong>
								<h3>Paixão por Jeans</h3>
								<p>Versátil, combina com vários estilos diferentes.</p>
								<span>Saiba Mais</span>
							</div>
							<figure class="product--img">
								<img src="<?php echo get_template_directory_uri() ?>/assets/build/image/product-example-3.jpg" alt="">
							</figure>
						</a>
					</li>
					<li class="product--item">
						<a href="javascript:void(0);" class="product--link">
							<div class="product--content">
								<strong>Beleza</strong>
								<h3>Poder Instantâneo</h3>
								<p>Batom vermelho deixa toda mulher poderosa.</p>
								<span>Saiba Mais</span>
							</div>
							<figure class="product--img">
								<img src="<?php echo get_template_directory_uri() ?>/assets/build/image/product-example-4.jpg" alt="">
							</figure>
						</a>
					</li> -->
				</ul>
			</section>
		</section>
	</div>


	<section class="home-map flex-grid halign-center valign-middle is-md">
		<div class="map-info col-4 flex-grid--wrap halign-between valign-middle is-md">
			<div class="col-5 flex-grid is-md halign-center button-find-map">
				<a href="javascript:void(0)" class="col flex-grid halign-between valign-middle">
					<i class="fa fa-map-marker" aria-hidden="true"></i>
					<span class="col">achar minha localização automaticamente</span>
				</a>
			</div>
			<span class="or col-1 is-md ">ou</span>
			<div class="col-6 flex-grid--col valign-bottom is-md input-find-map">
				<strong class="responsive-text--md col is-md">digite o cep de onde você está</strong>
				<div class="flex-grid input-find-map--inside halign-between is-md">
					<input type="text" class="col-7" placeholder="CEP">
					<button>Procurar</button>				
				</div>
			</div>
		</div>	
	</section>


	<div class="wrapper pd-60--bottom">
		<section class="flex-grid--wrap">
			<div class="col flex-grid--wrap halign-between valign-middle is-md">
				<div class="col flex-grid--col valign-baseline  is-md input-find-map">
					<strong class="responsive-text--md col is-md">Assine a newsletter do logo</strong>
					<div class="col-10 flex-grid input-find-map--inside halign-between is-md">
						<input type="text" class="col" placeholder="Seu Email">
						<button>Enviar</button>				
					</div>
				</div>
			</div>	
			<div class="col-6 flex-grid--col valign-bottom halign-left  is-md input-find-map">
				<strong class="self-middle responsive-text--md mg-20--top col is-md">Siga lojas logo nas redes sociais</strong>
				<ul class="flex-grid--wrap self-middle">
					<li>
						<a href="javascript:void(0)" class="social-icon--fb" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a>
					</li>
					<li>
						<a href="javascript:void(0)" class="social-icon--yt" title="Youtube" target="_blank"><i class="fa fa-youtube-play"></i></a>
					</li>
					<li>
						<a href="javascript:void(0)" title="Linkedin" class="social-icon--ld" target="_blank"><i class="fa fa-linkedin"></i></a>
					</li>
				</ul>
			</div>
		</section>
	</div>



	


	<?php include 'assets/includes/footer.php';?> 
</body>
</html>