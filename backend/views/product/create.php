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

$this->title = 'Добавить товар';
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'sizes' => $sizes,
        'colors' => $colors,
        'countries' => $countries,
        'materials' => $materials,
        'types' => $types,
        'properties' => $properties,
        'currentProperties' => $currentProperties,
    ]) ?>

</div>
