<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Country $model */

$this->title = 'Редактировать страну: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Характеристики', 'url' => ['/specification/index']];
$this->params['breadcrumbs'][] = ['label' => 'Страны', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="country-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
