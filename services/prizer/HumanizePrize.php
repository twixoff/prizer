<?php

namespace app\services\prizer;

use app\models\WinHistory;

class HumanizePrize
{

    /**
     * @param WinHistory $prize
     * @return string
     */
    public static function getWinMessage(WinHistory $prize): string
    {
        $prizeType = "";
        $prizeAmount = "";
        switch ($prize->prize_type) {
            case 'money':
                $prizeType = "денежный приз";
                $prizeAmount = $prize->prize_amount." р.";
                break;
            case 'thing':
                $prizeType = "вещевой приз";
                $prizeAmount = $prize->prize_amount;
                break;
            case 'bonus':
                $prizeType = "бонусные баллы";
                $prizeAmount = $prize->prize_amount." бал(-ов)";
                break;
        }

        return "Поздравляем! Вы выиграли <b>$prizeType</b> - <b>« $prizeAmount »</b>";
    }

    /**
     * @return string
     */
    public static function getLoseMessage(): string
    {
        return "Вы ничего не выиграли. Попробуйте еще раз :)";
    }

}