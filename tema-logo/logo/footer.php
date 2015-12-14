
		</main>
		<footer>
			<div class="container-fluid footer">
				<div class="row">
					<div class="col-md-7">
						<div class="container">
                    		<div class="row">
                    			<div class="col-md-8 col-sm-12">
	                    			<div class="col-md-4 col-sm-4">
	                    				<?php dynamic_sidebar( 'footer_area_1' ); ?>
	                    			</div>
	                    			<div class="col-md-4 col-sm-4">
	                    				<?php dynamic_sidebar( 'footer_area_2' ); ?>
	                    			</div>
	                    			<div class="col-md-4 col-sm-4">
	                    				<?php dynamic_sidebar( 'footer_area_3' ); ?>
	                    			</div>
	                    			<small>2015. Lojas Logo. Todos os direitos reservados.</small>
                    			</div>
                    		</div>
						</div>
					</div>
					<div class=" col-md-offset-7"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/mesa-rodape.jpg" alt="MKT Virtual"></div>
				</div>
			</div>
		</footer>

    <?php wp_footer(); ?>

  	</body>
</html>