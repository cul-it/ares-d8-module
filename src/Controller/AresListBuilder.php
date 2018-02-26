namespace Drupal\ares\Controller;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides a listing of Ares locations
 */
class AresListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['label'] => $this->t('Ares location');
    $header['id'] = $this->t('Machine name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $row['label'] = $this->label($entity);
    $row['id'] = $entity->id();
    $row['alid'] => $this->alid($entity);

    return $row + parent::buildRow($entity);
  }
}
