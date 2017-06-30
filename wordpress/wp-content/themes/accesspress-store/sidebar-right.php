<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package AccessPress Root
 */

if ( ! is_active_sidebar( 'sidebar-right' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area secondary-right sidebar">
	<?php dynamic_sidebar( 'sidebar-right' ); ?>
</div><!-- #secondary -->
