<?php
# MENU
	register_nav_menus( array(
	      'header' => __( 'Header Menu' ),
	      'banner' => __( 'Banner Menu' ),
	      'rodape_1' => __( 'Rodape Menu 1' ),
	      'rodape_2' => __( 'Rodape Menu 2' )

	));
	  
	 
	  
# WIDGETS  
	register_sidebar( array(
		'name' => 'Retangulo Esquerdo',
		'id' => 'wid_00',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	));
	register_sidebar( array(
		'name' => 'Quadro Superior Esquerdo',
		'id' => 'wid_01',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	));
	register_sidebar( array(
		'name' => 'Quadro Superior Direito',
		'id' => 'wid_02',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	));
	register_sidebar( array(
		'name' => 'Quadro Inferior Esquerdo',
		'id' => 'wid_03',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	));
	register_sidebar( array(
		'name' => 'Quadro Inferior Direito',
		'id' => 'wid_04',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	));
	register_sidebar( array(
		'name' => 'Mapa de Lojas',
		'id' => 'wid_mapa',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	));
 
 
 
?>