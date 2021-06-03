<?php

namespace tests\unit\models;

use app\services\prizer\MoneyPrize;

class MoneyPrizeConvertTest extends \Codeception\Test\Unit
{
    public function testConvert()
    {
        $prize = new MoneyPrize();
        for($i = 0; $i < 1000; $i++) {
            $bonus = $prize->convertToBonus($i);
            verify($bonus)->equals($i * MoneyPrize::RATE);
        }
    }

}
