<?php

namespace App\Lib;

class CurrencyValidator
{
  /**
   * Validate given string value as a currency value.
   * @param string $sCurrencyValue A string value to validate.
   * @return float validated currency value
   *     Example: 87.66
   * @throws \Exception Throws an exception if the given currency value is not numeric or exceeds supported precision.
   */
  public static function validate(string $sCurrencyValue): float
  {
    $aNodeCurrencyValue = explode('.', $sCurrencyValue);
    if (isset($aNodeCurrencyValue[1])) {
      $sAfterDecimalPoint = $aNodeCurrencyValue[1];
    } else {
      $sAfterDecimalPoint = '0';
    }
    if (!is_numeric($sCurrencyValue)) {
      throw new \Exception('Given string value, ' . $sCurrencyValue . ' is not numeric');
    } elseif (strlen($sAfterDecimalPoint) > 2) {
      throw new \Exception('Precision for the given value, ' . $sCurrencyValue . ' is supported.');
    } else {
      return (float)$sCurrencyValue;
    }
  }

}