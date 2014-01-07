/*! nanoScrollerJS - v0.7.3 - (c) 2013 James Florentino; Licensed MIT */
!function(a,b,c){"use strict";var d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x;w={paneClass:"pane",sliderClass:"slider",contentClass:"content",iOSNativeScrolling:!1,preventPageScrolling:!1,disableResize:!1,alwaysVisible:!1,flashDelay:1500,sliderMinHeight:20,sliderMaxHeight:null,documentContext:null,windowContext:null},s="scrollbar",r="scroll",k="mousedown",l="mousemove",n="mousewheel",m="mouseup",q="resize",h="drag",u="up",p="panedown",f="DOMMouseScroll",g="down",v="wheel",i="keydown",j="keyup",t="touchmove",d="Microsoft Internet Explorer"===b.navigator.appName&&/msie 7./i.test(b.navigator.appVersion)&&b.ActiveXObject,e=null,x=function(){var a,b,d;return a=c.createElement("div"),b=a.style,b.position="absolute",b.width="100px",b.height="100px",b.overflow=r,b.top="-9999px",c.body.appendChild(a),d=a.offsetWidth-a.clientWidth,c.body.removeChild(a),d},o=function(){function i(d,f){this.el=d,this.options=f,e||(e=x()),this.$el=a(this.el),this.doc=a(this.options.documentContext||c),this.win=a(this.options.windowContext||b),this.$content=this.$el.children("."+f.contentClass),this.$content.attr("tabindex",this.options.tabIndex||0),this.content=this.$content[0],this.options.iOSNativeScrolling&&null!=this.el.style.WebkitOverflowScrolling?this.nativeScrolling():this.generate(),this.createEvents(),this.addEvents(),this.reset()}return i.prototype.preventScrolling=function(a,b){if(this.isActive)if(a.type===f)(b===g&&a.originalEvent.detail>0||b===u&&a.originalEvent.detail<0)&&a.preventDefault();else if(a.type===n){if(!a.originalEvent||!a.originalEvent.wheelDelta)return;(b===g&&a.originalEvent.wheelDelta<0||b===u&&a.originalEvent.wheelDelta>0)&&a.preventDefault()}},i.prototype.nativeScrolling=function(){this.$content.css({WebkitOverflowScrolling:"touch"}),this.iOSNativeScrolling=!0,this.isActive=!0},i.prototype.updateScrollValues=function(){var a;a=this.content,this.maxScrollTop=a.scrollHeight-a.clientHeight,this.prevScrollTop=this.contentScrollTop||0,this.contentScrollTop=a.scrollTop,this.iOSNativeScrolling||(this.maxSliderTop=this.paneHeight-this.sliderHeight,this.sliderTop=0===this.maxScrollTop?0:this.contentScrollTop*this.maxSliderTop/this.maxScrollTop)},i.prototype.createEvents=function(){var a=this;this.events={down:function(b){return a.isBeingDragged=!0,a.offsetY=b.pageY-a.slider.offset().top,a.pane.addClass("active"),a.doc.bind(l,a.events[h]).bind(m,a.events[u]),!1},drag:function(b){return a.sliderY=b.pageY-a.$el.offset().top-a.offsetY,a.scroll(),a.updateScrollValues(),a.contentScrollTop>=a.maxScrollTop&&a.prevScrollTop!==a.maxScrollTop?a.$el.trigger("scrollend"):0===a.contentScrollTop&&0!==a.prevScrollTop&&a.$el.trigger("scrolltop"),!1},up:function(){return a.isBeingDragged=!1,a.pane.removeClass("active"),a.doc.unbind(l,a.events[h]).unbind(m,a.events[u]),!1},resize:function(){a.reset()},panedown:function(b){return a.sliderY=(b.offsetY||b.originalEvent.layerY)-.5*a.sliderHeight,a.scroll(),a.events.down(b),!1},scroll:function(b){a.isBeingDragged||(a.updateScrollValues(),a.iOSNativeScrolling||(a.sliderY=a.sliderTop,a.slider.css({top:a.sliderTop})),null!=b&&(a.contentScrollTop>=a.maxScrollTop?(a.options.preventPageScrolling&&a.preventScrolling(b,g),a.prevScrollTop!==a.maxScrollTop&&a.$el.trigger("scrollend")):0===a.contentScrollTop&&(a.options.preventPageScrolling&&a.preventScrolling(b,u),0!==a.prevScrollTop&&a.$el.trigger("scrolltop"))))},wheel:function(b){var c;if(null!=b)return c=b.delta||b.wheelDelta||b.originalEvent&&b.originalEvent.wheelDelta||-b.detail||b.originalEvent&&-b.originalEvent.detail,c&&(a.sliderY+=-c/3),a.scroll(),!1}}},i.prototype.addEvents=function(){var a;this.removeEvents(),a=this.events,this.options.disableResize||this.win.bind(q,a[q]),this.iOSNativeScrolling||(this.slider.bind(k,a[g]),this.pane.bind(k,a[p]).bind(""+n+" "+f,a[v])),this.$content.bind(""+r+" "+n+" "+f+" "+t,a[r])},i.prototype.removeEvents=function(){var a;a=this.events,this.win.unbind(q,a[q]),this.iOSNativeScrolling||(this.slider.unbind(),this.pane.unbind()),this.$content.unbind(""+r+" "+n+" "+f+" "+t,a[r])},i.prototype.generate=function(){var a,b,c,d,f;return c=this.options,d=c.paneClass,f=c.sliderClass,a=c.contentClass,this.$el.find(""+d).length||this.$el.find(""+f).length||this.$el.append('<div class="'+d+'"><div class="'+f+'" /></div>'),this.pane=this.$el.children("."+d),this.slider=this.pane.find("."+f),e&&(b={right:-e},this.$el.addClass("has-scrollbar")),null!=b&&this.$content.css(b),this},i.prototype.restore=function(){this.stopped=!1,this.pane.show(),this.addEvents()},i.prototype.reset=function(){var a,b,c,f,g,h,i,j,k,l;return this.iOSNativeScrolling?(this.contentHeight=this.content.scrollHeight,void 0):(this.$el.find("."+this.options.paneClass).length||this.generate().stop(),this.stopped&&this.restore(),a=this.content,c=a.style,f=c.overflowY,d&&this.$content.css({height:this.$content.height()}),b=a.scrollHeight+e,k=parseInt(this.$el.css("max-height"),10),k>0&&(this.$el.height(""),this.$el.height(a.scrollHeight>k?k:a.scrollHeight)),h=this.pane.outerHeight(!1),j=parseInt(this.pane.css("top"),10),g=parseInt(this.pane.css("bottom"),10),i=h+j+g,l=Math.round(i/b*i),l<this.options.sliderMinHeight?l=this.options.sliderMinHeight:null!=this.options.sliderMaxHeight&&l>this.options.sliderMaxHeight&&(l=this.options.sliderMaxHeight),f===r&&c.overflowX!==r&&(l+=e),this.maxSliderTop=i-l,this.contentHeight=b,this.paneHeight=h,this.paneOuterHeight=i,this.sliderHeight=l,this.slider.height(l),this.events.scroll(),this.pane.show(),this.isActive=!0,a.scrollHeight===a.clientHeight||this.pane.outerHeight(!0)>=a.scrollHeight&&f!==r?(this.pane.hide(),this.isActive=!1):this.el.clientHeight===a.scrollHeight&&f===r?this.slider.hide():this.slider.show(),this.pane.css({opacity:this.options.alwaysVisible?1:"",visibility:this.options.alwaysVisible?"visible":""}),this)},i.prototype.scroll=function(){return this.isActive?(this.sliderY=Math.max(0,this.sliderY),this.sliderY=Math.min(this.maxSliderTop,this.sliderY),this.$content.scrollTop(-1*((this.paneHeight-this.contentHeight+e)*this.sliderY/this.maxSliderTop)),this.iOSNativeScrolling||this.slider.css({top:this.sliderY}),this):void 0},i.prototype.scrollBottom=function(a){return this.isActive?(this.reset(),this.$content.scrollTop(this.contentHeight-this.$content.height()-a).trigger(n),this):void 0},i.prototype.scrollTop=function(a){return this.isActive?(this.reset(),this.$content.scrollTop(+a).trigger(n),this):void 0},i.prototype.scrollTo=function(b){return this.isActive?(this.reset(),this.scrollTop(a(b).get(0).offsetTop),this):void 0},i.prototype.stop=function(){return this.stopped=!0,this.removeEvents(),this.pane.hide(),this},i.prototype.destroy=function(){return this.stopped||this.stop(),this.pane.length&&this.pane.remove(),d&&this.$content.height(""),this.$content.removeAttr("tabindex"),this.$el.hasClass("has-scrollbar")&&(this.$el.removeClass("has-scrollbar"),this.$content.css({right:""})),this},i.prototype.flash=function(){var a=this;if(this.isActive)return this.reset(),this.pane.addClass("flashed"),setTimeout(function(){a.pane.removeClass("flashed")},this.options.flashDelay),this},i}(),a.fn.nanoScroller=function(b){return this.each(function(){var c,d;if((d=this.nanoscroller)||(c=a.extend({},w,b),this.nanoscroller=d=new o(this,c)),b&&"object"==typeof b){if(a.extend(d.options,b),b.scrollBottom)return d.scrollBottom(b.scrollBottom);if(b.scrollTop)return d.scrollTop(b.scrollTop);if(b.scrollTo)return d.scrollTo(b.scrollTo);if("bottom"===b.scroll)return d.scrollBottom(0);if("top"===b.scroll)return d.scrollTop(0);if(b.scroll&&b.scroll instanceof a)return d.scrollTo(b.scroll);if(b.stop)return d.stop();if(b.destroy)return d.destroy();if(b.flash)return d.flash()}return d.reset()})}}(jQuery,window,document);



function bindNavigation(){
	$('a[data-toggle-postlist]').on('mouseenter', function(){
		var $this = $(this),
			$thisTarget = $this.attr('data-toggle-postlist');	
		
		$('a[data-toggle-postlist]').removeClass('active');
		$('[data-postlist]').not($thisTarget).hide();

		$this.addClass('active');
		$('[data-postlist="' + $thisTarget + '"]').show();
	
	});
	
	$('[data-postlist]').on('mouseenter', function(){		
		var button = $('a[data-toggle-postlist="' + $(this).attr('data-postlist') + '"]');
		
		if(!button.hasClass('active'))
			button.addClass('active');

	});

	$('header a.search_icon').on('click', function(e){
		var form = $('li#search_form');
		
		if( form.data('open') === false ) {
			openSearch(form);
		} else if ( form.data('open') === true ) {
			closeSearch(form);
		}

		form.find('input[type="text"]').one('blur', function(){
			closeSearch($('li#search_form'));
		});

		e.preventDefault();
		return false;

	});
	
	$('li.has-dropdown').on({
		mouseenter:function(){
			var $this = $(this),
				$firstPostlist = $this.find('[data-postlist]').first();
			
			$('li.has-dropdown').not($this).removeClass('active');
			$this.find('[data-postlist]').not($firstPostlist).hide();

			$this.addClass('active');
			
			$firstPostlist.show();
			$this.find('[data-toggle-postlist]').first().addClass('active');

			$('img.lazy').trigger('navOpen');
			
			// $this.find('div.dropdown').one('mouseleave', function(){
			// 	$this.removeClass('active');
			// });

			
		},
		mouseleave:function(){
			var $this = $(this);
			
			$this.removeClass('active');
			$this.find('*').removeClass('active');
			//$this.find('[data-toggle-postlist]').first().addClass('active');
		}
	});

}

function socialMedia(){
	var social = $('article.post-box');
	var shares = social.find('div.share').hide();

	
	social.on({
		mouseenter:function(){
			var $this = $(this);
			$this.find('.open-share').stop(true, true).fadeOut(150);
			$this.find('div.share').stop(true, true).fadeIn(150);
		},
		mouseleave:function(){
			var $this = $(this);
			$this.find('.open-share').stop(true, true).fadeIn(150);
			$this.find('div.share').stop(true, true).fadeOut(150);
		}
	})

}

function openSearch(form){
	form.data('open', true);
	form.stop().animate({'width':'180px'}, 100);
}

function closeSearch(form){
	form.data('open', false);
	form.stop().animate({'width':'0px'}, 100);
}



function sliderInit() {
	var carouselSlider = $('[data-carousel-slider]'),
		gallerySlider = $('[data-nexgen-slider]');

	/*** 
	 * check for carousels
	 */	
	if ( carouselSlider && gallerySlider ) {
		$(window).load(function() {
			carouselInit(carouselSlider);
			nexGenInit(gallerySlider);
		});
	} else {
		if (carouselSlider)
			$(window).load(carouselInit(carouselSlider));

		if(gallerySlider)
			$(window).load(nexGenInit(gallerySlider));
	}
	
}

function carouselInit(carousel) {
	var carouselSlider = carousel;

	carouselSlider.flexslider({
		animation: 'slide',
		animationLoop: false,
		itemWidth: 116,
		slideshow: false,
		itemMargin: 10,
		controlNav: false,
		useCSS: true,
	});

	carouselSlider.find('li a').hover( function(){
		$(this).find('.description').toggleClass('hide');
	});
}

function nexGenInit(gallery) {
	var gallerySlider = gallery;
	var captionTarget = $('div.slide-caption'),
		titleTarget = $('h3.slide-title');
		counterCurrent = $('[data-slide-number]');

	$('div.nano').nanoScroller();	
	
	var location = window.location.origin + '' + window.location.pathname;
	
	gallerySlider.flexslider({
		animation: "none",  
		slideshow: false,  
		animationSpeed:1,
		controlNav: false, 
		directionNav: true,             
		prevText: 'Prev',
		controlsContainer: ".gallery-controls",          
		start: function(slider){
			var slideInfo = $('.flex-active-slide div.hide');
			var text = $('.flex-active-slide div.hide [data-slide-caption]').text();
			
			titleTarget.text(slideInfo.find('[data-slide-title]').text());
			
			if (window.location.search.length > 1) {
				// get the image number
				// if its set
				var searchImage = window.location.search.split('=')[1];
			}

			//
			//
			//	check if there a specific image appended
			//
			//
			if(searchImage > 1 && searchImage <= slider.count && !isNaN(searchImage)) {
				//
				//	animate to specific image and push history to image
				//
				
				slider.flexAnimate(parseInt(searchImage - 1));
				counterCurrent.text('');
				counterCurrent.text(parseInt(slider.currentSlide));

				//
				//
				//
			} else {
				//
				//	set history to first image
				//
				
				counterCurrent.text('');
				counterCurrent.text(parseInt(slider.currentSlide) + 1);	
				
				//
				//
				//
			}

			if (text.length > 1) {
			
				captionTarget.show();
				captionTarget.text(text);
			
			} else {
			
				captionTarget.hide();
			
			}
			
			//
			//	set total number of slides
			//
			$('[data-total-slides]').text(slider.count);

		},           
		before: function(slider){},           
		after: function(slider){
			var slideInfo = $('.flex-active-slide div.hide');
			var text = $('.flex-active-slide div.hide [data-slide-caption]').text();
			
			var currentSlide = parseInt(slider.currentSlide) + 1;
			
			counterCurrent.text('');
			counterCurrent.text(currentSlide);

			titleTarget.text(slideInfo.find('[data-slide-title]').text());

			if (text.length > 1) {

				captionTarget.show();
				captionTarget.text(text);
			
			} else {
			
				captionTarget.hide();
			
			}
			
		
		},            
		end: function(){},             
		added: function(){},           
		removed: function(){} 
	});
}

function modalGallery() {

	var $modals = $('a.modal-image');

	if ($modals) {
		var term_link = $('[data-term-link]').attr('data-term-link');
		if (term_link) {
			term_link = '<a href="' + term_link + '" class="banner">Photo Galleries</a>';
		} else {
			var term_link = '';
		}

		$modals
	    .attr('rel', 'gallery')
	    .fancybox({
	    	type: 'image',
	        beforeShow: function () {
	        	// var h1 = $('#primary h1').first();

	         //    if (this.title) {
	         //        // New line
	         //        this.title += '<br />';
	         //        this.title += '<a href="' + h1.find('a').attr('href') + '">' + h1.text() + '</a>';
	         //        this.title += '<br />';
	          
	         //        //this.title += '<div class="share"><ul class="social-buttons buttons no-list cf"><li><a class="socialite twitter-share" href="http://twitter.com/share" rel="nofollow" target="_blank" data-text="' + /**/ + '" data-url="' + this.href + '" data-count="horizontal" data-via="GossipOnThis"><span class="vhidden">Share on Twitter</span></a></li><li><a class="socialite googleplus-one" href="https://plus.google.com/share?url=' + this.href + '" rel="nofollow" target="_blank" data-size="medium" data-href="' + this.href + '"><span class="vhidden">Share on Google+</span></a></li><li><a class="socialite facebook-like" href="https://www.facebook.com/sharer.php?u=' + /*encodeURIComponent($link)*/ + '&t=' + /*encodeURIComponent($post->post_title)*/ + '" rel="nofollow" target="_blank" data-href="' + this.href + '" data-send="false" data-layout="button_count" data-width="60" data-show-faces="false"><span class="vhidden">Share on Facebook</span></a></li><li><a class="socialite linkedin-share" href="http://www.linkedin.com/shareArticle?mini=true&url=' + /*encodeURIComponent($link)*/ + '&title=' + /*encodeURIComponent($post->post_title)*/ + '" rel="nofollow" target="_blank" data-url="' + this.href + '" data-counter="right" data-counter="horizontal"><span class="vhidden">Share on LinkedIn</span></a></li></ul></div>';

	         //    }
	        },
	        afterShow: function() {
	            //twttr.widgets.load();
	            //Socialite.load($(this).find('.social-buttons'));
	        },
	        helpers : {
	            title : {
	                type: 'inside'
	            }
	        },
	        padding:[0, 0, 0, 0],
	        tpl: {
	        	//<ul class="social-buttons buttons no-list cf"><li><a class="socialite twitter-share" href="http://twitter.com/share" rel="nofollow" target="_blank" data-text="' + /**/ + '" data-url="' + this.href + '" data-count="horizontal" data-via="GossipOnThis"><span class="vhidden">Share on Twitter</span></a></li><li><a class="socialite googleplus-one" href="https://plus.google.com/share?url=' + this.href + '" rel="nofollow" target="_blank" data-size="medium" data-href="' + this.href + '"><span class="vhidden">Share on Google+</span></a></li><li><a class="socialite facebook-like" href="https://www.facebook.com/sharer.php?u=' + /*encodeURIComponent($link)*/ + '&t=' + /*encodeURIComponent($post->post_title)*/ + '" rel="nofollow" target="_blank" data-href="' + this.href + '" data-send="false" data-layout="button_count" data-width="60" data-show-faces="false"><span class="vhidden">Share on Facebook</span></a></li><li><a class="socialite linkedin-share" href="http://www.linkedin.com/shareArticle?mini=true&url=' + /*encodeURIComponent($link)*/ + '&title=' + /*encodeURIComponent($post->post_title)*/ + '" rel="nofollow" target="_blank" data-url="' + this.href + '" data-counter="right" data-counter="horizontal"><span class="vhidden">Share on LinkedIn</span></a></li></ul>
	        	wrap     : '<div class="fancybox-wrap" tabIndex="-1"><div class="fancybox-skin"><div class="fancy-header"><h1><a href="' + $('#primary h1').first().find('a').attr('href') + '">' + $('#primary h1').first().text() + '</a></h1><br />' + term_link + '<div class="share"></div></div><div class="fancybox-outer"><div class="fancybox-inner"></div></div></div></div>',
	        },
	        nextEffect: 'none',
	        prevEffect: 'none',
	        wrapCSS:'GoT'
	    });

	}
}

function init(){
	$('li#search_form').data('open', false);
	bindNavigation();
	socialMedia();
	sliderInit();
	modalGallery();
	resizeYoutube();
	
}

function resizeYoutube() {
	var $allVideos = $("#primary, div.fit-vid");
	$allVideos.fitVids({
		customSelector: "iframe[src^='http://cdnapi.kaltura.com'], iframe[src^='http://v-vids.com'], iframe[src^='http://vodlocker.com'], iframe[src^='http://faststream.in'], iframe[src^='http://videomega.tv'], iframe[src^='http://media.mtvnservices.com']"
	});
}

function initMostPopularPost(most_popular){
	var tmpl  = '<ol class="no-list">{{#.}}';
		tmpl += '<li><article class="post-box cf">{{{img}}}{{{tag_html}}}{{{title}}}</article></li>';
		tmpl += '{{/.}}</ol>';

	var buttons = $("#hrn-selector [data-hot]"),
		target = $("div#popularpoststarget");

		(function(){
			target.html( Mustache.to_html( tmpl, most_popular.daily ) ).fadeIn(75);
		})();

		buttons.on("click", function(e){
			var $this 	= $(this),
				val 	= $this.attr("data-hot");
			
			buttons.removeClass('active');
			$this.addClass('active');	

			target.fadeOut(75, function(){

				if ( val === "daily" )
					target.html( Mustache.to_html( tmpl, most_popular.daily ) ).fadeIn(75);

				if ( val === "weekly" )
					target.html( Mustache.to_html( tmpl, most_popular.weekly ) ).fadeIn(75);

				if ( val === "monthly" )
					target.html( Mustache.to_html( tmpl, most_popular.monthly ) ).fadeIn(75);
			
			});

			e.preventDefault();
			return false;
			
		});
}

function socialWorth(templateDir, articles) {
	var $articleWithCount 	= articles,
		templateDir			= templateDir;

	$.each($articleWithCount, function(index, value) {
		var $this = $(this);

		$.getJSON(templateDir + '/external/socialworth.php', { url: $this.attr('data-permalink') }, function(data){
			$this.find('span[data-share-count]').text('<strong>' + data.count + '</strong> shares');
		});

	});
	
}


jQuery(document).ready(function($) {
	var headerHeight = $('header div.bg_h1_GoT').offset().top + $('header div.bg_h1_GoT').outerHeight(true),
		wst,
		navH1 = $('nav div.got'),
		navleft = $('nav ul.no-list.alignleft').first();

	init();

	$(window).on('scroll', function(){
		wst = $(this).scrollTop();
		if( wst >= headerHeight){
			navleft.stop().animate({ 'left':'78px'}, 50, function(){

			});
		} else if ( wst < headerHeight ) {
			navleft.stop().animate({'left':'0px'}, 50, function(){
			
			});
		}
	});

	$('div.social_media_dropdown').on({
		mouseenter:function(e){
			var dropdown = $('#single-social-dropdown');

			if( dropdown.css('display') === 'none' ) {
				dropdown.css('display','block');
				
			}
		},
		mouseleave: function(e) {
			var dropdown = $('#single-social-dropdown');
			dropdown.css('display','none');
		}
	});

	Socialite.process();

	initMostPopularPost(most_popular);

	$('#primary img.lazy').show().lazyload();
	$('nav img.lazy').lazyload({
		event: 'navOpen'
	});



});