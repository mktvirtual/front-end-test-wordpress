<!DOCTYPE html>
<html>
<head>
	<title>Logo</title>
	<meta charset="utf-8" />
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<?php do_action( 'wp_enqueue_styles_and_scripts' ); ?>
	<?php wp_head(); ?>
	<script>
</script>
</head>
<body>
	<header>
		<div id="top-bar" class="orange">
			<ul id="top-menu" class="ul-horizontal-menu central text-right">
				<li><a href="#">Peça seu Cartão de Cliente</li></a>
				<li><a href="#"><span class="barcode-white-icon"></span>&nbsp;Solicite a 2ª via do boleto</li></a>
				<li><a href="#">Encontre uma loja</li></a>
				<li><a href="#">Assine a newsletter</li></a>
				<li class="input-wrapper"><input type="text" placeholder="Busca" /><input type="submit" /></li>
			</ul>
		</div>
		<div class="menu">
			<div class="central">
				<img src="<?php echo get_template_directory_uri() ?>/img/logo.png" alt="Lojas Logo" />
				<div class="menu-right text-right col">
					<ul class="ul-horizontal-menu" id="main-menu">
						<li>CAMPANHAS</li>
						<li>FEMININO</li>
						<li>MASCULINO</li>
						<li>KIDS</li>
						<li>CASA</li>
						<li>PROMOÇÕES</li>
					</ul>
				</div>
			</div>
		</div>
    
	</header>
		<div style="min-height: 50px;">
            <div id="slider_top" style="display: none; position: relative; margin: 0 auto;
                top: 0px; left: 0px; width: 1300px; height: 650px; overflow: hidden;">
                <div u="loading" style="position: absolute; top: 0px; left: 0px;">
                    <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block;
                        top: 0px; left: 0px; width: 100%; height: 100%;">
                    </div>
                    <div style="position: absolute; display: block; background: url('<?php echo get_template_directory_uri() ?>/img/loading.gif') #eee no-repeat center center; 
                        top: 0px; left: 0px; width: 100%; height: 100%;">
                    </div>
                </div>
                <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 1300px; height: 650px; overflow: hidden;">
                    <div>
                        <img u="image" src2="<?php echo get_template_directory_uri() ?>/img/banner1.jpg" />
                    </div>
                    <div>
                        <img u="image" src2="<?php echo get_template_directory_uri() ?>/img/banner2.jpg" />
                    </div>
                </div>
                <div u="navigator" class="jssorb21" style="bottom: 26px; right: 6px;">
            
                    <div u="prototype"></div>
                </div>
                       
                <span u="arrowleft" class="jssora21l" style="top: 123px; left: 8px;">
                </span>
            
                <span u="arrowright" class="jssora21r" style="top: 123px; right: 8px;">
                </span>
            
            </div>
            
        </div>
        <br />