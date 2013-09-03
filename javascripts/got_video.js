$(function(){
	var videos = $('[data-video]');

	videos.on('click', function(){
		var $this = $(this),
			$thisHeight = $this.attr('data-height'),
			$thisWidth  = $this.attr('data-width'),
			$thisSrc	= $this.attr('data-src'),
			$thisVidType= $this.attr('data-video');

		$this.html('');

		$this.hide();

		$('[data-vide-container]').show();

		// switch ($thisVidType){
		// 	case 'youtube':
		// 			$('<iframe width="660" height="372" src="http://www.youtube.com/embed/' + $thisSrc + '?autoplay=1" frameborder="0" allowfullscreen></iframe>').appendTo($this);
		// 		break;
		// 	case 'worldstar':
		// 			$('<object width="660" height="372"><param name="movie" value="' + $thisSrc + '"><param name="allowFullScreen" value="true"></param><embed src="' + $thisSrc + '" type="application/x-shockwave-flash" allowFullscreen="true" width="640" height="372"></embed></object>').appendTo($this);
		// 		break;
		// 	case 'vevo':
		// 			$('<object width="660" height="372"><param name="movie" value="' + $thisSrc + '"></param><param name="wmode" value="transparent"></param><param name="bgcolor" value="#000000"></param><param name="allowFullScreen" value="true"></param><param name="allowScriptAccess" value="always"></param><embed src="' + $thisSrc + '" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="660" height="372" bgcolor="#000000" wmode="transparent"></embed></object>').appendTo($this);
		// 		break;
		// 	case 'dailymotion':
		// 			$('<iframe frameborder="0" width="660" height="372" src="' + $thisSrc + '"></iframe').appendTo($this);
		// 		break;
		// }

	});

});