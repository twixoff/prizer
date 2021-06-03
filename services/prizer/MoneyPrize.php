<?php

namespace app\services\prizer;

class MoneyPrize extends BasePrize
{
    protected $maxWinCount = 3;

    protected $minAmount = 100;

    protected $maxAmount = 1500;

    /**
     * @var int conver rate from money to bonus
     */
    const RATE = 1.35;

    /**
     * Convert money to point.
     */
    public function convertToBonus($amount): float
    {
        return $amount * static::RATE;
    }

    /**
     * Send money to user card or bank account.
     *
     * @amount int amount to send
     * @param $bankAccount string bank account to send money
     * @return bool
     */
    public function sendToBank($amount, $bankAccount): bool
    {
        // TODO:: sending request to bank API over HTTP
        // TODO:: using $amount and $bankAccount params

        return true;
    }
}