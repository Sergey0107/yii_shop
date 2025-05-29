<?php

use common\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- Поле для имени пользователя -->
    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <!-- Поле для email -->
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <!-- Поле для пароля -->
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->hint('Введите пароль') ?>

    <!-- Поле для статуса -->
    <?= $form->field($model, 'status')->dropDownList([
        User::STATUS_ACTIVE => 'Активен',
        User::STATUS_INACTIVE => 'Неактивен',
        User::STATUS_DELETED => 'Удален',
    ], ['prompt' => 'Выберите статус']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>