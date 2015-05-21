<!doctype html>
<html class="no-js" lang="pt-br">
<?php wp_head(); ?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=9" /> 
<title><?php bloginfo('name'); ?></title>

<!-- CSS -->
<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css">

<script type="text/javascript">  
	document.getElementById(celHorUl).style.display = "none";
		function altera_display(id) {
			// Opções para o atributo display - block, inline e none
			if(document.getElementById(id).style.display=="none") {
				document.getElementById(id).style.display = "block";
			}
			else {
				document.getElementById(id).style.display = "none";
			}
		}        
</script>

</head>

<body>
	<section id="wrapper">
    	<header>
        	<nav id="infos-top">
            	<section class="wrap">
                	<form id="buscaHeader">
                        <input type="search" name="termo" value="Busca" onfocus="javascript: if(this.value=='Busca'){this.value='';};" onblur="javascript: if(this.value==''){this.value='Busca'};">
                        <button></button>
                    </form>
                	<ul>
                    	<li><a href="javascript:void(0)" class="cartao-top" title="Peça seu Cartão de Cliente">Peça seu Cartão de Cliente</a></li>
                  		<li><a href="javascript:void(0)" class="top-boleto" title="Selecione a 2ª via do boleto">Selecione a 2ª via do boleto</a></li>
                    	<li><a href="javascript:void(0)" title="Encontre uma loja">Encontre uma loja</a></li>
                    	<li><a href="javascript:void(0)" title="Assine a newsletter">Assine a newsletter</a></li>
            		</ul>
                </section>
            </nav>
        	<section id="logo-menu" class="wrap">
            	<a href="" id="logo"><img src="<?php bloginfo('template_url'); ?>/images/logo.png"></a>
            	<nav id="menu">
                	<ul class="nv1-ul">
                    	<li class="nv1-li">
                        	<a href="javascript:void(0)" title="Campanhas" class="nv1-a">Campanhas</a>
                            <ul class="nv2-ul">
                            	<li class="nv2-li">
                                	<a href="javascript:void(0)" class="nv2-a" title="Verão Especial">Verão Especial</a>
                                    <a href="javascript:void(0)" class="nv2-a" title="Festa em Família no Fim do Ano">Festa em Família no Fim do Ano</a>
                                    <a href="javascript:void(0)" class="nv2-a" title="Alto Verão">Alto Verão</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nv1-li">
                        	<a href="javascript:void(0)" title="Feminino" class="nv1-a">Feminino</a>
                            <ul class="nv2-ul ul-feminino">
                            	<li class="nv2-li">
                                	<a href="javascript:void(0)" class="nv2-a" title="Adulto">Adulto</a>
                                    <a href="javascript:void(0)" class="nv2-a" title="Tamanhos Grandes">Tamanhos Grandes</a>
                                    <a href="javascript:void(0)" class="nv2-a" title="Esporte">Esporte</a>
                                    <a href="javascript:void(0)" class="nv2-a" title="Lingerie">Lingerie</a>
                                    <a href="javascript:void(0)" class="nv2-a" title="Acessórios">Acessórios</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nv1-li">
                        	<a href="javascript:void(0)" title="Masculino" class="nv1-a">Masculino</a>
                            <ul class="nv2-ul ul-masculino">
                            	<li class="nv2-li">
                                	<a href="javascript:void(0)" class="nv2-a" title="Adulto">Adulto</a>
                                    <a href="javascript:void(0)" class="nv2-a" title="Tamanhos Grandes">Tamanhos Grandes</a>
                                    <a href="javascript:void(0)" class="nv2-a" title="Esporte">Esporte</a>
                                    <a href="javascript:void(0)" class="nv2-a" title="Acessórios">Acessórios</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nv1-li">
                        	<a href="javascript:void(0)" title="Kids" class="nv1-a">Kids</a>
                            <ul class="nv2-ul ul-kids">
                            	<li class="nv2-li">
                                	<a href="javascript:void(0)" class="nv2-a" title="Bebê">Bebê</a>
                                    <a href="javascript:void(0)" class="nv2-a" title="Infantil">Infantil</a>
                                    <a href="javascript:void(0)" class="nv2-a" title="Juvenil">Juvenil</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nv1-li">
                        	<a href="" title="Casa" class="nv1-a">Casa</a>
                        </li>
                        <li class="nv1-li">
                        	<a href="" title="Promoções" class="nv1-a">Promoções</a>
                        </li>
                    </ul>
                </nav>
            </section>
           <section id="top-cel">
            	<a href="" id="logo-cel"><img src="<?php bloginfo('template_url'); ?>/images/logo-cel.png"></a>
                <section id="menuCelHor">
                    <a onClick="altera_display('celHorUl');return true;" class="menuPrincipal" href="#" title="Menu">Menu</a>
                    <ul id="celHorUl" style="display:none; z-index:100000">
                        <li><a href="javascript:void(0)" title="Campanhas">Campanhas</a></li>
                        <li><a href="javascript:void(0)" title="Feminino">Feminino</a></li>
                        <li><a href="javascript:void(0)" title="Masculino">Masculino</a></li>
                        <li><a href="javascript:void(0)" title="Kids">Kids</a></li>
                        <li><a href="javascript:void(0)" title="Casa">Casa</a></li>
                        <li><a href="javascript:void(0)" title="Promoções">Promoções</a></li>  
                    </ul>
                </section>
           </section>
           
            <section id="slider">
            </section>
        </header>