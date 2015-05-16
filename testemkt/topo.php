	<header>
		<div class="container">
			<nav class='menus'>
				<figure class="logo">
					<a href="<?php echo $url; ?>">
						<img class="margin-logo" src="<?php echo $caminho; ?>images/logo-mariplast.png" alt="Mariplast">
					</a>
				</figure>
				<?php 
					$args= array(
						'menu' => 'main-menu',
						'echo' => false
						);
					echo strip_tags(wp_nav_menu( $args ),'<a><li><ul>'); 
				?>
			</nav>
			<?php get_product_search_form(); ?>
		</div>
	</header>