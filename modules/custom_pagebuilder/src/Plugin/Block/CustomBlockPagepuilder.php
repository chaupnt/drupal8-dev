<?php
namespace Drupal\custom_pagebuilder\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\custom_pagebuilder\Controller\CustomPagebuilderViewController;
/**
 * Description of CustomBlockPagepuilder
 *
 * @author EVA-Chau
 */

/**
 * Provides a 'Block Builder' Block.
 *
 * @Block(
 *   id = "custom_block_pagebuilder",
 *   admin_label = @Translation("Block Builder"),
 *   category = @Translation("Block Builder"),
 *   deriver = "Drupal\custom_pagebuilder\Plugin\Derivative\CustomBlockPagepuilder"
 * )
 */

class CustomBlockPagepuilder extends BlockBase {
  //put your code here
  public function build() {
    $block_id = $this->getDerivativeId();
    return $this->CustomBlockPagepuilder_buildercontent($block_id);
  }
  
  public function CustomBlockPagepuilder_buildercontent($block_id) {
    $bid = substr($block_id, -1);
    $view_block = new CustomPagebuilderViewController($bid);
    return $view_block->pageview();
  }
  
}
