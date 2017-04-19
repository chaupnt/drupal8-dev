<?php 
namespace Drupal\custom_pagebuilder\Shortcodes;
if(!class_exists('cpb_image')):
   class cpb_image{
      
      public function render_form(){
         $fields =array(
            'type' => 'cpb_image',
            'title' => ('Image'), 
            'size' => 3,
            'fields' => array(
               array(
                  'id'        => 'image',
                  'type'      => 'upload',
                  'title'     => t('Image'),
               ),
               array(
                  'id'        => 'align',
                  'type'      => 'select',
                  'title'     => t('Align Image'),
                  'options'   => array( 
                     'text-left'      => 'Left', 
                     'text-right'     => 'Right', 
                     'text-center'    => 'Center', 
                  ),
               ),
               array(
                  'id'     => 'alt',
                  'type'      => 'text',
                  'title'  => t('Alternate Text'),
               ),
               array(
                  'id'     => 'link',
                  'type'      => 'text',
                  'title'  => t('Link')
               ),
               array(
                  'id'     => 'target',
                  'type'      => 'select',
                  'options'   => array( 'off' => 'No', 'on' => 'Yes' ),
                  'title'  => t('Open in new window'),
                  'desc'      => t('Adds a target="_blank" attribute to the link.'),
               ),
               array(
                  'id'     => 'animate',
                  'type'      => 'select',
                  'title'  => t('Animation'),
                  'sub_desc'  => t('Entrance animation'),
                  'options'   => custom_pagebuilder_animate(),
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
         return self::sc_image( $item['fields'] );
      }

      public static function sc_image( $attr, $content = null ){
         $output = '';
         $class_array = array();
         $class_array[] = 'wow ' . $attr['animate'];
         $class_array[] = $attr['el_class'];
         $class_array[] = $attr['align'];
         $alt = (!empty($attr['alt'])) ? $attr['alt'] : '';
         if( $attr['target'] =='on' ){
            $target = 'target="_blank"';
         } else {
            $target = '';
         }
         $image = '';
         if(!empty($attr['image'])) {
           $image = '<img src="'. $attr['image'] .'" />';
         }
         
         $output .= '<div class="wrapper-custom-pagebuideer-image">';
          $output .= '<div class="content-image '. implode(" ", $class_array) .' ">';
            if($attr['link']) {
              $output .= '<a '. $target .' alt="'. $alt .'" href="'. $attr['link'] .'">'. $image .'</a>';
            } else {
              $output .= $image;
            }
          $output .= '</div>';
         $output .= '</div>';
         return array('#markup' => $output);
      }
      
   }
endif;   




