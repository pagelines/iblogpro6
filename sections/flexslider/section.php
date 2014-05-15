<?php
/*
	Section: FlexSlider
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: A professional and versatile slider section. 
	Class Name: plFlexSlider
	Filter: slider, full-width
*/


class plFlexSlider extends PageLinesSection {

	var $default_limit = 3;

	function section_opts(){

		$options = array();

		$options[] = array(

			'title' => __( 'Slider Configuration', 'pagelines' ),
			'type'	=> 'multi',
			'opts'	=> array(
				array(
					'key'			=> 'revslider_delay',
					'type' 			=> 'text_small',
					'default'		=> 12000,
					'label' 		=> __( 'Time Per Slide in Milliseconds (e.g. 12000)', 'pagelines' ),
				),
				array(
					'key'			=> 'revslider_height',
					'type' 			=> 'text_small',
					'default'		=> 500,
					'label' 		=> __( 'Slider Height in Pixels (e.g. 500)', 'pagelines' ),
				),
				array(
					'key'			=> 'revslider_fullscreen',
					'type' 			=> 'check',
					'label' 		=> __( 'Set to full window height? (Overrides height setting)', 'pagelines' ),
					'help' 			=> __( 'This option will set the slider to the height of the users browser window on load, it will also resize as needed.', 'pagelines' ),
				)
			)

		);

		$options[] = array(
			'key'		=> 'revslider_array',
	    	'type'		=> 'accordion', 
			'col'		=> 2,
			'title'		=> __('Slides Setup', 'pagelines'), 
			'post_type'	=> __('Slide', 'pagelines'), 
			'opts'	=> array(
				array(
					'key'		=> 'background',
					'label' 	=> __( 'Slide Background Image <span class="badge badge-mini badge-warning">REQUIRED</span>', 'pagelines' ),
					'type'		=> 'image_upload',
					'sizelimit'	=> 2097152, // 2M
					'help'		=> __( 'For high resolution, 2000px wide x 800px tall images. (2MB Limit)', 'pagelines' )
					
				),
				array(
					'key'	=> 'title',
					'label'	=> __( 'Slide Title', 'pagelines' ),
					'type'	=> 'text'
				),
				array(
					'key'	=> 'text',
					'label'	=> __( 'Slide Text', 'pagelines' ),
					'type'			=> 'text'
				),
				array(
					'key'			=> 'element_color',
					'label' 		=> __( 'Text', 'pagelines' ),
					'type'			=> 'select',
					'opts'	=> array(
						'element-light'	=> array('name'=> 'Light Text and Elements'),
						'element-dark'		=> array('name'=> 'Dark Text and Elements'),
					)
				),
				array(
					'key'	=> 'location',
					'label'	=> __( 'Slide Text Location', 'pagelines' ),
					'type'			=> 'select',
					'opts'	=> array(
						'left-side'	=> array('name'=> 'Text On Left'),
						'right-side'	=> array('name'=> 'Text On Right'),
						'centered'		=> array('name'=> 'Centered'),
					)
				),
				
				
				array(
					'key'	=> 'link',
					'label'	=> __( 'Primary Button', 'pagelines' ),
					'type'	=> 'button_link'
				),
				array(
					'key'	=> 'link_2',
					'label'	=> __( 'Secondary Button', 'pagelines' ),
					'type'	=> 'button_link'
				),
				
				array(
					'key'		=> 'video',
					'label' 	=> __( 'HTML5 Background Video', 'pagelines' ),
					'type'		=> 'media_select_video',
					
				),
				array(
					'key'		=> 'extra',
					'label'		=> __( 'Slide Extra Captions', 'pagelines' ),
					'type'		=> 'textarea',
					'ref'		=> __( 'Add extra Revolution Slider caption markup here. Rev slider is based on Revolution Slider, a jQuery plugin. It supports a wide array of functionality including video embeds and additional transitions if you can handle HTML. Check out the <a href="http://www.orbis-ingenieria.com/code/documentation/documentation.html" target="_blank">docs here</a>.', 'pagelines' )
				),
				

			)
	    );


		return $options;
	}

	
	function section_styles(){

		wp_enqueue_script( 'flexslider', $this->base_url.'/flexslider.js', array( 'jquery' ), pl_get_cache_key(), true );		
		//wp_enqueue_script( 'pagelines-slider', $this->base_url.'/pl.flex.js', array( 'jquery', 'flex' ), pl_get_cache_key(), true );
		
	}

   function section_template( ) {

	?>
	



		<div class="wrapper page-template-page-portfolio-slider-php">
					
		<div class="row content home-slider">
			
		</div>

		<div class="row slider">

			
			<script type="text/javascript">
				jQuery(document).ready(function($){
					jQuery('#slider-149').flexslider({
						namespace: "bean-",
						animation: "slide",
						slideshow: false,
						animationLoop: false,
						startAt: 1,
						directionNav: true,
						smoothHeight: true,
						controlNav: false,
						touch: true,
						prevText: "&larr;",
						nextText: "&rarr;",
					});
				});
			</script>

			<div class="post-slider">
				<div id="slider-149">
					<ul class="slides fadein">

						<li>
							<a title="Permanent Link to Esoteric Form" href=http://demo.themebeans.com/macho/portfolio/esoteric-form/><img width="1130" height="710" src="http://demo.themebeans.com/macho/wp-content/uploads/sites/19/2014/03/esoteric3-1130x710.jpg" class="attachment-port-full-slider" alt="Caption this image" /></a>
						</li>
						<li class="">
							<a title="Permanent Link to Fifty Five Cards" href=http://demo.themebeans.com/macho/portfolio/fifty-five-cards/><img width="1130" height="710" src="http://demo.themebeans.com/macho/wp-content/uploads/sites/19/2014/03/55cards-1-1130x710.jpg" class="attachment-port-full-slider" alt="55cards-1" /></a>
						</li>
						<li class="">
							<a title="Permanent Link to Numbers Poster" href=http://demo.themebeans.com/macho/portfolio/numbers-poster/><img width="1130" height="710" src="http://demo.themebeans.com/macho/wp-content/uploads/sites/19/2014/03/numbers2_14-1130x710.jpg" class="attachment-port-full-slider" alt="Add a caption to your image" /></a>
						</li>
						<li class="">
							<a title="Permanent Link to Harmony Day Stamps" href=http://demo.themebeans.com/macho/portfolio/harmony-day-stamps/><img width="1130" height="710" src="http://demo.themebeans.com/macho/wp-content/uploads/sites/19/2014/03/stamps1-1130x710.jpg" class="attachment-port-full-slider" alt="stamps1" /></a>
						</li>
						<li class="">
							<a title="Permanent Link to Cute Robots" href=http://demo.themebeans.com/macho/portfolio/cute-robots/><img width="1130" height="710" src="http://demo.themebeans.com/macho/wp-content/uploads/sites/19/2014/03/robot2-1130x710.jpg" class="attachment-port-full-slider" alt="robot2" /></a>
						</li>
						<li class="">
							<a title="Permanent Link to Brasilia Print" href=http://demo.themebeans.com/macho/portfolio/brasilia-print/><img width="1130" height="710" src="http://demo.themebeans.com/macho/wp-content/uploads/sites/19/2014/03/brasilia2-1130x710.jpg" class="attachment-port-full-slider" alt="brasilia2" /></a>
						</li>
						<li class="">
							<a title="Permanent Link to Foodwise Campaign" href=http://demo.themebeans.com/macho/portfolio/foodwise-campaign/><img width="1130" height="710" src="http://demo.themebeans.com/macho/wp-content/uploads/sites/19/2014/03/iphone21-1130x710.jpg" class="attachment-port-full-slider" alt="iphone2" /></a>
						</li>
						<li class="">
							<a title="Permanent Link to CA Collection 2014" href=http://demo.themebeans.com/macho/portfolio/ca-collection-2014/><img width="1130" height="710" src="http://demo.themebeans.com/macho/wp-content/uploads/sites/19/2014/03/ca51-1130x710.jpg" class="attachment-port-full-slider" alt="ca5" /></a>
						</li>
					</ul><!-- END .slides -->
				</div><!-- END #slider-$postid -->
			</div><!-- END .post-slider -->

			</div><!-- END .row .slider-->
		</div><!-- END .wrapper --> 
		
		



	<?php
	}


}