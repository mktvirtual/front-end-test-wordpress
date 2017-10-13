<?php 
	// class
	$intro_class = "";
	$parallax = false;
	$intro_style = "";
	
	$intro_options = get_post_meta( get_the_ID(), 'mfn-post-intro', true );
	if( is_array( $intro_options ) ){
	
		if( isset( $intro_options['light'] ) ){
			$intro_class .= 'light';
		}
		if( isset( $intro_options['full-screen'] ) ){
			$intro_class .= ' full-screen';
		}
		if( isset( $intro_options['parallax'] ) ){
			$intro_class .= ' parallax';
			$parallax = true;
		}
		if( isset( $intro_options['cover'] ) ){
			$intro_style .= 'background-size:cover;';
		}
			
	}
	
	// style
	if( $bg_color = get_post_meta( get_the_ID(), 'mfn-post-bg', true ) ){
		$intro_style .= 'background-color:'. esc_attr( $bg_color ) .';';
	}
	if( $bg_image = get_post_meta( get_the_ID(), 'mfn-post-header-bg', true ) ){
		$intro_style .= 'background-image:url('. esc_url( $bg_image ) .');';
	} else {
		$parallax = false;
	}

	// padding
	if( $intro_padding = mfn_opts_get( 'single-intro-padding' ) ){
		$intro_padding = 'style="padding:'. esc_attr( $intro_padding ) .';"';
	}
	
	// parallax
	if( $parallax ){
		$parallax = mfn_parallax_data();
		
		if( mfn_parallax_plugin() == 'translate3d' ){
			if( wp_is_mobile() ){
				$intro_style .= 'background-attachment:scroll;background-size:cover;-webkit-background-size:cover;';
			} else {
				$intro_style = false;
			}
		} else {
			$intro_style .= 'background-repeat:no-repeat;background-attachment:fixed;background-size:cover;-webkit-background-size:cover;';
		}
	}
	
	// style - prepare
	if( $intro_style ){
		$intro_style = 'style="'. $intro_style .'"';
	}
	
	// IMPORTANT for post meta
	while ( have_posts() ){
		the_post();
	}
	wp_reset_query();
?>

<div id="Intro" class="<?php echo $intro_class; ?>" <?php echo $intro_style;?> <?php echo $parallax;?>>

	<?php 
		// parallax | translate3d -------
		if( ! wp_is_mobile() && $parallax && mfn_parallax_plugin() == 'translate3d' ){
			echo '<img class="mfn-parallax" src="'. esc_url( $bg_image ) .'" alt="'. __( 'parallax background', 'betheme' ) .'" style="opacity:0" />';
		}
	?>

	<div class="intro-inner" <?php echo $intro_padding; ?>>
	
		<?php
			$h = mfn_opts_get( 'title-heading', 1 );
			echo '<h'. $h .' class="intro-title">'. get_the_title() .'</h'. $h .'>';
		?>
		
		<?php if( mfn_opts_get( 'blog-meta' ) ): ?>
			<div class="intro-meta">

				<div class="author">
					<i class="icon-user"></i>
					<span><a href="<?php echo get_author_posts_url( get_the_author_meta('ID') ); ?>"><?php the_author_meta( 'display_name' ); ?></a></span>
				</div>

				<div class="date">
					<i class="icon-clock"></i>
					<span><?php echo get_the_date(); ?></span>
				</div>	
				
				<?php if( $categories = get_the_category() ): ?>
					<div class="categories">
						<i class="icon-docs"></i>
						<?php 
							$string_cat = '';
							foreach( $categories as $cat ){
								$string_cat .= '<a href="'. get_category_link( $cat->term_id ) .'">'. $cat->name .'</a>, ';
							}
							$string_cat = rtrim( $string_cat, ", " );
							echo '<span>'. $string_cat .'</span>';
						?>
					</div>
				<?php endif; ?>
				
				<?php 
					$terms = get_the_terms( false, 'portfolio-types' );
					if( is_array( $terms ) ): 
				?>
					<div class="categories">
						<i class="icon-docs"></i>
						<?php
							$string_term = '';
							foreach( $terms as $term ){
								$string_term .= '<a href="'. get_term_link( $term, 'post_tag' ) .'">'. $term->name .'</a>, ';
							}
							$string_term = rtrim( $string_term, ", " );
							echo '<span>'. $string_term .'</span>';
						?>
					</div>
				<?php endif; ?>
				
				<?php if( $terms = get_the_terms( false, 'post_tag' ) ): ?>
					<div class="tags">
						<i class="icon-tag"></i>
						<?php 
							$string_term = '';
							foreach( $terms as $term ){
								$string_term .= '<a href="'. get_term_link( $term, 'post_tag' ) .'">'. $term->name .'</a>, ';
							}
							$string_term = rtrim( $string_term, ", " );
							echo '<span>'. $string_term .'</span>';
						?>
					</div>
				<?php endif; ?>

			</div>
		<?php endif; ?>
	
	</div>
	
	<div class="intro-next"><i class="icon-down-open-big"></i></div>

</div>