<?php

/* @var $this yii\web\View */

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

</div>
