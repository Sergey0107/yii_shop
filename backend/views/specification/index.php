<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var array $specifications */

$this->title = 'Характеристики';
?>
    <h2><?= Html::encode("Все характеристики") ?></h2>

    <div class="specification-buttons-container">
        <?php foreach ($specifications as $name => $action) { ?>

                <?= Html::a($name, [$action], ['class' => 'btn btn-primary']) ?>

        <?php } ?>
    </div>