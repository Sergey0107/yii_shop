<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\PropertyValue $model */

$this->title = $model->value;
$this->params['breadcrumbs'][] = ['label' => 'Характеристики', 'url' => ['property/index']];
$this->params['breadcrumbs'][] = ['label' => 'Значения характеристики', 'url' => ['index', 'property_id' => $model->property_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="property-value-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'property_id',
            'value',
        ],
    ]) ?>

</div>
