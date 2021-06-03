<?php

namespace app\services\prizer;

class BonusPrize extends BasePrize
{
    protected $minAmount = 1000;

    protected $maxAmount = 5000;

    /**
     * Send to user account.
     */
    public function sendToAccount(): void
    {}
}