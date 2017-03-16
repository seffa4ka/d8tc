<?php

namespace Drupal\Tests\sending_messages\Unit;

/**
 * Description of MyFirstTest
 *
 * @author seffka
 */
class MyTestForm extends \PHPUnit_Framework_TestCase{

  /**
  * Check email address. 
  *
  * @param type $mail
  */
  public static function checkEmail($mail) {
    if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  /**
   * Tests function that checks email.
   *
   * @param $mail
   *
   * @dataProvider emailDataProvider
   *
   * @see MyTestForm::emailDataProvider()
   */
  public function testCheckEmail($mail, $expected) {
    $this->assertEquals($expected, MyTestForm::checkEmail($mail));
  }

  /**
   * Email Data provider.
   *
   * @return array
   *
   * @dataProvider emailDataProvider
   * 
   * @see MyTestForm::emailDataProvider()
   */
  public function emailDataProvider() {
    $data = array(
      array('email', FALSE),
      array('email@email', FALSE),
      array('email@email.casdasdasdasdasdasdsdasdasdaasdasdasdasdasdasdasdasdasdasdasdasd', FALSE),
      array('email@email.com', TRUE),
      array(2.222, FALSE),
      array(1, FALSE),
      array(TRUE, FALSE),
      array(new \stdClass(), FALSE),
    );
    return $data;
  }
}
