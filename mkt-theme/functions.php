<?php

    register_nav_menu( $location, $description);

    add_theme_support('post-thumbnails');

    if ( function_exists( 'add_image_size' ) ) {
        add_image_size( 'thumb-small', 400, 0, true );
        add_image_size( 'thumb-large', 620, 0, true );
    }

    function SingleCategory($excludeItem, $separatorItem) {

        $exclude = $excludeItem;
        //how do you want the list separated? just a space is okay
        $separator = $separatorItem;
        //don't edit below here!
        $new_the_category = '';
        foreach((get_the_category()) as $category){
        if (!in_array($category->cat_name, $exclude)) {
                $new_the_category .= '<a href="'.get_bloginfo(url).'/'.get_option('category_base').'/'.$category->slug.'">'.$category->name.'</a>'.$separator;
            }
        }
        echo substr($new_the_category, 0, strrpos($new_the_category, $separator));
    }
?>