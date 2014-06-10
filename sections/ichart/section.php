<?php
/*
	Section: iChart
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: Awesome animated stat bars used them to show stats or other information.
	Class Name: iChart
	Cloning: true
	Edition: pro
	Filter: post-format
*/

class iChart extends PageLinesSection {

	var $default_limit = 3;

	function section_styles(){

		wp_enqueue_script( 'ichart', $this->base_url.'/ichart.js', array( 'jquery' ), pl_get_cache_key(), true );

	}

	function section_opts(){

		$options = array();

		$options[] = array(

			'title' => __( 'iChart Configuration', 'pagelines' ),
			'type'	=> 'multi',
			'opts'	=> array(
				array(
					'key'			=> 'ichart_title',
					'type' 			=> 'text',
					'default'		=> 'iChart',
					'label' 	=> __( 'iChart Title (Optional)', 'pagelines' ),
				),

				array(
					'key'			=> 'ichart_total',
					'type' 			=> 'text',
					'default'		=> 100,
					'label' 		=> __( 'iChart Total Count (Number)', 'pagelines' ),
					'help' 			=> __( 'This number will be used to calculate the percent of the bar filled. The iChart values will be shown as a percentage of this value. Default is 100.', 'pagelines' ),
				),

				array(
					'key'			=> 'ichart_modifier',
					'type' 			=> 'text',
					'default'		=> '%',
					'label' 		=> __( 'iChart Modifier (Text Added to Stats)', 'pagelines' ),
					'help' 			=> __( 'This will be added to the stat number.', 'pagelines' ),
				),
				
				array(
					'key'			=> 'ichart_format',
					'type' 			=> 'select',
					'opts'		=> array(
						'append'		=> array( 'name' => 'Append Modifier (Default)' ),
						'prepend'	 	=> array( 'name' => 'Prepend Modifier' ),
					),
					'default'		=> 'append',
					'label' 	=> __( 'iChart Format', 'pagelines' ),
				),
			)

		);

		$options[] = array(
			'key'		=> 'bars_array',
	    	'type'		=> 'accordion', 
			'col'		=> 2,
			'title'		=> __('iChart Bars Setup', 'pagelines'), 
			'post_type'	=> __('Bar', 'pagelines'), 
			'opts'		=> array(
				array(
					'key'		=> 'bar_descriptor',
					'label'		=> __( 'Descriptor', 'pagelines' ),
					'type'		=> 'text'
				),
				array(
					'key'		=> 'bar_value',
					'label'		=> __( 'Value', 'pagelines' ),
					'type'		=> 'text'
				),	

			)
	    );

		return $options;
	}

	function section_template(  ) {


		$ichart_title = $this->opt('ichart_title');
		$the_title = ($ichart_title) ? sprintf('<h4>%s</h4>', $ichart_title) : '';


		$ichart_format = $this->opt('ichart_format');
		$format = ($ichart_format) ? $ichart_format : 'append';


		$ichart_mod = $this->opt('ichart_modifier');
		$mod = ($ichart_mod) ? $ichart_mod : '%';


		$bars_array = $this->opt('bars_array');

		if( !$bars_array || $bars_array == 'false' || !is_array($bars_array) ){
			$bars_array = array( array(), array(), array() );
		}

		$output = '';
	
		
		if( is_array($bars_array) ){
			
			$bars = count( $bars_array );
			
			foreach( $bars_array as $item ){

				$descriptor = pl_array_get( 'bar_descriptor', $item );

				$value = pl_array_get( 'bar_value', $item );

				$desc = ($descriptor) ? sprintf('<p>%s</p>', $descriptor) : '';

				$value = apply_filters('bar_value', $value, $item, $descriptor); 

				$ichart_total = (int) $this->opt('ichart_total', $item);
				
				$total = ($ichart_total) ? $ichart_total : 100;


				if(!$value)
				continue;

				if( is_int($total))
					$width = floor( $value / $total * 100 ) ;
				else
					$width = 0;


				$tag = ( $format == 'append' ) ? $value . $mod : $mod . $value;

				$total_tag = ( $format == 'append' ) ? $ichart_total . $mod : $mod . $ichart_total;

				$output .= sprintf(
					'<li><div class="bar-wrap pl-contrast"><span class="the-bar" data-width="%s"><strong>%s</strong></span></div>%s</li>',
					$width.'%',
					$tag,
					$desc
				);

				
			}
				
		}

		if($output == ''){
			$this->default_chart();
		} else
			printf('<div class="ichart-wrap">%s<ul class="ichart">%s</ul></div>', $the_title, $output);

	}


	function default_chart(){

		?>
		<div class="ichart-wrap">
			<ul class="ichart">
				
				<li>
					<div class="bar-wrap pl-contrast">
						<span class="the-bar" data-width="70%"><strong>70%</strong></span>
					</div>
					<p>Ninja Ability</p>
				</li>
				<li>
					<div class="bar-wrap pl-contrast">
						<span class="the-bar" data-width="90%"><strong>90%</strong></span>
					</div>
					<p>Tree Climbing Skills</p>
				</li>
				<li>
					<div class="bar-wrap pl-contrast">
						<span class="the-bar" data-width="80%"><strong>80%</strong></span>
					</div>
					<p>Surprise Attack Stealth</p>
				</li>
			</ul>
		</div>
		<?php
	}
}