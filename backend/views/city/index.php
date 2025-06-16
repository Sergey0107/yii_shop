<?php

use backend\models\City;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\CitySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Города';
$this->params['breadcrumbs'][] = $this->title;

// Добавляем CSS стили
$this->registerCss(<<<CSS
    .dark-theme {
        background-color: #343a40;
        color: #f8f9fa;
    }
    
    .dark-theme .table {
        background-color: #343a40;
        color: #f8f9fa;
        border-color: #454d55;
    }
    
    .dark-theme .table th {
        background-color: #495057;
        color: #ffffff;
        border-color: #454d55;
    }
    
    .dark-theme .table td {
        background-color: #343a40;
        color: #f8f9fa;
        border-color: #454d55;
    }
    
    .dark-theme .table-striped tbody tr:nth-of-type(odd) {
        background-color: #3d444b;
    }
    
    .dark-theme .table-hover tbody tr:hover {
        background-color: #495057;
        color: #ffffff;
    }
    
    .dark-theme .pagination .page-item.active .page-link {
        background-color: #495057;
        border-color: #495057;
    }
    
    .dark-theme .pagination .page-link {
        background-color: #343a40;
        color: #f8f9fa;
        border-color: #454d55;
    }
    
    .dark-theme .pagination .page-link:hover {
        background-color: #495057;
        color: #ffffff;
    }
CSS
);
?>

<div class="city-index dark-theme">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить город', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['class' => 'grid-view dark-theme'],
        'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'city_code',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, City $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'contentOptions' => ['class' => 'action-column'],
            ],
        ],
    ]); ?>

</div>