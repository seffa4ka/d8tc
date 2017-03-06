<?php

namespace Drupal\currency_converter;

/**
 * Description of CurrencyConverterLoader.
 *
 * @author seffka
 */
class CurrencyConverterLoader {
  private $currencyKey;
  private $currencyAll;

  /**
   * When creating fills class variables $currencyKey and $currencyAll.
   */
  public function __construct() {
    $ids = \Drupal::entityQuery('currency_entity')
      ->execute();
    $nodes = \Drupal::entityTypeManager()->getStorage('currency_entity')->loadMultiple($ids);
    $currencyAll = array();
    $beforeValue = NULL;
    foreach ($ids as $id) {
      $nowValue = $nodes[$id]->field_source_currency_code->value;
      $dest = $nodes[$id]->field_destination_currency_code->value;
      $value = $nodes[$id]->field_source_currency_value->value;
      if ($nowValue !== $beforeValue) {
        $currencyAll[$nowValue] = array();
        $currencyAll[$nowValue][$dest] = $value;
        $beforeValue = $nowValue;
      }
      else {
        $currencyAll[$nowValue][$dest] = $value;
      }
    }
    $currencyKey = array_keys($currencyAll);
    $this->currencyKey = $currencyKey;
    $this->currencyAll = $currencyAll;
  }

  /**
   * Function return currencies keys.
   *
   * @return array
   *   currencies keys.
   */
  public function getCurrenciesKeys() {
    return $this->currencyKey;
  }

  /**
   * Function return currencies values.
   *
   * @return array
   *   currencies values.
   */
  public function getCurrenciesValues() {
    return $this->currencyAll;
  }

}
