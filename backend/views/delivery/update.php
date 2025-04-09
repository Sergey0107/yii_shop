<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Delivery $model */

$this->title = 'Редактировать СД: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Deliveries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="delivery-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
