<?php 
namespace Drupal\custom_pagebuilder\Shortcodes;
if(!class_exists('cpb_textblock')):
   class cpb_textblock{
      public function render_form(){
         $fields = array(
            'type' => 'cpb_textblock',
            'title' => t('Text Block'),
            'size' => 2,
            'fields' => array(

               array(
                  'id'           => 'content',
                  'type'         => 'textarea',
                  'title'        => t('Column content'),
                  'desc'         => t('Shortcodes and HTML tags allowed.'),
                  'shortcodes'   => 'on'
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
         $output = '<div class="wrapper-custom-pagebuild-item-elemet wrapper-custom-pagebuild-textblock '. $attr['el_class'] .'">';
         $output .= '<div class="inner-column-content">';
         $output .= '<div class="content">' . $attr['content'] . '</div>';
         $output .= '</div>';
         $output .= '</div>';
         return array('#markup' => $output);
      }
   }
 endif;  



