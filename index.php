<?php get_header();?>
<div class="slide cycle-slideshow" data-cycle-slides=".slide__each" data-cycle-pager=".slide__dots">
	<?php
		if( have_rows('slide') ): 
			while ( have_rows('slide') ) : the_row(); ?>
	       	<div class="slide__each" style="background-image: url('<?php the_sub_field('imagem'); ?>')">
	       		<a href="<?php the_sub_field('url'); ?>" class="slide__each__link"></a>       			
	       	</div>
		<?php endwhile;
		else :
		endif;
	?>
		<button class="slide__controls slide__controls--prev cycle-prev"></button>
		<button class="slide__controls slide__controls--next cycle-next"></button>
		<div class="slide__dots"></div>
	</div>

	
	<div class="blocks">
		<div class="row">
			<div class="blocks__one">
				<div class="blocks__content">
					<img src="<?php the_field('ad_img'); ?>" alt="">
					<div class="blocks__adesao">					
						<span class="blocks__adesao__ttl"><?php the_field('ad_ttl'); ?></span>
						<?php the_field('ad_texto'); ?>						
						<a href="><?php the_field('url_adesao'); ?>" class="blocks__adesao__btn">Preencher Adesão</a>							
					</div>
				</div>
			</div>
			<div class="blocks__group">
				<div class="row">
					<?php
					if( have_rows('blocos_conteudo') ): 
						while ( have_rows('blocos_conteudo') ) : the_row(); ?>
						<div class="blocks__group__each">
							<div class="blocks__content">
								<img src="<?php the_sub_field('imagem'); ?>" alt="">
								<div class="blocks__text <?php the_sub_field('pos_texto'); ?>">
									<h2><?php the_sub_field('subtitulo'); ?></h2>
									<h1><?php the_sub_field('titulo'); ?></h1>
									<p><?php the_sub_field('texto'); ?></p>
									<a href="<?php the_sub_field('url'); ?>" class="btn"><?php the_sub_field('link_texto'); ?></a>
								</div>			
							</div>
						</div>
					<?php endwhile;
						else :
						endif;
					?>
				</div>
			</div>
		</div>
	</div><!-- Blocks -->
	<div class="maps">
		<div class="maps__res" id="map">
		</div>
		<div class="maps__content">			
			<div class="row align-center">
				<div class="maps__inputs">
					<button class="maps__my-local">
						achar minha localização automaticamente
					</button>
					<div class="maps__sep">ou</div>
					<div class="maps__cep">
						<fieldset>
							<label for="" class="maps__cep__label">digite o cep de onde você está</label>
							<input type="text" placeholder="cep" class="maps__cep__input">
							<button class="maps__cep__btn">procurar</button>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div><!-- Maps -->
	<div class="social">
		<div class="row">
			<div class="social__newsletter">
				<label for="" class="social__newsletter__label">Assine a newsletter do logo</label>
				<input type="text" class="social__newsletter__input" placeholder="Seu email">
				<input type="submit" class="social__newsletter__btn" value="enviar">
			</div>
			<div class="social__net">
				<span class="social__net__ttl">Siga lojas logo nas redes sociais</span>
				<a href="#" class="social__net__link social__net__link--facebook"></a>
				<a href="#" class="social__net__link social__net__link--youtube"></a>
				<a href="#" class="social__net__link social__net__link--instagram"></a>
			</div>
		</div>
	</div><!-- Social -->
<?php get_footer();?>