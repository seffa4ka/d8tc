<?php

namespace Drupal\currency_converter\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class CurrencyController.
 *
 * @package Drupal\currency_converter\Controller
 */
class CurrencyController extends ControllerBase {

  /**
   * Index.
   *
   * @return string
   *   Return Hello string.
   */
  public function index() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: index')
    ];
  }

}
