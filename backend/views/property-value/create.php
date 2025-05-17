<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\PropertyValue $model */
/** @var int $property_id */

$this->title = 'Добавить значение';
$this->params['breadcrumbs'][] = ['label' => 'Значения характеристики', 'url' => ['index', 'property_id' => $property_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-value-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'property_id' => $property_id,
    ]) ?>

</div>
