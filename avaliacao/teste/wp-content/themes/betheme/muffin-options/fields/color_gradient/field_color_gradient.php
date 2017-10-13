<?php
class MFN_Options_color_gradient extends MFN_Options{	
	
	/**
	 * Field Constructor.
	 */
	function __construct($field = array(), $value ='', $parent){
		parent::__construct($parent->sections, $parent->args, $parent->extra_tabs);
		$this->field = $field;
		$this->value = $value;		
	}

	
	/**
	 * Field Render Function
	 */
	function render(){
		
		$class = (isset($this->field['class']))?$this->field['class']:'';
		
		echo '<div class="farb-popup-wrapper" id="'.$this->field['id'].'">';
		
			echo '<fieldset>';
		
				echo '<input type="text" id="'.$this->field['id'].'-from" name="'.$this->args['opt_name'].'['.$this->field['id'].'][from]" value="'.$this->value['from'].'" class="'.$class.' popup-colorpicker"/>';
				echo '<div class="farb-popup"><div class="farb-popup-inside"><div id="'.$this->field['id'].'-frompicker" class="color-picker"></div></div></div>';
				echo '<div class="color-prev prev-'.$this->field['id'].'-from" style="background-color:'.$this->value['from'].';" rel="'.$this->field['id'].'-from"></div>';
				
				echo '<input type="text" id="'.$this->field['id'].'-to" name="'.$this->args['opt_name'].'['.$this->field['id'].'][to]" value="'.$this->value['to'].'" class="'.$class.' popup-colorpicker"/>';
				echo '<div class="farb-popup"><div class="farb-popup-inside"><div id="'.$this->field['id'].'-topicker" class="color-picker"></div></div></div>';
				echo '<div class="color-prev prev-'.$this->field['id'].'-to" style="background-color:'.$this->value['to'].';" rel="'.$this->field['id'].'-to"></div>';
				
			echo '</fieldset>';
			
			echo (isset($this->field['desc']) && !empty($this->field['desc']))?' <span class="description">'.$this->field['desc'].'</span>':'';

		echo '</div>';	
	}
	
	
	/**
	 * Enqueue Function
	 */
	function enqueue(){
		wp_enqueue_script( 'mfn-opts-field-color-js', MFN_OPTIONS_URI.'fields/color/field_color.js', array('jquery', 'farbtastic'), time(), true );	
	}
	
}
