<?php

/**
 * @file
 * Contains \Drupal\demo_node\Controller\NodeContent.
 */

namespace Drupal\demo_node\Controller;

use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\Query\QueryFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;


class NodeContent extends ControllerBase {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The entity field manager.
   *
   * @var \Drupal\Core\Entity\EntityFieldManagerInterface
   */
  protected $entityFieldManager;

  /**
   * The entity query factory.
   *
   * @var \Drupal\Core\Entity\Query\QueryFactory.
   */
  protected $entityQuery;

  /**
   * Constructs the controller using dependency injection.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Entity\EntityFieldManagerInterface $entity_field_manager
   *   The entity field manager.
   * @param \Drupal\Core\Entity\Query\QueryFactory $query_factory
   *   The query factory.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, EntityFieldManagerInterface $entity_field_manager, QueryFactory $entity_query) {
    $this->entityTypeManager = $entity_type_manager;
    $this->entityFieldManager = $entity_field_manager;
    $this->entityQuery = $entity_query;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
    // We only care about the Webservice enities in this form, therefore
    // we directly use and store the right storage.
      $container->get('entity_type.manager'),
      $container->get('entity_field.manager'),
      $container->get('entity.query')
    );
  }

  /**
   * Displays individual fields of one node content and a the teaser.
   *
   * @return array
   *   Render Array of page content.
   */
  public function oneNode() {

    $nids = $this->entityQuery->get('node')
      ->condition('type', 'article')
      ->condition('status', 1)
      ->range(0, 1)
      ->execute();
    /** @var \Drupal\node\Entity\Node $node */
    $node = $this->entityTypeManager->getStorage('node')->load(reset($nids));

    $output['info'] = array(
      '#markup' => $this->t('This page contains various pieces of content of an article.'),
    );

    $output['fields'] = array(
      '#type' => 'fieldset',
      '#title' => $this->t('Individual node fields'),
      '#collapsible' => FALSE,
      '#attributes' => array(),
    );

    $base_fields = array_keys($this->entityFieldManager->getBaseFieldDefinitions('node'));
    $output['fields']['base_fields'] = array(
      '#theme' => 'item_list',
      '#title' => 'Base fields',
      '#items' => array(
        new FormattableMarkup('All base fields: @value', array('@value' => implode(', ', $base_fields))),
        new FormattableMarkup('Node ID: @value', array('@value' => $node->id())),
        new FormattableMarkup('Node type: @value', array('@value' => $node->getType())),
        new FormattableMarkup('Node title: @value', array('@value' => $node->getTitle())),
        new FormattableMarkup('Node author ID: @value', array('@value' => $node->getOwnerId())),
        new FormattableMarkup('Node author name: @value', array('@value' => $node->getOwner()->getUsername())),
        //format_string('First term ID: @value', array('@value' => $node->field_tags[0]->target_id)),
        new FormattableMarkup('First tenew FormattableMarkuprm ID: @value', array('@value' => $node->field_tags->target_id)),
      ),
      '#weight' => -2,
    );

    $node_fields = array_keys($node->getFieldDefinitions());
    $config_fields = array_diff($node_fields, $base_fields);
    $output['fields']['configurable_fields'] = array(
      '#theme' => 'item_list',
      '#title' => 'Configurable fields',
      '#items' => array(
        new FormattableMarkup('All configurable fields: @value', array('@value' => implode(', ', $config_fields))),
        new FormattableMarkup('First term name: @value', array('@value' => $node->field_tags->entity->name->value)),
        new FormattableMarkup('First term description: @value', array('@value' => $node->field_tags->entity->description->value)),
        new FormattableMarkup('Body text: @value', array('@value' => $node->body->value)),
        new FormattableMarkup('Body text format: @value', array('@value' => $node->body->format)),
      ),
      '#weight' => -1,
    );

    // The node in teaser view.
    $output['view'] = array(
      '#type' => 'fieldset',
      '#title' => $this->t('Node in teaser view'),
      '#collapsible' => FALSE,
      '#attributes' => array(),
    );
    $output['view']['teaser'] = $this->entityTypeManager->getViewBuilder('node')->view($node, 'teaser');
    $output['#cache']['max-time'] = 0;

    return $output;
  }

  /**
   * Displays a selection of node.
   *
   * @return array
   *   Render Array of page content.
   */
  public function nodeSelection() {

    // Select the nodes we want to show. i.e. 3 published articles.
    $nids = $this->entityQuery->get('node')
      ->condition('type', 'article')
      ->condition('status', 1)
      ->range(0, 3)
      ->execute();
    $nodes =  $this->entityTypeManager->getStorage('node')->loadMultiple($nids);

    // Build a list of node teasers for output.
    $output['selection'] = array(
      '#theme' => 'item_list',
    );
    foreach ($nodes as $node) {
      $output['selection']['#items'][] = $this->entityTypeManager->getViewBuilder('node')->view($node, 'teaser');
    }

    return $output;
  }

  /**
   * Displays a selection of node by taxonomy term name.
   *
   * @return array
   *   Render Array of page content.
   */
  public function nodesByTermName() {

    // @todo Create content if required.

    // Select the nodes referencing a term with the name 'Boat'.
    $nids = $this->entityQuery->get('node')
      ->condition('type', 'article')
      ->condition('status', 1)
      ->condition('field_tags.entity.name', 'Boat')
      ->execute();
    $nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);

    // Build a list of node teasers for output.
    $output['selection'] = array(
      '#theme' => 'item_list',
    );
    foreach ($nodes as $node) {
      $output['selection']['#items'][] = $this->entityTypeManager->getViewBuilder('node')->view($node, 'teaser');
    }

    return $output;
  }

}
