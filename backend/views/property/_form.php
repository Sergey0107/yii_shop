<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Property $model */
/** @var yii\widgets\ActiveForm $form */

$this->registerCss("
    .property-form {
        background: linear-gradient(135deg, #0c0c0c 0%, #1a1a2e 100%);
        border: 1px solid #16213e;
        border-radius: 12px;
        padding: 40px;
        margin: 20px 0;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
        color: #e2e8f0;
        max-width: 600px;
        margin: 20px auto;
    }

    .cosmic-form .form-group {
        margin-bottom: 24px;
    }

    .cosmic-form label {
        color: #cbd5e0;
        font-weight: 500;
        margin-bottom: 8px;
        display: block;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .cosmic-form .form-control {
        background: rgba(16, 20, 43, 0.8);
        border: 1px solid #2d3748;
        border-radius: 8px;
        color: #e2e8f0;
        padding: 12px 16px;
        font-size: 16px;
        transition: all 0.2s ease;
    }

    .cosmic-form .form-control:focus {
        background: rgba(26, 32, 64, 0.9);
        border-color: #4299e1;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
        outline: none;
        color: #ffffff;
    }

    .cosmic-form .form-control::placeholder {
        color: #718096;
    }

    .cosmic-btn {
        background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
        border: 1px solid #4a5568;
        color: #e2e8f0;
        padding: 12px 32px;
        border-radius: 8px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 14px;
    }

    .cosmic-btn:hover {
        background: linear-gradient(135deg, #4a5568 0%, #718096 100%);
        border-color: #718096;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .cosmic-btn:active {
        transform: translateY(0);
    }

    .cosmic-btn.btn-success {
        background: linear-gradient(135deg, #2d5a27 0%, #38a169 100%);
        border-color: #38a169;
    }

    .cosmic-btn.btn-success:hover {
        background: linear-gradient(135deg, #38a169 0%, #48bb78 100%);
        border-color: #48bb78;
    }

    .form-group:last-child {
        margin-bottom: 0;
        margin-top: 32px;
        text-align: center;
    }

    .help-block {
        color: #f56565;
        font-size: 12px;
        margin-top: 4px;
    }

    .has-error .form-control {
        border-color: #f56565;
        background: rgba(245, 101, 101, 0.1);
    }
");
?>

<div class="property-form cosmic-form">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'cosmic-form']
    ]); ?>

    <?= $form->field($model, 'name')->textInput([
        'maxlength' => true,
        'class' => 'form-control',
        'placeholder' => 'Введите название свойства'
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'cosmic-btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>