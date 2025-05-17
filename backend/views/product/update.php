<?php

use backend\models\ProductProperty;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Product $model */
/** @var array $sizes */
/** @var array $colors */
/** @var array $countries */
/** @var array $materials */
/** @var array $types */
/** @var backend\models\Property[] $properties */
/** @var ProductProperty $currentProperties */

$this->title = 'Редактировать товар: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="product-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'sizes' => $sizes,
        'countries' => $countries,
        'colors' => $colors,
        'types' => $types,
        'materials' => $materials,
        'properties' => $properties,         // <-- ДОЛЖНО БЫТЬ ЭТО
        'currentProperties' => $currentProperties,
    ]) ?>

</div>
