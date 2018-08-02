<?php 
    // Habilita Thumbnails
    add_theme_support('post-thumbnails');

    // Ativando menu dinâmico
    function mainMenuRegister() {
        register_nav_menus (
            array (
                'navigation-menu' => __('Menu Principal')
            )
        );
    }

    add_action('init', 'mainMenuRegister');

    // Ativando Post Style Slider
    function sliderRegister() {
        $labels = array(
            'name' => _x( 'Slider', 'post type general name' ),
            'singular_name' => _x( 'Slider', 'post type general name' ),
            'add_new' => _x( 'Adicionar Slider', 'slider' ),
            'add_new_item' => __( 'Adicionar Slider' ),
            'edit_item' => __( 'Editar Slider' ),
            'new_item' => __( 'Novo Slider' ),
            'view_item' => __( 'Ver Slider' ),
            'search_items' => __( 'Pesquisar slider' ),
            'not_found' => __( 'Slider não encontrado' ),
            'not_found' => __( 'Nada encontrado no lixo' ),
            'parent_item_colon' => '',
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'public_queryable' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-media-code',
            'capability_type' => 'post',
            'hierarchical' => false,
            'menu_position' => 6,
            'supports' => array('title', 'thumbnail'),
        );
        
        register_post_type( 'slider', $args );
    }


    add_action('init', 'sliderRegister');

    // Ativando Post Style Promocoes
    function promotionsRegister() {
        $labels = array(
            'name' => _x( 'Promoções', 'post type general name' ),
            'singular_name' => _x( 'Promoção', 'post type general name' ),
            'add_new' => _x( 'Adicionar Promoção', 'Promoção' ),
            'add_new_item' => __( 'Adicionar Promoção' ),
            'edit_item' => __( 'Editar Promoção' ),
            'new_item' => __( 'Novo Promoção' ),
            'view_item' => __( 'Ver Promoção' ),
            'search_items' => __( 'Pesquisar Promoção' ),
            'not_found' => __( 'Promoção não encontrado' ),
            'not_found' => __( 'Nada encontrado no lixo' ),
            'parent_item_colon' => '',
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'public_queryable' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-media-code',
            'capability_type' => 'post',
            'hierarchical' => false,
            'menu_position' => 6,
            'supports' => array('title', 'editor', 'thumbnail', 'custom_fields'),
            'taxonomies' => array( 'category' ),
        );
        
        register_post_type( 'promocao', $args );
    }


    add_action('init', 'promotionsRegister');

?>