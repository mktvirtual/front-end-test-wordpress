<?php
class MFN_Options_sliderbar extends MFN_Options{	
	
	
	/**
	 * Field Constructor.
	 */
	function __construct($field = array(), $value ='', $parent){	
		parent::__construct($parent->sections, $parent->args, $parent->extra_tabs);
		$this->field = $field;
		$this->value = $value;	
	}

	
	/**
	 * Field Render Function.
	 */
	function render(){

		$class  = false;
		$param 	= isset( $this->field['param'] ) ? $this->field['param'] : '';
		
		$min 	= isset( $param['min'] ) ? $param['min'] : 1;
		$max 	= isset( $param['max'] ) ? $param['max'] : 100;
		
		
		// echo -----------------------------------------------------
		echo '<div class="mfn-slider-field clearfix">';
		
			echo '<div id="'.$this->field['id'].'_sliderbar" class="sliderbar" rel="'.$this->field['id'].'" data-min="'. $min .'" data-max="'. $max .'"></div>';
			
			echo '<input type="number" min="'. $min .'" max="'. $max .'" id="'.$this->field['id'].'" name="'.$this->args['opt_name'].'['.$this->field['id'].']" value="'.esc_attr($this->value).'" class="sliderbar_input '.$class.'"/>';	

			echo '<div class="range">'. $min .' - '. $max .'</div>';
			
			if( isset($this->field['desc']) && !empty($this->field['desc']) ){
				echo '<span class="description sliderbar_desc">'. $this->field['desc'] .'</span>';
			}
			
		echo '</div>';
		
	}
	
	
	/**
	 * Enqueue Function.
	 */
	function enqueue(){		
		wp_enqueue_style('mfn-opts-jquery-ui-css');		
		wp_enqueue_script( 'jquery-slider', MFN_OPTIONS_URI.'fields/sliderbar/jquery.ui.slider.js', array('jquery', 'jquery-ui-core', 'jquery-ui-slider'), time(), true );
		wp_enqueue_script( 'mfn-opts-field-sliderbar-js', MFN_OPTIONS_URI.'fields/sliderbar/field_sliderbar.js', array('jquery', 'jquery-ui-core', 'jquery-ui-dialog'), time(), true );
	}
}
