<?php

namespace Drupal\custom_pagebuilder\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Language\Language;
use Drupal\Core\Form\FormStateInterface;
use Drupal\custom_pagebuilder\Core\ClassCustomPagebuilder;
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
    kint($entity->id());
    $form['#attached']['library'][] = 'custom_pagebuilder/custom_pagebuilder.assets.admin';
    if(!empty($entity->id())) {
      $abs_url_config = \Drupal::url('custom_pagebuilder.admin.save', array(), array('absolute' => FALSE)); 
      $page['#attached']['drupalSettings']['custom_pagebuilder']['saveConfigURL'] = $abs_url_config;
      $form['langcode'] = array(
        '#title' => $this->t('Language'),
        '#type' => 'language_select',
        '#default_value' => $entity->getUntranslated()->language()->getId(),
        '#languages' => Language::STATE_ALL,
      );
      
      $cpb = new ClassCustomPagebuilder(1);
      $cpb->custom_pagebuilder_load_shortcodes(true);
      
      $template = array(
        '#type' => 'page',
        '#cache' => array('max-age' => 0),
        '#theme' => 'custom_pagebuilder_admin_builder', 
        '#cpb_title' => $cpb->get_title(),
        '#cbp_rows_count' => $cpb->get_rows_count(),
        '#cpb_els_ops' => $cpb->custom_pagebuilder_shortcodes_forms(), 
        '#cpb_rows_opts' => $cpb->row_opts(),
        '#cpb_columns_opts' => $cpb->column_opts(),
        '#cpb_gbb_els' => $cpb->get_json_decode(),
      );
      $output = drupal_render($template);
      
      $form['content_pagebuilder'] = array(
        '#type' => 'item',
        '#markup' => $output,
      );
    }
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