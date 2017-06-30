<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://icanwp.com/plugins/background-slider-master/
 * @since      1.0.0
 *
 * @package    Background_Slider_Master
 * @subpackage Background_Slider_Master/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<h2>Background Slider - Settings</h2>
<h3>Slider Display Settings</h3>
<p class="bsm_notice"><strong>Apply slider to all pages and posts globally below, or click into your pages and posts individually and look for the "Select Background Slider Master Gallery" option on the side.<br /> This will apply the Background Slider to that page or post only.</strong></p>
<div class="icanwp-promo">
<h3>Do you want more features?</h3>
<ul>
<li>Add text overlay with or without call to action over each slide</li>
<li>Display thumbnail navigation on any side of the screen</li>
<li>Customize color, padding, margin, and more for each element displayed in the background slider</li>
<li>Get more animation in sliding effect</li>
<li>Override global style from each slider setting</li>
</ul>
<p><a href="https://icanwp.com/plugins/background-slider-gallery-demo/" class="icanwp-action" target="_blank">Demo</a><a href="https://icanwp.com/_link?a=ccbs" class="icanwp-action-hot" target="_blank">Get it now!</a></p>
</div>

<form class="bsm-settings" method="post" action="options.php"> 
<?php 
	settings_fields( 'bsm_settings_menu' );
	do_settings_sections( 'bsm_settings_menu' ); 
	submit_button(); 
?>
</form>
<div id="wp-master-info-panel">
	<div class="wp-master-info-section">
		<h3>Our plugins are developed to support our actual clients with over 10+ years of in Website Development.</h3>
		<p>&bull; Checkout the must have WordPress plugin for displaying your posts like a pro. <a href="https://icanwp.com/_link?a=ccpt" target="_blank">WordPress Post Ticker</a></p>
		<p>&bull; Impress your website visitors with the advanced <a href="https://icanwp.com/_link?a=ccpg" target="_blank">WordPress Portfolio Gallery</a> that give you full freedom of control.</p>
	</div>
	<div class="wp-master-promo-section">
		<h3>Best of the best services we recommend for your business website</h3>
		<p>&bull; Run your WordPress with all the optimization you need on a managed <a href="https://icanwp.com/_link?a=we" target="_blank">WordPress hosting</a>.</p>
		<p>&bull; Most economic and well supported <a href="https://icanwp.com/_link?a=nc" target="_blank">domain registrar</a> that we use for our clients.</p>
		<p>&bull; Constantly getting better and simply the best email <a href="https://icanwp.com/_link?a=cc" target="_blank">marketing solution</a></p>
		<h4>Alternative Solution for Tight Budget Project</h4>
		<p>&bull; Since 2009, we've used over 17 hosting companies and this <a href="//www.bluehost.com/track/icanwp/redirect" target="_blank">hosting company</a> is one of the best that we still use it on many of our projects.</p>
		<p>&bull; Still offering free service, with some restrictions, for decent size contact list for <a href="https://icanwp.com/_link?a=mc" target="_target">email marketing.</a></p>
	</div>
</div>
<h3>FAQ &amp; Troubleshooting</h3>
<h4>Q1. Background Slider image is covered behind other elements.</h4>
<p>
A. The background images are loaded as the first element under the  &lt;head&gt; section, but it is given z-index value of 0. Please make sure there are no html elements, such as &lt;body&gt; or &lt;div&gt; with background color or image specified in CSS.
</p>