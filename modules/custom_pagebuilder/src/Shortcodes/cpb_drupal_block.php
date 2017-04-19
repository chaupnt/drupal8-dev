<?php 
namespace Drupal\custom_pagebuilder\Shortcodes;
if(!class_exists('cpb_drupal_block')):
   class cpb_drupal_block{
      public function render_form(){
         $fields = array(
            'type' => 'cpb_drupal_block',
            'title' => ('Drupal Block'),
            'size' => 12,
            
            'fields' => array(
               array(
                  'id'        => 'title',
                  'type'      => 'text',
                  'title'     => t('Title display Admin'),
                  'std'       => '',
                  'class'     => 'display-admin'
               ),
               array(
                  'id'        => 'block_drupal',
                  'type'      => 'select',
                  'title'     => t('Block for drupal'),
                  'options'   => custom_pagebuilder_get_blocks_options(),
                  'std'       => '',
               ),
               array(
                  'id'        => 'hidden_title',
                  'type'      => 'select',
                  'title'     => t('Hidden title'),
                  'options'   => array('on' => 'Display', 'off'=>'Hidden'),
                  'std'       => 'on',
                  'desc'      => t('Hidden title default for block')
               ),
               array(
                  'id'        => 'align_title',
                  'type'      => 'select',
                  'title'     => t('Align title'),
                  'options'   => array('title-align-left' => 'Align Left', 'title-align-right'=>'Align Right', 'title-align-center' => 'Align Center'),
                  'std'       => 'title-align-center',
                  'desc'      => t('Align title default for block')
               ),
               array(
                  'id'        => 'remove_margin',
                  'type'      => 'select',
                  'title'     => ('Remove Margin'),
                  'options'   => array('on' => 'Yes', 'off'=>'No'),
                  'std'       => 'off',
                  'desc'      => t('Defaut block margin bottom 30px, You can remove margin for block')
               ),
               array(
                  'id'        => 'style_text',
                  'type'      => 'select',
                  'title'     => t('Skin Text for box'),
                  'options'   => array(
                     'text-dark'   => 'Text dark',
                     'text-light'   => 'Text light',
                  ),
                  'std'       => 'text-dark'
               ),
               array(
                  'id'        => 'el_class',
                  'type'      => 'text',
                  'title'     => t('Extra class name'),
                  'desc'      => t('Style particular content element differently - add a class name and refer to it in custom CSS.'),
               ),
               array(
                  'id'        => 'animate',
                  'type'      => 'select',
                  'title'     => t('Animation'),
                  'desc'      => t('Entrance animation'),
                  'options'   => custom_pagebuilder_animate(),
               ),
            ),                                      
         );
         return $fields;
      }

      public function render_content( $item ) {
         return self::sc_drupal_block( $item['fields'] );
      }

      public function sc_drupal_block( $attr, $content = null ){
        $ourput = '';
         $output = '';
         $class = array();
         $class[] = $attr['align_title']; 
         $class[] = $attr['el_class'];
         $class[] = 'hidden-title-' . $attr['hidden_title'];
         $class[] = 'remove-margin-' . $attr['remove_margin'];
         $class[] = $attr['style_text'];

         if($attr['block_drupal']){
            $ourput = '<div class="wrapper-custom-pagebuild-item-elemet wrapper-custom-pagebuild-block-drupal '.implode($class, ' ') .'">';
              $ourput .= custom_pagebuilder_render_block($attr['block_drupal']);
            $ourput .= '</div>';
         }  
         return array(
                    '#type' => 'inline_template',
                    '#template' => $ourput,
                    '#context' => array(),
                  );
      }
   }
endif;
   



