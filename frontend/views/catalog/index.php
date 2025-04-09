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
                        <p class="product-price"><?= Html::encode($product->price) ?> ₽</p>
                        <a href="<?= Url::to(['product/view', 'id' => $product->id]) ?>" class="btn btn-primary">Подробнее</a>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>Товары не найдены.</p>
        <?php } ?>
    </div>
</div>

<style>
    /* Стили для сетки товаров */
    .product-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: space-between;
        margin: 20px 0;
    }

    /* Стили для карточки товара */
    .product-card {
        width: calc(25% - 15px); /* 4 товара в строке с отступами */
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Стили для изображения */
    .product-image img {
        width: 100%;
        height: 200px; /* Фиксированная высота изображения */
        object-fit: cover; /* Со