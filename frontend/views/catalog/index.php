<?php

/** @var yii\web\View $this */
/** @var Product[] $products */

use backend\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\BackendAsset;

$backendUploads = BackendAsset::register($this);

$this->title = 'Каталог';
?>
<div class="site-index">
    <div class="product-grid">
        <?php if ($products) { ?>
            <?php foreach ($products as $product) { ?>
                <a href="<?= Url::to(['catalog/card', 'id' => $product->id]) ?>" class="product-card-link">
                    <div class="product-card">
                        <div class="product-image">
                            <?php if ($product->img) { ?>
                                <img src="<?= $backendUploads->baseUrl ?>/product/<?= $product->img ?>" alt="<?= Html::encode($product->name) ?>">
                            <?php } else { ?>
                                <img src="<?= $backendUploads->baseUrl ?>/product/no-image.png" alt="No Image">
                            <?php } ?>
                        </div>
                        <div class="product-info">
                            <h3 class="product-title"><?= Html::encode($product->name) ?></h3>
                            <div class="product-price-block">
                                <span class="product-price"><?= Html::encode($product->price) ?> ₽</span>
                            </div>
                            <button class="btn btn-cart">В корзину</button>
                        </div>
                    </div>
                </a>
            <?php } ?>
        <?php } else { ?>
            <p>Товары не найдены.</p>
        <?php } ?>
    </div>
</div>
