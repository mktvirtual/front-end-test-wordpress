<?php
//Model id : usually 'main_content'
class CZR_main_content_model_class extends CZR_Model {
      /*
      * @override
      */
      function __construct( $model ) {

            parent::__construct( $model );

            //in singular context we might want to display the featured image for standard headings
            $this -> czr_fn_process_singular_thumbnail();


            $children = array(

                  array(

                        //registered here also because we access to its properties from other templates
                        //which as of now is only possibile with already registered models
                        'model_class' => 'content/post-metas/post_metas',
                        'id' => 'post_metas',

                  ),

                  /*********************************************
                  * SLIDER
                  *********************************************/
                  /* Need to be registered before rendering because of the custom style*/
                  array(

                        'template'    => 'modules/slider/slider',
                        'id'          => 'main_slider',
                        'hook'        => '__before_main_wrapper',
                        'priority'    => 10

                  ),
                  //slider of posts
                  array(

                        'id'          => 'main_posts_slider',
                        'model_class' => array( 'parent' => 'modules/slider/slider', 'name' => 'modules/slider/slider_of_posts' ),
                        'template'    => 'modules/slider/slider',
                        'hook'        => '__before_main_wrapper',
                        'priority'    => 10
                  ),

                  /** end slider **/

                  /*********************************************
                  * Featured Pages
                  *********************************************/
                  /* contains the featured page item registration */
                  array(
                        'id'          => 'featured_pages',
                        'template'    => 'modules/featured-pages/featured_pages',
                        'hook'        => '__before_main_container',
                        'priority'    => 10
                  ),
                  /** end featured pages **/

                  /*********************************************
                  * Breadcrumbs
                  *********************************************/
                  /* contains the featured page item registration */
                  array(
                        'id'          => 'breadcrumb',
                        'template'    => 'modules/common/breadcrumb',
                        'hook'        => '__before_main_container',
                        'priority'    => 20
                  ),
                  /** end featured pages **/


                  /* Needs to access the czr_user_options_style */
                  /*********************************************
                  * GRID (POST LIST)
                  *********************************************/
                  array(

                        'id'          => 'post_list_grid',
                        'model_class' => 'modules/grid/grid_wrapper',

                  ),
                  /* END GRID */
            );

            foreach ( $children as $id => $model ) {
              CZR() -> collection -> czr_fn_register( $model );
            }//foreach
      }



      function czr_fn_process_singular_thumbnail() {

            if ( ! is_singular() )
                  return;

            $context =  is_single() ? 'post' : 'page';

            //do nothing if we don't display regular {context} heading
            if ( ! czr_fn_is_registered_or_possible( "regular_{$context}_heading" ) )
                  return;

            //__before_main_wrapper, 200
            //__before_regular_{post|page}_heading_title
            //__after_regular_{post|page}_heading_title
            $_singular_thumb_option = czr_fn_opt( "tc_single_${context}_thumb_location" );

            //nothing to do:
            if ( ! ( $_singular_thumb_option && 'hide' != $_singular_thumb_option ) ) {

                  return;

            }

            //define old customizr compatibility map:
            $_compat_location_hook_map = array(

                  //old hook                => new_hook

                  '__before_main_wrapper'   => '__before_main_wrapper',
                  '__before_content'        => '__before_regular_heading_title',
                  '__after_content_title'   => '__after_regular_heading_title',

            );


            //process location
            $_exploded_location   = explode('|', $_singular_thumb_option );
            $_hook                = isset( $_exploded_location[0] ) ? $_exploded_location[0] : '__before_content';
            //map the old location hook to the new location hook
            $_hook                = array_key_exists( $_hook, $_compat_location_hook_map ) ? $_compat_location_hook_map[ $_hook ] : '__before_regular_heading_title';


            //let's prepare the thumb
            //register the model and the template for displaying the thumbnail at a specific hook
            $singular_thumb_model_id = czr_fn_register( array( 'template' => 'content/common/media',

                  'id'         => 'singular_thumbnail',
                  'hook'       => $_hook,
                  'args'       => array(

                        'media_type'               => 'wp_thumb',
                        'has_permalink'            => false,
                        'has_lightbox'             => false,
                        'element_class'            => 'tc-singular-thumbnail-wrapper',
                        //slider full when __before_main_wrapper otherwise take the original one
                        'thumb_size'               => '__before_main_wrapper' == $_hook ? 'slider-full' : null
                  ),
                  'priority'   => 15,
                  'controller' => 'singular_thumbnail'
            ) );

            //control the visibility
            add_filter( "czr_do_render_view_{$singular_thumb_model_id}", array( $this, 'czr_fn_display_view_singular_thumbnail' ), 100, 2 );

            //css
            //needed only when not __after_regular_heading_title?
            //if ( '__after_regular_heading_title' != $_hook ) {

            add_filter( 'czr_user_options_style'    , array( $this , 'czr_fn_write_thumbnail_inline_css') );

            //}

      }


      /*
      * Singular thumbnail stuff
      *
      * TODO : maybe create a specific model
      * slider and fi before main wrapper xor
      */

      function czr_fn_display_view_singular_thumbnail( $bool, $model ) {

        if ( !$bool )
          return;

        $_hook = isset( $model->hook ) ? $model->hook : false;

        if ( !$_hook )
          return $bool;

        $_slider_shown = ( did_action( '__after_carousel_inner' ) );

        return '__before_main_wrapper' == $_hook && $_slider_shown ? false : true;

      }


      function czr_fn_write_thumbnail_inline_css( $_css ) {
            $context =  is_single() ? 'post' : 'page';

            $_thumb_height   = apply_filters( "tc_${context}_post_thumb_height", esc_attr( czr_fn_opt( "tc_{$context}_post_thumb_height" ) ) );
            $_thumb_height   = (! $_thumb_height || ! is_numeric($_thumb_height) ) ? 250 : $_thumb_height;

            return sprintf("%s\n%s",
              $_css,
              ".tc-singular-thumbnail-wrapper .entry-media__wrapper {
                max-height: {$_thumb_height}px;
                height :{$_thumb_height}px
              }\n"
            );
      }


}