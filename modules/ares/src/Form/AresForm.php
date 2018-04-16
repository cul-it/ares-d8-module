<?php

namespace Drupal\ares\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class AresForm
 *
 * Form class for adding/editing Ares location config entities
 */
class AresForm extends EntityForm {

  /**
    * Constructs an AresForm object.
    *
    * @param \Drupal\Core\Entity\Query\QueryFactory $entity_query
    *   The entity query.
    */
  public function __construct(QueryFactory $entity_query) {
    $this->entityQuery = $entity_query;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.query')
    );
  }

   /**
   * {@inheritdoc}
   */
   public function form(array $form, FormStateInterface $form_state) {
     $form = parent::form($form, $form_state);
     $ = $this->entity;

     // Location name
     $form['label'] = array(
       '#type' => 'textfield',
       '#title' => $this->t('Label'),
       '#maxlength' => 255,
       '#default_value' => $->label,
       '#description' => $this->t("Location name."),
       '#required' => TRUE,
     );

     // Unique machine name of the location.
     $form['id'] = array(
       '#type' => 'machine_name',
       '#maxlength' => EntityTypeInterface::BUNDLE_MAX_LENGTH,
       '#default_value' => $->id,
       '#disabled' => !$->isNew(),
       '#machine_name' => array(
         'exists' => [$this, 'exist']
       ),
     );

     // ALID
     $form['alid'] = array(
       '#type' => 'textfield',
       '#title' => $this->t('ALID'),
       '#maxlength' => 255,
       '#default_value' => $->alid,
       '#description' => $this->t('Location ALID.''),
       '#required' => TRUE,
     );

     // Block ID
     $form['block'] = array(
       '#type' => 'textfield',
       '#title' => $this->t('Block ID'),
       '#maxlength' => 255,
       '#default_value' => $->block,
       '#description' => $this->t('Location block ID.'),
       '#required' => TRUE,
     );

     return $form;
   }

  public function save(array $form, FormStateInterface $form_state) {
    $ = $this->entity;
    $status = $->save();

    if ($status) {
      drupal_set_message($this->t('Saved location: @name', array('@name' => $->name)));
    }
    else {
      drupal_set_message($this->t('Location @name was not saved', array('@name' => $->name)));
    }
    $form_state->setRedirect('entity.ares.collection');
  }

  /**
   * Helper function to check whether an Ares location config entity exists
   */
  public function exist($id) {
    $entity = $this->entityQuery->get('')
      ->condition('id', $id)
      ->execute();
    return (bool) $entity;
  }

 }
