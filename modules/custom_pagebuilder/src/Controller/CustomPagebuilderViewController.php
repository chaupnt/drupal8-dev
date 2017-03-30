<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Drupal\custom_pagebuilder\Controller;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\Controller\EntityViewController;
use Drupal\custom_pagebuilder\Core\ClassCustomPagebuilder;
/**
 * Description of CustomPagebuilderViewController
 *
 * @author Chau Phan
 */
class CustomPagebuilderViewController extends EntityViewController{
  //put your code here
  
  public function pageview($custom_pagebuilder) {
    $params = $this->get_json_content_page($custom_pagebuilder);
    kint($params);
    $_entity = \Drupal::entityTypeManager()->getStorage('custom_pagebuilder')->load($custom_pagebuilder);
    return $this->view($_entity);
  }
  
  public function view(EntityInterface $_entity, $view_mode = 'full') {
    $build = parent::view($_entity, $view_mode);
    return $build;
  }
  
  public function get_json_content_page($pid) {
    $query = \Drupal::database()->select('custom_pagebuilder', 'cp');
    $query->fields('cp');
    $query->leftjoin('custom_pagebuilder_content', 'cpc', 'cp.id = cpc.id');
    $query->fields('cpc');
    $query->condition('cp.id', $pid);
    $result = $query->execute()->fetchObject();
    $params = base64_decode($result->params);
    $params = json_decode($params, true);
    return $params;
  }
  
}
