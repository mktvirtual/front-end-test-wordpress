<?php if(!defined('ABSPATH')) die('Direct access denied.'); ?>

<div class="wrap">
    <div id="icon-tools" class="icon32"><br></div>
    
	<?php $this->render('export-import-tabs.php', array('tabs'=>$tabs)); ?>
	
	<h2><?php _e('Cyclone Slider Importer', 'cyclone-slider-2' ); ?></h2>
	
	<?php $this->render('error-message.php', array('error'=>$error)); ?>
	
	<?php $this->render('ok-message.php', array('ok'=>$ok)); ?>
	
	<br /><br />
	<a class="button" href="<?php echo esc_url($import_page_url); ?>"><?php _e('Back', 'cyclone-slider-2' ); ?></a>
</div>