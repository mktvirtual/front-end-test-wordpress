<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Home - MKT Virtual</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous" />
		<link rel="stylesheet" href="css/style.css"/>
	</head>
	<body>
		<header>
			<!-- TOP MENU -->
			<div class="container-fluid nav-top">
				<nav >
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
				<div id="myCarousel" class="carousel slide carousel-edit" data-ride="carousel">
					<ol class="carousel-indicators">
						<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
						<li data-target="#myCarousel" data-slide-to="1"></li>
						<li data-target="#myCarousel" data-slide-to="2"></li>
						<li data-target="#myCarousel" data-slide-to="3"></li>
					</ol>
					<div class="carousel-inner" role="listbox">
						<div class="item active">
							<img src="imgs/top-banner-01.jpg" alt="Legenda 01">
						</div>
						<div class="item">
							<img src="imgs/top-banner-02.jpg" alt="Legenda 02">
						</div>
						<div class="item">
							<img src="imgs/top-banner-03.jpg" alt="Legenda 03">
						</div>
						<div class="item">
							<img src="imgs/top-banner-04.jpg" alt="Legenda 04">
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
				<nav class="container navbar navbar-default nav-edit-slide">
					<div class="container-fluid">
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

							<ul class="nav navbar-nav navbar-right">
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
			</div>		
		</header>
		
		<h1>Hello, world!</h1>
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	</body>
</html>