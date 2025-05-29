<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Product $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description',
            [
                'attribute' => 'img',
                'format' => 'html',
                'value' => function ($model) {
                    if ($model->img && file_exists(Yii::getAlias('@webroot/uploads/product/' . $model->img))) {
                        return Html::img(Yii::getAlias('@web/uploads/product/' . $model->img), [
                            'alt' => 'Изображение товара',
                            'style' => 'width:150px;',
                        ]);
                    }
                    return 'Изображение отсутствует';
                },
            ],
            'price',
            'old_price',
            'quantity',
            'weight',
            [
                'attribute' => 'is_active',
                'value' => function ($model) {
                    return $model->is_active ? 'True' : 'False';
                },
            ],
            [
                'attribute' => 'size',
                'value' => function ($model) {
                    return $model->size ? $model->size->value : 'Размер не указан';
                },
            ],
            [
                'attribute' => 'type_id',
                'value' => function ($model) {
                    return $model->type ? $model->type->name : 'Тип не указан';
                },
            ],
            [
                'attribute' => 'country_id',
                'value' => function ($model) {
                    return $model->country ? $model->country->name : 'Страна не указана';
                },
            ],
            [
                'attribute' => 'color_id',
                'value' => function ($model) {
                    return $model->color ? $model->color->name : 'Цвет не указан';
                },
            ],
            [
                'attribute' => 'material_id',
                'value' => function ($model) {
                    return $model->material ? $model->material->name : 'Материал не указан';
                },
            ],
            [
                'attribute' => 'is_new',
                'value' => function ($model) {
                    return $model->is_new ? 'True' : 'False';
                },
            ],
            [
                'attribute' => 'is_popular',
                'value' => function ($model) {
                    return $model->is_popular ? 'True' : 'False';
                },
            ],
            [
                'label' => 'Дополнительные свойства',
                'format' => 'html',
                'value' => function ($model) {
                    if (!empty($model->propertyValues)) {
                        $result = '<ul>';
                        foreach ($model->propertyValues as $propValue) {
                            $result .= "<li><strong>{$propValue->property->name}:</strong> {$propValue->value}</li>";
                        }
                        $result .= '</ul>';
                        return $result;
                    }
                    return 'Нет дополнительных свойств';
                },
            ],
        ],


    ]) ?>

</div>
