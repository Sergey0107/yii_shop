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
                    <div class="product-list">
                        <?php foreach ($orderProducts as $orderProduct): ?>
                            <div class="product-card">
                                <div class="product-image">
                                    <?php if ($orderProduct->product->img): ?>
                                        <img src="<?= $backendUploads->baseUrl ?>/product/<?= $orderProduct->product->img ?>" alt="<?= Html::encode($orderProduct->product->name) ?>" loading="lazy">
                                    <?php else: ?>
                                        <img src="<?= $backendUploads->baseUrl ?>/product/no-image.png" alt="No Image" loading="lazy">
                                    <?php endif; ?>
                                </div>

                                <div class="product-details">
                                    <h3 class="product-title"><?= Html::encode($orderProduct->product->name) ?></h3>
                                    <div class="product-price"><?= Yii::$app->formatter->asDecimal($orderProduct->product->price) ?> ₽</div>
                                    <div class="product-quantity">Количество: <?= $orderProduct->quantity ?> шт.</div>
                                </div>

                                <div class="product-actions">
                                    <div class="product-total"><?= Yii::$app->formatter->asDecimal($orderProduct->product->price * $orderProduct->quantity) ?> ₽</div>
                                    <meta name="csrf-token" content="<?= Yii::$app->request->csrfToken ?>">
                                    <button class="product-remove" data-order-product-id="<?= $orderProduct->id ?>">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Правая колонка - карта -->
                <div class="map-section">
                    <div class="map-container" id="pickupMap" data-points='<?= json_encode($pickupPoints) ?>'>
                        <div class="map-placeholder">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 12C13.6569 12 15 10.6569 15 9C15 7.34315 13.6569 6 12 6C10.3431 6 9 7.34315 9 9C9 10.6569 10.3431 12 12 12Z" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 2C8.13 2 5 5.13 5 9C5 14.25 12 22 12 22C12 22 19 14.25 19 9C19 5.13 15.87 2 12 2Z" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <p>Выберите пункт выдачи на карте</p>
                        </div>
                    </div>
                    <div class="pickup-points">
                        <h3>Пункты выдачи</h3>
                        <div class="points-list">
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
                </div>
            </div>

            <!-- Форма заказа -->
            <div class="order-form">
                <div class="order-summary">
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
                        <span>Итого</span>
                        <span><?= Yii::$app->formatter->asDecimal($order->total_price) ?> ₽</span>
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
        <?php else: ?>
            <div class="empty-cart">
                <div class="empty-content">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 5H5L5.4 7M7 15H17L21 5H5.4M7 15L5.4 5M7 15L4.70711 17.2929C4.07714 17.9229 4.52331 19 5.41421 19H17M17 19C15.8954 19 15 19.8954 15 21C15 22.1046 15.8954 23 17 23C18.1046 23 19 22.1046 19 21C19 19.8954 18.1046 19 17 19ZM9 21C9 22.1046 8.10457 23 7 23C5.89543 23 5 22.1046 5 21C5 19.8954 5.89543 19 7 19C8.10457 19 9 19.8954 9 21Z" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <h3>Ваша корзина пуста</h3>
                    <p>Добавьте товары, чтобы продолжить покупки</p>
                    <a href="<?= Url::to(['catalog/index']) ?>" class="btn-continue">
                        Продолжить покупки
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    window.points = <?= json_encode($pickupPoints) ?>;
</script>

<script src="https://api-maps.yandex.ru/2.1/?apikey=YOUR_API_KEY&lang=ru_RU" type="text/javascript"></script>
