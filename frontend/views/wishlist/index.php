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

    .product-availability {
        display: inline-flex;
        align-items: center;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
        letter-spacing: 0.025em;
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
    }

    @media (max-width: 480px) {
        .products-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
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

                        <div class="product-availability <?= $product->quantity > 0 ? 'availability-in-stock' : 'availability-out-of-stock' ?>">
                            <span class="availability-icon <?= $product->quantity > 0 ? 'icon-in-stock' : 'icon-out-of-stock' ?>"></span>
                            <?= $product->quantity > 0 ? 'В наличии' : 'Нет в наличии' ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>