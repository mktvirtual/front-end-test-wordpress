jQuery(document).ready(function($){
	
	// Add Color Picker to all inputs that have 'color-field' class
	
    $( 'input.has-colorpicker' ).wpColorPicker({
    	mode	: 'hsl',
    	width	: 275,
    });
	
});