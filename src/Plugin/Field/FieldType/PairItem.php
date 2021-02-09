<?php

namespace Drupal\pair\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Defines the 'pair_pair' field type.
 *
 * @FieldType(
 *   id = "pair_pair",
 *   label = @Translation("Pair"),
 *   category = @Translation("General"),
 *   default_widget = "pair_pair",
 *   default_formatter = "pair_pair_default"
 * )
 */
class PairItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    if ($this->first !== NULL) {
      return FALSE;
    }
    elseif ($this->second !== NULL) {
      return FALSE;
    }
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {

    $properties['first'] = DataDefinition::create('integer')
      ->setLabel(t('First'));
    $properties['second'] = DataDefinition::create('integer')
      ->setLabel(t('Second'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints() {
    $constraints = parent::getConstraints();

    $options['first']['NotBlank'] = [];

    $options['second']['NotBlank'] = [];

    $constraint_manager = \Drupal::typedDataManager()->getValidationConstraintManager();
    $constraints[] = $constraint_manager->create('ComplexData', $options);
    // @todo Add more constraints here.
    return $constraints;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {

    $columns = [
      'first' => [
        'type' => 'int',
        'size' => 'normal',
      ],
      'second' => [
        'type' => 'int',
        'size' => 'normal',
      ],
    ];

    $schema = [
      'columns' => $columns,
      // @DCG Add indexes here if necessary.
    ];

    return $schema;
  }


}
