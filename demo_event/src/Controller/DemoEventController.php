<?php

/**
 * @file
 * Contains \Drupal\demo_event\Controller\DemoEventController.
 */

namespace Drupal\demo_event\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\demo_event\DemoEvents;
use Symfony\Component\EventDispatcher\EventDispatcher;


/**
 * Returns responses for Events Demo module routes.
 */
class DemoEventController extends ControllerBase {

  /**
   * Controller content callback: Lists which event are called.
   *
   * @return string
   */
  public function infoPage() {
    $output['info'] = array(
      '#markup' => $this->t('This demonstrates Events in Drupal 8. The following examples are available:'),
    );

    $output['urls'] = array(
      '#theme' => 'item_list',
      '#items' => array(
        $this->t('A page that dispatches an event: !url.', array('!url' => \Drupal::l('/demo/event/event', New Url('demo_event.info')))),
        $this->t('A form that broadcasts a message using an event: !url.', array('!url' => \Drupal::l('/demo/event/broadcast', New Url('demo_event.broadcast')))),
      ),
    );
    return $output;
  }

  /**
   * Controller content callback: Lists which event are called.
   *
   * @return string
   */
  public function eventPage() {
    // Dispatch an demo event. But no listeners have been subscribed, so there
    // will be no response on the event.
    // @todo The event dispatcher should be added as a dependency.
    /** @var \Symfony\Component\EventDispatcher\EventDispatcher $dispatcher */
    $dispatcher = \Drupal::service('event_dispatcher');
    $dispatcher->dispatch(DemoEvents::NO_REPLY);

    $output = 'This page fires a "demo_event.no-reply" event. But nobody listens :(';
    return $output;
  }
}
