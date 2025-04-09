<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Color $model */

$this->title = 'Редактировать цвет: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Характеристики', 'url' => ['/specification/index']];
$this->params['breadcrumbs'][] = ['label' => 'Цвета', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="color-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
