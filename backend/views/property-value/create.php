<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PropertyValue $model */

$this->title = 'Create Property Value';
$this->params['breadcrumbs'][] = ['label' => 'Property Values', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-value-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
