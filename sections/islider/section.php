<?php
/*
Section: iSlider
Author: PageLines
Author URI: http://www.pagelines.com
Description: A professional and versatile slider section. 
Class Name: iSlider
Filter: slider, full-width
*/


class iSlider extends PageLinesSection
{
    
    var $default_limit = 3;
    
    function section_persistent(){
        
    }
    
    function section_styles(){
        
        wp_enqueue_script( 'flexslider', PL_JS . '/script.flexslider.js', array( 'jquery' ), pl_get_cache_key(), true );
        wp_enqueue_script( 'islider', $this->base_url . '/islider.js', array('jquery'), pl_get_cache_key(), true);
    }
    
    function section_opts(){
        
        $options = array();
        
        $options[] = array(
            
            'title' => __('Config', 'pagelines'),
            'type' => 'multi',
            'col' => 1,
            'opts' => array(
                
                
            )
            
        );

        $options[] = array(
            'key'       => 'islider_array',
            'type'      => 'accordion', 
            'col'       => 2,
            'title'     => __('iSlider Setup', 'pagelines'), 
            'post_type' => __('iSlide', 'pagelines'), 
            'opts'  => array(
                array(
                    'key'       => 'image',
                    'label'     => __( 'Slide  Image <span class="badge badge-mini badge-warning">REQUIRED</span>', 'pagelines' ),
                    'type'      => 'image_upload',
                    'sizelimit' => 2097152, // 2M
                    'help'      => __( 'For high resolution, 2000px wide x 800px tall images. (2MB Limit)', 'pagelines' )
                    
                ),
                array(
                    'key'       => 'title',
                    'label'     => __( 'Title', 'pagelines' ),
                    'type'      => 'text'
                ),
                array(
                    'key'       => 'text',
                    'label'     => __( 'Text', 'pagelines' ),
                    'type'      => 'text'
                ),
                array(
                    'key'       => 'link',
                    'label'     => __( 'Link (Optional)', 'pagelines' ),
                    'type'      => 'text'
                ),
                array(
                    'key'       => 'link_text',
                    'label'     => __( 'Link Text', 'pagelines' ),
                    'type'      => 'text'
                ),
            )
        );
        
        
        return $options;
    }
    

    function section_template( ) {
        
        $islider_array = $this->opt('islider_array');
        
        if( !$islider_array || $islider_array == 'false' || !is_array($islider_array) ){
            $islider_array = array( array(), array(), array() );
        }
        
        $align = ($this->opt('list_align', $this->oset)) ? $this->opt('list_align', $this->oset) : 'textleft';
        
        $count = 1; 
        
        $output = '';
        
        if( is_array($islider_array) ){
            
            $slides = count( $islider_array );
            

            foreach( $islider_array as $slide ){

                $title = pl_array_get( 'title', $slide); 

                $text = pl_array_get( 'text', $slide); 

                $link = pl_array_get( 'link', $slide );

                $link_text = pl_array_get( 'link_text', $slide );  

                $the_img = pl_array_get( 'image', $slide );

                $the_img = ( $the_img ) ? $the_img : $this->base_url.'/space.jpg';

                $img = sprintf('<img src="%s" alt="">', $the_img);           

                $title = sprintf('<h2 data-sync="islider_array_slide%s_title">%s</h2>', $count, $title);

                $text = sprintf('<p data-sync="islider_array_slide%s_text">%s</p>', $count, $text);

                if( $link ){
                    $link_text = sprintf('<a data-sync="islider_array_slide%s_link_text" href="%s">%s <i class="icon icon-chevron-right"></i></a>', $count, $link, $link_text);
                } else { 
                    $link_text = '';
                };

                $content = sprintf('<div  data-sync="islider_array_slide%s" class="islider-content"><div class="islider-inner"> %s %s %s </div></div>', $count, $title, $text, $link_text);

                $output .= sprintf(
                    '<li>%s %s</li>',
                    $content,
                    $img
                );
                
                
                $count++;
            }

        }

        printf('
            <div class="flex-slider islider-container">
                <ul class="slides">
                    %s
                </ul>
            </div>', $output);
    
     ?>

	<?php
	}


}