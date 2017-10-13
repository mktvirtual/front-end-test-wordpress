<?php
class MFN_Validation_color extends MFN_Options{	
	
	/**
	 * Field Constructor.
	 */
	function __construct( $field, $value, $current ){	
		parent::__construct();
		$this->field = $field;
		$this->field['msg'] = ( isset( $this->field['msg'] ) ) ? $this->field['msg'] : __('This field must be a valid color value.', 'mfn-opts');
		$this->value = $value;
		$this->current = $current;
		$this->validate();	
	}
	
	/**
	 * Field Render Function.
	 */
	function validate(){
		
		if( ! is_array( $this->value ) ){
		
			if( $this->value[0] != '#' ){
				$this->value = ( isset( $this->current ) ) ? $this->current : '';
				$this->error = $this->field;
				return;
			}
			
			if( strlen( $this->value ) != 7 ){
				$this->value = ( isset ($this->current) ) ? $this->current : '';
				$this->error = $this->field;
			}
			
		}
			
		if( is_array( $this->value ) ){
			
			foreach( $this->value as $k => $value ){
				
				if( isset( $this->error ) ){
					continue;
				}
		
				if($value[0] != '#'){
					$this->value[$k] = ( isset( $this->current[$k] ) ) ? $this->current[$k] : '';
					$this->error = $this->field;
					continue;
				}
				
				if(strlen($value) != 7){
					$this->value[$k] = ( isset( $this->current[$k] ) ) ? $this->current[$k] : '';
					$this->error = $this->field;
				}
				
			}
			
		}

	}
	
}