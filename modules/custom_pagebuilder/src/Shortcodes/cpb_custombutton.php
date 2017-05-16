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
                        'btn-round' => 'Rounded button',
                        'btn-square'   => 'Square button',
                        'btn-skewed' => 'Skewed button',
                        'btn-round' => 'Round button',
                        'btn-3d' => '3D button',
                        'btn-outlined' => 'Outlined button',
                        'btn-square-outlined' => 'Square Outlined button',
                  ),
                  'std'       => 'align-center'
               ),
              
              array(
                  'id'        => 'color',
                  'type'      => 'select',
                  'title'     => t('Color'),
                  'options'   => array(
                      'btn-primary'   => 'Class Button Primary',
                      'btn-success'   => 'Class Button Success',
                      'btn-info'   => 'Class Button Info',
                      'btn-warning'   => 'Class Button Warning',
                      'btn-danger'   => 'Class Button Danger',
                      'btn-muted'   => 'Class Button muted',
                      'btn-color-theme' => 'Color Theme',
                      'btn-red'   => 'Button Red',
                      'btn-yellow'   => 'Button Yellow',
                      'btn-blue'   => 'Button Blue',
                      'btn-black'   => 'Button Black',
                      'btn-turquoise'   => 'Button Turquoise',
                      'btn-pink'   => 'Button Pink',
                      'btn-violet'   => 'Button Violet',
                      'btn-peacoc'   => 'Button Peacoc',
                      'btn-chino'   => 'Button Chino',
                      'btn-vista_blue'   => 'Button Vista Blue',
                      'btn-gray'   => 'Button Bray',
                      'btn-orange'   => 'Button Orange',
                      'btn-sky'   => 'Button Sky',
                      'btn-green'   => 'Button Green',
                      'btn-juicy_pink'   => 'Button Juicy Pink',
                      'btn-sandy_brown'   => 'Button Sandy Brown',
                      'btn-purple'   => 'Button Purple',
                      'btn-teal'   => 'Button Teal',
                      'btn-white'   => 'Button White',
                  ),
                  'std'       => 'btn-primary'
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
                  'id'        => 'size',
                  'type'      => 'select',
                  'title'     => t('Size'),
                  'options'   => array(
                        'btn-md' => 'Normal',
                        'btn-xs' => 'Mini',
                        'btn-sm' => 'Small',
                        'btn-lg' => 'Large',
                        'btn-xl' => 'Extra Large'
                  ),
                  'std'       => 'btn-md'
              ),
              
              array(
                  'id'        => 'block_button',
                  'type'      => 'select',
                  'title'     => t('Block Button'),
                  'options'   => array(
                        'no' => 'No',
                        'yes' => 'Yes',
                  ),
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
         return self::sc_custombutton( $item['fields'] );
      }


      public static function sc_custombutton( $attr, $content = null ){
        $target = '';
        if( isset($attr['target']) && '_blank' == $attr['target'] ) {
          $target = 'target="_blank"';
        }
        $title = ($attr['title']) ? $attr['title'] : 'Text on the Button';
        $text_button = $title;
        if(!empty($attr['add_icon'])) {
          $text_button = '<i class="'. $attr['chose_icon'] .'"></i> '. $title;
          if($attr['icon_align'] == 'icon-right') {
            $text_button = $title . ' <i class="'. $attr['chose_icon'] .'"></i>';
          }
        }
        
        $class = array();
        $class[] = 'btn';
        $class[] = $attr['shape'];
        $class[] = $attr['color'];
        $class[] = $attr['size'];
        $class[] = ($attr['block_button'] == 'yes') ? 'btn-block':''; 
        $output = '<div class="wrapper-custom-pagebuild-item-elemet wrapper-custom-pagebuild-custom-button '. $attr['el_class'] .'">';
        $output .= '<div class="inner-column-content">';
        $output .= '<div class="content '. $attr['align'] .' "><a '. $target .' href="'. $attr['url_link'] .'" class="'. implode($class, ' ') .'">'
             . $text_button . 
             '</a></div>';
        $output .= '</div>';
        $output .= '</div>';
        return array("#markup" => $output);
      }
   }
 endif;  
