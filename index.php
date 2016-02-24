<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Home - MKT Virtual</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous" />
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
		<link rel="stylesheet" href="css/style.css"/>
	</head>
	<style type="text/css">
	.navbar-edit-fixed{
		position:fixed;
		top:0;
		left:0;
		background:#F47D31;
		width:100%;
		padding-right:15%;
		padding-left:15%;
		border-bottom-left-radius:50px;
		border-bottom-right-radius:50px;
		-webkit-transition: all 0.5s ease-out;
		-moz-transition: all 0.5s ease-out;
		-o-transition: all 0.5s ease-out;
		transition: all 0.5s ease-out;
	}
	.navbar-edit-fixed img{
		width:40%;
	}
	.navbar-edit-fixed a{
		color:#FFF !important;
	}
	.navbar-edit-absolute{
		position:absolute;
		top:5%;
	}
	</style>
	<script type="text/javascript">
	$(document).ready(function(){
		$('#button-01').click(function(){
			$('#panel-01').slideToggle('slow');
		});
		
	});
	$(document).ready(function() {
		$(window).bind('scroll', function () {
			if ($(window).scrollTop() > 500) {
				$('.nav-edit-slide').removeClass("navbar-edit-absolute").addClass("navbar-edit-fixed");
			} else {
				$('.nav-edit-slide').removeClass("navbar-edit-fixed").addClass("navbar-edit-absolute");
			}
		});
	});
	</script>
	<body>
		<header>
			<!-- TOP MENU -->
			<div class="container-fluid nav-top">
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
								<img src="imgs/logo.png" alt="Logo MKTVirtual" width="90%" class="img-responsive"/>
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
							<img src="imgs/top-banner-01.jpg" alt="Legenda 01" width="100%" class="img-responsive">
						</div>
						<div class="item">
							<img src="imgs/top-banner-01.jpg" alt="Legenda 02" width="100%" class="img-responsive">
						</div>
						<div class="item">
							<img src="imgs/top-banner-01.jpg" alt="Legenda 03" width="100%" class="img-responsive">
						</div>
						<div class="item">
							<img src="imgs/top-banner-01.jpg" alt="Legenda 04" width="100%" class="img-responsive">
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
			<div class="col-md-4" style="padding:0px;">
				<img src="imgs/center-img-01.jpg" alt="Legenda 01" width="95%" class="img-responsive"/>
				<div class="legend-img-center box-04">
					<a id="button-01">PREENCHA A PROPOSTA DE ADESÃO</a>
					<div id="panel-01">
						<br />
						<p>Now you see me!</p>
					</div>
				</div>
			</div>
			<div class="col-md-8" style="padding:0px;">
				<div class="col-fix-pd col-md-6">
					<img src="imgs/center-img-05.jpg" alt="Legenda 01"  width="100%" class="img-responsive"/>
					 <div class="legend-img-center box-01">
						<span>BELEZA</span>
						<h4>RUIVA FATAL</h4>
						<p>Que o ruivo é o tom do momento todo mundo sabe.</p>
						<a href="#">SAIBA MAIS</a>
					</div>
				</div>
				<div class="col-fix-pd col-md-6">
					<img src="imgs/center-img-04.jpg" alt="Legenda 01"  width="100%" class="img-responsive"/>
					 <div class="legend-img-center box-02">
						<h4>PROMOÇÃO BOB ESPONJA</h3>
						<p>Na compra de uma peça Bob Esponja, ganhe um brinde.</p>
						<a href="#">CONTINUE LENDO</a>
					</div>
				</div>
				<div class="col-fix-pd col-md-6">
					<img src="imgs/center-img-03.jpg" alt="Legenda 01"  width="100%" class="img-responsive"/>
					 <div class="legend-img-center box-03">
						<span>MODA LOGO</span>
						<h4>PAIXÃO POR JEANS</h3>
						<p>Versátil, combina com vários estilos diferentes.</p>
						<a href="#">SAIBA MAIS</a>
					</div>
				</div>
				<div class="col-fix-pd col-md-6">
					<img src="imgs/center-img-02.jpg" alt="Legenda 01"  width="100%" class="img-responsive"/>
					 <div class="legend-img-center box-02">
						<span>BELEZA</span>
						<h4>PODER INSTANTÂNEO</h3>
						<p>Batom vermelho deixa toda mulher poderosa.</p>
						<a href="#">SAIBA MAIS</a>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid location-map">
			<div class="box-cep">
				<div class="col-md-6">
					<button class="button-location" name="teste2" id="teste2">
						<div class="col-md-2">
							<i class="fa fa-map-marker"></i> 
						</div>
						<div class="col-md-10">
							ACHAR MINHA LOCALIZAÇÃO AUTOMATICAMENTE
						</div>
					</button>
				</div>
				<div class="col-md-6">
					<span>DIGITE O CEP DE ONDE VOCÊ ESTÁ</span>
					<form action="" method="get" id="searchForm">
						<input type="text" name="cep" id="cep" placeholder="CEP"/>
						<input type="submit" name="submit" value="PROCURAR"/>
					</form>
				</div>
			</div>
		</div>
		<br/><br/><br/><br/>
		
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	</body>
</html>