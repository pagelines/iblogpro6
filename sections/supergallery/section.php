<?php
/*
	Section: SuperGallery
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: A simple gallery based on wordpress post/page attachments.
	Class Name: SuperGallery
	Edition: Pro
	Filter: Gallery
*/



class SuperGallery extends PageLinesSection {
	
	function section_opts(){
		
		$options = array();

		$options[] = array(

			'title' => __( 'Gallery Configuration', 'pagelines' ),
			'type'	=> 'multi',
			'opts'	=> array(
				array(
					'key' 		=> 'orderby',
					'label' 	=> __( 'Order By', 'pagelines' ),
					'type' 		=> 'select',
					'default' 	=> 'title',
					'opts' 		=> array(						
							'ID'		=> array( 'name' => "ID" ),
							'author'	=> array( 'name' => "Author" ),
							'title'		=> array( 'name' => "Title" ),
							'name' 		=> array( 'name' => "Name" ),
							'date' 		=> array( 'name' => "Date" ), 
							'rand' 		=> array( 'name' => "Random" ), 
							'menu_order'=> array( 'name' => "Page Order" ),
					)
				),
				array(
					'key' 		=> 'order',
					'label' 	=> __( 'Order', 'pagelines' ),
					'type' 		=> 'select',
					'default' 	=> 'ASC',
					'opts' 		=> array(
							'ASC'	=> array( 'name' => "Ascending" ),
							'DESC'	=> array( 'name' => "Descending" ),
					)
				),
				array(
					'key' 		=> 'theme',
					'label' 	=> __( 'Theme', 'pagelines' ),
					'type' 		=> 'select',
					'default' 	=> 'galleria-light',
					'opts' 		=> array(
							'galleria-light'	=> array( 'name' => "Light" ),
							'galleria-dark'		=> array( 'name' => "Dark" ),
					)
				),
				array(
					'key' 		=> 'numberposts',
					'default'	=> '-1',
					'label' 	=> __( 'Number of Posts (Unlimited if left blank)', 'pagelines' ),
					'type' 		=> 'text'
				),
				array(
					'key' 		=> 'height',
					'default'	=> '300',
					'label' 	=> __( 'Height in Pixels (Default is 400)', 'pagelines' ),
					'type' 		=> 'text'
				),
			)

		);

		return $options;
	}
	
	function section_styles(){
		
		wp_enqueue_script('Galleria', $this->base_url.'/galleria-1.3.3.min.js', array( 'jquery' ), 1.0 , true);
		
		wp_enqueue_style('Galleria', $this->base_url.'/themes/iblog/galleria.iblog.css');
	}

	function section_head(){ 
		
		$height = ( $this->opt( 'height' ) ) ? $this->opt( 'height' ) : '400';
		
		?>
		
		<style>

            <?php echo $this->prefix(); ?> .galleria{
				height: <?php echo $height; ?>px;
				width: 100%;
				}

        </style>
	
	<?php }

   function section_template() {

		global $post;

		$order 			= ( $this->opt( 'order' ) ) ? $this->opt( 'order' ) : 'ASC';
		$orderby 		= ( $this->opt( 'orderby' ) ) ? $this->opt( 'orderby' ) : 'title ASC';
		$theme 			= ( $this->opt( 'theme' ) ) ? $this->opt( 'theme' ) : 'galleria-light';
		$numberposts 	= ( $this->opt( 'numberposts' ) ) ? $this->opt( 'numberposts' ) : -1;
		
		$output = '';
		$count 	= 1; 

		$attachments = get_children( 
			array(	
				'post_parent'  	 => get_the_ID(), 
				'post_type' 	 => 'attachment', 
				'post_mime_type' => 'image',
				'order'          => $order,
				'orderby'        => $orderby,
				'numberposts'	 => $numberposts,
			) );

		if($attachments){
			foreach ( $attachments as $attachment_id => $attachment ) { 

				$image_link 		= wp_get_attachment_link( $attachment_id );
				$image_url 			= wp_get_attachment_url( $attachment_id );
				$image_big			= wp_get_attachment_url( $attachment_id );
				$image_title 		= apply_filters( 'the_title', $attachment->post_title );
				$image_caption 		= apply_filters( 'the_excerpt', $attachment->post_excerpt );
				//$image_description 	= apply_filters( 'the_content', $attachment->post_content );
			

				$image = sprintf('<img src="%s" data-big="%s" data-title="%s" data-description="%s" />', 
					$image_url, 
					$image_big, 
					$image_title,
					$image_caption,
					$image_title
					);

				$output .= sprintf(
					'<a href="%s">%s</a>',
					$image_link,
					$image
				);
			
				$count++;
				
			}
		
			printf('
				<div class="content %s">
					<div class="galleria">
						%s
					</div>
				</div>', $theme, $output);
				
			?>
			
				<script>

					jQuery(function(){
					  Galleria.loadTheme("<?php echo $this->base_url; ?>/themes/iblog/galleria.iblog.min.js");
					  Galleria.run('<?php echo $this->prefix(); ?> .galleria',{
				    	   height: 0.8
					  });
					});
					
				</script>
				
			<?php
			
		} else {
			echo '<strong>Attach photos to this post/page to activate gallery.</strong>';
		}	//End if images exist
	
	}
 	 
	
}
