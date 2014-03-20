<?php

/**
 * @file
 * Contains \Drupal\demo_plugin\Plugin\Field\FieldFormatter\DemoPluginUppercaseFormatter.
 */

namespace Drupal\demo_plugin\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'demo Uppercase' formatter.
 *
 * @FieldFormatter(
 *   id = "demo_plugin_uppercase",
 *   label = @Translation("Uppercase"),
 *   field_types = {
 *     "text"
 *   }
 * )
 */
class DemoPluginUppercaseFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items) {
    $elements = array();

    // Note that entity output is cached. After any change in the code below the
    // cache (registry) has to be cleared.
    foreach ($items as $delta => $item) {
      /** @var \Drupal\text\Plugin\Field\FieldType\TextItem $item */
      $elements[$delta] = array('#markup' => drupal_strtoupper($item->processed));
    }

    return $elements;
  }

}
