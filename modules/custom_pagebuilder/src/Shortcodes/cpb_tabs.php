<?php 
namespace Drupal\custom_pagebuilder\Shortcodes;
if(!class_exists('cpb_tabs')):
   class cpb_tabs{

      public function render_form(){
         $fields = array(
            'type'   => 'cpb_tabs',
            'title'  => t('Tabs Or Accordion'), 
            'size'   => 3, 
            
            'fields' => array(
         
               array(
                  'id'        => 'title',
                  'type'      => 'text',
                  'title'     => t('Title'),
                  'class'     => 'display-admin'
               ),
               
              array(
                  'id'        => 'type',
                  'type'      => 'select',
                  'title'     => t('Type'),
                  'options'   => array(
                    'tabs'  => 'Tabs',
                    'accordion' => 'Accordion',
                  )
              ),
              
               array(
                  'id'        => 'tabs',
                  'type'      => 'tabs',
                  'title'     => t('Tabs'),
                  'sub_desc'  => t('To add an <strong>icon</strong> in Title field, please use the following code:<br/><br/>&lt;i class=" icon-lamp"&gt;&lt;/i&gt; Tab Title'),
                  'desc'      => t('You can use Drag & Drop to set the order.'),
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
         return self::sc_tabs( $item['fields'] );
      }


      public static function sc_tabs( $attr, $content = null ){
        //kint($attr['tabs'][2]);
        $script = '';
        $output = '';
        
        if($attr['type'] == 'tabs') {
          $_id = 'tab-'.custom_pagebuilder_makeid();
          if(!empty($attr['tabs']) && is_array($attr['tabs'])) {
            
            $output .= '<div id="builder-tabs-'. $_id .'" class="wraper-custom-pagebuilder-tabs">';
            $output .= '<ul class="nav nav-tabs" role="tablist">';

                foreach($attr['tabs'] as $key=>$value) {
                  if($key == 0) {
                    $output .= '<li role="presentation" class="active nav-item">'
                        . '<a class="nav-link" href="#'. $_id .'_'. $key .'" aria-controls="'. $_id .'_.'. $key .'" role="tab" data-toggle="tab">
                      '. $value['title'] .'</a></li>' ;
                  } else {
                    $output .= '<li role="presentation" class="nav-item" >'
                        . '<a class="nav-link" href="#'. $_id .'_'. $key .'" aria-controls="'. $_id .'_.'. $key .'" role="tab" data-toggle="tab">
                      '. $value['title'] .'</a></li>' ;
                  }
                }
            $output .= '</ul>';

            $output .= '<div class="tab-content">';

            foreach($attr['tabs'] as $key=>$value) {
                  if($key == 0) {
                    $output .= '<div role="tabpanel" class="tab-pane active" id="'. $_id .'_'. $key .'">'. $value['content'] .'</div>' ;
                  } else {
                    $output .= '<div role="tabpanel" class="tab-pane" id="'. $_id .'_'. $key .'">'. $value['content'] .'</div>' ;
                  }
            }
            $output .= '</div>';
            $output .= '</div>';
          }
        } else {
          $_id = 'tab-'.custom_pagebuilder_makeid();
          if(is_array($attr['tabs'])) {
            $output .= '<div class="panel-group" id="wrapper-custom-pagebuider-'. $_id .'" role="tablist" aria-multiselectable="true">';
              $output .= '<div class="panel panel-default">';
                  foreach ($attr['tabs'] as $key=>$value) {
                    $output .= '<div class="panel-heading" role="tab" id="heading'. $_id .'-'. $key .'">';
                    $output .= '<h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#wrapper-custom-pagebuider-'. $_id .'" 
                                  href="#collapse-'. $_id .'-'. $key .'" aria-expanded="true" aria-controls="collapse-'. $_id .'-'. $key .'">
                                  ' . $value['title'] . '
                                </a>
                              </h4>';
                    $output .= '</div>';
                    
                    $output .= '<div id="collapse-'. $_id .'-'. $key .'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading'. $_id .'-'. $key .'">';
                      
                      $output .= '<div class="panel-body">';
                        $output .=$value['content'];
                      $output .= '</div>';
                    $output .= '</div>';
                    
                  }
              $output .= '</div>';
            $output .= '</div>';
          }
        }
        
        //return array('#markup' => $output);
        return array(
                    '#type' => 'inline_template',
                    '#template' => $output,
                    '#context' => array(),
                  );
        
      }
   }
endif;


