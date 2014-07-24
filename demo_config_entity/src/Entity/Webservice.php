<?php

/**
 * @file
 * Definition of Drupal\demo_config_entity\Entity\Webservice.
 */

namespace Drupal\demo_config_entity\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the webservice entity.
 *
 * @ConfigEntityType(
 *   id = "demo_config_entity_webservice",
 *   label = @Translation("Webservice"),
 *   config_prefix = "webservice",
 *   entity_keys = {
 *     "id" = "name",
 *     "label" = "label",
 *   }
 * )
 */
class Webservice extends ConfigEntityBase {

  /**
   * The webservice label.
   *
   * @var string
   */
  public $label;

  /**
   * The webservice machine readable name.
   *
   * @var string
   */
  public $name;

  /**
   * The webservice URL.
   *
   * @var string
   */
  public $url;

  /**
   * The webservice port.
   *
   * @var string
   */
  public $port;

  /**
   * Overrides Drupal\Core\Entity\Entity::id().
   */
  public function id() {
    // It would have been easier to use "id" here instead of "name". But
    // "name" is used here to demonstrate what happens if a non-default
    // variable name is used. See "entity_keys" in the ConfigEntityType
    // annotation too.
    return $this->name;
  }

}
