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
            'multiple_field' => array('images'),
            'fields' => array(
              
              array(
                  'id'        => 'images',
                  'type'      => 'multiple_upload',
                  'title'     => t('Image'),
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
        kint($attr);
        return array("#markup" => "xxx");
      }
  }

}