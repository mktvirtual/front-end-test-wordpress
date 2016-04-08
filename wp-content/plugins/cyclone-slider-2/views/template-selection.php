<?php if(!defined('ABSPATH')) die('Direct access denied.'); ?>
<ul class="cs-templates">
	<li class="header">
		<span class="template-name"><?php _e('Name', 'cyclone-slider-2'); ?></span>
		<span class="supported-slide-types"><?php _e('Supported Slides', 'cyclone-slider-2'); ?></span>
		<span class="cs-location"><?php _e('Location', 'cyclone-slider-2'); ?></span>
		<span class="selected"><?php _e('Selected', 'cyclone-slider-2'); ?></span>
		<span class="clear"></span>
	</li>
	<?php foreach($templates as $id=>$template): ?>
	<li class="body <?php echo ($template['selected']) ? 'active' : ''; ?>">
		<input <?php checked( $slider_settings['template'], $id); ?> id="template-<?php echo esc_attr($id); ?>" type="radio" name="cycloneslider_settings[template]" value="<?php echo esc_attr($id); ?>" />
		<span class="template-name"><?php echo esc_html($template['name']); ?></span>
		<span class="supported-slide-types">
			<?php if(in_array('image', $template['supports'])): ?>
			<i title="Image" class="icon-picture"></i>
			<?php endif; ?>
			<?php if(in_array('youtube', $template['supports'])): ?>
			<i title="YouTube" class="icon-youtube-play"></i>
			<?php endif; ?>
			<?php if(in_array('vimeo', $template['supports'])): ?>
			<i title="Vimeo" class="icon-play"></i>
			<?php endif; ?>
			<?php if(in_array('custom', $template['supports'])): ?>
			<i title="Custom HTML" class="icon-code"></i>
			<?php endif; ?>
			<?php if(in_array('testimonial', $template['supports'])): ?>
			<i title="Testimonial" class="icon-quote-left"></i>
			<?php endif; ?>
		</span>
		<span class="cs-location">
			<a href="#" data-content="<?php echo wp_kses_post($template['location_details']); ?>"><?php echo $template['location_name']; ?></a>
			<?php if( !empty( $template['warning'] ) ): ?>
				<a href="#" data-content="<?php echo wp_kses_post($template['warning']); ?>" ><i class="icon-warning-sign"></i></a>
			<?php endif; ?>
		</span>
		<span class="selected"><i class="icon-ok"></i></span>
		<span class="clear"></span>
	</li>
	<?php endforeach; ?>
</ul>
<div class="cs-templates-buttons">
	<a target="_blank" href="http://docs.codefleet.net/cyclone-slider-2/templating/" class="button-secondary"><?php _e('Learn More About Templates', 'cyclone-slider-2'); ?></a>
	<a target="_blank" href="https://www.codefleet.net/cyclone-slider-2/templates/" class="button-secondary"><?php _e('Get More Templates', 'cyclone-slider-2'); ?></a>
</div>