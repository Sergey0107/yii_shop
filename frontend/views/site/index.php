<?php

/** @var yii\web\View $this */
/** @var Product[] $popularProducts */
/** @var Product[] $newProducts */

use backend\models\Product;
use backend\models\Type;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use frontend\assets\BackendAsset;

$backendUploads = BackendAsset::register($this);

$this->title = 'Главная страница';

// Fetch categories from the Type model
$types = Type::find()->select(['id', 'name'])->asArray()->all();

?>
<div class="site-index">
    <!-- Баннер -->
    <section class="hero-banner">
        <div class="container">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="<?= Yii::getAlias('@web') ?>/uploads/banner1.png" alt="Баннер 1">
                    </div>
                    <div class="swiper-slide">
                        <img src="<?= Yii::getAlias('@web') ?>/uploads/banner2.jpg" alt="Баннер 2">
                    </div>
                    <div class="swiper-slide">
                        <img src="<?= Yii::getAlias('@web') ?>/uploads/banner3.jpeg" alt="Баннер 3">
                    </div>
                </div>
                <!-- Навигация -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <!-- Пагинация -->
                <div class="swiper-pagination"></div>
            </div>
            <!-- Decorative SVG Elements -->
            <svg class="banner-decor-left" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <path d="M100,10 A90,90 0 0,1 190,100 A90,90 0 0,1 100,190 A90,90 0 0,1 10,100 A90,90 0 0,1 100,10 Z" fill="none" stroke="var(--primary)" stroke-width="2" opacity="0.2"/>
                <circle cx="100" cy="100" r="20" fill="var(--primary)" opacity="0.3"/>
            </svg>
            <svg class="banner-decor-right" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <path d="M100,10 A90,90 0 0,1 190,100 A90,90 0 0,1 100,190 A90,90 0 0,1 10,100 A90,90 0 0,1 100,10 Z" fill="none" stroke="var(--primary)" stroke-width="2" opacity="0.2"/>
                <circle cx="100" cy="100" r="20" fill="var(--primary)" opacity="0.3"/>
            </svg>
        </div>
    </section>

    <!-- Популярные товары -->
    <section class="popular-products">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">
                    <svg class="title-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21L12 17.77L5.82 21L7 14.14L2 9.27L8.91 8.26L12 2Z" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Популярные товары
                </h2>
            </div>
            <?php if ($popularProducts) { ?>
                <div class="product-grid">
                    <?php foreach ($popularProducts as $product) { ?>
                        <div class="product-card fade-in">
                            <?php if (rand(0, 1)): ?>
                                <span class="product-badge">Новинка</span>
                            <?php elseif (rand(0, 1)): ?>
                                <span class="product-badge" style="background-color: var(--danger);">Скидка <?= rand(10, 30) ?>%</span>
                            <?php endif; ?>

                            <button class="product-wishlist">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.28 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.91 3.81 12 5.09C13.09 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.28 18.6 15.36 13.45 20.03L12 21.35Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>

                            <a href="<?= Url::to(['catalog/card', 'id' => $product->id]) ?>" class="product-image">
                                <?php if ($product->img) { ?>
                                    <img src="<?= $backendUploads->baseUrl ?>/product/<?= $product->img ?>" alt="<?= Html::encode($product->name) ?>" loading="lazy">
                                <?php } else { ?>
                                    <img src="<?= $backendUploads->baseUrl ?>/product/no-image.png" alt="No Image" loading="lazy">
                                <?php } ?>
                            </a>

                            <div class="product-info">
                                <span class="product-category"><?= ArrayHelper::getValue($types, array_rand($types))['name'] ?></span>
                                <h3 class="product-title"><?= Html::encode($product->name) ?></h3>

                                <div class="product-rating">
                                    <div class="stars">
                                        <?php
                                        $rating = rand(30, 50) / 10;
                                        $fullStars = floor($rating);
                                        $hasHalfStar = $rating - $fullStars >= 0.5;
                                        ?>
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <?php if ($i <= $fullStars): ?>
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="#f59e0b" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 17.27L18.18 21L16.54 13.97L22 9.24L14.81 8.63L12 2L9.19 8.63L2 9.24L7.46 13.97L5.82 21L12 17.27Z" fill="currentColor"/>
                                                </svg>
                                            <?php elseif ($hasHalfStar && $i == $fullStars + 1): ?>
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="#f59e0b" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 15.4V6.1L13.71 10.13L18.09 10.5L14.77 13.39L15.76 17.67M22 9.24L14.81 8.63L12 2L9.19 8.63L2 9.24L7.45 13.97L5.82 21L12 17.27L18.18 21L16.54 13.97L22 9.24Z" fill="currentColor"/>
                                                </svg>
                                            <?php else: ?>
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="#e5e7eb" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 17.27L18.18 21L16.54 13.97L22 9.24L14.81 8.63L12 2L9.19 8.63L2 9.24L7.46 13.97L5.82 21L12 17.27Z" fill="currentColor"/>
                                                </svg>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                    <span class="rating-count">(<?= rand(10, 150) ?>)</span>
                                </div>

                                <div class="product-price">
                                    <span class="current-price"><?= number_format($product->price, 0, '', ' ') ?> ₽</span>
                                    <?php if (rand(0, 1)): ?>
                                        <span class="old-price"><?= number_format($product->price * 1.2, 0, '', ' ') ?> ₽</span>
                                        <span class="discount">-<?= rand(10, 25) ?>%</span>
                                    <?php endif; ?>
                                </div>

                                <div class="product-actions">
                                    <button class="btn-add-cart">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3 3H5L5.4 5M7 13H17L21 5H5.4M7 13L5.4 5M7 13L4.70711 15.2929C4.07714 15.9229 4.52331 17 5.41421 17H17M17 17C15.8954 17 15 17.8954 15 19C15 20.1046 15.8954 21 17 21C18.1046 21 19 20.1046 19 19C19 17.8954 18.1046 17 17 17ZM9 19C9 20.1046 8.10457 21 7 21C5.89543 21 5 20.1046 5 19C5 17.8954 5.89543 17 7 17C8.10457 17 9 17.8954 9 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        В корзину
                                    </button>
                                    <button class="btn-quick-view">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12C23 12 19 20 12 20C5 20 1 12 1 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div class="no-results">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 7V5C3 3.89543 3.89543 3 5 3H19C20.1046 3 21 3.89543 21 5V7M3 7V19C3 20.1046 3.89543 21 5 21H19C20.1046 21 21 20.1046 21 19V7M3 7H21" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16 11C16 13.2091 14.2091 15 12 15C9.79086 15 8 13.2091 8 11" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <h3>Товары не найдены</h3>
                    <p>Попробуйте позже или выберите другие категории.</p>
                </div>
            <?php } ?>
            <div class="decorative-elements">
                <div class="decorative-line"></div>
                <div class="decorative-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21L12 17.77L5.82 21L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="var(--primary)" opacity="0.5"/>
                    </svg>
                </div>
                <div class="decorative-line"></div>
            </div>
        </div>
    </section>

    <!-- Новинки -->
    <section class="new-arrivals">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">
                    <svg class="title-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21L12 17.77L5.82 21L7 14.14L2 9.27L8.91 8.26L12 2Z" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Новинки
                </h2>
            </div>
            <?php if ($newProducts) { ?>
                <div class="product-grid">
                    <?php foreach ($newProducts as $product) { ?>
                        <div class="product-card fade-in">
                            <span class="product-badge">Новинка</span>

                            <button class="product-wishlist">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.28 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.91 3.81 12 5.09C13.09 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.28 18.6 15.36 13.45 20.03L12 21.35Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>

                            <a href="<?= Url::to(['catalog/card', 'id' => $product->id]) ?>" class="product-image">
                                <?php if ($product->img) { ?>
                                    <img src="<?= $backendUploads->baseUrl ?>/product/<?= $product->img ?>" alt="<?= Html::encode($product->name) ?>" loading="lazy">
                                <?php } else { ?>
                                    <img src="<?= $backendUploads->baseUrl ?>/product/no-image.png" alt="No Image" loading="lazy">
                                <?php } ?>
                            </a>

                            <div class="product-info">
                                <span class="product-category"><?= ArrayHelper::getValue($types, array_rand($types))['name'] ?></span>
                                <h3 class="product-title"><?= Html::encode($product->name) ?></h3>

                                <div class="product-rating">
                                    <div class="stars">
                                        <?php
                                        $rating = rand(30, 50) / 10;
                                        $fullStars = floor($rating);
                                        $hasHalfStar = $rating - $fullStars >= 0.5;
                                        ?>
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <?php if ($i <= $fullStars): ?>
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="#f59e0b" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 17.27L18.18 21L16.54 13.97L22 9.24L14.81 8.63L12 2L9.19 8.63L2 9.24L7.46 13.97L5.82 21L12 17.27Z" fill="currentColor"/>
                                                </svg>
                                            <?php elseif ($hasHalfStar && $i == $fullStars + 1): ?>
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="#f59e0b" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 15.4V6.1L13.71 10.13L18.09 10.5L14.77 13.39L15.76 17.67M22 9.24L14.81 8.63L12 2L9.19 8.63L2 9.24L7.45 13.97L5.82 21L12 17.27L18.18 21L16.54 13.97L22 9.24Z" fill="currentColor"/>
                                                </svg>
                                            <?php else: ?>
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="#e5e7eb" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 17.27L18.18 21L16.54 13.97L22 9.24L14.81 8.63L12 2L9.19 8.63L2 9.24L7.46 13.97L5.82 21L12 17.27Z" fill="currentColor"/>
                                                </svg>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                    <span class="rating-count">(<?= rand(10, 150) ?>)</span>
                                </div>

                                <div class="product-price">
                                    <span class="current-price"><?= number_format($product->price, 0, '', ' ') ?> ₽</span>
                                    <?php if (rand(0, 1)): ?>
                                        <span class="old-price"><?= number_format($product->price * 1.2, 0, '', ' ') ?> ₽</span>
                                        <span class="discount">-<?= rand(10, 25) ?>%</span>
                                    <?php endif; ?>
                                </div>

                                <div class="product-actions">
                                    <button class="btn-add-cart">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3 3H5L5.4 5M7 13H17L21 5H5.4M7 13L5.4 5M7 13L4.70711 15.2929C4.07714 15.9229 4.52331 17 5.41421 17H17M17 17C15.8954 17 15 17.8954 15 19C15 20.1046 15.8954 21 17 21C18.1046 21 19 20.1046 19 19C19 17.8954 18.1046 17 17 17ZM9 19C9 20.1046 8.10457 21 7 21C5.89543 21 5 20.1046 5 19C5 17.8954 5.89543 17 7 17C8.10457 17 9 17.8954 9 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        В корзину
                                    </button>
                                    <button class="btn-quick-view">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12C23 12 19 20 12 20C5 20 1 12 1 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div class="no-results">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 7V5C3 3.89543 3.89543 3 5 3H19C20.1046 3 21 3.89543 21 5V7M3 7V19C3 20.1046 3.89543 21 5 21H19C20.1046 21 21 20.1046 21 19V7M3 7H21" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16 11C16 13.2091 14.2091 15 12 15C9.79086 15 8 13.2091 8 11" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <h3>Новинок пока нет</h3>
                    <p>Следите за обновлениями, чтобы не пропустить новые поступления!</p>
                </div>
            <?php } ?>
            <div class="decorative-elements">
                <div class="decorative-line"></div>
                <div class="decorative-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21L12 17.77L5.82 21L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="var(--primary)" opacity="0.5"/>
                    </svg>
                </div>
                <div class="decorative-line"></div>
            </div>
        </div>
    </section>
</div>

<!-- Подключение Swiper.js -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<style>
    /* === Глобальные переменные и базовые стили === */
    :root {
        --primary: #2563eb;
        --primary-hover: #1d4ed8;
        --primary-light: #dbeafe;
        --secondary: #f3f4f6;
        --dark: #1f2937;
        --light: #f9fafb;
        --gray: #6b7280;
        --gray-light: #e5e7eb;
        --success: #10b981;
        --danger: #ef4444;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --radius-sm: 0.25rem;
        --radius: 0.5rem;
        --radius-lg: 0.75rem;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .site-index {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        background-color: var(--light);
        color: var(--dark);
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
        min-height: 100vh;
    }

    .container {
        width: 100%;
        max-width: 1200px;
        padding: 0 2rem;
        margin: 0 auto;
        position: relative;
    }

    /* Стили для баннера */
    .hero-banner {
        margin-bottom: 40px;
        overflow: hidden;
        position: relative;
    }

    .swiper-container {
        width: 100%;
        height: 400px;
    }

    .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .swiper-button-next,
    .swiper-button-prev {
        color: #fff;
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        width: 40px;
        height: 40px;
        transition: background-color 0.3s ease;
    }

    .swiper-button-next:hover,
    .swiper-button-prev:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }

    .swiper-pagination-bullet {
        background-color: #fff;
        opacity: 0.6;
        transition: opacity 0.3s ease;
    }

    .swiper-pagination-bullet-active {
        opacity: 1;
    }

    .banner-decor-left,
    .banner-decor-right {
        position: absolute;
        width: 150px;
        height: 150px;
        opacity: 0.5;
    }

    .banner-decor-left {
        top: 20px;
        left: 20px;
    }

    .banner-decor-right {
        bottom: 20px;
        right: 20px;
    }

    /* Стили для секций */
    .popular-products,
    .new-arrivals {
        padding: 80px 0;
        background-color: white;
        position: relative;
    }

    .new-arrivals {
        background-color: var(--secondary);
    }

    .section-header {
        text-align: center;
        margin-bottom: 60px;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 1.5rem;
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .section-title:after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 50px;
        height: 3px;
        background-color: var(--primary);
    }

    .title-icon {
        width: 24px;
        height: 24px;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(18rem, 1fr));
        gap: 1rem;
    }

    .product-card {
        background-color: white;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow);
        width: 100%;
        height: auto;
        padding: 0.25rem;
        position: relative;
        display: flex;
        flex-direction: column;
        transition: var(--transition);
    }

    .product-card:hover {
        transform: translateY(-0.5rem);
        box-shadow: var(--shadow-md);
    }

    .product-badge {
        position: absolute;
        top: 1rem;
        left: 1rem;
        background-color: var(--success);
        color: white;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.5rem;
        border-radius: var(--radius-sm);
        z-index: 1;
    }

    .product-wishlist {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background-color: white;
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
        z-index: 1;
    }

    .product-wishlist:hover {
        color: var(--danger);
    }

    .product-wishlist.active {
        color: var(--danger);
    }

    .product-image {
        position: relative;
        padding-top: 60%;
        overflow: hidden;
    }

    .product-image img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .product-card:hover .product-image img {
        transform: scale(1.05);
    }

    .product-info {
        padding: 0.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .product-category {
        color: var(--primary);
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .product-title {
        font-weight: 600;
        margin-bottom: 0.75rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-rating {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        margin-bottom: 0.75rem;
    }

    .stars {
        color: #f59e0b;
    }

    .rating-count {
        color: var(--gray);
        font-size: 0.875rem;
    }

    .product-price {
        margin-top: auto;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .current-price {
        font-size: 1.25rem;
        font-weight: 700;
    }

    .old-price {
        font-size: 1rem;
        color: var(--gray);
        text-decoration: line-through;
    }

    .discount {
        color: var(--success);
        font-weight: 600;
        font-size: 0.875rem;
    }

    .product-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .btn-add-cart {
        flex: 1;
        padding: 0.75rem;
        background-color: var(--primary);
        color: white;
        border: none;
        border-radius: var(--radius);
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-add-cart:hover {
        background-color: var(--primary-hover);
    }

    .btn-add-cart svg {
        width: 1.25rem;
        height: 1.25rem;
    }

    .btn-quick-view {
        width: 2.75rem;
        height: 2.75rem;
        background-color: var(--secondary);
        border: none;
        border-radius: var(--radius);
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-quick-view:hover {
        background-color: var(--gray-light);
    }

    .btn-quick-view svg {
        width: 1.25rem;
        height: 1.25rem;
    }

    .no-results {
        grid-column: 1 / -1;
        text-align: center;
        padding: 4rem;
    }

    .no-results svg {
        margin-bottom: 1rem;
    }

    .no-results h3 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
        color: var(--dark);
    }

    .no-results p {
        color: var(--gray);
        max-width: 32rem;
        margin: 0 auto;
    }

    .decorative-elements {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-top: 30px;
    }

    .decorative-line {
        height: 2px;
        background-color: var(--primary-light);
        flex-grow: 1;
    }

    .decorative-icon {
        flex-shrink: 0;
    }

    /* Адаптивность */
    @media (max-width: 768px) {
        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(14rem, 1fr));
        }

        .swiper-container {
            height: 300px;
        }

        .section-title {
            font-size: 1.5rem;
        }

        .banner-decor-left,
        .banner-decor-right {
            width: 100px;
            height: 100px;
        }
    }

    @media (max-width: 480px) {
        .product-grid {
            grid-template-columns: 1fr;
        }

        .swiper-container {
            height: 200px;
        }

        .banner-decor-left,
        .banner-decor-right {
            width: 80px;
            height: 80px;
        }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .fade-in {
        animation: fadeIn 0.5s ease forwards;
    }
</style>

<script>
    // Инициализация Swiper.js
    document.addEventListener('DOMContentLoaded', function () {
        const swiper = new Swiper('.swiper-container', {
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });

        // Избранное
        const wishlistButtons = document.querySelectorAll('.product-wishlist');
        wishlistButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                this.classList.toggle('active');
            });
        });
    });
</script>