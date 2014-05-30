!function ($) {
	$(window).load(function(){
	
		$('.islider-container').flexslider({
			
				namespace: "islider-",
				animation: "slide",
				startAt: 1,
				slideshow: true,
				animationLoop: false,
				directionNav: true,
				smoothHeight: true,
				controlNav: true,
				touch: true,

	    });
	    
	})
}(window.jQuery);