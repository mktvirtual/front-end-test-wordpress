<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Home - MKT Virtual</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous" />
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
		<link rel="stylesheet" href="css/style.css"/>
	</head>
	<body>
		<header>
			<!-- TOP MENU -->
			<div class="container-fluid nav-top hidden-xs hidden-sm">
				<nav>
					<ul>
						<li>
							<a href="#" title="Cartão cliente">Peça seu Cartão de Cliente</a>
						</li>
						<li>
							<a href="#" title="Solicite o Boleto"><span class="glyphicon glyphicon-barcode"></span> Solicite a 2ª via do boleto</a>
						</li>
						<li>
							<a href="#" title="Encontre uma loja">Encontre uma loja</a>
						</li>
						<li>
							<a href="#" title="Newsletter">Assine a newsletter</a>
						</li>
					</ul>
					<div>
						<fieldset class="search-nav-top">
							<form action="" method="get" id="searchForm">
								<input type="search" name="search" placeholder="Busca"/>
								<button type="submit" form="searchForm" value=""><span class="glyphicon glyphicon-search"></span></button>
							</form>
						</fieldset>
					</div>
				</nav>
			</div>
			<!-- Bootstrap Carousel Slide -->
			<div class="container-fluid carousel-container-edit">
				<nav class="navbar navbar-default nav-edit-slide">
					<div class="">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a class="navbar-brand" href="#">
								<img src="img/logo.png" alt="Logo MKTVirtual" width="90%" class="img-responsive"/>
							</a>
						</div>
						<div id="navbar" class="navbar-collapse collapse">
							<ul id="panel-button" class="nav navbar-nav navbar-right">
								<li><a href="#">CAMPANHAS</a></li>
								<li><a href="#">FEMININO</a></li>
								<li><a href="#">MASCULINO</a></li>
								<li><a href="#">KIDS</a></li>
								<li><a href="#">CASA</a></li>
								<li><a href="#">PROMOÇÕES</a></li>
							</ul>
						</div>
					</div>
				</nav>
				<div id="myCarousel" class="carousel slide carousel-edit" data-ride="carousel">
					<ol class="carousel-indicators">
						<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
						<li data-target="#myCarousel" data-slide-to="1"></li>
						<li data-target="#myCarousel" data-slide-to="2"></li>
						<li data-target="#myCarousel" data-slide-to="3"></li>
					</ol>
					<div class="carousel-inner" role="listbox">
						<div class="item active">
							<img src="img/top-banner-01.jpg" alt="Legenda 01" width="100%" class="img-responsive">
						</div>
						<div class="item">
							<img src="img/top-banner-01.jpg" alt="Legenda 02" width="100%" class="img-responsive">
						</div>
						<div class="item">
							<img src="img/top-banner-01.jpg" alt="Legenda 03" width="100%" class="img-responsive">
						</div>
						<div class="item">
							<img src="img/top-banner-01.jpg" alt="Legenda 04" width="100%" class="img-responsive">
						</div>
					</div>

					<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						<span class="sr-only">Anterior</span>
					</a>
					<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						<span class="sr-only">Proximo</span>
					</a>
				</div>
			</div>
		</header>
		<div class="container center-bar-imgs">
			<div class=" col-fix-pd col-xs-12 col-md-4">
				<img src="img/center-img-01.jpg" alt="Legenda 01" width="100%" class="img-responsive"/>
				<div id="button-01" class="legend-img-center box-04">
					<a>PREENCHA A PROPOSTA DE ADESÃO</a>
					<div id="panel-01">
						<p>Formulario para preenchimento</p>
					</div>
				</div>
			</div>
			<div class="col-fix-pd col-xs-6 col-md-4">
				<img src="img/center-img-05.jpg" alt="Legenda 01"  width="100%" class="img-responsive"/>
				<div class="legend-img-center box-01">
					<span>BELEZA</span>
					<h4>RUIVA FATAL</h4>
					<p>Que o ruivo é o tom do momento todo mundo sabe.</p>
					<a href="#">SAIBA MAIS</a>
				</div>
			</div>
			<div class="col-fix-pd col-xs-6 col-md-4">
				<img src="img/center-img-04.jpg" alt="Legenda 01"  width="100%" class="img-responsive"/>
				<div class="legend-img-center box-02">
					<h4>PROMOÇÃO BOB ESPONJA</h3>
					<p>Na compra de uma peça Bob Esponja, ganhe um brinde.</p>
					<a href="#">CONTINUE LENDO</a>
				</div>
			</div>
			<div class="col-fix-pd col-xs-6 col-md-4">
				<img src="img/center-img-03.jpg" alt="Legenda 01"  width="100%" class="img-responsive"/>
				<div class="legend-img-center box-03">
					<span>MODA LOGO</span>
					<h4>PAIXÃO POR JEANS</h3>
					<p>Versátil, combina com vários estilos diferentes.</p>
					<a href="#">SAIBA MAIS</a>
				</div>
			</div>
			<div class="col-fix-pd col-xs-6 col-md-4">
				<img src="img/center-img-02.jpg" alt="Legenda 01"  width="100%" class="img-responsive"/>
				<div class="legend-img-center box-02">
					<span>BELEZA</span>
					<h4>PODER INSTANTÂNEO</h3>
					<p>Batom vermelho deixa toda mulher poderosa.</p>
					<a href="#">SAIBA MAIS</a>
				</div>
			</div>
		</div>
		<div class="container-fluid location-map">
			<div class="box-cep">
				<div class="col-sm-6 col-md-6">
					<button class="button-location" name="teste2" id="teste2">
						<div class="col-md-2">
							<i class="fa fa-map-marker"></i> 
						</div>
						<div class="col-md-10">
							ACHAR MINHA LOCALIZAÇÃO AUTOMATICAMENTE
						</div>
					</button>
				</div>
				<div class="col-sm-6 col-md-6 input-box-01">
					<span>DIGITE O CEP DE ONDE VOCÊ ESTÁ</span>
					<form action="" method="get" id="searchForm">
						<input type="text" name="cep" id="cepMask" placeholder="CEP"/>
						<input type="submit" name="submit" value="PROCURAR"/>
					</form>
				</div>
			</div>
		</div>
		<div class="container social-bar">
			<div class="col-xs-8 col-sm-8 col-md-6 input-box-01">
				<span>ASSINE A NEWSLETTER DO LOGO</span>
				<form action="" method="get" id="newsletterForm">
					<input type="text" name="newsletter" id="newsletter" placeholder="Seu email"/>
					<input type="submit" name="submit" value="ENVIAR"/>
				</form>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-6">
				<span>SIGA LOJAS LOGO NAS REDES SOCIAIS</span>
				<ul class="social-buttons">
					<li><a href="#" alt="Facebook"><i class="fa fa-facebook"></i></a></li>
					<li><a href="#" alt="Youtube"><i class="fa fa-youtube-play"></i></a></li>
					<li><a href="#" alt="Instagram"><i class="fa fa-instagram"></i></a></li>
				</ul>
			</div>
		</div>
		<footer class="container-fluid all-footer">
			<div class="container">
				<div class="col-xs-4 col-sm-4 col-md-2">
					<h4>LOJAS LOGO</h4>
					<ul>
						<li>Sobre</li>
						<li>Lojas</li>
						<li>Trabalhe Conosco</li>
						<li>Contato</li>
					</ul>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-2">
					<h4>LISTA DE ATALHOS</h4>
					<ul>
						<li>Portal do Colaborador</li>
						<li>Promoções</li>
						<li>Cartão do Cliente</li>
						<li>Cadastre-se</li>
						<li>Blog</li>
					</ul>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-2-5">
					<h4>SAC LOJA LOGO <span>0800-701-0316</span></h4>
					<button class="button-location btn-02">
						<div class="col-xs-6 col-md-2">
							<i class="fa fa-barcode"></i>
						</div>
						<div class="col-xs-6 col-md-10">
							<span>SOLICITAR 2º VIA BOLETO</span>
						</div>
					</button>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-5 img-footer hidden-xs hidden-sm"> 
					<img src="img/footer.jpg" alt="footer" width="100%" class="img-responsive"/> 
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 copyright-footer">
					<h6>2015. Lojas Logo. Todos direitos reservados.</h6>
				</div>
			</div>
		</footer>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="js/jquery.maskedinput.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<script src="js/main.js"></script>
	</body>
</html>