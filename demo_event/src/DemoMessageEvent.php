<?php

/**
 * @file
 * Contains \Drupal\demo_event\DemoMessageEvent.
 */

namespace Drupal\demo_event;

use Symfony\Component\EventDispatcher\Event;

class DemoMessageEvent extends Event {

  /**
   * The event message string.
   *
   * @var string
   */
  protected $message;

  /**
   * Constructs ConfigImporterEvent.
   *
   * @param \Drupal\Core\Config\ConfigImporter $config_importer
   *   A config import object to notify listeners about.
   */
  public function __construct($message) {
    $this->message = $message;
  }

  /**
   * Gets the broadcast message.
   *
   * @return string
   *   The raw broadcasted message.
   */
  public function getMessage() {
    return $this->message;
  }

}
