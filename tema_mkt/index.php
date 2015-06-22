<?php
/**
 * @package WordPress
 * @subpackage Tema MKT
 * @since Tema MKT 1.0
 */

get_header(); ?>
<!-- Criando a area de conteudo do site -->
	<div class="conteudo">
		<div class="conteudo_esquerda">
			<img src="wp-content/uploads/2015/06/home_03.gif">
		</div>
		<div class="conteudo_direita">
			<!-- pegando os posts do wordpress -->
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
			<div class="post">
				<div class="foto">
					<!-- pegando a imagem para colocar no fundo -->
					<?php the_post_thumbnail(array(200,200)); ?>
				</div>
				<div class="texto">
					<!-- colocando o texto do post -->
					<?php the_content(); ?>
				</div>
			</div>	
				<?php endwhile; ?>
			<?php else : ?>
				<h1>Não foi encontrado nenhum post</h1>
			<?php endif; ?>
		</div>
	</div>
	<div class="clearfix"></div>
	<!-- Cria a area de localização -->
	<div class="localizacao">
		<div class="busca_localizacao">
			<div class="localizacao_esquerda">
				<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/home_04.gif"></a>
			</div>
			<div class="localizacao_direita">
				<label>Digite o CEP de onde você está</label><br>
				<input type="text" placeholder="CEP">
				<input type="submit" value="Buscar">
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<!-- Cria a area social -->
	<div class="social">
		<div class="social_esquerda">
			<label>ASSINE A NEWSLETTER DO LOGO</label><br>
			<input type="email" placeholder="SEU EMAIL">
			<input type="submit" value="Buscar">
		</div>
		<div class="social_direita">
			<label>SIGA LOJAS LOGO NAS REDES SOCIAIS</label>
			<ul>
				<li><a href=""><img src="<?php echo get_template_directory_uri(); ?>/images/social/face.png"></a></li>
				<li><a href=""><img src="<?php echo get_template_directory_uri(); ?>/images/social/you.png"></a></li>
				<li><a href=""><img src="<?php echo get_template_directory_uri(); ?>/images/social/instagram.png"></a></li>
			</ul>	
		</div>
	</div>
	<div class="clearfix"></div>
<?php get_footer(); ?>
