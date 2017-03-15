<?php

namespace Drupal\Tests\sending_messages\Unit;

/**
 * Description of MyFirstTest
 *
 * @author seffka
 */
class MyFirstTest extends \PHPUnit_Framework_TestCase{
  /**
   * Test.
   *
   * @return array[]
   *   Test array.
   */
  public function provideTest() {
    $allData = [];
    for ($i = 0; $i < 10; $i++) {
      $allData[] = [1];
    }
    return $allData;
  }

  /**
   * @dataProvider provideTest
   */
  public function testTest($data) {
    $this->assertEquals(1, $data);
  }
}
