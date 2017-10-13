<?php
class MFN_Options_info extends MFN_Options{	
	
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
		if( key_exists('desc', $this->field) ){
			echo '<p class="mfn-field-info">'.$this->field['desc'].'</p>';
		}
	}
	
}
