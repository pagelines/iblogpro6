<?php
/*
	Section: SuperTabs
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: An easy way to create and configure different tab types (Vertical, Horizontal and Accordion).
	Class Name: PLSuperTabs
	Filter: component
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
				array(
                    'key' 		=> 'selected_tab_color',
                    'type' 		=> 'color',
                    'label' 	=> __('Selected Tab Color', 'pagelines'),
                    'default' 	=> '000000'
                ),
				array(
                    'key' 		=> 'selected_tab_background_color',
                    'type' 		=> 'color',
                    'label'		=> __('Selected Tab Background Color', 'pagelines'),
                    'default' 	=> 'FFFFFF'
                ),
				array(
                    'key' 		=> 'hover_color',
                    'type' 		=> 'color',
                    'label' 	=> __('Hover Color', 'pagelines'),
                    'default' 	=> 'red'
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
					'key'		=> 'icon',
					'label'		=> __( 'Tab Icon', 'pagelines' ),
					'type'		=> 'select_icon'
				),
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
		                closed: false,
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
		
	    <style type="text/css">
			
			<?php echo $this->prefix(); ?> .resp-tab-active,
			<?php echo $this->prefix(); ?> .resp-tab-active:hover,
			<?php echo $this->prefix(); ?> h2.resp-accordion-active,
			<?php echo $this->prefix(); ?> h2.resp-accordion-active:hover{
				color: <?php echo pl_hashify($this->opt('selected_tab_color')); ?>!important;
				background-color: <?php echo pl_hashify($this->opt('selected_tab_background_color')); ?>;
			}
			<?php echo $this->prefix(); ?> li:hover,
			<?php echo $this->prefix(); ?> .resp-accordion:hover{
				color: <?php echo pl_hashify($this->opt('hover_color')); ?>;
			}
        </style>
		
	<?php }
	
	function section_styles(){
		
		wp_enqueue_script( 'ResponsiveTabs', $this->base_url.'/easyResponsiveTabs.js', array( 'jquery' ), PL_CORE_VERSION, true );

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
				$icon = pl_array_get( 'icon', $item ); 
				
	
				
				$title = sprintf('<span data-sync="tabs_array_item%s_title">%s</span>', $count, $title );
			
				$content = sprintf('<div data-sync="tabs_array_item%s_content">%s</div>', $count, $content );
			
				$media_icon = '';

				if(!$icon || $icon == ''){
					$icons = pl_icon_array();
					$icon = $icons[ array_rand($icons) ];
				}
				$media_icon = sprintf('<i class="icon-%s media-type-icon"></i>', $icon);

				$output .= sprintf(
					'<li class="%s">%s %s</li>',
					$user_class,
					$media_icon,
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
