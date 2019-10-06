<?php

namespace Drupal\disclaimer\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceFormatterBase;

/**
 * Plugin implementation of the 'disclaimer' formatter.
 *
 * @FieldFormatter(
 *   id = "disclaimer",
 *   label = @Translation("Disclaimer"),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class DisclaimerFormatter extends EntityReferenceFormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    try {
      /** @var \Drupal\Core\Field\EntityReferenceFieldItemListInterface $items */
      foreach ($this->getEntitiesToView($items, $langcode) as $delta => $entity) {
        $disclaimer[$delta] = [
          'nodeId' => $items->getEntity()->id(),
          'disclaimerTitle' => $entity->get('title')->value,
          'disclaimerBody' => $entity->get('body')->value,
        ];
      }
    }
    catch (\InvalidArgumentException $e) {
      return $elements;
    }

    if (!empty($disclaimer)) {
      $elements['#attached']['drupalSettings']['disclaimer'] = $disclaimer;
      $elements['#attached']['library'][] = 'disclaimer/disclaimer';
    }

    return $elements;
  }

}
