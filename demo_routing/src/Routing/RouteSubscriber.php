<?php

/**
 * @file
 * Contains \Drupal\demo_routing\Routing\RouteSubscriber.
 */

namespace Drupal\demo_routing\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   *
   * alterRoutes() is called at the RoutingEvents::ALTER event using the
   * event subscriber in RouteSubscriberBase.
   */
  public function alterRoutes(RouteCollection $collection) {
    // Change path '/user/login' to '/login'.
    $route = $collection->get('user.login');
    $route->setPath('/login');

    // Always deny access to '/user/logout'.
    // Note that the second parameter of setRequirement() is a string.
    $route = $collection->get('user.logout');
    $route->setRequirement('_access', 'FALSE');
  }
}