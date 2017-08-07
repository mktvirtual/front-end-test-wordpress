<?php
if ( ! class_exists( 'CZR_controller_header' ) ) :
  class CZR_controller_header extends CZR_controllers {
    static $instance;

    function czr_fn_display_view_head() {
      return true;
    }

    function czr_fn_display_view_topbar_wrapper() {
      return 1 == esc_attr( czr_fn_opt( 'tc_header_desktop_topbar' ) );
    }

    function czr_fn_display_view_topbar_social_block() {
      return czr_fn_has_social_links() && 1 == esc_attr( czr_fn_opt( 'tc_social_in_header' ) );
    }


    function czr_fn_display_view_branding_tagline() {
      return  '' != get_bloginfo( 'description' ) && in_array( esc_attr( czr_fn_opt( 'tc_header_desktop_tagline' ) ), array( 'brand_below', 'brand_next' ) );
    }

    function czr_fn_display_view_topbar_tagline() {
      return '' != get_bloginfo( 'description' ) && 'topbar' == esc_attr( czr_fn_opt( 'tc_header_desktop_tagline' ) );
    }

    function czr_fn_display_view_mobile_tagline() {
      return  '' != get_bloginfo( 'description' ) && 1 == esc_attr( czr_fn_opt( 'tc_header_mobile_tagline' ) );
    }



    function czr_fn_display_view_title() {
      return ! $this -> czr_fn_display_view_logo_wrapper();
    }


    function czr_fn_display_view_logo_wrapper() {
      //display the logo wrapper
      return $this -> czr_fn_display_view_logo();
    }


    function czr_fn_display_view_logo() {
      $_logo_atts = czr_fn_get_logo_atts();
      return ! empty( $_logo_atts );
    }



    //when the 'main' navbar menu is allowed?
    //1) menu allowed
    //and
    //2) menu type is not aside (sidenav)
    function czr_fn_display_view_navbar_primary_menu() {
      return $this -> czr_fn_display_view_menu() && 'aside' != esc_attr( czr_fn_opt( 'tc_menu_style' ) ) && ( has_nav_menu( 'main' ) || czr_fn_isprevdem() );;
    }

    //when the 'secondary' navbar menu is allowed?
    //1) menu allowed
    //and
    //2) menu type is aside (sidenav)
    function czr_fn_display_view_navbar_secondary_menu() {
      return $this -> czr_fn_display_view_menu() && czr_fn_is_secondary_menu_enabled();
    }

    //when the top navbar menu is allowed?
    //1) menu allowed
    //and
    //2) topbar is displayed
    function czr_fn_display_view_topbar_menu() {
      return $this -> czr_fn_display_view_menu() && esc_attr( czr_fn_opt( 'tc_header_desktop_topbar' ) );
    }

    //when the sidenav menu is allowed?
    //1) menu allowed
    //and
    //2) menu style is aside
    function czr_fn_display_view_sidenav() {
      return $this -> czr_fn_display_view_menu() && 'aside' == esc_attr( czr_fn_opt( 'tc_menu_style' ) ) && has_nav_menu( 'main' );
    }

    function czr_fn_display_view_menu() {
      return ! czr_fn_opt('tc_hide_all_menus');
    }

    //when the 'sidevan menu button' is allowed?
    //1) menu button allowed
    //2) menu style is aside ( sidenav)
    //==
    //czr_fn_display_view_sidenav
    function czr_fn_display_view_sidenav_menu_button() {
      return $this -> czr_fn_display_view_sidenav();
    }
    function czr_fn_display_view_sidenav_navbar_menu_button() {
      return $this -> czr_fn_display_view_sidenav();
    }

    //when the 'mobile menu button' is allowed?
    //1) menu button allowed
    // or
    //2) mobile search allowed
    function czr_fn_display_view_mobile_menu_button() {
      return $this -> czr_fn_display_view_menu() || $this -> czr_fn_display_view_mobile_search();
    }

    //when the 'menu button' is allowed?
    //1) menu allowed
    function czr_fn_display_view_menu_button() {
      return $this -> czr_fn_display_view_menu();
    }



    /* Header wc cart */
    function czr_fn_display_view_desktop_primary_wc_cart() {
      //in plugins compat we use this hook to enable wc cart options when WooCommerce is enabled
      if ( ! apply_filters( 'tc_woocommerce_options_enabled', false )  )
        return false;

      return 'navbar' == czr_fn_opt( 'tc_header_desktop_wc_cart' );
    }


    function czr_fn_display_view_desktop_topbar_wc_cart() {
      //in plugins compat we use this hook to enable wc cart options when WooCommerce is enabled
      if ( ! apply_filters( 'tc_woocommerce_options_enabled', false )  )
        return false;

      return 'topbar' == czr_fn_opt( 'tc_header_desktop_wc_cart' );
    }

    function czr_fn_display_view_mobile_wc_cart() {
      //in plugins compat we use this hook to enable wc cart options when WooCommerce is enabled
      if ( ! apply_filters( 'tc_woocommerce_options_enabled', false )  )
        return false;

      return czr_fn_opt( 'tc_header_mobile_wc_cart' );
    }


    /* Header search */
    function czr_fn_display_view_desktop_primary_search()  {
      return 'navbar' == czr_fn_opt( 'tc_header_desktop_search' );
    }


    function czr_fn_display_view_desktop_topbar_search()  {
      return 'topbar' == czr_fn_opt( 'tc_header_desktop_search' );
    }


    function czr_fn_display_view_mobile_search()  {
      return czr_fn_opt( 'tc_header_mobile_search' );
    }


    /*
    * Display primary_nav_utils only if one of the below are possible
    * - primary nav search in desktops
    * - primary woocommerce cart in desktops
    * - sidenav menut button in the primary navbar
    */
    function czr_fn_display_view_primary_nav_utils() {
      return $this->czr_fn_display_view_desktop_primary_search() || $this->czr_fn_display_view_desktop_primary_wc_cart() || $this->czr_fn_display_view_sidenav_navbar_menu_button();
    }

    /*
    * Display primary_nav_utils only if one of the below are possible
    * - primary nav search in desktops
    * - primary woocommerce cart in desktops
    * -
    */
    function czr_fn_display_view_topbar_nav_utils() {
      return $this->czr_fn_display_view_desktop_topbar_search() || $this->czr_fn_display_view_desktop_topbar_wc_cart() ;
    }

  }//end of class
endif;