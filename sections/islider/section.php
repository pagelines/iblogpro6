<?php
/*
Section: iSlider
Author: PageLines
Author URI: http://www.pagelines.com
Description: A professional and versatile slider section. 
Class Name: PLISlider
Filter: dual-width, slider
*/


class PLISlider extends PageLinesSection
{
    
    var $default_limit = 3;
    
    function section_persistent(){
        
    }
    
    function section_styles(){
        
        wp_enqueue_script('flexslider', $this->base_url . '/flexslider.js', array('jquery'), pl_get_cache_key(), true);
        wp_enqueue_script('islider', $this->base_url . '/islider.js', array('jquery'), pl_get_cache_key(), true);
    }
    
    function section_opts(){
        
        $options = array();
        
        $options[] = array(
            
            'title' => __('Config', 'pagelines'),
            'type' => 'multi',
            'col' => 1,
            'opts' => array(
                array(
                    'key' => 'islider_post_type',
                    'type' => 'select',
                    'opts' => pl_get_thumb_post_types(),
                    'default' => 4,
                    'label' => __('Which post type should iSlider use?', 'pagelines'),
                    'help' => __('<strong>Note</strong><br/> Post types for this section must have "featured images" enabled and be public.<br/><strong>Tip</strong><br/> Use a plugin to create custom post types for use with iSlider.', 'pagelines')
                ),
                array(
                    'key' => $this->id . '_format',
                    'type' => 'select',
                    'label' => __('Layout Format', 'pagelines'),
                    'opts' => array(
                        'image' => array(
                            'name' => __('Image Only', 'pagelines')
                        ),
                        'image_content' => array(
                            'name' => __('Image and Content', 'pagelines')
                        )
                    )
                ),
                array(
                    'key' => 'islider_sizes',
                    'type' => 'select_imagesizes',
                    'label' => __('Select Thumb Size', 'pagelines')
                ),
                array(
                    'key' => 'islider_total',
                    'type' => 'count_select',
                    'count_start' => 3,
                    'count_number' => 20,
                    'default' => 5,
                    'label' => __('Total Posts Loaded', 'pagelines')
                )
                
            )
            
        );

        $options[] = array(

            'title' => __( 'iSlider Content', 'pagelines' ),
            'col'   => 2,
            'type'  => 'multi',
            'help'      => __( 'Options to control the text and link in the iSlider title.', 'pagelines' ),
            'opts'  => array(
                array(
                    'key'           => 'islider_meta',
                    'type'          => 'text',
                    'label'         => __( 'iSlider Meta', 'pagelines' ),
                    'ref'           => __( 'Use shortcodes to control the dynamic meta info. Example shortcodes you can use are: <ul><li><strong>[post_categories]</strong> - List of categories</li><li><strong>[post_edit]</strong> - Link for admins to edit the post</li><li><strong>[post_tags]</strong> - List of post tags</li><li><strong>[post_comments]</strong> - Link to post comments</li><li><strong>[post_author_posts_link]</strong> - Author and link to archive</li><li><strong>[post_author_link]</strong> - Link to author URL</li><li><strong>[post_author]</strong> - Post author with no link</li><li><strong>[post_time]</strong> - Time of post</li><li><strong>[post_date]</strong> - Date of post</li><li><strong>[post_type]</strong> - Type of post</li></ul>', 'pagelines' ),
                ),
                array(
                    'key'           => 'islider_show_excerpt',
                    'type'          => 'check',
                    'label'     => __( 'Show excerpt?', 'pagelines' ),

                ),
                array(
                    'key' => 'islider_post_sort',
                    'type' => 'select',
                    'label' => __('Sort elements by postdate', 'pagelines'),
                    'default' => 'DESC',
                    'opts' => array(
                        'DESC' => array(
                            'name' => __('Date Descending (default)', 'pagelines')
                        ),
                        'ASC' => array(
                            'name' => __('Date Ascending', 'pagelines')
                        ),
                        'rand' => array(
                            'name' => __('Random', 'pagelines')
                        )
                    )
                )
              
            )

        );
        
        
        return $options;
    }
    
    
    function section_template()
    {
        
        global $post;
        
        $post_type = ($this->opt('islider_post_type')) ? $this->opt('islider_post_type') : 'post';
        
        $pt = get_post_type_object($post_type);

        $total = ($this->opt('islider_total')) ? $this->opt('islider_total') : '5';
        
        $sizes = ($this->opt('islider_sizes')) ? $this->opt('islider_sizes') : 'aspect-thumb';

        $sorting = ($this->opt('islider_post_sort')) ? $this->opt('islider_post_sort') : 'DESC';

        $orderby = ( 'rand' == $this->opt('islider_post_sort') ) ? 'rand' : 'date'; 
        
        $format = ($this->opt($this->id . '_format')) ? $this->opt($this->id . '_format') : 'image';
        
        $meta = ($this->opt('islider_meta')) ? $this->opt('islider_meta') : '[post_edit]';

        $show_excerpt = ($this->opt('islider_show_excerpt')) ? $this->opt('islider_show_excerpt') : false;
        
        $the_query = array(
            'posts_per_page'=> $total,
            'post_type'     => $post_type,
            'orderby'       => $orderby,
            'order'         => $sorting,
        );
        
        
        $posts = get_posts($the_query);
        
?>
            <h3>iTunes This Week</h3>
			<div class="flex-slider islider-container">
					<ul class="slides fadein">
		<?php
		        
		        if (!empty($posts)): foreach ($posts as $post): setup_postdata($post);
		?>


		<li>
            
		<?php

            if (has_post_thumbnail()) { 

                printf('<a href="%s">%s</a>', get_permalink(), get_the_post_thumbnail($post->ID, $sizes, array('title' => '')));

            } else {

                printf('<img height="400" width="600" src="%s" alt="no image added yet." />', pl_default_image());
           
            }

		?>

		<?php if ($format == 'image_content'): ?>

			<div>
					
					<h4><a href="<?php echo get_permalink();?>"><?php the_title(); ?></a></h4>
					<div><?php echo do_shortcode( apply_filters('islider_meta', $meta, $post->ID, pl_type_slug() )); ?></div>
					
					<?php if( $show_excerpt ): ?>
                    <div class="islider-excerpt">
                        <?php the_excerpt();?>
                    </div>
                    <?php endif;?>
					
			</div>

		<?php  endif; ?>

		<div class="clear"></div>

		</li>

		<?php endforeach; endif;
		      
		      if (!empty($posts))
		            echo '</ul></div>';
		?>



	<?php
	}


}