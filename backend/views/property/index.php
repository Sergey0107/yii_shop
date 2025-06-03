<?php

use backend\models\Property;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\PropertySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Характеристики';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css");
?>
    <div class="container py-5 cosmic-properties">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card border-0 shadow-lg cosmic-card">
                    <div class="card-header cosmic-header py-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="cosmic-icon-bg me-3">
                                    <i class="bi bi-gear cosmic-icon"></i>
                                </div>
                                <div>
                                    <h1 class="h2 mb-0 cosmic-title"><?= Html::encode($this->title) ?></h1>
                                    <p class="mb-0 cosmic-subtitle">Управление характеристиками товаров</p>
                                </div>
                            </div>
                            <?= Html::a('<i class="bi bi-plus-lg me-2"></i> Создать характеристику', ['create'], [
                                'class' => 'btn cosmic-add-btn',
                                'data-bs-toggle' => 'modal',
                                'data-bs-target' => '#propertyModal'
                            ]) ?>
                        </div>
                    </div>

                    <div class="card-body p-4 cosmic-card-body">
                        <!-- Кастомная форма поиска -->
                        <div class="cosmic-search-form mb-4">
                            <?php echo $this->render('_search', [
                                'model' => $searchModel,
                                'formClass' => 'cosmic-form'
                            ]); ?>
                        </div>

                        <div class="cosmic-table-responsive">
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'filterModel' => $searchModel,
                                'layout' => "{items}\n{pager}",
                                'tableOptions' => ['class' => 'table cosmic-table'],
                                'columns' => [
                                    [
                                        'class' => 'yii\grid\SerialColumn',
                                        'header' => '#',
                                        'headerOptions' => ['class' => 'cosmic-table-header'],
                                        'contentOptions' => ['class' => 'cosmic-table-cell']
                                    ],
                                    [
                                        'attribute' => 'id',
                                        'headerOptions' => ['class' => 'cosmic-table-header'],
                                        'contentOptions' => ['class' => 'cosmic-table-cell cosmic-id-cell']
                                    ],
                                    [
                                        'attribute' => 'name',
                                        'headerOptions' => ['class' => 'cosmic-table-header'],
                                        'contentOptions' => ['class' => 'cosmic-table-cell cosmic-name-cell']
                                    ],
                                    [
                                        'class' => ActionColumn::className(),
                                        'header' => 'Действия',
                                        'headerOptions' => ['class' => 'cosmic-table-header cosmic-actions-header'],
                                        'contentOptions' => ['class' => 'cosmic-table-cell cosmic-actions-cell'],
                                        'template' => '{view} {update} {delete}',
                                        'buttons' => [
                                            'view' => function ($url, $model) {
                                                return Html::a('<i class="bi bi-eye"></i>', $url, [
                                                    'class' => 'cosmic-action-btn cosmic-view-btn',
                                                    'title' => 'Просмотр'
                                                ]);
                                            },
                                            'update' => function ($url, $model) {
                                                return Html::a('<i class="bi bi-pencil"></i>', $url, [
                                                    'class' => 'cosmic-action-btn cosmic-edit-btn',
                                                    'title' => 'Редактировать',
                                                    'data-bs-toggle' => 'modal',
                                                    'data-bs-target' => '#propertyModal'
                                                ]);
                                            },
                                            'delete' => function ($url, $model) {
                                                return Html::a('<i class="bi bi-trash"></i>', $url, [
                                                    'class' => 'cosmic-action-btn cosmic-delete-btn',
                                                    'title' => 'Удалить',
                                                    'data' => [
                                                        'confirm' => 'Вы уверены, что хотите удалить эту характеристику?',
                                                        'method' => 'post',
                                                    ],
                                                ]);
                                            }
                                        ],
                                        'urlCreator' => function ($action, Property $model, $key, $index, $column) {
                                            return Url::toRoute([$action, 'id' => $model->id]);
                                        }
                                    ],
                                ],
                                'pager' => [
                                    'options' => ['class' => 'pagination justify-content-center cosmic-pagination'],
                                    'linkContainerOptions' => ['class' => 'page-item'],
                                    'linkOptions' => ['class' => 'page-link cosmic-page-link'],
                                    'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link cosmic-page-link disabled'],
                                    'prevPageLabel' => '<i class="bi bi-chevron-left"></i>',
                                    'nextPageLabel' => '<i class="bi bi-chevron-right"></i>',
                                ],
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно для формы -->
    <div class="modal fade" id="propertyModal" tabindex="-1" aria-labelledby="propertyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered cosmic-modal">
            <div class="modal-content cosmic-modal-content">
                <div class="modal-header cosmic-modal-header">
                    <h5 class="modal-title cosmic-modal-title" id="propertyModalLabel">Создать характеристику</h5>
                    <button type="button" class="btn-close cosmic-close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body cosmic-modal-body">
                    <!-- Форма будет загружаться через AJAX -->
                    <div id="modalFormContent">
                        <!-- Содержимое формы будет здесь -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Глобальные стили */
        .cosmic-properties {
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
            padding: 2rem;
        }

        /* Кнопка добавления */
        .cosmic-add-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            font-weight: 600;
            padding: 0.7rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            display: flex;
            align-items: center;
        }

        .cosmic-add-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
            color: white;
        }

        /* Таблица - основные стили */
        .cosmic-table-responsive {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        .cosmic-table {
            background: rgba(30, 30, 50, 0.4) !important;
            color: #e0e0ff !important;
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        /* Переопределяем все возможные фоны ячеек */
        .cosmic-table td,
        .cosmic-table th,
        .cosmic-table tbody tr td,
        .cosmic-table tbody tr th,
        .cosmic-table thead tr td,
        .cosmic-table thead tr th {
            background-color: transparent !important;
            background: transparent !important;
            color: #e0e0ff !important;
        }

        .cosmic-table-header {
            background: rgba(102, 126, 234, 0.3) !important;
            color: #c7d2fe !important;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
            border: none !important;
            padding: 1.2rem 1.5rem !important;
        }

        .cosmic-table-cell {
            background-color: rgba(30, 30, 50, 0.4) !important;
            background: rgba(30, 30, 50, 0.4) !important;
            padding: 1.2rem 1.5rem !important;
            border-bottom: 1px solid rgba(102, 126, 234, 0.1) !important;
            border-top: none !important;
            border-left: none !important;
            border-right: none !important;
            vertical-align: middle;
            color: #e0e0ff !important;
        }

        /* Последняя строка без нижней границы */
        .cosmic-table tbody tr:last-child td {
            border-bottom: none !important;
        }

        /* Эффект при наведении */
        .cosmic-table tbody tr:hover td {
            background: rgba(102, 126, 234, 0.15) !important;
            background-color: rgba(102, 126, 234, 0.15) !important;
        }

        /* Специфичные стили для разных типов ячеек */
        .cosmic-id-cell {
            font-weight: 700;
            color: #a5b4fc !important;
            background: rgba(30, 30, 50, 0.4) !important;
        }

        .cosmic-name-cell {
            color: #a5ffd6 !important;
            background: rgba(30, 30, 50, 0.4) !important;
            font-weight: 500;
        }

        /* Кнопки действий */
        .cosmic-actions-header {
            text-align: center;
        }

        .cosmic-actions-cell {
            text-align: center;
            white-space: nowrap;
        }

        .cosmic-action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            margin: 0 3px;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 1.1rem;
        }

        .cosmic-view-btn {
            background: rgba(102, 126, 234, 0.2);
            color: #a5b4fc;
            border: 1px solid rgba(102, 126, 234, 0.4);
        }

        .cosmic-view-btn:hover {
            background: rgba(102, 126, 234, 0.3);
            color: #c7d2fe;
            transform: translateY(-2px);
        }

        .cosmic-edit-btn {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.4);
        }

        .cosmic-edit-btn:hover {
            background: rgba(255, 193, 7, 0.3);
            color: #ffd54f;
            transform: translateY(-2px);
        }

        .cosmic-delete-btn {
            background: rgba(255, 107, 107, 0.2);
            color: #ff6b6b;
            border: 1px solid rgba(255, 107, 107, 0.4);
        }

        .cosmic-delete-btn:hover {
            background: rgba(255, 107, 107, 0.3);
            color: #ff8e8e;
            transform: translateY(-2px);
        }

        /* Пагинация */
        .cosmic-pagination {
            margin-top: 2rem;
        }

        .cosmic-page-link {
            background: rgba(30, 30, 50, 0.4);
            color: #c7d2fe;
            border: 1px solid rgba(102, 126, 234, 0.3);
            margin: 0 5px;
            border-radius: 8px !important;
            transition: all 0.3s ease;
        }

        .cosmic-page-link:hover {
            background: rgba(102, 126, 234, 0.3);
            color: white;
            border-color: #667eea;
        }

        .page-item.active .cosmic-page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            color: white;
        }

        .page-item.disabled .cosmic-page-link {
            background: rgba(30, 30, 50, 0.2);
            color: rgba(200, 200, 255, 0.4);
            border-color: rgba(102, 126, 234, 0.2);
        }

        /* Форма поиска */
        .cosmic-search-form {
            background: rgba(30, 30, 50, 0.5);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        .cosmic-form .form-group {
            margin-bottom: 1rem;
        }

        .cosmic-form .form-label {
            color: #c7d2fe;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .cosmic-form .form-control {
            background: rgba(20, 20, 40, 0.7);
            border: 1px solid rgba(102, 126, 234, 0.3);
            color: #e0e0ff;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .cosmic-form .form-control:focus {
            background: rgba(30, 30, 50, 0.7);
            border-color: #667eea;
            color: white;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        }

        .cosmic-form .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            font-weight: 600;
            padding: 0.7rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .cosmic-form .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
        }

        /* Фильтры в заголовках */
        .cosmic-table-header input,
        .cosmic-table-header select {
            background: rgba(20, 20, 40, 0.8) !important;
            border: 1px solid rgba(102, 126, 234, 0.3) !important;
            color: #e0e0ff !important;
            border-radius: 6px;
            padding: 0.5rem;
        }

        .cosmic-table-header input:focus,
        .cosmic-table-header select:focus {
            background: rgba(30, 30, 50, 0.8) !important;
            border-color: #667eea !important;
            color: white !important;
            box-shadow: 0 0 0 0.15rem rgba(102, 126, 234, 0.25) !important;
        }

        /* Опции в селектах */
        .cosmic-table-header select option {
            background: rgba(30, 30, 50, 0.9) !important;
            color: #e0e0ff !important;
        }

        /* Модальное окно */
        .cosmic-modal {
            max-width: 600px;
        }

        .cosmic-modal-content {
            background: rgba(26, 26, 46, 0.95);
            backdrop-filter: blur(15px);
            border-radius: 16px;
            border: 1px solid rgba(102, 126, 234, 0.4);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            color: #e0e0ff;
        }

        .cosmic-modal-header {
            border-bottom: 1px solid rgba(102, 126, 234, 0.3);
            padding: 1.5rem;
        }

        .cosmic-modal-title {
            color: #a5b4fc;
            font-weight: 700;
        }

        .cosmic-close-btn {
            color: #c7d2fe;
            opacity: 0.8;
            transition: all 0.3s ease;
        }

        .cosmic-close-btn:hover {
            opacity: 1;
            color: white;
        }

        .cosmic-modal-body {
            padding: 1.5rem;
        }

        /* Дополнительные правила для GridView */
        .grid-view table.table {
            background: rgba(30, 30, 50, 0.4) !important;
        }

        .grid-view table.table td,
        .grid-view table.table th {
            background: transparent !important;
            background-color: transparent !important;
        }

        /* Адаптивность */
        @media (max-width: 992px) {
            .cosmic-table-responsive {
                overflow-x: auto;
            }

            .cosmic-table {
                min-width: 600px;
            }

            .cosmic-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .cosmic-add-btn {
                margin-top: 1rem;
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .cosmic-card {
                margin: 1rem;
            }

            .cosmic-icon-bg {
                width: 40px;
                height: 40px;
            }

            .cosmic-title {
                font-size: 1.5rem;
            }

            .cosmic-search-form {
                padding: 1rem;
            }
        }
    </style>

<?php
// JavaScript для загрузки формы в модальное окно
$this->registerJs(<<<JS
$(document).on('click', '[data-bs-toggle="modal"][data-bs-target="#propertyModal"]', function(e) {
    e.preventDefault();
    var url = $(this).attr('href');
    
    $('#modalFormContent').html('<div class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Загрузка...</span></div></div>');
    
    $.get(url, function(data) {
        $('#modalFormContent').html(data);
    }).fail(function() {
        $('#modalFormContent').html('<div class="alert alert-danger">Ошибка загрузки формы</div>');
    });
    
    // Обновляем заголовок модального окна
    var isUpdate = $(this).hasClass('cosmic-edit-btn');
    $('#propertyModalLabel').text(isUpdate ? 'Редактировать характеристику' : 'Создать характеристику');
});

// Обработка успешной отправки формы
$(document).on('beforeSubmit', '#property-form', function(e) {
    e.preventDefault();
    var form = $(this);
    
    $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: form.serialize(),
        success: function(response) {
            if (response.success) {
                $('#propertyModal').modal('hide');
                $.pjax.reload({container: '#pjax-container', timeout: 10000});
            } else {
                $('#modalFormContent').html(response);
            }
        },
        error: function() {
            alert('Произошла ошибка');
        }
    });
    
    return false;
});
JS
);
?>