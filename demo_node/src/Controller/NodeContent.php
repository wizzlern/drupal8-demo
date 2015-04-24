<?php

/**
 * @file
 * Contains \Drupal\demo_node\Controller\NodeContent.
 */

namespace Drupal\demo_node\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Entity\Query\QueryFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;


class NodeContent extends ControllerBase {

  /**
   * The webservice storage.
   *
   * @var \Drupal\Core\Entity\EntityManagerInterface
   */
  protected $entityManager;

  /**
   * The entity query factory.
   *
   * @var \Drupal\Core\Entity\Query\QueryFactory.
   */
  protected $entityQuery;

  /**
   * Constructs the controller using dependency injection.
   *
   * @param \Drupal\Core\Entity\EntityStorageInterface $storage
   *   The entity storage.
   * @param \Drupal\Core\Entity\Query\QueryFactory $query_factory
   *   The query factory.
   */
  public function __construct(EntityManagerInterface $entity_manager, QueryFactory $entity_query) {
    $this->entityManager = $entity_manager;
    $this->entityQuery = $entity_query;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
    // We only care about the Webservice enities in this form, therefore
    // we directly use and store the right storage.
      $container->get('entity.manager'),
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
    $node = $this->entityManager->getStorage('node')->load(reset($nids));

    $output['info'] = array(
      '#markup' => $this->t('This page contains various pieces of content of an article.'),
    );

    $output['fields'] = array(
      '#type' => 'fieldset',
      '#title' => $this->t('Individual node fields'),
      '#collapsible' => FALSE,
      '#attributes' => array(),
    );

    $base_fields = array_keys($this->entityManager->getBaseFieldDefinitions('node'));
    $output['fields']['base_fields'] = array(
      '#theme' => 'item_list',
      '#title' => 'Base fields',
      '#items' => array(
        format_string('All base fields: @value', array('@value' => implode(', ', $base_fields))),
        format_string('Node ID: @value', array('@value' => $node->id())),
        format_string('Node type: @value', array('@value' => $node->getType())),
        format_string('Node title: @value', array('@value' => $node->getTitle())),
        format_string('Node author ID: @value', array('@value' => $node->getOwnerId())),
        format_string('Node author name: @value', array('@value' => $node->getOwner()->getUsername())),
        //format_string('First term ID: @value', array('@value' => $node->field_tags[0]->target_id)),
        format_string('First term ID: @value', array('@value' => $node->field_tags->target_id)),
      ),
      '#weight' => -2,
    );

    $node_fields = array_keys($node->getFieldDefinitions());
    $config_fields = array_diff($node_fields, $base_fields);
    $output['fields']['configurable_fields'] = array(
      '#theme' => 'item_list',
      '#title' => 'Configurable fields',
      '#items' => array(
        format_string('All configurable fields: @value', array('@value' => implode(', ', $config_fields))),
        format_string('First term name: @value', array('@value' => $node->field_tags->entity->name->value)),
        format_string('First term description: @value', array('@value' => $node->field_tags->entity->description->value)),
        format_string('Body text: @value', array('@value' => $node->body->value)),
        format_string('Body text format: @value', array('@value' => $node->body->format)),
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
    $output['view']['teaser'] = $this->entityManager->getViewBuilder('node')->view($node, 'teaser');

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
    $nodes =  $this->entityManager->getStorage('node')->loadMultiple($nids);

    // Build a list of node teasers for output.
    $output['selection'] = array(
      '#theme' => 'item_list',
    );
    foreach ($nodes as $node) {
      $output['selection']['#items'][] = $this->entityManager->getViewBuilder('node')->view($node, 'teaser');
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
    $nodes = $this->entityManager->getStorage('node')->loadMultiple($nids);

    // Build a list of node teasers for output.
    $output['selection'] = array(
      '#theme' => 'item_list',
    );
    foreach ($nodes as $node) {
      $output['selection']['#items'][] = $this->entityManager->getViewBuilder('node')->view($node, 'teaser');
    }

    return $output;
  }

}
