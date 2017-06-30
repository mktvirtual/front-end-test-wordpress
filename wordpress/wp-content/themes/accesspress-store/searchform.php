<?php
/**
  *
 * @package Accesspress Store
 */
 ?>
<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<input type="text" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" class="search-field" placeholder="<?php _e('Busca','accesspress-store') ?>" />
    <input type="hidden" name="post_type" value="product">
    <button type="submit" class="searchsubmit"><i class="fa fa-search"></i></button> 
</form>
