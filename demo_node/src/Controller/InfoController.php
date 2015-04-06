<?php

/**
 * @file
 * Contains \Drupal\demo_node\Controller\InfoController.
 */

namespace Drupal\demo_node\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;

class InfoController extends ControllerBase {

  /**
   * Controller content callback: Info page.
   *
   * @return array
   *   Render Array of page content.
   */
  public function infoPage() {

    $output['info'] = array(
      '#markup' => $this->t('This demonstrates the handling of node data in Drupal 8. The following examples are available:'),
    );

    $output['urls'] = array(
      '#theme' => 'item_list',
      '#items' => array(
        $this->t('A random article and node data: !uri.', array('!uri' => \Drupal::l('/demo/menu/one', New Url('demo_node.node')))),
        $this->t('3 published articles: !uri.', array('!uri' => \Drupal::l('/demo/node/list', New Url('demo_node.list')))),
        $this->t("Articles with the term 'Boat': !uri.", array('!uri' => \Drupal::l('/demo/node/term', New Url('demo_node.term')))),
      ),
    );

    return $output;
  }

}
