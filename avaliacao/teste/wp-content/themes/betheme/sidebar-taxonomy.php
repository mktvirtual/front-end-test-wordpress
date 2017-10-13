<?php
/**
 * The Page Sidebar containing the widget area.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

$sidebar = false;

// Category -----------------------------------------------
$category = get_query_var( 'portfolio-types' );
$cat_sidebar = 'portfolio-cat-'. $category;

if( is_active_sidebar( $cat_sidebar ) ){
	$sidebar = $cat_sidebar;
}

// Blog ---------------------------------------------------
if( ! $sidebar ){
	$portfolio_page_id = mfn_opts_get( 'portfolio-page' );
	$sidebars = mfn_opts_get( 'sidebars' );
	$sidebar = get_post_meta($portfolio_page_id, 'mfn-post-sidebar', true);
	$sidebar = $sidebars[$sidebar];
}

?>

<?php if( mfn_sidebar_classes() ): ?>
<div class="sidebar four columns">
	<div class="widget-area clearfix <?php mfn_opts_show('sidebar-lines'); ?>">
		<?php 
			if ( ! dynamic_sidebar( $sidebar ) ){ 
				mfn_nosidebar(); 
			}
		?>
	</div>
</div>
<?php endif;

// Omit Closing PHP Tags