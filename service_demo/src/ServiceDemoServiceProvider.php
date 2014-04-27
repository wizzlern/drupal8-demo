<?php
/**
 * @file
 * Contains Drupal\service_demo\ServiceDemoServiceProvider
 */
namespace Drupal\service_demo;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Modifies the language manager service.
 * 
 * Note that this class is automatically recognized based on
 * file name, parent class and file directory.
 * @see https://drupal.org/node/2026959
 */
class ServiceDemoServiceProvider extends ServiceProviderBase {

  /**
   * {@inheritdoc}
   *
   * Overrides language_negotiator class to use English for user/1.
   */
  public function alter(ContainerBuilder $container) {
    // This alter builds on top of LanguageServiceProvider::alter(). For this
    // alter to work in the right order the name of this module is 'service_demo'
    // which makes the ServiceDemoServiceProvider::alter() kick-in later.

    // Drupal\service_demo\ServiceDemoLanguageManager has one additional
    // dependency, the 'current_user' service. Because this alter is on-top
    // of Drupal\Core\Language\Language\LanguageServiceProvider we only have to
    // add this service as argument.
    $definition = $container->getDefinition('language_manager');
    $definition->setClass('Drupal\service_demo\ServiceDemoLanguageManager')
      ->addArgument(new Reference('current_user'));
  }
}