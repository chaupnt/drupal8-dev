<?php

namespace Drupal\custom_pagebuilder;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Url;

/**
 * Provides a list controller for custom_pagebuilder entity.
 *
 * @ingroup custom_pagebuilder
 */
class CustomPagebuilderList extends EntityListBuilder {

  /**
   * {@inheritdoc}
   *
   * We override ::render() so that we can add our own content above the table.
   * parent::render() is where EntityListBuilder creates the table using our
   * buildHeader() and buildRow() implementations.
   */
  public function render() {
    $build['description'] = array(
      '#markup' => $this->t('Content Entity Example implements a Contacts model. These contacts are fieldable entities. '),
    );
    $build['table'] = parent::render();
    return $build;
  }

  /**
   * {@inheritdoc}
   *
   * Building the header and content lines for the contact list.
   *
   * Calling the parent::buildHeader() adds a column for the possible actions
   * and inserts the 'edit' and 'delete' links as defined for the entity type.
   */
  public function buildHeader() {
    $header['id'] = $this->t('ContactID');
    $header['title'] = $this->t('Title');
    return $header + parent::buildHeader();
  }
  
  public function getOperations(EntityInterface $entity) {
    $operations = parent::getOperations($entity);
    
    
    $operations['Edit'] = array(
      'title' => 'Edit',
      'url' => \Drupal::url('entity.custom_pagebuilder.edit_form', array('custom_pagebuilder' => $entity->id())),
    );
    
    return $operations;
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $operations = '<a href="'. \Drupal::url('entity.custom_pagebuilder.edit_form', array('custom_pagebuilder' => $entity->id())) .'">Edit</a>';
    $operations .= '<a href="'. \Drupal::url('custom_pagebuilder.admin.config', array('custom_pagebuilder' => $entity->id())) .'">Config</a>';
    $row['id'] = $entity->id();
    $row['title'] = $entity->link();
    $row['operations']['data'] = array('#markup' => $operations);
    return $row + parent::buildRow($entity);
  }

}
?>