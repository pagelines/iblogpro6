!function ($) {
	$(window).load(function(){
	
		$('.islider-container').flexslider({
			
				namespace: "islider-",
				animation: "slide",
				slideshow: false,
				animationLoop: false,
				startAt: 1,
				directionNav: true,
				smoothHeight: true,
				controlNav: false,
				touch: true,
				prevText: 'Previous',
				nextText: 'Next',

	    });
	    
	})
}(window.jQuery);