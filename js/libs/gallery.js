var gal = {
	
	config:{
		mainContainer: '.single-gallery .impression',
		picHolder: 'p'
	},
	
	init: function(){
		var gal = this,
		mContainer = $(gal.config.mainContainer);
		mContainer.wrapInner('<ul class="slides"/>');
		mContainer.find('.slides').before('<div id="controls" />');
		gal._wrapHolder();
	},
	
	_wrapHolder: function(){
		var gal = this,		  
		$main = $(gal.config.mainContainer),
		$pics = $main.find(gal.config.picHolder).find('img');
		
		$pics.each(function(i){
			var $pic = $(this),
			$parent  = $pic.parents('p');
			$descr   = $parent.next('p');
			
			if($descr.find('img').length == 0){
				$slide = $parent.add($descr);
				$slide.wrapAll('<li/>').wrapAll('<div/>');
				$descr.addClass('flex-caption');
			}
		});
		
		$(gal.config.mainContainer).flexslider(
			{
				controlsContainer: "#controls",
				prevText: "< zurück",
				nextText: "vor >",
				animation: "slide",
				controlNav: false,
				slideshow: false,
				slideToStart: 0
			}
		).fadeIn();
	},
}

