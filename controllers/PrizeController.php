<?php

namespace app\controllers;

use app\models\User;
use app\models\WinHistory;
use app\services\prizer\MoneyPrize;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class PrizeController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    '*' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Send money to bank account or card
     *
     * @param $id int prize id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionSendToAccount($id)
    {
        $prizeHistory = $this->findModel($id, 'money');
        $prizeHistory->status = 2;
        $prizeHistory->updated_at = date('Y-m-d H:i:s');
        $prizeHistory->save();

        return $this->redirect(['site/index']);
    }

    /**
     * Convert money to bonus and sent to user
     *
     * @param $id int prize id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionConvertToBonus($id)
    {
        $prizeHistory = $this->findModel($id, 'money');

        $prize = new MoneyPrize();
        $bonus = $prize->convertToBonus($prizeHistory->prize_amount);

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $user = User::findOne($prizeHistory->user_id);
            $user->bonus += $bonus;
            $user->save();

            $prizeHistory->status = 4;
            $prizeHistory->updated_at = date('Y-m-d H:i:s');
            $prizeHistory->save();

            $transaction->commit();
        } catch (\Exception $e) {
            throw new \Exception('Saving error. '.$e->getMessage());

            $transaction->rollBack();
        }

        return $this->redirect(['site/index']);
    }

    /**
     * Send bonus to user account
     *
     * @param $id int prize id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionSendToUser($id)
    {
        $prizeHistory = $this->findModel($id, 'bonus');

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $user = User::findOne($prizeHistory->user_id);
            $user->bonus += $prizeHistory->prize_amount;
            $user->save();

            $prizeHistory->status = 5;
            $prizeHistory->updated_at = date('Y-m-d H:i:s');
            $prizeHistory->save();

            $transaction->commit();
        } catch (\Exception $e) {
            throw new \Exception('Saving error. '.$e->getMessage());

            $transaction->rollBack();
        }

        return $this->redirect(['site/index']);
    }

    /**
     * Send thing over post
     *
     * @param $id int prize id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionSendToPost($id)
    {
        $prizeHistory = $this->findModel($id, 'thing');
        $prizeHistory->status = 6;
        $prizeHistory->updated_at = date('Y-m-d H:i:s');
        $prizeHistory->save();

        return $this->redirect(['site/index']);
    }

    /**
     * Decline prize
     *
     * @param $id int prize id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDecline($id)
    {
        $prizeHistory = $this->findModel($id, 'thing');
        $prizeHistory->status = 1;
        $prizeHistory->updated_at = date('Y-m-d H:i:s');
        $prizeHistory->save();

        return $this->redirect(['site/index']);
    }

    protected function findModel($id, $prizeType)
    {
        if (($model = WinHistory::findOne(['id' => $id, 'prize_type' => $prizeType])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
