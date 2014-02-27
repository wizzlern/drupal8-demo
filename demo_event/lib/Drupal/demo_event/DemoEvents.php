<?php

/**
 * @file
 * Contains \Drupal\demo_event\DemoEvents.
 */

namespace Drupal\demo_event;

/**
 * Defines events for the Demo Event system.
 */
final class DemoEvents {

  /**
   * Name of event fired into the great unknown.
   *
   * @see \Drupal\demo_event\Controller\DemoEventController::eventPage()
   */
  const NO_REPLY = 'demo_event.no_reply';

  /**
   * Name of event fired when a user broadcasts a message.
   *
   * @see \Drupal\demo_event\Form\EventForm::submitForm()
   */
  const BROADCAST = 'demo_event.broadcast';

}
