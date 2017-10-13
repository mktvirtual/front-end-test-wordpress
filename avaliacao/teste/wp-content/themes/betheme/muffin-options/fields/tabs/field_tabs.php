<?php
class MFN_Options_tabs extends MFN_Options{	
	
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

		// enqueue js fix
		if( $meta ) $this->enqueue();
		
		// name -----------------------------------------------------
		$name	= ( ! $meta ) ? ( $this->args['opt_name'].'['.$this->field['id'].']' ) : $this->field['id'];
		
		if( $meta == 'new' ){
				
			// builder new
			$field_prefix = 'data-';
					
		} else {
				
			// builder exist & theme options
			$field_prefix = '';
		
		}
		
		// echo -----------------------------------------------------
		$count 	= ( $this->value ) ? count( $this->value ) : 0;
		
		echo '<input type="hidden" '. $field_prefix .'name="'. $name .'[count][]" class="mfn-tabs-count" value="'. $count .'" />';
		
		echo '<a href="javascript:void(0);" class="btn-blue mfn-add-tab" rel-name="'. $name .'">'. __('Add tab','mfn-opts') .'</a>';
		echo '<br style="clear:both;" />';
		
		echo '<ul class="tabs-ul">';
			
			if( isset( $this->value ) && is_array( $this->value ) ){
				foreach( $this->value as $k => $value ){
					echo '<li>';
					
						echo '<label>'. __('Title','mfn-opts') .'</label>';
						echo '<input type="text" name="'. $name .'[title][]" value="'. htmlspecialchars(stripslashes($value['title'])) .'" />';
						
						echo '<label>'. __('Content','mfn-opts') .'</label>';
						echo '<textarea name="'. $name .'[content][]" value="" >'. esc_attr( $value['content'] ) .'</textarea>';
						
						echo '<a href="" class="mfn-btn-close mfn-remove-tab"><em>delete</em></a>';
						
					echo '</li>';
				}
			}
			
			// default tab to clone
			echo '<li class="tabs-default">';
			
				echo '<label>'. __('Title','mfn-opts') .'</label>';
				echo '<input type="text" name="" value="" />';
				
				echo '<label>'. __('Content','mfn-opts') .'</label>';
				echo '<textarea name="" value=""></textarea>';
				
				echo '<a href="" class="mfn-btn-close mfn-remove-tab"><em>delete</em></a>';
				
			echo '</li>';	
	
		echo '</ul>';

		if( isset($this->field['desc']) && !empty($this->field['desc']) ){
			echo ' <span class="description tabs-desc">'.$this->field['desc'].'</span>';
		}
	}
	
	/**
	 * Enqueue
	*/
	function enqueue(){
		wp_enqueue_script('mfn-opts-field-tabs-js', MFN_OPTIONS_URI.'fields/tabs/field_tabs.js', array('jquery'), time(), true);
	}
	
}
