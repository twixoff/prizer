<?php

namespace app\services\prizer;

class ThingPrize extends BasePrize
{
    /**
     * @var int
     */
    protected $maxWinCount = 2;

    /**
     * @var string[] list of thing prizes
     */
    private $things = ['car', 't-shirt', 'cup', 'hat'];

    /**
     * Get random thing from $things list.
     *
     * @return string
     */
    public function getRandomAmount(): string
    {
        return $this->things[array_rand($this->things)];
    }

    /**
     * Send money to user card or bank account.
     */
    public function sendToPost(): void
    {}
}