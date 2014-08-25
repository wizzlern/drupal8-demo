<?php
/**
 * @file
 * Contains \Drupal\demo_event\Form\EventForm.
 */

namespace Drupal\demo_event\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\demo_event\DemoEvents;
use Drupal\demo_event\DemoMessageEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Implements an example form.
 */
class EventForm extends FormBase {

  /**
   * {@inheritdoc}.
   */
  public function getFormID() {
    return 'demo_event_event_form';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['info'] = array(
      '#markup' => $this->t('This form will trigger an event when the form is submitted. When the event'),
    );

    $form['message'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Your message'),
      '#description' => $this->t('This message will be broadcasted to the current user.'),
      '#required' => TRUE,
    );
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#button_type' => 'primary',
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $message = $form_state->getValue('message');

    // Dispatch a demo event using the message text as content of the event.
    // The listener that is subscribed will create a response message.
    // @todo The event dispatcher should be injected as a dependency.
    $dispatcher = \Drupal::service('event_dispatcher');
    $dispatcher->dispatch(DemoEvents::BROADCAST, new DemoMessageEvent($message));

    drupal_set_message($this->t('Your message was broadcasted. You should see the result immediately.'));
  }
}
