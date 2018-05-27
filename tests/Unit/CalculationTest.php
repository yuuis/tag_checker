<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\Request;

// 実行コマンド
// sudo vendor/bin/phpunit ./tests/Unit/CalculationTest.php

class CalculationTest extends TestCase {

    /**
     * @dataProvider plusProvider
     * @param unknown $foumula
     * @param unknown $field
     * @param unknown $expect
     */
  public function testPlus($foumula, $field, $expect) {
      $calc = new \App\Http\Logic\Calc\CalcLogic();
      $result = $calc->calculateRun($foumula, $field);
      $this->assertTrue($result == $expect);
  }
  public function plusProvider() {
      static $testCasesPlus = [
          ["foumula" => "2+", "filed" => 3, "expect" => 5],
          ["foumula" => "0.2+", "filed" => 0.3, "expect" => 0.5],
          ["foumula" => "0+", "filed" => 0, "expect" => 0],
          ["foumula" => "0+", "filed" => 5, "expect" => 5],
          ["foumula" => "1000000000+", "filed" => 1000000000, "expect" => 2000000000],
          ["foumula" => "9999999999+", "filed" => 1, "expect" => "表現できる桁数を超えました"],
          ["foumula" => "999999.999+", "filed" => 0.1, "expect" => "表現できる桁数を超えました"],
          ["foumula" => "0.001+", "filed" => 0.0005, "expect" => 0.002]
      ];
      return $testCasesPlus;
  }

  /**
   * @dataProvider minusProvider
   * @param unknown $foumula
   * @param unknown $field
   * @param unknown $expect
   */
  public function testMinus($foumula, $field, $expect) {
      $calc = new \App\Http\Logic\Calc\CalcLogic();
      $result = $calc->calculateRun($foumula, $field);
      $this->assertTrue($result == $expect);
  }
  public function minusProvider() {
      static $testCasesMinus = [
          ["foumula" => "6-", "filed" => 2, "expect" => 4],
          ["foumula" => "0.6-", "filed" => 0.2, "expect" => 0.4],
          ["foumula" => "0-", "filed" => 0, "expect" => 0],
          ["foumula" => "0-", "filed" => 5, "expect" => -5],
          ["foumula" => "1100000000-", "filed" => 100000000, "expect" => 1000000000],
          ["foumula" => "1-", "filed" => 9999999999, "expect" => "表現できる桁数を超えました"],
          ["foumula" => "9999999-", "filed" => 0.001, "expect" => "表現できる桁数を超えました"],
          ["foumula" => "0.001-", "filed" => 0.0005, "expect" => 0.001]
      ];
      return $testCasesMinus;
  }

  /**
   * @dataProvider multiplyProvider
   * @param unknown $foumula
   * @param unknown $field
   * @param unknown $expect
   */
  public function testMultiply($foumula, $field, $expect) {
      $calc = new \App\Http\Logic\Calc\CalcLogic();
      $result = $calc->calculateRun($foumula, $field);
      $this->assertTrue($result == $expect);
  }
  public function multiplyProvider() {
      static $testCasesMultiply = [
          ["foumula" => "3*", "filed" => 5, "expect" => 15],
          ["foumula" => "0.2*", "filed" => 0.4, "expect" => 0.08],
          ["foumula" => "0*", "filed" => 0, "expect" => 0],
          ["foumula" => "0*", "filed" => 5, "expect" => 0],
          ["foumula" => "100000*", "filed" => 10000, "expect" => 1000000000],
          ["foumula" => "999999*", "filed" => 99999, "expect" => "表現できる桁数を超えました"],
          ["foumula" => "99999.9*", "filed" => 99999, "expect" => "表現できる桁数を超えました"],
          ["foumula" => "0.04*", "filed" => 0.03, "expect" => 0.001]
      ];
      return $testCasesMultiply;
  }

  /**
   * @dataProvider divisionProvider
   * @param unknown $foumula
   * @param unknown $field
   * @param unknown $expect
   */
  public function testDivision($foumula, $field, $expect) {
      $calc = new \App\Http\Logic\Calc\CalcLogic();
      $result = $calc->calculateRun($foumula, $field);
      $this->assertTrue($result == $expect);
  }
  public function divisionProvider() {
      static $testCasesDivision = [
          ["foumula" => "8/", "filed" => 2, "expect" => 4],
          ["foumula" => "0.3/", "filed" => 0.5, "expect" => 0.6],
          ["foumula" => "0/", "filed" => 0, "expect" => 0],
          ["foumula" => "0/", "filed" => 5, "expect" => 0],
          ["foumula" => "10000000000/", "filed" => 10, "expect" => 1000000000],
          ["foumula" => "999999999999/", "filed" => 9, "expect" => "表現できる桁数を超えました"],
          ["foumula" => "99999999999/", "filed" => 9.9, "expect" => "表現できる桁数を超えました"],
          ["foumula" => "1/", "filed" => 0, "expect" => "0で割ることはできません"]
      ];
      return $testCasesDivision;
  }
}

