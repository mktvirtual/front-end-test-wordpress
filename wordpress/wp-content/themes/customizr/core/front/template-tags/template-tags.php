<?php
/**
 * Custom template tags for Customizr
 *
 *
 * @package Customizr
 */

if ( ! function_exists( 'czr_fn_carousel_nav' ) ) :
/* The template display the carousel nav */

function czr_fn_carousel_nav() {
      ?>
      <div class="czr-carousel-nav">
        <span class="czr-carousel-control btn btn-skin-dark-shaded inverted czr-carousel-prev icn-left-open-big" tabindex="0"></span>
        <span class="czr-carousel-control btn btn-skin-dark-shaded inverted czr-carousel-next icn-right-open-big" tabindex="0"></span>
      </div>
      <?php
}
endif;



if ( ! function_exists( 'czr_fn_comment_info' ) ) :

/* The template display the comment info */
function czr_fn_comment_info( $args = array() ) {


      $_allow_comment_info = (bool) esc_attr( czr_fn_opt( 'tc_comment_show_bubble' ) ) && (bool) esc_attr( czr_fn_opt( 'tc_show_comment_list' ) );

      if ( ! $_allow_comment_info )
            return;


      $defaults = array(
        'before' => '',
        'after'  => '',
        'echo'   => true
      );

      extract( wp_parse_args( $args, $defaults) );


      $comments_number = get_comments_number();

      if ( ! ( $comments_number > 0 && czr_fn_is_possible( 'comment_list' ) &&
              in_array( get_post_type(), apply_filters('czr_show_comment_infos_for_post_types' , array( 'post' , 'page') ) ) ) )
            return;

      $link            = sprintf( "%s%s",
            is_singular() ? '' : esc_url( get_permalink() ),
            //Filter hook used by disqus plugin
            apply_filters( 'czr_comment_info_anchor', '#czr-comments-title')
      );

      //Filter hook used by disqus plugin
      $link_attributes = implode( '', apply_filters( 'czr_comment_info_link_attributes', array() ) );

      $link            = sprintf( '%1$s<a class="comments__link" href="%2$s" title="%3$s" %5$s><span>%4$s</span></a>%6$s',
            $before,
            $link,
            sprintf( "%s %s %s" , number_format_i18n( $comments_number ) , _n( 'Comment on' , 'Comments on' , $comments_number, 'customizr' ) ,  esc_attr( strip_tags( get_the_title() ) ) ),
            sprintf( "%s %s" , number_format_i18n( $comments_number ) , _n( 'comment' , 'comments' , $comments_number, 'customizr' ) ),
            $link_attributes,
            $after
      );

      if ( !$echo )
            return $link;

      echo $link;

}
endif;



if ( ! function_exists( 'czr_fn_post_action' ) ) :

/**
 * The template for displaying the post action button
 * generally shown on thumb hover, will open the lightbox
 */
function czr_fn_post_action( $link, $link_class = '', $link_attr = '', $echo = true ) {

      if ( !$link )
            return;

      $icon        = 'icn-expand';
      $class       = $link_class ? $link_class . ' ' . $icon : $icon;
      $link_attr   = $link_attr ? " {$link_attr}" : '';

      $post_action = sprintf( '<div class="post-action btn btn-skin-dark-shaded inverted"><a href="%1$s" class="%2$s"%3$s></a></div>',
        esc_url( $link ),
        esc_attr( $class ),
        $link_attr
      );


      if ( !$echo )
            return $post_action;

      echo $post_action;
}
endif;



if ( ! function_exists( 'czr_fn_readmore_button' ) ) :
/**
 * The template for displaying the read more button
 * generally appended to the excerpt_more
 *
 */
function czr_fn_readmore_button( $args = array() ) {
      $defaults = array(
            'class' => '',
            'link'  => get_permalink(),
            'title' => the_title_attribute( array( 'before' => __('Permalink to:&nbsp;', 'customizr'), 'echo' => false ) ),
            'text'  => __('Read more &raquo;', 'customizr' ),
            'echo'  => false,
      );

      $args             = wp_parse_args( $args, $defaults );

      $args[ 'class' ]  = $args[ 'class' ] ? $args[ 'class' ] . ' readmore-holder' : 'readmore-holder';

      $readmore_button = sprintf( '<span class="%1$s"><a class="moretag btn btn-more btn-skin-dark" href="%2$s" title="%3$s">%4$s</a></span>',
            esc_attr( $args[ 'class' ] ),
            esc_url( $args[ 'link' ] ),
            esc_attr( $args[ 'title' ] ),
            $args[ 'text' ]
      );

      if ( !$args[ 'echo' ] )
        return $readmore_button;

      echo $readmore_button;

}
endif;



if ( ! function_exists( 'czr_fn_edit_button' ) ) :
/**
 * The template for displaying the edit button
 * Used everywhere from the slider to the posts to the comment
 *
 */
function czr_fn_edit_button( $args = array() ) {
      /*
      * No edit buttons if user is not logged in or is customizing
      * Other conditions are checked by the caller
      */
      if ( !is_user_logged_in() || czr_fn_is_customizing() )
        return;

      $defaults = array(
        'class'     => '',
        'title'     => __( 'Edit', 'customizr' ),
        'text'      => __( 'Edit', 'customizr' ),
        'link'      => '#',
        'target'    => '_blank',
        'rel'       => 'nofollow',
        'echo'      => true
      );

      $args             = wp_parse_args( $args, $defaults );

      $args[ 'class' ]  = $args[ 'class' ] ? $args[ 'class' ] . ' btn btn-edit' : 'btn btn-edit';

      $edit_button      = sprintf( '<a class="%1$s" title="%2$s" href="%3$s" target="%4$s" rel="%5$s"><i class="icn-edit"></i>%6$s</a>',
          esc_attr( $args[ 'class' ] ),
          esc_attr( $args[ 'title' ] ),
          esc_url( $args[ 'link' ] ),
          esc_attr( $args[ 'target' ] ),
          esc_attr( $args[ 'rel' ] ),
          $args[ 'text' ]
      );

      if ( !$args[ 'echo' ] )
        return $edit_button;

      echo $edit_button;

}
endif;

if ( ! function_exists( 'czr_fn_add_menu_button' ) ) :
/**
 * The template for displaying the add menu button
 */
function czr_fn_add_menu_button() {
    /*
    * user can edit menu && no visibile menu location is assigned
    */
    if ( current_user_can( 'edit_theme_options' ) && !czr_fn_is_there_any_visible_menu_location_assigned() ) {
        czr_fn_edit_button(
            array(
              'class' => 'add-menu-button',
              'link'  => czr_fn_get_customizer_url( array( 'panel' => 'nav_menus' ) ),
              'text'  => __( 'Add a menu', 'customizr' ),
              'title' => __( 'open the customizer menu section', 'customizr'),
            )
        );
    }
}
endif;

if ( ! function_exists( 'czr_fn_link_pages' ) ) :
/**
 * The template for displaying the edit button
 * Used everywhere from the slider to the posts to the comment
 *
 */
function czr_fn_link_pages( $echo = true ) {

      wp_link_pages( array(
            'before'        => '<div class="post-pagination pagination row"><div class="col-md-12"><ul class="pag-list">',
            'after'         => '</ul></div></div>',
            'link_before'   => '<span>',
            'link_after'    => '</span>',
            'echo'          => $echo
      ));
}

endif;

/* Draft */
if ( ! function_exists( 'czr_post_format_part' ) ) :
/**
 * The template for displaying the edit button
 * Used everywhere from the slider to the posts to the comment
 *
 */
function czr_post_format_part( $post_format = null ) {

      $post_format = is_null( $post_format ) ? get_post_format() : $post_format;

      if ( in_array( $post_format, array( 'quote', 'link' ) ) ) {
        czr_fn_render_template( "content/common/text/{$post_format}" );
      }
      elseif ( in_array( $post_format, array( 'audio', 'video' ) ) ) {
        //reponsive video?
        $args = 'video' == $post_format ? array(
          'model_args' => array(
            'element_class' => 'czr__r-w16by9' //responsive
          )
        ) : array();

        czr_fn_render_template( "content/common/media/{$post_format}", $args );
      }
}

endif;
