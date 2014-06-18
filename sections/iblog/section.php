<?php
/*
	Section: iBlog
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: A  style blog.
	Class Name: iBlog
	Filter: format
*/


class iBlog extends PageLinesSection {

	
	function before_section_template( $location = '' ) {

		global $wp_query;

		if(isset($wp_query) && is_object($wp_query))
			$this->wrapper_classes[] = ( $wp_query->post_count > 1 ) ? 'multi-post' : 'single-post';

	}

	function section_opts(){
		
		$options = array();

		

		return $options;
		
	}

	/**
	* Section template.
	*/
   function section_template() {
	
		if( have_posts() )
			while ( have_posts() ) : the_post();  $this->get_article(); endwhile;
		else
			$this->posts_404();
	
	}
	
	function get_article(){
		$format = get_post_format();

		$linkbox = ($format == 'quote' || $format == 'link') ? true : false;
		
		$gallery_format = get_post_meta( get_the_ID(), '_pagelines_gallery_slider', true);

		$class[ ] = ( ! empty( $gallery_format ) ) ? 'use-flex-gallery' : '';
		
		$classes = apply_filters( 'pagelines_get_article_post_classes', join( " ", $class) );

		$post_id = get_the_ID();
		
		?>
		<div class="row fix ipost">
			<div class="span1 ipost-date">
					<span class="day"><?php echo do_shortcode( '[post_date format="d"]' ); ?></span>
					<span class="month"><?php echo do_shortcode( '[post_date format="M"]' ); ?></span>
			</div>
			<div class="span10 offset1">
				
				<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
					
					<?php
						$media = pagelines_media( array( 'thumb-size' => 'aspect-thumb' ) ); 
						
						if( ! empty( $media ) )
							printf( '<div class="metamedia">%s</div>', $media );
					
					?>
				
					<?php if( ! $linkbox || is_single() ): ?>
					<div class="ipost-text">
						<?php if( ! $linkbox  ): ?>
							<h2 class="title"><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
						<?php endif; ?>
							<div class="content">
								<div class="author-name">Posted by <?php echo do_shortcode( '[post_author_posts_link]' ); ?> / <?php echo do_shortcode( '[post_categories]' ); ?></div>

								<?php 
									if( ! is_single() ) 
										echo get_the_excerpt();
									else{
										the_content('...');

										wp_link_pages( array(
											'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'pagelines' ) . '</span>',
											'after'       => '</div>',
											'link_before' => '<span>',
											'link_after'  => '</span>',
										) );
									}
								?>

								<?php echo do_shortcode( '[post_tags]' ); ?>
								
							</div>
					</div>
					<?php endif; ?>
				</article>
			</div>
		</div>
		<?php 
	}
	
	function posts_404(){
		echo '404';
	}
	
}