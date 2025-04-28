<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Property $propertyAll */

$this->title = 'Характеристики';
?>
    <h2><?= Html::encode("Все характеристики") ?></h2>

    <div class="specification-buttons-container">
        <?php foreach ($propertyAll as $property) { ?>

            <?= Html::a($property->name, ['#'], ['class' => 'btn btn-primary']) ?>

        <?php } ?>
    </div>