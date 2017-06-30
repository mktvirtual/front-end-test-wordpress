<?php
add_action('add_meta_boxes', 'accesspress_store_add_sidebar_layout_box');
function accesspress_store_add_sidebar_layout_box(){    
    add_meta_box(
        'accesspress_store_sidebar_layout',
        'Sidebar Layout', 
        'accesspress_store_sidebar_layout_callback',
        'page', 
        'normal', 
        'high'
    ); 
}

$accesspress_store_sidebar_layout = array(
    'left-sidebar' => array(
        'value'     => 'left-sidebar',
        'label'     => __( 'Left sidebar', 'accesspress-store' ),
        'thumbnail' => get_template_directory_uri() . '/inc/images/left-sidebar.png'
    ), 
    'right-sidebar' => array(
        'value' => 'right-sidebar',
        'label' => __( 'Right sidebar<br/>(default)', 'accesspress-store' ),
        'thumbnail' => get_template_directory_uri() . '/inc/images/right-sidebar.png'
    ),
    'both-sidebar' => array(
        'value'     => 'both-sidebar',
        'label'     => __( 'Both Sidebar', 'accesspress-store' ),
        'thumbnail' => get_template_directory_uri() . '/inc/images/both-sidebar.png'
    ),
    'no-sidebar' => array(
        'value'     => 'no-sidebar',
        'label'     => __( 'No sidebar', 'accesspress-store' ),
        'thumbnail' => get_template_directory_uri() . '/inc/images/no-sidebar.png'
) );


function accesspress_store_sidebar_layout_callback() { 
    global $post , $accesspress_store_sidebar_layout;
    wp_nonce_field( basename( __FILE__ ), 'accesspress_store_sidebar_layout_nonce' ); ?>
    <table class="form-table">
        <tr>
            <td colspan="4"><em class="f13">Choose Sidebar Template</em></td>
        </tr>
        <tr>
            <td>
                <?php  
                foreach ($accesspress_store_sidebar_layout as $field) {  
                    $accesspress_store_sidebar_metalayout = get_post_meta( $post->ID, 'accesspress_store_sidebar_layout', true ); ?>

                    <div class="radio-image-wrapper" style="float:left; margin-right:30px;">
                        <label class="description">
                            <span><img src="<?php echo esc_url( $field['thumbnail'] ); ?>" alt="" /></span></br>
                            <input type="radio" name="accesspress_store_sidebar_layout" value="<?php echo $field['value']; ?>" <?php checked( $field['value'], $accesspress_store_sidebar_metalayout ); if(empty($accesspress_store_sidebar_metalayout) && $field['value']=='right-sidebar'){ echo "checked='checked'";} ?>/>&nbsp;<?php echo $field['label']; ?>
                        </label>
                    </div>
                <?php } // end foreach 
                ?>
                <div class="clear"></div>
            </td>
        </tr>
        <tr>
            <td><em class="f13"><?php _e('You can set up the sidebar content','accesspress-store'); ?> <a href="<?php echo admin_url('/customize.php'); ?>"><?php _e('here','accesspress-store'); ?></a></em></td>
        </tr>
    </table>
    <?php 
} 

/**
 * save the custom metabox data
 * @hooked to save_post hook
 */
function accesspress_store_save_sidebar_layout( $post_id ) { 
    global $accesspress_store_sidebar_layout, $post; 
    if ( !isset( $_POST[ 'accesspress_store_sidebar_layout_nonce' ] ) || !wp_verify_nonce( $_POST[ 'accesspress_store_sidebar_layout_nonce' ], basename( __FILE__ ) ) )
        return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE)  
        return;    
    if ('page' == $_POST['post_type']) {  
        if (!current_user_can( 'edit_page', $post_id ) )  
            return $post_id;  
    } elseif (!current_user_can( 'edit_post', $post_id ) ) {  
        return $post_id;  
    }  
    
    foreach ($accesspress_store_sidebar_layout as $field) {  
        $old = get_post_meta( $post_id, 'accesspress_store_sidebar_layout', true); 
        $new = sanitize_text_field($_POST['accesspress_store_sidebar_layout']);
        if ($new && $new != $old) {  
            update_post_meta($post_id, 'accesspress_store_sidebar_layout', $new);  
        } elseif ('' == $new && $old) {  
            delete_post_meta($post_id,'accesspress_store_sidebar_layout', $old);  
        } 
     }     
}
add_action('save_post', 'accesspress_store_save_sidebar_layout');