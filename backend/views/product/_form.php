<?php
use backend\models\ProductProperty;
use backend\models\Property;
use backend\models\PropertyValue;
use backend\models\Size;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
/** @var array $sizes */
/** @var array $colors */
/** @var array $countries */
/** @var array $materials */
/** @var array $types */
/** @var backend\models\Property[] $properties */
/** @var ProductProperty $currentProperties */

$this->registerCssFile("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css");
?>

<div class="container py-5 cosmic-form">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg cosmic-card">
                <div class="card-header cosmic-header py-4">
                    <div class="d-flex align-items-center">
                        <div class="cosmic-icon-bg me-3">
                            <i class="bi bi-stars cosmic-icon"></i>
                        </div>
                        <div>
                            <h1 class="h2 mb-0 cosmic-title">Управление товаром</h1>
                            <p class="mb-0 cosmic-subtitle">Заполните форму для добавления или редактирования товара</p>
                        </div>
                    </div>
                </div>

                <?php $form = ActiveForm::begin([
                    'options' => [
                        'enctype' => 'multipart/form-data',
                        'class' => 'needs-validation cosmic-form',
                        'novalidate' => true
                    ],
                    'fieldConfig' => [
                        'template' => "{label}{input}\n{error}",
                        'labelOptions' => ['class' => 'form-label cosmic-label'],
                        'errorOptions' => ['class' => 'invalid-feedback cosmic-error'],
                        'inputOptions' => ['class' => 'form-control cosmic-input'],
                    ]
                ]); ?>

                <div class="card-body p-4 p-md-5 cosmic-card-body">
                    <!-- Основная информация -->
                    <div class="mb-5 cosmic-section">
                        <div class="d-flex align-items-center mb-4">
                            <div class="cosmic-icon-bg me-3">
                                <i class="bi bi-info-circle cosmic-icon"></i>
                            </div>
                            <h2 class="h4 mb-0 cosmic-section-title">Основная информация</h2>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <?= $form->field($model, 'name')->textInput([
                                    'maxlength' => true,
                                    'placeholder' => 'Введите название товара',
                                    'required' => true
                                ]) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $form->field($model, 'price')->textInput([
                                    'type' => 'number',
                                    'step' => '0.01',
                                    'placeholder' => '0.00',
                                    'required' => true
                                ]) ?>
                            </div>

                            <div class="col-12">
                                <?= $form->field($model, 'description')->textarea([
                                    'rows' => 4,
                                    'placeholder' => 'Подробное описание товара...',
                                    'class' => 'form-control cosmic-textarea'
                                ]) ?>
                            </div>
                        </div>
                    </div>

                    <!-- Изображение товара -->
                    <div class="mb-5 cosmic-section">
                        <div class="d-flex align-items-center mb-4">
                            <div class="cosmic-icon-bg me-3">
                                <i class="bi bi-image cosmic-icon"></i>
                            </div>
                            <h2 class="h4 mb-0 cosmic-section-title">Изображение товара</h2>
                        </div>

                        <div class="cosmic-image-upload">
                            <div class="text-center mb-4">
                                <?php if ($model->img && file_exists(Yii::getAlias('@webroot/uploads/product/' . $model->img))) : ?>
                                    <div class="mb-3">
                                        <?= Html::img(
                                            Yii::getAlias('@web/uploads/product/' . $model->img),
                                            [
                                                'alt' => 'Изображение товара',
                                                'class' => 'img-fluid rounded shadow cosmic-current-image',
                                            ]
                                        ) ?>
                                        <p class="cosmic-image-label mt-2 mb-0">Текущее изображение</p>
                                    </div>
                                <?php else : ?>
                                    <div class="cosmic-no-image">
                                        <i class="bi bi-image cosmic-no-image-icon"></i>
                                        <p class="cosmic-no-image-text">Изображение не загружено</p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label class="form-label cosmic-label">Загрузить новое изображение</label>
                                <div class="cosmic-file-upload">
                                    <?= $form->field($model, 'imageFile')->fileInput([
                                        'class' => 'cosmic-file-input',
                                        'accept' => 'image/*'
                                    ])->label(false) ?>
                                    <div class="cosmic-file-icon">
                                        <i class="bi bi-cloud-arrow-up"></i>
                                    </div>
                                    <p class="cosmic-file-instruction">Перетащите файл сюда или кликните для выбора</p>
                                    <p class="cosmic-file-info">Поддерживаемые форматы: JPG, PNG, GIF. Максимальный размер: 5MB</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Цены и наличие -->
                    <div class="mb-5 cosmic-section">
                        <div class="d-flex align-items-center mb-4">
                            <div class="cosmic-icon-bg me-3">
                                <i class="bi bi-tag cosmic-icon"></i>
                            </div>
                            <h2 class="h4 mb-0 cosmic-section-title">Цены и наличие</h2>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-4">
                                <?= $form->field($model, 'old_price')->textInput([
                                    'type' => 'number',
                                    'step' => '0.01',
                                    'placeholder' => '0.00'
                                ]) ?>
                            </div>

                            <div class="col-md-4">
                                <?= $form->field($model, 'quantity')->textInput([
                                    'type' => 'number',
                                    'placeholder' => '0',
                                    'min' => '0'
                                ]) ?>
                            </div>

                            <div class="col-md-4">
                                <?= $form->field($model, 'weight')->textInput([
                                    'type' => 'number',
                                    'step' => '0.1',
                                    'placeholder' => '0.0'
                                ]) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $form->field($model, 'is_active')->dropDownList([
                                    1 => 'Активен',
                                    0 => 'Неактивен'
                                ], [
                                    'class' => 'form-select cosmic-select',
                                    'prompt' => 'Выберите статус'
                                ]) ?>
                            </div>
                        </div>
                    </div>

                    <!-- Характеристики товара -->
                    <div class="mb-5 cosmic-section">
                        <div class="d-flex align-items-center mb-4">
                            <div class="cosmic-icon-bg me-3">
                                <i class="bi bi-list-check cosmic-icon"></i>
                            </div>
                            <h2 class="h4 mb-0 cosmic-section-title">Характеристики товара</h2>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <?= $form->field($model, 'size_id')->dropDownList(
                                    $sizes,
                                    [
                                        'prompt' => 'Выберите размер',
                                        'class' => 'form-select cosmic-select'
                                    ]
                                ) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $form->field($model, 'type_id')->dropDownList(
                                    $types,
                                    [
                                        'prompt' => 'Выберите тип',
                                        'class' => 'form-select cosmic-select'
                                    ]
                                ) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $form->field($model, 'country_id')->dropDownList(
                                    $countries,
                                    [
                                        'prompt' => 'Выберите страну',
                                        'class' => 'form-select cosmic-select'
                                    ]
                                ) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $form->field($model, 'color_id')->dropDownList(
                                    $colors,
                                    [
                                        'prompt' => 'Выберите цвет',
                                        'class' => 'form-select cosmic-select'
                                    ]
                                ) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $form->field($model, 'material_id')->dropDownList(
                                    $materials,
                                    [
                                        'prompt' => 'Выберите материал',
                                        'class' => 'form-select cosmic-select'
                                    ]
                                ) ?>
                            </div>
                        </div>
                    </div>

                    <!-- Дополнительные свойства -->
                    <?php if ($properties): ?>
                        <div class="mb-5 cosmic-section">
                            <div class="d-flex align-items-center mb-4">
                                <div class="cosmic-icon-bg me-3">
                                    <i class="bi bi-gear cosmic-icon"></i>
                                </div>
                                <h2 class="h4 mb-0 cosmic-section-title">Дополнительные свойства</h2>
                            </div>

                            <div class="row g-4">
                                <?php foreach ($properties as $property):
                                    $selectedValue = null;
                                    if ($currentProperties) {
                                        foreach ($currentProperties as $cp) {
                                            if ($cp->property_id == $property->id) {
                                                $selectedValue = $cp->value_id;
                                                break;
                                            }
                                        }
                                    }
                                    ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label cosmic-label"><?= $property->name ?></label>
                                            <?= Html::dropDownList(
                                                "PropertyValues[{$property->id}]",
                                                $selectedValue,
                                                ArrayHelper::map(PropertyValue::findAll(['property_id' => $property->id]), 'id', 'value'),
                                                [
                                                    'prompt' => 'Выберите значение...',
                                                    'class' => 'form-select cosmic-select'
                                                ]
                                            ) ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Дополнительные настройки -->
                    <div class="mb-4 cosmic-section">
                        <div class="d-flex align-items-center mb-4">
                            <div class="cosmic-icon-bg me-3">
                                <i class="bi bi-sliders cosmic-icon"></i>
                            </div>
                            <h2 class="h4 mb-0 cosmic-section-title">Дополнительные настройки</h2>
                        </div>

                        <div class="d-flex flex-wrap gap-4">
                            <div class="form-check form-switch cosmic-switch">
                                <?= $form->field($model, 'is_new')->checkbox([
                                    'class' => 'form-check-input cosmic-switch-input',
                                    'role' => 'switch'
                                ])->label('', ['class' => 'form-check-label cosmic-switch-label']) ?>
                            </div>

                            <div class="form-check form-switch cosmic-switch">
                                <?= $form->field($model, 'is_popular')->checkbox([
                                    'class' => 'form-check-input cosmic-switch-input',
                                    'role' => 'switch'
                                ])->label('', ['class' => 'form-check-label cosmic-switch-label']) ?>
                            </div>
                        </div>
                    </div>

                    <!-- Кнопка отправки -->
                    <div class="text-center mt-5 pt-3">
                        <?= Html::submitButton('Сохранить товар', [
                            'class' => 'btn cosmic-btn px-5 py-3'
                        ]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<style>
    /* Глобальные стили */
    .cosmic-form {
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

    .cosmic-section {
        padding: 1.5rem;
        border-radius: 12px;
        background: rgba(30, 30, 50, 0.4);
        border: 1px solid rgba(102, 126, 234, 0.2);
        margin-bottom: 2rem;
        transition: all 0.3s ease;
    }

    .cosmic-section:hover {
        background: rgba(35, 35, 60, 0.5);
        border-color: rgba(102, 126, 234, 0.4);
    }

    .cosmic-section-title {
        color: #a5b4fc;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .cosmic-label {
        color: #c7d2fe;
        font-weight: 500;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .cosmic-input, .cosmic-select, .cosmic-textarea {
        background: rgba(20, 20, 36, 0.7);
        border: 1px solid rgba(102, 126, 234, 0.3);
        color: #e0e0ff;
        border-radius: 8px;
        padding: 0.8rem 1rem;
        transition: all 0.3s ease;
    }

    .cosmic-input:focus, .cosmic-select:focus, .cosmic-textarea:focus {
        background: rgba(25, 25, 45, 0.8);
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        color: white;
        outline: none;
    }

    .cosmic-input::placeholder, .cosmic-textarea::placeholder {
        color: rgba(200, 200, 255, 0.4);
    }

    .cosmic-textarea {
        min-height: 120px;
        resize: vertical;
    }

    /* Стили для загрузки изображений */
    .cosmic-image-upload {
        padding: 1.5rem;
        border-radius: 12px;
        background: rgba(25, 25, 45, 0.5);
        border: 1px dashed rgba(102, 126, 234, 0.4);
    }

    .cosmic-current-image {
        max-height: 200px;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(102, 126, 234, 0.3);
    }

    .cosmic-image-label {
        color: #a5b4fc;
        font-size: 0.9rem;
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

    .cosmic-file-upload {
        position: relative;
        padding: 2rem;
        border-radius: 8px;
        background: rgba(20, 20, 36, 0.5);
        border: 2px dashed rgba(102, 126, 234, 0.4);
        transition: all 0.3s ease;
        text-align: center;
    }

    .cosmic-file-upload:hover {
        background: rgba(25, 25, 45, 0.6);
        border-color: #667eea;
    }

    .cosmic-file-icon {
        font-size: 2.5rem;
        color: #667eea;
        margin-bottom: 1rem;
    }

    .cosmic-file-instruction {
        color: #c7d2fe;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .cosmic-file-info {
        color: rgba(200, 200, 255, 0.6);
        font-size: 0.85rem;
        margin-bottom: 0;
    }

    .cosmic-file-input {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
    }

    /* Стили для переключателей */
    .cosmic-switch {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        background: rgba(30, 30, 50, 0.4);
    }

    .cosmic-switch-input {
        width: 48px;
        height: 24px;
        background-color: rgba(102, 126, 234, 0.3);
        border-color: rgba(102, 126, 234, 0.5);
    }

    .cosmic-switch-input:checked {
        background-color: #667eea;
        border-color: #764ba2;
    }

    .cosmic-switch-label {
        color: #c7d2fe;
        font-weight: 500;
    }

    /* Кнопка */
    .cosmic-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-radius: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        position: relative;
        overflow: hidden;
    }

    .cosmic-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
    }

    .cosmic-btn:active {
        transform: translateY(0);
    }

    .cosmic-btn::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        transform: translateX(-100%);
        transition: transform 0.5s ease;
    }

    .cosmic-btn:hover::after {
        transform: translateX(100%);
    }

    /* Ошибки */
    .cosmic-error {
        color: #ff6b6b;
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }

    .needs-validation .cosmic-input:invalid,
    .needs-validation .cosmic-select:invalid {
        border-color: #ff6b6b;
    }

    .needs-validation .cosmic-input:invalid:focus,
    .needs-validation .cosmic-select:invalid:focus {
        border-color: #ff6b6b;
        box-shadow: 0 0 0 0.25rem rgba(255, 107, 107, 0.25);
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

        .cosmic-section {
            padding: 1rem;
        }
    }
</style>