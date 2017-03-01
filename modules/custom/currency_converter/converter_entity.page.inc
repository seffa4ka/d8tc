<?php

/**
 * @file
 * Contains converter_entity.page.inc.
 *
 * Page callback for Converter entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Converter entity templates.
 *
 * Default template: converter_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_converter_entity(array &$variables) {
  // Fetch ConverterEntity Entity Object.
  $converter_entity = $variables['elements']['#converter_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
