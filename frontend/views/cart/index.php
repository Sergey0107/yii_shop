<?php

/** @var yii\web\View $this */
/** @var backend\models\Order $order */
/** @var backend\models\OrderProducts[] $orderProducts */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\BackendAsset;

$backendUploads = BackendAsset::register($this);
$this->title = 'Корзина';
?>
<div class="cart-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($order): ?>
        <div class="order-summary">
            <h2>Информация о заказе</h2>
            <p><strong>Номер заказа:</strong> <?= $order->id ?></p>
            <p><strong>Общая стоимость:</strong> <?= $order->total_price ?> ₽</p>
        </div>

        <div class="order-products">
            <h2>Товары в заказе</h2>
            <?php if ($orderProducts): ?>
                <div class="product-grid">
                    <?php foreach ($orderProducts as $index => $orderProduct): ?>
                        <div class="product-card">
                            <div class="product-image">
                                <?php if ($orderProduct->product->img): ?>
                                    <img src="<?= $backendUploads->baseUrl ?>/product/<?= $orderProduct->product->img ?>" alt="<?= Html::encode($orderProduct->product->name) ?>">
                                <?php else: ?>
                                    <img src="<?= Url::to('@web/uploads/no-image.png') ?>" alt="No Image">
                                <?php endif; ?>
                            </div>
                            <div class="product-info">
                                <h3 class="product-title"><?= Html::encode($orderProduct->product->name) ?></h3>
                                <div class="product-price-block">
                                    <span class="product-price"><?= $orderProduct->product->price ?> ₽</span>
                                </div>
                            </div>
                            <div class="product-actions">
                                <button class="btn-1 btn-minus" data-product-id="<?= $orderProduct->id ?>">−</button>
                                <span class="quantity"><?= $orderProduct->quantity ?></span>
                                <button class="btn-1 btn-plus" data-product-id="<?= $orderProduct->id ?>">+</button>
                                <button class="btn-1 btn-remove" data-product-id="<?= $orderProduct->id ?>">×</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>В заказе пока нет товаров.</p>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <p>У вас пока нет активных заказов.</p>
    <?php endif; ?>
</div>

<style>

    .cart-index {
        background-color: #f8f9fa;
        padding: 40px 20px;
        text-align: center;
    }

    /* Информация о заказе */
    .order-summary {
        margin-bottom: 40px;
        text-align: left;
    }

    .order-summary h2 {
        font-size: 24px;
        color: #343a40;
        margin-bottom: 15px;
    }

    .order-summary p {
        font-size: 16px;
        color: #555;
        margin: 5px 0;
    }

    /* Сетка товаров */
    .product-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: space-between;
    }

    /* Карточка товара */
    .product-card {
        display: flex;
        align-items: center;
        width: calc(100% - 20px);
        max-width: 600px;
        background-color: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.06);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    /* Изображение товара */
    .product-image img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-right: 1px solid rgba(0, 0, 0, 0.08);
    }

    /* Информация о товаре */
    .product-info {
        flex: 1;
        padding: 15px;
        text-align: left;
    }

    .product-title {
        font-size: 18px;
        margin: 0 0 10px;
        color: #343a40;
        word-wrap: break-word;
    }

    .product-price-block {
        background-color: #f8f9fa;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding: 5px 10px;
        margin-bottom: 10px;
    }

    .product-price {
        font-size: 16px;
        font-weight: bold;
        color: #0d6efd;
    }

    /* Действия с товаром */
    .product-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px;
        border-left: 1px solid rgba(0, 0, 0, 0.08);
    }

    .btn-1 {
        background-color: #17a2b8;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.2s ease;
    }

    .btn-1:hover {
        background-color: #138496;
    }

    .btn-remove {
        background-color: #dc3545;
    }

    .btn-remove:hover {
        background-color: #b02a37;
    }

    .quantity {
        font-size: 16px;
        font-weight: bold;
        color: #343a40;
    }

    /* Адаптивность */
    @media (max-width: 768px) {
        .product-card {
            flex-direction: column;
            width: 100%;
        }

        .product-image img {
            width: 100%;
            height: auto;
            border-right: none;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        }

        .product-actions {
            flex-direction: row;
            justify-content: space-between;
            border-left: none;
        }
    }
</style>

<script>
    // Обработчики для кнопок "Плюс", "Минус" и "Удалить"
    document.addEventListener('DOMContentLoaded', function () {
        const minusButtons = document.querySelectorAll('.btn-minus');
        const plusButtons = document.querySelectorAll('.btn-plus');
        const removeButtons = document.querySelectorAll('.btn-remove');

        minusButtons.forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.dataset.productId;
                updateQuantity(productId, -1);
            });
        });

        plusButtons.forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.dataset.productId;
                updateQuantity(productId, 1);
            });
        });

        removeButtons.forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.dataset.productId;
                removeProduct(productId);
            });
        });

        function updateQuantity(productId, delta) {
            console.log(`Обновление количества товара ${productId} на ${delta}`);
            // Здесь можно добавить AJAX-запрос для обновления количества в базе данных
        }

        function removeProduct(productId) {
            console.log(`Удаление товара ${productId}`);
            // Здесь можно добавить AJAX-запрос для удаления товара из базы данных
        }
    });
</script>