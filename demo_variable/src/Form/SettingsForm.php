<?php
/**
 * @file
 * Contains \Drupal\demo_variable\Form\SettingsForm.
 */

namespace Drupal\demo_variable\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements an example form.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}.
   */
  public function getFormID() {
    return 'demo_variable_config_form';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->configFactory->get('demo_variable.settings');

    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Your name'),
      '#default_value' => $config->get('name'),
      '#required' => TRUE,
    );
    $options = array(
      'build' => $this->t('Building with modules'),
      'develop' => $this->t('Development'),
      'theme' => $this->t('Theming'),
      'devops' => $this->t('DevOps'),
    );
    $form['skills'] = array(
      '#type' => 'checkboxes',
      '#title' => $this->t('Drupal skills'),
      '#description' => $this->t('Your drupal skills.'),
      '#options' => $options,
      '#default_value' => $config->get('drupal.skills') ? $config->get('drupal.skills') : array(),
    );

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->configFactory->get('demo_variable.settings');

    // Add the form values to the configuration.
    $config->set('name', $form_state->getValue('name'));
    $config->set('drupal.skills', array_filter($form_state->getValue('skills')));

    // Save the configuration.
    $config->save();
  }
}
