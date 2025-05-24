<?php
/** @var yii\web\View $this */
/** @var backend\models\Order $order */
/** @var backend\models\OrderProducts[] $orderProducts */
/** @var array $pickupPoints */

use frontend\assets\CartAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\BackendAsset;

$backendUploads = BackendAsset::register($this);
CartAsset::register($this);
$this->title = 'Корзина';
?>
<div class="cart-page">
    <div class="container">
        <h1 class="page-title"><?= Html::encode($this->title) ?></h1>

        <?php if ($order): ?>
            <div class="cart-layout">
                <!-- Левая колонка - товары -->
                <div class="cart-products">
                    <div class="product-list-container">
                        <div class="product-list-header">
                            <h3>Ваши товары</h3>
                            <span class="items-count"><?= count($orderProducts) ?> товара</span>
                        </div>
                        <div class="product-list-scrollable">
                            <?php foreach ($orderProducts as $orderProduct): ?>
                                <div class="product-card" style="--card-accent: <?= sprintf('#%06X', mt_rand(0, 0xFFFFFF)) ?>">
                                    <div class="product-image">
                                        <?php if ($orderProduct->product->img): ?>
                                            <img src="<?= $backendUploads->baseUrl ?>/product/<?= $orderProduct->product->img ?>" alt="<?= Html::encode($orderProduct->product->name) ?>" loading="lazy">
                                        <?php else: ?>
                                            <img src="<?= $backendUploads->baseUrl ?>/product/no-image.png" alt="No Image" loading="lazy">
                                        <?php endif; ?>
                                        <div class="product-image-overlay"></div>
                                    </div>

                                    <div class="product-details">
                                        <div class="product-header">
                                            <h3 class="product-title"><?= Html::encode($orderProduct->product->name) ?></h3>
                                            <div class="product-actions">
                                                <button class="product-remove" data-order-product-id="<?= $orderProduct->id ?>">
                                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                                        <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="product-meta-wrapper">
                                            <div class="product-meta">
                                <span class="product-price" data-price="<?= $orderProduct->product->price ?>">
                                    <?= Yii::$app->formatter->asDecimal($orderProduct->product->price) ?> ₽
                                </span>
                                                <div class="quantity-controls">
                                                    <button class="quantity-btn minus" data-order-product-id="<?= $orderProduct->id ?>">
                                                        <svg width="14" height="2" viewBox="0 0 14 2"><path d="M1 1h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                                    </button>
                                                    <span class="product-quantity"><?= $orderProduct->quantity ?></span>
                                                    <button class="quantity-btn plus" data-order-product-id="<?= $orderProduct->id ?>">
                                                        <svg width="14" height="14" viewBox="0 0 14 14"><path d="M7 1v12M1 7h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="product-total">
                                                <?= Yii::$app->formatter->asDecimal($orderProduct->product->price * $orderProduct->quantity) ?> ₽
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Правая колонка - оформление -->
                <div class="order-section">
                    <div class="order-summary-card">
                        <h3>Итого</h3>

                        <div class="summary-details">
                            <div class="summary-row">
                                <span>Товары (<?= count($orderProducts) ?>)</span>
                                <span><?= Yii::$app->formatter->asDecimal($order->total_price) ?> ₽</span>
                            </div>
                            <div class="summary-row">
                                <span>Доставка</span>
                                <span>Бесплатно</span>
                            </div>
                            <div class="summary-divider"></div>
                            <div class="summary-row total">
                                <span>К оплате</span>
                                <span><?= Yii::$app->formatter->asDecimal($order->total_price) ?> ₽</span>
                            </div>
                        </div>

                        <div class="pickup-section">
                            <h4>Пункт выдачи</h4>
                            <div class="map-container" id="pickupMap" data-points='<?= json_encode($pickupPoints) ?>'>
                                <div class="map-placeholder">
                                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 12C13.6569 12 15 10.6569 15 9C15 7.34315 13.6569 6 12 6C10.3431 6 9 7.34315 9 9C9 10.6569 10.3431 12 12 12Z" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12 2C8.13 2 5 5.13 5 9C5 14.25 12 22 12 22C12 22 19 14.25 19 9C19 5.13 15.87 2 12 2Z" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <p>Выберите пункт выдачи на карте</p>
                                </div>
                            </div>
                            <div class="points-list-container">
                                <?php foreach ($pickupPoints as $point): ?>
                                    <div class="point-item" data-lat="<?= $point['lat'] ?>" data-lng="<?= $point['lng'] ?>">
                                        <input type="radio" name="pickup_point" id="point-<?= $point['id'] ?>" value="<?= $point['id'] ?>">
                                        <label for="point-<?= $point['id'] ?>">
                                            <strong><?= Html::encode($point['name']) ?></strong>
                                            <span><?= Html::encode($point['address']) ?></span>
                                            <small><?= Html::encode($point['hours']) ?></small>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="form-fields">
                            <div class="form-group">
                                <input type="tel" id="phone" name="phone" class="form-input" placeholder="Телефон" required>
                            </div>
                            <div class="form-group">
                                <input type="email" id="email" name="email" class="form-input" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <textarea id="comment" name="comment" class="form-input" placeholder="Комментарий к заказу"></textarea>
                            </div>
                        </div>

                        <div class="form-actions">
                            <meta name="csrf-token" content="<?= Yii::$app->request->csrfToken ?>">
                            <button class="btn-checkout" id="submitOrder">
                                Оформить заказ
                            </button>
                            <button class="btn-clear" id="clearCart">
                                Очистить корзину
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- ... существующий код для пустой корзины ... -->
        <?php endif; ?>
    </div>
</div>

<script>
    window.points = <?= json_encode($pickupPoints) ?>;
</script>

<script src="https://api-maps.yandex.ru/2.1/?apikey=YOUR_API_KEY&lang=ru_RU" type="text/javascript"></script>
<style>
    /* Новые стили для улучшенного дизайна */
    .product-list-container {
        background: transparent;
        border-radius: 12px;
        overflow: hidden;
    }

    .product-card {
        display: flex;
        width: 100%;
        background: white;
        margin-bottom: 16px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 30px rgba(0, 0, 0, 0.1);
    }

    .product-image {
        width: 120px;
        height: 120px;
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-image img {
        transform: scale(1.05);
    }

    .product-image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(var(--card-accent-rgb), 0.1) 0%, rgba(var(--card-accent-rgb), 0.05) 100%);
    }

    .product-details {
        flex: 1;
        padding: 16px;
        display: flex;
        flex-direction: column;
    }

    .product-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }

    .product-title {
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
        color: #1a1a1a;
        flex: 1;
        padding-right: 10px;
    }

    .product-meta-wrapper {
        margin-top: auto;
    }

    .product-meta {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 8px;
    }

    .product-price {
        font-weight: 700;
        font-size: 1rem;
        color: var(--card-accent);
        min-width: 80px;
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        background: #f8fafc;
        border-radius: 8px;
        padding: 4px;
        border: 1px solid #e2e8f0;
    }

    .quantity-btn {
        width: 28px;
        height: 28px;
        border: none;
        background: white;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        color: var(--card-accent);
    }

    .quantity-btn:hover {
        background: rgba(var(--card-accent-rgb), 0.1);
    }

    .quantity-btn svg {
        transition: transform 0.2s ease;
    }

    .quantity-btn:active svg {
        transform: scale(0.9);
    }

    .product-quantity {
        min-width: 30px;
        text-align: center;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .product-total {
        font-weight: 700;
        font-size: 1.1rem;
        color: #1a1a1a;
        text-align: right;
        padding-top: 8px;
        border-top: 1px dashed #e2e8f0;
    }

    .product-actions {
        margin-left: auto;
    }

    .product-remove {
        background: none;
        border: none;
        padding: 4px;
        cursor: pointer;
        color: #94a3b8;
        transition: all 0.2s ease;
    }

    .product-remove:hover {
        color: #ef4444;
        transform: rotate(90deg);
    }

    /* Анимации */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .product-card {
        animation: fadeIn 0.4s ease forwards;
    }

    /* Для работы с CSS переменными */
    .product-card {
        --card-accent-rgb: <?= mt_rand(50, 200) ?>, <?= mt_rand(50, 200) ?>, <?= mt_rand(50, 200) ?>;
    }
</style>