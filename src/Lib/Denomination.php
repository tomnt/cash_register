<?php

namespace App\Lib;

class Denomination
{
  /**
   * Obtains an array of count and type of currency corresponding to given dollar amount.
   *
   * @param float $amount Amount in dollar. Example: 12.34
   * @param App\Entity\Currency[] $aCurrency Array of available Currency objects
   * @return array An array of count and currency
   *     Example;
   *         [["count":1,"amount":10,"name":"Ten Dollars","type":"note"],
   *          ["count":2,"amount":1,"name":"One Dollar","type":"note"],
   *          ...
   */
  public static function getDenominations(float $amount, array $aCurrency): array
  {
    $amount = $amount*100;
    $aCurrencySorted=[];
    foreach ($aCurrency as $currency) {
      $aCurrencySorted[$currency->getAmount()*100] =  $currency;
    }
    krsort($aCurrencySorted);
    $arrDenominations = [];
    foreach ($aCurrencySorted as $currency) {
      $currencyAmount = $currency->getAmount() * 100;
      if ($amount > $currency->getAmount()&& floor($amount/$currencyAmount)) {
        $arrDenominations[]
          = ['count'=>floor($amount/$currencyAmount)
          ,'amount'=>$currency->getAmount()
          ,'name'=>$currency->getName()
          ,'type'=>$currency->getType()
        ];
        $amount = (float)$amount % $currencyAmount;
      }
    }
    return $arrDenominations;
  }
}