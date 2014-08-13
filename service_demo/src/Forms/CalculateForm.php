<?php
/**
 * @file
 * Contains \Drupal\service_demo\Form\CalculateForm.
 */

namespace Drupal\service_demo\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


/**
 * User input form to make calculations.
 */
class CalculateForm extends FormBase {

  /**
   * {@inheritdoc}.
   */
  public function getFormID() {
    return 'service_demo_calculate_form';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['number'] = array(
      '#type' => 'number',
      '#title' => $this->t('A number'),
      '#required' => TRUE,
      '#default_value' => 1,
      '#min' => 0,
    );

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Nth Fibonacci'),
      '#button_type' => 'primary',
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $number = $form_state->getValue('number');
    $result = $this->calculateFibonacciNth($number);
    drupal_set_message($this->t('The !number<sup>th</sup> Fibonacci number is !result.', array('!number' => $number, '!result' => $result)));
  }

  protected function calculateFibonacciNth($number) {
    // Get the Fibonacci service and use it to calculate the value of the Nth
    // number.
    // NOTE: calling the global service container from within a class is
    // considered bad practice. Instead, you should use dependency injection to
    // allow the service to be replaced with another one.
    $fibonacci = \Drupal::service('fibonacci');
    return $fibonacci->calculateNth($number);
  }
}
