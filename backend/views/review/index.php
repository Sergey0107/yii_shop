<?php

use backend\models\Review;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\ReviewSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Отзывы';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .review-index {
        padding: 20px;
        background: rgba(10, 10, 20, 0.95);
        min-height: 100vh;
        color: #e8e9ea;
    }

    .review-header {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.8) 0%, rgba(118, 75, 162, 0.8) 100%);
        color: white;
        padding: 30px;
        border-radius: 15px 15px 0 0;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        border: 1px solid rgba(102, 126, 234, 0.4);
    }

    .review-header h1 {
        margin: 0;
        font-size: 2.5rem;
        font-weight: 300;
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }

    .review-content {
        background: rgba(20, 20, 36, 0.7);
        border-radius: 0 0 15px 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        overflow: hidden;
        border: 1px solid rgba(102, 126, 234, 0.4);
        border-top: none;
    }

    .search-section {
        padding: 20px;
        background: rgba(30, 30, 50, 0.6);
        border-bottom: 1px solid rgba(102, 126, 234, 0.4);
    }

    .custom-grid-view {
        margin: 0;
    }

    .custom-grid-view table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
        background: transparent;
    }

    .custom-grid-view th {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.8) 0%, rgba(118, 75, 162, 0.8) 100%);
        color: white;
        padding: 15px 12px;
        text-align: left;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
        position: sticky;
        top: 0;
        z-index: 10;
        border-bottom: 1px solid rgba(102, 126, 234, 0.4);
    }

    .custom-grid-view td {
        padding: 15px 12px;
        border-bottom: 1px solid rgba(102, 126, 234, 0.4);
        vertical-align: top;
        transition: all 0.3s ease;
        background: rgba(20, 20, 36, 0.7);
        color: #e8e9ea;
    }

    .custom-grid-view tbody tr:hover {
        background: rgba(40, 40, 60, 0.8);
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    }

    .review-text {
        max-width: 300px;
        word-wrap: break-word;
        line-height: 1.5;
        color: #c8c9ca;
    }

    .rating-stars {
        color: #ffc107;
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 2px;
    }

    .rating-number {
        margin-left: 8px;
        color: #a8a9aa;
        font-weight: 500;
    }

    .id-badge {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.8), rgba(118, 75, 162, 0.8));
        color: white;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
        border: 1px solid rgba(102, 126, 234, 0.4);
    }

    .user-product-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .info-label {
        font-size: 11px;
        color: #a8a9aa;
        text-transform: uppercase;
        font-weight: 600;
    }

    .info-value {
        font-size: 14px;
        color: #e8e9ea;
        font-weight: 500;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .btn-view {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.8), rgba(118, 75, 162, 0.8));
        color: white;
        border: 1px solid rgba(102, 126, 234, 0.4);
        padding: 8px 12px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        color: white;
        text-decoration: none;
        background: linear-gradient(135deg, rgba(102, 126, 234, 1), rgba(118, 75, 162, 1));
    }

    .btn-delete {
        background: linear-gradient(135deg, rgba(220, 50, 50, 0.8), rgba(180, 30, 30, 0.8));
        color: white;
        border: 1px solid rgba(220, 50, 50, 0.4);
        padding: 8px 12px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 50, 50, 0.4);
        color: white;
        text-decoration: none;
        background: linear-gradient(135deg, rgba(220, 50, 50, 1), rgba(180, 30, 30, 1));
    }

    .no-reviews {
        text-align: center;
        padding: 60px 20px;
        color: #a8a9aa;
        font-size: 18px;
    }

    /* Стили для форм поиска в темной теме */
    .search-section input,
    .search-section select {
        background: rgba(40, 40, 60, 0.8);
        border: 1px solid rgba(102, 126, 234, 0.4);
        color: #e8e9ea;
        border-radius: 6px;
        padding: 8px 12px;
    }

    .search-section input:focus,
    .search-section select:focus {
        outline: none;
        border-color: rgba(102, 126, 234, 0.8);
        box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.2);
    }

    .search-section label {
        color: #e8e9ea;
    }

    @media (max-width: 768px) {
        .review-header h1 {
            font-size: 2rem;
        }

        .custom-grid-view th,
        .custom-grid-view td {
            padding: 10px 8px;
            font-size: 13px;
        }

        .review-text {
            max-width: 200px;
        }

        .action-buttons {
            flex-direction: column;
            gap: 4px;
        }
    }
</style>

<div class="review-index">
    <div class="review-header">
        <h1><?= Html::encode($this->title) ?></h1>
        <p style="margin: 10px 0 0 0; opacity: 0.9;">Управление отзывами пользователей</p>
    </div>

    <div class="review-content">
        <div class="search-section">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>

        <div class="custom-grid-view">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table'],
                'options' => ['class' => ''],
                'emptyText' => '<div class="no-reviews">📝 Отзывы не найдены</div>',
                'columns' => [
                    [
                        'attribute' => 'id',
                        'headerOptions' => ['style' => 'width: 80px;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return '<span class="id-badge">#' . $model->id . '</span>';
                        }
                    ],
                    [
                        'attribute' => 'product_id',
                        'label' => 'Товар',
                        'headerOptions' => ['style' => 'width: 120px;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return '<div class="user-product-info">
                                        <span class="info-label">Товар</span>
                                        <span class="info-value">' . $model->product->name . '</span>
                                    </div>';
                        }
                    ],
                    [
                        'attribute' => 'user_id',
                        'label' => 'Пользователь',
                        'headerOptions' => ['style' => 'width: 120px;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return '<div class="user-product-info">
                                        <span class="info-label">Пользователь</span>
                                        <span class="info-value">' . $model->user->username . '</span>
                                    </div>';
                        }
                    ],
                    [
                        'attribute' => 'rating',
                        'label' => 'Рейтинг',
                        'headerOptions' => ['style' => 'width: 120px;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $stars = str_repeat('⭐', $model->rating) . str_repeat('☆', 5 - $model->rating);
                            return '<div class="rating-stars">' . $stars . '<span class="rating-number">(' . $model->rating . '/5)</span></div>';
                        }
                    ],
                    [
                        'attribute' => 'review',
                        'label' => 'Отзыв',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $text = Html::encode($model->review);
                            $shortText = mb_strlen($text) > 100 ? mb_substr($text, 0, 100) . '...' : $text;
                            return '<div class="review-text" title="' . $text . '">' . $shortText . '</div>';
                        }
                    ],
                    [
                        'class' => ActionColumn::class,
                        'header' => 'Действия',
                        'headerOptions' => ['style' => 'width: 150px; text-align: center;'],
                        'contentOptions' => ['style' => 'text-align: center;'],
                        'template' => '{view} {delete}',
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a('👁 Просмотр', $url, [
                                    'class' => 'btn-view',
                                    'title' => 'Просмотреть отзыв',
                                ]);
                            },
                            'delete' => function ($url, $model, $key) {
                                return Html::a('🗑 Удалить', $url, [
                                    'class' => 'btn-delete',
                                    'title' => 'Удалить отзыв',
                                    'data' => [
                                        'confirm' => 'Вы уверены, что хотите удалить этот отзыв?',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                        ],
                        'urlCreator' => function ($action, Review $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>