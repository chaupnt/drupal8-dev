<?php 
namespace Drupal\custom_pagebuilder\TwigExtension;


/**
 *  
 */
class CustomPagebuilderAdminRow extends \Twig_Extension{
  /**
   * {@inheritdoc}
   * This function must return the name of the extension. It must be unique.
   */
  public function getName() {
    return 'custom_pagebuilder_twig';
  }

  /**
   * In this function we can declare the extension function
   */
  public function getFunctions() {
    return array(
      new \Twig_SimpleFunction('custom_pagebuilder_row_twig', 
        array($this, 'custom_pagebuilder_row_twig'),
        array('is_safe' => array('html'))),
        
      new \Twig_SimpleFunction('custom_pagebuilder_column_twig', 
          array($this, 'custom_pagebuilder_column_twig'),
          array('is_safe' => array('html'))),
          
      new \Twig_SimpleFunction('custom_pagebuilder_column_elements', 
          array($this, 'custom_pagebuilder_column_elements'),
          array('is_safe' => array('html'))),
          
      new \Twig_SimpleFunction('cpb_fields_twig', 
          array($this, 'custom_pagebuilder_builder_fields_twig'),
          array('is_safe' => array('html'))),
          
      new \Twig_SimpleFunction('cpb_fields_row_twig', 
          array($this, 'custom_pagebuilder_builder_fields_row_twig'),
          array('is_safe' => array('html'))),
          
      new \Twig_SimpleFunction('cpb_fields_element_twig', 
          array($this, 'custom_pagebuilder_builder_fields_items_twig'),
          array('is_safe' => array('html'))),
          
          
      );
  }

  /**
   * The php function to load a given block
   */
  public function custom_pagebuilder_row_twig( $item_std = fasle, $row_std = fasle, $column_std = fasle, $row = false, $row_id = false  ) {
    $t = '';
    $template = array(
      '#type' => 'page',
      '#cache' => array('max-age' => 0),
      '#theme' => 'custom_pagebuilder_builder_row', 
      '#item_std' => $item_std,
      '#row_std' => $row_std,
      '#column_std' => $column_std,
      '#row' => $row,
      '#row_id' => $row_id,
    );
    $t .= drupal_render($template);
    return $t;
    //print_r('sdfsdfsd'); die();
    //return array('#markup' => 'asdasdasdasdasdasdas');
  }
  
  function custom_pagebuilder_column_twig( $item_std = fasle, $column_std = fasle, $column = false, $column_id = false,  $row_id = false ) {
    //print_r($column_std); die();
    $t = '';
    $column_size = (isset($column['attr']['size']) && $column['attr']['size']) ? $column['attr']['size'] : '4';
  	$column_type = (isset($column['attr']['type']) && $column['attr']['type']) ? $column['attr']['type'] : '';
  	$name_column_id = $column ? 'name="cpb-column-id[]"' : '';
    $template = array(
      '#type' => 'page',
      '#cache' => array('max-age' => 0),
      '#theme' => 'custom_pagebuilder_builder_column', 
      '#item_std' => $item_std,
      '#column_std' => $column_std,
      '#column' => $column,
      '#column_id' => $column_id,
      '#row_id' => $row_id,
      '#column_size' => $column_size,
      '#column_type' => $column_type,
      '#name_column_id' => $name_column_id
    );
    $t .= drupal_render($template);
    return $t;
  }
  
  function custom_pagebuilder_column_elements( $item_std = false, $cpb_item = false, $column_id = false, $row_id = false ) {
    $t = '';
    //kint($cpb_item[0]);
    if(!empty($item_std)) {
      $element_type 		= $cpb_item ? 'element-type[]' : '';
    	$element_parent	= $cpb_item ? 'element-parent[]' : '';
    	$element_row_parent = $cpb_item ? 'element-row-parent[]' : '';
    	$label = ( $cpb_item && key_exists('fields', $cpb_item) && key_exists('title_admin', $cpb_item['fields']) ) ? $cpb_item['fields']['title_admin'] : '';
    	if(!$label)
    	$label = ( $cpb_item && key_exists('fields', $cpb_item) && key_exists('title', $cpb_item['fields']) ) ? $cpb_item['fields']['title'] : '';
      
      $template = array(
        '#type' => 'page',
        '#cache' => array('max-age' => 0),
        '#theme' => 'custom_pagebuilder_builder_elements', 
        '#item_std' => $item_std,
        '#cpb_item' => $cpb_item,
        '#column_id' => $column_id,
        '#row_id' => $row_id,
        '#element_type' => $element_type,
        '#element_parent' => $element_parent,
        '#element_row_parent' => $element_row_parent,
        '#label' => $label
      );
      $t .= drupal_render($template);
    }
    return $t;
  }
  
  function custom_pagebuilder_builder_fields_twig( $column_std = false, $column = false) {
    //print_r($column); die();
    $output = '';
    if(!empty($column_std)) {
      foreach( $column_std as $field ) {
          $val = false;
          if( $column && isset($column['attr'][$field['id']]) && $field['type'] !='info'){
             $val = $column['attr'][$field['id']];
          }
          if( !isset($field['std']) ) $field['std'] = false;
          $val = ( $val || $val=='0' ) ? $val : stripslashes(htmlspecialchars(( $field['std']), ENT_QUOTES ));
          $field['id'] = 'cpb-columns['. $field['id'] .']';
          if( $field['type'] != 'tabs' ){
             $field['id'] .= '[]';
          }
          $output .= custom_pagebuilder_single_field( $field, $val );
      }
    }
    return $output;
  }
  
  function custom_pagebuilder_builder_fields_row_twig($row_std = false, $row = false) {
    $output = '';
    if(!empty($row_std)) {
      
      foreach( $row_std as $field ){
          $val = false;
          if( $row && isset($row['attr'][$field['id']]) && $field['type'] !='info'){
             $val = $row['attr'][$field['id']];
          }
          if( !isset($field['std']) ) $field['std'] = false;
          $val = ( $val || $val=='0' ) ? $val : stripslashes(htmlspecialchars(( $field['std']), ENT_QUOTES ));
          $field['id'] = 'cpb-rows['. $field['id'] .']';
          if( $field['type'] != 'tabs' ){
             $field['id'] .= '[]';
          }
          $output .= custom_pagebuilder_single_field( $field, $val );
      }
    }
    return $output;
  }
  
  function custom_pagebuilder_builder_fields_items_twig($item_std = false, $cpb_item = false) {
    //kint($cpb_item);
    $output = '';
    if(!empty($item_std)) {
      //kint($item_std);
      $form = new \Drupal\custom_pagebuilder\Form\CustomPagebuilderFormItems( $item_std['fields'] );
      $form_render = \Drupal::formBuilder()->getForm($form);
      $output .= drupal_render($form_render);
      foreach( $item_std['fields'] as $field ){
        $val = false;
        if( $cpb_item && key_exists( 'fields', $cpb_item ) && key_exists( $field['id'], $cpb_item['fields'] ) ){
          $val = $cpb_item['fields'][$field['id']];
        }
        if( ! isset($field['std']) ) $field['std'] = false;
        $val = ( $val || $val=='0' ) ? $val : stripslashes(htmlspecialchars(( $field['std']), ENT_QUOTES ));
        $field['id'] = 'cpb-items['. $item_std['type'] .']['. $field['id'] .']';
        if( $field['type'] != 'tabs' ){
          $field['id'] .= '[]';         
        }
        $output .= custom_pagebuilder_single_field( $field, $val );
      }
    }
    return $output;
  }
  
}




?>