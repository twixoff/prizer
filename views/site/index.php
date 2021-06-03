<?php

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $searchModel \app\models\WinHistorySearch */

use yii\grid\GridView;
use yii\bootstrap\Html;
use app\services\prizer\HumanizePrize;

$this->title = 'Prizer';
?>

<div class="text-center">

    <div class="jumbotron">
        <?php if(Yii::$app->session->hasFlash('prize-success')) : ?>
            <?php $prize = Yii::$app->session->getFlash('prize-success'); ?>
            <div class="alert alert-success"><?= HumanizePrize::getWinMessage($prize) ?></div>
        <?php elseif(Yii::$app->session->hasFlash('prize-fail')) : ?>
            <?php $message = Yii::$app->session->getFlash('prize-fail'); ?>
            <div class="alert alert-danger">
                <?= HumanizePrize::getLoseMessage() ?></div>
        <?php endif; ?>

        <?= Html::beginForm(['site/get-prize'], 'post') ?>
            <?= Html::submitButton('Получить приз', ['class' => 'btn btn-success']) ?>
        <?= Html::endForm() ?>
    </div>

</div>

<div class="prize-history">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'layout' => "{items}\n{summary}\n{pager}",
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['class' => 'text-center', 'style' => 'width: 60px;'],
                'contentOptions' => ['class' => 'text-center']
            ],

            [
                'label' => 'Тип приза',
                'value' => 'prizeTypeName',
            ],
            [
                'label' => 'Размер приза / Вещь',
                'value' => 'prize_amount',
            ],
            [
                'attribute' => 'status',
                'label' => 'Статус',
                'value' => function($model) {
                    return "<span class='label label-info'>".$model->statusName."</span>";
                },
                'format' => 'html',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center']
            ],
            'created_at:datetime:Дата',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        if($model->status !== 0) {
                            return '';
                        }

                        if($model->prize_type == 'money') {
                            return Html::a('Вывести на карту', ['prize/send-to-account', 'id' => $model->id],
                                ['class' => 'btn btn-xs btn-default',
                                'data-method' => 'post',
                                'data-confirm' => "Зачисление денежных средств в течении 24 часов.\n"
                                    ."ps. Отправка в банк через консульную команду prize/send-to-bank."
                            ]) . "\n" . Html::a('Конвертировать в бонусы', ['prize/convert-to-bonus', 'id' => $model->id],
                                ['class' => 'btn btn-xs btn-default',
                                    'data-method' => 'post',
                                    'data-confirm' => "Конвертация в бонусы и перевод на счет пользователя."
                                ]);
                        }
                        if($model->prize_type == 'bonus') {
                            return Html::a('Отправить в ЛК', ['prize/send-to-user', 'id' => $model->id], [
                                'class' => 'btn btn-xs btn-default',
                                'data-method' => 'post',
                                'data-confirm' => "Уверены?"
                            ]);
                        }
                        if($model->prize_type == 'thing') {
                            return Html::a('Отправить почтой', ['prize/send-to-post', 'id' => $model->id], [
                                'class' => 'btn btn-xs btn-default',
                                'data-method' => 'post',
                                'data-confirm' => "Точно? Может не дойти."
                            ]);
                        }
                    },
                ]
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{decline}',
                'contentOptions' => ['class' => 'text-center'],
                'buttons' => [
                    'decline' => function ($url, $model, $key) {
                        if($model->status !== 0) {
                            return '';
                        }

                        return Html::a('отказ', ['prize/decline', 'id' => $model->id], [
                                'class' => 'btn btn-xs btn-danger',
                                'data-method' => 'post',
                                'data-confirm' => "вы действительно желаете отказаться от приза?"
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
