<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = 'Пользователь #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css");
?>
<div class="container py-5 cosmic-user-view">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg cosmic-card">
                <div class="card-header cosmic-header py-4">
                    <div class="d-flex align-items-center">
                        <div class="cosmic-icon-bg me-3">
                            <i class="bi bi-person-circle cosmic-icon"></i>
                        </div>
                        <div>
                            <h1 class="h2 mb-0 cosmic-title"><?= Html::encode($this->title) ?></h1>
                            <p class="mb-0 cosmic-subtitle">Детальная информация о пользователе</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5 cosmic-card-body">
                    <div class="d-flex justify-content-end mb-4">
                        <div class="btn-group">
                            <?= Html::a('<i class="bi bi-pencil me-2"></i> Редактировать',
                                ['update', 'id' => $model->id],
                                ['class' => 'btn cosmic-edit-btn me-2']
                            ) ?>
                            <?= Html::a('<i class="bi bi-trash me-2"></i> Удалить',
                                ['delete', 'id' => $model->id],
                                [
                                    'class' => 'btn cosmic-delete-btn',
                                    'data' => [
                                        'confirm' => 'Вы уверены, что хотите удалить этого пользователя?',
                                        'method' => 'post',
                                    ],
                                ]
                            ) ?>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Основная информация -->
                        <div class="col-md-6 mb-4">
                            <div class="cosmic-info-card">
                                <div class="cosmic-info-header">
                                    <i class="bi bi-info-circle me-2"></i> Основная информация
                                </div>
                                <div class="cosmic-info-body">
                                    <div class="row cosmic-info-row">
                                        <div class="col-md-5 cosmic-info-label">ID:</div>
                                        <div class="col-md-7 cosmic-info-value"><?= $model->id ?></div>
                                    </div>
                                    <div class="row cosmic-info-row">
                                        <div class="col-md-5 cosmic-info-label">Имя пользователя:</div>
                                        <div class="col-md-7 cosmic-info-value"><?= $model->username ?></div>
                                    </div>
                                    <div class="row cosmic-info-row">
                                        <div class="col-md-5 cosmic-info-label">Email:</div>
                                        <div class="col-md-7 cosmic-info-value cosmic-email"><?= $model->email ?></div>
                                    </div>
                                    <div class="row cosmic-info-row">
                                        <div class="col-md-5 cosmic-info-label">Статус:</div>
                                        <div class="col-md-7 cosmic-info-value">
                                            <span class="cosmic-status-badge <?= $model->status == User::STATUS_ACTIVE ? 'active' : 'inactive' ?>">
                                                <?= $model->status == User::STATUS_ACTIVE ? 'Активен' : ($model->status == User::STATUS_INACTIVE ? 'Неактивен' : 'Удален') ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Техническая информация -->
                        <div class="col-md-6 mb-4">
                            <div class="cosmic-info-card">
                                <div class="cosmic-info-header">
                                    <i class="bi bi-gear me-2"></i> Техническая информация
                                </div>
                                <div class="cosmic-info-body">
                                    <div class="row cosmic-info-row">
                                        <div class="col-md-5 cosmic-info-label">Дата создания:</div>
                                        <div class="col-md-7 cosmic-info-value"><?= Yii::$app->formatter->asDatetime($model->created_at) ?></div>
                                    </div>
                                    <div class="row cosmic-info-row">
                                        <div class="col-md-5 cosmic-info-label">Дата обновления:</div>
                                        <div class="col-md-7 cosmic-info-value"><?= Yii::$app->formatter->asDatetime($model->updated_at) ?></div>
                                    </div>
                                    <div class="row cosmic-info-row">
                                        <div class="col-md-5 cosmic-info-label">Auth Key:</div>
                                        <div class="col-md-7 cosmic-info-value cosmic-code"><?= $model->auth_key ?: '-' ?></div>
                                    </div>
                                    <div class="row cosmic-info-row">
                                        <div class="col-md-5 cosmic-info-label">Password Hash:</div>
                                        <div class="col-md-7 cosmic-info-value cosmic-code"><?= $model->password_hash ? '••••••••' : '-' ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Дополнительные действия -->
                    <div class="text-center mt-4">
                        <?= Html::a('<i class="bi bi-cart me-2"></i> Заказы пользователя',
                            ['order/index', 'user_id' => $model->id],
                            ['class' => 'btn cosmic-orders-btn px-4 py-2']
                        ) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Глобальные стили */
    .cosmic-user-view {
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

    .cosmic-email {
        color: #a5ffd6;
    }

    .cosmic-code {
        font-family: 'Courier New', monospace;
        font-size: 0.85rem;
        color: rgba(200, 200, 255, 0.7);
        word-break: break-all;
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

    .cosmic-orders-btn {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.3) 0%, rgba(118, 75, 162, 0.3) 100%);
        color: #c7d2fe;
        border: 1px solid rgba(102, 126, 234, 0.4);
        border-radius: 12px;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .cosmic-orders-btn:hover {
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

        .col-md-6 {
            width: 100%;
            margin-bottom: 1.5rem;
        }

        .btn-group {
            width: 100%;
            flex-direction: column;
        }

        .cosmic-edit-btn,
        .cosmic-delete-btn {
            width: 100%;
            margin-bottom: 0.5rem;
            margin-right: 0 !important;
        }
    }
</style>