<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
<title><?php wp_title(); ?></title>
<?php wp_head(); ?>
</head>
<body>

<div class="container-fluid">
	<div class="row">
		<div class="f-nav">
			<div class="col-md-8 col-lg-6 col-lg-offset-2 links">
				<ul>
					<li><a href="#"> Peça seu cartão de cliente </a></li>
					<li><a href="#"><span class="glyphicon glyphicon-barcode" aria-hidden="true"></span> Solicite a 2° via do boleto </a></li>
					<li><a href="#"> Encontre uma loja </a></li>
					<li><a href="#"> Assine a newsletter </a></li>
				</ul>
			</div>
			<div class="col-md-4 col-lg-2 form">	
				<form>
					<input type="" name="" placeholder="Busca" class="search">
				</form>
			</div>
		</div>
	</div>
</div>

<!-- SEGUNDO MENU -->
<nav class="navbar s-nav">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed  icon-responsive" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="glyphicon glyphicon-align-justify"></span>
      </button>
      <a class="main-logo" href="#"> LOGO </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li class="item-list"><a href="#" class="link-list"> CAMPANHAS </a></li>
        <li class="item-list"><a href="#" class="link-list"> FEMININO </a></li>
        <li class="item-list"><a href="#" class="link-list"> MASCULINO </a></li>
        <li class="item-list"><a href="#" class="link-list"> KIDS </a></li>
        <li class="item-list"><a href="#" class="link-list"> CASA </a></li>
        <li class="item-list"><a href="#" class="link-list"> PROMOÇÕES </a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<!-- SILEDE -->
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img src="https://imagens.buzzpage.com.br/user_images/uploads/14044novayork_big.jpg" alt="..." width="100%">
      <div class="carousel-caption">
        ...
      </div>
    </div>
    <div class="item">
      <img src="https://imagens.buzzpage.com.br/user_images/uploads/14044novayork_big.jpg" alt="..." width="100%">
      <div class="carousel-caption">
        ...
      </div>
    </div>
    <div class="item">
      <img src="https://imagens.buzzpage.com.br/user_images/uploads/14044novayork_big.jpg" alt="..." width="100%">
      <div class="carousel-caption">
        ...
      </div>
    </div>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>