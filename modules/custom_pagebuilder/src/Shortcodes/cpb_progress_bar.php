<?php 
namespace Drupal\custom_pagebuilder\Shortcodes;
if(!class_exists('cpb_progress_bar')):
   class cpb_progress_bar{

      public function render_form(){
         $fields = array(
            'type'   => 'cpb_progress_bar',
            'title'  => t('Progress Bar'),
            'size'   => 3,
            'icon'   => 'fa fa-bars',
            'fields' => array(
              array(
                  'id'        => 'title',
                  'type'      => 'text',
                  'title'     => t('Title'),
                  'class'     => 'display-admin'
               ),
               array(
                  'id'        => 'percent',
                  'type'      => 'text',
                  'title'     => t('Percent'),
                  'desc'      => t('Number between 0-100 (Percent)'),
               ),
               array(
                  'id'        => 'background',
                  'type'      => 'color',
                  'title'     => t('Background Color'),
                  'desc'      => 'Background color for progress'
               ),
              
              array(
                  'id'        => 'animated_striped',
                  'type'      => 'select',
                  'title'     => t('Animated Striped'),
                  'options'   => array(
                    'no' => 'No',
                    'yes' => 'Yes',
                  ),
              ),
              
              
               array(
                  'id'        => 'skin_text',
                  'type'      => 'select',
                  'title'     => 'Skin Text for box',
                  'options'   => array(
                     'text-light' => t('Text Light'),
                     'text-dark'  => t('Text Dark') 
                  ) 
               ),
              
               array(
                  'id'        => 'animate',
                  'type'      => 'select',
                  'title'     => t('Animation'),
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
         return self::sc_progress( $item['fields'] );
      }


      public static function sc_progress( $attr, $content = null ){
         $style = '';
         $title = (!empty($attr['title'])) ? $attr['title']:'';
         $percent = (!empty($attr['percent'])) ? $attr['percent']:'0';
         $style = array();
         if(!empty($attr['background'])) $style[] = 'background-color: ' . $attr['background'];
         $style[] = 'width: '. $percent .'%';
         $class_array = array();
         $class_array[] = (!empty($attr['el_class'])) ? $attr['el_class'] : '';
         $class_array[] = (!empty($attr['skin_text'])) ? $attr['skin_text'] : '';
         
         $class_animate = '';
         if($attr['animated_striped'] == 'yes') {
           $class_animate = ' progress-bar-striped active ';
         }
         
         // Amination Box
         $class_animate = '';
         $duration = '';
         $delay = '';
         if(!empty($attr['animate'])) {
           $class_array[] = ' wow '. $attr['animate'];
           $duration = !empty($attr['duration']) ? 'data-wow-duration='.$attr['duration'].'s' : '';
           $delay = !empty($attr['delay']) ? 'data-wow-delay='.$attr['delay'].'s' : '';
         }
         
         $output = '<div class="widget wrapper-custombuider-progress-bar '. implode(' ', $class_array) .' " {{ duration }} {{ delay }} >';
            $output .= '<div class="progress">';
              $output .= '<div style="{{ style_prog }}" class="progress-bar '. $class_animate .' " role="progressbar" aria-valuenow="'. $percent .'" aria-valuemin="0" aria-valuemax="100" >';
                $output .= $title;
              $output .= '</div>';
            $output .= '</div>';
         $output .= '</div>';
         
         return array(
                    '#type' => 'inline_template',
                    '#template' => $output,
                    '#context' => array(
                      'style_prog' => implode(";", $style),
                      'duration' => $duration,
                      'delay' => $delay
                    ),
                  ); 
         
      }
   }
 endif;  



