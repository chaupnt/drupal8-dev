<?php
namespace Drupal\custom_pagebuilder\Plugin\Derivative;
use Drupal\Component\Plugin\Derivative\DeriverBase;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomBlockPagebuilder
 *
 * @author EVA-Chau
 */
class CustomBlockPagepuilder extends DeriverBase {
  //put your code here
  public function getDerivativeDefinitions($base_plugin_definition) {
    $query = \Drupal::database()->select('custom_pagebuilder', 'cp');
    $query->fields('cp');
    $query->condition('cp.setting_block', 1);
    $result = $query->execute();
    foreach ($result as $value) {
      $this->derivatives["custom_block_pagebuilder_" . $value->id] = $base_plugin_definition;
      $this->derivatives["custom_block_pagebuilder_" . $value->id]['admin_label'] = "Block Builder ".$value->title;
    }
    return $this->derivatives;
  }
  
}
