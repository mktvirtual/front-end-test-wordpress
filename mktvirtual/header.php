<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">

        <!-- jQuery -->
        <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        
        <!-- Arquivos Bootstrap -->
        <link href="<?php echo get_template_directory_uri(); ?>/bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <script src="<?php echo get_template_directory_uri(); ?>/bootstrap/js/bootstrap.min.js"></script>
        
        <!-- Font Awesome -->
        <link href="<?php echo get_template_directory_uri(); ?>/css/font-awesome.min.css" type="text/css" rel="stylesheet">

        <!-- Template -->
        <link href="<?php echo get_template_directory_uri(); ?>/style.css" type="text/css" rel="stylesheet">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php bloginfo('description'); ?>">
	</head>
	
        <body <?php body_class(); ?>>
                 
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <a href="<?php echo home_url(); ?>">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/logo-mkt.png" alt="MktVirtual" class="img-responsive logo">
                        </a>
                    </div>
                </div>                    
            </div>
                  
            <nav class="navbar navbar-default" role="navigation">
                <div class="container">
                    <div class="row">
                        <div class="navbar-header">
                           <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu-mkt">
                             <span class="sr-only">Ativar Navegação</span>
                             <span class="icon-bar"></span>
                             <span class="icon-bar"></span>
                             <span class="icon-bar"></span>
                           </button>
                           <span class="navbar-brand visible-xs">Menu</span>
                       </div>
                       <div class="collapse navbar-collapse" id="menu-mkt">
                       <?php echo wp_nav_menu('navmenu'); ?>
                       </div>
                    </div>
                </div>
            </nav>
