<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Drupal\custom_pagebuilder\Shortcodes;
if(!class_exists('cpb_custombutton')):
   class cpb_custombutton{
      public function render_form(){
         $fields = array(
            'type' => 'cpb_custombutton',
            'title' => t('Custom Button'),
            'size' => 2,
            'fields' => array(

              array(
                  'id'           => 'title',
                  'type'         => 'text',
                  'title'        => t('Text'),
                  'desc'         => t('Text on the button'),
                  'class'     => 'display-admin',
              ), 
              
              array(
                  'id'           => 'url_link',
                  'type'         => 'urllink',
                  'title'        => t('URL (Link)'),
                  'desc'         => t('Link on the button'),
                  'class'     => 'display-admin',
              ), 
              
              array(
                  'id'           => 'target',
                  'type'         => 'checkboxs',
                  'title'        => t('Target'),
                  'options'      => array(
                    '_blank'  => '_blank', 
                  ), 
              ),
              
              array(
                  'id'           => 'add_icon',
                  'type'         => 'checkboxs',
                  'title'        => t('Add icon?'),
                  'options'      => array(
                    'add_icon'  => 'add_icon', 
                  ), 
              ),
              
              array(
                  'id'           => 'chose_icon',
                  'type'         => 'icon_font',
                  'title'        => t('Chose Icon'), 
              ),
              
              array(
                  'id'        => 'icon_align',
                  'type'      => 'select',
                  'title'     => t('Align Icon'),
                  'options'   => array(
                      'icon-left'   => 'Left',
                      'icon-right' => 'Right',
                  ),
                  'std'       => 'icon-left'
               ),
              
              array(
                  'id'        => 'align',
                  'type'      => 'select',
                  'title'     => t('Align Button'),
                  'options'   => array(
                        'text-left'   => 'Align Left',
                        'text-center' => 'Align Center',
                        'text-right'  => 'Align Right'
                  ),
                  'std'       => 'text-center'
               ),
              
              array(
                  'id'        => 'shape',
                  'type'      => 'select',
                  'title'     => t('Shape'),
                  'options'   => array(
                        'round' => 'Rounded',
                        'square'   => 'Square',
                  ),
                  'std'       => 'align-center'
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
                      "mulled-wine"=>"Mulled Wine",
                      "vista-blue"=>"Vista Blue",
                      "black"=>"Black",
                      "grey"=>"Grey",
                      "orange"=>"Orange",
                      "sky"=>"Sky",
                      "green"=>"Green",
                      "juicy-pink"=>"Juicy pink",
                      "sandy-brown"=>"Sandy brown",
                      "purple"=>"Purple",
                      "white"=>"White",
                  ),
                  'std'       => 'primary'
               ),
              
              array(
                  'id'        => 'size',
                  'type'      => 'select',
                  'title'     => t('Size'),
                  'options'   => array(
                        'md' => 'Normal',
                        'xs' => 'Mini',
                        'sm' => 'Small',
                        'lg' => 'Large'
                  ),
                  'std'       => 'md'
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
         return self::sc_column( $item['fields'] );
      }


      public static function sc_column( $attr, $content = null ){
        $target = '';
        if( isset($attr['target']) && '_blank' == $attr['target'] ) {
          $target = 'target="_blank"';
        }
        
        if(!empty($attr['add_icon'])) {
          $title = ($attr['title']) ? $attr['title'] : 'Text on the Button';
          $text_button = '<i class="'. $attr['chose_icon'] .'"></i> '. $title;
          if($attr['icon_align'] == 'icon-right') {
            $text_button = $title . ' <i class="'. $attr['chose_icon'] .'"></i>';
          }
        }
        
        $class = array();
        $class[] = 'btn';
        $class[] = 'btn-type-'.$attr['shape'];
        $class[] = 'btn-'.$attr['color'];
        $class[] = 'btn-'.$attr['size'];
         
        $ourput = '<div class="wrapper-custom-pagebuild-item-elemet wrapper-custom-pagebuild-custom-button '. $attr['el_class'] .'">';
        $ourput .= '<div class="inner-column-content">';
        $ourput .= '<div class="content '. $attr['align'] .' "><a '. $target .' href="'. $attr['url_link'] .'" class="'. implode($class, ' ') .'">'
             . $text_button . 
             '</a></div>';
        $ourput .= '</div>';
        $ourput .= '</div>';
        return array("#markup" => $output);
      }
   }
 endif;  
