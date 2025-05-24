<?php

/** @var yii\web\View $this */
/** @var Product[] $popularProducts */
/** @var Product[] $newProducts */

use backend\models\Product;
use backend\models\Type;
use frontend\assets\BackendAsset;
use frontend\assets\HomePageAsset;
use yii\bootstrap5\BootstrapAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;


$backendUploads = BackendAsset::register($this);
HomePageAsset::register($this);


$this->title = 'Главная страница';

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
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
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
                            <?php if ($product->is_new): ?>
                                <span class="product-badge">Новинка</span>
                            <?php elseif ($product->old_price): ?>
                            <?php $discount = 100 - (ceil($product->price * 100 / $product->old_price)); ?>
                                <span class="product-badge" style="background-color: var(--danger);">Скидка <?= $discount ?>%</span>
                            <?php elseif ($product->is_popular):  ?>
                                <span class="product-badge hit-fire">ХИТ</span>
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
                                    <?php if ($product->old_price) { ?>
                                        <span class="old-price"><?= number_format($product->old_price, 0, '', ' ') ?> ₽</span>
                                        <?php $discount = 100 - (ceil($product->price * 100 / $product->old_price)); ?>
                                        <span class="discount">-<?= $discount ?>%</span>
                                    <?php } ?>
                                </div>

                                <div class="product-actions">
                                    <?php if (Yii::$app->user->identity) { ?>
                                        <button class="btn-add-cart" onclick="addToCart(<?= $product->id ?>)">
                                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3 3H5L5.4 5M7 13H17L21 5H5.4M7 13L5.4 5M7 13L4.70711 15.2929C4.07714 15.9229 4.52331 17 5.41421 17H17M17 17C15.8954 17 15 17.8954 15 19C15 20.1046 15.8954 21 17 21C18.1046 21 19 20.1046 19 19C19 17.8954 18.1046 17 17 17ZM9 19C9 20.1046 8.10457 21 7 21C5.89543 21 5 20.1046 5 19C5 17.8954 5.89543 17 7 17C8.10457 17 9 17.8954 9 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            В корзину
                                        </button>
                                    <?php } else { ?>
                                        <a href="<?= Yii::$app->urlManager->createUrl(['/site/login']) ?>" class="btn-add-cart">
                                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M3 3H5L5.4 5M7 13H17L21 5H5.4M7 13L5.4 5M7 13L4.70711 15.2929C4.07714 15.9229 4.52331 17 5.41421 17H17M17 17C15.8954 17 15 17.8954 15 19C15 20.1046 15.8954 21 17 21C18.1046 21 19 20.1046 19 19C19 17.8954 18.1046 17 17 17ZM9 19C9 20.1046 8.10457 21 7 21C5.89543 21 5 20.1046 5 19C5 17.8954 5.89543 17 7 17C8.10457 17 9 17.8954 9 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                Войти
                                        </a>
                                    <?php } ?>
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
                                    <?php if ($product->old_price) { ?>
                                        <span class="old-price"><?= number_format($product->old_price, 0, '', ' ') ?> ₽</span>
                                        <?php $discount = 100 - (ceil($product->price * 100 / $product->old_price)); ?>
                                        <span class="discount">-<?= $discount ?>%</span>
                                    <?php } ?>
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

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>



<script>
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

        const wishlistButtons = document.querySelectorAll('.product-wishlist');
        wishlistButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                this.classList.toggle('active');
            });
        });
    });
</script>

<style>
    .hit-fire {
        background: linear-gradient(45deg, #ff0000, #ff7700, #ffbb00);
        color: white;
        font-weight: bold;
        text-shadow: 0 0 3px rgba(0,0,0,0.3);
        padding: 4px 10px;
        border-radius: 12px;
        animation: fire-pulse 1.5s infinite alternate;
        box-shadow: 0 0 5px rgba(255, 60, 0, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.2);
        display: inline-block;
        position: relative;
        overflow: hidden;
    }

    .hit-fire::before {
        content: '';
        position: absolute;
        top: -10px;
        left: -20px;
        right: -20px;
        bottom: -10px;
        background: linear-gradient(45deg,
        rgba(255,0,0,0.3) 0%,
        rgba(255,119,0,0.3) 50%,
        rgba(255,187,0,0.3) 100%);
        z-index: -1;
        filter: blur(8px);
        animation: fire-glow 2s infinite alternate;
    }

    @keyframes fire-pulse {
        0% { transform: scale(1); box-shadow: 0 0 5px rgba(255, 60, 0, 0.7); }
        100% { transform: scale(1.05); box-shadow: 0 0 15px rgba(255, 60, 0, 0.9); }
    }

    @keyframes fire-glow {
        0% { opacity: 0.5; }
        100% { opacity: 1; }
    }
</style>