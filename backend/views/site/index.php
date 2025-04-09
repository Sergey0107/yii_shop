<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Панель администратора';
?>
<div class="site-index">

    <div class="body-content">

        <div class="">
            <?= Html::a('Заказы', ['order/index'], ['class' => 'btn btn-primary']) ?>
        </div>

        <div class="">
            <?= Html::a('Службы доставки', ['delivery/index'], ['class' => 'btn btn-primary']) ?>
        </div>

    </div>
</div>
