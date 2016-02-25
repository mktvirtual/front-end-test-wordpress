
<?php echo $text_link_open; ?><img src="<?php echo wp_get_attachment_image_url( $image_id, 'full' ); ?>"></a>

<?php
	if ( ! empty( $title ) ) :
	echo '<div class="titulo" style="'.$text.'">'.$text_link_open.$title.$text_link_close.'</div>';
	endif;
	
	if ( ! empty( $link_text ) ) :
	echo '<button type="button" class="botao">'.$link_text.'</button>';
	/* background: url(<?php echo wp_get_attachment_image_url( $image_id, $image_size ); ?>) no-repeat center center; background-size: cover */
	endif;
?>