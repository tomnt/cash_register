<?php


namespace App\Lib;


class Denomination
{
  /**
   * @param float $amount
   * @param App\Entity\Currency[] $aCurrency
   * @return array
   */
  public static function getDenominations(float $amount, array $aCurrency): array
  {
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