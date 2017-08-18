<?php get_header(); ?>

	<main role="main">
		<!-- section -->
		<section>
			<?php get_template_part('partial/promocao'); ?>
		</section>
		<!-- /section -->
	
		<section>
			<div class="box-widgets-2">
				<?php get_template_part('partial/mapa');  ?>
			</div>
		</section>
		<section>
			<div class="row">
				<div class="col-sm-4">
					<div class="newsletter">
						<p>Assine a newsletter do logo</p>
						<form>
							<input type="mail" name="newsletterEmail" placeholer="Seu email">
							<div class="btn-default">
                                <button>Enviar</button>
                            </div>
						</form>
					</div>
				</div>
				<div class="col-sm-8">
					<div class="social-media">
						<p>Siga lojas logo nas redes sociais</p>
						<a href="#" class="icon facebook" title="Ir para facebook">
							<img src="<?php echo get_template_directory_uri(); ?>/img/icons/fb.png" alt="Icon Facebook"  />
						</a>
						<a href="#" class="icon youtube">
							<img src="<?php echo get_template_directory_uri(); ?>/img/icons/yout.png" alt="Icon Youtube" title="Ir para Youtube"  />
						</a>
						<a href="#" class="icon instagram">
							<img src="<?php echo get_template_directory_uri(); ?>/img/icons/insta.png" alt="Icon Instagram"  title="Ir para Instagram"  />
						</a>
					</div>
				</div>
			</div>
		</section>
		<section>
			<div class="box-widgets-1">
				<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-area-1')) ?>
			</div>
		</section>
		<section>
			<div class="box-widgets-2">
				<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-area-2')) ?>
			</div>
		</section>
	</main>



<?php get_footer(); ?>
