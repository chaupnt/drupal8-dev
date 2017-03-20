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
      new \Twig_SimpleFunction('custom_twig_admin_row', 
        array($this, 'custom_twig_admin_row'),
        array('is_safe' => array('html'))));
  }

  /**
   * The php function to load a given block
   */
  public function custom_twig_admin_row() {
    print_r('sdfsdfsd'); die();
    return array('#markup' => 'asdasdasdasdasdasdas');
  }
}


?>