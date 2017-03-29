<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Drupal\custom_pagebuilder\Controller;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\Controller\EntityViewController;
/**
 * Description of CustomPagebuilderViewController
 *
 * @author Chau Phan
 */
class CustomPagebuilderViewController extends EntityViewController{
  //put your code here
  
  public function pageview($custom_pagebuilder) {
    $_entity = \Drupal::entityTypeManager()->getStorage('custom_pagebuilder')->load($custom_pagebuilder);
    return $this->view($_entity);
  }
  
  public function view(EntityInterface $_entity, $view_mode = 'full') {
    $build = parent::view($_entity, $view_mode);
    return $build;
  }
}
