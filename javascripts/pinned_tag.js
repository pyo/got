function returnSlugs(array){
	var slugs = array;
	console.log(slugs[0]);
	for (var i = 0; slugs.length > i; i++) {
		//console.log(slugs[i]);
		//if ( slugs[i].split(' ').length > 0 )
		//	console.log('true');

	//	slugs[i] = slugs[i].replace(' ', '-');
	};

	return slugs;
}

function populateDropDown($, vals, dropdown){
	var vals = vals,
		dropdown = dropdown;

	dropdown.html('');

	for (var i = vals.length - 1; i >= 0; i--) {
		dropdown.append($('<option></option>').val(vals[i]).html(vals[i].replace('-', ' ')));
	}
	
}

jQuery(document).ready(function($) {
	var dropdown = $('#_cmb_pinned_tags'),
		getSelected = function(){
			return dropdown.find('option').filter(':selected').val();
		},
		slugs = _.union(returnSlugs($('#tax-input-post_tag').val().split(', ')), [getSelected()]),
		tagList = $('div.tagchecklist'),
		tagListHTML = $('div.tagchecklist').html();

	function dropDownChange() {
		var theSelected = getSelected();

		/***
		 * repopulate dropdown with changed items
		 */
		populateDropDown($, _.union(returnNewTags(), returnSlugs([theSelected])), dropdown);
		
		/*** 
		 * keep original selected option selected
		 */
		dropdown.find('option').filter(function() { return $(this).val() === theSelected; }).attr('selected', true);

		/*** 
		 *  Save new taglist
		 */
		tagListHTML = $('div.tagchecklist').html();

	}

	/***
	 * populate initial list of tags
	 */ 
	//tagList.trigger('contentchanged');

	/***
	 * listen to content changed
	 */
	tagList.on('contentchanged', dropDownChange());

	/*** 
	 * check html to trigger event
	 */
	setInterval( function(){ 
		console.log($('div.tagchecklist').html());
		if( tagListHTML !== $('div.tagchecklist').html() )
			tagList.trigger('contentchanged');
	
	}, 750);

	/**
	 * get new tags from html
	 */
	function returnNewTags(){
		var tags = $('div.tagchecklist span'),
			newTags = [];

		tags.each(function(i){
			newTags[i] = $(this).text().slice(2);
		});

		return returnSlugs(newTags);

	}



});