<?php
class MFN_Options_switch extends MFN_Options{	
	
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
		
		$class	= ( isset( $this->field['class']) ) ? 'class="'.$this->field['class'].'" ' : '';	
		$name	= ( ! $meta ) ? ( $this->args['opt_name'].'['.$this->field['id'].']' ) : $this->field['id'];
		
		echo '<div class="mfn-switch-field">';
		
			// fix for value "off = 0"
			if( ! $this->value ) $this->value = 0;
			// fix for WordPress 3.6 meta options
			if(strpos( $this->field['id'] ,'[]') === false) echo '<input type="hidden" name="'. $name .'" value="0" />';
			
			echo '<input type="checkbox" data-toggle="switch" id="'.$this->field['id'].'" name="'. $name .'" '.$class.' value="1" '.checked($this->value, 1, false).' />';
			
			if( isset($this->field['desc'] ) && ! empty( $this->field['desc'] ) ){
				echo '<span class="description btn-desc">'.$this->field['desc'].'</span>';
			}

		echo '</div>';
	}
	
	/**
	 * Enqueue Function.
	*/
	function enqueue(){		
		wp_enqueue_script( 'mfn-opts-field-switch-js', MFN_OPTIONS_URI.'fields/switch/field_switch.js', false, time(), true );
	}
	
}
