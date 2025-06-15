<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Review $model */

$this->title = $model->product->name;
$this->params['breadcrumbs'][] = ['label' => 'Отзывы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<style>
    .review-view {
        padding: 20px;
        background: rgba(10, 10, 20, 0.95);
        min-height: 100vh;
        color: #e8e9ea;
    }

    .review-detail-header {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.8) 0%, rgba(118, 75, 162, 0.8) 100%);
        color: white;
        padding: 30px;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        border: 1px solid rgba(102, 126, 234, 0.4);
        margin-bottom: 30px;
    }

    .review-detail-header h1 {
        margin: 0;
        font-size: 2.2rem;
        font-weight: 300;
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }

    .review-detail-header .subtitle {
        margin: 10px 0 0 0;
        opacity: 0.9;
        font-size: 1.1rem;
    }

    .action-section {
        background: rgba(20, 20, 36, 0.7);
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 30px;
        border: 1px solid rgba(102, 126, 234, 0.4);
        text-align: center;
    }

    .btn-back {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.8), rgba(118, 75, 162, 0.8));
        color: white;
        border: 1px solid rgba(102, 126, 234, 0.4);
        padding: 12px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-right: 15px;
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        color: white;
        text-decoration: none;
        background: linear-gradient(135deg, rgba(102, 126, 234, 1), rgba(118, 75, 162, 1));
    }

    .btn-delete-custom {
        background: linear-gradient(135deg, rgba(220, 50, 50, 0.8), rgba(180, 30, 30, 0.8));
        color: white;
        border: 1px solid rgba(220, 50, 50, 0.4);
        padding: 12px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-delete-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 50, 50, 0.4);
        color: white;
        text-decoration: none;
        background: linear-gradient(135deg, rgba(220, 50, 50, 1), rgba(180, 30, 30, 1));
    }

    .detail-view-container {
        background: rgba(20, 20, 36, 0.7);
        border-radius: 15px;
        overflow: hidden;
        border: 1px solid rgba(102, 126, 234, 0.4);
        box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    }

    .detail-view-header {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.6), rgba(118, 75, 162, 0.6));
        padding: 20px;
        color: white;
        font-size: 1.3rem;
        font-weight: 600;
        text-align: center;
        border-bottom: 1px solid rgba(102, 126, 234, 0.4);
    }

    .custom-detail-view table {
        width: 100%;
        border-collapse: collapse;
        background: transparent;
    }

    .custom-detail-view th {
        background: rgba(40, 40, 60, 0.8);
        color: #e8e9ea;
        padding: 18px 20px;
        text-align: left;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid rgba(102, 126, 234, 0.4);
        width: 200px;
        vertical-align: top;
    }

    .custom-detail-view td {
        padding: 18px 20px;
        border-bottom: 1px solid rgba(102, 126, 234, 0.4);
        color: #c8c9ca;
        font-size: 15px;
        line-height: 1.6;
        vertical-align: top;
    }

    .custom-detail-view tr:last-child th,
    .custom-detail-view tr:last-child td {
        border-bottom: none;
    }

    .rating-display {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .rating-stars {
        color: #ffc107;
        font-size: 18px;
    }

    .rating-number {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.8), rgba(118, 75, 162, 0.8));
        color: white;
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 600;
        border: 1px solid rgba(102, 126, 234, 0.4);
    }

    .id-badge {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.8), rgba(118, 75, 162, 0.8));
        color: white;
        padding: 6px 12px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        display: inline-block;
        border: 1px solid rgba(102, 126, 234, 0.4);
    }

    .review-text-full {
        background: rgba(40, 40, 60, 0.6);
        padding: 15px;
        border-radius: 8px;
        border: 1px solid rgba(102, 126, 234, 0.3);
        line-height: 1.7;
        font-size: 15px;
        color: #e8e9ea;
        max-width: 100%;
        word-wrap: break-word;
    }

    @media (max-width: 768px) {
        .review-detail-header h1 {
            font-size: 1.8rem;
        }

        .custom-detail-view th {
            width: 120px;
            padding: 15px;
            font-size: 12px;
        }

        .custom-detail-view td {
            padding: 15px;
            font-size: 14px;
        }

        .action-section {
            text-align: center;
        }

        .btn-back,
        .btn-delete-custom {
            display: block;
            margin: 0 auto 10px auto;
            width: fit-content;
        }
    }
</style>

<div class="review-view">
    <div class="review-detail-header">
        <h1><?= Html::encode($this->title) ?></h1>
        <p class="subtitle">Детальный просмотр отзыва</p>
    </div>

    <div class="action-section">
        <?= Html::a('← Назад к списку', ['index'], [
            'class' => 'btn-back',
        ]) ?>

        <?= Html::a('🗑 Удалить отзыв', ['delete', 'id' => $model->id], [
            'class' => 'btn-delete-custom',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить отзыв?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <div class="detail-view-container">
        <div class="detail-view-header">
            📝 Информация об отзыве
        </div>

        <div class="custom-detail-view">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => ''],
                'attributes' => [
                    [
                        'attribute' => 'product_id',
                        'label' => 'Товар',
                        'format' => 'raw',
                        'value' => '<span class="id-badge">' . $model->product->name . '</span>'
                    ],
                    [
                        'attribute' => 'user_id',
                        'label' => 'Пользователь',
                        'format' => 'raw',
                        'value' => '<span class="id-badge">' . $model->user->username . '</span>'
                    ],
                    [
                        'attribute' => 'rating',
                        'label' => 'Рейтинг',
                        'format' => 'raw',
                        'value' => function($model) {
                            $stars = str_repeat('⭐', $model->rating) . str_repeat('☆', 5 - $model->rating);
                            return '<div class="rating-display">
                                        <span class="rating-stars">' . $stars . '</span>
                                        <span class="rating-number">' . $model->rating . '/5</span>
                                    </div>';
                        }
                    ],
                    [
                        'attribute' => 'review',
                        'label' => 'Текст отзыва',
                        'format' => 'raw',
                        'value' => '<div class="review-text-full">' . Html::encode($model->review) . '</div>'
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>