!function ($) {
	$(window).load(function(){

	    $('.islider').flexslider({
	        animation: "fade",
	        slideshow: false,
	        fadeFirstSlide: true, 
	        animationLoop: true,
	        directionNav: true,
	        controlNav: false,  
	        //smoothHeight: true,
	        touch: true,
	        
	        after: function(slider) {
      			
      			console.log(slider)

      			var slide = slider.find('.flex-active-slide .content')

      			if( slide.hasClass('element-dark') )
      				slider.find('.flex-direction-nav').addClass('dark-nav')
      			else 
      				slider.find('.flex-direction-nav').removeClass('dark-nav')
    		}
	      });

	})
}(window.jQuery);