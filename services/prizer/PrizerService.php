<?php

namespace app\services\prizer;

use app\models\WinHistory;

class PrizerService
{
    /**
     * @var int
     */
    private $userId;

    /**
     * @var string
     */
    private $prizeType;

    /**
     * @var string
     */
    private $prizeAmount;

    /**
     * @var int
     */
    private $maxWinCount;

    public function __construct($userId)
    {
        $this->userId = $userId;
        $this->setRandomType();
    }

    /**
     * Set current random prize type and amount.
     *
     * @throws \Exception
     */
    public function setRandomType(): void
    {
        $prizeTypes = ['money', 'bonus', 'thing'];
        $this->prizeType = $prizeTypes[array_rand($prizeTypes)];

        $prize = PrizeFactory::factory($this->prizeType);
        $this->maxWinCount = $prize->getMaxWinCount();
        $this->prizeAmount = $prize->getRandomAmount();
    }

    /**
     * Get prize for user.
     *
     * @return WinHistory
     * @throws \Exception
     */
    public function getPrize(): WinHistory
    {
        $this->isCanWin();

        $prize = new WinHistory();
        $prize->user_id = $this->userId;
        $prize->prize_type = $this->prizeType;
        $prize->prize_amount = $this->prizeAmount;
        if(!$prize->save()) {
            throw new \Exception('Saving error. '.print_r($prize->getErrors(), true));
        }

        return $prize;
    }

    /**
     * Check max count prize.
     *
     * @return bool
     * @throws \Exception
     */
    public function isCanWin(): bool
    {
        if($this->maxWinCount > 0) {
            $winCount = WinHistory::find()
                ->where(['user_id' => $this->userId, 'prize_type' => $this->prizeType])->count();
            if($winCount >= $this->maxWinCount) {
                throw new \Exception('Maximum number of prizes ('.$this->prizeType.') reached. Try again.');
            }
        }

        return true;
    }

}