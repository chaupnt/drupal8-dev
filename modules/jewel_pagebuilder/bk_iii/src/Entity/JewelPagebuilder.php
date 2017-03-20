<?php

namespace Drupal\jewel_pagebuilder\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\jewel_pagebuilder\JewelPagebuilderInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Jewel Pagebuilder entity.
 *
 * @ingroup Jewel Pagebuilder
 *
 * @ContentEntityType(
 *   id = "jewel_pagebuilder",
 *   label = @Translation("Jewel Pagebuilder"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\jewel_pagebuilder\Controller\JewelPagebuildController",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\jewel_pagebuilder\Form\JewelPagebuilderForm",
 *       "edit" = "Drupal\jewel_pagebuilder\Form\JewelPagebuilderForm",
 *       "delete" = "Drupal\jewel_pagebuilder\Form\JewelPagebuilderDeleteForm",
 *     },
 *   base_table = "jewel_pagebuilder",
 *   fieldable = FALSE,
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "canonical" = "/pagebuilder/{content_entity_jewel_pagebuilder}",
 *     "edit-form" = "/admin/jewel_pagebuilder/{content_entity_jewel_pagebuilder}/edit",
 *     "delete-form" = "/admin/jewel_pagebuilder/{content_entity_jewel_pagebuilder}/delete,
 *     "collection" = "/admin/jewel_pagebuilder/list"
 *   },
 * )
 */
 //implements JewelPagebuilderInterface
 class JewelPagebuilder extends ContentEntityBase  {

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    // Standard field, used as unique if primary index.
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Advertiser entity.'))
      ->setReadOnly(TRUE);
      
    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Contact entity.'))
      ->setSettings(array(
        'default_value' => '',
        'max_length' => 255,
        'text_processing' => 0,
      ))
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -6,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string',
        'weight' => -6,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    return $fields;
  }
}
 
?>