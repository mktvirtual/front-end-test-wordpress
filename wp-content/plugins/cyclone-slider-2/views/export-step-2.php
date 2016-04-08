<?php if(!defined('ABSPATH')) die('Direct access denied.'); ?>

<div class="wrap">
    <div id="icon-tools" class="icon32"><br></div>
    
	<?php $this->render('export-import-tabs.php', array('tabs'=>$tabs)); ?>
	
    <h2><?php _e('Cyclone Slider Exporter', 'cyclone-slider-2'); ?></h2>
    
	<?php $this->render('error-message.php', array('error'=>$error)); ?>
	
	<form method="post" action="<?php echo esc_url( $export_page_url ); ?>">
		<input type="hidden" name="<?php echo esc_attr($nonce_name); ?>" value="<?php echo esc_attr($nonce); ?>" />
		<input type="hidden" name="cycloneslider_export_step" value="2" />
        <table class="form-table">
			<tr>
				<th><h4><?php _e('Selected slider(s):', 'cyclone-slider-2'); ?></h4></th>
				<td><?php if($page_data['sliders']): ?>
					<ul class="export-page-list ">
						<?php foreach($page_data['sliders'] as $slider): ?>
							<li><?php echo esc_html($slider); ?></li>
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<th><h4><?php _e('File Name:', 'cyclone-slider-2'); ?></h4></th>
				<td>
					<?php echo esc_attr( $page_data['file_name'] ); ?>
				</td>
			</tr>
        </table>
        <br /><br />
		<a class="button" href="<?php echo esc_url( $export_page_url ); ?>"><?php _e('Back', 'cyclone-slider-2'); ?></a>
        <?php submit_button( __('Generate Export File', 'cyclone-slider-2'), 'primary', 'submit', false) ?>
    </form>
</div>