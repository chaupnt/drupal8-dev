<?php
namespace Drupal\custom_pagebuilder\includes\core;
class ClassCustomPagebuilder {

  protected $cb_shortcodes = array();
  protected $title = '';
  protected $params = '';
  protected $rows_cound = 0;
  public function __construct($pid){
    $result = db_select('{gavias_blockbuilder}', 'd')
          ->fields('d')
          ->condition('id', $pid, '=')
          ->execute()
          ->fetchObject();
    $pbd_single = new \stdClass();
    if($result){
      $this->title =  $result->title;
      $this->params = $result->params;  
    }
  }
  
  public function get_title() {  return $this->title;}
  public function get_params() { return $this->params;}
  public function get_json_decode() {
    $gbb_els = base64_decode($this->get_params());
    $gbb_els = json_decode($gbb_els, true);
    if( is_array( $gbb_els ) && ! key_exists( 'attr', $gbb_els[0] ) ){
  		$gbb_els_new = array(
  			'attr'	=> $this->row_opts(),
  			'items'	=> $gbb_els
  		);
      $gbb_els = array( $gbb_els_new );
    }
		
    return  $gbb_els;
  }
  
  function get_rows_count() {
    return is_array( $this->get_json_decode() ) ? count( $this->get_json_decode() ) : 0;
  }
  
  public function custom_pagebuilder_get_list_shortcodes(){
    $theme_default = \Drupal::config('system.theme')->get('default');
    $theme_path =  $theme_name = drupal_get_path('theme', $theme_default);

    $shortcodes = array();
    if( empty($this->cb_shortcodes) ){
      
      $shortcodes_theme = array(); 
      
      if(function_exists('gavias_blockbuilder_override_shortcodes')){
        $shortcodes_theme = gavias_blockbuilder_override_shortcodes(); //theme_name/includes/shortcodes.php
      }

      $shortcodes_module = custom_pagebuilder_list_shortcodes(); //this module 

      $shortcodes = array_merge($shortcodes_theme, $shortcodes_module);
    }
    //print_r($shortcodes);die();
    return $shortcodes;
  }

  public function custom_pagebuilder_load_file_shortcodes(){
   $theme_default = \Drupal::config('system.theme')->get('default');
   $theme_path =  $theme_name = drupal_get_path('theme', $theme_default);
    if( empty($this->cb_shortcodes) ){

      $shortcodes = $this->custom_pagebuilder_get_list_shortcodes();

      foreach( $shortcodes as $sc ){
        $sc_path = '';
        if(file_exists($theme_path . '/gavias_shortcodes/' . $sc . '.php')){
          $sc_path = $theme_path . '/gavias_shortcodes/' . $sc . '.php';
        }else if(file_exists(CUSTOM_PAGEBUILDER_PATH . '/shortcodes/' . $sc . '.php')){
          $sc_path = CUSTOM_PAGEBUILDER_PATH . '/shortcodes/' . $sc . '.php';
        }
        if($sc_path){
          require($sc_path);
        }
      }  
    }
  }

  public function custom_pagebuilder_load_shortcodes( $backend=true ){
    if( empty($this->cb_shortcodes) ) {
      $theme_default = \Drupal::config('system.theme')->get('default');
      $theme_path =  $theme_name = drupal_get_path('theme', $theme_default);
      $shortcodes = $this->custom_pagebuilder_get_list_shortcodes();
      foreach( $shortcodes as $sc ){
        $sc_path = '';
        if(file_exists($theme_path . '/gavias_shortcodes/' . $sc . '.php')){
          $sc_path = $theme_path . '/gavias_shortcodes/' . $sc . '.php';
        }else if(file_exists(GAVIAS_BLOCKBUILDER_PATH . '/shortcodes/' . $sc . '.php')){
          $sc_path = GAVIAS_BLOCKBUILDER_PATH . '/shortcodes/' . $sc . '.php';
        }
        if($sc_path){
          $class = $sc;
          $_class = '\\Drupal\custom_pagebuilder\shortcodes\\'.$class;
          if( class_exists($_class) ){
            $s = new $_class;
            if($backend){ //Load form setting for shortcode backend
              if(method_exists($s, 'render_form')){
                $this->cb_shortcodes[$class] = $s->render_form();
              }
            }else{
              if(method_exists($s, 'load_shortcode')){
                  $s->load_shortcode();
              }
            }
          }
        }
      }
    }
  }

  public function custom_pagebuilder_shortcodes_forms(){
    return $this->cb_shortcodes;
  }

  public  function row_opts(){
   return array(
      array(
        'id'        => 'info',
        'type'      => 'info',
        'desc'      => 'Setting background for row'
      ),
      array(
        'id'       => 'bg_image',
        'type'     => 'upload',
        'title'    => ('Background Image'),
      ),
      array(
        'id'          => 'bg_color',
        'type'        => 'text',
        'title'       => ('Background Color'),
        'desc'        => ('Use color name (eg. "gray") or hex (eg. "#808080").'),
        'class'       => 'small-text',
        'std'         => '',
      ),
      array(
        'id'         => 'bg_position',
        'type'       => 'select',
        'title'      => t('Background Position'),
        'options'    => array(
          'center top' => 'center top',
          'center right' => 'center right',
          'center bottom' => 'center bottom',
          'center center' => 'center center',
          'left top' => 'left top',
          'left center' => 'left center',
          'left bottom' => 'left bottom',
          'right top' => 'right top',
          'right center' => 'right center',
          'right bottom' => 'right bottom',
        )
      ),
      array(
        'id'         => 'bg_repeat',
        'type'       => 'select',
        'title'      => t('Background Position'),
        'options'    => array(
          'no-repeat' => 'no-repeat',
          'repeat' => 'repeat',
          'repeat-x' => 'repeat-x',
          'repeat-y' => 'repeat-y',
          )
      ),

      array(
        'id'         => 'bg_attachment',
        'type'       => 'select',
        'title'      => t('Background Attachment'),
        'options'    => array(
          'scroll' => 'Scroll',
          'fixed'  => 'Fixed - Parallax',
          ),
        'std'         => 'scroll'
      ),

      array(
        'id'        => 'info',
        'type'      => 'info',
        'desc'      => 'Setting padding, margin for row'
      ),
      array(
        'id'        => 'style_space',
        'type'      => 'select',
        'title'     => 'Style Space',
        'options'   => array(
          'default'                           => 'Default',
          'remove_padding_top'                => 'Remove padding top',
          'remove_padding_bottom'             => 'Remove padding bottom',
          'remove_padding'                    => 'Remove padding for row',
          'remove_padding_col'                => 'Remove padding for colums of row',
          'remove_margin remove_padding remove_padding_col' => 'Remove padding for [colums & row]'
        )
      ),

      array(
        'id'        => 'padding_top',
        'type'      => 'text',
        'title'     => ('Padding Top'),
        'desc'      => ('Set value padding top for row (e.g. 30)'),
        'class'     => 'small-text',
        'std'       => '0',
      ),
      
      array(
        'id'          => 'padding_bottom',
        'type'        => 'text',
        'title'       => ('Padding Bottom'),
        'desc'        => ('Set value padding bottom for row (e.g. 30)'),
        'class'       => 'small-text',
        'std'         => '0',
      ),

      array(
        'id'          => 'margin_top',
        'type'        => 'text',
        'title'       => ('Margin Top'),
        'desc'        => ('Set value margin top for row (e.g. 30)'),
        'class'       => 'small-text',
        'std'         => '0',
      ),
      
      array(
        'id'          => 'margin_bottom',
        'type'        => 'text',
        'title'       => ('Margin Bottom'),
        'desc'        => ('Set value margin bottom for row (e.g. 30)'),
        'class'       => 'small-text',
        'std'         => '0',
      ),
      
      array(
        'id'        => 'info',
        'type'      => 'info',
        'desc'      => 'Setting layout, style for row'
      ),

      array(
        'id'            => 'layout',
        'type'          => 'select',
        'title'         => 'Layout',
        'options'       => array( 'container' => 'Box', 'container-fw' => 'Full Width' )
      ),
      
      array(
        'id'        => 'info',
        'type'      => 'info',
        'desc'      => 'Setting class, id for row'
      ),

      array(
        'id'    => 'class',
        'type'    => 'text',
        'title'   => ('Custom CSS classes'),
        'desc'    => ('Multiple classes should be separated with SPACE.<br />'),
      ),
      
      array(
        'id'    => 'row_id',
        'type'    => 'text',
        'title'   => ('Custom ID'),
        'desc'    => ('Use this option to create One Page sites.<br/>For example: Your Custom ID is <strong>offer</strong> and you want to open this section, please use link: <strong>your-url/#offer-2</strong>'),
        'class'   => 'small-text',
      ),
    );
  }

  public  function column_opts(){
   return array(
      array(
        'id'        => 'info',
        'type'      => 'info',
        'desc'      => 'Setting background for column'
      ),
      array(
        'id'       => 'bg_image',
        'type'     => 'upload',
        'title'    => ('Background Image'),
      ),
      array(
        'id'          => 'bg_color',
        'type'        => 'text',
        'title'       => ('Background Color'),
        'desc'        => ('Use color name (eg. "gray") or hex (eg. "#808080").'),
        'class'       => 'small-text',
        'std'         => '',
      ),
      array(
        'id'         => 'bg_position',
        'type'       => 'select',
        'title'      => t('Background Position'),
        'options'    => array(
          'center top' => 'center top',
          'center right' => 'center right',
          'center bottom' => 'center bottom',
          'center center' => 'center center',
          'left top' => 'left top',
          'left center' => 'left center',
          'left bottom' => 'left bottom',
          'right top' => 'right top',
          'right center' => 'right center',
          'right bottom' => 'right bottom',
        )
      ),
      array(
        'id'         => 'bg_repeat',
        'type'       => 'select',
        'title'      => t('Background Position'),
        'options'    => array(
          'no-repeat' => 'no-repeat',
          'repeat' => 'repeat',
          'repeat-x' => 'repeat-x',
          'repeat-y' => 'repeat-y',
          )
      ),

      array(
        'id'         => 'bg_attachment',
        'type'       => 'select',
        'title'      => t('Background Attachment'),
        'options'    => array(
          'scroll' => 'Scroll',
          'fixed'  => 'Fixed - Parallax',
          ),
        'std'         => 'scroll'
      ),

      array(
        'id'        => 'info',
        'type'      => 'info',
        'desc'      => 'Setting class, id for columns'
      ),

      array(
        'id'    => 'class',
        'type'    => 'text',
        'title'   => ('Custom CSS classes'),
        'desc'    => ('Multiple classes should be separated with SPACE.<br />'),
      ),
      
      array(
        'id'    => 'column_id',
        'type'    => 'text',
        'title'   => ('Custom ID'),
        'desc'    => ('For example: Your Custom ID for column'),
        'class'   => 'small-text',
      ),
      
      array(
        'id'        => 'info',
        'type'      => 'info',
        'desc'      => 'Setting Responsive Visibility for Columns'
      ),
      array(
        'id' => 'hidden_lg',
        'type'    => 'select',
        'title'   => ('Hide on large screen (hidden-lg)'),
        'options'   => array(
          'show'        => 'Show',   
          'hidden'   => 'Hidden'
        )
      ),
      array(
        'id' => 'hidden_md',
        'type'    => 'select',
        'title'   => ('Hide on medium screen (hidden-md)'),
        'options'   => array(
          'show'        => 'Show',   
          'hidden'         => 'Hidden'
        )
      ),
      array(
        'id' => 'hidden_sm',
        'type'    => 'select',
        'title'   => ('Hide on small screen (hidden-sm)'),
        'options'   => array(
          'show'        => 'Show',   
          'hidden'         => 'Hidden'
        )
      ),
      array(
        'id' => 'hidden_xs',
        'type'    => 'select',
        'title'   => ('Hide on extra small screen (hidden-xs)'),
        'options'   => array(
          'show'        => 'Show',   
          'hidden'         => 'Hidden'
        )
      ),

    );
  }
}
