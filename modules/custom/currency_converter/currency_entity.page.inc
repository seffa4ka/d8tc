<?php

/**
 * @file
 * Contains currency_entity.page.inc.
 *
 * Page callback for Currency entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Currency entity templates.
 *
 * Default template: currency_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_currency_entity(array &$variables) {
  // Fetch CurrencyEntity Entity Object.
  $currency_entity = $variables['elements']['#currency_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
