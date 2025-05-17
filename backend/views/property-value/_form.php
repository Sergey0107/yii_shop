<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PropertyValue $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="property-value-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'property_id')->textInput() ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
