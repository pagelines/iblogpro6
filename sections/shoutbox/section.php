<?php
/*
	Section: ShoutBox
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: A simple shout box.
	Class Name: PLShoutBox
	Filter: component
*/

class PLShoutBox extends PageLinesSection {

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
		
		
		printf('<div class="shoutbox-wrap fade in %s" style="%s">%s <button type="button" class="close-shoutbox" href="#" data-dismiss="alert">×</button></div>', $align, $padding, $content);
		
	}
}


