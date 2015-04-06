<?php

/**
 * @file
 * Contains \Drupal\demo_plugin\Plugin\Field\FieldFormatter\DemoPluginUppercaseFormatter.
 */

namespace Drupal\demo_plugin\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\SafeMarkup;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Component\Utility\Unicode;


/**
 * Plugin implementation of the 'demo Uppercase' formatter.
 *
 * @FieldFormatter(
 *   id = "demo_plugin_uppercase",
 *   label = @Translation("Uppercase"),
 *   field_types = {
 *     "string",
 *     "string_long",
 *   },
 *   quickedit = {
 *     "editor" = "plain_text"
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
      
      $elements[$delta] = array('#markup' => nl2br(Unicode::strtoupper(SafeMarkup::checkPlain($item->value))));
    }

    return $elements;
  }

}
