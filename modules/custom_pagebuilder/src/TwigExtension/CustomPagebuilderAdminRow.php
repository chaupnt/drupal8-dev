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
  public function custom_pagebuilder_twig( $class_page ) {
    kint($class_page->get_rows_count());
    $t = '';
    for( $i = 0; $i < $class_page->get_rows_count(); $i++ ) {
      $t .= 'asdasdasdas<br/>';
    }
    return $t;
    //print_r('sdfsdfsd'); die();
    //return array('#markup' => 'asdasdasdasdasdasdas');
  }
}


?>