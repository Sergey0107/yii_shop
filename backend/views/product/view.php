<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Product $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$this->registerCssFile("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css");
?>
<div class="container py-5 cosmic-view">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg cosmic-card">
                <div class="card-header cosmic-header py-4">
                    <div class="d-flex align-items-center">
                        <div class="cosmic-icon-bg me-3">
                            <i class="bi bi-stars cosmic-icon"></i>
                        </div>
                        <div>
                            <h1 class="h2 mb-0 cosmic-title"><?= Html::encode($this->title) ?></h1>
                            <p class="mb-0 cosmic-subtitle">Детальная информация о товаре</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5 cosmic-card-body">
                    <div class="d-flex justify-content-end mb-4">
                        <div class="btn-group">
                            <?= Html::a('<i class="bi bi-pencil"></i> Редактировать',
                                ['update', 'id' => $model->id],
                                ['class' => 'btn cosmic-edit-btn me-2']
                            ) ?>
                            <?= Html::a('<i class="bi bi-trash"></i> Удалить',
                                ['delete', 'id' => $model->id],
                                [
                                    'class' => 'btn cosmic-delete-btn',
                                    'data' => [
                                        'confirm' => 'Вы уверены, что хотите удалить этот товар?',
                                        'method' => 'post',
                                    ],
                                ]
                            ) ?>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Изображение товара -->
                        <div class="col-md-5 mb-4">
                            <div class="cosmic-image-container">
                                <?php if ($model->img && file_exists(Yii::getAlias('@webroot/uploads/product/' . $model->img))) : ?>
                                    <?= Html::img(
                                        Yii::getAlias('@web/uploads/product/' . $model->img),
                                        [
                                            'alt' => 'Изображение товара',
                                            'class' => 'img-fluid cosmic-product-image',
                                        ]
                                    ) ?>
                                <?php else : ?>
                                    <div class="cosmic-no-image">
                                        <i class="bi bi-image cosmic-no-image-icon"></i>
                                        <p class="cosmic-no-image-text">Изображение отсутствует</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Основная информация -->
                        <div class="col-md-7">
                            <div class="cosmic-info-card">
                                <div class="cosmic-info-header">
                                    <i class="bi bi-info-circle me-2"></i> Основная информация
                                </div>
                                <div class="cosmic-info-body">
                                    <div class="row cosmic-info-row">
                                        <div class="col-md-4 cosmic-info-label">ID:</div>
                                        <div class="col-md-8 cosmic-info-value"><?= $model->id ?></div>
                                    </div>
                                    <div class="row cosmic-info-row">
                                        <div class="col-md-4 cosmic-info-label">Описание:</div>
                                        <div class="col-md-8 cosmic-info-value"><?= $model->description ?: '-' ?></div>
                                    </div>
                                    <div class="row cosmic-info-row">
                                        <div class="col-md-4 cosmic-info-label">Цена:</div>
                                        <div class="col-md-8 cosmic-info-value cosmic-price"><?= number_format($model->price, 2) ?> ₽</div>
                                    </div>
                                    <div class="row cosmic-info-row">
                                        <div class="col-md-4 cosmic-info-label">Старая цена:</div>
                                        <div class="col-md-8 cosmic-info-value cosmic-old-price"><?= $model->old_price ? number_format($model->old_price, 2) . ' ₽' : '-' ?></div>
                                    </div>
                                    <div class="row cosmic-info-row">
                                        <div class="col-md-4 cosmic-info-label">Количество:</div>
                                        <div class="col-md-8 cosmic-info-value"><?= $model->quantity ?></div>
                                    </div>
                                    <div class="row cosmic-info-row">
                                        <div class="col-md-4 cosmic-info-label">Вес:</div>
                                        <div class="col-md-8 cosmic-info-value"><?= $model->weight ?> кг</div>
                                    </div>
                                    <div class="row cosmic-info-row">
                                        <div class="col-md-4 cosmic-info-label">Статус:</div>
                                        <div class="col-md-8 cosmic-info-value">
                                            <span class="cosmic-status-badge <?= $model->is_active ? 'active' : 'inactive' ?>">
                                                <?= $model->is_active ? 'Активен' : 'Неактивен' ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Характеристики -->
                    <div class="row mt-4">
                        <div class="col-md-6 mb-4">
                            <div class="cosmic-info-card">
                                <div class="cosmic-info-header">
                                    <i class="bi bi-tags me-2"></i> Характеристики
                                </div>
                                <div class="cosmic-info-body">
                                    <div class="row cosmic-info-row">
                                        <div class="col-md-5 cosmic-info-label">Размер:</div>
                                        <div class="col-md-7 cosmic-info-value"><?= $model->size ? $model->size->value : 'Не указан' ?></div>
                                    </div>
                                    <div class="row cosmic-info-row">
                                        <div class="col-md-5 cosmic-info-label">Тип:</div>
                                        <div class="col-md-7 cosmic-info-value"><?= $model->type ? $model->type->name : 'Не указан' ?></div>
                                    </div>
                                    <div class="row cosmic-info-row">
                                        <div class="col-md-5 cosmic-info-label">Страна:</div>
                                        <div class="col-md-7 cosmic-info-value"><?= $model->country ? $model->country->name : 'Не указана' ?></div>
                                    </div>
                                    <div class="row cosmic-info-row">
                                        <div class="col-md-5 cosmic-info-label">Цвет:</div>
                                        <div class="col-md-7 cosmic-info-value"><?= $model->color ? $model->color->name : 'Не указан' ?></div>
                                    </div>
                                    <div class="row cosmic-info-row">
                                        <div class="col-md-5 cosmic-info-label">Материал:</div>
                                        <div class="col-md-7 cosmic-info-value"><?= $model->material ? $model->material->name : 'Не указан' ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="cosmic-info-card">
                                <div class="cosmic-info-header">
                                    <i class="bi bi-stars me-2"></i> Дополнительные настройки
                                </div>
                                <div class="cosmic-info-body">
                                    <div class="row cosmic-info-row">
                                        <div class="col-md-6 cosmic-info-label">Новинка:</div>
                                        <div class="col-md-6 cosmic-info-value">
                                            <span class="cosmic-status-badge <?= $model->is_new ? 'active' : 'inactive' ?>">
                                                <?= $model->is_new ? 'Да' : 'Нет' ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row cosmic-info-row">
                                        <div class="col-md-6 cosmic-info-label">Популярный:</div>
                                        <div class="col-md-6 cosmic-info-value">
                                            <span class="cosmic-status-badge <?= $model->is_popular ? 'active' : 'inactive' ?>">
                                                <?= $model->is_popular ? 'Да' : 'Нет' ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Дополнительные свойства -->
                    <?php if (!empty($model->propertyValues)) : ?>
                        <div class="cosmic-info-card mt-4">
                            <div class="cosmic-info-header">
                                <i class="bi bi-gear me-2"></i> Дополнительные свойства
                            </div>
                            <div class="cosmic-info-body">
                                <div class="row">
                                    <?php foreach ($model->propertyValues as $propValue): ?>
                                        <div class="col-md-6 mb-3">
                                            <div class="cosmic-property-item">
                                                <div class="cosmic-property-label"><?= $propValue->property->name ?></div>
                                                <div class="cosmic-property-value"><?= $propValue->value ?></div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="text-center mt-5">
                        <?= Html::a('Вернуться к списку товаров', ['index'], [
                            'class' => 'btn cosmic-back-btn px-4 py-2'
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Глобальные стили */
    .cosmic-view {
        background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 100%);
        min-height: 100vh;
        color: #e0e0ff;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .cosmic-card {
        background: rgba(26, 26, 46, 0.8);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(102, 126, 234, 0.3);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .cosmic-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-bottom: 1px solid rgba(118, 75, 162, 0.5);
    }

    .cosmic-title {
        color: white;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .cosmic-subtitle {
        color: rgba(255, 255, 255, 0.8);
        font-size: 1rem;
    }

    .cosmic-icon-bg {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        backdrop-filter: blur(5px);
        border: 1px solid rgba(102, 126, 234, 0.3);
    }

    .cosmic-icon {
        color: #a5b4fc;
        font-size: 1.5rem;
    }

    .cosmic-card-body {
        background: rgba(22, 22, 40, 0.7);
    }

    /* Карточки информации */
    .cosmic-info-card {
        border-radius: 12px;
        background: rgba(30, 30, 50, 0.4);
        border: 1px solid rgba(102, 126, 234, 0.2);
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
    }

    .cosmic-info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        border-color: rgba(102, 126, 234, 0.4);
    }

    .cosmic-info-header {
        background: rgba(102, 126, 234, 0.2);
        padding: 1rem 1.5rem;
        color: #a5b4fc;
        font-weight: 600;
        font-size: 1.1rem;
        border-bottom: 1px solid rgba(102, 126, 234, 0.3);
    }

    .cosmic-info-body {
        padding: 1.5rem;
    }

    .cosmic-info-row {
        padding: 0.8rem 0;
        border-bottom: 1px solid rgba(102, 126, 234, 0.1);
    }

    .cosmic-info-row:last-child {
        border-bottom: none;
    }

    .cosmic-info-label {
        color: #c7d2fe;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .cosmic-info-value {
        color: #e0e0ff;
        font-weight: 500;
    }

    /* Изображение товара */
    .cosmic-image-container {
        border-radius: 12px;
        overflow: hidden;
        background: rgba(30, 30, 50, 0.4);
        border: 1px solid rgba(102, 126, 234, 0.2);
        padding: 1.5rem;
        text-align: center;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cosmic-product-image {
        max-height: 300px;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(102, 126, 234, 0.3);
    }

    .cosmic-no-image {
        padding: 2rem;
        border-radius: 8px;
        background: rgba(20, 20, 36, 0.5);
        border: 1px dashed rgba(102, 126, 234, 0.3);
    }

    .cosmic-no-image-icon {
        font-size: 3rem;
        color: rgba(102, 126, 234, 0.5);
        margin-bottom: 1rem;
    }

    .cosmic-no-image-text {
        color: rgba(200, 200, 255, 0.6);
        font-style: italic;
    }

    /* Цены */
    .cosmic-price {
        color: #a5ffd6;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .cosmic-old-price {
        color: #ff6b6b;
        text-decoration: line-through;
        font-size: 0.95rem;
    }

    /* Бейджи статусов */
    .cosmic-status-badge {
        display: inline-block;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .cosmic-status-badge.active {
        background: rgba(101, 223, 165, 0.2);
        color: #65dfa5;
        border: 1px solid rgba(101, 223, 165, 0.4);
    }

    .cosmic-status-badge.inactive {
        background: rgba(255, 107, 107, 0.2);
        color: #ff6b6b;
        border: 1px solid rgba(255, 107, 107, 0.4);
    }

    /* Дополнительные свойства */
    .cosmic-property-item {
        background: rgba(35, 35, 60, 0.5);
        border-radius: 8px;
        padding: 1rem;
        border: 1px solid rgba(102, 126, 234, 0.2);
    }

    .cosmic-property-label {
        color: #c7d2fe;
        font-size: 0.9rem;
        margin-bottom: 0.3rem;
    }

    .cosmic-property-value {
        color: #e0e0ff;
        font-weight: 500;
        font-size: 1.05rem;
    }

    /* Кнопки */
    .cosmic-edit-btn {
        background: rgba(102, 126, 234, 0.2);
        color: #a5b4fc;
        border: 1px solid rgba(102, 126, 234, 0.4);
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .cosmic-edit-btn:hover {
        background: rgba(102, 126, 234, 0.3);
        color: #c7d2fe;
        transform: translateY(-2px);
    }

    .cosmic-delete-btn {
        background: rgba(255, 107, 107, 0.2);
        color: #ff6b6b;
        border: 1px solid rgba(255, 107, 107, 0.4);
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .cosmic-delete-btn:hover {
        background: rgba(255, 107, 107, 0.3);
        color: #ff8e8e;
        transform: translateY(-2px);
    }

    .cosmic-back-btn {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.3) 0%, rgba(118, 75, 162, 0.3) 100%);
        color: #c7d2fe;
        border: 1px solid rgba(102, 126, 234, 0.4);
        border-radius: 12px;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .cosmic-back-btn:hover {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.4) 0%, rgba(118, 75, 162, 0.4) 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
    }

    /* Адаптивность */
    @media (max-width: 768px) {
        .cosmic-card {
            margin: 1rem;
        }

        .cosmic-header {
            padding: 1.5rem;
        }

        .cosmic-icon-bg {
            width: 40px;
            height: 40px;
        }

        .cosmic-title {
            font-size: 1.5rem;
        }

        .row {
            flex-direction: column;
        }

        .col-md-5, .col-md-6, .col-md-7 {
            width: 100%;
            margin-bottom: 1.5rem;
        }
    }
</style>