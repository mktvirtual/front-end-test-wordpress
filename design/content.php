<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
	  <div class="row">
	  	<div class="column">
	    <?php
			if ( is_single() ) :
				the_title( '<h1 class="title">', '</h1>' );
			else :
				the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			endif;
		?>
		</div>
      </div>
	</header><!-- .entry-header -->

	<div class="entry-content">
	  <div class="row">
	  	<div class="column">
	    <?php
		  /* translators: %s: Name of current post */
		  the_content( sprintf(
		  __( 'Continue reading %s', 'twentyfifteen' ),
		  the_title( '<span class="screen-reader-text">', '</span>', false )
		  ) );
		?>
		</div>
	  </div>
		
	</div><!-- .entry-content -->

	<?php
		// Author bio.
		if ( is_single() && get_the_author_meta( 'description' ) ) :
			get_template_part( 'author-bio' );
		endif;
	?>

</article><!-- #post-## -->
