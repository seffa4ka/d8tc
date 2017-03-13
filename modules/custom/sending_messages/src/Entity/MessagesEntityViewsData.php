<?php

namespace Drupal\sending_messages\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Messages entity entities.
 */
class MessagesEntityViewsData extends EntityViewsData {

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
