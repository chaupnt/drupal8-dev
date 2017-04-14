<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Drupal\custom_pagebuilder\Core;

/**
 * Description of ClassFormFieldItem
 *
 * @author EVA-Chau
 */
class ClassFormFieldItem {
  //put your code here
  
  //private $form_element;
  function __construct($tyle) {
  }
  
  static function getFormElement($type) {
    switch (  $type ) {
      case 'textarea':
        return $form['textarea'] = array(
          '#type' => 'textarea',
          '#title' => t('Description'),
          '#default_value' => '',
          '#weight' => 0,
        );
       break;
    }
  }
  
}
