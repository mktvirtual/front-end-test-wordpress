<?php
/**
 * Mega Menu classes.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */


/** --------------------------------------------------------------------------
 * Custom Mega Menu - Fields & Edit Function
 * --------------------------------------------------------------------------- */
class Mfn_MegaMenu {

	/* ---------------------------------------------------------------------------
	 * Custom Fields - Add
	 * --------------------------------------------------------------------------- */
	function mfn_setup_nav_menu_item( $menu_item ) {
		$menu_item->megamenu	= get_post_meta( $menu_item->ID, 'menu-item-mfn-megamenu', true );
		$menu_item->bg 			= get_post_meta( $menu_item->ID, 'menu-item-mfn-bg', true );
		return $menu_item;
	}
	
	/* ---------------------------------------------------------------------------
	 * Custom Fields - Save
	 * --------------------------------------------------------------------------- */
	function mfn_update_nav_menu_item( $menu_id, $menu_item_db_id, $menu_item_data ) {
		
		// mega menu
		if ( ! isset( $_REQUEST['edit-menu-item-megamenu'][$menu_item_db_id]) ) {
			$_REQUEST['edit-menu-item-megamenu'][$menu_item_db_id] = '';
		}
		$megamenu = $_REQUEST['edit-menu-item-megamenu'][$menu_item_db_id];
		update_post_meta( $menu_item_db_id, 'menu-item-mfn-megamenu', $megamenu );
		
		// background
		if ( ! isset( $_REQUEST['edit-menu-item-bg'][$menu_item_db_id]) ) {
			$_REQUEST['edit-menu-item-bg'][$menu_item_db_id] = '';
		}
		$bg = $_REQUEST['edit-menu-item-bg'][$menu_item_db_id];
		update_post_meta( $menu_item_db_id, 'menu-item-mfn-bg', $bg );
	}
	
	/* ---------------------------------------------------------------------------
	 * Custom Backend Walker - Edit
	 * --------------------------------------------------------------------------- */
	function mfn_edit_nav_menu_walker($walker,$menu_id) {
		return 'Walker_Nav_Menu_Edit_Mfn';
	}
	
	/* ---------------------------------------------------------------------------
	 * Constructor
	* --------------------------------------------------------------------------- */
	function __construct() {
		
		// Custom Fields - Add
		add_filter( 'wp_setup_nav_menu_item',  array( $this, 'mfn_setup_nav_menu_item' ) );
	
		// Custom Fields - Save
		add_action( 'wp_update_nav_menu_item', array( $this, 'mfn_update_nav_menu_item'), 100, 3 );
	
		// Custom Walker - Edit
		add_filter( 'wp_edit_nav_menu_walker', array( $this, 'mfn_edit_nav_menu_walker'), 100, 2 );
	}
	
}
new Mfn_MegaMenu();


/**
 * Create HTML list of nav menu input items.
 * Based on Walker_Nav_Menu_Edit class.
 */
class Walker_Nav_Menu_Edit_Mfn extends Walker_Nav_Menu {
	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker_Nav_Menu::start_lvl()
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see Walker_Nav_Menu::end_lvl()
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {}

	/**
	 * Start the element output.
	 *
	 * @see Walker_Nav_Menu::start_el()
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $_wp_nav_menu_max_depth;
		$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

		ob_start();
		$item_id = esc_attr( $item->ID );
		$removed_args = array(
			'action',
			'customlink-tab',
			'edit-menu-item',
			'menu-item',
			'page-tab',
			'_wpnonce',
		);

		$original_title = '';
		if ( 'taxonomy' == $item->type ) {
			$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
			if ( is_wp_error( $original_title ) )
				$original_title = false;
		} elseif ( 'post_type' == $item->type ) {
			$original_object = get_post( $item->object_id );
			$original_title = get_the_title( $original_object->ID );
		} elseif ( 'post_type_archive' == $item->type ) {
			$original_object = get_post_type_object( $item->object );
			if ( $original_object ) {
				$original_title = $original_object->labels->archives;
			}
		}

		$classes = array(
			'menu-item menu-item-depth-' . $depth,
			'menu-item-' . esc_attr( $item->object ),
			'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
		);

		$title = $item->title;

		if ( ! empty( $item->_invalid ) ) {
			$classes[] = 'menu-item-invalid';
			/* translators: %s: title of menu item which is invalid */
			$title = sprintf( __('%s (Invalid)','mfn-opts'), $item->title );
		} elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
			$classes[] = 'pending';
			/* translators: %s: title of menu item in draft status */
			$title = sprintf( __('%s (Pending)','mfn-opts'), $item->title );
		}

		$title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;

		$submenu_text = '';
		if ( 0 == $depth )
			$submenu_text = 'style="display: none;"';

		?>
		<li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode(' ', $classes ); ?>">
			<div class="menu-item-bar">
				<div class="menu-item-handle">
					<span class="item-title"><span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span class="is-submenu" <?php echo $submenu_text; ?>><?php _e( 'sub item','mfn-opts' ); ?></span></span>
					<span class="item-controls">
						<span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
						<span class="item-order hide-if-js">
							<a href="<?php
								echo wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'move-up-menu-item',
											'menu-item' => $item_id,
										),
										remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
									),
									'move-menu_item'
								);
							?>" class="item-move-up" aria-label="<?php esc_attr_e( 'Move up','mfn-opts' ) ?>">&#8593;</a>
							|
							<a href="<?php
								echo wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'move-down-menu-item',
											'menu-item' => $item_id,
										),
										remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
									),
									'move-menu_item'
								);
							?>" class="item-move-down" aria-label="<?php esc_attr_e( 'Move down','mfn-opts' ) ?>">&#8595;</a>
						</span>
						<a class="item-edit" id="edit-<?php echo $item_id; ?>" href="<?php
							echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
						?>" aria-label="<?php esc_attr_e( 'Edit menu item','mfn-opts' ); ?>"><?php _e( 'Edit','mfn-opts' ); ?></a>
					</span>
				</div>
			</div>

			<div class="menu-item-settings wp-clearfix" id="menu-item-settings-<?php echo $item_id; ?>">
				<?php if ( 'custom' == $item->type ) : ?>
					<p class="field-url description description-wide">
						<label for="edit-menu-item-url-<?php echo $item_id; ?>">
							<?php _e( 'URL','mfn-opts' ); ?><br />
							<input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
						</label>
					</p>
				<?php endif; ?>
				<p class="description description-wide">
					<label for="edit-menu-item-title-<?php echo $item_id; ?>">
						<?php _e( 'Navigation Label','mfn-opts' ); ?><br />
						<input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
					</label>
				</p>
				<p class="field-title-attribute field-attr-title description description-wide">
					<label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
						<?php _e( 'Title Attribute','mfn-opts' ); ?><br />
						<input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
					</label>
				</p>
				<p class="field-link-target description">
					<label for="edit-menu-item-target-<?php echo $item_id; ?>">
						<input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked( $item->target, '_blank' ); ?> />
						<?php _e( 'Open link in a new window/tab','mfn-opts' ); ?>
					</label>
				</p>
				<p class="field-css-classes description description-thin">
					<label for="edit-menu-item-classes-<?php echo $item_id; ?>">
						<?php _e( 'CSS Classes (optional)','mfn-opts' ); ?><br />
						<input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
					</label>
				</p>
				<p class="field-xfn description description-thin">
					<label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
						<?php _e( 'Link Relationship (XFN)','mfn-opts' ); ?><br />
						<input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
					</label>
				</p>
				<p class="field-description description description-wide">
				
					<?php 
						// default description fix
						if( ! $item->post_name ) $item->description = '';
					?>
				
					<label for="edit-menu-item-description-<?php echo $item_id; ?>">
						<?php _e( 'Description','mfn-opts' ); ?><br />
						<textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo $item->description; ?></textarea>
						<span class="description"><?php _e('The description will be displayed in the menu if the current theme supports it.','mfn-opts'); ?></span>
					</label>
				</p>
				
				<?php if ( 0 == $depth ): ?>
					<p class="field-mfn-megamenu description">
						<?php 
	                        $value = get_post_meta( $item_id, 'menu-item-mfn-megamenu', true);
	                        if( $value != "" ) $value = "checked='checked'";
	                    ?>
	                    <label for="edit-menu-item-megamenu-<?php echo $item_id; ?>">
	                        <?php _e( 'Mega Menu','mfn-opts' ); ?><br/>
	                        <input type="checkbox" value="enabled" id="edit-menu-item-megamenu-<?php echo $item_id; ?>" name="edit-menu-item-megamenu[<?php echo $item_id; ?>]" <?php echo $value; ?> />
	                        <?php _e( 'Activate Mega Menu','mfn-opts' ); ?>
	                    </label>
					</p>
					
					<p class="field-mfn-bg description description-wide">
						<label for="edit-menu-item-bg-<?php echo $item_id; ?>">
							<?php _e( 'Background Image URL','mfn-opts' ); ?><br />
							<input type="text" id="edit-menu-item-bg-<?php echo $item_id; ?>" class="widefat code edit-menu-item-bg" name="edit-menu-item-bg[<?php echo $item_id; ?>]" value="<?php echo get_post_meta( $item_id, 'menu-item-mfn-bg', true); ?>" />
							<span class="description"><?php _e('Backgrounds can be used for Megamenu Only','mfn-opts'); ?></span>
						</label>
					</p>
				<?php endif; ?>
				
				<?php 
					// Add this directly after the description paragraph in the start_el() method
					do_action( 'wp_nav_menu_item_custom_fields', $item_id, $item, $depth, $args );
					// end added section 
				?>

				<p class="field-move hide-if-no-js description description-wide">
					<label>
						<span><?php _e( 'Move','mfn-opts' ); ?></span>
						<a href="#" class="menus-move-up"><?php _e( 'Up one','mfn-opts' ); ?></a>
						<a href="#" class="menus-move-down"><?php _e( 'Down one','mfn-opts' ); ?></a>
						<a href="#" class="menus-move-left"></a>
						<a href="#" class="menus-move-right"></a>
						<a href="#" class="menus-move-top"><?php _e( 'To the top','mfn-opts' ); ?></a>
					</label>
				</p>

				<div class="menu-item-actions description-wide submitbox">
					<?php if( 'custom' != $item->type && $original_title !== false ) : ?>
						<p class="link-to-original">
							<?php printf( __('Original: %s','mfn-opts'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
						</p>
					<?php endif; ?>
					<a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
					echo wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'delete-menu-item',
								'menu-item' => $item_id,
							),
							admin_url( 'nav-menus.php' )
						),
						'delete-menu_item_' . $item_id
					); ?>"><?php _e( 'Remove','mfn-opts' ); ?></a> <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo $item_id; ?>" href="<?php echo esc_url( add_query_arg( array( 'edit-menu-item' => $item_id, 'cancel' => time() ), admin_url( 'nav-menus.php' ) ) );
						?>#menu-item-settings-<?php echo $item_id; ?>"><?php _e('Cancel','mfn-opts'); ?></a>
				</div>

				<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
				<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
				<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
				<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
				<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
				<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
			</div><!-- .menu-item-settings-->
			<ul class="menu-item-transport"></ul>
		<?php
		$output .= ob_get_clean();
	}
}


/**
 * Custom Frontend Main Menu Walker
 */
class Walker_Nav_Menu_Mfn extends Walker_Nav_Menu {

	// columns
	var $columns		= 0;
	var $max_columns	= 0;

	// rows
	var $rows			= 1;
	var $aRows			= array();

	// mega menu
	var $has_megamenu	= 0;
	var $bg_megamenu	= '';
    
	/**
	 * @see Walker::start_lvl()
	 */        
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"sub-menu{tag_ul_class}\"{tag_ul_style}>\n";
	}
    
	/**
	 * @see Walker::end_lvl()
	 */
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
		
		if( $depth === 0 )
		{
			if( $this->has_megamenu )
			{
				// mega menu background image
				if( $this->bg_megamenu ){

					$class	= ' mfn-megamenu-bg';
					$style	= ' style="background-image:url('. $this->bg_megamenu .');"';
					
					$output	= str_replace("{tag_ul_class}", " mfn-megamenu mfn-megamenu-".$this->max_columns . $class, $output);
					$output	= str_replace("{tag_ul_style}", $style, $output);	
					
				} else {

					$output = str_replace("{tag_ul_class}", " mfn-megamenu mfn-megamenu-".$this->max_columns, $output);
					$output = str_replace("{tag_ul_style}", "", $output);
					
				}

				foreach($this->aRows as $row => $columns){
					$output = str_replace("{tag_li_class_".$row."}", "mfn-megamenu-cols-".$columns, $output);
				}
					
				$this->columns		= 0;
				$this->max_columns	= 0;
				$this->aRows		= array();
			} 
			else
			{
				$output = str_replace("{tag_ul_class}", "", $output);
				$output = str_replace("{tag_ul_style}", "", $output);
			}
		}
	}    

	/**
	 * @see Walker::start_el()
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {   
		global $wp_query;

		$item_output = $li_text_block_class = $column_class = "";

		if( $depth === 0 ){  
			// 1st level --------------------------------------------
			$this->has_megamenu	= get_post_meta( $item->ID, 'menu-item-mfn-megamenu', true);
			$this->bg_megamenu	= get_post_meta( $item->ID, 'menu-item-mfn-bg', true);
		}
           
		if( $depth === 1 && $this->has_megamenu ){
     		// 2nd level Mega Menu ----------------------------------
			$this->columns ++;
			$this->aRows[$this->rows] = $this->columns;
			
			if($this->max_columns < $this->columns) $this->max_columns = $this->columns;

			if( $item->title != "-" )
			{
				$title = apply_filters( 'the_title', $item->title, $item->ID );
				
				$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
                $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
                $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
                $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';       
                
				$item_output .= $args->before;
					$item_output .= '<a class="mfn-megamenu-title"'. $attributes .'>';
						$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
					$item_output .= '</a>';
				$item_output .= $args->after;
			}
                
			$column_class = ' {tag_li_class_'.$this->rows.'}';
		} else {
			// 1-3 level, except Mega Menu 2nd level ----------------
			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
			
			$item_output .= $args->before;
				$item_output .= '<a'. $attributes .'>';
					$description =  trim($item->description) ? '<span class="description">'. $item->description .'</span>' : false;
					$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $description . $args->link_after;
				$item_output .= '</a>';
			$item_output .= $args->after;
		}
		
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$class_names = $value = '';
		
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="'. $li_text_block_class . esc_attr( $class_names ) . $column_class.'"';
		
		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

remove_filter('nav_menu_description', 'strip_tags');
add_filter( 'wp_setup_nav_menu_item', 'mfn_wp_setup_nav_menu_item' );
function mfn_wp_setup_nav_menu_item($menu_item) {
	$menu_item->description = apply_filters( 'nav_menu_description', $menu_item->post_content );
	return $menu_item;
}
