<?php

namespace Drupal\pair\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'pair_pair_default' formatter.
 *
 * @FieldFormatter(
 *   id = "pair_pair_default",
 *   label = @Translation("Default"),
 *   field_types = {"pair_pair"}
 * )
 */
class PairDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];

    foreach ($items as $delta => $item) {

      if ($item->first) {
        $element[$delta]['first'] = [
          '#type' => 'item',
          '#title' => $this->t('First'),
          '#markup' => $item->first,
        ];
      }

      if ($item->second) {
        $element[$delta]['second'] = [
          '#type' => 'item',
          '#title' => $this->t('Second'),
          '#markup' => $item->second,
        ];
      }

    }

    return $element;
  }

}
