<?php

use frontend\assets\BackendAsset;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Избранное';
$backendUploads = BackendAsset::register($this);
?>

<style>
    .wishlist-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .wishlist-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .wishlist-title {
        font-size: 2.5rem;
        font-weight: 300;
        color: #1e40af;
        margin: 0;
        letter-spacing: -0.02em;
    }

    .wishlist-subtitle {
        font-size: 1.1rem;
        color: #64748b;
        margin-top: 10px;
        font-weight: 400;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }

    .product-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(30, 64, 175, 0.08);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        border: 1px solid rgba(226, 232, 240, 0.8);
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(30, 64, 175, 0.15);
        border-color: rgba(30, 64, 175, 0.2);
    }

    .product-image {
        display: block;
        width: 100%;
        height: 240px;
        overflow: hidden;
        position: relative;
        background: #f8fafc;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .product-card:hover .product-image img {
        transform: scale(1.05);
    }

    .product-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        color: white;
        z-index: 2;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .remove-wishlist-btn {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 36px;
        height: 36px;
        background: rgba(239, 68, 68, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        transition: all 0.3s ease;
        z-index: 2;
        opacity: 0;
    }

    .product-card:hover .remove-wishlist-btn {
        opacity: 1;
    }

    .remove-wishlist-btn:hover {
        background: #dc2626;
        transform: scale(1.1);
    }

    .product-info {
        padding: 24px;
    }

    .product-name {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0 0 12px 0;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-price {
        margin: 16px 0;
    }

    .current-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e40af;
        margin-right: 12px;
    }

    .old-price {
        font-size: 1.1rem;
        color: #64748b;
        text-decoration: line-through;
        font-weight: 400;
    }

    .product-availability {
        display: inline-flex;
        align-items: center;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
        letter-spacing: 0.025em;
        margin-bottom: 20px;
    }

    .availability-in-stock {
        background: rgba(34, 197, 94, 0.1);
        color: #059669;
        border: 1px solid rgba(34, 197, 94, 0.2);
    }

    .availability-out-of-stock {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .availability-icon {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-right: 8px;
    }

    .icon-in-stock {
        background: #059669;
    }

    .icon-out-of-stock {
        background: #dc2626;
    }

    .product-actions {
        display: flex;
        gap: 12px;
        margin-top: 20px;
    }

    .add-to-cart-btn {
        flex: 1;
        padding: 12px 20px;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 500;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .add-to-cart-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
    }

    .add-to-cart-btn:disabled {
        background: #94a3b8;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .remove-from-wishlist-btn {
        padding: 12px;
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .remove-from-wishlist-btn:hover {
        background: rgba(239, 68, 68, 0.2);
        transform: translateY(-2px);
    }

    .empty-wishlist {
        text-align: center;
        padding: 80px 20px;
        color: #64748b;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 24px;
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 12px;
    }

    .empty-text {
        font-size: 1.1rem;
        line-height: 1.6;
        max-width: 400px;
        margin: 0 auto;
    }

    .continue-shopping {
        display: inline-flex;
        align-items: center;
        margin-top: 30px;
        padding: 12px 28px;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .continue-shopping:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(59, 130, 246, 0.4);
        color: white;
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .wishlist-container {
            padding: 20px 15px;
        }

        .wishlist-title {
            font-size: 2rem;
        }

        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .product-image {
            height: 200px;
        }

        .product-info {
            padding: 20px;
        }

        .current-price {
            font-size: 1.3rem;
        }

        .product-actions {
            flex-direction: column;
        }
    }

    @media (max-width: 480px) {
        .products-grid {
            grid-template-columns: 1fr;
            gap: 16px;
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
                            <span class="product-badge" style="background-color: var(--danger);">Скидка <?= $discount ?>%</span>
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
        border-radius: 8px;
        color: white;
        font-weight: 500;
        z-index: 1000;
        transform: translateX(100%);
        transition: transform 0.3s ease;
        ${type === 'success' ? 'background: #059669;' : 'background: #dc2626;'}
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