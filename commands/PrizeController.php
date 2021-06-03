<?php

namespace app\commands;

use app\models\WinHistory;
use app\services\prizer\MoneyPrize;
use yii\console\Controller;
use yii\console\ExitCode;

class PrizeController extends Controller
{
    /**
     * Sending awaiting money to bank account.
     */
    public function actionSendToBank($limit = 10)
    {
        $prizes = WinHistory::find()
            ->where(['prize_type' => 'money', 'status' => 2])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit($limit)
            ->all();

        foreach ($prizes as $prize) {
            $moneyPrize = new MoneyPrize();
            $isSent = $moneyPrize->sendToBank($prize->prize_amount, 'BANK_ACCOUNT_NUMBER');
            if($isSent) {
                $prize->status = 3;
                $prize->save();

                echo "Prize ".$prize->id." (".$prize->prize_amount.") sent.".PHP_EOL;
            } else {
                echo "Smth gone wrong. Prize id: ".$prize->id.PHP_EOL;
            }
        }

        return ExitCode::OK;
    }
}
