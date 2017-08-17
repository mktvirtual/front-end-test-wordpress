<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>
		
		<link href="//www.google-analytics.com" rel="dns-prefetch">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php bloginfo('description'); ?>">

		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,700" rel="stylesheet">
		<link href="<?php echo get_template_directory_uri(); ?>/css/mapa.css" rel="stylesheet">
		<script src="<?php echo get_template_directory_uri(); ?>/js/mapa.js"></script>
		<?php wp_head(); ?>
		<script>
        // conditionizr.com
        // configure environment tests
        conditionizr.config({
            assets: '<?php echo get_template_directory_uri(); ?>',
            tests: {}
        });
</script>

<?php
	$logo = $wpLogo ? $wpLogo : 'logo_topo.png';
 ?>
	</head>
	<body <?php body_class(); ?>>

		<!-- wrapper -->
		<div class="container-fluid">

			<!-- header -->
			<header role="banner">
				<section>	
					<div class="container">
						<div class="row">
							<div class="col-xs-2 col-sm-6 col-md-6">
								<img  src="<?php echo get_template_directory_uri(); ?>/img/titulo.png" class="titulo">
							</div>
							<div class="col-xs-10 col-sm-6 col-md-6">
								<!-- logo -->
								<figure>
									<a href="https://www.sexlog.com/" target="_blank">
										<img src="<?php echo get_template_directory_uri(); ?>/img/logo_topo.png" alt="Logo">
									</a>
								</figure>
								<!-- /logo -->
							</div>
						</div>

					</div>
				</section>

			</header>
			<!-- /header -->
