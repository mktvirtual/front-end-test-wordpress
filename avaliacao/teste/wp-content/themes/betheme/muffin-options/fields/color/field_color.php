<?php
class MFN_Options_color extends MFN_Options{	
	
	/**
	 * Constructor
	 */
	function __construct( $field = array(), $value ='', $parent = NULL ){
		
		if( is_object($parent) ){
			parent::__construct($parent->sections, $parent->args, $parent->extra_tabs);
		}
		
		$this->field = $field;
		$this->value = $value;
				
	}
	
	/**
	 * Render
	 */
	function render( $meta = false ){

		$class 	= ( isset( $this->field['class']) ) ? $this->field['class'] : 'regular-text';
		$name 	= ( ! $meta ) ? ( $this->args['opt_name'].'['.$this->field['id'].']' ) : $this->field['id'];
		$std 	= ( isset( $this->field['std'] ) ) ? $this->field['std'] : '';
		$value 	= ( $this->value ) ? $this->value : $std;
		
		echo '<div class="mfn-field-color">';
		
			echo '<input type="text" id="'. $this->field['id'] .'" name="'. $name .'" value="'. $value .'" class="'. $class .' has-colorpicker" />';
				
			if( isset( $this->field['desc'] ) && ! empty( $this->field['desc'] ) ){
				echo '<span class="description">'. $this->field['desc'] .'</span>';	
			}
			
		echo '</div>';
	}
	
	/**
	 * Enqueue
	 */
	function enqueue(){

		// Add the color picker css file
		wp_enqueue_style( 'wp-color-picker' );
		 
		// Include our custom jQuery file with WordPress Color Picker dependency
		wp_enqueue_script( 'mfn-opts-field-color-js', MFN_OPTIONS_URI .'fields/color/field_color.js', array( 'wp-color-picker' ), THEME_VERSION, true );
		
	}
	
}
