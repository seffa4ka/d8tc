<?php

namespace Drupal\currency_converter\Controller;

use Drupal\Core\Controller\ControllerBase;
use \Drupal\currency_converter\CurrencyConverterLoader;

/**
 * Class CurrencyController.
 *
 * @package Drupal\currency_converter\Controller
 */
class CurrencyController extends ControllerBase {

  /**
   * Currency Controller page.
   *
   * @return string
   *   Return form.
   */
  public function index() {
    $currencies = new CurrencyConverterLoader();
    return [
      '#theme' => 'currency_converter',
      '#currencies' => $currencies->getCurrenciesKeys(),
      '#attached' => array(
        'library' => array(
          'currency_converter/currency_converter_libraries',
        ),
        'drupalSettings' => array(
          'currencies' => $currencies->getCurrenciesValues(),
        ),
      ),
    ];
  }

}
