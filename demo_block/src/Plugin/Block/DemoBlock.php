<?php

/**
 * @file
 * Contains \Drupal\demo_block\Plugin\Block\DemoBlock.
 */

namespace Drupal\demo_block\Plugin\Block;

use Drupal\block\Annotation\Block;
use Drupal\block\BlockBase;
use Drupal\Core\Annotation\Translation;
use Drupal\Core\Form\FormStateInterface;


/**
 * Provides a 'Example: configurable text string' block.
 *
 * @Block(
 *   id = "demo_block",
 *   subject = @Translation("Demo"),
 *   admin_label = @Translation("Demo Block")
 * )
 */
class DemoBlock extends BlockBase {

  /**
   * Overrides \Drupal\block\BlockBase::defaultConfiguration().
   */
  public function defaultConfiguration() {
    return array(
      'label' => t('Demo'),
      'content' => t('Default demo content'),
      'cache' => array(
        'max_age' => 3600,
        'contexts' => array(
          'cache_context.user.roles',
        ),
      ),
    );
  }

  /**
   * Overrides \Drupal\block\BlockBase::blockForm().
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['content'] = array(
      '#type' => 'textfield',
      '#title' => t('Block contents'),
      '#size' => 60,
      '#description' => t('This text will appear in the demo block.'),
      '#default_value' => $this->configuration['content'],
    );
    return $form;
  }

  /**
   * Overrides \Drupal\block\BlockBase::blockSubmit().
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['content'] = $form_state->getValue('content');
  }

  /**
   * Implements \Drupal\block\BlockBase::blockBuild().
   */
  public function build() {
    return array(
      '#markup' => $this->configuration['content'],
    );
  }

}
