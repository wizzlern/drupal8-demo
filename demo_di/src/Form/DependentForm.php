<?php
/**
 * @file
 * Contains \Drupal\demo_di\Form\DependentForm.
 */

namespace Drupal\demo_di\Form;

use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\user\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Implements a form with dependency injection.
 */
class DependentForm extends FormBase {

  /**
   * The current user account object.
   *
   * @var AccountInterface $account
   */
  protected $account;

  /**
   * The entity manager. Can be used to load user entities.
   *
   * @var EntityManagerInterface $entityManager
   */
  protected $entityManager;

  /**
   * {@inheritdoc}.
   */
  public function getFormID() {
    return 'demo_di_dependent_form';
  }

  /**
   * Class constructor.
   * This custom constructor class "injects" two service objects into this
   * class. They and are stored in protect properties and used by the code in
   * this class.
   *
   * @see ::create()
   */
  public function __construct(AccountInterface $account, EntityManagerInterface $entity_manager) {
    // Store the services in properties to be used in other methods of this class.
    $this->account = $account;
    $this->entityManager = $entity_manager;
  }

  /**
   * {@inheritdoc}
   *
   * This implementation of a method of the ContainerInterface instantiates this
   * form class. In this example the class is instantiated with two services.
   * Using this method is the way to inject services into a form, or any other
   * class that implements the DependencyInjection/ContainerInterface.
   *
   * @see ::__construct()
   */
  public static function create(ContainerInterface $container) {
    // Instantiate the form object.
    return new static(
      // Load the services that are needed to create the form.
      $container->get('current_user'),
      $container->get('entity.manager')
    );
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['uid'] = array(
      '#type' => 'number',
      '#title' => $this->t('User ID'),
      '#description' => $this->t('Some information of this user will be displayed'),
      '#default_value' => 0,
      '#min' => 0,
    );
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Show user info'),
      '#button_type' => 'primary',
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $user = $this->entityManager->getStorage('user')->load($form_state->getValue('uid'));
    if (empty($user)) {
      $form_state->setErrorByName('uid', t('No user exists with this ID. Please enter a valid user ID.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Get current user data.
    $id = $this->account->id();
    $name = $this->account->getUsername();
    drupal_set_message($this->t('The current user is @name (uid: !id).', array('@name' => $name, '!id' => $id)));

    // Get data of the selected user.
    /** @var \Drupal\user\Entity\User $user */
    $user = $this->entityManager->getStorage('user')->load($form_state->getValue('uid'));
    $id = $user->id();
    $name = $user->getUsername();
    $roles = $user->getRoles();
    drupal_set_message($this->t('User @name (uid: !id) has roles: @roles', array('@name' => $name, '!id' => $id, '@roles' => implode(', ', $roles))));
  }

}
