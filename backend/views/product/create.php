<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Product $model */
/** @var array $sizes */
/** @var array $colors */
/** @var array $countries */
/** @var array $materials */
/** @var array $types */

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
    ]) ?>

</div>
