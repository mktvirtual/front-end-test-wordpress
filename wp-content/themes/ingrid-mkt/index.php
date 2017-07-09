<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <!-- TITULO PÁGINA -->
        <title><?php wp_title('-', true, 'right'); bloginfo(); ?></title>
        <!-- -PARTIAL HEAD -->
        <?php include('includes/partial-head.php'); ?>
        <!--HEAD WP -->
        <?php //wp_head(); ?>
    </head>
    <body>
        <!-- HEADER -->
        <?php include('includes/header.php'); ?> 
        <!-- MAIN -->
        <main class="main home">
            <!-- SLIDER -->
            <section id="swiper__home" class="swiper__home swiper-container hide-md">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <a href="#" target="_blank" alt="Banner 1">
                            <figure class="banners">
                                <img class="img-100" src="<?php bloginfo('template_url'); ?>/assets/dist/images/banner-1.jpg" />
                            </figure>
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="#" target="_blank" alt="Banner 2">
                            <figure class="banners">
                                <img class="img-100" src="<?php bloginfo('template_url'); ?>/assets/dist/images/banner-2.jpg" />
                            </figure>
                        </a>
                    </div>
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
                <!-- /SLIDER -->
            </section>
            <!-- DESTAQUES -->
            <section class="destaques">
                <div class="wrapper">
                    <div class="row">
                        <div class="content row">
                           <ul class="destaques__lista flex-grid around-xs">
                        <li class="adesao lista__item">
                            <a href="" class="lista__link">
                                <figure class="lista__figure">
                                    <img src="<?php bloginfo('template_url'); ?>/assets/dist/images/img-adesao-home.jpg" class="img img-100"/>
                                </figure>
                                <div class="adesao__description">
                                    <p class="text">preencha a proposta de adesão</p>
                                </div>
                            </a>
                        </li>
                        <li class="lista__item">
                            <a href="" class="lista__link">
                                <figure class="lista__figure">
                                    <img src="<?php bloginfo('template_url'); ?>/assets/dist/images/img-destaque-1.jpg" class="img img-100"/>
                                </figure>
                                <div class="lista__description lista__description--left flex-grid">
                                    <span class="categoria hide-md">Beleza</span>
                                    <strong class="titulo">Ruiva Fatal</strong>
                                    <p class="text hide-md">Que o ruivo é o tom do momento<br/> todo mundo sabe.</p>
                                    <span class="bt-default hide-md">Saiba Mais</span>
                                </div>
                            </a>
                        </li>
                        <li class="lista__item">
                            <a href="" class="lista__link">
                                <figure class="lista__figure">
                                    <img src="<?php bloginfo('template_url'); ?>/assets/dist/images/img-destaque-3.jpg" class="img img-100"/>
                                </figure>
                                <div class="lista__description lista__description--right flex-grid">
                                    <span class="categoria hide-md">Moda Logo</span>
                                    <strong class="titulo">Paixão por Jeans</strong>
                                    <p class="text hide-md">Versátil, combina com vários estilos diferentes.</p>
                                    <span class="bt-default hide-md">Saiba Mais</span>
                                </div>
                            </a>
                        </li>
                        <li class="lista__item">
                            <a href="" class="lista__link">
                                <figure class="lista__figure">
                                    <img src="<?php bloginfo('template_url'); ?>/assets/dist/images/img-destaque-2.jpg" class="img img-100"/>
                                </figure>
                                <div class="lista__description lista__description--center flex-grid">
                                    <strong class="titulo">Promoção Bob Esponja</strong>
                                    <p class="text hide-md">Na compra de uma peça Bob Esponja, ganhe um brinde.</p>
                                    <span class="bt-default hide-md">Saiba Mais</span>
                                </div>
                            </a>
                        </li>
                        <li class="lista__item">
                            <a href="" class="lista__link">
                                <figure class="lista__figure">
                                    <img src="<?php bloginfo('template_url'); ?>/assets/dist/images/img-destaque-4.jpg" class="img img-100"/>
                                </figure>
                                <div class="lista__description lista__description--center flex-grid">
                                    <span class="categoria hide-md">Beleza</span>
                                    <strong class="titulo">Poder Instânteneo</strong>
                                    <p class="text hide-md">Batom vermelho deixa toda mulher poderosa.</p>
                                    <span class="bt-default hide-md">Saiba Mais</span>
                                </div>
                            </a>
                        </li>
                         <!-- /DEMAIS DESTAQUES-->
                    </ul>
                        </div>
                    </div>
                </div>
                <!-- /DESTAQUES -->
            </section>
            <!-- LOCALIZAÇÃO -->
            <section class="localizacao flex-grid center-xs middle-xs">
                <div class="localizacao__boxes flex-grid col-md-6 around-sm middle-sm wrap-md">
                    <!-- AUTOMATICA -->
                    <a href="#" class="box-default flex-grid around-sm col-sm-4" title="achar minha localização automaticamente">
                        <i class="fa fa-map-marker col-sm-2"></i>
                        <span class="text col-lg-8">achar minha localização automaticamente</span>
                        <!-- /AUTOMATICA -->
                    </a>
                    <!-- SEPARADOR -->
                    <span class="localizacao__separador flex-grid">ou</span>
                    <!-- CEP -->
                    <div class="form__box">
                        <strong class="home__tag">digite o cep de onde você está</strong>
                        <form action="" method="get" class="form">
                            <div class="form__inside">
                                <input type="text" name="" placeholder="CEP" class="form__input" maxlength="8" />
                                <button class="form__btn bt-default">Procurar</button>
                            </div>
                        </form>
                        <!-- /CEP -->
                    </div>
                </div>
                <!-- /LOCALIZAÇÃO -->
            </section>
            <!-- CONTATO -->
            <section class="contato">
                <div class="wrapper row between-xs">
                    <!-- NEWSLETTER -->
                    <div class="form__box wrap-md col-md-6">
                        <strong class="home__tag">assine a newsletter do logo</strong>
                        <form action="" method="get" class="form">
                            <div class="form__inside flex-grid col-md-8 around-md">
                                <input type="email" name="" placeholder="Seu e-mail" class="form__input col-md-8" />
                                <button class="form__btn bt-default">Enviar</button>
                            </div>
                        </form>
                        <!-- /NEWSLETTER -->
                    </div>
                    <!-- REDES SOCIAIS -->
                    <div class="redes-sociais col-md-6">
                        <strong class="home__tag">siga lojas logo nas redes sociais</strong>
                        <ul class="redes-sociais__lista row col-sm">
                            <li class="redes-sociais__item">
                                <a href="" title="Facebook" class="redes-sociais__link"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li class="redes-sociais__item">
                                <a href="" title="Youtube" class="redes-sociais__link"><i class="fa fa-youtube-play"></i></a>
                            </li>
                            <li class="redes-sociais__item">
                                <a href="" title="Instagram" class="redes-sociais__link"><i class="fa fa-instagram"></i></a>
                            </li>
                        </ul>
                        <!-- /REDES SOCIAIS -->
                    </div>
                </div>
                <!-- /CONTATO -->
            </section>
            <!-- /MAIN -->
        </main>
        <!-- FOOTER -->
        <?php include('includes/footer.php'); ?> 
        <!-- SCRIPTS -->
        <?php include('includes/script.php'); ?> 
        <!--FOOTER WP -->
        <?php //wp_footer(); ?>
    </body>
</html>
