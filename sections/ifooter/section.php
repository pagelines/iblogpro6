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

		$menu_options = array(); 
		
		for( $i = 1; $i <= 3; $i++ ){
			
			$menu_options[] = array(
									'key'			=> 'pf_nav_title_'.$i,
									'type'			=> 'text',
									'label'		 	=> sprintf( __( 'Nav %s Title', 'pagelines' ), $i ),
								);
			
			$menu_options[] = array(
									'key'			=> 'pf_nav_menu_'.$i,
									'type'			=> 'select_menu',
									'label'		 	=> sprintf( __( 'Nav %s Menu', 'pagelines' ), $i ),
								);
			
			$menu_options[] = array(
									'type'			=> 'divider',
								);
		}

		$options = array(
		 	array(
				'type' 			=> 'multi',
				'title' 		=> __( 'Logo', 'pagelines' ),
				'opts'			=> array(
					array(
						'key'		=> 'logo',
						'type' 		=> 'image_upload',
						'label' 	=> __( 'Logo', 'pagelines' ),
					),
					
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
				'opts'			=> $menu_options
			),
			
			
		);
		return $options;

	}
	
	
   function section_template() { 
	
		$logo = ( $this->opt('logo') ) ? $this->opt('logo') : PL_THEME_URL.'/logo.png';
		$text = ( $this->opt('text') ) ? $this->opt('text') : 'Designed by PageLines in California.';
		
		$copy = ( $this->opt('copy') ) ? $this->opt('copy') : '&copy; iBlogPro 2014';
		
		
		$cols = array(); 
		for( $i = 1; $i <= 3; $i++ ){
			
			$menu =  ( $this->opt('pf_nav_menu_'.$i) ) ? $this->opt('pf_nav_menu_'.$i) : false;
			
			
			
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
				
			
			$cols[ $i ]['title'] = ( $this->opt('pf_nav_title_'.$i) ) ? $this->opt('pf_nav_title_'.$i) : false;
		
		}
		
	
	?>
	
	<div class="ifooter-container row">
		<div class="span4">
			
			<div class="logo">
				<a href="<?php echo home_url();?>"><img src="<?php echo $logo; ?>" /></a>
			</div>
			<div class="tagline-text">
				<p><?php echo $text; ?></p>
			</div>
			<div class="copyright-text">
				<p><?php echo $copy; ?></p>
			</div>
		</div>
		<div class="span2 offset2">
			<?php 
			
				$title = ( $cols[1]['title'] ) ? $cols[1]['title'] : __('Pages','pagelines'); 
				$menu = ( $cols[1]['menu'] ) ? $cols[1]['menu'] : pl_list_pages(); 
				
				echo pl_media_list( $title, $menu ); 
			?>
			
		</div>
		<div class="span2">
			<?php 
			
				$title = ( $cols[2]['title'] ) ? $cols[2]['title'] : __('Categories','pagelines'); 
				$menu = ( $cols[2]['menu'] ) ? $cols[2]['menu'] : pl_popular_taxonomy(); 
				
				echo pl_media_list( $title, $menu ); 
			?>
		</div>
		<div class="span2">
			<?php 
			
				$title = ( $cols[3]['title'] ) ? $cols[3]['title'] : __('Tags','pagelines'); 
				$menu = ( $cols[3]['menu'] ) ? $cols[3]['menu'] : pl_popular_taxonomy( 6, 'post_tag'); 
				
				echo pl_media_list( $title, $menu ); 
			?>
		</div>
	</div>
	
	
	<?php
	}
	
	
	
}