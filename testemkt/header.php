<?php include 'caminhos.php'; ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="pt-BR">
	<head profile="http://gmpg.org/xfn/11">
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<title><?php bloginfo('name'); ?><?php wp_title('|'); ?></title>
		<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
		<?php wp_head(); ?>
	</head>
	<body>
		<div class="container">
			<header class="topo">
				<div class="container">
					<figure class="logo-mkt">
						<img src="<?php echo $caminho; ?>images/logo-mkt.png" alt="Logo MKT Virtual">
					</figure>
					<nav class="menu">
						<li>Lorem</li>
						<li>Ipsum  Dolor</li>
						<li>Sit Amet</li>
						<li>Mauris</li>
						<li>Neque Nulla</li>
						<li>Bibendum</li>
						<li>Conguedon Mauris</li>
					</nav>
				</div>
			</header>