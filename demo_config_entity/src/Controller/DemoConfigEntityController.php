<?php

/**
 * @file
 * Contains \Drupal\demo_config_entity\Controller\DemoConfigEntityController.
 */

namespace Drupal\demo_config_entity\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
//use Drupal\demo_config_entity\Entity\Webservice;

/**
 * Returns information for Content Entity Demo.
 */
class DemoConfigEntityController extends ControllerBase {

  /**
   * Controller content callback: Info page.
   *
   * @return string
   */
  public function infoPage() {

    $output['info'] = array(
      '#markup' => $this->t('This demonstrates the capabilities of the Drupal 8 Configuration Entities. The following examples are available:'),
    );
    $output['urls'] = array(
      '#theme' => 'item_list',
      '#items' => array(
        $this->t('Add and list a simple <em>webservice</em> entity: !uri.', array('!uri' => \Drupal::l('/demo/configuration-entity/add', New Url('demo_config_entity.add')))),
//        $this->t('List all entities: !uri.', array('!uri' => \Drupal::l('/demo/demo_config_entity/list', New Url('demo_config_entity.list')))),
      ),
    );

//    $values = array(
//      'name' => 'one4',
//      'label' => 'One',
//      'url' => 'http://example-one.com',
//      'port' => '8080',
//      'foo' => 'Foo',
//    );
    // Additional keys are ignored ('foo').
    // Missing data does not get a default (by default).
    // Missing id (name) results in Drupal\Core\Entity\EntityMalformedException
//    $webservice = new Webservice($values, 'demo_config_entity_webservice');
//    $webservice->save();
//    $one = entity_load('demo_config_entity_webservice', 'one1');
//    dpm($one);
//    dpm($one->id());
//    dpm($one->uuid());
//    dpm($one->label());
//
//    dpm($one->url);
//    dpm($one->port);
    return $output;
  }


}
