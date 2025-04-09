<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Color $model */

$this->title = 'Добавить новый цвет';
$this->params['breadcrumbs'][] = ['label' => 'Характеристики', 'url' => ['/specification/index']];
$this->params['breadcrumbs'][] = ['label' => 'Цвета', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="color-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
