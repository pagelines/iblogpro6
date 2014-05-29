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

        $options[] = array(

            'title' => __( 'iSlider Header', 'pagelines' ),
            'col'   => 2,
            'type'  => 'multi',
            'opts'  => array(
                array(
                    'key'           => 'islider_title',
                    'type'          => 'text',
                    'label'     => __( 'Title', 'pagelines' ),

                ),
                array(
                    'key'           => 'islider_link',
                    'type'          => 'text',
                    'label'     => __( 'Link Text', 'pagelines' ),

                ),
                array(
                    'key'           => 'islider_link_url',
                    'type'          => 'text',
                    'label'     => __( 'Link URL', 'pagelines' ),

                ),
                array(
                    'key'           => 'hide_header',
                    'type'          => 'check',
                    'label'     => __( 'Hide Header?', 'pagelines' ),

                ),
              
            )

        );
        
        
        return $options;
    }
    
    
    function section_template()
    {
        $title = ($this->opt('islider_title', $this->oset)) ? $this->opt('islider_title', $this->oset) : 'iSlider Section';

        $link_text = ($this->opt('islider_link', $this->oset)) ? $this->opt('islider_link', $this->oset) : 'See All iBlogPro Sections';

        $link_url = ($this->opt('islider_link_url', $this->oset)) ? $this->opt('islider_link_url', $this->oset) : ' ';

        global $post;
        
        $post_type = ($this->opt('islider_post_type')) ? $this->opt('islider_post_type') : 'post';
        
        $pt = get_post_type_object($post_type);

        $total = ($this->opt('islider_total')) ? $this->opt('islider_total') : '5';
        
        $sizes = ($this->opt('islider_sizes')) ? $this->opt('islider_sizes') : 'aspect-thumb';

        $sorting = ($this->opt('islider_post_sort')) ? $this->opt('islider_post_sort') : 'DESC';

        $orderby = ( 'rand' == $this->opt('islider_post_sort') ) ? 'rand' : 'date'; 

        $hide_header = ($this->opt('hide_header')) ? $this->opt('hide_header') : false;
        
        $the_query = array(
            'posts_per_page'=> $total,
            'post_type'     => $post_type,
            'orderby'       => $orderby,
            'order'         => $sorting,
        );
        
        
        $posts = get_posts($the_query);
        
?>  
        <?php if( !$hide_header ): 

        printf('
            <div class="center islider-title">
                <h3>%s</h3>
                <a href="%s">%s <i class="icon icon-chevron-right"></i></a>
            </div>', $title, $link_url, $link_text);

        endif;?>
        

			<div class="flex-slider islider-container">
					<ul class="slides fadein">
		<?php
		        
		        if (!empty($posts)): foreach ($posts as $post): setup_postdata($post);
		?>


		<li class="fix">
            
		<?php

            if (has_post_thumbnail()) { 

                printf('<a href="%s">%s</a>', get_permalink(), get_the_post_thumbnail($post->ID, $sizes, array('title' => '')));

            } else {

                printf('<img height="400" width="600" src="%s" alt="no image added yet." />', pl_default_image());
           
            }

		?>

		</li>

		<?php endforeach; endif;
		      
		      if (!empty($posts))
		            echo '</ul></div>';
		?>



	<?php
	}


}