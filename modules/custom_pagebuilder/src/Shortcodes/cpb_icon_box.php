<?php 
namespace Drupal\custom_pagebuilder\Shortcodes;
if(!class_exists('cpb_icon_box')):
   class cpb_icon_box{

      public function render_form(){
         $fields = array(
            'type' => 'cpb_icon_box',
            'title' => ('Icon Box'), 
            'size' => 3,
            'fields' => array(
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
                  'id'        => 'iconboxstyle',
                  'type'      => 'select',
                  'title'     => 'Box Style',
                  'options'   => array(
                    ''=>'Default',
                    'icon-style-default' => 'Simple Ultimate',
                    'icon-style-medium' => 'Boxed',
                  )
               ),
              
               array(
                  'id'        => 'icon_size',
                  'type'      => 'select',
                  'title'     => 'Icon font size',
                  'options'   => array(
                    ''=>'Default',
                    'icon-size-small' => 'Small',
                    'icon-size-medium' => 'Medium',
                    'icon-size-large' => 'Large',
                    'icon-size-xlarge' => 'X-large',
                  )
               ),
              
               array(
                  'id'        => 'icon_color',
                  'type'      => 'select',
                  'title'     => t('Icon Color'),
                  'options'   => array(
                      'icon-color-color_theme' => 'Color Theme',
                      'icon-color-primary'   => 'Class Icon Color Primary',
                      'icon-color-success'   => 'Class Icon Color Success',
                      'icon-color-info'   => 'Class Icon Color Info',
                      'icon-color-warning'   => 'Class Icon Color Warning',
                      'icon-color-danger'   => 'Class Icon Color Danger',
                      'icon-color-muted'   => 'Class Icon Color muted',
                      'icon-color-red'   => 'Icon Color Red',
                      'icon-color-yellow'   => 'Icon Color Yellow',
                      'icon-color-blue'   => 'Icon Color Blue',
                      'icon-color-black'   => 'Icon Color Black',
                      'icon-color-turquoise'   => 'Icon Color Turquoise',
                      'icon-color-pink'   => 'Icon Color Pink',
                      'icon-color-violet'   => 'Icon Color Violet',
                      'icon-color-peacoc'   => 'Icon Color Peacoc',
                      'icon-color-chino'   => 'Icon Color Chino',
                      'icon-color-vista_blue'   => 'Icon Color Vista Blue',
                      'icon-color-gray'   => 'Icon Color Bray',
                      'icon-color-orange'   => 'Icon Color Orange',
                      'icon-color-sky'   => 'Icon Color Sky',
                      'icon-color-green'   => 'Icon Color Green',
                      'icon-color-juicy_pink'   => 'Icon Color Juicy Pink',
                      'icon-color-sandy_brown'   => 'Icon Color Sandy Brown',
                      'icon-color-purple'   => 'Icon Color Purple',
                      'icon-color-teal'   => 'Icon Color Teal',
                      'icon-color-white'   => 'Icon Color White',
                  ),
                  'desc'      => t('Color for icon'),
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
                     'left'            => 'Left',
                  ),
                  'title'  => t('Icon Position'),
                  'std'    => 'top',
               ),
               
               array(
                  'id'        => 'link',
                  'type'      => 'text',
                  'title'     => t('Link'),
                  'desc'      => t('Link for Box')
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
                     ''  => t('Text Default'), 
                     'text-color-dark'  => t('Text Dark'), 
                     'text-color-light' => t('Text Light')
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
         $class[] = (!empty($attr['iconboxstyle'])) ? $attr['iconboxstyle']:'';
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
            $class[] = $attr['icon_size'];
         }
         if($attr['icon_color']){
            //$style_icon[] = 'color: ' . $attr['icon_color'];
           $class[] = $attr['icon_color'];
         }
         
         $title_box = '';
         if(!empty($attr['title'])) {
           $title_box = '<h3>'. $attr['title'] .'</h3>';
           if(!empty( $attr['link'] )) $title_box = '<h3><a href="'. $attr['link'] .'">'. $attr['title'] .'</a></h3>';
         }
         
         
         $output = '<div style="{{ style_box }}" class="wrapper-custom-pagebuilder-icon-box '. implode($class, ' ') .' ">';
            $output .= '<div class="inner-icon-box">';
            if(!empty($icon_content)) {
              $output .= '<div class="highlight-image-icon">'
                  . '<div class="icon-content '. $class_animate .'" {{ duration }} {{ delay }} >'. $icon_content .'</div></div>';
            }
            $output .= '<div class="highlight_content">';
              if($attr['title']) {
                $output .= $title_box;
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
                      'delay' => $delay,
                    ),
                  ); 
         
      }
   }
endif;   




