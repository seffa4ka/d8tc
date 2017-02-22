<?php

namespace Drupal\internet_reception\Controller;

use Drupal\Core\Controller\ControllerBase;

class InternetReceptionController extends ControllerBase {

  public function helloWorld() {
    $output = array();

    $output['#title'] = 'HelloWorld page title';

    $output['#markup'] = 'Hello World!';

    return $output;
  }

}
