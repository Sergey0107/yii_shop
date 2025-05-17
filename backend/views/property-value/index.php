<?php

use backend\models\PropertyValue;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\PropertyValueSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var int $property_id */


$this->title = 'Значения характеристики';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-value-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить значение', ['create', 'property_id' => $property_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'value',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, PropertyValue $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
