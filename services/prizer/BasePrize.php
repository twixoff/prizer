<?php

namespace app\services\prizer;

abstract class BasePrize
{
    /**
     * @var int max count to win each of prize per user
     */
    protected $maxWinCount = 0;

    /**
     * @var int min amount for money or bonus
     */
    protected $minAmount;

    /**
     * @var int max amount for money or bonus
     */
    protected $maxAmount;

    public function getMaxWinCount(): int
    {
        return $this->maxWinCount;
    }

    /**
     * @return string random amount for for money and bonus
     * or thing from list of prize
     */
    public function getRandomAmount(): string
    {
        return rand($this->minAmount, $this->maxAmount);
    }
}