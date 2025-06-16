<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Order;

/** @var yii\web\View $this */
/** @var backend\models\Order $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'total_price')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList(
        Order::getStatusNames(),
        [
            'prompt' => 'Выберите статус',
            'class' => 'form-control dark-select',
        ]
    ) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'delivery_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<style>
    /* Стили для темного выпадающего списка */
    .dark-select {
        background-color: #343a40; /* Темный фон */
        color: #f8f9fa; /* Светлый текст */
        border-color: #454d55;
    }

    /* Стили для вариантов в выпадающем списке */
    .dark-select option {
        background-color: #343a40;
        color: #f8f9fa;
    }

    /* Стиль при наведении */
    .dark-select option:hover {
        background-color: #495057;
    }

    /* Стиль для выбранного варианта */
    .dark-select option:checked {
        background-color: #495057;
    }
</style>