<?php
/*
	Section: iHeader
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: A stylized navigation bar with multiple modes and styles.
	Class Name: PLIHeader
	Filter: nav
*/


class PLIHeader extends PageLinesSection {


	function section_persistent(){
		register_nav_menus( array( 'iheader_nav' => __( 'iHeader Section', 'pagelines' ) ) );

	}

	function section_opts(){


		$the_urls = array(); 
	
		$icons = $this->the_icons();
		
		foreach($icons as $icon){
			$the_urls[] = array(
				'label'	=> ui_key($icon) . ' URL', 
				'key'	=> 'iheader_'.$icon,
				'type'	=> 'text',
				'scope'	=> 'global',
			); 
		}


		$opts = array(
			array(
				'type'	=> 'multi',
				'key'	=> 'navi_content',
				'title'	=> __( 'Logo', 'pagelines' ),
				'col'	=> 1,
				'opts'	=> array(
					array(
						'type'	=> 'image_upload',
						'key'	=> 'navi_logo',
						'label'	=> __( 'Navboard Logo', 'pagelines' ),
						'has_alt'	=> true,
						'opts'	=> array(
							'center_logo'	=> 'Center: Logo | Right: Pop Menu | Left: Site Search',
							'left_logo'		=> 'Left: Logo | Right: Standard Menu',
						),
					),
					array(
						'type'		=> 'check',
						'key'		=> 'navi_logo_disable',
						'label'		=> __( 'Disable Logo?', 'pagelines' ),
						'default'	=> false
					)
				)

			),

			array(
				'type'	=> 'multi',
				'key'	=> 'navi_content',
				'title'	=> __( 'Social Icons', 'pagelines' ),
				'col'	=> 1,
				'opts'	=> array(
					array(
						'type'	=> 'multi',
						'key'	=> 'iheader_urls', 
						'title'	=> 'Link URLs',
						
						'col'	=> 2,
						'opts'	=> $the_urls
						
					),
				)

			),


			array(
				'type'	=> 'multi',
				'key'	=> 'navi_nav',
				'title'	=> 'Navigation',
				'col'	=> 2,
				'opts'	=> array(
					array(
						'key'	=> 'navi_help',
						'type'	=> 'help_important',
						'label'	=> __( 'Using Megamenus (multi column drop down)', 'pagelines' ),
						'help'	=> __( 'Want a full width, multi column "mega menu"? Simply add a class of "megamenu" to the list items using the WP menu creation tool.', 'pagelines' )
					),
					array(
						'key'	=> 'navi_menu',
						'type'	=> 'select_menu',
						'label'	=> __( 'Select Menu', 'pagelines' ),
					),
					array(
						'key'	=> 'navi_search',
						'type'	=> 'check',
						'label'	=> __( 'Hide Search?', 'pagelines' ),
					),
					array(
						'key'	=> 'navi_offset',
						'type'	=> 'text_small',
						'place'	=> '100%',
						'label'	=> __( 'Dropdown offset from top of nav (optional)', 'pagelines' ),
						'help'	=> __( 'Default is 100% aligned to bottom. Can be PX or %.', 'pagelines' )
					)	
				)
			)
		);

		return $opts;

	}


	function the_icons( ){
		
		$icons = array(
			'facebook',
			'linkedin',
			'instagram',
			'twitter',
			'youtube',
			'google-plus',
			'pinterest',
			'dribbble',
			'flickr',
			'github',
		); 
		
		
		return $icons;
		
	}

	
   function section_template( $location = false ) {

   		$icons = $this->the_icons(); 

		$menu = ( $this->opt('navi_menu') ) ? $this->opt('navi_menu') : false;
		$offset = ( $this->opt('navi_offset') ) ? sprintf( 'data-offset="%s"', $this->opt('navi_offset') ) : false;
		$hide_search = ( $this->opt('navi_search') ) ? true : false;
		$class = ( $this->meta['draw'] == 'area' ) ? 'pl-content' : '';

	?>

	<div class="fix row">

		<div class="span4">
			<?php if( '1' !== $this->opt( 'navi_logo_disable' ) ): ?>
				<a href="<?php echo home_url('/');?>"><?php echo $this->image( 'navi_logo', pl_get_theme_logo(), array(), get_bloginfo('name')); ?></a>
			<?php endif; ?>
		</div>

		<div class="span6 offset2">
			
			<div class="icons">
			<?php 
			
			foreach($icons as $icon){
			
				$url = ( pl_setting('iheader_'.$icon) ) ? pl_setting('iheader_'.$icon) : false;
			
				if( $url )
					printf('<a href="%s" class="iheader-link" target="_blank"><i class="icon icon-%s"></i></a>', $url, $icon); 
			}
		
			?>
			</div>

		</div>
	</div>

	<div class="navi-wrap <?php echo $class; ?> fix">
		

			<ul class="homebutton navi-left">
				<li>
					<a href="<?php echo home_url(); ?>" title="<?php bloginfo("name"); ?>">
						<i class="icon icon-home"></i>
						<!-- <img src="http://demo.marcofolio.net/apple_menu/images/logo.png" /> -->
					</a>
				</li>
			</ul>

			<?php

				$menu_args = array(
					'theme_location' => 'navi_nav',
					'menu' => $menu,
					'menu_class'	=> 'inline-list pl-nav sf-menu navi-left',
					'attr'			=> $offset,
				);
				echo pl_navigation( $menu_args );

				if( ! $hide_search )
					pagelines_search_form( true, 'navi-searchform');
			?>





	</div>
<?php }

}


