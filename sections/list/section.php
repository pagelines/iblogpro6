<?php
/*
	Section: List
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: An easy to use list section.
	Class Name: PLList
	Filter: component
	Loading: active

*/


class PLList extends PageLinesSection {

	var $default_limit = 4;
	
	function section_head(){ ?>
		
	    <style type="text/css">
	
			<?php echo $this->prefix(); ?> .list-wrap{
				background-color: <?php echo pl_hashify($this->opt('background_color')); ?>;
			}
			<?php echo $this->prefix(); ?> ul.list li{
				color: <?php echo pl_hashify($this->opt('color')); ?>;
				font-size: <?php echo $this->opt('font_size'); ?>px;
			}
			<?php echo $this->prefix(); ?> ul.list li a{
				color: <?php echo pl_hashify($this->opt('link_color')); ?>;
			}

        </style>
		
	<?php }


	function section_opts(){

		$options = array();

		$options[] = array(

			'title' => __( 'List Configuration', 'pagelines' ),
			'key'	=> 'list_config',
			'type'	=> 'multi',
			'opts'	=> array(
				array(
					'key'			=> 'font_size',
					'type'			=> 'count_select',
					'count_start'	=> 10,
					'count_number'	=> 30,
					'title'			=> __( 'Font Size', 'pagelines' ),
					'default'		=> '20px', 
				),
				array(
					'type' 			=> 'select',
					'key'			=> 'list_align',
					'label' 		=> 'Alignment',
					'opts'			=> array(
						'textleft'		=> array('name' => 'Align Left (Default)'),
						'textright'		=> array('name' => 'Align Right'),
						'textcenter'	=> array('name' => 'Center'),
						'textjustify'	=> array('name' => 'Justify'),
					)
				),
				array(
                    'key' => 'color',
                    'type' => 'color',
                    'label' => __('Color', 'pagelines'),
                    'default' => '000000'
                ),
				array(
                    'key' => 'link_color',
                    'type' => 'color',
                    'label' => __('Link Color', 'pagelines'),
                    'default' => '59B1F6'
                ),
				array(
                    'key' => 'background_color',
                    'type' => 'color',
                    'label' => __('Background Color', 'pagelines'),
                    'default' => 'ffffff'
                ),
			)

		);

		$options[] = array(
			'key'		=> 'list_items_array',
	    	'type'		=> 'accordion', 
			'col'		=> 2,
			'title'		=> __('List Setup', 'pagelines'), 
			'post_type'	=> __('List Item', 'pagelines'), 
			'opts'	=> array(
				array(
					'key'		=> 'icon',
					'label'		=> __( 'Item Icon', 'pagelines' ),
					'type'		=> 'select_icon'
				),
				array(
					'key'		=> 'text',
					'label'		=> __( 'Item Text', 'pagelines' ),
					'type'		=> 'text'
				),
				array(
					'key'		=> 'link',
					'label'		=> __( 'Item Link (Optional)', 'pagelines' ),
					'type'		=> 'text'
				),
			)
	    );

		return $options;
	}


   function section_template( ) {
		
		$list_items_array = $this->opt('list_items_array');
		
		if( !$list_items_array || $list_items_array == 'false' || !is_array($list_items_array) ){
			$list_items_array = array( array(), array(), array() );
		}
		
		$align = ($this->opt('list_align', $this->oset)) ? $this->opt('list_align', $this->oset) : 'textleft';
		
		$count = 1; 
		
		$output = '';
		
		if( is_array($list_items_array) ){
			
			$boxes = count( $list_items_array );
			
			
			
			foreach( $list_items_array as $item ){
	
				$text = pl_array_get( 'text', $item, 'List Item '. $count); 
				$link = pl_array_get( 'link', $item ); 
				$icon = pl_array_get( 'icon', $item ); 				
				
				if( $link ){
					$text = sprintf('<span data-sync="list_items_array_item%s_text"><a href="%s">%s</a></span>', $count, $link, $text);
				} else { 
					$text = sprintf('<span data-sync="list_items_array_item%s_text">%s</span>', $count, $text );
				};
				
				
				$content_title = ($text) ? sprintf('<h3>%s<h3>', $text ) : '';


				$media_bg = '';
				$media_icon = '';

				if(!$icon || $icon == ''){
					$icons = pl_icon_array();
					$icon = $icons[ array_rand($icons) ];
				}
				$media_icon = sprintf('<i class="icon icon-%s media-type-icon"></i>', $icon);
				
				$output .= sprintf(
					'<li class="pl-animation">%s %s</li>',
					$media_icon,
					$text
				);
				
				
				$count++;
			}

		}

		printf('
			<div class="list-wrap pl-animation-group row">
				<ul class="list %s">
					%s
				</ul>
			</div>', $align, $output);
		$scopes = array('local', 'type', 'global');
	
	}
}
