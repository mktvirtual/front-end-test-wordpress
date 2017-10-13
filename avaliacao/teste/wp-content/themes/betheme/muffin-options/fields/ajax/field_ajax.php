<?php
class MFN_Options_ajax extends MFN_Options{

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
		
		$action = isset( $this->field['action'] ) ? $this->field['action'] : '';
		$param 	= isset( $this->field['param'] ) ? $this->field['param'] : '';
		
		echo '<a href="javascript:void(0);" class="btn-blue mfn-opts-ajax" data-ajax="'. admin_url('admin-ajax.php') .'" data-action="'. $action .'" data-param="'. $param .'">'. __('Randomize', 'mfn-opts') .'</a>';
		
		echo ( isset($this->field['desc']) && ! empty($this->field['desc']) ) ? '<span class="description">'. $this->field['desc'] .'</span>' : '';
	}

	/**
	 * Enqueue Function.
	 */
	function enqueue(){
		
		wp_enqueue_script(
			'mfn-opts-field-ajax-js', 
			MFN_OPTIONS_URI.'fields/ajax/field_ajax.js', 
			array('jquery'),
			time(),
			true
		);
		
	}
}
