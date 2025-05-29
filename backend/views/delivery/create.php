<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Delivery $model */

$this->title = 'Добавить службу доставки';
$this->params['breadcrumbs'][] = ['label' => 'Службы доставки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
