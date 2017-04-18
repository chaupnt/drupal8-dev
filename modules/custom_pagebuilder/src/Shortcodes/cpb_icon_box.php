<?php 
namespace Drupal\custom_pagebuilder\Shortcodes;
if(!class_exists('cpb_icon_box')):
   class cpb_icon_box{

      public function render_form(){
         $fields = array(
            'type' => 'cpb_icon_box',
            'title' => ('Icon Box'), 
            'size' => 3,'fields' => array(
         
               array(
                  'id'        => 'title',
                  'type'      => 'text',
                  'title'     => t('Title'),
                  'class'     => 'display-admin'
               ),
               array(
                  'id'        => 'content',
                  'type'      => 'textarea',
                  'title'     => t('Content'),
                  'desc'      => t('Some Shortcodes and HTML tags allowed'),
               ),
         
               array(
                  'id'           => 'add_icon',
                  'type'         => 'checkboxs',
                  'title'        => t('Use icon ?'),
                  'options'      => array(
                    'add_icon'  => 'add_icon', 
                  ), 
                  'default_value' => 'add_icon',
               ),
              
              array(
                  'id'           => 'chose_icon',
                  'type'         => 'icon_font',
                  'title'        => t('Chose Icon'), 
              ),
              
               array(
                  'id'        => 'icon_size',
                  'type'      => 'select',
                  'title'     => 'Icon font size',
                  'options'   => array(''=>'Default', 14, 16, 18, 20, 22, 24, 26, 28, 30, 32, 34, 36, 38, 40, 42, 44, 46, 48, 50, 52, 54, 56, 58, 60)
               ),
              
               array(
                  'id'        => 'icon_color',
                  'type'      => 'color',
                  'title'     => t('Icon Color'),
                  'desc'      => t('Color for icon, e.g: #000'),
                  'std'       => '',
               ),
               array(
                  'id'        => 'image',
                  'type'      => 'upload',
                  'title'     => t('Icon image'),
               ),
               
               array(
                  'id'            => 'icon_position',
                  'type'          => 'select',
                  'options'       => array(
                     'top-center'      => 'Top Center',
                     'top-left'        => 'Top Left',
                     'top-right'       => 'Top Right',
                     'right'           => 'Right',
                     'left'            => 'Left',
                     'top-left-title'  => 'Top Left Title',
                     'top-right-title' => 'Top Right Title',
                  ),
                  'title'  => t('Icon Position'),
                  'std'    => 'top',
               ),
               
               array(
                  'id'        => 'link',
                  'type'      => 'text',
                  'title'     => t('Link'),
                  'desc'      => t('Link for text')
               ),

               array(
                  'id'        => 'bg_color',
                  'type'      => 'color',
                  'title'     => t('Background color'),
                  'desc'      => t('Background for icon box, e.g: #f5f5f5')
               ),

               array(
                  'id'        => 'skin_text',
                  'type'      => 'select',
                  'title'     => 'Skin Text for box',
                  'options'   => array(
                     'text-dark'  => t('Text Dark'), 
                     'text-light' => t('Text Light')
                  ) 
               ),
               
               array(
                  'id'        => 'target',
                  'type'      => 'select',
                  'options'   => array( 'off' => 'No', 'on' => 'Yes' ),
                  'title'     => t('Open in new window'),
                  'desc'      => t('Adds a target="_blank" attribute to the link.'),
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
         return self::sc_icon_box( $item['fields'], $item['fields']['content'] );
      }


      public static function sc_icon_box( $attr, $content = null ){
         global $base_url;


         // target
         if( $attr['target'] == 'on' ){
            $target = 'target="_blank"';
         } else {
            $target = false;
         }

         $icon_content = '';
         if(!empty($attr['add_icon'])) {
           $icon_content = '<i style="{{ style_icon }}" class="'. $attr['chose_icon'] .'"></i>';
         } elseif(isset($attr['image'])) {
           $alt = (isset($attr['alt_img'])) ? $attr['alt_img'] : '';
           $icon_content = '<img src="'. $attr['image'] .'" alt="'. $alt .'" />';
         }
         
         // Amination Box
         $class_animate = '';
         $duration = '';
         $delay = '';
         if(!empty($attr['animate'])) {
           $class_animate = ' wow '. $attr['animate'];
           $duration = !empty($attr['duration']) ? 'data-wow-duration='.$attr['duration'].'s' : '';
           $delay = !empty($attr['delay']) ? 'data-wow-delay='.$attr['delay'].'s' : '';
         }
         
         // Class Box
         $class = array();
         if($attr['el_class']){ $class[] = $attr['el_class']; }
         $class[] = $attr['icon_position'];
         if($attr['skin_text']){
           $class[] = $attr['skin_text'];
         }

         //Background color
         $style = array();
         if($attr['bg_color']){
            $style[] = 'background-color: ' . $attr['bg_color'];
         }
         
         
         $style_icon = array();
         if($attr['icon_size']){
            $style_icon[] = 'font-size: ' . (14 + 2*$attr['icon_size']) .'px';
         }
         if($attr['icon_color']){
            $style_icon[] = 'color: ' . $attr['icon_color'];
         }
         
         
         
         $output = '<div style="{{ style_box }}" class="wrapper-custom-pagebuilder-icon-box '. implode($class, ' ') .' ">';
            $output .= '<div class="inner-icon-box">';
            if(!empty($icon_content)) {
              $output .= '<div class="highlight-image-icon">'
                  . '<div class="icon-content '. $class_animate .'" {{ duration }} {{ delay }} >'. $icon_content .'</div></div>';
            }
            $output .= '<div class="highlight_content">';
              if($attr['title']) {
                $output .= '<h3>'. $attr['title'] .'</h3>';
              }
              if($attr['content']) {
                $output .= '<div class="desc">'. $attr['content'] .'</div>';
              }
            $output .= '</div>';
            $output .= '</div>';
         $output .= '</div>';
         
         return array(
                    '#type' => 'inline_template',
                    '#template' => $output,
                    '#context' => array(
                      'style_icon' => implode(";", $style_icon),
                      'duration' => $duration,
                      'style_box' => implode(";", $style),
                    ),
                  ); 
         
      }
   }
endif;   




