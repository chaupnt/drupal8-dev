<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Drupal\custom_pagebuilder\Shortcodes;

/**
 * Description of cpb_node_view
 *
 * @author Chau Phan
 */
if(!class_exists('cpb_node_view')) {
  class cpb_node_view {
    //put your code here
    public function render_form(){
         $fields = array(
            'type' => 'cpb_node_view',
            'title' => ('Node View'), 
            'size' => 3,
            'fields' => array(
               array(
                  'id'        => 'node_id',
                  'type'      => 'text',
                 'title'     => t('Node ID'),
                  'class'     => 'display-admin'
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
                  'id'     => 'el_class',
                  'type'      => 'text',
                  'title'  => t('Extra class name'),
                  'desc'      => t('Style particular content element differently - add a class name and refer to it in custom CSS.'),
               ),

            ),                                       
         );
         return $fields;
      }
      
      public function render_content( $item ) {
         if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
         return self::sc_node_view( $item['fields'], $item['fields']['content'] );
      }


      public static function sc_node_view( $attr, $content = null ){
        
        $output = '';
        
        // Amination Box
         $class_animate = '';
         $duration = '';
         $delay = '';
         if(!empty($attr['animate'])) {
           $class_animate = ' wow '. $attr['animate'];
           $duration = !empty($attr['duration']) ? 'data-wow-duration='.$attr['duration'].'s' : '';
           $delay = !empty($attr['delay']) ? 'data-wow-delay='.$attr['delay'].'s' : '';
         }
        
        $nid = $attr['node_id'];
        $entity_type = 'node';
        $view_mode = 'full';

        $view_builder = \Drupal::entityTypeManager()->getViewBuilder($entity_type);
        $storage = \Drupal::entityTypeManager()->getStorage($entity_type);
        $node = $storage->load($nid);
        $_view = '';
        if(!empty($node)) {
          $build = $view_builder->view($node, $view_mode);
          $_view = render($build);
        }
        
        $output .= '<div class="wrapper-custom-pagebuilder-node-view '. $attr['el_class'] .' '. $class_animate .' " {{ duration }} {{ delay }} >';
            $output .= '<div class="inner-content">';
              $output .= $_view;
            $output .= '</div>';
         $output .= '</div>';
         
         
         return array(
                    '#type' => 'inline_template',
                    '#template' => $output,
                    '#context' => array(
                      'duration' => $duration,
                      'delay' => $delay,
                    ),
                  ); 
      }
      
  }
}
