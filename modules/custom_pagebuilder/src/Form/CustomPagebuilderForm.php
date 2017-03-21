<?php

namespace Drupal\custom_pagebuilder\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Language\Language;
use Drupal\Core\Form\FormStateInterface;
use Drupal\custom_pagebuilder\includes\core\ClassCustomPagebuilder;
/**
 * Form controller for the custom_pagebuilder entity edit forms.
 *
 * @ingroup custom_pagebuilder
 */
class CustomPagebuilderForm extends ContentEntityForm {
  
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\content_entity_example\Entity\Contact */
    $form = parent::buildForm($form, $form_state);
    $entity = $this->entity;
    $form['#attached']['library'][] = 'custom_pagebuilder/custom_pagebuilder.assets.admin';
    $form['langcode'] = array(
      '#title' => $this->t('Language'),
      '#type' => 'language_select',
      '#default_value' => $entity->getUntranslated()->language()->getId(),
      '#languages' => Language::STATE_ALL,
    );
    
    $result = db_select('{gavias_blockbuilder}', 'd')
          ->fields('d')
          ->condition('id', 1, '=')
          ->execute()
          ->fetchObject();
    $pbd_single = new \stdClass();
    if($result){
      $pbd_single->title =  $result->title;
      $pbd_single->body_class = $result->body_class;  
      $pbd_single->params = $result->params;  
    }else{
      return false;
    }
    $gsc = new ClassCustomPagebuilder(1);
    $gsc->custom_pagebuilder_load_shortcodes(true);
    //print_r($gsc->custom_pagebuilder_shortcodes_forms()); 
    /*
  	$gsc->custom_pagebuilder_load_shortcodes(true);
  	$gbb_rows_opts = $gsc->row_opts(); 
  	$gbb_columns_opts = $gsc->column_opts(); 
  	$gbb_els_ops = $gsc->custom_pagebuilder_shortcodes_forms();
  	$gbb_els_params = $pbd_single->params;
  	$gbb_els = base64_decode($gbb_els_params);
  	$gbb_els = json_decode($gbb_els, true);
  	//print"<pre>";print_r($gbb_els);die();
  	$gbb_title = $pbd_single->title;
  	$gbb_shortcode = $pbd_single->body_class;
  	$gbb_id = 1;
    if( is_array( $gbb_els ) && ! key_exists( 'attr', $gbb_els[0] ) ){
		$gbb_els_new = array(
			'attr'	=> $gbb_rows_opts,
			'items'	=> $gbb_els
		);
		$gbb_els = array( $gbb_els_new );
	 }
	  $gbb_rows_count = is_array( $gbb_els ) ? count( $gbb_els ) : 0;
	//ob_start();
  	//include GAVIAS_BLOCKBUILDER_PATH . '/templates/backend/admin-builder.php';
    */
    $template = array(
      '#type' => 'page',
      '#cache' => array('max-age' => 0),
      '#theme' => 'custom_pagebuilder_admin_builder', 
      '#cpb_title' => $gsc->get_title(),
      '#cbp_rows_count' => $gsc->get_rows_count(),
      '#cpb_els_ops' => $gsc->custom_pagebuilder_shortcodes_forms(), 
      '#cpb_rows_opts' => $gsc->row_opts(),
      '#cpb_columns_opts' => $gsc->column_opts(),
      '#cpb_gbb_els' => $gsc->get_json_decode(),
    );
    $output = drupal_render($template);
    //print_r($output); die();
  	//$content = ob_get_clean();
    //kint($content);
    //$twig = \Drupal\custom_pagebuilder\TwigExtension\CustomPagebuilderAdminRow();
    //print_r($twig); die();
    $form['content_pagebuilder'] = array(
      '#type' => 'item',
      '#markup' => $output,
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $form_state->setRedirect('entity.custom_pagebuilder.collection');
    $entity = $this->getEntity();
    $entity->save();
  }
  
}