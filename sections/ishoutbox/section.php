<?php
/*
	Section: iShoutBox
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: A simple dismissable alert box.
	Class Name: iShoutBox
	Filter: component
*/

class iShoutBox extends PageLinesSection {

	function section_opts(){
		$opts = array(
			array(
				'col'		=> 2,
				'type' 		=> 'textarea',
				'key'		=> 'ishoutbox_content',
				'label'		=> __( 'iShoutBox Content', 'pagelines' ),
				'help' 		=> __( 'This area supports text and HTML', 'pagelines' ),
			),
			array(
				'type'		=> 'multi',
				'key'		=> 'ishoutbox_settings', 
				'label' 	=> __( 'iShoutBox Settings', 'pagelines' ),
				'opts'		=> array(
					array(
						'type' 			=> 'select',
						'key'			=> 'ishoutbox_align',
						'label' 		=> 'Alignment',
						'opts'			=> array(
							'textcenter'	=> array('name' => 'Center (Default)'),
							'textleft'		=> array('name' => 'Align Left'),
							'textright'		=> array('name' => 'Align Right'),
							'textjustify'	=> array('name' => 'Justify'),
						)
					),	
				array(
						'key'		=> 'ishoutbox_pad',
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

		$content = $this->opt('ishoutbox_content');
		
		$content = (!$content) ? '<p><strong>iShoutBox</strong> &raquo; Add Content or any HTML!</p>' : sprintf('%s', do_shortcode( wpautop($content) ) ); 
			
		$align = ($this->opt('ishoutbox_align', $this->oset)) ? $this->opt('ishoutbox_align', $this->oset) : 'center';
		
		$padding = ($this->opt('ishoutbox_pad')) ? sprintf('padding: %s;', $this->opt('ishoutbox_pad')) : ''; 
		
		
		printf('<div class="ishoutbox-wrap fade in %s" style="%s">%s <button type="button" class="close-ishoutbox" href="#" data-dismiss="alert">×</button></div>', $align, $padding, $content);
		
	}
}


