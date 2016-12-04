<div class="nav-top">
  <div class="flex-container container">
    <ul class="navtop-list hidden-mobile">
      <li class="item"><a href="#" class="item-link">Peça seu cartão cliente</li></a>
      <li class="item"><a href="#" class="item-link">Solicite segunda via de boleto</li></a>
      <li class="item"><a href="#" class="item-link">Encontre uma loja</li></a>
      <li class="item"><a href="#" class="item-link">Assine a newsletter</li></a>
    </ul>

    <form role='search' method="get" action="" class="search search-form search-desktop hidden-mobile">
      <fieldset class="wrapper">
        <input class='search-input' type="text" placeholder="Buscar" title="" value="<?php echo get_search_query() ?>" name="s">
        <button type="submit" class="search-button"><i class="fa fa-search icon" aria-hidden="true"></i></button>
      </fieldset>
    </form>
  </div>
</div>

<form role='search' method="get" action="" class="search search-mobile search-form hidden-desktop">
  <fieldset class="wrapper">
    <a href="javascript:void(0);" class="btn-Search-close"><i class="fa fa-close" aria-hidden="true"></i></a>
    <input class='search-input' type="text" placeholder="Buscar" title="" value="<?php echo get_search_query() ?>" name="s">
    <button type="submit" class="search-button"><i class="fa fa-search icon" aria-hidden="true"></i></button>
  </fieldset>
</form>
<header class="header">
  <div class="container flex-container">
    <div class="logo">
      <img class="logo-image" src="<?php echo get_template_directory_uri(); ?>/public/images/logo.png" alt="logo">
    </div>
    <div class="hidden-desktop">
      <div class="search-anchor">
        <i class="fa fa-search" aria-hidden="true"></i>
      </div>
      <div class="menu-anchor">
        <i class="fa fa-bars" aria-hidden="true"></i>
      </div>
    </div>
    <nav id="site-navigation" class="main-navigation menu" role="navigation">
      <ul class="navtop-list hidden-desktop">
        <li class="service-menu">
          <a href="#" class="anchor-dropdown item-link">Serviços <i class="fa fa-chevron-right icon" aria-hidden="true"></i></a>
          <ul class="menu-drop">
            <div class="service-menu-header-dropdown">
              <li class="item">
                <a href="#" class="anchor-dropdown-back item-link"><i class="fa fa-chevron-left" aria-hidden="true"></i> Serviços</a></li>
            </div>
            <li class="item"><a href="#" class="item-link">Peça seu cartão cliente</li></a>
            <li class="item"><a href="#" class="item-link">Solicite segunda via de boleto</li></a>
            <li class="item"><a href="#" class="item-link">Encontre uma loja</li></a>
            <li class="item"><a href="#" class="item-link">Assine a newsletter</li></a>
          </ul>
        </li>
      </ul>


      <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'menu-list' ) ); ?>
    </nav>
  </div>
</header>
