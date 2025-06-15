<?php

use frontend\assets\BackendAsset;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Избранное';
$backendUploads = BackendAsset::register($this);
?>

<style>
    body {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%);
        min-height: 100vh;
        margin: 0;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .wishlist-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px 15px;
        position: relative;
    }

    .wishlist-header {
        text-align: center;
        margin-bottom: 25px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 8px 32px rgba(30, 64, 175, 0.15);
    }

    .wishlist-title {
        font-size: 2.2rem;
        font-weight: 700;
        color: #1e40af;
        margin: 0;
        text-shadow: 0 2px 10px rgba(30, 64, 175, 0.2);
        background: linear-gradient(45deg, #1e40af, #3b82f6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .wishlist-subtitle {
        font-size: 1rem;
        color: #64748b;
        margin: 8px 0 0 0;
        font-weight: 400;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 18px;
        margin-top: 20px;
    }

    .product-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(30, 64, 175, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.8);
        position: relative;
        transform-style: preserve-3d;
    }

    .product-card:hover {
        transform: translateY(-12px) rotateX(5deg);
        box-shadow: 0 25px 50px rgba(30, 64, 175, 0.2);
        border-color: rgba(59, 130, 246, 0.3);
    }

    .product-image {
        display: block;
        width: 100%;
        height: 200px;
        overflow: hidden;
        position: relative;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
        filter: saturate(1.1) contrast(1.05);
    }

    .product-card:hover .product-image img {
        transform: scale(1.08);
    }

    .product-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 0.7rem;
        font-weight: 700;
        color: white;
        z-index: 2;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .remove-wishlist-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 32px;
        height: 32px;
        background: rgba(239, 68, 68, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        z-index: 2;
        opacity: 0;
        backdrop-filter: blur(10px);
    }

    .product-card:hover .remove-wishlist-btn {
        opacity: 1;
    }

    .remove-wishlist-btn:hover {
        background: #dc2626;
        transform: scale(1.15);
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
    }

    .product-info {
        padding: 18px;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.95) 100%);
    }

    .product-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0 0 8px 0;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-price {
        margin: 10px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .current-price {
        font-size: 1.3rem;
        font-weight: 700;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .old-price {
        font-size: 0.95rem;
        color: #94a3b8;
        text-decoration: line-through;
        font-weight: 400;
    }

    .product-availability {
        display: inline-flex;
        align-items: center;
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 500;
        letter-spacing: 0.025em;
        margin-bottom: 12px;
    }

    .availability-in-stock {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(34, 197, 94, 0.05) 100%);
        color: #059669;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .availability-out-of-stock {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(239, 68, 68, 0.05) 100%);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .availability-icon {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        margin-right: 6px;
        animation: glow 2s ease-in-out infinite alternate;
    }

    @keyframes glow {
        from { box-shadow: 0 0 5px currentColor; }
        to { box-shadow: 0 0 10px currentColor, 0 0 15px currentColor; }
    }

    .icon-in-stock {
        background: #059669;
    }

    .icon-out-of-stock {
        background: #dc2626;
    }

    .product-actions {
        display: flex;
        gap: 8px;
        margin-top: 12px;
    }

    .add-to-cart-btn {
        flex: 1;
        padding: 10px 16px;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 500;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .add-to-cart-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    }

    .add-to-cart-btn:disabled {
        background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%);
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .remove-from-wishlist-btn {
        padding: 10px;
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.3);
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    .remove-from-wishlist-btn:hover {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.2) 0%, rgba(239, 68, 68, 0.1) 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.2);
    }

    .empty-wishlist {
        text-align: center;
        padding: 50px 20px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 25px;
        box-shadow: 0 8px 32px rgba(30, 64, 175, 0.15);
    }

    .empty-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .empty-title {
        font-size: 1.4rem;
        font-weight: 600;
        color: #1e40af;
        margin-bottom: 10px;
        text-shadow: 0 2px 10px rgba(30, 64, 175, 0.1);
    }

    .empty-text {
        font-size: 1rem;
        line-height: 1.5;
        max-width: 350px;
        margin: 0 auto;
        color: #64748b;
    }

    .continue-shopping {
        display: inline-flex;
        align-items: center;
        margin-top: 25px;
        padding: 12px 24px;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        text-decoration: none;
        border-radius: 15px;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
    }

    .continue-shopping:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(59, 130, 246, 0.5);
        color: white;
        text-decoration: none;
    }

    /* Декоративные элементы */
    .wishlist-container::before {
        content: '';
        position: absolute;
        top: -50px;
        left: -50px;
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.1) 100%);
        border-radius: 50%;
        animation: float 4s ease-in-out infinite;
        z-index: -1;
    }

    .wishlist-container::after {
        content: '';
        position: absolute;
        bottom: -30px;
        right: -30px;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.1) 100%);
        border-radius: 50%;
        animation: float 3s ease-in-out infinite reverse;
        z-index: -1;
    }

    @media (max-width: 768px) {
        .wishlist-container {
            padding: 15px 10px;
        }

        .wishlist-title {
            font-size: 1.8rem;
        }

        .wishlist-header {
            padding: 15px;
            margin-bottom: 20px;
        }

        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 15px;
        }

        .product-image {
            height: 180px;
        }

        .product-info {
            padding: 15px;
        }

        .current-price {
            font-size: 1.2rem;
        }

        .product-actions {
            flex-direction: column;
            gap: 6px;
        }
    }

    @media (max-width: 480px) {
        .products-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .wishlist-container {
            padding: 10px;
        }
    }

    :root {
        --danger: #ef4444;
    }
</style>

<div class="wishlist-container">
    <div class="wishlist-header">
        <h1 class="wishlist-title">Избранное</h1>
        <p class="wishlist-subtitle">Товары, которые вам понравились</p>
    </div>

    <?php if (empty($products)): ?>
        <div class="empty-wishlist">
            <div class="empty-icon">💙</div>
            <h2 class="empty-title">Ваш список избранного пуст</h2>
            <p class="empty-text">
                Добавляйте понравившиеся товары в избранное, чтобы не потерять их из виду
            </p>
            <a href="<?= Url::to(['catalog/index']) ?>" class="continue-shopping">
                Перейти к покупкам
            </a>
        </div>
    <?php else: ?>
        <div class="products-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <a href="<?= Url::to(['catalog/card', 'id' => $product->id]) ?>" class="product-image">
                        <?php if ($product->old_price): ?>
                            <?php $discount = 100 - (ceil($product->price * 100 / $product->old_price)); ?>
                            <span class="product-badge">Скидка <?= $discount ?>%</span>
                        <?php endif; ?>

                        <button class="remove-wishlist-btn" onclick="removeFromWishlist(<?= $product->id ?>); event.preventDefault();" title="Удалить из избранного">
                            ×
                        </button>

                        <?php if ($product->img): ?>
                            <img src="<?= $backendUploads->baseUrl ?>/product/<?= $product->img ?>" alt="<?= Html::encode($product->name) ?>" loading="lazy">
                        <?php else: ?>
                            <img src="<?= $backendUploads->baseUrl ?>/product/no-image.png" alt="No Image" loading="lazy">
                        <?php endif; ?>
                    </a>

                    <div class="product-info">
                        <h3 class="product-name">
                            <a href="<?= Url::to(['catalog/card', 'id' => $product->id]) ?>" style="color: inherit; text-decoration: none;">
                                <?= Html::encode($product->name) ?>
                            </a>
                        </h3>

                        <div class="product-price">
                            <span class="current-price"><?= number_format($product->price, 0, ',', ' ') ?> ₽</span>
                            <?php if ($product->old_price): ?>
                                <span class="old-price"><?= number_format($product->old_price, 0, ',', ' ') ?> ₽</span>
                            <?php endif; ?>
                        </div>

                        <div class="product-availability <?= $product->quantity > 0 ? 'availability-in-stock' : 'availability-out-of-stock' ?>">
                            <span class="availability-icon <?= $product->quantity > 0 ? 'icon-in-stock' : 'icon-out-of-stock' ?>"></span>
                            <?= $product->quantity > 0 ? 'В наличии' : 'Нет в наличии' ?>
                        </div>

                        <div class="product-actions">
                            <button class="add-to-cart-btn"
                                    onclick="addToCart(<?= $product->id ?>)"
                                <?= $product->quantity <= 0 ? 'disabled' : '' ?>>
                                <span>🛒</span>
                                <?= $product->quantity > 0 ? 'В корзину' : 'Нет в наличии' ?>
                            </button>
                            <button class="remove-from-wishlist-btn"
                                    onclick="removeFromWishlist(<?= $product->id ?>)"
                                    title="Удалить из избранного">
                                ♡
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
    function addToCart(productId) {
        // AJAX запрос для добавления товара в корзину
        fetch('<?= Url::to(['cart/add']) ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: 'product_id=' + productId
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Показать уведомление об успешном добавлении
                    showNotification('Товар добавлен в корзину', 'success');
                } else {
                    showNotification('Ошибка при добавлении товара', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Произошла ошибка', 'error');
            });
    }

    function removeFromWishlist(productId) {
        if (confirm('Удалить товар из избранного?')) {
            // AJAX запрос для удаления товара из избранного
            fetch('<?= Url::to(['wishlist/remove']) ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'product_id=' + productId
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Удалить карточку товара из DOM с анимацией
                        const productCard = event.target.closest('.product-card');
                        productCard.style.transform = 'scale(0)';
                        productCard.style.opacity = '0';
                        setTimeout(() => {
                            productCard.remove();
                            // Проверить, остались ли товары
                            const remainingCards = document.querySelectorAll('.product-card');
                            if (remainingCards.length === 0) {
                                location.reload(); // Перезагрузить страницу для показа пустого состояния
                            }
                        }, 300);
                        showNotification('Товар удален из избранного', 'success');
                    } else {
                        showNotification('Ошибка при удалении товара', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Произошла ошибка', 'error');
                });
        }
    }

    function showNotification(message, type) {
        // Создать и показать уведомление
        const notification = document.createElement('div');
        notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 12px 20px;
        border-radius: 12px;
        color: white;
        font-weight: 500;
        z-index: 1000;
        transform: translateX(100%);
        transition: transform 0.3s ease;
        backdrop-filter: blur(20px);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        ${type === 'success'
            ? 'background: linear-gradient(135deg, #059669 0%, #047857 100%);'
            : 'background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);'
        }
    `;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);

        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }
</script>