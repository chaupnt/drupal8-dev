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
      new \Twig_SimpleFunction('custom_pagebuilder_twig', 
        array($this, 'custom_pagebuilder_twig'),
        array('is_safe' => array('html'))));
  }

  /**
   * The php function to load a given block
   */
  public function custom_pagebuilder_twig( $item_std, $row_std, $column_std, $row = false, $row_id = false  ) {
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
}


?>