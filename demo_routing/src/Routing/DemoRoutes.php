<?php

/**
 * @file
 * Contains \Drupal\demo_routing\Routing\DemoRoutes.
 */

namespace Drupal\demo_routing\Routing;

use Symfony\Component\Routing\Route;

/**
 * Defines dynamic routes.
 */
class DemoRoutes {

  /**
   * {@inheritdoc}
   */
  public function routes() {
    $today = strtolower(date('l', REQUEST_TIME));

    $routes['demo_routing.today'] = new Route(
      '/demo/routing/day/' . $today,
      array(
        '_controller' => '\Drupal\demo_routing\Controller\DemoRoutingController::today',
        '_title' => 'Today',
      ),
      array('_permission' => 'access content')
    );
    return $routes;
  }

}