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
       $array_term = array();
       foreach($tree as $value) {
          $new_value = strtolower($value->name->value);
          $new_value = preg_replace('/[^a-z0-9_]+/', '_', $new_value);
          $new_value = preg_replace('/_+/', '_', $new_value);
          $array_term[] = array(
            'name' => $value->name->value,
            'machine_name' => $new_value,
          );
       }
       return $array_term;
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
        $terms = $this->get_portfolio_categories();
        $nids = \Drupal::entityQuery('node')->condition('type','portfolio')->pager(1)->execute();
        $portfolios =  \Drupal\node\Entity\Node::loadMultiple($nids);
        $col = '';
        if((!empty($attr['display_type'])) && $attr['display_type'] == '2_col') {
          $col = '2';
        } else if((!empty($attr['display_type'])) && $attr['display_type'] == '3_col') {
          $col = '3';
        } else if((!empty($attr['display_type'])) && $attr['display_type'] == '4_col') {
          $col = '4';
        }
        if($attr['display_type'] == 'carousel') {
          return array(
              '#type' => 'html',
              '#cache' => array('max-age' => 0),
              '#theme' => 'page_portfolio_content_owl_carousel',
              '#portfolio_catagory' => $terms,
              '#portfolios' => $portfolios,
              '#hover_effect' => (!empty($attr['hover_effect'])) ? $attr['hover_effect'] : '',
              '#grid_col' => (!empty($attr['display_type'])) ? $col : '',
              '#el_class' => (!empty($attr['el_class'])) ? $attr['el_class'] : '',
          );
        } else {
          return array(
              '#type' => 'html',
              '#cache' => array('max-age' => 0),
              '#theme' => 'page_portfolio_content',
              '#portfolio_catagory' => $terms,
              '#portfolios' => $portfolios,
              '#hover_effect' => (!empty($attr['hover_effect'])) ? $attr['hover_effect'] : '',
              '#grid_col' => (!empty($attr['display_type'])) ? $col : '',
              '#el_class' => (!empty($attr['el_class'])) ? $attr['el_class'] : '',
          );
        }
        
    } 
   }
endif;   
