<?php if(!defined('ABSPATH')) die('Direct access denied.'); ?>

<input type="hidden" name="<?php echo esc_attr($nonce_name); ?>" value="<?php echo esc_attr($nonce); ?>" />
<div class="cs-sortables" data-post-id="<?php echo esc_attr($post_id); ?>">
	<?php echo $slides; ?>
</div>
<input type="button" value="<?php _e('Add Slide', 'cyclone-slider-2'); ?>" class="cs-add-slide button-secondary" />
<input type="button" value="<?php _e('Add Images as Slides', 'cyclone-slider-2'); ?>" class="cs-multiple-slides button-secondary" />