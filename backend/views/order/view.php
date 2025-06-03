<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Order $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<style>
    .cosmic-container {
        background: linear-gradient(135deg, #0c0c1e 0%, #1a1a3a 50%, #2d1b69 100%);
        min-height: 100vh;
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }

    .cosmic-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background:
                radial-gradient(circle at 20% 20%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 119, 198, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.1) 0%, transparent 50%);
        pointer-events: none;
    }

    .cosmic-stars {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
    }

    .star {
        position: absolute;
        background: white;
        border-radius: 50%;
        animation: twinkle 4s infinite;
    }

    .star:nth-child(1) { top: 10%; left: 20%; width: 2px; height: 2px; animation-delay: 0s; }
    .star:nth-child(2) { top: 20%; left: 80%; width: 1px; height: 1px; animation-delay: 1s; }
    .star:nth-child(3) { top: 80%; left: 10%; width: 3px; height: 3px; animation-delay: 2s; }
    .star:nth-child(4) { top: 40%; left: 90%; width: 2px; height: 2px; animation-delay: 3s; }
    .star:nth-child(5) { top: 70%; left: 50%; width: 1px; height: 1px; animation-delay: 0.5s; }

    @keyframes twinkle {
        0%, 100% { opacity: 0.3; }
        50% { opacity: 1; }
    }

    .cosmic-header {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        z-index: 1;
    }

    .cosmic-title {
        color: #fff;
        font-size: 2rem;
        font-weight: 600;
        margin: 0;
        text-align: center;
        background: linear-gradient(45deg, #7c77c6, #ff77c6, #77dbff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: none;
    }

    .cosmic-subtitle {
        color: rgba(255, 255, 255, 0.8);
        text-align: center;
        margin-top: 0.5rem;
        font-size: 1.1rem;
    }

    .cosmic-actions {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin: 2rem 0;
        position: relative;
        z-index: 1;
    }

    .cosmic-btn {
        padding: 12px 30px;
        border: none;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.9rem;
    }

    .cosmic-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .cosmic-btn:hover::before {
        left: 100%;
    }

    .cosmic-btn-primary {
        background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
    }

    .cosmic-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .cosmic-btn-danger {
        background: linear-gradient(45deg, #ff6b6b 0%, #ee5a24 100%);
        color: white;
        box-shadow: 0 8px 32px rgba(255, 107, 107, 0.3);
    }

    .cosmic-btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(255, 107, 107, 0.4);
        color: white;
    }

    .cosmic-detail-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 2rem;
        position: relative;
        z-index: 1;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .cosmic-detail-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .cosmic-detail-table th {
        background: rgba(255, 255, 255, 0.1);
        color: #7c77c6;
        padding: 1rem 1.5rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.9rem;
        border: none;
        width: 30%;
    }

    .cosmic-detail-table td {
        background: rgba(255, 255, 255, 0.05);
        color: rgba(255, 255, 255, 0.9);
        padding: 1rem 1.5rem;
        border: none;
        font-size: 1rem;
    }

    .cosmic-detail-table tr:first-child th:first-child {
        border-top-left-radius: 15px;
    }

    .cosmic-detail-table tr:first-child td {
        border-top-right-radius: 15px;
    }

    .cosmic-detail-table tr:last-child th {
        border-bottom-left-radius: 15px;
    }

    .cosmic-detail-table tr:last-child td {
        border-bottom-right-radius: 15px;
    }

    .cosmic-detail-table tr {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .cosmic-detail-table tr:last-child {
        border-bottom: none;
    }

    .cosmic-value {
        font-weight: 500;
        color: #fff;
    }

    .cosmic-status {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        background: linear-gradient(45deg, #11998e, #38ef7d);
        color: white;
        box-shadow: 0 4px 15px rgba(17, 153, 142, 0.3);
    }

    .cosmic-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: #77dbff;
        text-shadow: 0 0 10px rgba(119, 219, 255, 0.5);
    }

    .cosmic-id {
        font-family: 'Courier New', monospace;
        background: rgba(255, 255, 255, 0.1);
        padding: 4px 8px;
        border-radius: 8px;
        color: #ff77c6;
        font-weight: 600;
    }
</style>

<div class="cosmic-container">
    <div class="cosmic-stars">
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
    </div>

    <div class="cosmic-header">
        <h1 class="cosmic-title">Заказ #<?= Html::encode($this->title) ?></h1>
        <p class="cosmic-subtitle">Детальная информация о заказе</p>
    </div>

    <div class="cosmic-actions">
        <?= Html::a('✏️ Редактировать', ['update', 'id' => $model->id], ['class' => 'cosmic-btn cosmic-btn-primary']) ?>
        <?= Html::a('🗑️ Удалить', ['delete', 'id' => $model->id], [
            'class' => 'cosmic-btn cosmic-btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить заказ?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <div class="cosmic-detail-card">
        <?= DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'cosmic-detail-table'],
            'template' => '<tr><th>{label}</th><td class="cosmic-value">{value}</td></tr>',
            'attributes' => [
                [
                    'attribute' => 'id',
                    'format' => 'raw',
                    'value' => '<span class="cosmic-id">' . Html::encode($model->id) . '</span>',
                    'label' => '🆔 ID Заказа'
                ],
                [
                    'attribute' => 'user_id',
                    'label' => '👤 ID Пользователя',
                    'value' => $model->user_id
                ],
                [
                    'attribute' => 'total_price',
                    'format' => 'raw',
                    'value' => '<span class="cosmic-price">💰 ' . Yii::$app->formatter->asCurrency($model->total_price) . '</span>',
                    'label' => '💳 Общая стоимость'
                ],
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'value' => '<span class="cosmic-status">📦 ' . Html::encode($model->status) . '</span>',
                    'label' => '📋 Статус заказа'
                ],
                [
                    'attribute' => 'created_at',
                    'format' => 'datetime',
                    'label' => '📅 Дата создания'
                ],
                [
                    'attribute' => 'delivery_id',
                    'label' => '🚚 ID Доставки',
                    'value' => $model->delivery_id
                ],

            ],
        ]) ?>
    </div>
</div>