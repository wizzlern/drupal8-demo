<?php

/**
 * @file
 * Contains \Drupal\demo_event\EventSubscriber\DemoEventSubscriber.
 */

namespace Drupal\demo_event\EventSubscriber;

use Drupal\Core\KeyValueStore\StateInterface;
use Drupal\demo_event\DemoEvents;
use Drupal\demo_event\DemoMessageEvent;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Tracks the active trail.
 */
class DemoEventSubscriber implements EventSubscriberInterface {

  /**
   * The state service.
   *
   * @var \Drupal\Core\KeyValueStore\StateInterface
   */
  protected $state;

  /**
   * Constructs a new DemoEventSubscriber.
   *
   * @param \Drupal\Core\KeyValueStore\StateInterface $state
   *   The state service.
   */
  public function __construct(StateInterface $state) {
    $this->state = $state;
  }

  /**
   * Displays kernel events.
   *
   * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
   *   The event to process.
   */
  public function onKernelEvent(Event $event) {
    drupal_set_message('Kernel event occurred: ' . $event->getName());
    watchdog('demo_event', 'Kernel event occurred: @event', array('@event' => $event->getName()), WATCHDOG_NOTICE);
  }

  /**
   * Displays broadcast event.
   *
   * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
   *   The event to process.
   */
  public function onBroadcastEvent(DemoMessageEvent $event) {
    drupal_set_message('Demo event occurred: ' . $event->getName());
    drupal_set_message('A message for you: ' . $event->getMessage(), 'warning');
    watchdog('demo_event', 'Message received: @message', array('@message' => $event->getMessage()), WATCHDOG_NOTICE);
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    // Subscribe to all kernel events.
    $events[KernelEvents::REQUEST][] = array('onKernelEvent');
    $events[KernelEvents::CONTROLLER][] = array('onKernelEvent');
    $events[KernelEvents::RESPONSE][] = array('onKernelEvent');
    $events[KernelEvents::VIEW][] = array('onKernelEvent');
    $events[KernelEvents::TERMINATE][] = array('onKernelEvent');
    $events[KernelEvents::EXCEPTION][] = array('onKernelEvent');

    // Subscribe to Demo events.
    $events[DemoEvents::BRAODCAST][] = array('onBroadcastEvent');

    return $events;
  }

}
