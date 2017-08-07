<?php
/**
* Loads front end fonts
*
*
* @package      Customizr
*/
if ( ! class_exists( 'CZR_resources_fonts' ) ) :
  class CZR_resources_fonts {

        //Access any method or var of the class with classname::$instance -> var or method():
        static $instance;

        function __construct () {

              self::$instance =& $this;
              add_action( 'wp_enqueue_scripts'            , array( $this , 'czr_fn_enqueue_gfonts' ), 0 );

              //Font awesome before other theme styles
              add_action( 'wp_enqueue_scripts'            , array( $this , 'czr_fn_maybe_enqueue_fa_icons'), 9 );

              add_filter( 'czr_user_options_style'        , array( $this , 'czr_fn_write_fonts_inline_css') );

              //not ready yet
              //add_filter( 'czr_user_options_style'        , array( $this , 'czr_fn_write_dropcap_inline_css') );


        }

        /**
        * Write the font icon in the custom stylesheet at the very beginning
        * hook : wp_enqueue_scripts
        * @package Customizr
        * @since Customizr 3.2.3
        */
        function czr_fn_maybe_enqueue_fa_icons() {
              //Enqueue FontAwesome CSS
              if ( true == czr_fn_opt( 'tc_font_awesome_icons' ) ) {
                    $_path = apply_filters( 'czr_fa_css_path' , CZR_BASE_URL . CZR_ASSETS_PREFIX . 'shared/fonts/fa/css/' );
                    wp_enqueue_style( 'customizr-fa',
                          $_path . 'font-awesome.min.css',
                          array(),
                          CUSTOMIZR_VER,
                          'all'
                    );
              }
         }


    /*
    * Callback of wp_enqueue_scripts
    * @return css string
    *
    * @package Customizr
    * @since Customizr 3.2.9
    */
    function czr_fn_enqueue_gfonts() {
      $_font_pair         = esc_attr( czr_fn_opt( 'tc_fonts' ) );

      if ( ! $this -> czr_fn_is_gfont( $_font_pair , '_g_') )
        return;

      $font               = explode( '|', czr_fn_get_font( 'single' , $_font_pair ) );

      if ( ! $font )
        return;

      if ( is_array( $font ) )//case is a pair
        $font             = implode( '%7C', array_unique( $font ) );


      wp_enqueue_style(
        'czr-gfonts',
        sprintf( '//fonts.googleapis.com/css?family=%s', $font ),
        array(),
        null,
        'all'
      );
    }



    /**
    * Callback of czr_user_options_style hook
    * @return css string
    *
    * @package Customizr
    * @since Customizr 3.2.9
    */

    function czr_fn_write_fonts_inline_css( $_css = null , $_context = null ) {
      $_css               = isset($_css) ? $_css : '';
      $_font_pair         = esc_attr( czr_fn_opt( 'tc_fonts' ) );
      $_body_font_size    = esc_attr( czr_fn_opt( 'tc_body_font_size' ) );
      $_font_selectors    = CZR_init::$instance -> font_selectors;

      //create the $body and $titles vars
      extract( $_font_selectors, EXTR_OVERWRITE );

      if ( ! isset($body) || ! isset($titles) )
        return;

      //adapt the selectors in edit context => add specificity for the mce-editor
      if ( ! is_null( $_context ) ) {
        $titles = ".{$_context} .h1, .{$_context} h2, .{$_context} h3";
        $body   = "body.{$_context}";
      }

      $titles = apply_filters('czr_title_fonts_selectors' , $titles );
      $body   = apply_filters('czr_body_fonts_selectors' , $body );

      if ( '_g_sourcesanspro' != $_font_pair ) {//check if not default
        $_selector_fonts  = explode( '|', czr_fn_get_font( 'single' , $_font_pair ) );
        if ( ! is_array($_selector_fonts) )
          return $_css;

        foreach ($_selector_fonts as $_key => $_raw_font) {
          //create the $_family and $_weight vars
          extract( $this -> czr_fn_get_font_css_prop( $_raw_font , $this -> czr_fn_is_gfont( $_font_pair ) ) );

          $selector = '';

          if ( !( $_family || $_weight ) )
            continue;


          switch ($_key) {
            case 0 : //titles font
              $selector = $titles;
              break;
            case 1 : //body fond
              $selector = $body;
              break;
          }

          if ( $selector ) {
              $_css .= sprintf( "%s { %s%s }\n",
                  $selector,
                  $_family ? "font-family : {$_family};" : '',
                  $_weight  ? "font-weight : {$_weight};" : ''
              );
          }

        }
      }//end if

      /*
      * TODO: implement modular scale
      */
      if ( 15 != $_body_font_size ) {

          $_line_height = apply_filters('czr_body_line_height_ratio', 1.5 );
          if ( ! czr_fn_is_checked( 'tc_ms_respond_css' ) ) {
            //turn into rem
            $remsize      = $_body_font_size / 16;
            $remsize      = number_format( (float)$remsize, 2, '.', '');
            $_css .= "
              {$body} {
                font-size : {$remsize}rem;
                line-height : {$_line_height}em;
              }\n";
          } else {
            $emsize_medium = $_body_font_size * 0.833 / 16;//@see assets/css/front/stye-modular-scale.css
            $emsize_medium = number_format( (float)$emsize_medium, 2, '.', '');
            $emsize_large = $_body_font_size * 0.9375 / 16;
            $emsize_large = number_format( (float)$emsize_large, 2, '.', '');
            $_css .= "
              {$body} {
                font-size : {$emsize_medium}em!important;
                line-height : {$_line_height}em;
              }
              @media (min-width: 20em) and (max-width: 60em) {
                {$body} {
                  font-size: calc( {$emsize_medium}em + 0.1045 * ( ( 100vw - 20em) / 40 ))!important;
                }
              }
              @media (min-width: 60em) {
                {$body} {
                  font-size: {$emsize_large}em!important;
                }
              }\n";
          }
      }

      return $_css;
    }//end of fn


    /**
    * Helper to check if the requested font code includes the Google font identifier : _g_
    * @return bool
    *
    * @package Customizr
    * @since Customizr 3.3.2
    */
    private function czr_fn_is_gfont($_font , $_gfont_id = null ) {
      $_gfont_id = $_gfont_id ? $_gfont_id : '_g_';
      return false !== strpos( $_font , $_gfont_id );
    }


    /**
    * Callback of czr_user_options_style hook
    * @return css string
    *
    * @package Customizr
    * @since Customizr 3.2.11
    */
    function czr_fn_write_dropcap_inline_css( $_css = null , $_context = null ) {
      $_css               = isset($_css) ? $_css : '';
      if ( ! esc_attr( czr_fn_opt( 'tc_enable_dropcap' ) ) )
        return $_css;

      $_main_color_pair = czr_fn_get_skin_color( 'pair' );
      $_color           = $_main_color_pair[0];
      $_shad_color      = $_main_color_pair[1];
      $_pad_right       = false !== strpos( esc_attr( czr_fn_opt( 'tc_fonts' ) ), 'lobster' ) ? 26 : 8;
      $_css .= "
        .tc-dropcap {
          color: {$_color};
          float: left;
          font-size: 75px;
          line-height: 75px;
          padding-right: {$_pad_right}px;
          padding-left: 3px;
        }\n
        .skin-shadow .tc-dropcap {
          color: {$_color};
          text-shadow: {$_shad_color} -1px 0, {$_shad_color} 0 -1px, {$_shad_color} 0 1px, {$_shad_color} -1px -2px;
        }\n
        .simple-black .tc-dropcap {
          color: #444;
        }\n";

      return $_css;
    }





    /*************************************
    * HELPERS
    *************************************/
    /**
    * Helper to extract font-family and weight from a Customizr font option
    * @return array( font-family, weight )
    *
    * @package Customizr
    * @since Customizr 3.3.2
    */
    private function czr_fn_get_font_css_prop( $_raw_font , $is_gfont = false ) {
      $_css_exp = explode(':', $_raw_font);
      $_weight  = isset( $_css_exp[1] ) ? $_css_exp[1] : false;
      $_family  = '';

      if ( $is_gfont ) {
        $_family = str_replace('+', ' ' , $_css_exp[0]);
      } else {
        $_family = implode("','", explode(',', $_css_exp[0] ) );
      }
      $_family = sprintf("'%s'" , $_family );

      return compact("_family" , "_weight" );
    }

  }//end of CZR_resources
endif;
