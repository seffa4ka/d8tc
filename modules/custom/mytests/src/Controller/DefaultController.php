<?php

namespace Drupal\mytests\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class DefaultController.
 *
 * @package Drupal\mytests\Controller
 */
class DefaultController extends ControllerBase {

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
