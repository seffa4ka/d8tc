<?php

namespace Drupal\note\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class NoteController.
 *
 * @package Drupal\note\Controller
 */
class NoteController extends ControllerBase {

  /**
   * Index.
   *
   * @return string
   *   Return Hello string.
   */
  public function index() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Hello!'),
    ];
  }

}
