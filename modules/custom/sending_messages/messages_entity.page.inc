<?php

/**
 * @file
 * Contains messages_entity.page.inc.
 *
 * Page callback for Messages entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Messages entity templates.
 *
 * Default template: messages_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_messages_entity(array &$variables) {
  // Fetch MessagesEntity Entity Object.
  $messages_entity = $variables['elements']['#messages_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
