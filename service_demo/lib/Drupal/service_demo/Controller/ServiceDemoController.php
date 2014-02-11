<?php

/**
 * @file
 * Contains \Drupal\service_demo\Controller\ServiceDemoController.
 */

namespace Drupal\service_demo\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Returns responses for Demo Form module routes.
 */
class ServiceDemoController extends ControllerBase {

  /**
   * Controller content callback: Info page.
   *
   * @return string
   */
  public function infoPage() {

    $output['info'] = array(
      '#markup' => $this->t('This demonstrates Services in Drupal 8. The following examples are available:'),
    );

    $output['urls'] = array(
      '#theme' => 'item_list',
      '#items' => array(
        $this->t('Calculate Fibonacci numbers: !url.', array('!url' => l('/demo/service/calculate', 'demo/service/calculate'))),
        $this->t('Displays the current page language: !url.', array('!url' => l('/demo/service/language', 'demo/service/language'))),
      ),
    );

    return $output;
  }

  public function languagePage(Request $request) {
    $language = \Drupal::service('language_manager')->getCurrentLanguage();

    $output['info'] = array(
      '#markup' => $this->t('The current language is @language. The language for user/1 is always English.', array('@language' => $language->name)),
    );

    return $output;
  }
}
