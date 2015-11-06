<?php

/**
 * @file
 * Contains \Drupal\demo_event\EventSubscriber\DemoEventSubscriber.
 */

namespace Drupal\demo_event\EventSubscriber;

use Drupal\demo_event\DemoEvents;
use Drupal\demo_event\DemoMessageEvent;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Demo event subscriber. Responds to kernel events and demo events.
 */
class DemoEventSubscriber implements EventSubscriberInterface {

  /**
   * Logs kernel events.
   *
   * @param \Symfony\Component\EventDispatcher\Event $event
   *   The event to process.
   */
  public function onKernelEvent(Event $event) {
    drupal_set_message(format_string('Kernel events occurred. <a href=":url">See the Log for details</a>.', [':url' => '/admin/reports/dblog']));
    \Drupal::logger('demo_event')->notice(format_string('@time: Kernel event %event', array('%event' => $event->getName(), '@time' => REQUEST_TIME)));
  }

  /**
   * Displays broadcast event.
   *
   * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
   *   The event to process.
   */
  public function onBroadcastEvent(DemoMessageEvent $event) {
    drupal_set_message('Demo event occurred: ' . $event->getName());
    drupal_set_message('We have a message for you: ' . $event->getMessage(), 'warning');
    \Drupal::logger('demo_event')->notice(format_string('Message received: @message', array('@message' => $event->getMessage())));
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

    // Subscribe to Demo broadcast events
    $events[DemoEvents::BROADCAST][] = array('onBroadcastEvent');

    return $events;
  }

}
