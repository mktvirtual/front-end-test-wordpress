<?php if(!defined('ABSPATH')) die('Direct access denied.'); ?>

<div class="wrap">
    <div id="icon-tools" class="icon32"><br></div>
    
    <?php $this->render('export-import-tabs.php', array('tabs'=>$tabs)); ?>
    
    <h2><?php _e('Cyclone Slider Exporter', 'cyclone-slider-2'); ?></h2>
	
	<?php $this->render('error-message.php', array('error'=>$error)); ?>
	
	<form method="post" action="<?php echo esc_url( $export_page_url ); ?>">
		<input type="hidden" name="<?php echo esc_attr($nonce_name); ?>" value="<?php echo esc_attr($nonce); ?>" />
		<input type="hidden" name="cycloneslider_export_step" value="1" />
        <?php if($sliders): ?>
            <table class="form-table">
                <tr>
                    <th><h4><?php _e('Select sliders:', 'cyclone-slider-2'); ?></h4></th>
                    <td>
                        <label for="cs-select-all">
                            <input type="checkbox" id="cs-select-all" name="<?php echo esc_attr( $transient_name ); ?>[all_sliders]" value="1" <?php checked($page_data['all_sliders'], 1); ?> />
                            <span><strong><?php _e('Select All', 'cyclone-slider-2'); ?></strong></span>
                        </label> <br />
                        <hr />
                        <?php foreach($sliders as $slider): ?>
                            <label for="cs-slider-<?php echo $slider['post_name']; ?>">
                                <input class="cs-sliders" type="checkbox" id="cs-slider-<?php echo esc_attr( $slider['post_name'] ); ?>" name="<?php echo esc_attr( $transient_name ); ?>[sliders][]" value="<?php echo esc_attr( $slider['post_name'] ); ?>" <?php echo ( in_array($slider['post_name'], $page_data['sliders']) ) ? 'checked="checked"' : '' ; ?> />
                                <span><em><?php echo esc_html($slider['post_title']); ?></em></span>
                            </label> <br />
                        <?php endforeach; ?>
                    </td>
                </tr>
				<tr>
					<th><label for="cs-file_name"><?php _e('File Name:', 'cyclone-slider-2'); ?></label></th>
					<td>
						<input type="text" class="regular-text" id="cs-file_name" name="<?php echo esc_attr( $transient_name ); ?>[file_name]" value="<?php echo esc_attr( $page_data['file_name'] ); ?>" />
					</td>
				</tr>
            </table>
        <?php else: ?>
			<p><?php _e('No slider to export.', 'cyclone-slider-2'); ?></p>
        <?php endif; ?>
        <br /><br />
        <?php submit_button( __('Clear', 'cyclone-slider-2'), 'secondary', 'reset', false) ?>
        <?php submit_button( __('Next', 'cyclone-slider-2'), 'primary', 'submit', false) ?>
    </form>
</div>