<?php
/**
 * @file
 * Contains \Drupal\ares\Form\SearchForm.
 */
namespace Drupal\ares\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class aresSearchForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ares_search_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['search_box'] = array(
      '#type' => 'textfield',
      '#id' => 'search_box',
      '#name' => 'search_box',
      '#autocomplete_path' => 'ares/autocomplete',
      '#attributes' => array('class'=> array('auto_submit')),
      //'#default_value' => 'peanut butter',
      '#size' => 15,
      '#maxlength' => 255,
      '#prefix' => '<label class="sr-only" for="reserves_search_box">Search course reserves</label>'
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Search'),
      '#attributes' => array('#class' => 'go')
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    drupal_set_message($this->t('Your form is being submitted!'));
  }

}
