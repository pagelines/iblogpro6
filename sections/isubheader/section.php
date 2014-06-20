<?php
/*
	Section: iSubheader
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: A dynamic subheader area that includes optional sub navigation and call to action.
	Class Name: iSubheader
	Filter: component, nav
	Loading: active
*/

class iSubheader extends PageLinesSection {

	
	function section_opts(){

		$options = array();

		$options = array(

			array(
				'type' 			=> 'multi',
				'title' 		=> __( 'iSubheader', 'pagelines' ),
				'col'			=> 2,
				'opts'			=> array(
					array(
						'key'		=> 'ish_header',
						'type' 		=> 'text',
						'label' 	=> __( 'iSubheader', 'pagelines' ),
						'help'		=> 'Defaults to current page title if left blank'
					),
				)
			),

			array(
				'type' 			=> 'multi',
				'title' 		=> __( 'Menu (optional)', 'pagelines' ),
				'col'			=> 2,
				'opts'			=> array(			
					array(
									'key'			=> 'ish_nav',
									'type'			=> 'select_menu',
									'label'		 	=> 'Select Menu',
					),
					array(
						'key'			=> 'ish_link',
						'type' 			=> 'text',
						'label' 		=> __( 'Call to action Link', 'pagelines' ),
					),
					array(
						'key'			=> 'ish_link_text',
						'type' 			=> 'text',
						'label' 		=> __( 'Call to action Text', 'pagelines' ),
					),
					array(
						'type'		=> 'check',
						'key'		=> 'is_nav_disable',
						'label'		=> __( 'Hide Navigation & Call to action areas?', 'pagelines' ),
						'default'	=> false
					),
				)

			),
			
		);

		return $options;

	}
	
	function before_section_template( $location = '' ) {

		$this->wrapper_classes['special'] = 'pl-scroll-translate'; 

	}
	

	function section_template() {
		
		global $post;
		
		$title = ( $this->opt('ish_header') ) ? $this->opt('ish_header') : pl_smart_page_title();
		
		$menu = ( $this->opt('ish_nav') ) ? $this->opt('ish_nav') : false; 		

		$link = ( $this->opt('ish_link') ) ? $this->opt('ish_link') : '';

		$link_text = ( $this->opt('ish_link_text') ) ? $this->opt('ish_link_text') : '';

		if( $link ){
			$callout = sprintf('<a data-sync="ish_link_text" href="%s" class="ish-callout btn-link-color">%s</a>', $link, $link_text);
		} 

		?>
		<div class="pl-animation pla-fade row">
				<div class="span4">
					<h2 class="ish-header" data-sync="ish_header"><?php echo $title; ?></h2>
				</div>
				<div class="span8">
					
					<div class="ish-links">
						<?php echo $callout; ?>

						<?php 

						if ( is_array( wp_get_nav_menu_items( $menu ) ) || has_nav_menu( 'ish_nav' ) ) {
							wp_nav_menu(
								array(
									'menu_class'		=> 'ish-nav',
									'menu'				=> $menu,
									'container'			=> null,
									'depth'				=> 1,
									'fallback_cb'		=> '',
								)
							);
						} 

						?>
					</div>

				</div>
		</div>
	<?php

	}
}
