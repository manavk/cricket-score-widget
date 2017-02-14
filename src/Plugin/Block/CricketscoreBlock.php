<?php

namespace Drupal\cricket_score_widget\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Cricket Score Widget' block.
 *
 * @Block(
 *   id = "cricket_score_widget_block",
 *   admin_label = @Translation("Cricket score block")
 * )
 */
class CricketscoreBlock extends BlockBase implements BlockPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();

    $width = $config['width'];
    $width = $config['height'];
    $result = array(
      '#markup' =>'<object height="300px" width="300px"><param value="http://static.cricinfo.com/db/SUPPORT/ADVERTS/TESTING/WIDGETS/stat_cric/300x250_APR/liveScores.swf" name="movie"><embed height="300px" width="300px" src="http://static.cricinfo.com/db/SUPPORT/ADVERTS/TESTING/WIDGETS/stat_cric/300x250_APR/liveScores.swf"></object>',
      '#allowed_tags' => ['object', 'param', 'embed'],
      );
    return $result;
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['height'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Height'),
      '#size' => 4,
      '#description' => $this->t('Height of the Widget in Pixel. Minimum value is 175'),
      '#default_value' => isset($config['height']) ? $config['height'] : '250',
    );

    $form['width'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Width'),
      '#size' => 4,
      '#description' => $this->t('Width of the Widget in Pixel. Minimum value is 210'),
      '#default_value' => isset($config['width']) ? $config['width'] : '300',
    );

    return $form;
  }


  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $width = intval($form_state->getValue('width'));
    $height = intval($form_state->getValue('height'));
    if ($width < 210) {
      $width = 210;
    }
    if ($height < 175) {
      $height = 175;
    }
    $this->configuration['width'] = $width;
    $this->configuration['height'] = $height;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    $default_config = \Drupal::config('cricket_score_widget.settings');
    return array(
      'width' => $default_config->get('cricketscore.width'),
      'height' => $default_config->get('cricketscore.height'),
    );
  }
}
