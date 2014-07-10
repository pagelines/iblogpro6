<?php
/*
Section: iSlider
Author: PageLines
Author URI: http://www.pagelines.com
Description: A professional and versatile slider section. 
Class Name: iSlider
Filter: slider
*/


class iSlider extends PageLinesSection
{
    
    var $default_limit = 2;
    
    function section_styles(){
        
        wp_enqueue_script( 'flexslider', PL_JS . '/script.flexslider.js', array( 'jquery' ), pl_get_cache_key(), true );
        wp_enqueue_script( 'islider', $this->base_url . '/islider.js', array('jquery'), pl_get_cache_key(), true);
    }
    
    function section_opts(){
        
        $options = array();

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
                    'key'       => 'element_color',
                    'label'     => __( 'Style', 'pagelines' ),
                    'type'      => 'select',
                    'default'   => 'element-light',
                    'opts'      => array(
                        'element-light'  => array('name'=> 'Light Text and Elements'),
                        'element-dark'   => array('name'=> 'Dark Text and Elements'),
                    )
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
    
    function slides_output( $islider_array ){

        $count = 1; 
        
        $output = '';
        
        if( is_array($islider_array) ){
            
            foreach( $islider_array as $slide ){

                $the_img = pl_array_get( 'image', $slide );

                if( $the_img ){
 
                    $title = pl_array_get( 'title', $slide);

                    $text = pl_array_get( 'text', $slide); 

                    $element_color = pl_array_get( 'element_color', $slide ); 

                    $link = pl_array_get( 'link', $slide);

                    $link_text = pl_array_get( 'link_text', $slide );

                    $the_img = pl_array_get( 'image', $slide );

                    $the_img = ( $the_img ) ? $the_img : $this->base_url.'/images/islider1.jpg';

                    $img = sprintf('<img src="%s" alt="">', $the_img);           

                    $title = sprintf('<h2 data-sync="islider_array_item%s_title">%s</h2>', $count, $title);

                    $text = sprintf('<p data-sync="islider_array_item%s_text">%s</p>', $count, $text);

                    if( $link ){
                        $link_text = sprintf('<a data-sync="islider_array_item%s_link_text" href="%s">%s <i class="icon icon-chevron-right"></i></a>', $count, $link, $link_text);
                    } else { 
                        $link_text = '';
                    };

                    $content = sprintf('<div data-sync="islider_array_item%s" class="content %s"> %s %s %s </div>', $count, $element_color, $title, $text, $link_text);

                    $output .= sprintf(
                        '<li>%s %s</li>',
                        $content,
                        $img
                    );
                
                }

                $count++;
            }

        }

        return $output;    
    }

    function section_template( ) {
        
        $islider_array = $this->opt('islider_array');
        
        $islides = $this->slides_output( $islider_array );
    
        if( $islides == '' ){
            
            $islider_array = array(
                array(
                    'image'         => $this->base_url . '/images/default.jpg',
                    'element_color' => 'element-light',
                    'title'         => 'iSlider',
                    'text'          => 'Congrats! You have successfully installed this slider.<br /> Now just set it up.',
                    'link'          => 'http://www.pagelines.com/',
                    'link_text'     => 'Visit PageLines.com'
                ),
                
            );
            
            $islides = $this->slides_output( $islider_array );
        }


        printf('
            <div class="islider">
                <ul class="slides">
                    %s
                </ul>
            </div>', $islides);
	}
}