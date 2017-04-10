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
    $form = parent::buildForm($form, $form_state);
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