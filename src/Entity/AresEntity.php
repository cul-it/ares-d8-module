namespace Drupal\ares\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\ares\AresInterface;

/**
 * Defines the Ares location configuration entity
 *
 * @ConfigEntityType(
 *   id = "ares",
 *   label = @Translation("Ares Location")
 *   handlers = {
 *     "list_builder" = "Drupal\ares\Controller\AresListBuilder",
 *     "form" = {
 *       "add" = "Drupal\ares\Form\AresForm",
 *       "edit" = "Drupal\ares\Form\AresForm"
 *       "delete" = "Drupal\ares\Form\AresDeleteForm",
 *     }
 *   },
 *   config_prefix = "ares",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label"
 *   },
 *   links = {
 *     "edit-form" = "/admin/config/system/ares/{location}"
 *     "delete-form" = "/admin/config/system/ares/{location}/delete",
 *   }
 * )
 */
class Ares extends ConfigEntityBase implements AresInterface {
  /**
   * The Ares location ID
   *
   * @var string
   */
  public $id;

  /**
   * The Ares location name
   *
   * @var string
   */
  public $label;

  /**
   * The Ares alid (Ares location id)
   *
   * @var int
   */
  public $alid;

  /**
   * The Ares location block id
   *
   * @var int
   */
  public $block;

  // Specific config property get/set methods go here, implementing the interface
}
