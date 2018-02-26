<?php

namespace Drupal\ares\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormInterface;

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

    $form = \Drupal::FormBuilder()->getForm('Drupal\ares\Form\AresSearchForm');

    return $form;
  }
}
