<?php
/**
 * @file
 * Definition of Drupal\cssgrid\Plugin\views\style\cssgrid.
 */
namespace Drupal\cssgrid\Plugin\views\style;

use Drupal\core\form\FormStateInterface;
use Drupal\views\Plugin\views\style\StylePluginBase;

/**
 * Style plugin to render listing.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "cssgrid",
 *   title = @Translation("CSSGrid"),
 *   help = @Translation("Render a css-grid of view data."),
 *   theme = "views_view_cssgrid",
 *   display_types = { "normal" }
 * )
 *
 */
class cssgrid extends StylePluginBase {

  /**
   * {@inheritdoc}
   */
  protected $usesOptions = TRUE;
  protected $usesRowPlugin = TRUE;
  protected $usesRowClass = TRUE;

  /**
   * Set default options
   */
  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();

    $options['container_width'] = ['default' => '1536'];
    $options['column_count'] = ['default' => '4'];
    $options['column_min_width'] = ['default' => '250'];
    $options['column_gap'] = ['default' => '1'];
    $options['alignment'] = ['default' => 'horizontal'];

    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    $form['container_width'] = [
      '#type' => 'number',
      '#title' => $this->t('Max. Breite des Containers, in dem das Grid platziert wird'),
      '#default_value' => $this->options['container_width'],
      '#required' => TRUE,
      '#min' => 1,
      '#field_suffix' => 'px',
    ];
    $form['column_count'] = [
      '#type' => 'number',
      '#title' => $this->t('Number of columns'),
      '#default_value' => $this->options['column_count'],
      '#required' => TRUE,
      '#min' => 1,
    ];
    $form['column_gap'] = [
      '#type' => 'number',
      '#title' => $this->t('Column Gap'),
      '#description' => $this->t('Gap between Columns. 1rem = 16px'),
      '#default_value' => $this->options['column_gap'],
      '#field_suffix' => 'rem',
    ];

    $form['column_min_width'] = [
      '#type' => 'number',
      '#title' => $this->t('Column Min width'),
      '#description' => $this->t('The width of each column.'),
      '#default_value' => $this->options['column_min_width'],
      '#field_suffix' => 'px',
    ];

    $gap_px = $this->options['column_gap'] * 16;
    $total_gap_width = ($this->options['column_count'] - 1) * $gap_px;
    $remaining_width = $this->options['container_width'] - $total_gap_width;
    $calc_col_width = $remaining_width / $this->options['column_count'];

    $nl = "\n";
    $text = "CALCULATE IDEAL VALUES. Apply and reopen Dialogue for Changes.";
    $text .= $nl . "Container Width: " . $this->options['container_width'] . " px. ";
    $text .= "Column Count: " . $this->options['column_count'];
    $text .= $nl . "Gap between Columns: " . $this->options['column_gap'] . "rem == " . $gap_px . " px. Total Gap Width = " . $total_gap_width . " px.";
    $text .= $nl . "(Container Width - Total Gap Width) = " . $remaining_width . " px remaining width";
    $text .= $nl . "(Remaining Width / Column Count) = " . $calc_col_width . " px calculated Column Width.";

    $form['console'] = [
      '#type' => 'textarea',
      '#title' => 'Console',
      '#description' => $this->t('Calculate Column Min Width.'),
      '#default_value' => $text,
    ];

    $form['alignment'] = [
      '#type' => 'radios',
      '#title' => $this->t('Alignment'),
      '#options' => ['horizontal' => $this->t('Horizontal'), 'vertical' => $this->t('Vertical')],
      '#default_value' => $this->options['alignment'],
      '#description' => $this->t('Horizontal alignment will place items starting in the upper left and moving right. Vertical alignment will place items starting in the upper left and moving down.'),
    ];


  }
}
