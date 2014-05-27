<?php
/*
	Section: iFooter
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: iBlogPro stylized footer area. Columnized with navigation.
	Class Name: iFooter
	
*/


class iFooter extends PageLinesSection {

	
	function section_opts(){

		$options = array(
		 	array(
				'type' 			=> 'multi',
				'title' 		=> __( 'Logo', 'pagelines' ),
				'opts'			=> array(
					
					array(
						'key'		=> 'text',
						'type' 		=> 'textarea',
						'label' 	=> __( 'Tagline Text', 'pagelines' ),
					),
					
					array(
						'key'		=> 'copy',
						'type' 		=> 'text',
						'label' 	=> __( 'Copyright text or similar.', 'pagelines' ),
					),

				)
			),
			
			array(
				'type' 			=> 'multi',
				'col'			=> 2,
				'title' 		=> __( 'Navigation Columns', 'pagelines' ),
				'opts'			=> array(

					array(
						'key'			=> 'if_nav_menu',
						'type'			=> 'select_menu',
						'label'		 	=> __( 'Nav Menu', 'pagelines' ),
					),
				)
			),
			
			
		);
		return $options;

	}
	
	
   function section_template() { 
	
		$text = ( $this->opt('text') ) ? $this->opt('text') : 'Designed by PageLines in California.';
		
		$copy = ( $this->opt('copy') ) ? $this->opt('copy') : 'Copyright &copy; 2014 iBlogPro. All rights reserved';

		$menu = ( $this->opt('if_nav_menu') ) ? $this->opt('if_nav_menu') : false; 
		
	
	?>
	
	<div class="ifooter-container row">
		<div class="span4">
			
			<div class="tagline-text">
				<p><?php echo $text; ?></p>
			</div>
			<div class="copyright-text">
				<p><?php echo $copy; ?></p>
			</div>
		</div>
		<div class="span8">

	       		
	       		<?php 	
					if ( is_array( wp_get_nav_menu_items( $menu ) ) || has_nav_menu( 'if_nav_menu' ) ) {
					wp_nav_menu(
						array(
							'menu_class'		=> 'ifooter_nav',
							'menu'				=> $menu,
							'container'			=> null,
							'depth'				=> 1,
							'fallback_cb'		=> '',
							'theme_location'	=> 'main_nav',
						)
					);
					} else 
						pl_nav_fallback('ifooter_nav');
					?>

		</div>
	</div>
	
	
	<?php
	}
	
	
	
}