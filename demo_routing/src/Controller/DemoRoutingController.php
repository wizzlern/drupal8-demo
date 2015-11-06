<?php

/**
 * @file
 * Contains \Drupal\demo_routing\Controller\DemoRoutingController.
 */

namespace Drupal\demo_routing\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\Request;

/**
 * Returns responses for Events Demo module routes.
 */
class DemoRoutingController extends ControllerBase {

  /**
   * Controller content callback: Info page.
   *
   * @return string
   */
  public function infoPage() {

    $output['info'] = array(
      '#markup' => $this->t('This demonstrates the capabilities of the Drupal 8 routing system. The following examples are available:'),
    );
    $today = strtolower(date('l', REQUEST_TIME));
    $output['urls'] = array(
      '#theme' => 'item_list',
      '#items' => array(
        $this->t('A static route: @link (current page).', array('@link' => \Drupal::l('/demo/routing', new Url('demo_routing.info')))),
        $this->t('A route with a placeholder: @link.', array('@link' => \Drupal::l('/demo/routing/hello/[your name]', New Url('demo_routing.hello', array('name' => 'you'))))),
        $this->t('A route with a placeholder which is automatically converted to an object: @link.', array('@link' => \Drupal::l('demo/routing/user/[user id]', New Url('demo_routing.user', array('user' => 1))))),
        $this->t('A dynamic route: @link.', array('@link' => \Drupal::l("/demo/routing/day/[name of today's weekday]", Url::fromUserInput('/demo/routing/day/' . $today)))),
        $this->t('An altered route. URI /user/login is now changed to @link.', array('@link' => \Drupal::l('/login', Url::fromUserInput('/login')))),
        $this->t('An altered route. Access to <a href="/user/logout">/user/logout</a> is always denied.'),
      ),
    );

    return $output;
  }

  /**
   * Controller content callback: Hello page with dynamic URL.
   *
   * @return string
   */
  public function helloYouPage($name) {

    $output['hello'] = array(
      '#markup' => $this->t('Hello @name', array('@name' => $name)),
    );

    return $output;
  }

  /**
   * Controller content callback: Hello page with dynamic URL.
   *
   * @return string
   */
  public function today() {

    $output['today'] = array(
      '#markup' => $this->t("Today it's @!day_of_the_week. Yay!", array('@day_of_the_week' => date('l', REQUEST_TIME))),
    );

    return $output;
  }

  /**
   * Controller content callback: Hello page with dynamic URL.
   *
   * @return string
   */
  public function helloUserPage(AccountInterface $user, Request $request) {

    // Get the raw parameter from the URL.
    $uid = $request->attributes->get('_raw_variables')->get('user');

    $output['hello'] = array(
      '#markup' => $this->t('Hello @name. Your user ID is @id', array(
        '@name' => $user->getUsername(),
        '@id' => $uid,
      )),
    );

    return $output;
  }

}
