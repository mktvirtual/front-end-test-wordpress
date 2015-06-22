<?php get_header(); ?>
	<div id="content-wrapper">
		<div class="central">
			<div class="content right">
			<?php
			$cont = 1;
	
			if ( have_posts() ) : while ( have_posts() ) : the_post(); 
				if ($cont === 5) :
			?>
			</div>
			<div class="content left">
				<div class="content-in">
					<?php
					if ( has_post_thumbnail() ) {
						the_post_thumbnail();
					}
					?>
					<div class="caption">
						<?php echo get_post_meta($post->ID, 'action_button_text', true); ?>
					</div>
				</div>
			</div>
			
			<?php else : ?>
			
				<div class="content-in c-<?php echo $cont ?>">
					<div class="post">
						<?php
						if ( has_post_thumbnail() ) {
						    the_post_thumbnail();
						}
						?>
						<div class="info">
							<h4><?php echo get_the_category( $post->ID, true )[0]->name ?></h4>
							<h3><?php the_title(); ?></h3>
							<div class="excerpt">
								<?php the_excerpt(); ?>
							</div>
							
							<div class="btn"><?php echo get_post_meta($post->ID, 'action_button_text', true); ?></div>
						</div>
					</div>
				</div>
			<?php endif; $cont++; endwhile; else : ?>
			</div>
			<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
		<?php endif; ?>
		</div>
	</div>
	<div id="google-maps">
		<div id="map-canvas">
			<div class="get-location">
			<div class="btn" id="btn-auto-local">
				<span class="icon">
					<span class="pin-icon"></span>
				</span>
				<span class="text">
					<div class="inside pin">
						ACHAR MINHA LOCALIZAÇÃO AUTOMATICAMENTE
					</div>
				</span>
			</div>&nbsp;
			<span>OU</span>
			&nbsp;
			<div class="cep-search">
				<p>DIGITE O CEP DE ONDE VOCÊ ESTÁ</p>
				<div class="cep-search-inn">
					<input type="text" id="txt-cep" placeholder="CEP" />
					<div class="btn" id="btn-cep">PROCURAR</div>
				</div>
			</div>
		</div>
		</div>

	</div>
	
	
	<div id="contact-info">
		<div class="central">
			<div id="newsletter">
				<p>ASSINE A NEWSLETTER DO LOGO</p>
				<input type="text" placeholder="Seu e-mail" />
				<input type="submit" value="ENVIAR" />
			</div>
			<div id="social-links">
				<p>SIGA LOJAS LOGO NAS REDES SOCIAIS</p>
				<a href="#"><span class="social-icon"><span class="facebook-icon"></span></span></a>
				<a href="#"><span class="social-icon"><span class="youtube-icon"></span></span></a>
				<a href="#"><span class="social-icon"><span class="instagram-icon"></span></span></a>
			</div>
		</div>
	</div>

<?php get_footer(); ?>
