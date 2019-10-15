<?php

use PHPUnit\Framework\TestCase;
use App\Lib\Denomination as Denomination;
use App\Entity\Currency as Currency;

class DenominationTest extends TestCase
{
  public function testGetMessages()
  {
    $amount = 12.34;
    $aResult=Denomination::getDenominations($amount,self::getACurrency());
    $this->assertEquals(1,$aResult[0]['count']);
    $this->assertEquals(10,$aResult[0]['amount']);
    $this->assertEquals(2,$aResult[1]['count']);
    $this->assertEquals(1,$aResult[1]['amount']);
    $this->assertEquals(1,$aResult[2]['count']);
    $this->assertEquals(0.25,$aResult[2]['amount']);
    $this->assertEquals(1,$aResult[3]['count']);
    $this->assertEquals(0.05,$aResult[3]['amount']);
    $this->assertEquals(4,$aResult[4]['count']);
    $this->assertEquals(0.01,$aResult[4]['amount']);
  }

  /**
   * @return Currency[]
   */
  private static function getACurrency(): array{
    $arrCurrency = [
      ['amount' => 0.01, 'name' => 'penny', 'type' => 'coin', 'is_active' => true],
      ['amount' => 0.05, 'name' => 'nickel', 'type' => 'coin', 'is_active' => true],
      ['amount' => 0.10, 'name' => 'dime', 'type' => 'coin', 'is_active' => true],
      ['amount' => 0.25, 'name' => 'quarter', 'type' => 'coin', 'is_active' => true],
      ['amount' => 1.00, 'name' => 'One Dollar', 'type' => 'note', 'is_active' => true],
      ['amount' => 5.00, 'name' => 'Five Dollars', 'type' => 'note', 'is_active' => true],
      ['amount' => 10.00, 'name' => 'Ten Dollars', 'type' => 'note', 'is_active' => true],
      ['amount' => 20.00, 'name' => 'Twenty Dollars', 'type' => 'note', 'is_active' => true],
    ];
    $aCurrencyReturn = [];
    foreach ($arrCurrency as $amount => $aCurrency) {
      $currency = new Currency();
      $currency->setAmount($aCurrency['amount']);
      $currency->setName($aCurrency['name']);
      $currency->setType($aCurrency['type']);
      $currency->setIsActive($aCurrency['is_active']);
      $aCurrencyReturn[] = $currency;
    }
    return $aCurrencyReturn;
  }
}