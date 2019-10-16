<?php

use PHPUnit\Framework\TestCase;
use App\Lib\CurrencyValidator as CurrencyValidator;

class CurrencyValidatorTest extends TestCase
{

  function testValidate()
  {
    $this->assertEquals(12.34, CurrencyValidator::validate('12.34'));
    try {
      CurrencyValidator::validate('12.345');
    } catch (Exception $e) {
      $this->assertEquals('Precision for the given value, 12.345 is supported.', $e->getMessage());
    }
    try {
      CurrencyValidator::validate('ABC');
    } catch (Exception $e) {
      $this->assertEquals('Given string value, ABC is not numeric', $e->getMessage());
    }
  }

}