<?php 
namespace Drupal\custom_pagebuilder\Shortcodes;
if(!class_exists('cpb_box_info')):
   class cpb_box_info{
      public function render_form(){
         return array(
           'type'          => 'cpb_box_info',
            'title'        => t('Box Info Background'),
            'size'         => 3,
            'fields' => array(
               array(
                  'id'        => 'title',
                  'type'      => 'text',
                  'title'     => t('Title'),
                  'class'     => 'display-admin'
               ),
                array(
                  'id'        => 'subtitle',
                  'type'      => 'text',
                  'title'     => t('Sub Title')
               ),
               array(
                  'id'        => 'image',
                  'type'      => 'upload',
                  'title'     => t('Image'),
                  'desc'      => t('Image for box info'),
               ),
               array(
                  'id'        => 'content',
                  'type'      => 'textarea',
                  'title'     => t('Content'),
                  'desc'      => t('Content for box info'),
               ),
               array(
                  'id'        => 'height',
                  'type'      => 'text',
                  'title'     => t('Min height'),
                  'desc'      => t('Min height for content info box. e.g. 300px'),
               ),
               array(
                  'id'        => 'content_align',
                  'type'      => 'select',
                  'title'     => t('Content Align'),
                  'desc'      => t('Align Content for box info'),
                  'options'   => array( 
                    'text-left' => 'Left', 
                    'text-right' => 'Right',
                    'text-center' => 'Center'
                   ),
                  'std'       => 'text-left'
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
            return self::sc_box_info( $item['fields'], $item['fields']['content'] );
      }

      public static function sc_box_info( $attr, $content = null ){
         global $base_path;
         //kint($attr['height']);
         $output = '';
         $image_bg = '';
         if($attr['image']) {
           $image_bg = 'background-image:url('.$attr['image'].')';
         }

         $style_content = '';
         $height = (!empty($attr['height'])) ? 'min-height:' . $attr['height'] : '';
         //kint($height);
         $class_aray = array();
         $class_aray[] = ($attr['el_class']) ? $attr['el_class']:'';
         $class_aray[] = $attr['content_align'];
         
         $output .= '<div class="widget wrapper-custom-pagebuild-box-info '.implode(" ", $class_aray).'" style="'. $height .'">';
            $output .= '<div class="clearfix">';
              $output .= '<div class="image" style="'. $image_bg .'"></div>';
                $output .= '<div class="content" >';
                  $output .= '<div class="content-inner">';
                    if($attr['title']){
                      $output .= '<div class="title"><h2>'. $attr['title'] .'</h2></div>';
                    }
                    if($attr['subtitle']){
                      $output .= '<div class="subtitle"><span>'. $attr['subtitle'] .'</span></div>';
                    }
                    if($attr['content']){
                      $output .= '<div class="desc">'. $attr['content'] .'</div>';
                    }
          $output .= '</div></div></div></div>';
          kint($output);
          return $output;
      } 
   }
endif;   
