<?php
class MFN_Options_checkbox extends MFN_Options{	
	
	/**
	 * Field Constructor.
	 */
	function __construct( $field = array(), $value ='', $parent = NULL ){		
		if( is_object($parent) ) parent::__construct($parent->sections, $parent->args, $parent->extra_tabs);
		$this->field = $field;
		$this->value = $value;	
	}
	
	/**
	 * Field Render Function.
	 */
	function render( $meta = false ){
		
		$class = ( isset( $this->field['class']) ) ? $this->field['class'] : '';
		$name  = ( ! $meta ) ? ( $this->args['opt_name'].'['.$this->field['id'].']' ) : $this->field['id'];

		if ( is_array ( $this->field[ 'options' ] ) ) {
			// Multi Checkboxes
			
			if ( ! isset( $this->value ) ) {
				$this->value = array();
			}
			
			if ( ! is_array( $this->value ) ){
				$this->value = array();
			}
			
			echo '<div class="mfnf-checkbox multi '. $class .'">';
			
				// FIX | Post Meta Save | All values unchecked
				echo '<input type="hidden" name="'. $name. '[post-meta]" value="1" checked="checked" />';
			
				echo '<ul>';
					foreach( $this->field['options'] as $k => $v ){
						
						if( ! key_exists( $k, $this->value ) ) $this->value[$k] = '';

						echo '<li>';
							echo '<label>';
								echo '<input type="checkbox" name="'. $name. '['.$k.']" value="'. $k .'" '. checked( $this->value[$k], $k, false ) .' />';
								echo '<span class="label">'. $v .'</span>';
							echo '</label>';
						echo '</li>';
	
					}
				echo '</ul>';
				
				if( isset( $this->field['desc'] ) && ! empty( $this->field['desc'] ) ) echo '<span class="description">'. $this->field['desc'] .'</span>';
			echo '</div>';
			
			
		} else {
			// Single Checkbox
			echo 'please use "switch" field for single checkbox';
		}
	}
	
	/**
	 * Enqueue Function.
	 */
	function enqueue(){
		wp_enqueue_script( 'mfn-opts-field-checkbox-js', MFN_OPTIONS_URI.'fields/checkbox/field_checkbox.js',  array('jquery'), time(), true );	
	}
	
}
