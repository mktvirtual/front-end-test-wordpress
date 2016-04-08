<?php if(!defined('ABSPATH')) die('Direct access denied.'); ?>

<div class="cs-slide" data-slide-type="<?php echo esc_attr( $slide['type'] ); ?>" data-slide-hidden="<?php echo esc_attr( $slide['hidden'] ); ?>">
	<div class="cs-header">
		<span class="cs-icon">
			<i class="icon-picture"></i>
			<i class="icon-youtube-play"></i>
			<i class="icon-play"></i>
			<i class="icon-code"></i>
			<i class="icon-film"></i>
			<i class="icon-quote-left"></i>
		</span>
		<span class="cs-title">
			<?php echo esc_html($box_title); ?>
		</span>
		<span class="cs-controls">
			<span class="cs-delete" title="<?php _e('Delete', 'cyclone-slider-2'); ?>">
				<i class="icon-remove"></i>
			</span>
		</span>
		<div class="clear"></div>
	</div>
	<div class="cs-body">
		<div class="cs-slide-type-bar">
			<select class="cs-slide-type-switcher" name="cycloneslider_metas[<?php echo esc_attr($i); ?>][type]">
				<option value="image" <?php selected($slide['type'], 'image'); ?>><?php _e('Image', 'cyclone-slider-2'); ?></option>
				<option value="youtube" <?php selected($slide['type'], 'youtube'); ?>><?php _e('YouTube', 'cyclone-slider-2'); ?></option>
				<option value="vimeo" <?php selected($slide['type'], 'vimeo'); ?>><?php _e('Vimeo', 'cyclone-slider-2'); ?></option>
				<option value="custom" <?php selected($slide['type'], 'custom'); ?>><?php _e('Custom HTML', 'cyclone-slider-2'); ?></option>
				<option value="testimonial" <?php selected($slide['type'], 'testimonial'); ?>><?php _e('Testimonial', 'cyclone-slider-2'); ?></option>
			</select>
			
			<label class="cs-slide-hidden" for="cs-slide-hidden-<?php echo esc_attr($i); ?>">
				<input id="cs-slide-hidden-<?php echo esc_attr($i); ?>" type="checkbox" name="cycloneslider_metas[<?php echo esc_attr($i); ?>][hidden]" value="1" <?php checked($slide['hidden'], '1'); ?>>
				<span><?php _e('Hidden', 'cyclone-slider-2'); ?></span>
			</label>
		</div>
		<div class="clear"></div>
		<div class="cs-slide-image">
			<div class="cs-image-preview">
				<div class="cs-image-thumb" <?php echo (empty($image_url)) ? 'style="display:none"' : '';?>>
					<?php if($image_url): ?>
					<img src="<?php echo esc_url($image_url); ?>" alt="thumb">
					<?php endif; ?>
				</div>
				<input class="cs-image-id" name="cycloneslider_metas[<?php echo esc_attr($i); ?>][id]" type="hidden" value="<?php echo esc_attr($slide['id']); ?>" />
				<input class="button-secondary cs-media-gallery-show" type="button" value="<?php _e('Get Image', 'cyclone-slider-2'); ?>" />
			</div>
			<div class="cs-image-settings">
				<div class="expandable-box">
					<div class="expandable-header first"><?php _e('Caption', 'cyclone-slider-2'); ?></div>
					<div class="expandable-body">
						<div class="field">
							<label for=""><?php _e('Title:', 'cyclone-slider-2'); ?></label> <br>
							<input class="widefat cycloneslider-slide-meta-title" name="cycloneslider_metas[<?php echo esc_attr($i); ?>][title]" type="text" value="<?php echo esc_attr($slide['title']); ?>" />
						</div>
						<div class="field last">
							<label for=""><?php _e('Description:', 'cyclone-slider-2'); ?></label> <br>
							<textarea class="widefat cycloneslider-slide-meta-description" name="cycloneslider_metas[<?php echo esc_attr($i); ?>][description]"><?php echo esc_textarea($slide['description']); ?></textarea>
						</div>
					</div>
				</div>
				<div class="expandable-box">
					<div class="expandable-header"><?php _e('Link', 'cyclone-slider-2'); ?></div>
					<div class="expandable-body">
						<div class="field">
							<label for=""><?php _e('Link URL:', 'cyclone-slider-2'); ?></label> <br>
							<input class="cycloneslider_metas_link_url widefat" name="cycloneslider_metas[<?php echo esc_attr($i); ?>][link]" type="text" value="<?php echo esc_url($slide['link']); ?>" />
						</div>
						<div class="field last">
							<label for=""><?php _e('Open Link in:', 'cyclone-slider-2'); ?></label> <br>
							<select class="cycloneslider_metas_link_target" id="" name="cycloneslider_metas[<?php echo esc_attr($i); ?>][link_target]">
								<option <?php selected( $slide['link_target'], '_self' ); ?> value="_self"><?php _e('Same Window', 'cyclone-slider-2'); ?></option>
								<option <?php selected( $slide['link_target'], '_blank' ); ?> value="_blank"><?php _e('New Tab or Window', 'cyclone-slider-2'); ?></option>
							</select>
						</div>
					</div>
				</div>
				<div class="expandable-box">
					<div class="expandable-header"><?php _e('Image Attributes', 'cyclone-slider-2'); ?></div>
					<div class="expandable-body">
						<div class="field">
							<label for=""><?php _e('Alternate Text:', 'cyclone-slider-2'); ?></label> <br>
							<input class="widefat cycloneslider-slide-meta-alt" name="cycloneslider_metas[<?php echo esc_attr($i); ?>][img_alt]" type="text" value="<?php echo esc_attr($slide['img_alt']); ?>" />
						</div>
						<div class="field last">
							<label for=""><?php _e('Title Text:', 'cyclone-slider-2'); ?></label> <br>
							<input class="widefat cycloneslider-slide-meta-title" name="cycloneslider_metas[<?php echo esc_attr($i); ?>][img_title]" type="text" value="<?php echo esc_attr($slide['img_title']); ?>" />
						</div>
					</div>
				</div>
				<div class="expandable-box last">
					<div class="expandable-header"><?php _e('Slide Transition Effects', 'cyclone-slider-2'); ?></div>
					<div class="expandable-body">
						
						<select id="" class="cycloneslider_metas_enable_slide_effects" name="cycloneslider_metas[<?php echo esc_attr($i); ?>][enable_slide_effects]">
							<option <?php echo (0==$slide['enable_slide_effects']) ? 'selected="selected"' : ''; ?> value="0"><?php _e('Disable', 'cyclone-slider-2'); ?></option>
							<option <?php echo (1==$slide['enable_slide_effects']) ? 'selected="selected"' : ''; ?> value="1"><?php _e('Enable Slide Effects', 'cyclone-slider-2'); ?></option>
						</select>
						
						<div class="clear"></div>
						
						<div class="field field-inline">
							<label for=""><?php _e('Transition Effects:', 'cyclone-slider-2'); ?></label>
							<select id="" class="cycloneslider_metas_fx" name="cycloneslider_metas[<?php echo esc_attr($i); ?>][fx]">
								<option value="default">Default</option>
								<?php foreach($effects as $value=>$name): ?>
								<option value="<?php echo esc_attr($value); ?>" <?php echo ($slide['fx']==$value) ? 'selected="selected"' : ''; ?>><?php echo esc_html($name); ?></option>
								<?php endforeach; ?>
							</select>
							<div class="clear"></div>
						</div>
						
						<div class="field field-inline">
							<label for=""><?php _e('Transition Effects Speed:', 'cyclone-slider-2'); ?></label>
							<input class="widefat cycloneslider-slide-meta-speed" name="cycloneslider_metas[<?php echo esc_attr($i); ?>][speed]" type="number" value="<?php echo esc_attr(@$slide['speed']); ?>" />
							<span class="note"> <?php _e('Milliseconds', 'cyclone-slider-2'); ?></span>
							<div class="clear"></div>
						</div>
						
						<div class="field field-inline">
							<label for=""><?php _e('Next Slide Delay:', 'cyclone-slider-2'); ?></label>
							<input class="widefat cycloneslider-slide-meta-timeout" name="cycloneslider_metas[<?php echo esc_attr($i); ?>][timeout]" type="number" value="<?php echo esc_attr(@$slide['timeout']); ?>" />
							<span class="note"> <?php _e('Milliseconds', 'cyclone-slider-2'); ?></span>
							<div class="clear"></div>
						</div>
						
						
						<div class="cycloneslider-slide-tile-properties">
							
							<div class="field field-inline">
								<label for=""><?php _e('Tile Count:', 'cyclone-slider-2'); ?></label>
								<input class="widefat cycloneslider-slide-meta-tile-count" name="cycloneslider_metas[<?php echo esc_attr($i); ?>][tile_count]" type="number" value="<?php echo esc_attr(@$slide['tile_count']); ?>" />
								<span class="note"> <?php _e('The number of tiles to use in the transition.', 'cyclone-slider-2'); ?></span>
								<div class="clear"></div>
							</div>
							<!--
							<label for=""><?php _e('Tile Delay:', 'cyclone-slider-2'); ?></label>
							<input class="widefat cycloneslider-slide-meta-tile-delay" name="cycloneslider_metas[<?php echo esc_attr($i); ?>][tile_delay]" type="text" value="<?php echo esc_attr(@$slide['tile_delay']); ?>" />
							<span class="note"> <?php _e('Milliseconds to delay each individual tile transition.', 'cyclone-slider-2'); ?></span>
							<div class="cycloneslider-spacer-15"></div>
							-->
							<div class="field field-inline">
								<label for=""><?php _e('Tile Position:', 'cyclone-slider-2'); ?></label>
								<select id="" name="cycloneslider_metas[<?php echo esc_attr($i); ?>][tile_vertical]">
									<option <?php echo ('true'==$slide['tile_vertical']) ? 'selected="selected"' : ''; ?> value="true"><?php _e('Vertical', 'cyclone-slider-2'); ?></option>
									<option <?php echo ('false'==$slide['tile_vertical']) ? 'selected="selected"' : ''; ?> value="false"><?php _e('Horizontal', 'cyclone-slider-2'); ?></option>
								</select>
								<div class="clear"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</div><!-- // end .cs-slide-image -->
		<div class="cs-slide-youtube">
			<div class="field">
				<label for="cs_youtube_url-<?php echo esc_attr($i); ?>" class="cs-changeling-id"><?php _e('YouTube URL:', 'cyclone-slider-2'); ?></label>
				<input id="cs_youtube_url-<?php echo esc_attr($i); ?>" type="text" class="widefat cs-changeling-id cs-youtube-url" name="cycloneslider_metas[<?php echo esc_attr($i); ?>][youtube_url]" value="<?php echo esc_attr($slide['youtube_url']); ?>" />
				<span class="note"><?php _e('Copy and paste a valid YouTube URL here.', 'cyclone-slider-2'); ?></span>
			</div>
			<div class="field field-normal last">
				<input type="hidden" name="cycloneslider_metas[<?php echo esc_attr($i); ?>][youtube_related]" value="false" />
				<input id="cs_youtube_related-<?php echo esc_attr($i); ?>" type="checkbox" class="widefat cs-changeling-id cs-youtube-related" name="cycloneslider_metas[<?php echo esc_attr($i); ?>][youtube_related]" value="true" <?php checked( $slide['youtube_related'], 'false' ); ?> />
				<label for="cs_youtube_related-<?php echo esc_attr($i); ?>" class="cs-changeling-id"><?php _e('Do not show suggested videos when the video finishes.', 'cyclone-slider-2'); ?></label>
			</div>
		</div><!-- // end .cs-slide-youtube -->
		<div class="cs-slide-vimeo">
			<div class="field last">
				<label for=""><?php _e('Vimeo URL:', 'cyclone-slider-2'); ?></label>
				<input type="text" class="widefat cs-vimeo-url" name="cycloneslider_metas[<?php echo esc_attr($i); ?>][vimeo_url]" value="<?php echo esc_attr($slide['vimeo_url']); ?>" />
				<span class="note"><?php _e('Copy and paste a valid Vimeo URL here.', 'cyclone-slider-2'); ?></span>
			</div>
		</div><!-- // end .cs-slide-vimeo -->
		<div class="cs-slide-custom">
			<div class="field last">
				<label for=""><?php _e('Custom HTML', 'cyclone-slider-2'); ?></label>
				<textarea class="widefat cs-custom-html" name="cycloneslider_metas[<?php echo esc_attr($i); ?>][custom]"><?php echo esc_textarea($slide['custom']); ?></textarea>
			</div>
		</div><!-- // end .cs-slide-custom -->
		
		<div class="cs-slide-testimonial">
			<div class="cs-testimonial-quote">
				<div class="field last">
					<label for=""><?php _e('Quote', 'cyclone-slider-2'); ?></label>
					<textarea class="widefat cs-testimonial" name="cycloneslider_metas[<?php echo esc_attr($i); ?>][testimonial]"><?php echo esc_textarea($slide['testimonial']); ?></textarea>
				</div>
			</div><!-- // end .cs-testimonial-quote -->
			<div class="cs-quote-properties">
				<div class="expandable-box">
					<div class="expandable-header first"><?php _e('Author', 'cyclone-slider-2'); ?></div>
					<div class="expandable-body">
						<div class="field last">
							<label for=""><?php _e('Name:', 'cyclone-slider-2'); ?></label> <br>
							<input class="widefat" name="cycloneslider_metas[<?php echo esc_attr($i); ?>][testimonial_author]" type="text" value="<?php echo esc_attr($slide['testimonial_author']); ?>" />
						</div>
					</div>
				</div>
				<div class="expandable-box last">
					<div class="expandable-header"><?php _e('Link', 'cyclone-slider-2'); ?></div>
					<div class="expandable-body">
						<div class="field">
							<label for=""><?php _e('Link URL:', 'cyclone-slider-2'); ?></label> <br>
							<input class="widefat" name="cycloneslider_metas[<?php echo esc_attr($i); ?>][testimonial_link]" type="text" value="<?php echo esc_url($slide['testimonial_link']); ?>" />
						</div>
						<div class="field last">
							<label for=""><?php _e('Open Link in:', 'cyclone-slider-2'); ?></label> <br>
							<select class="" id="" name="cycloneslider_metas[<?php echo esc_attr($i); ?>][testimonial_link_target]">
								<option <?php selected( $slide['testimonial_link_target'], '_self' ); ?> value="_self"><?php _e('Same Window', 'cyclone-slider-2'); ?></option>
								<option <?php selected( $slide['testimonial_link_target'], '_blank' ); ?> value="_blank"><?php _e('New Tab or Window', 'cyclone-slider-2'); ?></option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</div><!-- // end .cs-slide-testimonial -->
		<div class="clear"></div>
	</div>
</div>