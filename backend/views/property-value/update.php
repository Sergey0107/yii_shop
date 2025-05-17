<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PropertyValue $model */

$this->title = 'Update Property Value: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Property Values', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="property-value-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
