<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        <?php bloginfo('name'); echo " | "; bloginfo('description'); ?>
    </title>
    <!--- -->
    <!--- CSS -->
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
    <link rel="stylesheet" href="<?php bloginfo('template_url') ?>/assets/vendor/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php bloginfo('template_url') ?>/assets/vendor/font-awesome/css/font-awesome.min.css">
    <!--- JS -->
    <script type="text/javascript" src="<?php bloginfo('template_url') ?>/assets/vendor/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url') ?>/assets/vendor/tether/dist/js/tether.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url') ?>/assets/vendor/bootstrap/dist/js/bootstrap.min.js"></script>

</head>

<body <?php body_class(); ?>>
<div class="site-container">
    <header id="header">
        <section id="top-navigation">
            <div class="container-fluid mini-header">
                <div class="mini-header-container">
                    <div class="row">
                        <div class="col-lg-8 col-md-9 mini-header-links">
                            <ul class="float-right">
                                <li>
                                    <a href="#">Peça seu cartão de cliente</a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-barcode" aria-hidden="true"></i>&nbsp;&nbsp;Solicite a 2° via do boleto</a>
                                </li>
                                <li>
                                    <a href="#">Encontre uma loja</a>
                                </li>
                                <li>
                                    <a href="#">Assine a newsletter</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-4 col-md-3 form">
                            <form class="input-group">
                                <input type="text" placeholder="Busca" class="search">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="nav-container">
                <nav id="nav-header" class="navbar navbar-expand-md">
                    <a class="navbar-brand" href="#">
                        <span class="nav-brand">LOGO</span>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon">
                            <i class="fa fa-bars" aria-hidden="true"></i>
                        </span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ml-auto">
                            <?php wp_nav_menu(
                            array(
                                'theme_location' => 'navigation-menu',
                                'container' => false,
                                'items_wrap' => '%3$s'
                            )
                        ); ?>
                        </ul>

                    </div>
                </nav>
            </div>
        </section>

        <div id="banner">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <?php 
                    $args = array('post_type'=>'slider', 'showposts'=>4);
                    $my_slider = get_posts( $args );
                    $count = 0;
                    if($my_slider) : foreach($my_slider as $post) : setup_postdata( $post )
                ?>
                    <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $count ?>" <?php if($count==0 ) ?>class="active"?>></li>

                    <?php 
                    $count++;
                    endforeach;
                    endif;
                ?>
                </ol>
                <div class="carousel-inner">
                    <?php 
                            $args = array('post_type'=>'slider', 'showposts'=>4);
                            $my_slider = get_posts( $args );
                            $count = 0;
                            if($my_slider) : foreach($my_slider as $post) : setup_postdata( $post )
                        ?>

                    <div class="carousel-item <?php if($count == 0) echo active ?>">
                        <img class="d-block w-100 img-fit" src="<?php the_post_thumbnail_url('full') ?>" alt="<?php the_title() ?>">
                    </div>

                    <?php 
                            $count++;
                            endforeach;
                            endif;
                        ?>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </header>
   