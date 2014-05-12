<?php
/*
	Section: ShoutBox
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: A simple shout box.
	Class Name: PLShoutBox
	Edition: pro
	Filter: component
	Loading: active
*/

class PLShoutBox extends PageLinesSection {
	
	function section_head(){

			
		?>
	
		<style>
			<?php echo $this->prefix(); ?> .shoutbox-wrap{
				background-color: <?php echo pl_hashify($this->opt('shoutbox_background_color')); ?>;
				color: <?php echo pl_hashify($this->opt('shoutbox_text_color')); ?>;
			}
			<?php echo $this->prefix(); ?> .shoutbox-wrap a{ 
				color: <?php echo pl_hashify($this->opt('shoutbox_text_color')); ?>;
				border: 1px solid <?php echo pl_hashify($this->opt('shoutbox_text_color')); ?>;
			}
			<?php echo $this->prefix(); ?> .shoutbox-wrap .close-shoutbox{
				color: <?php echo pl_hashify($this->opt('shoutbox_text_color')); ?>;
			}
		</style>	
		
		<?php
	}

	function section_opts(){
		$opts = array(
			array(
				'col'		=> 2,
				'type' 		=> 'textarea',
				'key'		=> 'shoutbox_content',
				'label'		=> __( 'ShoutBox Content', 'pagelines' ),
				'help' 		=> __( 'This area supports text and HTML', 'pagelines' ),
			),
			array(
				'type'		=> 'multi',
				'key'		=> 'shoutbox_settings', 
				'label' 	=> __( 'ShoutBox Settings', 'pagelines' ),
				'opts'		=> array(
					array(
						'key'			=> 'shoutbox_text_color',
						'type' 			=> 'color',
						'label' 		=> __( 'Text Color', 'pagelines' ),
						'default' 		=> 'FFFFFF',
					),
					array(
						'key'			=> 'shoutbox_background_color',
						'type' 			=> 'color',
						'label' 		=> __( 'Background Color', 'pagelines' ),
						'default' 		=> '59B1F6',
					),
					array(
						'key'			=> 'shoutbox_font_size',
						'type'			=> 'count_select',
						'count_start'	=> 10,
						'count_number'	=> 30,
						'suffix'		=> 'px',
						'title'			=> __( 'Font Size', 'pagelines' ),
						'default'		=> '', 
					),
					
					array(
						'type' 			=> 'select',
						'key'			=> 'shoutbox_align',
						'label' 		=> 'Alignment',
						'opts'			=> array(
							'textcenter'	=> array('name' => 'Center (Default)'),
							'textleft'		=> array('name' => 'Align Left'),
							'textright'		=> array('name' => 'Align Right'),
							'textjustify'	=> array('name' => 'Justify'),
						)
					),	
					array(
						'key'		=> 'shoutbox_pad',
						'type' 		=> 'text',
						'label' 	=> __( 'Padding <small>(CSS Shorthand)</small>', 'pagelines' ),
						'ref'		=> __( 'This option uses CSS padding shorthand. For example, use "15px 30px" for 15px padding top/bottom, and 30 left/right.', 'pagelines' ),
						'default' 	=> '5px',
						
					),				
				)
			),
		);

		return $opts;

	}


	function section_template() {

		$content = $this->opt('shoutbox_content');
		
		$content = (!$content) ? '<p><strong>ShoutBox</strong> &raquo; Add Content or any HTML!</p>' : sprintf('%s', do_shortcode( wpautop($content) ) ); 
			
		$align = ($this->opt('shoutbox_align', $this->oset)) ? $this->opt('shoutbox_align', $this->oset) : 'center';
		
		$padding = ($this->opt('shoutbox_pad')) ? sprintf('padding: %s;', $this->opt('shoutbox_pad')) : ''; 
		
		$fontsize = ($this->opt('shoutbox_font_size')) ? sprintf('font-size: %spx;', $this->opt('shoutbox_font_size')) : ''; 
		
		printf('<div class="shoutbox-wrap fade in %s" style=" %s %s ">%s <button type="button" class="close-shoutbox" href="#" data-dismiss="alert">×</button></div>', $align, $padding, $fontsize, $content);
		
	}
}


