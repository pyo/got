jQuery(document).ready(function($) {
	//
	//	get the formats checkboxes
	//
	var formats = $('#post_meta_box select#got_format');

	function hideBoxes() {
		$('#modal_gallery_field').hide();
		$('#video_field').hide();
		$('#modal_gallery_field').hide();
		$('#list_field').hide();
	}

	hideBoxes();
	

	var currentVal = formats.val();

	if(currentVal !== null && currentVal !== undefined && currentVal.length > 1) {
		currentVal = currentVal.split('-').join('_');
		var lastIndex = currentVal.lastIndexOf('format');
		currentVal = currentVal.substr(0, lastIndex);
		$('#' + currentVal + 'field').show();
	}



	formats.on('change', function(e){
		var val = $(this).val();

		hideBoxes();
		
		if(val !== null && val !== undefined && val.length > 1) {
			val = val.split('-').join('_');
			var lastIndex = val.lastIndexOf('format');
			val = val.substr(0, lastIndex);
			$('#' + val + 'field').show();
		}
		

	});

	//
	//	check if the box is checked
	//
	// function getCheckedVal(box){
	// 	var box = box;
	// 	return box.attr('checked');
	// }

	// //
	// //	show the fields if they are checked
	// //
	// function showFields(val, field){
	// 	var val = val,
	// 		field = field;

	// 	if (field.css('display') === 'none' && val === 'checked'){
	// 		field.css('display', 'block');
	// 	} else if (field.css('display') == 'block' && val === undefined){
	// 		field.css('display', 'none');
	// 	}
	// }	
	
	//
	//	init and bind change
	//



	// $.each(formats, function(){
	// 	var $this = $(this),
	// 		$thisField = $('#' + $this.parents('label').text().toLowerCase().split('-').join('_').substr(1) + '_field');

	// 	if ( $thisField.length >= 1 ) {
			
	// 		showFields(getCheckedVal($this), $thisField);

	// 		$this.on('change', function(){
	// 			showFields(getCheckedVal($this), $thisField);
	// 		});
		
	// 	}

	// });

});