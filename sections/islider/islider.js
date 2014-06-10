!function ($) {
	$(window).load(function(){
	
		$('.islider-container').flexslider({
			
				namespace: "islider-",
				animation: "slide",
				//startAt: 0,
				//slideshow: false,
				fadeFirstSlide: true, 
				animationLoop: false,
				directionNav: true,
				smoothHeight: true,
				//controlNav: true,
				touch: true,

	    });

	})
}(window.jQuery);