<?php
/** @var yii\web\View $this */
/** @var backend\models\Order $order */
/** @var backend\models\OrderProducts[] $orderProducts */
/** @var backend\models\City[] $cities */
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

                <div class="order-section">
                    <div class="order-summary-card">
                        <h3>Итого</h3>

                        <div class="summary-details">
                            <div class="summary-row">
                                <span>Товары (<?= ($order->getCountProducts()) ?>)</span>
                                <span><?= Yii::$app->formatter->asInteger($order->total_price) ?> ₽</span>
                            </div>
                            <div class="summary-row-delivery">
                                <span>Доставка</span>
                                <span class="delivery-price" data-delivery-cost="<?= $order->delivery_price ?>">
                                    <?php if ($order->delivery_price > 0): ?>
                                        <?= Yii::$app->formatter->asInteger($order->delivery_price) ?> ₽
                                    <?php else: ?>
                                        Бесплатно
                                    <?php endif; ?>
                                </span>
                            </div>
                            <div class="summary-divider"></div>
                            <div class="summary-row total">
                                <span>К оплате</span>
                                <span><?= Yii::$app->formatter->asInteger($order->total_price) ?> ₽</span>
                            </div>
                        </div>
                        <div class="delivery-method">
                            <h4>Способ доставки</h4>
                            <div class="delivery-options">
                                <label class="delivery-option">
                                    <input type="radio" name="delivery_method" value="1" checked>
                                    <span>Самовывоз</span>
                                </label>
                                <label class="delivery-option">
                                    <input type="radio" name="delivery_method" value="2">
                                    <span>Доставка курьером</span>
                                </label>
                            </div>
                            <div class="delivery-address" id="courierAddress" style="display: none;">
                                <div class="form-group">
                                    <input type="text" id="city" name="city" class="form-input" placeholder="Город" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" id="street" name="street" class="form-input" placeholder="Улица" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" id="house" name="house" class="form-input" placeholder="Дом" required>
                                </div>
                            </div>
                        </div>
                        <div class="pickup-section">
                            <h4>Пункт выдачи</h4>
                            <div class="form-group">
                                <select id="city-select" class="form-select">
                                    <option value="">Выберите город</option>
                                    <?php foreach ($cities as $city): ?>
                                        <option value="<?= $city->city_code ?>"><?= Html::encode($city->name) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
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
                                    <div id="pickupPoint"
                                         class="point-item js-pickup-point"
                                         data-lat="<?= $point['lat'] ?>"
                                         data-lng="<?= $point['lng'] ?>"
                                         data-id="<?= $point['id'] ?>"
                                         data-name="<?= Html::encode($point['name']) ?>"
                                         data-address="<?= Html::encode($point['address']) ?>"
                                         data-hours="<?= Html::encode($point['hours']) ?>">
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
                        <div class="payment-method">
                            <h4>Способ оплаты</h4>
                            <div class="payment-options">
                                <label class="payment-option">
                                    <input type="radio" name="payment_method" value="1" checked>
                                    <div class="payment-content">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M17 9V7C17 5.89543 16.1046 5 15 5H5C3.89543 5 3 5.89543 3 7V13C3 14.1046 3.89543 15 5 15H7M9 19H19C20.1046 19 21 18.1046 21 17V11C21 9.89543 20.1046 9 19 9H9C7.89543 9 7 9.89543 7 11V17C7 18.1046 7.89543 19 9 19Z" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M12 14C13.1046 14 14 13.1046 14 12C14 10.8954 13.1046 10 12 10C10.8954 10 10 10.8954 10 12C10 13.1046 10.8954 14 12 14Z" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span>Наличными при получении</span>
                                    </div>
                                </label>
                                <label class="payment-option">
                                    <input type="radio" name="payment_method" value="2">
                                    <div class="payment-content">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3 10H21M7 15H8M12 15H13M6 19H18C19.6569 19 21 17.6569 21 16V8C21 6.34315 19.6569 5 18 5H6C4.34315 5 3 6.34315 3 8V16C3 17.6569 4.34315 19 6 19Z" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span>Картой Сбербанка</span>
                                    </div>
                                </label>
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
        <?php endif; ?>
    </div>
</div>

<script>
    window.points = <?= json_encode($pickupPoints) ?>;
</script>

<script src="https://api-maps.yandex.ru/2.1/?apikey=YOUR_API_KEY&lang=ru_RU" type="text/javascript"></script>
<style>

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

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .product-card {
        animation: fadeIn 0.4s ease forwards;
    }

    .product-card {
        --card-accent-rgb: <?= mt_rand(50, 200) ?>, <?= mt_rand(50, 200) ?>, <?= mt_rand(50, 200) ?>;
    }

    .delivery-method {
        margin-bottom: 20px;
    }

    .delivery-options {
        display: flex;
        gap: 15px;
        margin: 10px 0;
    }

    .delivery-option {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        transition: all 0.2s ease;
    }

    .delivery-option:hover {
        border-color: var(--primary);
    }

    .delivery-option input[type="radio"] {
        margin: 0;
    }

    .delivery-address {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px dashed var(--border-color);
    }

    .payment-method {
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px dashed #e2e8f0;
    }

    .payment-options {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 10px;
    }

    .payment-option {
        display: flex;
        align-items: center;
        cursor: pointer;
        padding: 12px 16px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
        background: white;
    }

    .payment-option:hover {
        border-color: #4f46e5;
        box-shadow: 0 2px 8px rgba(79, 70, 229, 0.1);
    }

    .payment-option input[type="radio"] {
        margin-right: 12px;
    }

    .payment-content {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
    }

    .payment-content svg {
        flex-shrink: 0;
        color: #4f46e5;
    }

    .payment-option input[type="radio"]:checked + .payment-content {
        font-weight: 600;
    }

    .payment-option input[type="radio"]:checked ~ .payment-content svg {
        color: #4f46e5;
    }

    @keyframes paymentPulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.02); }
        100% { transform: scale(1); }
    }

    .payment-option input[type="radio"]:checked + .payment-content {
        animation: paymentPulse 0.3s ease;
    }

    @keyframes paymentPulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.02); }
        100% { transform: scale(1); }
    }

    .payment-option input[type="radio"]:checked + .payment-content {
        animation: paymentPulse 0.3s ease;
    }

    .notification {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        width: calc(100% - 40px);
        max-width: 500px;
        padding: 0;
        border-radius: 8px;
        color: white;
        z-index: 1000;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        opacity: 0;
        transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .notification-content {
        display: flex;
        align-items: center;
        padding: 16px 20px;
        gap: 12px;
    }

    .notification.success {
        background: #4CAF50;
    }

    .notification.error {
        background: #F44336;
    }

    .notification-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 24px;
        height: 24px;
    }

    .notification-icon svg {
        width: 100%;
        height: 100%;
    }

    .notification-text {
        flex: 1;
        font-size: 15px;
        line-height: 1.4;
    }

    .notification-close {
        background: transparent;
        border: none;
        padding: 4px;
        margin-left: 8px;
        cursor: pointer;
        color: rgba(255, 255, 255, 0.8);
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .notification-close:hover {
        color: white;
        transform: rotate(90deg);
    }

    .notification-close svg {
        width: 16px;
        height: 16px;
    }

    .notification.slide-up {
        transform: translateX(-50%) translateY(100px);
        opacity: 0;
    }

    .notification:not(.slide-up) {
        transform: translateX(-50%) translateY(0);
        opacity: 1;
    }

    .notification.slide-down {
        transform: translateX(-50%) translateY(100px);
        opacity: 0;
    }

    @media (max-width: 600px) {
        .notification {
            width: calc(100% - 20px);
            bottom: 10px;
        }
    }

    .city-select-container {
        margin-bottom: 15px;
    }

    .form-select {
        display: block;
        width: 100%;
        padding: 10px 15px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #fff;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 16px;
    }

    .form-select:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2);
    }
</style>