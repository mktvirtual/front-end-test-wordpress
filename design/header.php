<!doctype html>
<html class="no-js" <?php language_attributes(); ?> >
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="theme-color" content="#f47d31">
        <title><?php if ( is_category() ) {
            echo 'Category Archive for &quot;'; single_cat_title(); echo '&quot; | '; bloginfo( 'name' );
        } elseif ( is_tag() ) {
            echo 'Tag Archive for &quot;'; single_tag_title(); echo '&quot; | '; bloginfo( 'name' );
        } elseif ( is_archive() ) {
            wp_title(''); echo ' Archive | '; bloginfo( 'name' );
        } elseif ( is_search() ) {
            echo 'Search for &quot;'.esc_html($s).'&quot; | '; bloginfo( 'name' );
        } elseif ( is_home() || is_front_page() ) {
            bloginfo( 'name' ); echo ' | '; bloginfo( 'description' );
        }  elseif ( is_404() ) {
            echo 'Error 404 Not Found | '; bloginfo( 'name' );
        } elseif ( is_single() ) {
            wp_title('');
        } else {
            echo wp_title( ' | ', 'false', 'right' ); bloginfo( 'name' );
        } ?></title>
        
        <link href='https://fonts.googleapis.com/css?family=Alegreya+Sans' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
        
        <?php wp_head(); ?>
    </head>
    
    <header>
      <div class="contain-to-grid sticky show-for-small-only">
        <nav class="top-bar" data-topbar role="navigation">
          <ul class="title-area">
            <li class="name">
              <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/img/logo-mobile.png" alt=""></a></h1>
            </li>

            <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
            <section class="top-bar-section">
              <ul class="right">
                <?php wp_nav_menu( array( 'theme_location' => 'menu-banner' ) ); ?>  
              </ul>
            </section>
          </ul>
        </nav>
      </div>
    
      <div class="barra-topo">
        <div class="row">
          <div class="column campo-laranja right large-4 hide-for-medium-only">
            <form>
              <div class="row">
                <div class="small-9 columns">
                  <div class="row">
                    <input type="text" placeholder="Busca">
                  </div>
                </div>

                <div class="small-3 columns">
                  <a href="#">l</a>
                </div>
              </div>          
            </form>
          </div>

          <div class="column right medium-12 large-7 hide-for-small-only">
            <div class="row">
              <!-- Menu sobre o banner -->
              <?php wp_nav_menu( array( 'theme_location' => 'barra-topo' ) ); ?>  
            </div>
          </div>          
        </div>

        <div class="row hide-for-small-only">
          <div class="column left medium-3">
            <img class="banner-logo" src="<?php bloginfo('stylesheet_directory'); ?>/img/logo.png" alt="">
          </div>

          <div class="column right medium-9">
            <!-- Menu sobre o banner -->
            <?php wp_nav_menu( array( 'theme_location' => 'menu-banner' ) ); ?>
          </div>
        </div> 
      </div>     
    </header>

        
    

  
