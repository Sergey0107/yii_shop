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
                                        <div class="product-meta">
                                            <span class="product-price"><?= Yii::$app->formatter->asDecimal($orderProduct->product->price) ?> ₽</span>
                                            <span class="product-quantity">× <?= $orderProduct->quantity ?> шт.</span>
                                        </div>
                                        <div class="product-total"><?= Yii::$app->formatter->asDecimal($orderProduct->product->price * $orderProduct->quantity) ?> ₽</div>
                                    </div>

                                    <div class="product-actions">
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
