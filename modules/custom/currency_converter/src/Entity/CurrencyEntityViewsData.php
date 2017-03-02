<?php

namespace Drupal\currency_converter\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Currency entity entities.
 */
class CurrencyEntityViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
