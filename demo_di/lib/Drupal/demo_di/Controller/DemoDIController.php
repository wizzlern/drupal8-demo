<?php

/**
 * @file
 * Contains \Drupal\demo_di\Controller\DemoDIController.
 */

namespace Drupal\demo_di\Controller;

use Drupal\Core\Controller\ControllerBase;

class DemoDIController extends ControllerBase {

  /**
   * Controller content callback: Info page.
   *
   * @return string
   */
  public function infoPage() {

    $output['info'] = array(
      '#markup' => $this->t('This demonstrates Dependency Injection in Drupal 8. The following examples are available:'),
    );

    $output['urls'] = array(
      '#theme' => 'item_list',
      '#items' => array(
        $this->t('Show user information: !url.', array('!url' => l('/demo/dependency-injection/form', 'demo/dependency-injection/form'))),
      ),
    );

    return $output;
  }

}
