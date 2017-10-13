<?php
class MFN_Options_radio_img extends MFN_Options{	
	
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
		
		$class = ( isset( $this->field['class'])) ? 'class="'.$this->field['class'].'" ' : '';
		$name = ( ! $meta ) ? ( $this->args['opt_name'].'['.$this->field['id'].']' ) : $this->field['id'];
		
		echo '<fieldset '.$class.'>';
			foreach($this->field['options'] as $k => $v){
				echo '<div class="mfn-radio-item">';
					$selected = (checked($this->value, $k, false) != '')?' mfn-radio-img-selected':'';
					echo '<label class="mfn-radio-img'.$selected.' mfn-radio-img-'.$this->field['id'].'" for="'.$this->field['id'].'_'.array_search($k,array_keys($this->field['options'])).'">';
						echo '<input type="radio" id="'.$this->field['id'].'_'.array_search($k,array_keys($this->field['options'])).'" name="'. $name . '" value="'.$k.'" '.checked($this->value, $k, false).'/>';
						echo '<img src="'.$v['img'].'" alt="'.$v['title'].'" />';
					echo '</label>';
					echo '<span class="description">'.$v['title'].'</span>';
				echo '</div>';
			}
			echo (isset($this->field['desc']) && !empty($this->field['desc']))?'<br style="clear:both;"/><span class="description">'.$this->field['desc'].'</span>':'';
		echo '</fieldset>';
		
	}
	
	/**
	 * Enqueue Function.
	*/
	function enqueue(){	
		wp_enqueue_script('mfn-opts-field-radio_img-js', MFN_OPTIONS_URI.'fields/radio_img/field_radio_img.js', array('jquery'),time(),true);	
	}
	
}
