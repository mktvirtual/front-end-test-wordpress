<?php if(!defined('ABSPATH')) die('Direct access denied.'); ?>

<?php
if(!empty($post->post_name)):
	if( function_exists('cyclone_slider') ):
		cyclone_slider($post->post_name);
	endif;
else:
	?><p><?php _e('Your preview will appear here.', 'cyclone-slider-2'); ?></p><?php
endif;