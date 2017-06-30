jQuery(document).ready(function($) {

    /**
     * Icon Services Custom Js
    */
    $(document).on('click', '.ap-font-group li', function(){
       	$('.ap-font-group li').removeClass();
        $(this).addClass('selected');
        var aa = $(this).parents('#ap-font-awesome-list').find('.ap-font-group li.selected').children('i').attr('class');
    	$(this).parents('#ap-font-awesome-list').siblings('p').find('.hidden-icon-input').val(aa);
    	$(this).parents('#ap-font-awesome-list').siblings('p').find('.icon-receiver').html('<i class="'+aa+'"></i>');
        return false;
    });
    

    /**
     * 
    */
    $('.switch_options').each(function() {
        //This object
        var obj = $(this);
        var enb = obj.children('.switch_enable'); //cache first element, this is equal to ON
        var dsb = obj.children('.switch_disable'); //cache first element, this is equal to OFF
        var input = obj.children('input'); //cache the element where we must set the value
        var input_val = obj.children('input').val(); //cache the element where we must set the value

        /* Check selected */
        if (0 == input_val) {
            dsb.addClass('selected');
        }
        else if (1 == input_val) {
            enb.addClass('selected');
        }

        //Action on user's click(ON)
        enb.on('click', function() {
            $(dsb).removeClass('selected'); //remove "selected" from other elements in this object class(OFF)
            $(this).addClass('selected'); //add "selected" to the element which was just clicked in this object class(ON) 
            $(input).val(1).change(); //Finally change the value to 1
        });

        //Action on user's click(OFF)
        dsb.on('click', function() {
            $(enb).removeClass('selected'); //remove "selected" from other elements in this object class(ON)
            $(this).addClass('selected'); //add "selected" to the element which was just clicked in this object class(OFF) 
            $(input).val(0).change(); // //Finally change the value to 0
        });

    });

    
    /**
     * Widget Area Image Uplaod Function
    */
    var optionsframework_upload;
    var optionsframework_selector;
    function optionsframework_add_file(event, selector) {
        var upload = $(".uploaded-file"), frame;
        var $el = $(this);
        optionsframework_selector = selector;
        event.preventDefault();
        if ( optionsframework_upload ) {
            optionsframework_upload.open();
        } else {
            optionsframework_upload = wp.media.frames.optionsframework_upload =  wp.media({
                title: $el.data('choose'),
                button: {
                    text: $el.data('update'),
                    close: false
                }
            });
            optionsframework_upload.on( 'select', function() {
                // Grab the selected attachment.
                var attachment = optionsframework_upload.state().get('selection').first();
                optionsframework_upload.close();
                optionsframework_selector.find('.upload').val(attachment.attributes.url);
                if ( attachment.attributes.type == 'image' ) {
                    optionsframework_selector.find('.screenshot').empty().hide().append('<img src="' + attachment.attributes.url + '"><a class="remove-image">Remove</a>').slideDown('fast');
                }
                optionsframework_selector.find('.upload-button-wdgt').unbind().addClass('remove-file').removeClass('upload-button-wdgt').val(accesspress_store_l10n.remove);
                optionsframework_selector.find('.of-background-properties').slideDown();
                optionsframework_selector.find('.remove-image, .remove-file').on('click', function() {
                    optionsframework_remove_file( $(this).parents('.section') );
                });
            });
        }
        optionsframework_upload.open();
    }

    function optionsframework_remove_file(selector) {
        selector.find('.remove-image').hide();
        selector.find('.upload').val('');
        selector.find('.of-background-properties').hide();
        selector.find('.screenshot').slideUp();
        selector.find('.remove-file').unbind().addClass('upload-button-wdgt').removeClass('remove-file').val(accesspress_store_l10n.upload);
        if ( $('.section-upload .upload-notice').length > 0 ) {
            $('.upload-button-wdgt').remove();
        }
        selector.find('.upload-button-wdgt').on('click', function(event) {
            optionsframework_add_file(event, $(this).parents('.section'));
            
        });
    }

    $('.remove-image, .remove-file').on('click', function() {
        optionsframework_remove_file( $(this).parents('.section') );
    });

    $(document).on('click', '.upload-button-wdgt', function( event ) {
        optionsframework_add_file(event, $(this).parents('.section'));
    });

});