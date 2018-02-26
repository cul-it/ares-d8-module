<?php

namespace Drupal\ares\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a basic Ares block
 *
 * @Block(
 *   id = "ares_block",
 *   admin_label = @Translation("Ares block")
 * )
 */
class AresBlock extends BlockBase {

  public function build() {
    $config = $this->getConfiguration();
    return array(
      '#markup' => "test",
    );
  }
}
