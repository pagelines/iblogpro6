<?php
/*

	Section: iTabs
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: An easy way to create and configure responsive tabs.
	Class Name: iTabs
	Filter: component
*/


class iTabs extends PageLinesSection {


	function section_styles(){
		
		wp_enqueue_script( 'ResponsiveTabs', $this->base_url.'/responsiveTabs.min.js', array( 'jquery' ), pl_get_cache_key(), true );

	}

	function section_opts(){

		$options = array();

		$options[] = array(
			'key'		=> 'tabs_array',
	    	'type'		=> 'accordion', 
			'col'		=> 2,
			'title'		=> __('iTabs Setup', 'pagelines'), 
			'post_type' => __('iTab', 'pagelines'), 
			'opts'		=> array(
				array(
					'key'		=> 'title',
					'label'		=> __( 'Tab Title', 'pagelines' ),
					'type'		=> 'text'
				),
				array(
					'key'		=> 'content',
					'label' 	=> __( 'Tab Content', 'pagelines' ),
					'type'		=> 'textarea',
					'help'		=> __( 'Supports Text and HMTL', 'pagelines' )
				),
				array(
					'key'		=> 'class',
					'label'		=> __( 'Tab Class (Optional)', 'pagelines' ),
					'type'		=> 'text'
				),			

			)
	    );

		return $options;
	}

	function section_head(){ 

		?>
		
		<script>
		!function ($) {

			$(document).on('sectionStart', function( e ) {

		        RESPONSIVEUI.responsiveTabs();

			})

		}(window.jQuery); 
		</script>

	<?php }
	

   function section_template( ) {
	
		$tabs_array = $this->opt('tabs_array');
		
		if( !$tabs_array || $tabs_array == 'false' || !is_array($tabs_array) ){
			$tabs_array = array( array(), array(), array() );
		}
		
		$output = '';
		$count = 1; 
	
		
		if( is_array($tabs_array) ){
			
			$tabs = count( $tabs_array );
			
			foreach( $tabs_array as $tab ){
	
				$title = pl_array_get( 'title', $tab, 'Tab '. $count); 
				
				$content = pl_array_get( 'content', $tab, 'iTab Section: Tab '. $count); 
				
				$link = pl_array_get( 'link', $tab); 
				
				$user_class = pl_array_get( 'class', $tab);
				
				$title = sprintf('<h2 data-sync="tabs_array_tab%s_title">%s</h2>', $count, $title);

				$content = sprintf('<div data-sync="tabs_array_tab%s_content" class="%s">%s</div>',  $count, $user_class, $content);

				$output .= sprintf('%s %s', $title, $content);

				$count++;
			}
				
		}
		
		printf('
			<div class="itabs row">
				<div class="responsive-tabs">
		            	%s
		        </div>
			</div>', 
			$output
		);

	}	
}
