<?php
/** @var backend\models\Order[] $orders */

use frontend\assets\BackendAsset;
use yii\helpers\Html;
use yii\helpers\Url;

$backendUploads = BackendAsset::register($this);

/** @var \yii\web\View $this */

$this->title = "Мои заказы";
?>
<div class="orders-container">
    <!-- Левая колонка - список заказов -->
    <div class="orders-sidebar">
        <h1 class="page-title">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 4H18C19.1046 4 20 4.89543 20 6V20C20 21.1046 19.1046 22 18 22H6C4.89543 22 4 21.1046 4 20V6C4 4.89543 4.89543 4 6 4H8M16 4C16 2.89543 15.1046 2 14 2H10C8.89543 2 8 2.89543 8 4M16 4C16 5.10457 15.1046 6 14 6H10C8.89543 6 8 5.10457 8 4M9 12L11 14L15 10" stroke="url(#gradient)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <defs>
                    <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#667eea"/>
                        <stop offset="100%" style="stop-color:#764ba2"/>
                    </linearGradient>
                </defs>
            </svg>
            Мои заказы
        </h1>

        <?php if ($orders) { ?>
            <div id="orders-list">
                <?php foreach ($orders as $order) {?>
                    <div class="order-item" onclick="selectOrder(<?= $order->id ?>)">
                        <div class="order-header">
                            <div class="order-number">Заказ #<?= $order->id ?></div>
                            <div class="order-date"><?= $order->created_at ?></div>
                        </div>
                        <div class="order-status status-delivered">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <?= $order->getStatusName() ?>
                        </div>
                        <div class="order-price"><?= $order->total_price ?> ₽</div>
                        <div class="delivery-price">Доставка: <?= $order->delivery_price > 0 ? ($order->delivery_price . ' ₽') : 'Бесплатно'?></div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>

    <div class="orders-main">
        <div id="order-details-placeholder" class="order-details-placeholder">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <h3>Выберите заказ</h3>
            <p>Кликните на заказ слева, чтобы посмотреть подробную информацию</p>
        </div>

        <div id="order-details" class="order-details" style="display: none;">
            <div class="order-details-header">
                <div class="order-details-title">Заказ #<span id="selected-order-number"></span></div>
                <div class="order-meta">
                    <div class="meta-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M8 7V3C8 2.44772 8.44772 2 9 2H15C15.5523 2 16 2.44772 16 3V7M8 7C8 6.44772 8.44772 6 9 6H15C15.5523 6 16 6.44772 16 7M8 7H6C4.89543 7 4 7.89543 4 9V19C4 20.1046 4.89543 21 6 21H18C19.1046 21 20 20.1046 20 19V9C20 7.89543 19.1046 7 18 7H16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <div>
                            <div style="font-weight: 600;">Способ оплаты</div>
                            <div id="payment-method">Наличными</div>
                        </div>
                    </div>
                    <div class="meta-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M13 16V6C13 4.89543 12.1046 4 11 4H3C1.89543 4 1 4.89543 1 6V16C1 17.1046 1.89543 18 3 18H11C12.1046 18 13 17.1046 13 16ZM13 16H17.5858C18.4767 16 19.3284 15.6464 19.9497 15.0251L22.7071 12.2677C23.0976 11.8771 23.0976 11.2440 22.7071 10.8535L19.9497 8.09607C19.3284 7.47477 18.4767 7.12118 17.5858 7.12118H13V16Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <div>
                            <div style="font-weight: 600;">Способ доставки</div>
                            <div id="delivery-method"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="products-section">
                <h3 class="section-title">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M16 11V7C16 5.89543 15.1046 5 14 5H10C8.89543 5 8 5.89543 8 7V11M5 9H19L18 21H6L5 9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Товары в заказе
                </h3>

                <div id="products-list">
                    <!-- Товары будут загружены через AJAX -->
                </div>

                <div id="products-loading" style="display: none; text-align: center; padding: 2rem;">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2V6M12 18V22M4.93 4.93L7.76 7.76M16.24 16.24L19.07 19.07M2 12H6M18 12H22M4.93 19.07L7.76 16.24M16.24 7.76L19.07 4.93" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <p>Загрузка товаров...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function selectOrder(orderId) {
        // Убираем активный класс со всех заказов
        document.querySelectorAll('.order-item').forEach(item => {
            item.classList.remove('active');
        });

        // Добавляем активный класс к выбранному заказу
        event.currentTarget.classList.add('active');

        // Скрываем placeholder и показываем детали
        document.getElementById('order-details-placeholder').style.display = 'none';
        document.getElementById('order-details').style.display = 'block';

        // Загружаем детали заказа через AJAX
        loadOrderDetails(orderId);
    }

    function loadOrderDetails(orderId) {
        // Показываем индикатор загрузки
        document.getElementById('products-loading').style.display = 'block';
        document.getElementById('products-list').innerHTML = '';

        // Обновляем номер заказа
        document.getElementById('selected-order-number').textContent = orderId;

        // AJAX запрос для загрузки деталей заказа
        fetch('<?= Url::to(['account/get-order-details']) ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: 'order_id=' + orderId
        })
            .then(response => response.json())
            .then(data => {
                // Скрываем индикатор загрузки
                document.getElementById('products-loading').style.display = 'none';

                if (data.success) {
                    console.log(data.order);
                    // Обновляем информацию о заказе
                    document.getElementById('payment-method').textContent = data.order.payment_method || 'Не указан';
                    document.getElementById('delivery-method').textContent = data.order.delivery_method || 'Не указан';

                    // Выводим товары
                    const productsList = document.getElementById('products-list');
                    productsList.innerHTML = '';

                    if (data.products && data.products.length > 0) {
                        data.products.forEach(product => {
                            const productCard = document.createElement('div');
                            productCard.className = 'product-card';

                            productCard.innerHTML = `
                            <div class="product-image">
                                <img src="${product.image_url}" alt="${product.name}">
                            </div>
                            <div class="product-info">
                                <div class="product-title">${product.name}</div>
                                <div class="product-price">${product.price} ₽</div>
                                <div class="product-quantity">Количество: ${product.quantity} шт.</div>
                            </div>
                        `;

                            productsList.appendChild(productCard);
                        });
                    } else {
                        productsList.innerHTML = '<p>Товары не найдены</p>';
                    }
                } else {
                    document.getElementById('products-list').innerHTML = '<p>Ошибка загрузки товаров</p>';
                    console.error('Ошибка:', data.message);
                }
            })
            .catch(error => {
                document.getElementById('products-loading').style.display = 'none';
                document.getElementById('products-list').innerHTML = '<p>Ошибка загрузки товаров</p>';
                console.error('Ошибка запроса:', error);
            });
    }
</script>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        min-height: 100vh;
        color: #333;
    }

    .orders-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem;
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 2rem;
        min-height: calc(100vh - 4rem);
    }

    .orders-sidebar {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        height: fit-content;
        max-height: calc(100vh - 6rem);
        overflow-y: auto;
    }

    .orders-main {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        height: fit-content;
        max-height: calc(100vh - 6rem);
        overflow-y: auto;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .order-item {
        background: #fff;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        border: 2px solid transparent;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .order-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: -1;
    }

    .order-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 30px rgba(37, 99, 235, 0.2);
    }

    .order-item:hover::before {
        opacity: 0.05;
    }

    .order-item.active {
        border-color: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.15);
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .order-number {
        font-weight: 600;
        color: #2563eb;
        font-size: 1.1rem;
    }

    .order-date {
        color: #6b7280;
        font-size: 0.9rem;
    }

    .order-status {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 500;
        margin: 0.5rem 0;
    }

    .status-draft { background: #dbeafe; color: #1e40af; }
    .status-created { background: #bfdbfe; color: #1e40af; }
    .status-shipped { background: #93c5fd; color: #1e40af; }
    .status-in-point { background: #60a5fa; color: #1e3a8a; }
    .status-delivered { background: #3b82f6; color: #fff; }
    .status-cancelled { background: #1e40af; color: #fff; }

    .order-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: #111827;
        margin-top: 0.5rem;
    }

    .delivery-price {
        font-size: 0.9rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    .order-details-placeholder {
        text-align: center;
        color: #6b7280;
        padding: 4rem 2rem;
    }

    .order-details-placeholder svg {
        margin-bottom: 1rem;
        opacity: 0.3;
    }

    .order-details {
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .order-details-header {
        border-bottom: 2px solid #f3f4f6;
        padding-bottom: 1.5rem;
        margin-bottom: 2rem;
    }

    .order-details-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 0.5rem;
    }

    .order-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem;
        background: #f9fafb;
        border-radius: 12px;
    }

    .meta-item svg {
        color: #2563eb;
    }

    .products-section {
        margin-top: 2rem;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .product-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        display: flex;
        gap: 1rem;
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.1);
    }

    .product-image {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-info {
        flex: 1;
    }

    .product-title {
        font-weight: 600;
        color: #111827;
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }

    .product-price {
        font-size: 1.1rem;
        font-weight: 700;
        color: #2563eb;
    }

    .product-quantity {
        color: #6b7280;
        font-size: 0.9rem;
        margin-top: 0.25rem;
    }

    #products-loading {
        color: #6b7280;
    }

    #products-loading svg {
        animation: spin 1s linear infinite;
        margin-bottom: 0.5rem;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #6b7280;
    }

    .empty-state svg {
        margin-bottom: 1rem;
        opacity: 0.3;
    }

    @media (max-width: 768px) {
        .orders-container {
            grid-template-columns: 1fr;
            gap: 1rem;
            padding: 1rem;
        }

        .product-card {
            flex-direction: column;
            text-align: center;
        }

        .product-image {
            align-self: center;
        }
    }
</style>