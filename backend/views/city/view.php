<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\City $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Города', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

// Добавляем CSS стили для темной темы
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
    
    .dark-theme h1 {
        color: #f8f9fa;
    }
    
    .dark-theme .breadcrumb {
        background-color: #495057;
    }
    
    .dark-theme .breadcrumb-item.active {
        color: #adb5bd;
    }
    
    .dark-theme .breadcrumb-item a {
        color: #dee2e6;
    }
CSS
);
?>

<div class="city-view dark-theme">

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
        'options' => ['class' => 'table table-striped table-bordered detail-view'],
        'attributes' => [
            'id',
            'name',
            'city_code',
        ],
    ]) ?>

</div>