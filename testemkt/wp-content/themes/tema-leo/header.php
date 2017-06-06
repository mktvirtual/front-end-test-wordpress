<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php wp_title(' >> ',true,'right'); bloginfo('name'); ?></title>
	<?php wp_head(); ?>
  </head>

  <body <?php body_class(); ?> >
    <header class="row no-max pad main">
  <h1><a class='current' href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
  <a href="" class="nav-toggle"><span></span>Menu</a>
  <nav>
    <h1 class="open"><a class='current' href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
    <?php
    
	  $defaults = array(
	              
				  'container' => false,
				  'theme-location' => 'primary-menu',
				  'menu_class' => 'no-bullet'
	  );
	  
	  wp_nav_menu($defaults);
	  
	?>
  </nav>
</header>
