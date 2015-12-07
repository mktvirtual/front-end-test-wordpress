<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>
  
  <!--Post-->
  <section id="post">
    <?php
      while ( have_posts() ) : the_post();
      get_template_part( 'content', get_post_format() );
      if ( comments_open() || get_comments_number() ) :
        comments_template();
      endif;
      endwhile;
    ?>
  </section>

<?php get_footer(); ?>
