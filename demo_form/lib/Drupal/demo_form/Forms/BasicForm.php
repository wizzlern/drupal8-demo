<?php
/**
 * @file
 * Contains \Drupal\demo_form\Forms\BasicForm.
 */

namespace Drupal\demo_form\Forms;

use Drupal\Core\Form\FormBase;

/**
 * Implements an example form.
 */
class BasicForm extends FormBase {

  /**
   * {@inheritdoc}.
   */
  public function getFormID() {
    return 'demo_form_basic_form';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, array &$form_state) {
    $form['phone_number'] = array(
      '#type' => 'tel',
      '#title' => $this->t('Your phone number'),
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
  public function validateForm(array &$form, array &$form_state) {
    if (strlen($form_state['values']['phone_number']) < 3) {
      $this->setFormError('phone_number', $form_state, t('The phone number is too short. Please enter a full phone number.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, array &$form_state) {
    drupal_set_message($this->t('Your phone number is @number', array('@number' => $form_state['values']['phone_number'])));
  }
}
