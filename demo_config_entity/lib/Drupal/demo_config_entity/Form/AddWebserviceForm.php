<?php
/**
 * @file
 * Contains \Drupal\demo_config_entity\Form\AddWebserviceForm.
 */

namespace Drupal\demo_config_entity\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Entity\EntityStorageControllerInterface;
use Drupal\demo_config_entity\Entity\Webservice;
use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\Core\Entity\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Implements an example form.
 */
class AddWebserviceForm extends FormBase {

  /**
   * The webservice storage controller.
   *
   * @var \Drupal\Core\Entity\EntityStorageControllerInterface
   */
  protected $storageController;

  /**
   * The entity query factory.
   *
   * @var \Drupal\Core\Entity\Query\QueryFactory.
   */
  protected $entityQuery;

  /**
   * Constructs a new form using dependency injection.
   *
   * @param \Drupal\Core\Entity\EntityStorageControllerInterface $storage_controller
   *   The entity storage controller.
   * @param \Drupal\Core\Entity\Query\QueryFactory $query_factory
   *   The query factory.
   */
  public function __construct(EntityStorageControllerInterface $storage_controller, QueryFactory $entity_query) {
    $this->storageController = $storage_controller;
    $this->entityQuery = $entity_query;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      // We only care about the Webservice enities in this form, therefore
      // we directly use and store the right storage controller.
      $container->get('entity.manager')->getStorageController('demo_config_entity_webservice'),
      $container->get('entity.query')
    );
  }

  /**
   * {@inheritdoc}.
   */
  public function getFormID() {
    return 'demo_config_entity_webservice_add';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, array &$form_state) {

    // Show all websform entities in a table.
    $entities = $this->getAllWebservices();
    $form['entities'] = array(
      '#type' => 'table',
      '#header' => array(
        $this->t('ID'),
        $this->t('Name'),
        $this->t('URL'),
        $this->t('Port'),
      ),
      '#empty' => $this->t('There are no webservices yet. You can add using the form below'),
      '#title' => $this->t('Available webservices'),
    );
    foreach ($entities as $id => $webserice) {
      $form['entities'][$id] = array(
        array('#markup' => $webserice->id()),
        array('#markup' => $webserice->label),
        array('#markup' => $webserice->url),
        array('#markup' => $webserice->port),
      );
    }

    $form['label'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => '255',
      '#description' => $this->t('A unique name for this webservice.'),
    );
    $form['name'] = array(
      '#type' => 'machine_name',
      '#maxlength' => 64,
      '#description' => $this->t('A unique name for this webservice. It must only contain lowercase letters, numbers and underscores.'),
      '#machine_name' => array(
        'exists' => array($this, 'exists'),
      ),
    );
    $form['url'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('URL'),
      '#maxlength' => '255',
      '#description' => $this->t('The URL of this webservice. For example: http://example.com'),
    );
    $form['port'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Port'),
      '#maxlength' => '6',
      '#description' => $this->t('The port of this webservice. For example: 8080'),
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
  public function submitForm(array &$form, array &$form_state) {
    $webservice = new Webservice($form_state['values'], 'demo_config_entity_webservice');
    $webservice->save();
    drupal_set_message($this->t('Webform @name was saved.', array('@name' => $form_state['values']['label'])));
  }

  /**
   * Determines if the webservice name already exists.
   *
   * @param string $id
   *   The action ID
   *
   * @return bool
   *   TRUE if the action exists, FALSE otherwise.
   */
  public function exists($id) {
    $action = $this->storageController->load($id);
    return !empty($action);
  }

  /**
   * Gets all webservice entities.
   *
   * @return mixed
   */
  protected function getAllWebservices() {
    // Query for all webservice entities.
    // $this->entityQuery->get('demo_config_entity_webservice')->execute();

    // Load all webservice entities.
    return $this->storageController->loadMultiple();
  }
}
