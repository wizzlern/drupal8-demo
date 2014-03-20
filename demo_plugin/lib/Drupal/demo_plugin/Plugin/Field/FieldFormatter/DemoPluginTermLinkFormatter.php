<?php

/**
 * @file
 * Contains \Drupal\demo_plugin\Plugin\Field\FieldFormatter\DemoPluginTermLinkFormatter.
 */

namespace Drupal\demo_plugin\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\taxonomy\Plugin\Field\FieldFormatter\LinkFormatter;

/**
 * Replacement plugin implementation for the taxonomy term link formatter.
 */
class DemoPluginTermLinkFormatter extends LinkFormatter {

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, array &$form_state) {
    $elements['limit'] = array(
      '#type' => 'number',
      '#title' => t('Max number of terms.'),
      '#default_value' => $this->getSetting('limit'),
      '#description' => t('Max number of terms to display. Set to zero for unlimited'),
    );

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = array();
    $settings = $this->getSettings();

    if (!empty($settings['limit'])) {
      $summary[] = t('Display max !limit terms.', array('!limit' => $settings['limit']));
    }
    else {
      $summary[] = t('Display all terms.');
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items) {
    // Let the parent method do the rendering.
    $elements = parent::viewElements($items);

    // If set, limit the number of terms in the output.
    $limit = $this->getSetting('limit');
    if ($limit) {
      $elements = array_slice($elements, 0, $limit);
    }

    return $elements;
  }

}
