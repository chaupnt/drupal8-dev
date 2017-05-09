<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Drupal\taxonomy\Entity\Term;
namespace Drupal\custom_pagebuilder\Shortcodes;

if(!class_exists('cpb_portfolio_content')):
   class cpb_portfolio_content{
  
      
     public function get_portfolio_categories() {
       //$term = new \Drupal\taxonomy\Entity\Term();
       $tree = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree('portfolio_category', 0, NULL, TRUE);
       //kint($tree);
     }  
  
      public function render_form(){
         return array(
           'type'          => 'cpb_portfolio_content',
            'title'        => t('Portfolio Content'),
            'size'         => 3,
            'fields' => array(
              
              array(
                  'id'        => 'display_type',
                  'type'      => 'select',
                  'title'     => t('Grid column'),
                  'desc'      => t('Grid column Content'),
                  'options'   => array( 
                    '2_col' => '2 Column', 
                    '3_col' => '3 Column',
                    '4_col' => '4 Column',
                    'carousel' => 'Carousel',
                   ),
              ),
              
              array(
                  'id'        => 'hover_effect',
                  'type'      => 'select',
                  'title'     => t('Hover Effect'),
                  'desc'      => t('Effect Hover Image Portfolio'),
                  'options'   => custom_pagebuilder_image_hover(),
              ),
              
              array(
                  'id'        => 'el_class',
                  'type'      => 'text',
                  'title'     => t('Extra class name'),
                  'desc'      => t('Style particular content element differently - add a class name and refer to it in custom CSS.'),
              ),
            ),                                     
         );
      }

      public function render_content( $item ) {
         if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
            return $this->sc_portfolio_content( $item['fields'], $item['fields']['content'] );
      }

      public function sc_portfolio_content( $attr, $content = null ){
        $this->get_portfolio_categories();
        return array(
          '#type' => 'html',
          '#cache' => array('max-age' => 0),
          '#theme' => 'page_portfolio_content',
          '#portfolio_catagory' => 'asdasdasdsa',
          '#portfolios' => 'asdasdas',
          '#hover_effect' => 'asdasdasdasda',
          '#el_class' => (!empty($attr['el_class'])) ? $attr['el_class'] : '',
      );
    } 
   }
endif;   
