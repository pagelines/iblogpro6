<?php
/*
	Section: iFooter
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: iBlogPro stylized footer area with enhanced breadcrumb Navigation.
	Class Name: iFooter
	
*/


class iFooter extends PageLinesSection {

	
	function section_opts(){

		$menu_options = array(); 
		
		for( $i = 1; $i <= 4; $i++ ){
			
			$menu_options[] = array(
									'key'			=> 'ifooter_nav_title_'.$i,
									'type'			=> 'text',
									'label'		 	=> sprintf( __( 'Nav %s | Title', 'pagelines' ), $i ),
								);
			
			$menu_options[] = array(
									'key'			=> 'ifooter_nav_menu_'.$i,
									'type'			=> 'select_menu',
									'label'		 	=> sprintf( __( 'Nav %s | Select Menu', 'pagelines' ), $i ),
								);
			
			$menu_options[] = array(
									'type'			=> 'divider',
								);
			
		}

		$options = array(

			array(
				'type' 			=> 'multi',
				'title' 		=> __( 'Breadcrumbs', 'pagelines' ),
				'opts'			=> array(

					array(
						'type'		=> 'check',
						'key'		=> 'footer_top_disable',
						'label'		=> __( 'Hide Breadcrumbs & Navigation Columns?', 'pagelines' ),
						'default'	=> false
					),
					
					array(
						'key'		=> 'breadcrumbs_icon',
						'type' 		=> 'image_upload',
						'label' 	=> __( 'Breadcrumbs Icon', 'pagelines' ),
						'help'		=> 'Must be 32px by 32px.',
					),

				)

			),

			array(
				'type' 			=> 'multi',
				'title' 		=> __( 'Navigation Columns', 'pagelines' ),
				'opts'			=> $menu_options,
			),
			


		 	array(
				'type' 			=> 'multi',
				'title' 		=> __( 'Bottom Credits', 'pagelines' ),
				'col'			=> 2,
				'opts'			=> array(

					array(
						'key'		=> 'copy',
						'type' 		=> 'text',
						'label' 	=> __( 'Copyright text or similar.', 'pagelines' ),
					),

					array(
						'key'		=> 'tagline',
						'type' 		=> 'text',
						'label' 	=> __( 'Tagline Text', 'pagelines' ),
					),

				)
			),
			
		);

		return $options;

	}
	
	
   function section_template() { 
	
		$breadcrumbs_icon = ( $this->opt('breadcrumbs_icon') ) ? $this->opt('breadcrumbs_icon') : PL_PARENT_URL.'/images/default-favicon.png';

		$hide_footer_top = ( $this->opt('footer_top_disable') ) ? $this->opt('footer_top_disable') : false;
		
		$tagline = ( $this->opt('tagline') ) ? $this->opt('tagline') : 'Designed by PageLines in California.';
		
		$copy = ( $this->opt('copy') ) ? $this->opt('copy') : 'Copyright &copy; 2014 iBlogPro All rights reserved.';
		
		
		$cols = array(); 
		for( $i = 1; $i <= 4; $i++ ){
			
			$menu =  ( $this->opt('ifooter_nav_menu_'.$i) ) ? $this->opt('ifooter_nav_menu_'.$i) : false;
			
			
			
			$cols[ $i ] = array(
				'menu'		=> false, 
				'title'		=> false
			);
			
			if( $menu && is_array( wp_get_nav_menu_items( $menu ) ) ){
				$args = array(
					'menu'            	=> '',
					'echo'            	=> false,
					'items_wrap'      	=> '%3$s',
					'container'			=> ''
				);
				$cols[ $i ]['menu'] = wp_nav_menu( $args );
			}
				
			
			$cols[ $i ]['title'] = ( $this->opt('ifooter_nav_title_'.$i) ) ? $this->opt('ifooter_nav_title_'.$i) : false;
		
		}
		
	
	?>
	

		<?php if( '1' !== $hide_footer_top ): ?>
			
			<div class="ifooter-top row fix">

				<div class="row">
					<div class="breadcrumbs-container fix">
						<a href="<?php echo home_url();?>" class="breadcrumbs-icon"><img src="<?php echo $breadcrumbs_icon; ?>" /></a>
						<?php if (function_exists('pl_breadcrumbs')) pl_breadcrumbs(); ?>
					</div>
				</div>

				<div class="row">
					<div class="span3">
						<?php 
						
							$title = ( $cols[1]['title'] ) ? $cols[1]['title'] : __('Pages','pagelines'); 
							$menu = ( $cols[1]['menu'] ) ? $cols[1]['menu'] : pl_list_pages(); 
							
							echo pl_media_list( $title, $menu ); 
						?>
						
					</div>
					<div class="span3">
						<?php 
						
							$title = ( $cols[2]['title'] ) ? $cols[2]['title'] : __('Categories','pagelines'); 
							$menu = ( $cols[2]['menu'] ) ? $cols[2]['menu'] : pl_popular_taxonomy(); 
							
							echo pl_media_list( $title, $menu ); 
						?>
					</div>
					<div class="span3">
						<?php 
						
							$title = ( $cols[3]['title'] ) ? $cols[3]['title'] : __('Tags','pagelines'); 
							$menu = ( $cols[3]['menu'] ) ? $cols[3]['menu'] : pl_popular_taxonomy( 6, 'post_tag'); 
							
							echo pl_media_list( $title, $menu ); 
						?>
					</div>
					<div class="span3">
						<?php 
						
							$title = ( $cols[4]['title'] ) ? $cols[4]['title'] : __('Pages','pagelines'); 
							$menu = ( $cols[4]['menu'] ) ? $cols[4]['menu'] : pl_list_pages(); 
							
							echo pl_media_list( $title, $menu ); 
						?>
					</div>
				</div>

			</div><!-- end .ifooter-top -->

		<?php endif; ?>

		<div class="ifooter-bottom">
			<p>
				<?php echo $copy . $tagline; ?>
			</p>
		</div><!-- end .ifooter-bottom -->

	
	<?php
	}
	
	
	
}