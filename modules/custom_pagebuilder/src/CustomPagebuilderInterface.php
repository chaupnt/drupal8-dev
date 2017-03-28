<?php

namespace Drupal\custom_pagebuilder;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining a Contact entity.
 * @ingroup custom_pagebuilder
 */
interface CustomPagebuilderInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}

?>