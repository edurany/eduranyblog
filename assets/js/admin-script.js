function bl_open_uploader(element, class_name){

	$that = jQuery(element);
    wp.media.editor.send.attachment = function(props, attachment){

    	$that.prev().val(attachment.url);

    	jQuery('.'+class_name + ' > img').remove();
    	jQuery('.'+class_name).prepend('<img src="'+attachment.url+'" style="width:100%">');
    }

    wp.media.editor.open(this);

    return false;
}

jQuery(function($) {
	$('.cf-nav a').click(function(){
		$('.bl_status_show').hide();
	});
	$('.cf-nav a[href="#post-format-status"]').click(function(){
		console.log(tinyMCE.activeEditor.selection.getContent());
		if(tinyMCE.activeEditor.getContent() == ''){
			tinyMCE.activeEditor.selection.setContent('Status Post');
		}
		$('.bl_status_show').show();
	});
	if(!$('.cf-nav a[href="#post-format-status"]').hasClass('current')){
		$('.bl_status_show').hide();
	}

	function blu_featured_image_position(){
		$('#postimagediv').insertAfter('#titlediv').find('.inside').css('text-align','center');
	}
	blu_featured_image_position();

	// Post format changes
	blu_show_correct_format($('#post-formats-select input[name="post_format"]:checked').attr('value'));
	$('#post-formats-select input[name="post_format"]').change(function(){
		blu_show_correct_format($(this).attr('value'));
	});


	// add image
	function add_image_upload_function(){	
		$('.blu_image_upload .blu_add_image').click(function(e){

			e.preventDefault();
			var $image = $(this).parent().find('img'); 
			var $input = $(this).parent().find('.source');
			var $image_id = $(this).parent().find('.image_id');
		    wp.media.editor.send.attachment = function(props, attachment){
		    	$input.val(attachment.url);
		    	$image_id.val(attachment.id);
		    	$image.attr('src', attachment.url );
		    	$image.data('image-id', attachment.id );
		    	// console.log(attachment);
		    }
		    wp.media.editor.open(this);
		    return false;
		});
	}
	add_image_upload_function();
	// remove image
	$('.blu_image_upload .remove_image').click(function(e){
		e.preventDefault();

		if (confirm("Are you sure you want to delete the image?")) {
			var $image = $(this).parent().find('img'); 
			var $input = $(this).parent().find('input');

		    $input.val('');
		    $image.attr('src', $image.data('placeholder') );
		}
		return false;
	});



	$('.bl_add_field').click(function () {
		var field_count = $( this ).closest( 'fieldset' ).find('.array_item:last-child').attr('data-key');
		var field_name = $( this ).closest( 'fieldset' ).find('.array_item:last-child').attr('data-name');
		field_count++;
		console.log( field_count );
		var html = $( this ).closest( 'fieldset' ).find('.array_item:last-child').clone();
		$( html ).attr('data-key', field_count);
		$( html ).children('.blu_item').each(function(){
			$( this ).attr('name', field_name + '[' + field_count + '][' + $( this ).attr('data-arrayname') + ']').val('');
			// alert('one');
		})
		// $( html ).find('textarea').attr('name', field_name + '[' + field_count + '][' + $( html ).find('input').attr('data-arrayname') + ']').html('');
		$( this ).closest( 'fieldset' ).find('.array_item:last-child').after( html );
		add_image_upload_function();
	});

	$('.bl_add_field_complex').click(function () {
		var field_count = $( this ).closest( 'fieldset' ).find('.array_item:last-child').attr('data-key');
		var field_name = $( this ).closest( 'fieldset' ).find('.array_item:last-child').attr('data-name');
		var field_count_child = 0;
		field_count++;
		console.log( field_count );
		var html = $( this ).closest( 'fieldset' ).find('.array_item:last-child').clone();
		$( html ).attr('data-key', field_count);
		$( html ).children('.blu_item_title').attr('name', field_name + '[' + field_count + '][title]').val('');
		$( html ).children('.input_item_group').each(function(){
			$( this ).find('.blu_item').attr('name', field_name + '[' + field_count + '][item][' + field_count_child + ']').val('');
			field_count_child++;
			// alert('one');
		})
		// $( html ).find('textarea').attr('name', field_name + '[' + field_count + '][' + $( html ).find('input').attr('data-arrayname') + ']').html('');
		$( this ).closest( 'fieldset' ).find('.array_item:last-child').after( html );
		add_image_upload_function();
	});

	$('fieldset').on('click', '.close', function () {
		if (confirm("Are you sure you want to delete this item?")) {
			if($(this).closest('fieldset').find('.blu_image_upload').length > 1){
				$( this ).parent().remove();
			}else if($(this).closest('fieldset').find('.array_item').length > 1){
				$( this ).parent().remove();
			}else{
				$(this).parent().children('.blu_item').val(''); 
				$(this).parent().children('.blu_add_image').find('img').attr('src', ''); 
			}
		}
		return false;
	});

	$('.array_fieldset').on('click', '.bl_add_field_complex_child', function () {
		var $parent = $( this ).closest('.array_item');
		var $field_count = $( this ).prev('.input_item_group').find('.blu_item').data('key');
		var $parent_field_count = $parent.attr('data-key');

		var $field_name = $parent.attr('data-name');

		$field_count++;
		console.log($field_count);
		var html = $( this ).prev('.input_item_group').clone();
		$( html ).find('.blu_item').attr('data-key', $field_count);
		$( html ).find('.blu_item').attr('name', $field_name + '[' + $parent_field_count + '][item][' + $field_count + ']').val('');

		$(this).before( html );
		add_image_upload_function();
	});
	$('fieldset').on('click', '.close_item', function () {
		if( $( this ).closest('.array_item').find('.input_item_group').length > 1 ){
			$( this ).parent().remove();
		}
	});


	/*
		INSTAGRAM
	*/
	// remove cache
	$('.blu_empty_instagram_cache').click(function(e){
		e.preventDefault();
		$.ajax({  
            type: 'POST',  
            url: blu.ajaxurl,  
            data: {  
                action: 'blu_empty_instagram_cache',
            },  
            success: function(data, textStatus, XMLHttpRequest){  
            	alert('Cache deleted');
                // console.log('the-data' + data);
            },  
            error: function(MLHttpRequest, textStatus, errorThrown){  
                console.log(errorThrown);
            }  
        });
	});

});

function blu_show_correct_format(format){
	jQuery('#blu_format_quote').hide();
	jQuery('#blu_format_link').hide();
	jQuery('#blu_format_audio').hide();
	jQuery('#blu_format_gallery').hide();
	jQuery('#blu_format_video').hide();
	jQuery('#blu_format_status').hide();
	jQuery('#blu_format_'+format).show();
}