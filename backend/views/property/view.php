<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Property $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Properties', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$this->registerCss("
    .property-view {
        background: linear-gradient(135deg, #0c0c0c 0%, #1a1a2e 100%);
        border: 1px solid #16213e;
        border-radius: 12px;
        padding: 40px;
        margin: 20px 0;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
        color: #e2e8f0;
    }

    .property-view h1 {
        color: #ffffff;
        margin-bottom: 32px;
        font-weight: 600;
        text-align: center;
        font-size: 28px;
        letter-spacing: 1px;
        text-transform: uppercase;
        border-bottom: 2px solid #2d3748;
        padding-bottom: 16px;
    }

    .cosmic-actions {
        text-align: center;
        margin: 32px 0;
        padding: 24px;
        background: rgba(16, 20, 43, 0.6);
        border-radius: 8px;
        border: 1px solid #2d3748;
    }

    .cosmic-btn {
        background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
        border: 1px solid #4a5568;
        color: #e2e8f0;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 14px;
        text-decoration: none;
        display: inline-block;
        margin: 0 8px;
    }

    .cosmic-btn:hover {
        background: linear-gradient(135deg, #4a5568 0%, #718096 100%);
        border-color: #718096;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        text-decoration: none;
    }

    .cosmic-btn:active {
        transform: translateY(0);
    }

    .cosmic-btn.btn-primary {
        background: linear-gradient(135deg, #2b6cb0 0%, #3182ce 100%);
        border-color: #3182ce;
    }

    .cosmic-btn.btn-primary:hover {
        background: linear-gradient(135deg, #3182ce 0%, #4299e1 100%);
        border-color: #4299e1;
    }

    .cosmic-btn.btn-danger {
        background: linear-gradient(135deg, #c53030 0%, #e53e3e 100%);
        border-color: #e53e3e;
    }

    .cosmic-btn.btn-danger:hover {
        background: linear-gradient(135deg, #e53e3e 0%, #f56565 100%);
        border-color: #f56565;
    }

    .detail-view {
        background: rgba(16, 20, 43, 0.8);
        border: 1px solid #2d3748;
        border-radius: 8px;
        margin: 32px 0;
        overflow: hidden;
    }

    .detail-view table {
        width: 100%;
        margin: 0;
        border-collapse: collapse;
    }

    .detail-view th {
        background: rgba(45, 55, 72, 0.8);
        color: #cbd5e0;
        padding: 16px 20px;
        text-align: left;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 14px;
        border-bottom: 1px solid #2d3748;
        width: 30%;
    }

    .detail-view td {
        padding: 16px 20px;
        color: #e2e8f0;
        border-bottom: 1px solid #2d3748;
        font-size: 16px;
    }

    .detail-view tr:last-child th,
    .detail-view tr:last-child td {
        border-bottom: none;
    }

    .detail-view tr:hover {
        background: rgba(26, 32, 64, 0.5);
    }

    .cosmic-footer-btn {
        text-align: center;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid #2d3748;
    }
");
?>

<div class="property-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="cosmic-actions">
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'cosmic-btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'cosmic-btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'detail-view'],
        'attributes' => [
            'id',
            'name',
        ],
    ]) ?>

    <div class="cosmic-footer-btn">
        <?= Html::a('Значения', ['property-value/index', 'property_id' => $model->id], ['class' => 'cosmic-btn btn-primary']) ?>
    </div>

</div>