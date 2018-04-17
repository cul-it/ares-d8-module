<?php

namespace Drupal\ares\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormInterface;

/**
 * Provides a basic Ares block for the front page of a site
 *
 * @Block(
 *   id = "ares_front_block",
 *   admin_label = @Translation("Ares front page block")
 * )
 */
class AresFrontBlock extends BlockBase {

  public function build() {

    //$form = \Drupal::FormBuilder()->getForm('Drupal\ares\Form\AresSearchForm');
    $listForm = \Drupal::FormBuilder()->getForm('Drupal\ares\Form\AresListForm');

    //return array($form, $listForm);
    // FOR NOW, we're omitting the search form ($form)
    return array($listForm);
  }
}
