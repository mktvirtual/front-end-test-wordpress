  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <?php wp_head(); ?>
  </head>
  <body>
  <header>
    <nav class="navbar-fixed-top navbar-sup">
      <div class="collapse navbar-collapse">
        <div class="container">
          <ul class="navbar-right list-inline">
            <li><a href="#">Peça seu Cartão de Cliente</a></li>
            <li><a href="#"><i class="fa fa-barcode"></i>Solicite a 2ª via do boleto</a></li>
            <li><a href="#">Encontre uma loja</a></li>
            <li><a href="#">Assine a newsletter</a></li>
            <li><?php get_search_form(); ?></li>
          </ul>
        </div>
      </div>
    </nav>
    <nav class="navbar navbar-fixed-top" id="startchange">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-sm-2 col-xs-4">
            <div class="navbar-header">
              <?php if ( get_theme_mod( 'themeslug_logo' ) ) : ?>
                <a class="navbar-brand" href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'>
                  <img src='<?php echo esc_url( get_theme_mod( 'themeslug_logo' ) ); ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'>
                </a>
              <?php else : ?>
                <hgroup>
                  <h1 class='site-title'><a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'><?php bloginfo( 'name' ); ?></a></h1>
                  <h2 class='site-description'><?php bloginfo( 'description' ); ?></h2>
                </hgroup>
              <?php endif; ?>
            </div>
          </div>
          <div class="col-md-8 col-sm-10">
            <button type="button" data-target=".navbar-inf" data-toggle="collapse" class="navbar-toggle"><i class="fa fa-bars"></i></button>
            <div class="collapse navbar-collapse navbar-inf">
              <?php wp_nav_menu( array( 'theme_location' => 'header-menu', 'menu_class' => 'navbar-right list-inline' ) ); ?>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </header>
  <main>