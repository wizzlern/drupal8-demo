<?php

/**
 * @file
 * Contains \Drupal\demo_node\Controller\InfoController.
 */

namespace Drupal\demo_node\Controller;

use Drupal\Core\Controller\ControllerBase;


class InfoController extends ControllerBase {

  /**
   * Controller content callback: Info page.
   *
   * @return array
   *   Render Array of page content.
   */
  public function infoPage() {

    $output['info'] = array(
      '#markup' => $this->t('This demonstrates the capabilities of the Drupal 8 routing system. The following examples are available:'),
    );

    $output['urls'] = array(
      '#theme' => 'item_list',
      '#items' => array(
        $this->t('A random article and node data: !uri.', array('!uri' => l('/demo/node/one', 'demo/node/one'))),
        $this->t('3 published articles: !uri.', array('!uri' => l('/demo/node/list', 'demo/node/list'))),
        $this->t("Articles with the term 'Boat': !uri.", array('!uri' => l('/demo/node/term', 'demo/node/term'))),
      ),
    );

    return $output;
  }

}
