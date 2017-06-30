<?php
/**
 * Custom Markup for Search form
 *
 * @package Palm Beach
 */

?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'palm-beach' ); ?></span>
		<input type="search" class="search-field"
			placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'palm-beach' ); ?>"
			value="<?php echo get_search_query(); ?>" name="s"
			title="<?php echo esc_attr_x( 'Search for:', 'label', 'palm-beach' ); ?>" />
	</label>
	<button type="submit" class="search-submit">
		<span class="genericon-search"></span>
		<span class="screen-reader-text"><?php echo esc_html_x( 'Search', 'submit button', 'palm-beach' ); ?></span>
	</button>
</form>
