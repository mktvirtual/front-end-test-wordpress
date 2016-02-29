<?php

//ativar as opcoes do menu no wordpress

add_theme_support('menus');

//registra um menu

function set_menu_areas()
{
	register_nav_menu('main-menu', 'Menu primário');	
}
//comando que inicia a funcao no wordpress (chama a funcão, faz funcionar)
add_action('init', 'set_menu_areas');

?>