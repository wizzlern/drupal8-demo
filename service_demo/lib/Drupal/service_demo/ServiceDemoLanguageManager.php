<?php

/**
 * @file
 * Contains \Drupal\language\ConfigurableLanguageManager.
 */

namespace Drupal\service_demo;

use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Language\Language;
use Drupal\Core\Language\LanguageDefault;
use Drupal\language\ConfigurableLanguageManager;
use Drupal\Core\Session\AccountInterface;

/**
 * Overrides default LanguageManager to provide configured languages.
 */
class ServiceDemoLanguageManager extends ConfigurableLanguageManager {

  /**
   * The current user service.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  public function __construct(LanguageDefault $default_language, ConfigFactory $config_factory, ModuleHandlerInterface $module_handler, AccountInterface $current_user) {
    // The override of getCurrentLanguage() uses the 'current_user' service.
    $this->currentUser = $current_user;
    parent::__construct($default_language, $config_factory, $module_handler);
  }

  /**
   * {@inheritdoc}
   *
   * Forces the current language of user/1 to be English.
   */
  public function getCurrentLanguage($type = Language::TYPE_INTERFACE) {

    if (!isset($this->negotiatedLanguages[$type])) {
      // The interface language of user/1 is set to be English.
      if ($this->currentUser->id() == '1' && $type == Language::TYPE_INTERFACE) {
        $languages = $this->getLanguages();
        if (isset($languages['en'])) {
          $this->negotiatedLanguages[$type] = $languages['en'];
        }
      }
      // For other users the default language negotiation is used.
      else {
        $this->negotiatedLanguages[$type] = parent::getCurrentLanguage($type);
      }
    }

    return $this->negotiatedLanguages[$type];
  }
}
