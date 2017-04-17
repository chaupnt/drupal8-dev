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
                  'id'        => 'element_tag',
                  'type'      => 'select',
                  'title'     => t('Element Tag'),
                  'options'   => array(
                        'h1'   => 'H1',
                        'h2'   => 'H2',
                        'h3'   => 'H4',
                        'h4'   => 'H5',
                        'h5'   => 'H5',
                        'h6'   => 'H6',
                        'p'   => 'p',
                        'div'   => 'div'
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
         $class[] = $attr['el_class'];
         $class[] = $attr['align'];
         $output = '<div class="wrapper-custom-pagebuild-item-elemet wrapper-custom-pagebuilder-heading">';
         $output .= '<div class="widget custom-pagebuilder-heading '. implode($class, ' ') .'">';
         
         if($attr['title']) {
           switch ($attr['element_tag']) {
             case 'h1':
               $o_t = '<h1>';
               $c_t = '</h1>';
               break;
             case 'h2':
               $o_t = '<h2>';
               $c_t = '</h2>';
               break;
             case 'h3':
               $o_t = '<h3>';
               $c_t = '</h3>';
               break;
             case 'h4':
               $o_t = '<h4>';
               $c_t = '</h4>';
               break;
             case 'h5':
               $o_t = '<h5>';
               $c_t = '</h5>';
               break;
             case 'h6':
               $o_t = '<h6>';
               $c_t = '</h6>';
               break;
             case 'p':
               $o_t = '<p>';
               $c_t = '</p>';
               break;
             case 'div':
               $o_t = '<div>';
               $c_t = '</div>';
               break;
           }
           
           $output .= $o_t;
              $output .= $attr['title'];
           $output .= $c_t;
         }
         
         $output .= '</div><div class="clearfix"></div>';
         $output .= '</div>';
         return $output;
      }
      
   }
endif;

