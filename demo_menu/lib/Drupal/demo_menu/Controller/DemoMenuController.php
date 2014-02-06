<?php

/**
 * @file
 * Contains \Drupal\demo_menu\Controller\DemoMenuController.
 */

namespace Drupal\demo_menu\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Demo Menu module routes.
 */
class DemoMenuController extends ControllerBase {

  /**
   * Controller content callback: Info page.
   *
   * @return array
   */
  public function infoPage() {

    $output['info'] = array(
      '#markup' => $this->t('This demonstrates the capabilities of the Drupal 8 menu API. The following examples are available:'),
    );

    $output['pages'] = array(
      '#theme' => 'item_list',
      '#items' => array(
        $this->t('Menu page with tab: !url.', array('!url' => l('/demo/menu/one', 'demo/menu/one'))),
        $this->t('Menu page with action link: !url.', array('!url' => l('/demo/menu/two', 'demo/menu/two'))),
      ),
    );

    return $output;
  }

  /**
   * Controller content callback: Menu page one.
   *
   * @return array
   */
  public function menuOne() {

    $output['info'] = array(
      '#markup' => $this->t('Welcome. Enjoy your stay.'),
    );

    return $output;
  }

  /**
   * Controller content callback: Menu page two.
   *
   * @return array
   */
  public function menuTwo() {

    $output['info'] = array(
      '#markup' => $this->t("Hey, a visitor! Let's have a party."),
    );

    return $output;
  }

}
