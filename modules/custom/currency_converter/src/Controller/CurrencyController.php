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
      '#theme' => 'currency_converter',
      '#attached' => array(
        'library' => array(
          'currency_converter/currency_converter_libraries',
        ),
      ),
    ];
  }

}
