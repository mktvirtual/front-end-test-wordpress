<?php
class MFN_Options_upload extends MFN_Options{

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

		// class ----------------------------------------------------
		if( isset( $this->field['class']) ){
			$class = $this->field['class'];
		} else {
			$class = 'image';
		}
		
		// name -----------------------------------------------------
		if( $meta == 'new' ){
				
			// builder new
			$name = 'data-name="'. $this->field['id'] .'"';
				
		} elseif( $meta ){
				
			// page mata & builder existing items
			$name = 'name="'. $this->field['id'] .'"';
				
		} else {
				
			// theme options
			$name = 'name="'. $this->args['opt_name'] .'['. $this->field['id'] .']"';
		
		}
		
		// value is empty -------------------------------------------
		if( $this->value == '' ){
			$remove = 'style="display:none;"';
			$upload = '';
		} else {
			$remove = '';
			$upload = 'style="display:none;"';
		}
		
		// echo -----------------------------------------------------
		echo '<div class="mfn-upload-field">';
		
			echo '<input type="text" '. $name .' value="'. $this->value .'" class="'.$class.'" />';

			echo ' <a href="javascript:void(0);" data-choose="Choose a File" data-update="Select File" class="mfn-opts-upload" '. $upload .'><span></span>'. __('Browse', 'mfn-opts') .'</a>';
			echo ' <a href="javascript:void(0);" class="mfn-opts-upload-remove" '. $remove .'>'.__('Remove Upload', 'mfn-opts').'</a>';
			
			if( $class == 'image' ) echo '<img class="mfn-opts-screenshot '.$class.'" src="'.$this->value.'" />';
			
			if( isset($this->field['desc']) && !empty($this->field['desc']) ){
				echo '<span class="description '.$class.'">'. $this->field['desc'] .'</span>';	
			}
		
		echo '</div>';
	}

    /**
     * Enqueue
     */
    function enqueue() {
        
		wp_enqueue_script( 'mfn-opts-field-upload-js', MFN_OPTIONS_URI .'fields/upload/field_upload.js', array('jquery'), time(), true );
		wp_enqueue_media();

        wp_localize_script('mfn-opts-field-upload-js', 'mfn_upload', array('url' => $this->url.'fields/upload/blank.png'));
    }
}
