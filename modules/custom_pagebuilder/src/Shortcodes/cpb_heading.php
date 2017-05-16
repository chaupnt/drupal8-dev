<?php 
namespace Drupal\custom_pagebuilder\Shortcodes;
if(!class_exists('cpb_heading')):
   class cpb_heading{
      public function render_form(){
         $fields = array(
            'type'      => 'cpb_heading',
            'title'     => t('Heading'), 
            'size'      => 3, 
            
            'fields'    => array(
               array(
                  'id'        => 'title',
                  'type'      => 'text',
                  'title'     => t('Title'),
                  'class'     => 'display-admin',
               ),
              
              array(
                  'id'        => 'sub_title',
                  'type'      => 'text',
                  'title'     => t('Sub Title'),
              ),
              
              array(
                  'id'        => 'heading_type',
                  'type'      => 'select',
                  'title'     => t('Heading Style'),
                  'options'   => array(
                        '' => 'Header Style',
                        'heading-border-top'   => 'Heading Border Top',
                        'heading-border-bottom'   => 'Heading Border Bottom',
                        'heading-short-border-top'   => 'Heading Short Border Top',
                        'heading-short-border-bottom'   => 'Heading Short Border Bottom', 
                        'heading-title-side-border-top' => 'Heading Title Side Border Top',
                        'heading-title-side-border-middle' => 'Heading Title Side Border Middle',
                        'heading-title-side-border-bottom' => 'Heading Title Side Border Bottom',
                        'heading-title-side-short-border-top' => 'Heading Title Side Short Border Top',
                        'heading-title-side-short-border-middle' => 'Heading Title Side Short Border Middle',
                        'heading-title-side-short-border-bottom' => 'Heading Title Side Short Border Bottom',
                  ),
                  'std'       => 'align-center'
               ),
              
              array(
                  'id'        => 'element_tag',
                  'type'      => 'select',
                  'title'     => t('Element Tag'),
                  'options'   => array(
                        'h2'   => 'H2',
                        'h3'   => 'H4',
                        'h4'   => 'H5',
                        'h5'   => 'H5',
                        'h6'   => 'H6',
                  ),
                  'std'       => 'h2'
               ),
              
               array(
                  'id'        => 'align',
                  'type'      => 'select',
                  'title'     => t('Align text for heading'),
                  'options'   => array(
                        'text-left'   => 'Align Left',
                        'text-center' => 'Align Center',
                        'text-right'  => 'Align Right'
                  ),
                  'std'       => 'align-center'
               ),
              
              array(
                  'id'        => 'text_color',
                  'type'      => 'select',
                  'title'     => t('Text Color'),
                  'options'   => array(
                    '' => 'Text Color',
                    'text-primary'   => 'Class Text Primary',
                    'text-success'   => 'Class Text Success',
                    'text-info'   => 'Class Text Info',
                    'text-warning'   => 'Class Text Warning',
                    'text-danger'   => 'Class Text Danger',
                    'text-muted'   => 'Class Text muted',
                    'text-color-theme' => 'Color Theme',
                    'text-red'   => 'Text Red',
                    'text-yellow'   => 'Text Yellow',
                    'text-blue'   => 'Text Blue',
                    'text-black'   => 'Text Black',
                    'text-turquoise'   => 'Text Turquoise',
                    'text-pink'   => 'Text Pink',
                    'text-violet'   => 'Text Violet',
                    'text-peacoc'   => 'Text Peacoc',
                    'text-chino'   => 'Text Chino',
                    'text-vista_blue'   => 'Text Vista Blue',
                    'text-gray'   => 'Text Bray',
                    'text-orange'   => 'Text Orange',
                    'text-sky'   => 'Text Sky',
                    'text-green'   => 'Text Green',
                    'text-juicy_pink'   => 'Text Juicy Pink',
                    'text-sandy_brown'   => 'Text Sandy Brown',
                    'text-purple'   => 'Text Purple',
                    'text-teal'   => 'Text Teal',
                    'text-white'   => 'Text White',
                  ),
                  'std'       => '',
              ),
              
              array(
                'id' => 'animate',
                'type' => 'select',
                'title' => t('Animation Icon'),
                'desc' => t('Entrance animation for element'),
                'options' => custom_pagebuilder_animate(),
              ),
              array(
                'id' => 'duration',
                'type' => 'text',
                'title' => ('Anumate Duration'),
                'desc' => ('Change the animation duration'),
                'class' => 'small-text',
              ),
              array(
                'id' => 'delay',
                'type' => 'text',
                'title' => ('Anumate Delay'),
                'desc' => ('Delay before the animation starts'),
                'class' => 'small-text',
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
         return self::sc_heading( $item['fields'], $item['fields']['content'] );
      }

      public static function sc_heading( $attr, $content = null ){
         $class = array();
         $class[] = (!empty($attr['el_class'])) ? $attr['el_class']: '';
         $class[] = $attr['align'];
         $color_text = (!empty($attr['text_color'])) ? $attr['text_color']: '';
         $output = '<div class="wrapper-custom-pagebuild-item-elemet wrapper-custom-pagebuilder-heading">';
         //$output .= '<div class="widget  '. implode(' ', $class) .'">';
         
         if($attr['title']) {
           switch ($attr['element_tag']) {
             case 'h2':
               $o_t = '<h2 class="cbp-title-heading '. $color_text .' ">';
               $c_t = '</h2>';
               break;
             case 'h3':
               $o_t = '<h3 class="cbp-title-heading '. $color_text .'">';
               $c_t = '</h3>';
               break;
             case 'h4':
               $o_t = '<h4 class="cbp-title-heading '. $color_text .'">';
               $c_t = '</h4>';
               break;
             case 'h5':
               $o_t = '<h5 class="cbp-title-heading '. $color_text .'">';
               $c_t = '</h5>';
               break;
             case 'h6':
               $o_t = '<h6 class="cbp-title-heading '. $color_text .'">';
               $c_t = '</h6>';
               break;
           }
           $sub_title = '';
           if(!empty($attr['sub_title'])) {
             $sub_title = '</br><span class="cpb-sub-title-text">'. $attr['sub_title'] .'</span>';
           }
           
          // Amination Box
          
          $class[] = (!empty($attr['heading_type'])) ? $attr['heading_type']:'';
          
          $duration = '';
          $delay = '';
          if(!empty($attr['animate'])) {
            $class[] = ' wow '. $attr['animate'];
            $duration = !empty($attr['duration']) ? 'data-wow-duration='.$attr['duration'].'s' : '';
            $delay = !empty($attr['delay']) ? 'data-wow-delay='.$attr['delay'].'s' : '';
          }
           
           $output .= '<div class="custom-pagebuilder-heading '. implode(" ", $class) .'" {{ duration }} {{ delay }} >';
            $output .= $o_t;
               $output .= '<span class="cpb-title-text">' . $attr['title'] . '</span>' . $sub_title;
            $output .= $c_t;
           $output .= '</div>';
         }
         
         $output .= '<div class="clearfix"></div>';
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
endif;

