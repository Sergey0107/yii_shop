<?php
/** @var yii\web\View $this */
/** @var backend\models\Order $order */
/** @var backend\models\OrderProducts[] $orderProducts */
/** @var array $pickupPoints */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\BackendAsset;

$backendUploads = BackendAsset::register($this);
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
                                    <button class="product-remove" data-product-id="<?= $orderProduct->id ?>">
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
                    <div class="map-container" id="pickupMap">
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

<style>
    :root {
        --primary: #4f46e5;
        --primary-light: #6366f1;
        --primary-dark: #4338ca;
        --danger: #ef4444;
        --success: #10b981;
        --warning: #f59e0b;
        --gray: #9ca3af;
        --gray-light: #e5e7eb;
        --gray-lighter: #f3f4f6;
        --dark: #1f2937;
        --radius: 8px;
        --shadow: 0 1px 3px rgba(0,0,0,0.1);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
        --transition: all 0.2s ease;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        color: var(--dark);
        line-height: 1.5;
        background-color: #f9fafb;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .page-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin: 1.5rem 0;
        color: var(--dark);
        text-align: center;
    }

    .cart-layout {
        display: flex;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    /* Стили для товаров */
    .cart-products {
        flex: 2;
    }

    .product-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .product-card {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding: 1.5rem;
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        transition: var(--transition);
    }

    .product-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    .product-image {
        width: 120px;
        height: 120px;
        flex-shrink: 0;
        border-radius: var(--radius);
        overflow: hidden;
        background: var(--gray-lighter);
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-details {
        flex-grow: 1;
    }

    .product-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }

    .product-price {
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 0.25rem;
    }

    .product-quantity {
        font-size: 0.9rem;
        color: var(--gray);
    }

    .product-actions {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 1rem;
    }

    .product-total {
        font-weight: 600;
        font-size: 1.1rem;
    }

    .product-remove {
        background: none;
        border: none;
        color: var(--gray);
        cursor: pointer;
        padding: 0.25rem;
        transition: var(--transition);
    }

    .product-remove:hover {
        color: var(--danger);
    }

    /* Стили для карты */
    .map-section {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .map-container {
        height: 300px;
        background-color: var(--gray-lighter);
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--shadow);
    }

    .map-placeholder {
        text-align: center;
        color: var(--primary);
    }

    .map-placeholder svg {
        width: 64px;
        height: 64px;
        margin-bottom: 1rem;
    }

    .pickup-points {
        background: white;
        border-radius: var(--radius);
        padding: 1.5rem;
        box-shadow: var(--shadow);
    }

    .pickup-points h3 {
        font-size: 1.1rem;
        margin-bottom: 1rem;
        color: var(--dark);
    }

    .points-list {
        max-height: 300px;
        overflow-y: auto;
    }

    .point-item {
        margin-bottom: 0.75rem;
    }

    .point-item input {
        display: none;
    }

    .point-item label {
        display: block;
        padding: 1rem;
        border: 1px solid var(--gray-light);
        border-radius: var(--radius);
        cursor: pointer;
        transition: var(--transition);
    }

    .point-item input:checked + label {
        border-color: var(--primary);
        background-color: rgba(79, 70, 229, 0.05);
    }

    .point-item label strong {
        display: block;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .point-item label span {
        display: block;
        font-size: 0.9rem;
        color: var(--gray);
        margin-bottom: 0.25rem;
    }

    .point-item label small {
        display: block;
        font-size: 0.8rem;
        color: var(--gray);
    }

    /* Стили для формы заказа */
    .order-form {
        background: white;
        border-radius: var(--radius);
        padding: 2rem;
        box-shadow: var(--shadow-md);
        margin-top: 2rem;
    }

    .order-summary {
        margin-bottom: 1.5rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    .summary-row.total {
        font-weight: 600;
        font-size: 1.1rem;
        margin: 1rem 0;
    }

    .summary-divider {
        height: 1px;
        background-color: var(--gray-light);
        margin: 1rem 0;
    }

    .form-fields {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .form-group {
        margin-bottom: 0;
    }

    .form-group:last-child {
        grid-column: span 2;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--gray-light);
        border-radius: var(--radius);
        font-size: 0.95rem;
        transition: var(--transition);
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    textarea.form-input {
        min-height: 100px;
        resize: vertical;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .btn-checkout {
        flex: 2;
        padding: 1rem;
        background-color: var(--primary);
        color: white;
        border: none;
        border-radius: var(--radius);
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-checkout:hover {
        background-color: var(--primary-dark);
    }

    .btn-clear {
        flex: 1;
        padding: 1rem;
        background-color: white;
        color: var(--danger);
        border: 1px solid var(--danger);
        border-radius: var(--radius);
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-clear:hover {
        background-color: rgba(239, 68, 68, 0.05);
    }

    /* Стили для пустой корзины */
    .empty-cart {
        text-align: center;
        padding: 3rem 0;
    }

    .empty-content {
        max-width: 400px;
        margin: 0 auto;
    }

    .empty-cart svg {
        margin-bottom: 1.5rem;
    }

    .empty-cart h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .empty-cart p {
        color: var(--gray);
        margin-bottom: 1.5rem;
    }

    .btn-continue {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        background-color: var(--primary);
        color: white;
        border-radius: var(--radius);
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition);
    }

    .btn-continue:hover {
        background-color: var(--primary-dark);
    }

    @media (max-width: 768px) {
        .cart-layout {
            flex-direction: column;
        }

        .form-fields {
            grid-template-columns: 1fr;
        }

        .form-group:last-child {
            grid-column: span 1;
        }

        .form-actions {
            flex-direction: column;
        }

        .product-card {
            flex-direction: column;
            align-items: flex-start;
        }

        .product-image {
            width: 100%;
            height: auto;
            aspect-ratio: 1/1;
        }

        .product-actions {
            width: 100%;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
        }
    }
</style>

<script src="https://api-maps.yandex.ru/2.1/?apikey=YOUR_API_KEY&lang=ru_RU" type="text/javascript"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Инициализация карты
        ymaps.ready(initMap);

        function initMap() {
            const map = new ymaps.Map('pickupMap', {
                center: [55.76, 37.64], // Москва по умолчанию
                zoom: 10
            });

            // Добавление пунктов выдачи на карту
            const points = <?= json_encode($pickupPoints) ?>;
            const collection = new ymaps.GeoObjectCollection();

            points.forEach(point => {
                const placemark = new ymaps.Placemark(
                    [point.lat, point.lng],
                    {
                        balloonContent: `
                        <strong>${point.name}</strong><br>
                        ${point.address}<br>
                        Часы работы: ${point.hours}
                    `
                    },
                    {
                        preset: 'islands#blueDotIcon'
                    }
                );

                collection.add(placemark);

                // Обработчик клика по пункту на карте
                placemark.events.add('click', function() {
                    document.querySelector(`#point-${point.id}`).checked = true;
                });
            });

            map.geoObjects.add(collection);

            // Автоматическое масштабирование карты
            if (points.length > 0) {
                map.setBounds(collection.getBounds(), {
                    checkZoomRange: true
                });
            }

            // Обработчик выбора пункта из списка
            document.querySelectorAll('.point-item input').forEach(input => {
                input.addEventListener('change', function() {
                    if (this.checked) {
                        const point = points.find(p => p.id == this.value);
                        if (point) {
                            map.setCenter([point.lat, point.lng], 15);
                        }
                    }
                });
            });
        }

        // Обработчик для кнопки удаления товара
        document.querySelectorAll('.product-remove').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.productId;
                const productCard = this.closest('.product-card');

                if (confirm('Удалить товар из корзины?')) {
                    fetch('/cart/delete?id=' + productId, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                productCard.style.opacity = '0';
                                setTimeout(() => {
                                    productCard.remove();
                                    updateOrderSummary(data.order);
                                }, 300);
                            } else {
                                alert('Ошибка при удалении товара');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Ошибка при удалении товара');
                        });
                }
            });
        });

        // Обработчик для кнопки очистки корзины
        document.getElementById('clearCart').addEventListener('click', function() {
            if (confirm('Очистить всю корзину?')) {
                fetch('/cart/clear', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert('Ошибка при очистке корзины');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Ошибка при очистке корзины');
                    });
            }
        });

        // Обработчик оформления заказа
        document.getElementById('submitOrder').addEventListener('click', function() {
            const phone = document.getElementById('phone').value;
            const email = document.getElementById('email').value;
            const comment = document.getElementById('comment').value;
            const pickupPoint = document.querySelector('input[name="pickup_point"]:checked')?.value;

            if (!phone || !email) {
                alert('Пожалуйста, заполните все обязательные поля');
                return;
            }

            if (!pickupPoint) {
                alert('Пожалуйста, выберите пункт выдачи');
                return;
            }

            const formData = new FormData();
            formData.append('phone', phone);
            formData.append('email', email);
            formData.append('comment', comment);
            formData.append('pickup_point', pickupPoint);

            fetch('/order/create', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '/order/success?id=' + data.orderId;
                    } else {
                        alert(data.message || 'Ошибка при оформлении заказа');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ошибка при оформлении заказа');
                });
        });

        // Маска для телефона
        const phoneInput = document.getElementById('phone');
        phoneInput.addEventListener('input', function(e) {
            const x = this.value.replace(/\D/g, '').match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
            this.value = !x[2] ? x[1] : '+' + x[1] + ' (' + x[2] + (x[3] ? ') ' + x[3] + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '') : '');
        });

        // Обновление итоговой информации
        function updateOrderSummary(order) {
            document.querySelector('.summary-row.total span:last-child').textContent = order.total_price + ' ₽';
            document.querySelector('.summary-row:first-child span:last-child').textContent = order.total_price + ' ₽';
            document.querySelector('.summary-row:first-child span:first-child').textContent = 'Товары (' + order.products_count + ')';
        }
    });
</script>