<?php

/**
 * @file
 * Contains \Drupal\demo_variable\Controller\DemoVariableController.
 */

namespace Drupal\demo_variable\Controller;

use Drupal\Core\Site\Settings;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;

/**
 * Returns responses for Events Demo module routes.
 */
class DemoVariableController extends ControllerBase {

  /**
   * Controller content callback: Lists the value of some variables called.
   *
   * @return string
   */
  public function infoPage() {

    $output['info'] = array(
      '#markup' => $this->t('This demonstrates the different variable systems in Drupal 8. The following examples are available:'),
    );

    $output['pages'] = array(
      '#theme' => 'item_list',
      '#items' => array(
        $this->t('Settings: !url.', array('!url' => \Drupal::l('/demo/variable/setting', New Url('demo_variable.setting')))),
        $this->t('State: !url.', array('!url' => \Drupal::l('/demo/variable/state', New Url('demo_variable.state')))),
        $this->t('Simple configuration: !url.', array('!url' => \Drupal::l('/demo/variable/config', New Url('demo_variable.config')))),
      ),
    );

    return $output;
  }

  /**
   * Controller content callback: Lists the values of some variables called.
   *
   * @return string
   */
  public function settingsPage() {

    $output['info'] = array(
      '#markup' => $this->t('Settings are set at bootstrap and can be overwritten in settings.php. These setting are currently available:'),
    );
    $items = array();
    foreach(Settings::getAll() as $key => $value) {

      // We modify the value to display it properly.
      if (is_bool($value)) {
        $value = $value ? 'TRUE' : 'FALSE';
      }

      $items[] = format_string("\$settings['@name'] = @value", array('@name' => $key, '@value' => $value));

    }
    $output['settings'] = array(
      '#theme' => 'item_list',
      '#items' => $items,
    );

    return $output;
  }

  /**
   * Controller content callback: Show the time this page was last visited.
   *
   * @return string
   */
  public function statePage() {

    $output['info'] = array(
      '#prefix' => '<p>',
      '#markup' => $this->t('State variables represent a certain state of a process. For example the last time cron was run.'),
      '#suffix' => '</p>',
    );

    // Get the the Last Visited timestamp and prepare it for display.
    $last = \Drupal::state()->get('demo_variable.last_visited');
    $time = $last ? format_date($last) : $this->t('Unknown');

    // Set the Last Visited timestamp to the current time and store it.
    // The state service should be inject it as a depencency, not hardcoded,
    // but we leave that for the Dependency Injection demo module./
    \Drupal::state()->set('demo_variable.last_visited', REQUEST_TIME);

    $output['state'] = array(
      '#prefix' => '<p>',
      '#markup' => $this->t('Last time you visited this page: !time', array('!time' => $time)),
      '#suffix' => '</p>',
    );

    return $output;
  }

}
