<?php

namespace Drupal\Tests\sending_messages\Unit;

/**
 * Description of MyFirstTest.
 *
 * @author seffka
 */
class MyTestForm extends \PHPUnit_Framework_TestCase {

  /**
   * Check email subject.
   *
   * @param mixed $subject
   *   Actual value.
   */
  public static function checkSubject($subject) {
    if (is_string($subject)) {
      if (strlen($subject) < 64) {
        return TRUE;
      }
    }

    return FALSE;
  }

  /**
   * Check email subject.
   *
   * @param mixed $mail
   *   Actual value.
   */
  public static function checkEmail($mail) {

    if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
      return TRUE;
    }

    return FALSE;
  }

  /**
   * Tests function that checks subject.
   *
   * @param mixed $subject
   *   Actual value.
   * @param bool $expected
   *   Expected value.
   *
   * @dataProvider subjectDataProvider
   *
   * @see MyTestForm::subjectDataProvider()
   */
  public function testSubject($subject, $expected) {
    $this->assertEquals($expected, MyTestForm::checkSubject($subject));
  }

  /**
   * Tests function that checks email.
   *
   * @param mixed $mail
   *   Actual value.
   * @param bool $expected
   *   Expected value.
   *
   * @dataProvider emailDataProvider
   *
   * @see MyTestForm::emailDataProvider()
   */
  public function testCheckEmail($mail, $expected) {
    $this->assertEquals($expected, MyTestForm::checkEmail($mail));
  }

  /**
   * Subject Data provider.
   *
   * @return array
   *   Actual and expected value.
   *
   * @dataProvider subjectDataProvider
   *
   * @see MyTestForm::subjectDataProvider()
   */
  public function subjectDataProvider() {
    $data = array(
      array('subjectsubjectsubjectsubjectsubjectsubjectsubjectsubjectsubjectsubject', FALSE),
      array('subject', TRUE),
      array(2.222, FALSE),
      array(1, FALSE),
      array(TRUE, FALSE),
      array(new \stdClass(), FALSE),
    );
    return $data;
  }

  /**
   * Email Data provider.
   *
   * @return array
   *   Actual and expected value.
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
