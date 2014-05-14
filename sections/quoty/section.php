<?php
/*
	Section: Quoty
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: A flexible quote section. Can be customized with several transitions and a large number of quotes.
	Class Name: PLQuoty
	Filter: dual-width
*/


class PLQuoty extends PageLinesSection {

	var $default_limit = 3;

	function section_opts(){

		$options = array();

		$options[] = array(
			'title' 	=> __( 'Quoty Configuration', 'pagelines' ),
			'type'		=> 'multi',
			'key'		=> 'quoty_config',
			'post_type'	=> __('Quote', 'pagelines'), 
			'opts'		=> array(
					array(
						'key'		=> 'quoty_delay',
						'type' 		=> 'text',
						'default'	=> '9000',
						'label' 	=> __( 'Time Per Slide (in Seconds)', 'pagelines' ),
					),
				)
			);

		$options[] = array(
			'key'		=> 'quotes_array',
	    	'type'		=> 'accordion', 
			'col'		=> 2,
			'title'		=> __('Quotes Setup', 'pagelines'), 
			'post_type'	=> __('Quotes', 'pagelines'), 
			'opts'	=> array(
				array(
					'key'		=> 'quote',
					'label'		=> __( 'Author Quote', 'pagelines' ),
					'type'		=> 'text'
				),
				array(
					'key'		=> 'image',
					'label' 	=> __( 'Author Image (Optional)', 'pagelines' ),
					'type'		=> 'image_upload',
					'sizelimit'	=> 2097152 // 2M
				),
				array(
					'key'		=> 'name',
					'label'		=> __( 'Author Name', 'pagelines' ),
					'type'		=> 'text'
				),
				array(
					'key'		=> 'link',
					'label'		=> __( 'Author Link URL (Optional)', 'pagelines' ),
					'type'		=> 'text'
				),
				array(
					'key'		=> 'alignment',
					'label'		=> __( 'Alignment', 'pagelines' ),
					'type'		=> 'select',
					'opts'		=> array(
						'left-side'		=> array('name'=> 'Align Left'),
						'right-side'	=> array('name'=> 'Align Right'),
						'centered'		=> array('name'=> 'Centered'),
					)
				)
			)
	    );


		return $options;
	}

	function section_styles(){
		
		wp_enqueue_script( 'Modernizr', $this->base_url.'/modernizr.custom.js', array( 'jquery' ), PL_CORE_VERSION, true );
		
		wp_enqueue_script( 'QTRotator', $this->base_url.'/jquery.cbpQTRotator.min.js', array( 'jquery' ), PL_CORE_VERSION, true );


	}

	function section_head( ){

		?>	

		<script>
			jQuery( function() {

			jQuery( ".quoty" ).cbpQTRotator({
					speed : 900,
					easing : 'ease',
					interval : <?php if( $this->opt('quoty_delay')){
									echo ($this->opt('quoty_delay') * 1000 );
								} else {
								    echo '9000';
								} ?>
				});

			} );
		</script>

	<?php }

	function render_quotes(){

		$quotes_array = $this->opt('quotes_array');
		
		if( !$quotes_array || $quotes_array == 'false' || !is_array($quotes_array) ){
			$quotes_array = array( array(), array(), array(), array() );
		}
	
		$output = '';
		
		if( is_array($quotes_array) ){
			
			
			foreach( $quotes_array as $quote ){

				$the_quote = pl_array_get( 'quote', $quote );
				
				if( $the_quote ){
					
					$the_image = pl_array_get( 'image', $quote ); 
					
					$the_name = pl_array_get( 'name', $quote ); 
					
					$the_link = pl_array_get( 'link', $quote ); 

					$the_alignment = pl_array_get( 'alignment', $quote ); 

					$transition = pl_array_get( 'transition', $quote, 'fade' ); 
					
					if($the_location == 'centered'){
						$quote_class = 'centered';
					} elseif ($the_location == 'right-side'){
						$quote_class = 'right-side';
					} else {
						$quote_class = 'left-side';
					}

					$quote = sprintf('<p><span>&#147;</span>%s<span>&#148;</span></p>', $the_quote);
					
					$image = ($the_image) ? sprintf('<img src="%s" alt="%s" />', $the_image, $the_name) : '';
					
					$name = sprintf('<cite><a href="%s">%s</a></cite>', $the_link, $the_name);


					$output .= sprintf('
						<div class="item pl-inner">
							<blockquote class="%s">
							  %s %s
							  
							</blockquote>
							%s
						</div>', 
						$quote_class,
						$quote, 
						$image,
						$name
					);
				}
				
			
			}
		
		}
				
		
		return $output;
	}

	function default_quotes(){
		?>

				<div class="item pl-inner" >
					<blockquote>
					  <img src="<?php echo $this->base_url ?>/images/author.jpg" alt="Steve Jobs" />
					  <p>You can’t connect the dots looking forward; <br />you can only connect them looking backwards</p>
					  <cite><a href="http://pagelines.com">Steve Jobs</a></cite>
					</blockquote>
				</div>
				<div class="item pl-inner">
					<blockquote>
					  <img src="<?php echo $this->base_url ?>/images/author.jpg" alt="Steve Jobs" />
					  <p>Quality is much better than quantity. <br />One home run is much better than two doubles.</p>
					  <cite><a href="http://pagelines.com">PageLines</a></cite>
					</blockquote>
				</div>
				<div class="item pl-inner">
					<blockquote>
					  <img src="<?php echo $this->base_url ?>/images/author.jpg" alt="Steve Jobs" />
					  <p>Everyone here has the sense that right now is one of those moments when we are influencing the future.</p>
					  <cite><a href="http://pagelines.com">PageLines</a></cite>
					</blockquote>
				</div>
	

		<?php
	}

   function section_template( ) {


	?>
	
	</script>
	
		<div class="quoty">
				<?php

					$quotes = $this->render_quotes();

					if( $quotes == '' ){
						$this->default_quotes();
					} else {
						echo $quotes;
					}
				?>
		</div>
		<?php
	}


}