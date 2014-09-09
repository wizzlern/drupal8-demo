<?php

/**
 * @file
 * Contains \Drupal\demo_plugin\Plugin\Field\FieldFormatter\DemoPluginUppercaseFormatter.
 */

namespace Drupal\demo_plugin\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Unicode;
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

    // Note that entity output is cached. After changing the code below the
    // cache (registry) should be cleared or the content should be re-saved.
    foreach ($items as $delta => $item) {
      /** @var \Drupal\text\Plugin\Field\FieldType\TextItem $item */

      // This works on view preview but not on real page.
      $elements[$delta] = array(
        '#markup' => Unicode::strtoupper($item->processed)
      );

      /**
       * @todo remove this work-around,
       * @see https://drupal.org/node/2273277
       */
      drupal_render($elements[$delta], TRUE);

    }

    return $elements;
  }

}
