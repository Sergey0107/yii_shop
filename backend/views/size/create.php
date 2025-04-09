<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Size $model */

$this->title = 'Добавить размер';
$this->params['breadcrumbs'][] = ['label' => 'Размеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="size-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
