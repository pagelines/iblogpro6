<?php
/*
	Section: SuperTabs
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: An easy way to create and configure different tab types (Vertical, Horizontal and Accordion).
	Class Name: PLSuperTabs
	Filter: dual-width
	Loading: active
*/


class PLSuperTabs extends PageLinesSection {

	var $default_limit = 3;

	function section_opts(){

		$options = array();

		$options[] = array(

			'title' => __( 'SuperTabs Configuration', 'pagelines' ),
			'key'	=> 'tabs_config',
			'type'	=> 'multi',
			'opts'	=> array(
				array(
					'type' 		=> 'select',
					'key'		=> 'tabs_type',
					'label' 	=> 'Tabs Type',
					'opts'		=> array(
						'default'	=> array('name' => 'Horizontal (Default)'),
						'vertical'	=> array('name' => 'Vertical'),
						'accordion'	=> array('name' => 'Accordion'),
					),
					'default'	=> 'default'
				),
			)

		);

		$options[] = array(
			'key'		=> 'tabs_array',
	    	'type'		=> 'accordion', 
			'col'		=> 2,
			'title'		=> __('Tabs Setup', 'pagelines'), 
			'post_type'	=> __('Tab', 'pagelines'), 
			'opts'		=> array(
				array(
					'key'		=> 'title',
					'label'		=> __( 'Tab Title', 'pagelines' ),
					'type'		=> 'text'
				),
				array(
					'key'		=> 'content',
					'label' 	=> __( 'Tab Content (HTML)', 'pagelines' ),
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

					$('<?php echo $this->prefix(); ?> #default').easyResponsiveTabs({
			            type: 'default', //default, vertical, accordion;
		                width: 'auto',
		                fit: true,
		                closed: true,
			        });

					$('<?php echo $this->prefix(); ?> #vertical').easyResponsiveTabs({
			            type: 'vertical', 
		                width: 'auto',
		                fit: true,
		                closed: false,
			        });

					$('<?php echo $this->prefix(); ?> #accordion').easyResponsiveTabs({
			            type: 'accordion', 
		                width: 'auto',
		                fit: true,
		                closed: false,
			        });

				})
			}(window.jQuery); 

		</script>
		
		
	<?php }
	

	function section_styles(){
		
		wp_enqueue_script( 'ResponsiveTabs', $this->base_url.'/easyResponsiveTabs.js',  true );

	}

	

   function section_template( ) {
	
		$tabs_array = $this->opt('tabs_array');
		
		if( !$tabs_array || $tabs_array == 'false' || !is_array($tabs_array) ){
			$tabs_array = array( array(), array(), array() );
		}

		
		$width = 0;
		$content_out = '';
		$output = '';
		$count = 1; 
	
		
		if( is_array($tabs_array) ){
			
			$boxes = count( $tabs_array );
			
			foreach( $tabs_array as $item ){
	
				$title = pl_array_get( 'title', $item, 'Tab '. $count); 
				$content = pl_array_get( 'content', $item, 'Content for tab '. $count); 
				$link = pl_array_get( 'link', $item ); 
				$user_class = pl_array_get( 'class', $item );
				
	
				
				$title = sprintf('<span data-sync="tabs_array_item%s_title">%s</span>', $count, $title );
			
				$content = sprintf('<div data-sync="tabs_array_item%s_content">%s</div>', $count, $content );

				$output .= sprintf(
					'<li class="%s">%s</li>',
					$user_class,
					$title
				);
				$content_out .= sprintf('%s', $content);
				
				$count++;
			}
				
		}

		$tabs_type = ($this->opt('tabs_type', $this->oset)) ? $this->opt('tabs_type', $this->oset) : 'default';
		
		printf('
			<div class="supertabs row">
				<div id="%s">
					<ul class="resp-tabs-list">
		                %s
		            </ul>
					<div class="resp-tabs-container">
						%s
		            </div>
				</div>
			</div>', 
			$tabs_type, 
			$output, 
			$content_out
		);
		
		$scopes = array('local', 'type', 'global');

	}	
}
