<?php
/*
	Section: iHeader
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: A stylized navigation bar with multiple modes and styles.
	Class Name: iHeader
	Filter: nav
*/


class iHeader extends PageLinesSection {

	function section_persistent(){
		register_nav_menus( array( 'iheader_nav' => __( 'iHeader Section', 'pagelines' ) ) );

	}

	function section_opts(){


		$social_urls = array(); 
	
		$social_icons = $this->social_icons();
		
		foreach($social_icons as $icon){
			$social_urls[] = array(
				'label'	=> ui_key($icon) . ' URL', 
				'key'	=> 'iheader_'.$icon,
				'type'	=> 'text',
				'scope'	=> 'global',
			); 
		}


		$opts = array(
			array(
				'type'	=> 'multi',
				'key'	=> 'iheader_content',
				'title'	=> __( 'Logo', 'pagelines' ),
				'col'	=> 1,
				'opts'	=> array(
					array(
						'type'	=> 'image_upload',
						'key'	=> 'iheader_logo',
						'label'	=> __( 'iHeader Logo', 'pagelines' ),
						'has_alt'	=> true,
						'opts'	=> array(
							'center_logo'	=> 'Center: Logo | Right: Pop Menu | Left: Site Search',
							'left_logo'		=> 'Left: Logo | Right: Standard Menu',
						),
					),
					array(
						'type'		=> 'check',
						'key'		=> 'iheader_logo_disable',
						'label'		=> __( 'Hide Logo?', 'pagelines' ),
						'default'	=> false
					)
				)

			),

			array(
				'type'	=> 'multi',
				'key'	=> 'iheader_social',
				'title'	=> __( 'Social Icons', 'pagelines' ),
				'col'	=> 1,
				'opts'	=> array(
					array(
						'type'	=> 'multi',
						'key'	=> 'iheader_social_urls', 
						'title'	=> 'Link URLs',
						'opts'	=> $social_urls,
					),
					array(
						'type'		=> 'check',
						'key'		=> 'iheader_social_disable',
						'label'		=> __( 'Hide Social Icons?', 'pagelines' ),
						'default'	=> false
					),
				)

			),


			array(
				'type'	=> 'multi',
				'key'	=> 'iheader_nav',
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
						'key'	=> 'iheader_menu',
						'type'	=> 'select_menu',
						'label'	=> __( 'Select Menu', 'pagelines' ),
					),
					array(
						'key'	=> 'iheader_search',
						'type'	=> 'check',
						'label'	=> __( 'Hide Search?', 'pagelines' ),
					),	
				)
			)
		);

		return $opts;

	}

	function social_icons( ){
		
		$social_icons = array(
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
		
		return $social_icons;
		
	}

	
   function section_template( $location = false ) {

   		$logo = $this->image( 'iheader_logo', pl_get_theme_logo(), array(), get_bloginfo('name'));

   		$hide_logo = ( $this->opt('iheader_logo_disable') ) ? $this->opt('iheader_logo_disable') : false;

   		$social_icons = $this->social_icons(); 

   		$hide_social = ( $this->opt('iheader_social_disable') ) ? $this->opt('iheader_social_disable') : false;

		$menu = ( $this->opt('iheader_menu') ) ? $this->opt('iheader_menu') : false;

		$hide_search = ( $this->opt('iheader_search') ) ? true : false;

		$menu_args = array(
			'theme_location' => 'iheader_nav',
			'menu' => $menu,
			'menu_class'	=> 'inline-list pl-nav sf-menu',
			
		);

	?>

	<div class="row">

		<div class="span4 logo">

			<?php if( '1' !== $hide_logo ): ?>

				<a href="<?php echo home_url('/');?>"><?php echo $logo; ?></a>
			
			<?php endif; ?>

		</div>

		<div class="span6 offset2 icons">

			<?php if( '1' !== $hide_social ): ?>
			
				<div class="icons">

					<?php 
					
					foreach($social_icons as $icon){
					
						$url = ( pl_setting('iheader_'.$icon) ) ? pl_setting('iheader_'.$icon) : false;
					
						if( $url )
							printf('<a href="%s" class="iheader-link" target="_blank"><i class="icon icon-%s"></i></a>', $url, $icon); 
					}
				
					?>

				</div>

			<?php endif; ?>

		</div>
	</div>

	<div class="nav-wrap fix">

			<ul class="homebutton">
				<li>
					<a href="<?php echo home_url(); ?>" title="<?php bloginfo("name"); ?>">
						
						<i class="icon icon-home"></i>
					
					</a>
				</li>
			</ul>

			<?php

				echo pl_navigation( $menu_args );

				if( ! $hide_search )
					pagelines_search_form( true, 'iheader-searchform');
			?>

	</div>
<?php }

}