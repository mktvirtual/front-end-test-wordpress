<!DOCTYPE html>
<html>
<head>
	
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title> <?php bloginfo() ?>  </title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?= get_bloginfo('template_url') ?>/css/fontawesome-sizes.css" />

	<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Alegreya+Sans:400,700' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" type="text/css" href="<?= get_bloginfo('template_url') ?>/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="<?= get_bloginfo('template_url') ?>/style.css" />

	<?php wp_head(); ?>

</head>
<body>

	<nav class="navbar">

		<div class="container">
			<div class="logo">
				<a href="/">
					<img src="<?= get_bloginfo('template_url') ?>/images/logo.png" alt="Lojas Logo" />
				</a>
			</div>

			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div> <!-- .navbar-header -->
		
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav pull-right">
					<li> <a href="#"> Peça seu cartão de cliente </a> </li>
					<li> <a href="#">  <i class="fa fa-barcode"></i> &nbsp; Solicite a 2ª via do boleto</a> </li>
					<li> <a href="#"> Encontre uma loja </a> </li>
					<li> <a href="#newsletter"> Assine a Newsletter </a> </li>

					<li id='tree-categorias'>
						<ul class="nav navbar-nav">
						<?php 
							$args = array(
								'exclude_tree' => '1,8',
								'title_li' => '',
								'orderby'  => 'ID',
								'hide_empty' => 0,
							);
							wp_list_categories($args)
						?>
						</ul>
					</li>

					<li> 
						<div id="busca">
							<input type="text" name="s" placeholder="Busca">
							<button id="submit-search" class="bt"><i class="fa fa-search"></i></button>
						</div> <!-- #busca -->
					</li>
				</ul>
			</div><!-- .nav-collapse -->
		</div> <!-- .container-->
	</nav> <!-- .navbar .navbar-inverse navbar-fixed-top -->

	<header id='main-header'>

		<div id="slider">
			<?php if( function_exists('cyclone_slider') ) cyclone_slider('header'); ?>

			<div id="slider-up">
				<div class="container">
					<a id="logo"href="/"> 
						<img src="<?= get_bloginfo('template_url') ?>/images/logo.png" alt="Lojas Logo" />
					</a>

					<div id="categorias">
						<ul class="pull-right">
						<?php 
							$args = array(
								'exclude_tree' => '1,8',
								'title_li' => '',
								'orderby'  => 'ID',
								'hide_empty' => 0,
							);
							wp_list_categories($args)
						?>
						</ul>
					</div> <!-- .col-sm-9 -->
				</div> <!-- .container -->
			</div> <!-- #slider-up -->
		</div> <!-- #slider --> 

	</header>

	<div id="container">

	    <div class="container">

     