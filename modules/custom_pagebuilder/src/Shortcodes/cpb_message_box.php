<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Drupal\custom_pagebuilder\Shortcodes;

/**
 * Description of cpb_message_box
 *
 * @author Chau-Phan
 */

if(!class_exists('cpb_message_box')):
   class cpb_message_box{
      public function render_form(){
         $fields = array(
            'type'      => 'cpb_message_box',
            'title'     => t('Message Box'), 
            'size'      => 3, 
            
            'fields'    => array(
              
              array(
                  'id'           => 'chose_icon',
                  'type'         => 'icon_font',
                  'title'        => t('Chose Icon'), 
              ),
              
              array(
                  'id'        => 'message_box_style',
                  'type'      => 'select',
                  'title'     => t('Message Box Style'),
                  'options'   => array(
                        'message-box-standard' => 'Standard',
                        'message-box-square' => 'Square Boxes',
                        'message-box-round' => 'Round Boxes',
                        'message-box-outlined' => 'Outlined Boxes',
                  ),
                  'desc'       => 'Select predefined message box design or choose "Custom" for custom styling.'
              ),           
              
              array(
                  'id'        => 'color',
                  'type'      => 'select',
                  'title'     => t('Color'),
                  'options'   => array(
                      "primary"=>"Classic Primary",
                      "info"=>"Classic Info",
                      "success"=>"Classic Success",
                      "warning"=>"Classic Warning",
                      "danger"=>"Classic Danger",
                      "inverse"=>"Classic Inverse",
                      "blue"=>"Blue",
                      "turquoise"=>"Turquoise",
                      "pink"=>"Pink",
                      "violet"=>"Violet",
                      "peacoc"=>"Peacoc",
                      "chino"=>"Chino",
                      "mulled_wine"=>"Mulled Wine",
                      "vista_blue"=>"Vista Blue",
                      "black"=>"Black",
                      "grey"=>"Grey",
                      "orange"=>"Orange",
                      "sky"=>"Sky",
                      "green"=>"Green",
                      "juicy_pink"=>"Juicy pink",
                      "sandy_brown"=>"Sandy brown",
                      "purple"=>"Purple",
                      "white"=>"White",
                  ),
                  'std'       => 'primary'
              ),
              
              array(
                  'id'        => 'content',
                  'type'      => 'textarea',
                  'title'     => t('Message'),
              ),
              
              array(
                  'id'        => 'text_color',
                  'type'      => 'select',
                  'title'     => 'Text Color',
                  'options'   => array(
                     ''  => t('Text Default'), 
                     'text-color-dark'  => t('Text Dark'), 
                     'text-color-light' => t('Text Light')
                  ) 
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
         if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
         return self::sc_message_box( $item['fields'], $item['fields']['content'] );
      }

      public static function sc_message_box( $attr, $content = null ){
         $icon = '';
         $icon = '<i class="'. $attr['chose_icon'] .'"></i> ';
         
         $class_array = array();
         $class_array[] = $attr['text_color'];
         $class_array[] = $attr['message_box_style'];
         $class_array[] = 'message-box-color-'.$attr['color'];
         $output = '<div class="wrapper-custom-pagebuilder-message-box">';
          $output .= '<div class="widget custom-pagebuilder-message-box '. $attr['el_class'] .'">';
            
          $output .= '<div class="alert '. implode(" ", $class_array) .'" role="alert">';
            $output .= '<div class="cpb-message-box-icon">'. $icon .'</div>';
            $output .= '<div class="cpb-message-content">';
            $output .= ($attr['content']) ? $attr['content'] : '';
            $output .= '</div>';
          $output .= '</div>';
         
          $output .= '</div><div class="clearfix"></div>';
         $output .= '</div>';
         return array('#markup' => $output);
      }
      
   }
endif;
