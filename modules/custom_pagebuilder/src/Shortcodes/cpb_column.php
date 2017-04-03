<?php 
namespace Drupal\custom_pagebuilder\Shortcodes;
if(!class_exists('cpb_column')):
   class cpb_column{

      public function render_form(){
         $fields = array(
            'type' => 'cpb_column',
            'title' => t('Text - Shortcode'),
            'size' => 3,
            'fields' => array(
               
               array(
                  'id'     => 'title',
                  'type'      => 'text',
                  'title'  => t('Title'),
                   'class'     => 'display-admin'
               ),

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
        
         extract(shortcode_atts(array(
            'title'      => '',
            'content'    => '',
            'el_class'    => ''
         ), $attr));
         $ourput = '<div class="column-content '.$el_class.'">';
         $ourput .= do_shortcode( $content );
         $ourput .= '</div>';
         return $ourput;
      }

      public function load_shortcode(){
         add_shortcode( 'column', array('cpb_column', 'sc_column') );
      }
   }
 endif;  



