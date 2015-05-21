<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta content="telephone=no" name="format-detection">

	<!-- Bootstrap css -->
	<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/bootstrap.css';?>" type="text/css" media="screen">
	
	<link rel="stylesheet" href="<?php echo esc_url( get_stylesheet_uri() ); ?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/responsive.css';?>" type="text/css" media="screen">

	<!-- fonts -->
	<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Alegreya+Sans:100,300,400,500,700,800,900,100italic,300italic,400italic,500italic,700italic,800italic,900italic' rel='stylesheet' type='text/css'>

	<!-- font awesome -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/font-awesome/css/font-awesome.min.css';?>">

	<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/js/jquery-1.11.3.min.js';?>"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri() . '/js/hamburger.js';?>"></script>
	
	<?php wp_head(); ?>
</head>
<body>

<div class="page-body">
	<header class="site-header">
	   	<div class="apoio">
	   		<div class="container">
	   			<ul>
	   				<li><a href="#">Peça seu Cartão de Cliente</a></li>
	   				<li><a href="#"><img class="barcode-apoio " src="<?php echo get_template_directory_uri() . '/images/barcode-icon.png';?>" alt="barcode icon">Solicite a 2ª via do boleto</a></li>
	   				<li><a href="#">Encontre uma loja</a></li>
	   				<li><a href="#">Assine a newsletter</a></li>
	   				<li>
	   					<form method="get" id="search_form" action="<?php bloginfo('home'); ?>"/>
					       <input type="text" class="text" name="s" value="Buscar" >
					       <button type="submit" class="submit"/><i class="fa fa-search"></i></button>
						</form>
					</li>
	   			</ul>
	   		</div>
	   	</div>

	   	<div class="nav">
	   		<div class="container">
	   			<div class="logo"><img src="<?php echo get_template_directory_uri() . '/images/logo/logo.png';?>" alt="logo image"></div>
	   			<?php wp_nav_menu( array( 'theme_location' => 'nav-menu' ) ); ?>
	   		</div>
	   	</div>
		
		<div id="hamburger">
            <div></div>
            <div></div>
            <div></div>
        </div>

	</header>
