<!DOCTYPE>
<html>
<head>
<meta charset="utf-8" />
		<title><?php wp_title('|'); ?></title>
		<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
</head>

<body>
<div class="topo">
  <header class="header">
    <div class="logo"><img src="<?php echo bloginfo('template_directory'); ?>/images/logo.png" width="188" height="49"></div>
  </header>
  <nav class="menu">
  	<li><?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?></li>
  </nav>
	</div>