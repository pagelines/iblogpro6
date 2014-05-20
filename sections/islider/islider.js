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
				prevText: '<i class="icon icon-chevron-left"></i>',
				nextText: '<i class="icon icon-chevron-right"></i>',

	    });


		
	})
}(window.jQuery);