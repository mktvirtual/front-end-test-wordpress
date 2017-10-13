<?php
/**
 * Theme functions.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

/* ---------------------------------------------------------------------------
 * Theme support
 * --------------------------------------------------------------------------- */
if( false ) add_editor_style( '/css/style-editor.css' );

add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-formats', array( 'image', 'video', 'quote', 'link' ) );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'title-tag' );


/* ---------------------------------------------------------------------------
 * Add Image Size
 * 
 * TIP: add_image_size ( string $name, int $width, int $height, bool|array $crop = false )
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_add_image_size' ) )
{
	function mfn_add_image_size() {
		
		// Backend --------------------------------------------
			
			/*
			 * Featured Image
			 */
			set_post_thumbnail_size( 			260,  146,  false );
			
			/*
			 * List Thumbnail for custom post formats
			 */
			add_image_size( '50x50', 			50,   50,   false );
			
			
		// Builder Items --------------------------------------
		
			/*
			 * Clients | do NOT crop logos
			 */
			add_image_size( 'clients-slider', 	150,  75,   false );
		
			/*
			 * Slider | Muffin Builder Item
			 * 
			 * TODO: Verify proportions (? size)
			 */
			add_image_size( 'slider-content', 	1630, 860,  true );
			
			/*
			 * Testimonials
			 * 
			 * TODO: change it to 200x200
			 */
			add_image_size( 'testimonials', 	85,   85,   true );
			
			/*
			 * Sticky Navigation | Blog, Portfolio & Shop
			 * Widget: Recent Posts
			 * 
			 * TODO: connect with testimonials & change it to 200x200
			 */
			add_image_size( 'blog-navi', 		80,   80,   true );
				
			
		// Blog & Portfolio -----------------------------------	
		
			/*
			 * Portfolio | Style: Masonry flat
			 * 
			 * TODO: SIZE too big? (use cover/width 100%? ipad?)
			 */
			add_image_size( 'portfolio-mf', 	1280, 1000, true );
			add_image_size( 'portfolio-mf-w',   1280, 500,  true );	/* Wide */
			add_image_size( 'portfolio-mf-t',   768,  1200, true );	/* Tall	*/
			
			/*
			 * Portfolio | Style: List
			 * 
			 * TODO: Verify proportions (? size)
			 */
			add_image_size( 'portfolio-list', 	1920, 750,  true );
			
			
		// Blog & Portfolio | Dynamic sizes -------------------
		
			/*
			 * Blog & Portfolio | List
			 * 
			 * TODO: DEFAULT HEIGHT/PROPORTIONS - FOR VERIFICATION
			 */
			$archivesW = mfn_opts_get( 'featured-blog-portfolio-width', 960 );
			$archivesH = mfn_opts_get( 'featured-blog-portfolio-height', 750 );
			
			$archivesC = mfn_opts_get( 'featured-blog-portfolio-crop', 'crop' );
			$archivesC = ( $archivesC == 'resize' ) ? false : true;
			
			add_image_size( 'blog-portfolio', $archivesW, $archivesH, $archivesC );
			
			/*
			 * Blog & Portfolio | Single
			 * 
			 * TODO: DEFAULT HEIGHT/PROPORTIONS - FOR VERIFICATION
			 */
			$singleW = mfn_opts_get( 'featured-single-width', 1200 );
			$singleH = mfn_opts_get( 'featured-single-height', 480 );
				
			$singleC = mfn_opts_get( 'featured-single-crop', 'crop' );
			$singleC = ( $singleC == 'resize' ) ? false : true;
			
			add_image_size( 'blog-single', $singleW, $singleH, $singleC );

	}
}
add_action( 'after_setup_theme', 'mfn_add_image_size', 11 );


/* ---------------------------------------------------------------------------
 * Excerpt | Lenght
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_excerpt_length' ) )
{
	function mfn_excerpt_length( $length ) {
		return mfn_opts_get( 'excerpt-length', 26 );
	}
}
add_filter( 'excerpt_length', 'mfn_excerpt_length', 999 );


/* ---------------------------------------------------------------------------
 * Excerpt | Wrap [...] into <span>
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_trim_excerpt' ) )
{
	function mfn_trim_excerpt( $text ) {
		return '<span class="excerpt-hellip"> […]</span>';
	}
}
add_filter( 'excerpt_more', 'mfn_trim_excerpt' );


/* ---------------------------------------------------------------------------
 * Excerpt | for Pages
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_add_excerpts_to_pages' ) )
{
	function mfn_add_excerpts_to_pages() {
		add_post_type_support( 'page', 'excerpt' );
	}
}
add_action( 'init', 'mfn_add_excerpts_to_pages' );


/* ---------------------------------------------------------------------------
 * Slug | Generate
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_slug' ) )
{
	function mfn_slug( $string = false ){
    	return strtolower( trim ( preg_replace( '/[^A-Za-z0-9-]+/', '-', $string ) ) );
	}
}


/* ---------------------------------------------------------------------------
 * Blog Page | Exclude category
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_exclude_category' ) )
{
	function mfn_exclude_category($query) {
		
		if( $exclude = trim( mfn_opts_get( 'exclude-category' ) ) ){
			if( is_home() ){

				$exclude = str_replace( ' ', '', $exclude );
				$exclude = explode( ',', $exclude );
				
				$exclude_ids = array();
				
				if( is_array( $exclude ) ){
					foreach( $exclude as $slug ){
						$category = get_category_by_slug( $slug );
						$exclude_ids[] = $category->term_id * -1;
					}
				}

				$exclude_ids = implode( ',', $exclude_ids );
				
				$query->set( 'cat', $exclude_ids );
			}
		}
		
		return $query;
	}
}
add_filter('pre_get_posts', 'mfn_exclude_category');


/* ---------------------------------------------------------------------------
 * SSL | Compatibility
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_ssl' ) )
{
	function mfn_ssl( $echo = false ){
		$ssl = '';
		if( is_ssl() ) $ssl = 's';
		if( $echo ){
			echo $ssl;
		}
		return $ssl;
	}
}


/* ---------------------------------------------------------------------------
 * SSL | Attachments
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_ssl_attachments' ) )
{
	function mfn_ssl_attachments( $url ){
		if( is_ssl() ){
			return str_replace( 'http://', 'https://', $url );
		}
		return $url;
	}
}
add_filter( 'wp_get_attachment_url', 'mfn_ssl_attachments' );


/* ---------------------------------------------------------------------------
 * White Label | Admin Body Class
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_white_label_class' ) )
{
	function mfn_white_label_class( $classes ){
		if( WHITE_LABEL ) $classes .= 'white-label';
		return $classes;
	}
}
add_filter( 'admin_body_class', 'mfn_white_label_class' );


/* ---------------------------------------------------------------------------
 * Get Real Post ID
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_ID' ) )
{
	function mfn_ID(){
		global $post;
		$postID = false;
	
		if( ! is_404() ){
			
			if( function_exists( 'is_woocommerce' ) && is_woocommerce() ){
				
				// WooCommerce
				
				// WC < 2.7 backward compatibility
				if( version_compare( WC_VERSION, '2.7', '<' ) ){
					$postID = woocommerce_get_page_id( 'shop' );
				} else {
					$postID = wc_get_page_id( 'shop' );
				}
				
			} elseif( is_search() ){
				
				$postID = false;
			
			} elseif( is_tax() ){
				
				// taxonomy-portfolio-types.php
				$postID = mfn_opts_get( 'portfolio-page' );
				
			} elseif( in_array( get_post_type(), array( 'post', 'tribe_events' ) ) && ! is_singular() ){
				
				// index.php
				if( get_option( 'page_for_posts' ) ){
					
					// Setings / Reading
					$postID = get_option( 'page_for_posts' );	
					
				} elseif( mfn_opts_get( 'blog-page' ) ){
					
					// Theme Options / Getting Started / Blog
					$postID = mfn_wpml_ID( mfn_opts_get( 'blog-page' ) );
							
				}
				
			} else {
				
				// default
				$postID = get_the_ID();
				
			}
		}
	
		return $postID;
	}
}


/* ---------------------------------------------------------------------------
 * Get Layout ID
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_layout_ID' ) )
{
	function mfn_layout_ID(){

		$layoutID = false;
		
		if( mfn_ID() ){
			
			if( is_single() && get_post_type() == 'post' ){
				
				// Theme Options | Single Post
				$layoutID = mfn_opts_get( 'blog-single-layout' );
				
			} elseif( is_single() && get_post_type() == 'portfolio' ) {
	
				if( get_post_meta( mfn_ID(), 'mfn-post-custom-layout', true ) ){
					
					// Page Options | Single Portfolio
					$layoutID = get_post_meta( mfn_ID(), 'mfn-post-custom-layout', true );
					
				} else {
					
					// Theme Options | Single Portfolio
					$layoutID = mfn_opts_get( 'portfolio-single-layout' );
					
				}
				
			} else {
				
				// Page Options | Page
				$layoutID = get_post_meta( mfn_ID(), 'mfn-post-custom-layout', true );
				
			}
			
		}

		return $layoutID;
	}
}


/* ---------------------------------------------------------------------------
 * Slider | Isset
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_slider_isset' ) )
{
	function mfn_slider_isset( $id = false ){
		
		$slider = false;
				
		// Global Slider Shortcode
		if( is_page() && mfn_opts_get( 'slider-shortcode' ) ){
			return 'global';
		}
		
		if( $id || is_home() || is_category() || is_tax() || get_post_type() == 'page' || ( get_post_type( mfn_ID() ) == 'portfolio' && get_post_meta( mfn_ID(), 'mfn-post-slider-header', true ) ) ){
				
			if( ! $id ) $id = mfn_ID(); // do NOT move it before IF
			
			if( get_post_meta( $id, 'mfn-post-slider', true ) ){
				
				// Revolution Slider
				$slider = 'rev';
				
			} elseif( get_post_meta( $id, 'mfn-post-slider-layer', true ) ) {
				
				// Layer Slider
				$slider = 'layer';
				
			} elseif( get_post_meta( $id, 'mfn-post-slider-shortcode', true ) ) {
				
				// Custom Slider
				$slider = 'custom';
				
			}
			
		}

		return $slider;
	}
}


/* ---------------------------------------------------------------------------
 * Slider | Get
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_slider' ) )
{
	function mfn_slider( $id = false ){
		
		$slider = false;
		$slider_type = mfn_slider_isset( $id );
		
		if( ! $id ) $id = mfn_ID(); // do NOT move it before IF
		
		switch ($slider_type) {
			
			case 'global':
		        $slider = '<div class="mfn-main-slider" id="mfn-global-slider">';
					$slider .= do_shortcode( mfn_opts_get('slider-shortcode') );
				$slider .= '</div>';
		        break;
		        
			case 'rev':
		        $slider = '<div class="mfn-main-slider" id="mfn-rev-slider">';
					$slider .= do_shortcode('[rev_slider '. get_post_meta( $id, 'mfn-post-slider', true ) .']');
				$slider .= '</div>';
		        break;
		        
			case 'layer':
		        $slider = '<div class="mfn-main-slider" id="mfn-layer-slider">';
					$slider .= do_shortcode('[layerslider id="'. get_post_meta( $id, 'mfn-post-slider-layer', true ) .'"]');
				$slider .= '</div>';
		        break;
		        
			case 'custom':
		        $slider = '<div class="mfn-main-slider" id="mfn-custom-slider">';
					$slider .= do_shortcode( get_post_meta( $id, 'mfn-post-slider-shortcode', true ) );
				$slider .= '</div>';
		        break;
		        
		}
		
		return $slider;
	}
}


/* ---------------------------------------------------------------------------
 * WP Mobile Detect | Quick FIX: parallax on mobile
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_is_mobile' ) )
{
	function mfn_is_mobile(){

		$mobile = wp_is_mobile();

		if( mfn_opts_get( 'responsive-parallax' ) ){
			$mobile = false;
		}

		return $mobile;
	}
}


/* ---------------------------------------------------------------------------
 * User OS
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_user_os' ) )
{
	function mfn_user_os(){
		
		$os = false;
		$user_agent = $_SERVER['HTTP_USER_AGENT'];

		if( strpos( $user_agent, 'iPad;' ) || strpos( $user_agent, 'iPhone;' ) ){
			$os = ' ios';
		}

		return $os;
	}
}


/* ---------------------------------------------------------------------------
 * User Agent | For: Prallax - Safari detect & future use
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_user_agent' ) )
{
	function mfn_user_agent(){

		$user_agent = $_SERVER['HTTP_USER_AGENT'];

		if( stripos( $user_agent, 'Chrome/') !== false ){
				
			$user_agent = 'chrome';

		} elseif( ( stripos( $user_agent, 'Safari/') !== false ) && ( stripos( $user_agent, 'Mobile/') !== false ) ){
				
			$user_agent = 'safari mobile';
			
		} elseif( stripos( $user_agent, 'Safari/') !== false ){
				
			$user_agent = 'safari';
			 
		} else {
				
			// for future use
			$user_agent = false;
				
		}

		return $user_agent;
	}
}


/* ---------------------------------------------------------------------------
 * Paralllax | Plugin
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_parallax_plugin' ) )
{
	function mfn_parallax_plugin(){

		$parallax = mfn_opts_get( 'parallax' );

		if( $parallax == 'translate3d no-safari' ){
			if( mfn_user_agent() == 'safari' ){
				$parallax = 'enllax';
			} else {
				$parallax = 'translate3d';
			}		
		}

		return $parallax;
	}
}


/* ---------------------------------------------------------------------------
 * Paralllax | Code - Section & wrapper background
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_parallax_data' ) )
{
	function mfn_parallax_data(){
		
		$parallax = mfn_parallax_plugin();
		
		if( $parallax == 'translate3d' ){
			
			$parallax = 'data-parallax="3d"';
			
		} elseif( $parallax == 'stellar' ){
			
			$parallax = 'data-stellar-background-ratio="0.5"';
			
		} else {
			
			$parallax = 'data-enllax-ratio="-0.3"';
		}
				
		return $parallax;
	}
}


/* ---------------------------------------------------------------------------
 * Pagination for Blog and Portfolio
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_pagination' ) )
{
	function mfn_pagination( $query = false, $load_more = false ){
		global $wp_query;	
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );
	
		// default $wp_query
		if( ! $query ) $query = $wp_query;
		
		$translate['prev'] = mfn_opts_get('translate') ? mfn_opts_get('translate-prev','&lsaquo; Prev page') : __('Prev page','betheme');
		$translate['next'] = mfn_opts_get('translate') ? mfn_opts_get('translate-next','Next page &rsaquo;') : __('Next page','betheme');
		$translate['load-more'] = mfn_opts_get('translate') ? mfn_opts_get('translate-load-more','Load more') : __('Load more','betheme');
		
		$query->query_vars['paged'] > 1 ? $current = $query->query_vars['paged'] : $current = 1;  
		
		if( empty( $paged ) ) $paged = 1;
		$prev = $paged - 1;							
		$next = $paged + 1;
		
		$end_size = 1;
		$mid_size = 2;
		$show_all = mfn_opts_get('pagination-show-all');
		$dots = false;
	
		if( ! $total = $query->max_num_pages ) $total = 1;
		
		$output = '';
		if( $total > 1 )
		{
			if( $load_more ){
				// ajax load more -------------------------------------------------
				
				if( $paged < $total ){
					$output .= '<div class="column one pager_wrapper pager_lm">';
						$output .= '<a class="pager_load_more button button_js" href="'. get_pagenum_link( $next ) .'">';
							$output .= '<span class="button_icon"><i class="icon-layout"></i></span>';
							$output .= '<span class="button_label">'. $translate['load-more'] .'</span>';
						$output .= '</a>';
					$output .= '</div>';
				}
				
			} else {
				// default --------------------------------------------------------	
				
				$output .= '<div class="column one pager_wrapper">';
					$output .= '<div class="pager">';
						
						if( $paged >1 ){
							$output .= '<a class="prev_page" href="'. get_pagenum_link( $prev ) .'"><i class="icon-left-open"></i>'. $translate['prev'] .'</a>';
						}
				
						$output .= '<div class="pages">';
							for( $i=1; $i <= $total; $i++ ){
								if ( $i == $current ){
									$output .= '<a href="'. get_pagenum_link($i) .'" class="page active">'. $i .'</a>';
									$dots = true;
								} else {
									if ( $show_all || ( $i <= $end_size || ( $current && $i >= $current - $mid_size && $i <= $current + $mid_size ) || $i > $total - $end_size ) ){
										$output .= '<a href="'. get_pagenum_link($i) .'" class="page">'. $i .'</a>';
										$dots = true;
									} elseif ( $dots && ! $show_all ) {
										$output .= '<span class="page">...</span>';
										$dots = false;
									}
								}
							}
						$output .= '</div>';
						
						if( $paged < $total ){
							$output .= '<a class="next_page" href="'. get_pagenum_link( $next ) .'">'. $translate['next'] .'<i class="icon-right-open"></i></a>';
						}
						
					$output .= '</div>';
				$output .= '</div>'."\n";
				
			}
		}
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * No sidebar message for templates with sidebar 
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_nosidebar' ) )
{
	function mfn_nosidebar(){
		echo 'This template supports the sidebar\'s widgets. <a href="'. home_url() .'/wp-admin/widgets.php">Add one</a> or use Full Width layout.';	
	}
}


/* ---------------------------------------------------------------------------
 * New Walker Category for categories menu
 * --------------------------------------------------------------------------- */
if( ! class_exists( 'New_Walker_Category' ) )
{
	class New_Walker_Category extends Walker_Category {
		function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
			extract($args);
	
			$cat_name = esc_attr( $category->name );
			$cat_name = apply_filters( 'list_cats', $cat_name, $category );
			
			$link = '<a href="' . esc_attr( get_term_link($category) ) . '" ';
			if ( $use_desc_for_title == 0 || empty($category->description) )
				$link .= 'title="' . esc_attr( sprintf(__('View all posts filed under %s','betheme'), $cat_name) ) . '"';
			else
				$link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
			$link .= '>';
			$link .= $cat_name;
	
			if ( !empty($show_count) )
				$link .= ' <span>(' . intval($category->count) . ')</span>';
				
			$link .= '</a>';
	
			if ( 'list' == $args['style'] ) {
				$output .= "\t<li";
				$class = 'cat-item cat-item-' . $category->term_id;
				if ( !empty($current_category) ) {
					$_current_category = get_term( $current_category, $category->taxonomy );
					if ( $category->term_id == $current_category )
						$class .=  ' current-cat';
					elseif ( $category->term_id == $_current_category->parent )
						$class .=  ' current-cat-parent';
				}
				$output .=  ' class="' . $class . '"';
				$output .= ">$link\n";
			} else {
				$output .= "\t$link\n";
			}
		}
	}
}


/* ---------------------------------------------------------------------------
 * Current page URL
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'curPageURL' ) )
{
	function curPageURL(){
		$pageURL = 'http';
		if( is_ssl() ) $pageURL .= "s";
		$pageURL .= "://";
		if( $_SERVER["SERVER_PORT"] != "80" ) {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	 }
	 return $pageURL;
	}
}


/* ---------------------------------------------------------------------------
 * Subheader | Page Title
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_page_title' ) )
{
	function mfn_page_title( $echo = false ){
		
		if( is_home() ){
			
			// Blog ---------------------------------------
			$title = get_the_title( mfn_ID() );
			
		} elseif( function_exists( 'tribe_is_month' ) && ( tribe_is_event_query() || tribe_is_month() || tribe_is_event() || tribe_is_day() || tribe_is_venue() ) ){
			
			// The Events Calendar ------------------------
			$title = tribe_get_events_title();
			
		} elseif( is_tag() ){
			
			// Blog | Tag ---------------------------------
			$title = single_tag_title('', false);
			
		} elseif( is_category() ){
			
			// Blog | Category ----------------------------
			$title = single_cat_title('', false);
			
		} elseif( is_author() ){
			
			// Blog | Author ------------------------------
			$title = get_the_author();
		
		} elseif( is_day() ){
		
			// Blog | Day ---------------------------------
			$title = get_the_time('d');
		
		} elseif( is_month() ){
		
			// Blog | Month -------------------------------
			$title = get_the_time('F');

		} elseif( is_year() ){
		
			// Blog | Year --------------------------------
			$title = get_the_time('Y');
			
		} elseif( is_single() || is_page() ){
			
			// Single -------------------------------------
			$title = get_the_title( mfn_ID() );
			
		} elseif( get_post_taxonomies() ){
			
			// Taxonomy -----------------------------------
			$title = single_cat_title('', false);
			
		} else {
			
			// Default ------------------------------------
			$title = get_the_title( mfn_ID() );		
		}
		
		if( $echo ) echo $title;
		return $title;
	}
}


/* ---------------------------------------------------------------------------
 * Breadcrumbs
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_breadcrumbs' ) )
{
	function mfn_breadcrumbs( $class = false ){
		global $post;
		
		$translate['home'] 			= mfn_opts_get('translate') ? mfn_opts_get('translate-home','Home') : __('Home','betheme');
		
		$homeLink = home_url();
		$separator = ' <span><i class="icon-right-open"></i></span>';
		
		
		// Plugin | bbPress -----------------------------------
		if( function_exists('is_bbpress') && is_bbpress() ){
			bbp_breadcrumb( array(
				'before' 		=> '<ul class="breadcrumbs">',
				'after' 		=> '</ul>',
				'sep' 			=> '<i class="icon-right-open"></i>',
				'crumb_before' 	=> '<li>',
				'crumb_after' 	=> '</li>',
				'home_text' 	=> $translate['home'],
			) );
			return true;
		} // end: bbPress -------------------------------------
		
	
		// Default breadcrumbs --------------------------------
		$breadcrumbs = array();
	
		// Home prefix --------------------------------
		$breadcrumbs[] =  '<a href="'. $homeLink .'">'. $translate['home'] .'</a>';
	
		// Blog -------------------------------------------
		if( get_post_type() == 'post' ){
			
			$blogID = false;
			if( get_option( 'page_for_posts' ) ){
				$blogID = get_option( 'page_for_posts' );	// Setings / Reading
			} elseif( mfn_opts_get( 'blog-page' ) ){
				$blogID = mfn_opts_get( 'blog-page' );		// Theme Options / Getting Started / Blog
			}
			
			// Blog Page has parent
			$blog_post = get_post( $blogID );
			
			if( $blog_post->post_parent ){
			
				$parent_id  = $blog_post->post_parent;
				$parents = array();
			
				while( $parent_id ) {
					$page = get_page( $parent_id );
					$parents[] = '<a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>';
					$parent_id  = $page->post_parent;
				}
				$parents = array_reverse( $parents );
				$breadcrumbs = array_merge_recursive($breadcrumbs, $parents);
			
			}
	
			if( $blogID ) $breadcrumbs[] = '<a href="'. get_permalink( $blogID ) .'">'. get_the_title( $blogID ) .'</a>';
		}
					
		if( is_front_page() || is_home() ){
			
			// do nothing

		// Plugin | Events Calendar -------------------------------------------
		} elseif( function_exists( 'tribe_is_month' ) && ( tribe_is_event_query() || tribe_is_month() || tribe_is_event() || tribe_is_day() || tribe_is_venue() ) ) {
	
			if( function_exists( 'tribe_get_events_link' ) ){
				$breadcrumbs[] = '<a href="'. tribe_get_events_link() .'">'. tribe_get_events_title() .'</a>';
			}
			
		// Blog | Tag -------------------------------------
		} elseif( is_tag() ){
			
			$breadcrumbs[] = '<a href="'. curPageURL() .'">' . single_tag_title('', false) . '</a>';
			
		// Blog | Category --------------------------------
		} elseif( is_category() ){
			
			$cat = get_term_by('name', single_cat_title('',false), 'category');
			if( $cat && $cat->parent ){
				$breadcrumbs[] = get_category_parents( $cat->parent, true, $separator );
			}
			
			$breadcrumbs[] = '<a href="'. curPageURL() .'">' . single_cat_title('', false) . '</a>';
			
		// Blog | Author ----------------------------------
		} elseif( is_author() ){
			
			$breadcrumbs[] = '<a href="'. curPageURL() .'">' . get_the_author() . '</a>';
			
		// Blog | Day -------------------------------------
		} elseif( is_day() ){
			
			$breadcrumbs[] = '<a href="'. get_year_link( get_the_time('Y') ) . '">'. get_the_time('Y') .'</a>';
			$breadcrumbs[] = '<a href="'. get_month_link( get_the_time('Y'), get_the_time('m') ) .'">'. get_the_time('F') .'</a>';
			$breadcrumbs[] = '<a href="'. curPageURL() .'">'. get_the_time('d') .'</a>';
	
		// Blog | Month -----------------------------------
		} elseif( is_month() ){
	
			$breadcrumbs[] = '<a href="' . get_year_link( get_the_time('Y') ) . '">' . get_the_time('Y') . '</a>';
			$breadcrumbs[] = '<a href="'. curPageURL() .'">'. get_the_time('F') .'</a>';
			
		// Blog | Year ------------------------------------
		} elseif( is_year() ){
	
			$breadcrumbs[] = '<a href="'. curPageURL() .'">'. get_the_time('Y') .'</a>';
			
		// Single -----------------------------------------
		} elseif( is_single() && ! is_attachment() ){
			
			// Custom Post Type -----------------
			if( get_post_type() != 'post' ){
				
				$post_type 			= get_post_type_object(get_post_type());
				$slug 				= $post_type->rewrite;
				$portfolio_page_id 	= mfn_wpml_ID( mfn_opts_get('portfolio-page') );
			
				// Portfolio Page ------------
				if( $slug['slug'] == mfn_opts_get( 'portfolio-slug', 'portfolio-item' ) && $portfolio_page_id ){
					$breadcrumbs[] = '<a href="' . get_page_link( $portfolio_page_id ) . '">'. get_the_title( $portfolio_page_id ) .'</a>';	
				}
				
				// Category ----------
				if( $portfolio_page_id ){
					
					$terms = get_the_terms( get_the_ID(), 'portfolio-types' );
					if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {	
						$term = $terms[0];
						$breadcrumbs[] = '<a href="'. get_term_link( $term ) .'">'. $term->name .'</a>';
					}
					
				}
				
				// Single Item --------
				$breadcrumbs[] = '<a href="' . curPageURL() . '">'. get_the_title().'</a>';
	
			// Blog | Single --------------------
			} else {
				
				$cat = get_the_category(); 
				if( ! empty( $cat ) ){
					$breadcrumbs[] = get_category_parents( $cat[0], true, $separator );
				}
			
				$breadcrumbs[] = '<a href="' . curPageURL() . '">'. get_the_title() .'</a>';
				
			}
			
		// Taxonomy ---------------------------------------
		} elseif( ! is_page() && get_post_taxonomies() ){
				
			// Portfolio ------------------------
			$post_type = get_post_type_object( get_post_type() );
			if( $post_type->name == 'portfolio' && $portfolio_page_id = mfn_wpml_ID( mfn_opts_get('portfolio-page') ) ) {
				$breadcrumbs[] = '<a href="' . get_page_link( $portfolio_page_id ) . '">'. get_the_title( $portfolio_page_id ) .'</a>';
			}
		
			$breadcrumbs[] = '<a href="' . curPageURL() . '">' . single_cat_title('', false) . '</a>';
			
		// Page with parent -------------------------------
		} elseif( is_page() && $post->post_parent ){
			
			$parent_id  = $post->post_parent;
			$parents = array();
				
			while( $parent_id ) {
				$page = get_page( $parent_id );
				$parents[] = '<a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>';
				$parent_id  = $page->post_parent;
			}
			$parents = array_reverse( $parents );
			$breadcrumbs = array_merge_recursive($breadcrumbs, $parents);
				
			$breadcrumbs[] = '<a href="' . curPageURL() . '">'. get_the_title( mfn_ID() ) .'</a>';
		
		// Default ----------------------------------------
		} else {
			
			$breadcrumbs[] = '<a href="' . curPageURL() . '">'. get_the_title( mfn_ID() ) .'</a>';
			
		}
		
		
		// PRINT ------------------------------------------------------------------
		echo '<ul class="breadcrumbs '. $class .'">';
			
			$count = count( $breadcrumbs );
			$i = 1;
			
			foreach( $breadcrumbs as $bk => $bc ){
	
				if( strpos( $bc , $separator ) ){
					
					// Category parents fix
					echo '<li>'. $bc .'</li>';
					
				} else {
					
					if( $i == $count ) $separator = '';
					echo '<li>'. $bc . $separator .'</li>';
					
				}
				
				$i++;
				
			}
			
		echo '</ul>';
	
	}
}


/* ---------------------------------------------------------------------------
 * Hex 2 rgba
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'hex2rgba' ) )
{
	function hex2rgba( $hex, $alpha = 1, $echo = false ) {
		$hex = str_replace("#", "", $hex);
	
		if(strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} else {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}
		
		$rgba = 'rgba('. $r.', '. $g .', '. $b .', '. $alpha .')';
	
		if( $echo ){
			echo $rgba;
			return true;
		}
		
		return $rgba;
	}
}


/* ---------------------------------------------------------------------------
 * Is dark color
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_brightness' ) )
{
	function mfn_brightness( $hex, $tolerance = 169 ) {
		
		$hex = str_replace("#", "", $hex);
	
		$r = hexdec(substr( $hex, 0, 2 ));
		$g = hexdec(substr( $hex, 2, 2 ));
		$b = hexdec(substr( $hex, 4, 2 ));
	
		$brightness =  ( ($r * 299) + ($g * 587) + ($b * 114) ) / 1000;
				
		if( $brightness > $tolerance ){
			$brightness = 'light';
		} else {
			$brightness = 'dark';
		}
		
		return $brightness;		
	}
}


/* ---------------------------------------------------------------------------
 * jPlayer HTML
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_jplayer_html' ) )
{
	function mfn_jplayer_html( $video_m4v, $poster = false ){
		$player_id 	= mt_rand( 0, 999 );
		
		$output = '<div id="jp_container_'. $player_id .'" class="jp-video mfn-jcontainer">';
			$output .= '<div class="jp-type-single">';
				$output .= '<div id="jquery_jplayer_'. $player_id .'" class="jp-jplayer mfn-jplayer" data-m4v="'. $video_m4v .'" data-img="'. $poster .'" data-swf="'. THEME_URI .'/assets/jplayer"></div>';
				$output .= '<div class="jp-gui">';
					$output .= '<div class="jp-video-play">';
						$output .= '<a href="javascript:;" class="jp-video-play-icon" tabindex="1">play</a>';
					$output .= '</div>';
					$output .= '<div class="jp-interface">';
						$output .= '<div class="jp-progress">';
							$output .= '<div class="jp-seek-bar">';
								$output .= '<div class="jp-play-bar"></div>';
							$output .= '</div>';
						$output .= '</div>';
						$output .= '<div class="jp-current-time"></div>';
						$output .= '<div class="jp-duration"></div>';
						$output .= '<div class="jp-controls-holder">';
							$output .= '<ul class="jp-controls">';
								$output .= '<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>';
								$output .= '<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>';
								$output .= '<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>';
								$output .= '<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>';
								$output .= '<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>';
								$output .= '<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>';
							$output .= '</ul>';
							$output .= '<div class="jp-volume-bar"><div class="jp-volume-bar-value"></div></div>';
							$output .= '<ul class="jp-toggles">';
								$output .= '<li><a href="javascript:;" class="jp-full-screen" tabindex="1" title="full screen">full screen</a></li>';
								$output .= '<li><a href="javascript:;" class="jp-restore-screen" tabindex="1" title="restore screen">restore screen</a></li>';
								$output .= '<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>';
								$output .= '<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>';
							$output .= '</ul>';
						$output .= '</div>';
						$output .= '<div class="jp-title"><ul><li>jPlayer Video Title</li></ul></div>';
					$output .= '</div>';
				$output .= '</div>';
				$output .= '<div class="jp-no-solution"><span>Update Required</span>To play the media you will need to either update your browser to a recent version or update your <a href="https://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a></div>';
			$output .= '</div>';
		$output .= '</div>'."\n";
		
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * jPlayer
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_jplayer' ) )
{
	function mfn_jplayer( $postID, $sizeH = 'full' ){
		
		// masonry square video fix
		if($sizeH == 'blog-masonry') $sizeH = 'blog-square';
		
		$video_m4v	= get_post_meta( $postID, 'mfn-post-video-mp4', true );
		$poster		= wp_get_attachment_image_src( get_post_thumbnail_id( $postID ), $sizeH );		
		$poster		= $poster[0];
		
		return mfn_jplayer_html( $video_m4v, $poster );
	}
}


/* ---------------------------------------------------------------------------
 * Post Format
* --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_post_format' ) )
{
	function mfn_post_format( $postID ){
		
		if( get_post_type( $postID ) == 'portfolio' && is_single( $postID ) ){	
			
			// portfolio
			if ( get_post_meta( get_the_ID(), 'mfn-post-video', true ) ){
				// Video - embed
				$format = 'video';
			} elseif( get_post_meta( get_the_ID(), 'mfn-post-video-mp4', true ) ){
				// Video - HTML5
				$format = 'video';
			} else {
				// Image
				$format = false;
			}
			
		} else {
			
			// blog
			$format = get_post_format( $postID );
			
		}
	
		return $format;
	}
}


/* ---------------------------------------------------------------------------
 * Attachment | GET attachment ID by URL
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_get_attachment_id_url' ) )
{
	function mfn_get_attachment_id_url( $image_url ){
		global $wpdb;
		
		$image_url = esc_url( $image_url );
		$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ));
		
		if( isset($attachment[0]) ){
			return $attachment[0];
		}
	}
}


/* ---------------------------------------------------------------------------
 * Attachment | GET attachment data
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_get_attachment_data' ) )
{
	function mfn_get_attachment_data( $image, $data, $with_key = false ){
		$size = $return = false;
		
		// image link used instead of image id
// 		if( ! is_numeric( $image ) ){
// 			$image = mfn_get_attachment_id_url( $image );
// 		}
		
		if( ! is_numeric( $image ) ){
		
			// QUICK FIX https
			$image_ID = mfn_get_attachment_id_url( $image );
		
			if( ! $image_ID ){
				$image = str_replace( 'https://', 'http://', $image );
				$image_ID = mfn_get_attachment_id_url( $image );
			}
		
			$image = $image_ID;
		}
		

		$meta = wp_prepare_attachment_for_js( $image );
		if( is_array( $meta ) && isset( $meta[ $data ] ) ){
			$return = $meta[ $data ];
			
			// if looking for alt and it isn't specified use image title
			if( $data == 'alt' && ! $return ){
				$return = $meta[ 'title' ];
			}
		}

		if( $return && $with_key ){
			$return = $data. '="'. $return .'"';
		}

		return $return;
	}
}


/* ---------------------------------------------------------------------------
 * Post Thumbnail | GET post thumbnail type
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_post_thumbnail_type' ) )
{
	function mfn_post_thumbnail_type( $postID ){	
			
		$type = 'image';
		$post_format = mfn_post_format( $postID );
		
		if( $post_format == 'image' ){
			$type = 'image';
		} elseif( $post_format == 'video' && get_post_meta( $postID, 'mfn-post-video', true )  ){
			$type = 'video embed';
		} elseif( $post_format == 'video' && get_post_meta( $postID, 'mfn-post-video-mp4', true ) ){
			$type = 'video html5';
		} elseif( get_post_meta( $postID, 'mfn-post-slider', true ) || get_post_meta( $postID, 'mfn-post-slider-layer', true ) ){
			$type = 'slider';
		}
		
		return $type;
	}
}	


/* ---------------------------------------------------------------------------
 * Post Thumbnail | GET post thumbnail
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_post_thumbnail' ) )
{
	function mfn_post_thumbnail( $postID, $type = false, $style = false, $images_only = false ){
		$output = '';
	
		
		
		// Image Size ---------------------------------------------------------
		
		
		if( $type == 'portfolio' ){
			
			// Portfolio ----------------------
			if( $style == 'list' ){
				
				// Portfolio | List ----------------------
				$sizeH = 'portfolio-list';
				
			} elseif( $style == 'masonry-flat' ) {
				
				// Portfolio | Masonry Flat ----------------------
				$size = get_post_meta( $postID, 'mfn-post-size', true );
				if( $size == 'wide' ){
					$sizeH = 'portfolio-mf-w';
				} elseif( $size == 'tall' ) {
					$sizeH = 'portfolio-mf-t';
				} else {
					$sizeH = 'portfolio-mf';
				}
				
			} elseif( $style == 'masonry-minimal' ) {
				
				// Portfolio | Masonry Minimal ----------------------
				$sizeH = 'full';
				
			} else {
				
				// Portfolio | Default ----------------------
				$sizeH = 'blog-portfolio';
				
			}
	
		} elseif( $type == 'blog' && $style == 'photo' ){
			
			// Blog | Photo ----------------------
			$sizeH = 'blog-single';
			$sizeV = 'blog-single';
			
		} elseif( $type == 'related' ){
			
			// Related Posts ----------------------
			$sizeH = 'blog-portfolio';
			
		} elseif( is_single( $postID ) ){
			
			// Blog & Portfolio | Single ----------------------
			$sizeH = 'blog-single';
			$sizeV = 'full';
			
		} else {
			
			// Default ----------------------
			$sizeH = 'blog-portfolio';
			$sizeV = 'full';
			
		}
	
		
		
		// Link Wrap ----------------------------------------------------------
		
		
		$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $postID ), 'large' );
		
		if( is_single( $postID ) ){
			
			// Single -----------------------------------------
			
			/*$link_before = '<a href="'. $large_image_url[0] .'" rel="prettyphoto">';
				$link_before .= '<div class="mask"></div>';
						
			$link_after = '</a>';
			$link_after .= '<div class="image_links">';
				$link_after .= '<a href="'. $large_image_url[0] .'" class="zoom" rel="prettyphoto"><i class="icon-search"></i></a>';
			$link_after .= '</div>';*/
			
			// Single | Post
			
			if( get_post_type() == 'post' ){
				
				// Blog | Single - Disable Image Zoom
				
				if( ! mfn_opts_get( 'blog-single-zoom' ) ){
					$link_before = '';
					$link_after = '';
				}
				
				// Blog | Single | Structured data
				
				if( mfn_opts_get( 'mfn-seo-schema-type' ) ){
					
					$link_before .= '<div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">';
					
						$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $postID ), 'full' );
							
						$link_after_schema = '<meta itemprop="url" content="'. $image_url[0] .'"/>';
						$link_after_schema .= '<meta itemprop="width" content="'. mfn_get_attachment_data( $image_url[0], 'width' ) .'"/>';
						$link_after_schema .= '<meta itemprop="height" content="'. mfn_get_attachment_data( $image_url[0], 'height' ) .'"/>';
						
					$link_after_schema .= '</div>';
					
					$link_after = $link_after_schema . $link_after;
				}
				
			}
			
		} elseif( $type == 'portfolio' ){
			
			// Portfolio --------------------------------------
			
			$external = mfn_opts_get( 'portfolio-external' );
			
			// External Link to Project Page
			if( $image_links = ( get_post_meta( get_the_ID(), 'mfn-post-link', true ) ) ){
				$image_links_class = 'triple';
			} else {
				$image_links_class = 'double';
			}
			
			// Image Link
			if( $external == 'popup' ){
				
				// link popup
				$link_before 	= '<a href="'. $large_image_url[0] .'" rel="prettyphoto">';
				$link_title 	= '<a href="'. $large_image_url[0] .'" rel="prettyphoto">';
				
			} elseif( $external == 'disable' ){
				
				// disable details
				$link_before 	= '<a href="'. $large_image_url[0] .'" rel="prettyphoto[portfolio]">';
				$link_title 	= '<a href="'. $large_image_url[0] .'" rel="prettyphoto">';
				
			} elseif( $external && $image_links ){
				
				// link to project website
				$image_links_class = 'double';
				$link_before 	= '<a href="'. $image_links .'" target="'. $external .'">';
				$link_title 	= '<a href="'. $image_links .'" target="'. $external .'">';
				
			} else {
				
				// link to project details
				$link_before 	= '<a href="'. get_permalink() .'">';
				$link_title 	= '<a href="'. get_permalink() .'">';
				
			}
			
				$link_before .= '<div class="mask"></div>';
	
			$link_after = '</a>';
			
			// Hover
			if( mfn_opts_get( 'portfolio-hover-title' ) ){
				
				// Hover | Title
				$link_after .= '<div class="image_links hover-title">';
					$link_after .= $link_title . get_the_title() .'</a>';
				$link_after .= '</div>';
				
			} elseif( $external != 'disable' ) {
				
				// Hover | Icons
				$link_after .= '<div class="image_links '. $image_links_class .'">';
					if( ! in_array( $external, array('_self','_blank') ) ) $link_after .= '<a href="'. $large_image_url[0] .'" class="zoom" rel="prettyphoto"><i class="icon-search"></i></a>';
					if( $image_links ) $link_after .= '<a target="_blank" href="'. $image_links .'" class="external"><i class="icon-forward"></i></a>';
					$link_after .= '<a href="'. get_permalink() .'" class="link"><i class="icon-link"></i></a>';
				$link_after .= '</div>';
				
			}
			
		} else {
			
			// Blog -------------------------------------------
			
			$link_before = '<a href="'. get_permalink() .'">';
				$link_before .= '<div class="mask"></div>';
	
			$link_after = '</a>';
			$link_after .= '<div class="image_links double">';
				$link_after .= '<a href="'. $large_image_url[0] .'" class="zoom" rel="prettyphoto"><i class="icon-search"></i></a>';
				$link_after .= '<a href="'. get_permalink() .'" class="link"><i class="icon-link"></i></a>';
			$link_after .= '</div>';
			
		}
		
		
		
		// Post Format --------------------------------------------------------	
		
		$post_format = mfn_post_format( $postID );
		
		// Images Only
		
		if( $images_only ){
			if( ! in_array( $post_format, array( 'quote', 'link', 'image' ) ) ){
				$post_format = 'images-only';
			}
		}

		switch( $post_format ){
			
			case 'quote':
			case 'link':
				
				// quote - Quote - without image
				
				return false;
				break;
				
			case 'image': 
				
				// image - Vertical Image
				
				if( has_post_thumbnail() ){
					$output .= $link_before;
						$output .= get_the_post_thumbnail( $postID, $sizeV, array( 'class'=>'scale-with-grid' ) );
					$output .= $link_after;
				}
				break;
				
			case 'video':
				
				// video - Video
				
				if( $video = get_post_meta( $postID, 'mfn-post-video', true ) ){
					if( is_numeric($video) ){
						// Vimeo
						$output .= '<iframe class="scale-with-grid" src="http'. mfn_ssl() .'://player.vimeo.com/video/'. $video .'" allowFullScreen></iframe>'."\n";
					} else {
						// YouTube
						$output .= '<iframe class="scale-with-grid" src="http'. mfn_ssl() .'://www.youtube.com/embed/'. $video .'?wmode=opaque" allowfullscreen></iframe>'."\n";
					}
				} elseif( get_post_meta( $postID, 'mfn-post-video-mp4', true ) ){
					$output .= mfn_jplayer( $postID );		
				}
				break;
				
			case 'images-only':
				
				// Images Only
				
				$output .= $link_before;
					$output .= get_the_post_thumbnail( $postID, $sizeH, array( 'class' => 'scale-with-grid' ) );
				$output .= $link_after;
				break;
				
			default:
				
				// standard - Text, Horizontal Image, Slider
				
				$rev_slider = get_post_meta( $postID, 'mfn-post-slider', true );
				$lay_slider = get_post_meta( $postID, 'mfn-post-slider-layer', true );
				
				if( $type != 'portfolio' && ( $rev_slider || $lay_slider ) ){
						
					if( $rev_slider ){
						// Revolution Slider
						$output .= do_shortcode('[rev_slider '. $rev_slider .']');
						
					} elseif( $lay_slider ){
						// Layer Slider
						$output .= do_shortcode('[layerslider id="'. $lay_slider .'"]');
					}
					
				} elseif( has_post_thumbnail() ){
					
					// Image
					$output .= $link_before;
						$output .= get_the_post_thumbnail( $postID, $sizeH, array( 'class'=>'scale-with-grid' ) );
					$output .= $link_after;
					
				}
		}
		
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Single Post Navigation | SET query order
 * --------------------------------------------------------------------------- */

// previous ----------
if( ! function_exists( 'mfn_filter_previous_post_sort' ) )
{
	function mfn_filter_previous_post_sort( $sort ){
		if( mfn_get_portfolio_order() == 'ASC' ){
			$order = 'DESC';
		} else {
			$order = 'ASC';
		}
		$sort = "ORDER BY p.". esc_sql( mfn_get_portfolio_orderby() ) ." ". $order ." LIMIT 1";
		return $sort;
	}
}

if( ! function_exists( 'mfn_filter_previous_post_where' ) )
{
	function mfn_filter_previous_post_where( $where ){
		global $post, $wpdb;
		$orderby = mfn_get_portfolio_orderby();
		$where = preg_replace( "/(.*)p.post_type/", "AND p.post_type", $where );
		
		if( mfn_get_portfolio_order() == 'ASC' ){
			$where_pre = $wpdb->prepare( "WHERE p.". esc_sql( $orderby ) ." < %s", $post->$orderby );
		} else {
			$where_pre = $wpdb->prepare( "WHERE p.". esc_sql( $orderby ) ." > %s", $post->$orderby );
		}
		
		$where = $where_pre.' '.$where;
		return $where;
	}
}

// next ----------
if( ! function_exists( 'mfn_filter_next_post_sort' ) )
{
	function mfn_filter_next_post_sort( $sort ){
		$sort = "ORDER BY p.". esc_sql( mfn_get_portfolio_orderby() ) ." ". esc_sql( mfn_get_portfolio_order() ) ." LIMIT 1";
		return $sort;
	}
}

if( ! function_exists( 'mfn_filter_next_post_where' ) )
{
	function mfn_filter_next_post_where( $where ){
		global $post, $wpdb;
		$orderby = mfn_get_portfolio_orderby();
		$where = preg_replace( "/(.*)p.post_type/", "AND p.post_type", $where );
		
		if( mfn_get_portfolio_order() == 'ASC' ){
			$where_pre = $wpdb->prepare( "WHERE p.". esc_sql( $orderby ) ." > %s", $post->$orderby );
		} else {
			$where_pre = $wpdb->prepare( "WHERE p.". esc_sql( $orderby ) ." < %s", $post->$orderby );
		}
		
		$where = $where_pre.' '.$where;
		return $where;
	}
}

// helpers ----------
if( ! function_exists( 'mfn_get_portfolio_order' ) )
{
	function mfn_get_portfolio_order(){
		return mfn_opts_get( 'portfolio-order', 'DESC' );
	}
}

if( ! function_exists( 'mfn_get_portfolio_orderby' ) )
{
	function mfn_get_portfolio_orderby(){
		$orderby = mfn_opts_get( 'portfolio-orderby', 'date' );
		switch( $orderby ){
			case 'title':
				$orderby = 'post_title';
				break;
			case 'menu_order':
				$orderby = 'menu_order';
				break;
			default:
				$orderby = 'post_date';
		}
		return $orderby;
	}
}

// filters ----------
if( ! function_exists( 'mfn_post_navigation_sort' ) )
{
	function mfn_post_navigation_sort(){
		add_filter( 'get_previous_post_sort', 'mfn_filter_previous_post_sort' );
		add_filter( 'get_previous_post_where', 'mfn_filter_previous_post_where' );
		add_filter( 'get_next_post_sort', 'mfn_filter_next_post_sort' );
		add_filter( 'get_next_post_where', 'mfn_filter_next_post_where' );	
	}
}


/* ---------------------------------------------------------------------------
 * Single Post Navigation | GET header navigation
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_post_navigation_header' ) )
{
	function mfn_post_navigation_header( $post_prev, $post_next, $post_home, $translate = array() ){
		
		$style = mfn_opts_get( 'prev-next-style' );
		
		$output = '<div class="column one post-nav '. $style .'">';
		
			if( $style == 'minimal' ){
				
				// minimal -----
							
				if( $post_prev ) $output .= '<a class="prev" href="'. get_permalink( $post_prev ) .'"><i class="icon icon-left-open-big"></i></a></li>';
				if( $post_next ) $output .= '<a class="next" href="'. get_permalink( $post_next ) .'"><i class="icon icon-right-open-big"></i></a></li>';		
				if( $post_home ) $output .= '<a class="home" href="'. get_permalink( $post_home ) .'"><svg class="icon" width="22" height="22" xmlns="https://www.w3.org/2000/svg"><path d="M7,2v5H2V2H7 M9,0H0v9h9V0L9,0z"/><path d="M20,2v5h-5V2H20 M22,0h-9v9h9V0L22,0z"/><path d="M7,15v5H2v-5H7 M9,13H0v9h9V13L9,13z"/><path d="M20,15v5h-5v-5H20 M22,13h-9v9h9V13L22,13z"/></svg></a>';
				
			} else {
				
				// default -----

				$output .= '<ul class="next-prev-nav">';
					if( $post_prev ) $output .= '<li class="prev"><a class="button button_js" href="'. get_permalink( $post_prev ) .'"><span class="button_icon"><i class="icon-left-open"></i></span></a></li>';
					if( $post_next ) $output .= '<li class="next"><a class="button button_js" href="'. get_permalink( $post_next ) .'"><span class="button_icon"><i class="icon-right-open"></i></span></a></li>';
				$output .= '</ul>';
					
				if( $post_home ) $output .= '<a class="list-nav" href="'. get_permalink( $post_home ) .'"><i class="icon-layout"></i>'. $translate['all'] .'</a>';
			
			}
	
		$output .= '</div>';

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Single Post Navigation | GET sticky navigation
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_post_navigation_sticky' ) )
{
	function mfn_post_navigation_sticky( $post, $next_prev, $icon ){
		$output = '';
	
		if( is_object( $post ) ){
			
			// move this DOM element with JS
			
			$style = mfn_opts_get( 'prev-next-sticky-style', 'default' );
			
			$output .= '<a class="fixed-nav fixed-nav-'. $next_prev .' format-'. get_post_format( $post ) .' style-'. $style .'" href="'. get_permalink( $post ) .'">';

				$output .= '<span class="arrow"><i class="'. $icon .'"></i></span>';
				
				$output .= '<div class="photo">';
					$output .= get_the_post_thumbnail( $post->ID, 'blog-navi' );
				$output .= '</div>';
				
				$output .= '<div class="desc">';
					$output .= '<h6>'. get_the_title( $post ) .'</h6>';
					$output .= '<span class="date"><i class="icon-clock"></i>'. get_the_date(get_option('date_format'), $post->ID) .'</span>';
				$output .= '</div>';
				
			$output .= '</a>';
		}
	
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Search | SET add custom fields to search query
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_search' ) )
{
	function mfn_search( $search_query ) {
		global $wpdb;
	
		if( is_search() && $search_query->is_main_query() && $search_query->is_search() ){
	
			$keyword = get_search_query();
			if( ! $keyword ) return false;
			
			// WooCommerce uses default search Query
			if( function_exists('is_woocommerce') && is_woocommerce() ){
				return false;
			}
	
			$keyword = '%' . $wpdb->esc_like( $keyword ) . '%';
	
			// Post Title & Post Content
			$post_ids_title = $wpdb->get_col( $wpdb->prepare( "
				SELECT DISTINCT ID FROM {$wpdb->posts}
				WHERE post_title LIKE '%s'
			", $keyword, $keyword ) );
			
			// Post Title & Post Content
			$post_ids_content = $wpdb->get_col( $wpdb->prepare( "
				SELECT DISTINCT ID FROM {$wpdb->posts}
				WHERE post_content LIKE '%s'
			", $keyword, $keyword ) );
			
			// Custom Fields
			$post_ids_meta = $wpdb->get_col( $wpdb->prepare( "
				SELECT DISTINCT post_id FROM {$wpdb->postmeta}
				WHERE meta_key = 'mfn-page-items-seo'
				AND meta_value LIKE '%s'
			", $keyword ) );
	
			$post_ids = array_merge( $post_ids_title, $post_ids_content, $post_ids_meta );
	
			if( ! count( $post_ids ) ) return false;
	
			$search_query->set( 's', false );
			$search_query->set( 'post__in', $post_ids );
			$search_query->set( 'orderby', 'post__in' );
	
		}
	}
}
add_action( 'pre_get_posts', 'mfn_search' );


/* ---------------------------------------------------------------------------
 * Posts per page & pagination fix
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_option_posts_per_page' ) )
{
	function mfn_option_posts_per_page( $value ) {
		if ( is_tax( 'portfolio-types' ) ) {
	        $posts_per_page = mfn_opts_get( 'portfolio-posts', 6, true );
	    } else {
	        $posts_per_page = mfn_opts_get( 'blog-posts', 5, true );
	    }
	    return $posts_per_page;
	}
}

if( ! function_exists( 'mfn_posts_per_page' ) )
{
	function mfn_posts_per_page() {
	    add_filter( 'option_posts_per_page', 'mfn_option_posts_per_page' ); 
	}
}
add_action( 'init', 'mfn_posts_per_page', 0 );


/* ---------------------------------------------------------------------------
 *	Comments number with text
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_comments_number' ) )
{
	function mfn_comments_number() {
		$translate['comment'] = mfn_opts_get('translate') ? mfn_opts_get('translate-comment','comment') : __('comment','betheme');
		$translate['comments'] = mfn_opts_get('translate') ? mfn_opts_get('translate-comments','comments') : __('comments','betheme');
		$translate['comments-off'] = mfn_opts_get('translate') ? mfn_opts_get('translate-comments-off','comments off') : __('comments off','betheme');
		
		$num_comments = get_comments_number(); // get_comments_number returns only a numeric value
		
		if ( comments_open() ) {
			if ( $num_comments != 1 ) {
				$comments = '<a href="' . get_comments_link() .'">'. $num_comments.'</a> '. $translate['comments'];
			} else {
				$comments = '<a href="' . get_comments_link() .'">1</a> '. $translate['comment'];
			}
		} else {
			$comments = $translate['comments-off'];
		}
		return $comments;
	}
}


/* ---------------------------------------------------------------------------
 *	Menu title in selected location
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_get_menu_name' ) )
{
	function mfn_get_menu_name($location){
		
		if( ! has_nav_menu($location) ){
			return false;
		}
		
		$menus = get_nav_menu_locations();
		$menu_title = wp_get_nav_menu_object($menus[$location])->name;
		
		return $menu_title;
	}
}


/* ---------------------------------------------------------------------------
 *	GET | WordPress Authors
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_get_authors' ) )
{
	function mfn_get_authors(){
		
		$authors = get_users();
		
		if( is_array($authors) ){
			foreach( $authors as $ka => $author ){
				$remove = true;
				if( in_array( 'author', $author->roles ) ) $remove = false;
				if( in_array( 'editor', $author->roles ) ) $remove = false;
				if( in_array( 'administrator', $author->roles ) ) $remove = false;
				if( $remove ) unset( $authors[$ka] );
			}
		}
		
		return $authors;
	}
}


/* ---------------------------------------------------------------------------
 *	Under Construction
 * --------------------------------------------------------------------------- */
if( ! function_exists('mfn_under_construction') )
{
	function mfn_under_construction(){

		if( mfn_opts_get('construction') ){
			
			if( isset( $_POST['_wpcf7_is_ajax_call'] ) ){
					
				// do nothing
					
			} else {
					
				if( ! is_user_logged_in() && ! is_admin()
				&& basename( $_SERVER['PHP_SELF']) != 'wp-login.php'
				&& basename( $_SERVER['PHP_SELF']) != 'wp-cron.php'
				&& basename( $_SERVER['PHP_SELF']) != 'xmlrpc.php' ){
					
					get_template_part('under-construction');
					exit();
					
				}
					
			}
			
		}
				
	}
}
add_action('init', 'mfn_under_construction', 30);


/* ---------------------------------------------------------------------------
 *	Set Max Content Width
 * --------------------------------------------------------------------------- */
if ( ! isset( $content_width ) ) $content_width = 1200;


/* ---------------------------------------------------------------------------
 *	WPML | Date Format
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_wpml_date_format' ) )
{
	function mfn_wpml_date_format( $format ) {
		if (function_exists('icl_translate'))
			$format = icl_translate('Formats', $format, $format);
		return $format;
	}
}
add_filter('option_date_format', 'mfn_wpml_date_format');


/* ---------------------------------------------------------------------------
 *	WPML | ID
 *	@param type string – 'post', 'page', 'post_tag' or 'category'
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_wpml_ID' ) )
{
	function mfn_wpml_ID( $id, $type = 'page' ) {
		if( function_exists('icl_object_id') ) {
			return icl_object_id( $id, $type, true );
		} else {
			return $id;
		}
	}
}


/* ---------------------------------------------------------------------------
 *	WPML | Term slug
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_wpml_term_slug' ) )
{
	function mfn_wpml_term_slug( $slug, $type, $multi = false ){
		
		if( function_exists( 'icl_object_id' ) ){
			
			if( $multi ){
				
				// multiple categories
				
				$slugs = explode( ',', $slug );
				
				if( is_array( $slugs ) ){
					foreach( $slugs as $slug_k => $slug ){
						
						$slug = trim( $slug );
						
						$term = get_term_by( 'slug', $slug, $type );
						$term = apply_filters( 'wpml_object_id', $term->term_id, $type, true );
						$slug = get_term_by( 'term_id', $term, $type )->slug;
						
						$slugs[$slug_k] = $slug;
					}
				}
				
				$slug = implode( ',', $slugs );
				
			} else {
				
				// single category
				
				$term = get_term_by( 'slug', $slug, $type );
				$term = apply_filters( 'wpml_object_id', $term->term_id, $type, true );
				$slug = get_term_by( 'term_id', $term, $type )->slug;
				
			}

		}
						
		return $slug;
	}
}


/* ---------------------------------------------------------------------------
 *	Schema | Auto Get Schema Type By Post Type
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_tag_schema' ) )
{
	function mfn_tag_schema(){
		$schema = 'http'. mfn_ssl() .'://schema.org/';
	
		// Is Woocommerce product
		if( function_exists( 'is_product' ) && is_product() ){
			
			$type = false;
			
		} elseif( is_single() && get_post_type() == 'post' ) {
			
			// Single post
			$type = "Article";
			
		} elseif( is_author() ) {
			
			// Author page
			$type = 'ProfilePage';
			
		} elseif( is_search() ) {
			
			// Search results
			$type = 'SearchResultsPage';
			
		} else {
			
			// Default
			$type = 'WebPage';
			
		}

		if( mfn_opts_get( 'mfn-seo-schema-type' ) && $type ){
			echo ' itemscope itemtype="' . $schema . $type . '"';
		}
		
		return true;
	}
}


/* ---------------------------------------------------------------------------
 *	TGM Plugin Activation
 * --------------------------------------------------------------------------- */
add_action( 'tgmpa_register', 'mfn_register_required_plugins' );
if( ! function_exists( 'mfn_register_required_plugins' ) )
{
	function mfn_register_required_plugins() {
	
		$plugins = array(
				
			// required -----------------------------	
			
			array(	
				'name'               	=> 'Slider Revolution', // The plugin name.
				'slug'               	=> 'revslider', // The plugin slug (typically the folder name).
				'source'             	=> THEME_DIR .'/plugins/revslider.zip', // The plugin source.
				'required'           	=> true, // If false, the plugin is only 'recommended' instead of required.
				'version'            	=> '5.4.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
// 				'force_activation'   	=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
// 				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
// 				'external_url'       	=> '', // If set, overrides default API URL and points to an external URL.
// 				'is_callable'        	=> '', // If set, this callable will be be checked for availability to determine if a plugin is active.
			),
	
			array(
				'name'     				=> 'Contact Form 7',
				'slug'     				=> 'contact-form-7',	
				'required' 				=> true,
				'external_url'			=> 'https://wordpress.org/plugins/contact-form-7/',
			),
				
			// recommended -----------------------------

			array(
				'name'     				=> 'Duplicate Post',
				'slug'     				=> 'duplicate-post',
				'required' 				=> false,
				'external_url'			=> 'https://wordpress.org/plugins/duplicate-post/',
			),
				
			array(
				'name'     				=> 'Force Regenerate Thumbnails',
				'slug'     				=> 'force-regenerate-thumbnails',
				'required' 				=> false,
				'external_url'			=> 'https://wordpress.org/plugins/force-regenerate-thumbnails/',
			),
				
			array(
				'name'     				=> 'Layer Slider',
				'slug'     				=> 'LayerSlider',
				'source'   				=> THEME_DIR .'/plugins/layerslider.zip',
				'required' 				=> false,
				'version' 				=> '6.1.6',
			),
	
			array(
				'name'     				=> 'Visual Composer',
				'slug'     				=> 'js_composer',
				'source'   				=> THEME_DIR .'/plugins/js_composer.zip',
				'required' 				=> false,
				'version' 				=> '5.1',
			),
	
		);
	
		$config = array(

			'id'           	=> 'mfn-be',        		// Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' 	=> '',                      // Default absolute path to bundled plugins.
			'menu'         	=> 'tgmpa-install-plugins', // Menu slug.
			'parent_slug'  	=> 'themes.php',            // Parent menu slug.
			'capability'   	=> 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  	=> true,                    // Show admin notices or not.
			'dismissable'  	=> true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  	=> '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic'	=> false,                   // Automatically activate plugins after installation or not.
			'message' 		=> '<div class="mfn-tgm-message">'. __( 'If you are not sure about server\'s settings and limits, please activate <u>necessary plugins ONLY</u>', 'tgmpa' ) .'</div>',	// Message to output right before the plugins table
			'strings'      	=> array(
				'page_title'                      	=> __( 'Install Required Plugins', 'tgmpa' ),
				'menu_title'                     	=> __( 'Install Plugins', 'tgmpa' ),
				'installing'                      	=> __( 'Installing Plugin: %s', 'tgmpa' ), // %s = plugin name.
				'oops'                            	=> __( 'Something went wrong with the plugin API.', 'tgmpa' ),
				'notice_can_install_required'     	=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'tgmpa' ),
				'notice_can_install_recommended'  	=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'tgmpa' ),
				'notice_cannot_install'           	=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'tgmpa' ),
				'notice_can_activate_required'    	=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'tgmpa' ),
				'notice_can_activate_recommended' 	=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'tgmpa' ),
				'notice_cannot_activate'          	=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'tgmpa' ),
				'notice_ask_to_update'            	=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'tgmpa' ),
				'notice_cannot_update'            	=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'tgmpa' ),
				'install_link'                    	=> _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'tgmpa' ),
				'activate_link'                   	=> _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'tgmpa' ),
				'return'                          	=> __( 'Return to Required Plugins Installer', 'tgmpa' ),
				'plugin_activated'                	=> __( 'Plugin activated successfully.', 'tgmpa' ),
				'complete'                        	=> __( 'All plugins installed and activated successfully. %s', 'tgmpa' ), // %s = dashboard link.
				'nag_type'                        	=> 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
			),
				
		);
	
		tgmpa( $plugins, $config );
	}
}


/** --------------------------------------------------------------------------
 * DEPRECATED
 * --------------------------------------------------------------------------- */

/* ---------------------------------------------------------------------------
 * Excerpt
 * @deprecated
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_excerpt' ) )
{
	function mfn_excerpt($post, $length = 55, $tags_to_keep = '<a><b><h1><h2><h3><h4><h5><h6><strong>', $extra = ' [...]') {
			
		if(is_int($post)) {
			$post = get_post($post);
		} elseif(!is_object($post)) {
			return false;
		}

		if(has_excerpt($post->ID)) {
			$the_excerpt = $post->post_excerpt;
			return apply_filters('the_content', $the_excerpt);
		} else {
			$the_excerpt = $post->post_content;
		}

		$the_excerpt = strip_shortcodes(strip_tags($the_excerpt, $tags_to_keep));
		$the_excerpt = preg_split('/\b/', $the_excerpt, $length * 2+1);
		$excerpt_waste = array_pop($the_excerpt);
		$the_excerpt = implode($the_excerpt);
		if( $excerpt_waste ) $the_excerpt .= $extra;

		return apply_filters('the_content', $the_excerpt);
	}
}

/* ---------------------------------------------------------------------------
 * Get Comment Excerpt
 * @deprecated since 12.5
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_get_comment_excerpt' ) )
{
	function mfn_get_comment_excerpt($comment_ID = 0, $num_words = 20) {
		$comment = get_comment( $comment_ID );
		$comment_text = strip_tags($comment->comment_content);
		$blah = explode(' ', $comment_text);
		if (count($blah) > $num_words) {
			$k = $num_words;
			$use_dotdotdot = 1;
		} else {
			$k = count($blah);
			$use_dotdotdot = 0;
		}
		$excerpt = '';
		for ($i=0; $i<$k; $i++) {
			$excerpt .= $blah[$i] . ' ';
		}
		$excerpt .= ($use_dotdotdot) ? '[...]' : '';
		return apply_filters('get_comment_excerpt', $excerpt);
	}
}
