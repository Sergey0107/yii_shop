<?php

use yii\helpers\Html;
use frontend\assets\BackendAsset;

$backendUploads = BackendAsset::register($this);

/** @var \yii\web\View $this */
/** @var backend\models\Product $product */

$this->title = $product->name;
?>

<div class="product-page">
    <div class="product-container">

        <div class="product-image">
            <?php if ($product->img) { ?>
                <img src="<?= $backendUploads->baseUrl ?>/product/<?= $product->img ?>" alt="<?= Html::encode($product->name) ?>">
            <?php } else { ?>
                <img src="<?= $backendUploads->baseUrl ?>/product/no-image.png" alt="No Image">
            <?php } ?>
        </div>


        <div class="product-info">
            <h1><?= Html::encode($product->name) ?></h1>

            <div class="product-price">
                <span class="price-label">Цена:</span>
                <span class="price-value"><?= Html::encode($product->price) ?> ₽</span>
            </div>

            <div class="product-details">
                <div class="detail-row">
                    <span class="detail-key">Наличие</span>
                    <span class="detail-value <?= $product->quantity > 0 ? 'in-stock' : 'out-of-stock' ?>">
                        <?= Html::encode($product->quantity > 0 ? 'В наличии' : 'Нет в наличии') ?>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Размер</span>
                    <span class="detail-value"><?= Html::encode($product->size->value . ' м' ?? 'Не указано') ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Тип</span>
                    <span class="detail-value"><?= Html::encode($product->type->name ?? 'Не указано') ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Страна</span>
                    <span class="detail-value"><?= Html::encode($product->country->name ?? 'Не указано') ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Материал</span>
                    <span class="detail-value"><?= Html::encode($product->material->name ?? 'Не указано') ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Цвет</span>
                    <span class="detail-value"><?= Html::encode($product->color->name ?? 'Не указано') ?></span>
                </div>
            </div>

            <div class="product-actions">
                <?= Html::a('В корзину', ['/cart/add', 'id' => $product->id], [
                    'class' => 'btn btn-primary',
                    'data-method' => 'post',
                ]) ?>
            </div>
        </div>
    </div>


    <div class="product-description">
        <h2>Описание товара</h2>
        <p><?= Html::encode($product->description ?? 'Нет описания') ?></p>
    </div>
</div>

<style>
    .product-page {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 40px 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .product-container {
        display: flex;
        gap: 40px;
        margin-bottom: 40px;
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
    }

    .product-image {
        flex: 0 0 450px;
        position: relative;
    }

    .product-image img {
        width: 100%;
        height: 450px;
        object-fit: cover;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: #fff;
    }

    .product-image img:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
    }

    .product-info {
        flex: 1;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .product-info h1 {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 25px;
        color: #1e40af;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .product-price {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 30px;
        padding: 20px;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border-radius: 15px;
        color: white;
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
    }

    .price-label {
        font-size: 18px;
        font-weight: 500;
    }

    .price-value {
        font-size: 28px;
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .product-details {
        margin-bottom: 35px;
        background: rgba(241, 245, 249, 0.7);
        padding: 25px;
        border-radius: 15px;
        border: 1px solid rgba(148, 163, 184, 0.2);
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid rgba(148, 163, 184, 0.2);
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-key {
        font-weight: 600;
        color: #1e40af;
        font-size: 16px;
        flex: 0 0 120px;
    }

    .detail-value {
        color: #374151;
        font-weight: 500;
        text-align: right;
        flex: 1;
        font-size: 16px;
    }

    .detail-value.in-stock {
        color: #059669;
        font-weight: 600;
    }

    .detail-value.out-of-stock {
        color: #dc2626;
        font-weight: 600;
    }

    .product-actions {
        text-align: center;
    }

    .product-actions .btn-primary {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border: none;
        padding: 18px 40px;
        border-radius: 50px;
        font-size: 18px;
        font-weight: 600;
        color: white;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .product-actions .btn-primary:hover {
        background: linear-gradient(135deg, #1d4ed8, #1e3a8a);
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(59, 130, 246, 0.4);
        color: white;
        text-decoration: none;
    }

    .product-description {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        max-width: 1200px;
        margin: 0 auto;
    }

    .product-description h2 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #1e40af;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .product-description p {
        font-size: 18px;
        color: #374151;
        line-height: 1.8;
        font-weight: 400;
    }

    /* Адаптивность */
    @media (max-width: 768px) {
        .product-page {
            padding: 20px 15px;
        }

        .product-container {
            flex-direction: column;
            gap: 30px;
        }

        .product-image {
            flex: none;
        }

        .product-image img {
            height: 300px;
        }

        .product-info {
            padding: 30px 25px;
        }

        .product-info h1 {
            font-size: 26px;
        }

        .price-value {
            font-size: 24px;
        }

        .product-description {
            padding: 30px 25px;
        }

        .product-description h2 {
            font-size: 24px;
        }

        .detail-key {
            flex: 0 0 100px;
            font-size: 14px;
        }

        .detail-value {
            font-size: 14px;
        }
    }

    @media (max-width: 480px) {
        .product-actions .btn-primary {
            padding: 15px 30px;
            font-size: 16px;
        }

        .detail-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .detail-value {
            text-align: left;
        }
    }
</style>