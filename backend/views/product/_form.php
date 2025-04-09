<?php

use backend\models\Size;
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

?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    <!-- Поле вывода изображения -->
    <div class="form-group">
        <?php if ($model->img && file_exists(Yii::getAlias('@webroot/uploads/product/' . $model->img))) : ?>
            <label>Изображение:</label>
            <div>
                <?= Html::img(
                    Yii::getAlias('@web/uploads/product/' . $model->img),
                    [
                        'alt' => 'Изображение товара',
                        'style' => 'max-width: 200px; margin-bottom: 10px;',
                    ]
                ) ?>
            </div>
        <?php else : ?>
            <p>Изображение не загружено.</p>
        <?php endif; ?>
    </div>

    <?= $form->field($model, 'imageFile')->fileInput()->label('') ?> <!-- Поле для загрузки изображения -->

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <?= $form->field($model, 'size_id')->dropDownList(
        $sizes,
        ['prompt' => 'Выберите размер']
    ) ?>

    <?= $form->field($model, 'type_id')->dropDownList(
        $types,
        ['prompt' => 'Выберите тип']
    ) ?>

    <?= $form->field($model, 'country_id')->dropDownList(
        $countries,
        ['prompt' => 'Выберите страну']
    ) ?>

    <?= $form->field($model, 'color_id')->dropDownList(
        $colors,
        ['prompt' => 'Выберите цвет']
    ) ?>

    <?= $form->field($model, 'material_id')->dropDownList(
        $materials,
        ['prompt' => 'Выберите материал']
    ) ?>

    <?= $form->field($model, 'is_new')->checkbox() ?>
    <?= $form->field($model, 'is_popular')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
