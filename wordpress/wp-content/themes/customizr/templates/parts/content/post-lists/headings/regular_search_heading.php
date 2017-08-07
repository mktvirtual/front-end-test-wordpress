<?php
/**
* The template for displaying the sarch archive title (search, no-results )
*/
?>
<header class="archive-header search-header<?php czr_fn_echo( 'element_class' ) ?>" <?php czr_fn_echo('element_attributes') ?>>
  <div class="archive-header-inner">
    <h1 class="archive-title"><?php echo __( 'Search results for:', 'customizr' ) . ' ' . get_search_query() ?></h1>
    <?php
     global $wp_query;
     if ( $wp_query->found_posts ):
    ?>
    <div class="header-bottom">
     <span>
       <?php printf( _n('%s result', '%s results', $wp_query->found_posts, 'customizr' ), $wp_query->found_posts ) ?>
     </span>
    </div>
  <?php endif ?>
  <hr class="featurette-divider">
  </div>
</header>