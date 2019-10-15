<?php

namespace App\DataFixtures;

use App\Entity\Currency;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
  /**
   * [Command line: Loading Fixtures]
   * php bin/console doctrine:fixtures:load
   * @param ObjectManager $manager
   */
  public function load(ObjectManager $manager)
  {
    $arrCurrency = [
       ['amount'=>0.01,'name' => 'penny', 'type' => 'coin','is_active'=>true],
       ['amount'=>0.05,'name' => 'nickel', 'type' => 'coin','is_active'=>true],
       ['amount'=>0.10,'name' => 'dime', 'type' => 'coin','is_active'=>true],
       ['amount'=>0.25,'name' => 'quarter', 'type' => 'coin','is_active'=>true],
       ['amount'=>1.00,'name' => 'One Dollar', 'type' => 'note','is_active'=>true],
       ['amount'=>5.00,'name' => 'Five Dollars', 'type' => 'note','is_active'=>true],
       ['amount'=>10.00,'name' => 'Ten Dollars', 'type' => 'note','is_active'=>true],
       ['amount'=>20.00,'name' => 'Twenty Dollars', 'type' => 'note','is_active'=>true],
       ['amount'=>100.00,'name' => 'One Hundred Dollars', 'type' => 'note','is_active'=>false]
    ];
    foreach ($arrCurrency as $amount=>$aCurrency) {
      $currency = new Currency();
      $currency ->setAmount($aCurrency['amount']);
      $currency ->setName($aCurrency['name']);
      $currency->setType($aCurrency['type']);
      $currency->setIsActive($aCurrency['is_active']);
      $manager->persist($currency);
    }
    $manager->flush();
  }
}
