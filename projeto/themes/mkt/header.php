
<!DOCTYPE HTML>
<html lang="pt-BR">
	<head>
		
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=no" />
	    
	    
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<title><?php wp_title(''); ?></title>
		<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	</head>
<body>
	

	<header id="menu_topo">
	  <h1>MKT VIRTUAL</h1>
	  <input type="checkbox" id="control-nav" />
	  <label for="control-nav" class="control-nav"></label>
	  <label for="control-nav" class="control-nav-close"></label>
	  
	    <nav>
		
			<?php wp_nav_menu( array( 'theme_location' => 'header' ) ); ?>
			<div id="menu_banner_desativado"><?php wp_nav_menu( array( 'theme_location' => 'banner' ) ); ?></div>
			
			
			<ul id="ul_p" style="float: right">
			<li class="li_p">
			<form>
			<input type="text" name="p" onfocus="this.value=''" onblur="if(this.value==''){this.value='Busca'}" class="pesquisar" value="Busca">
			<button type="submit" class="p">&nbsp;</button>
			</form>
			</li>
			</ul>
			
		</nav>
																		<div style="clear: both"> </div>
	</header>
	
																		<div style="clear: both"> </div>
	
	<div id="banner">
		
		<header id="menu_banner" class="limita">
			
			<nav class="menu_banner limita">
				<?php wp_nav_menu( array( 'theme_location' => 'banner' ) ); ?>
			</nav>
			<div class="logo">MKT VIRTUAL</div>
		</header>
		
	</div>