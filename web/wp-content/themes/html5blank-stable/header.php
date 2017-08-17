<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

		<link href="//www.google-analytics.com" rel="dns-prefetch">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php bloginfo('description'); ?>">

		<link href="<?php echo get_template_directory_uri(); ?>/css/main-nav.css" rel="stylesheet" >
		
		<!-- Bootstrap core CSS -->
		<link href="<?php echo get_template_directory_uri(); ?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="<?php echo get_template_directory_uri(); ?>/css/full-slider.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Maven+Pro:400,500,700,900" rel="stylesheet"> 
		<?php wp_head(); ?>
		<script>
        // conditionizr.com
        // configure environment tests
        conditionizr.config({
            assets: '<?php echo get_template_directory_uri(); ?>',
            tests: {}
        });
        </script>

	</head>
	<body <?php body_class(); ?>>
			<!-- header -->
			<header class="header clear" role="banner">
				<section><!-- Fixed navbar -->
					<nav class="navbar navbar-default fixed-top" role="navigation">
							<div class="navbar-header">
								<div class="container">
									<div class="row container navbar-container">
											<div class="col-md-7">
												<div id="nav" class=""  >
													<?php html5blank_nav(); ?>
												</div>
												<button type="button" class="navbar-toggle menu-button collapsed" data-toggle="collapse" data-target=".navbar-collapse" aria-expanded-"false" aria-controls="navbar" style="display: none;">
														<span class="sr-only">Toggle navigation</span>
														<span class="icon-bar"></span>
														<span class="icon-bar"></span>
														<span class="icon-bar"></span>
												</button>
											</div>
											<div class="col-md-5">
												<div class="box-busca">
															<?php get_template_part('searchform'); ?>
														</div>
												</div>
											</div>
											
									</div>
								</div>
							</div>
							<div class="container">
								<a class="navbar-brand page-scroll" href="#page-top" dir="ltr" title="Logo Brand">
									<img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="Logo Brand" />
								</a> 
								<figure title=" Logo"  id="brand" style="display: none;">
									<img src="<?php echo get_template_directory_uri(); ?>/img/logo-small.png" alt="Ferracini Brand"  />
								</figure>
							</div>

						</nav><!-- /.navbar -->
				</section>
			</header>
			<section>
				<?php get_template_part('./partial','slider'); ?>
			</section>
			<!-- /header -->
		<!-- wrapper -->
		<div class="wrapper container">
