<?php

/**
 * @file
 * Contains \Drupal\hello\Form\HelloConfigForm.
 */

namespace Drupal\demo_config_translation\Form;

use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Config\Context\ContextInterface;
use Drupal\Core\Path\AliasManagerInterface;
use Drupal\Core\Form\ConfigFormBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configure text display settings for this the hello world page.
 */
class HelloConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormID() {
    return 'demo_config_translation_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, array &$form_state) {
    $config = $this->config('demo_config_translation.settings');

    $hello_message = $config->get('hello_message');

    $form['case'] = array(
      '#type' => 'radios',
      '#title' => $this->t('Letter case of your "Hello World!" message'),
      '#default_value' => $config->get('case'),
      '#options' => array(
        0 => $this->t('Do not modify'),
        1 => $this->t('UPPER'),
      ),
      '#description' => $this->t('Choose the case of your "Hello, world!" message.'),
    );

    $form['hello_message'] = array(
      '#type' => 'textfield',
      '#title' => t('Your "Hello World!" message'),
      '#default_value' => $config->get('hello_message'),
      '#required' => TRUE,
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, array &$form_state) {
    $this->config('demo_config_translation.settings')
      ->set('case', $form_state['values']['case'])
      ->set('hello_message', $form_state['values']['hello_message'])
      ->save();

    parent::submitForm($form, $form_state);
  }
}
