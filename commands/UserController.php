<?php

namespace app\commands;

use app\models\User;
use yii\console\Controller;
use yii\console\ExitCode;

class UserController extends Controller
{
    /**
     * Create new user.
     */
    public function actionCreate($username, $password)
    {
        $user = new User();
        $user->username = $username;
        $user->setPassword($password);
        $user->setAuthKey();
        if(!$user->save()) {
            print_r($user->getErrors()).PHP_EOL;
        } else {
            echo "User created.".PHP_EOL;
        }

        return ExitCode::OK;
    }
}
