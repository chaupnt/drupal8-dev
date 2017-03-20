<?php

namespace Drupal\jewel_pagebuilder\Controller;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Url;

/**
 * Class JewelPagebuildController.
 *
 * @package Drupal\jewel_pagebuilder\Controller
 */
class JewelPagebuildController extends EntityListBuilder {

  /**
   * Hello.
   *
   * @return string
   *   Return Hello string.
   */
   public function buildHeader() {
     $header['id'] = $this->t('ContactID');
     $header['name'] = $this->t('Name');
     return $header + parent::buildHeader();
   }
 
   /**
    * {@inheritdoc}
    */
   public function buildRow(EntityInterface $entity) {
     $row['id'] = $entity->id();
     $row['name'] = $entity->link();
     return $row + parent::buildRow($entity);
   }

}
