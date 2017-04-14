<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Drupal\custom_pagebuilder\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
/**
 * Description of CustomPagebuilderFormItems
 *
 * @author EVA-Chau
 */
class CustomPagebuilderFormItems extends FormBase{
  //put your code here
  public function getFormId() {
    return 'custom_pagebuilder_items_element_form';
  }
  
  private $field_data;
  
  public function __construct( $field_data ) {
    $this->field_data = $field_data;
  }
  
  public function buildForm(array $form, FormStateInterface $form_state) {
    kint($this->field_data);
    $form['phone_number'] = array(
      '#type' => 'tel',
      '#title' => $this->t('Your phone number'),
    );
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    );
    return $form;
    return $form;
  }
  
  public function validateForm(array &$form, FormStateInterface $form_state) {
    
  }
  
  public function submitForm(array &$form, FormStateInterface $form_state) {
    
  }
  
}
