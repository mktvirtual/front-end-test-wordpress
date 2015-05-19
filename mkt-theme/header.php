<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="favicon.ico" />

        <title><?php bloginfo('name'); ?></title>
        <meta name="description" content="<?php bloginfo('description'); ?>">

        <link href="<?php bloginfo('stylesheet_url'); ?>" rel="stylesheet">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/app/css/main.css">

        <link href='http://fonts.googleapis.com/css?family=Maven+Pro' rel='stylesheet' type='text/css'>

        <!--[if lt IE 9]>
            <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/app/css/ie-styles.css">
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>

        <!--[if lt IE 9]>
            <p class="browser-happy">Seu Internet Explorer <strong>está desatualizado</strong>. Por favor, <a href="http://windows.microsoft.com/pt-br/internet-explorer/download-ie" target="_blank">clique aqui</a> e atualize seu navegador para melhorar sua experiência.</p>
        <![endif]-->

            <header class="header">
                <div class="wrap">
                    <!-- <h1 class="logo"></h1> -->
                    <a href="<?php bloginfo('url'); ?>"><img src="<?php bloginfo('template_url'); ?>/app/img/logo.png" alt=""></a>
                    <div class="burger">
                        <b class="b"></b>
                        <b class="b"></b>
                        <b class="b"></b>
                    </div>
                </div>
                <nav class="navbar">
                    <div class="wrap">
                        <?php wp_nav_menu(array('menu_class' => 'nav close')); ?>
                    </div>
                    <div class="ruler"></div>
                </nav>
            </header>
