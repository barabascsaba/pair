<?php

namespace Drupal\pair\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Defines the 'pair_pair' field widget.
 *
 * @FieldWidget(
 *   id = "pair_pair",
 *   label = @Translation("Pair"),
 *   field_types = {"pair_pair"},
 * )
 */
class PairWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $firstValue = isset($items[$delta]->first) ? $items[$delta]->first : NULL;
    $secondValue = isset($items[$delta]->second) ? $items[$delta]->second : NULL;

    $element['first'] = [
      '#type' => 'entity_autocomplete',
      '#target_type' => 'taxonomy_term',
      '#selection_settings' => array(
          'target_bundles' => array('taxonomy_term', 'tags'),
      ),
      '#title' => $this->t('First'),
      '#default_value' => \Drupal\taxonomy\Entity\Term::load($firstValue),
      '#autocreate' => [
        'bundle' => 'tags',
      ],
    ];

    $element['second'] = [
      '#type' => 'entity_autocomplete',
      '#target_type' => 'taxonomy_term',
      '#selection_settings' => array(
          'target_bundles' => array('taxonomy_term', 'tags'),
      ),
      '#title' => $this->t('Second'),
      '#default_value' => \Drupal\taxonomy\Entity\Term::load($secondValue),
      '#autocreate' => [
        'bundle' => 'newtags',
      ],
    ];



    $element['#theme_wrappers'] = ['container', 'form_element'];
    $element['#attributes']['class'][] = 'container-inline';
    $element['#attributes']['class'][] = 'pair-pair-elements';
    $element['#attached']['library'][] = 'pair/pair_pair';

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function errorElement(array $element, ConstraintViolationInterface $violation, array $form, FormStateInterface $form_state) {
    return isset($violation->arrayPropertyPath[0]) ? $element[$violation->arrayPropertyPath[0]] : $element;
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    foreach ($values as $delta => $value) {
      if ($value['first'] === '') {
        $values[$delta]['first'] = NULL;
      }
      if ($value['second'] === '') {
        $values[$delta]['second'] = NULL;
      }
    }
    return $values;
  }

}
