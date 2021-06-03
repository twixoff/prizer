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
    public function convertToBonus(): void
    {}

    /**
     * Send money to user card or bank account.
     */
    public function sendToBank(): void
    {}
}