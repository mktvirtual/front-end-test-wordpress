<?php
/**
 * The template for displaying the tagline (both mobile and desktop one)
 */
?>
<span class="header-tagline <?php czr_fn_echo( 'element_class' ) ?>" <?php czr_fn_echo( 'element_attributes' ) ?>>
  <?php esc_attr_e( get_bloginfo( 'description' ) ) ?>
</span>

