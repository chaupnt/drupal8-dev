<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Drupal\custom_pagebuilder\Shortcodes;
if(!class_exists('cpb_carousel')) {
  /**
   * Description of cpb_carousel
   *
   * @author Chau Phan
   */
  class cpb_carousel {
    //put your code here
    public function render_form(){
         $fields = array(
            'type' => 'cpb_carousel',
            'title' => t('Custom Carousel'),
            'size' => 2,
            'multiple_field' => array('multiple_images'),
            'fields' => array(
              
              array(
                  'id'        => 'multiple_images',
                  'type'      => 'multiple_upload',
                  'title'     => t(''),
              ),
              
              array(
                  'id'        => 'animate',
                  'type'      => 'select',
                  'title'     => t('Animation Icon'),
                  'desc'      => t('Entrance animation for element'),
                  'options'   => custom_pagebuilder_animate(),
              ),
               
              array(
                'id'    => 'duration',
                'type'    => 'text',
                'title'   => ('Anumate Duration'),
                'desc'    => ('Change the animation duration'),
                'class'   => 'small-text',
              ),

             array(
                'id'    => 'delay',
                'type'    => 'text',
                'title'   => ('Anumate Delay'),
                'desc'    => ('Delay before the animation starts'),
                'class'   => 'small-text',
              ),
              
              array(
                  'id'        => 'el_class',
                  'type'      => 'text',
                  'title'     => t('Extra class name'),
                  'desc'      => t('Style particular content element differently - add a class name and refer to it in custom CSS.'),
              ),   
              
            ),                                     
         );
         return $fields;
      }


      public function render_content( $item ) {
         return self::sc_carousel( $item['fields'] );
      }


      public static function sc_carousel( $attr, $content = null ){
        $_id = custom_pagebuilder_makeid(10);
        $output = '';
        if(count($attr['multiple_images']) > 0 && !empty($attr['multiple_images'][0]['url_image'])) {
          $output .= '<div id="custom-pagebuider-carousel-'. $_id .'" class="carousel slide" data-ride="carousel">';
          $output .= '<div class="carousel-inner" role="listbox">';
              foreach($attr['multiple_images'] as $key=>$images) {
                $active = '';
                if($key == 0) {
                  $active = 'active';
                }
                if(!empty($images['url_image'])) {
                  $output .= '<div class="carousel-item '. $active .'">';
                  $output .= '<img class="d-block img-fluid" src="'. $images['url_image'] .'" alt="First slide">';
                  if(!empty($images['title'])) {
                    $output .= '<div class="carousel-caption d-none d-md-block">';
                      $output .= '<h3>'. $images['title'] .'</h3>';
                      $output .= (!empty($images['sub_title'])) ? '<p>'. $images['sub_title'] .'</p>':'';
                    $output .= '</div>';
                  }
                  $output .= '</div>';
                }
              }
          $output .= '</div>';
          $output .= '<a class="carousel-control-prev" href="#custom-pagebuider-carousel-'. $_id .'" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>';
          $output .= '<a class="carousel-control-next" href="#custom-pagebuider-carousel-'. $_id .'" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>';
          $output .= '</div>';
        }
        return array(
                    '#type' => 'inline_template',
                    '#template' => $output,
                    '#context' => array(),
                  );
      }
  }

}