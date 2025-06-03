<?php

/** @var yii\web\View $this */
/** @var Product[] $products */
/** @var Pagination $pages */
/** @var string $sort */
/** @var array $colors */
/** @var array $countries */
/** @var array $materials */
/** @var array $types */
/** @var array $sizes */
/** @var float $minProductPrice */
/** @var float $maxProductPrice */
/** @var array $properties */
/** @var array $selectedTypes */
/** @var array $selectedColors */
/** @var array $selectedSizes */
/** @var float $selectedPriceMin */
/** @var float $selectedPriceMax */
/** @var array $selectedMaterials */
/** @var array $selectedCountries */
/** @var array $selectedProperties */

use backend\models\Color;
use backend\models\Country;
use backend\models\Material;
use backend\models\Product;
use backend\models\Size;
use backend\models\Type;
use backend\models\Property;
use frontend\assets\CatalogAsset;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\BackendAsset;

$backendUploads = BackendAsset::register($this);
CatalogAsset::register($this);

$this->title = 'Новинки';
?>

<div class="novelties-page">
    <div class="container">
        <!-- Баннер с заголовком -->
        <div class="novelties-banner">
            <div class="banner-content">
                <h1 class="banner-title">
                    <span class="title-icon">✨</span>
                    Новинки
                    <span class="title-icon">✨</span>
                </h1>
                <p class="banner-subtitle">Тут представлены самые свежие новинки нашего магазина</p>
                <div class="banner-decoration">
                    <div class="decoration-line"></div>
                    <div class="decoration-star">⭐</div>
                    <div class="decoration-line"></div>
                </div>
            </div>
        </div>

        <div class="main-layout">
            <main class="content">
                <div class="product-grid">
                    <?php if ($products): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="product-card fade-in">
                                <?php if ($product->is_popular): ?>
                                    <span class="product-badge hit-fire">ХИТ</span>
                                <?php elseif ($product->is_new): ?>
                                    <span class="product-badge new-badge">Новинка</span>
                                <?php elseif ($product->old_price): ?>
                                    <?php $discount = 100 - (ceil($product->price * 100 / $product->old_price)); ?>
                                    <span class="product-badge discount-badge">Скидка <?= $discount ?>%</span>
                                <?php endif; ?>

                                <button class="product-wishlist">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.28 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.91 3.81 12 5.09C13.09 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.28 18.6 15.36 13.45 20.03L12 21.35Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>

                                <a href="<?= Url::to(['catalog/card', 'id' => $product->id]) ?>" class="product-image">
                                    <?php if ($product->img): ?>
                                        <img src="<?= $backendUploads->baseUrl ?>/product/<?= $product->img ?>" alt="<?= Html::encode($product->name) ?>" loading="lazy">
                                    <?php else: ?>
                                        <img src="<?= $backendUploads->baseUrl ?>/product/no-image.png" alt="No Image" loading="lazy">
                                    <?php endif; ?>
                                </a>

                                <div class="product-info">
                                    <span class="product-category"><?= ArrayHelper::getValue($types, array_search($product->type_id, array_column($types, 'id')), ['name' => 'Unknown'])['name'] ?></span>
                                    <h3 class="product-title"><?= Html::encode($product->name) ?></h3>

                                    <div class="product-rating">
                                        <div class="stars">
                                            <?php
                                            $rating = $product->rating ?? rand(30, 50) / 10;
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
                                        <span class="rating-count">(<?= $product->review_count ?? rand(10, 150) ?>)</span>
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
                                        <?php if (Yii::$app->user->isGuest): ?>
                                            <!-- Для неавторизованных пользователей - кнопка входа -->
                                            <a href="<?= Yii::$app->urlManager->createUrl(['/site/login']) ?>" class="btn-add-cart">
                                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M3 3H5L5.4 5M7 13H17L21 5H5.4M7 13L5.4 5M7 13L4.70711 15.2929C4.07714 15.9229 4.52331 17 5.41421 17H17M17 17C15.8954 17 15 17.8954 15 19C15 20.1046 15.8954 21 17 21C18.1046 21 19 20.1046 19 19C19 17.8954 18.1046 17 17 17ZM9 19C9 20.1046 8.10457 21 7 21C5.89543 21 5 20.1046 5 19C5 17.8954 5.89543 17 7 17C8.10457 17 9 17.8954 9 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                Войти
                                            </a>
                                        <?php else: ?>
                                            <!-- Для авторизованных пользователей - кнопка добавления в корзину -->
                                            <button class="btn-add-cart" onclick="addToCart(<?= $product->id ?>)">
                                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M3 3H5L5.4 5M7 13H17L21 5H5.4M7 13L5.4 5M7 13L4.70711 15.2929C4.07714 15.9229 4.52331 17 5.41421 17H17M17 17C15.8954 17 15 17.8954 15 19C15 20.1046 15.8954 21 17 21C18.1046 21 19 20.1046 19 19C19 17.8954 18.1046 17 17 17ZM9 19C9 20.1046 8.10457 21 7 21C5.89543 21 5 20.1046 5 19C5 17.8954 5.89543 17 7 17C8.10457 17 9 17.8954 9 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                В корзину
                                            </button>
                                        <?php endif; ?>

                                        <button class="btn-quick-view">
                                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12C23 12 19 20 12 20C5 20 1 12 1 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-results">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 7V5C3 3.89543 3.89543 3 5 3H19C20.1046 3 21 3.89543 21 5V7M3 7V19C3 20.1046 3.89543 21 5 21H19C20.1046 21 21 20.1046 21 19V7M3 7H21" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M16 11C16 13.2091 14.2091 15 12 15C9.79086 15 8 13.2091 8 11" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h3>Новинки скоро появятся</h3>
                            <p>Мы работаем над пополнением ассортимента новинками</p>
                            <button id="resetFiltersBtn2">
                                Посмотреть весь каталог
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Устанавливаем минимальную и максимальную цены из PHP
        const minPrice = <?= $minProductPrice ?? 0 ?>;
        const maxPrice = <?= $maxProductPrice ?? 10000 ?>;

        // Текущие значения из полей ввода или по умолчанию
        let minVal = parseInt(document.getElementById('minPrice')?.value) || minPrice;
        let maxVal = parseInt(document.getElementById('maxPrice')?.value) || maxPrice;

        // Получаем элементы DOM
        const minPriceInput = document.getElementById('minPrice');
        const maxPriceInput = document.getElementById('maxPrice');
        const minPriceHandle = document.getElementById('minPriceHandle');
        const maxPriceHandle = document.getElementById('maxPriceHandle');
        const priceSliderFill = document.getElementById('priceSliderFill');
        const priceSliderTrack = document.querySelector('.price-slider-track');

        // Проверяем существование элементов перед работой с ними
        if (minPriceInput && maxPriceInput && minPriceHandle && maxPriceHandle && priceSliderFill && priceSliderTrack) {
            // Установка начальных значений
            minPriceInput.placeholder = minPrice;
            maxPriceInput.placeholder = maxPrice;

            // Обновление слайдера
            function updateSlider() {
                const sliderWidth = priceSliderTrack.offsetWidth;
                const minPosition = ((minVal - minPrice) / (maxPrice - minPrice)) * sliderWidth;
                const maxPosition = ((maxVal - minPrice) / (maxPrice - minPrice)) * sliderWidth;

                minPriceHandle.style.left = `${minPosition}px`;
                maxPriceHandle.style.left = `${maxPosition}px`;
                priceSliderFill.style.left = `${minPosition}px`;
                priceSliderFill.style.width = `${maxPosition - minPosition}px`;
            }

            // Обновление заполнения слайдера
            function updateSliderFill() {
                const sliderWidth = priceSliderTrack.offsetWidth;
                const minPosition = parseFloat(minPriceHandle.style.left || '0');
                const maxPosition = parseFloat(maxPriceHandle.style.left || '0');

                priceSliderFill.style.left = `${minPosition}px`;
                priceSliderFill.style.width = `${maxPosition - minPosition}px`;
            }

            // Обработчики для ручек слайдера
            function setupHandle(handle, isMin) {
                let isDragging = false;

                handle.addEventListener('mousedown', function (e) {
                    isDragging = true;
                    document.addEventListener('mousemove', onMouseMove);
                    document.addEventListener('mouseup', onMouseUp);
                });

                function onMouseMove(e) {
                    if (!isDragging) return;

                    const sliderRect = priceSliderTrack.getBoundingClientRect();
                    let newPosition = e.clientX - sliderRect.left;
                    const sliderWidth = sliderRect.width;

                    newPosition = Math.max(0, Math.min(newPosition, sliderWidth));

                    if (isMin) {
                        const maxPosition = parseFloat(maxPriceHandle.style.left || sliderWidth);
                        newPosition = Math.min(newPosition, maxPosition - 10);
                    } else {
                        const minPosition = parseFloat(minPriceHandle.style.left || 0);
                        newPosition = Math.max(newPosition, minPosition + 10);
                    }

                    handle.style.left = `${newPosition}px`;

                    const value = minPrice + (newPosition / sliderWidth) * (maxPrice - minPrice);
                    if (isMin) {
                        minVal = Math.round(value);
                        if (minPriceInput) minPriceInput.value = minVal;
                    } else {
                        maxVal = Math.round(value);
                        if (maxPriceInput) maxPriceInput.value = maxVal;
                    }

                    updateSliderFill();
                }

                function onMouseUp() {
                    isDragging = false;
                    document.removeEventListener('mousemove', onMouseMove);
                    document.removeEventListener('mouseup', onMouseUp);
                }
            }

            // Обработчики для полей ввода
            if (minPriceInput) {
                minPriceInput.addEventListener('input', function () {
                    minVal = parseInt(this.value) || minPrice;
                    if (minVal > maxVal) {
                        minVal = maxVal;
                        this.value = minVal;
                    }
                    updateSlider();
                });
            }

            if (maxPriceInput) {
                maxPriceInput.addEventListener('input', function () {
                    maxVal = parseInt(this.value) || maxPrice;
                    if (maxVal < minVal) {
                        maxVal = minVal;
                        this.value = maxVal;
                    }
                    updateSlider();
                });
            }

            // Настройка обработчиков слайдера
            setupHandle(minPriceHandle, true);
            setupHandle(maxPriceHandle, false);

            // Инициализация слайдера
            updateSlider();
        }

        // Мобильные фильтры
        const mobileFilterToggle = document.getElementById('mobileFilterToggle');
        const sidebarFilters = document.getElementById('sidebarFilters');

        if (mobileFilterToggle && sidebarFilters) {
            mobileFilterToggle.addEventListener('click', function () {
                sidebarFilters.classList.toggle('active');
            });
        }

        // Сброс фильтров
        const resetFiltersBtn = document.getElementById('resetFiltersBtn');
        const resetFiltersBtn2 = document.getElementById('resetFiltersBtn2');

        function resetFilters() {
            window.location.href = '<?= Url::to(['catalog/index']) ?>';
        }

        if (resetFiltersBtn) {
            resetFiltersBtn.addEventListener('click', resetFilters);
        }

        if (resetFiltersBtn2) {
            resetFiltersBtn2.addEventListener('click', resetFilters);
        }

        // Сортировка
        const sortSelect = document.getElementById('sortSelect');
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                const url = new URL(window.location.href);
                const params = new URLSearchParams(url.search);

                // Обновляем только параметр сортировки
                params.set('sort', this.value);

                // Сбрасываем пагинацию на первую страницу при изменении сортировки
                params.set('page', '1');

                // Формируем новый URL
                window.location.href = `${url.pathname}?${params.toString()}`;
            });

            // Устанавливаем выбранное значение из URL
            const urlParams = new URLSearchParams(window.location.search);
            const sortParam = urlParams.get('sort') || 'popular';
            sortSelect.value = sortParam;
        }

        // Избранное
        const wishlistButtons = document.querySelectorAll('.product-wishlist');
        wishlistButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const productId = this.dataset.productId;
                const isActive = this.classList.contains('active');

                $.post('/wishlist/toggle', {id: productId})
                    .done(function(response) {
                        if(response.success) {
                            this.classList.toggle('active');
                            showNotification(isActive ? 'Удалено из избранного' : 'Добавлено в избранное');
                        } else {
                            showNotification(response.message || 'Ошибка', 'error');
                        }
                    }.bind(this))
                    .fail(function() {
                        showNotification('Ошибка сервера', 'error');
                    });
            });
        });

        // Анимация появления карточек товаров
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.product-card').forEach((card) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });
    });
</script>

<style>
    /* Основные стили страницы */
    .novelties-page {
        padding-top: 120px; /* Отступ от хедера */
        min-height: 100vh;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    }

    /* Баннер - синий цвет как у кнопок корзины */
    .novelties-banner {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        padding: 60px 0;
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
    }

    .novelties-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="80" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="60" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="30" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="10" cy="90" r="1" fill="rgba(255,255,255,0.1)"/></svg>');
        animation: float 20s infinite linear;
    }

    @keyframes float {
        0% { transform: translateY(0px) rotate(0deg); }
        100% { transform: translateY(-20px) rotate(360deg); }
    }

    .banner-content {
        text-align: center;
        position: relative;
        z-index: 2;
        padding: 0 20px;
    }

    .banner-title {
        font-size: 3.5rem;
        font-weight: 800;
        color: white;
        margin-bottom: 20px;
        text-shadow: 0 4px 8px rgba(0,0,0,0.3);
        letter-spacing: -1px;
    }

    .title-icon {
        display: inline-block;
        animation: sparkle 2s infinite alternate;
        margin: 0 15px;
    }

    @keyframes sparkle {
        0% { transform: scale(1) rotate(0deg); }
        100% { transform: scale(1.1) rotate(10deg); }
    }

    .banner-subtitle {
        font-size: 1.3rem;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 30px;
        font-weight: 400;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .banner-decoration {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
    }

    .decoration-line {
        width: 80px;
        height: 2px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
    }

    .decoration-star {
        font-size: 1.5rem;
        animation: rotate 4s infinite linear;
    }

    @keyframes rotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Контейнер для адаптивности */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Сетка товаров - адаптивная с 3 товарами в ряду */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        padding: 0;
    }

    /* Карточка товара */
    .product-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        position: relative;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        border: 1px solid rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .product-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.05), rgba(29, 78, 216, 0.05));
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }

    .product-card:hover::before {
        opacity: 1;
    }

    /* Адаптивность для планшетов */
    @media (max-width: 1024px) {
        .container {
            padding: 0 15px;
        }

        .product-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        .banner-title {
            font-size: 2.8rem;
        }

        .banner-subtitle {
            font-size: 1.1rem;
        }

        .novelties-banner {
            padding: 40px 0;
        }
    }

    /* Адаптивность для мобильных устройств */
    @media (max-width: 768px) {
        .novelties-page {
            padding-top: 100px;
        }

        .container {
            padding: 0 10px;
        }

        .product-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .banner-title {
            font-size: 2.2rem;
            margin-bottom: 15px;
        }

        .title-icon {
            margin: 0 10px;
        }

        .banner-subtitle {
            font-size: 1rem;
            margin-bottom: 25px;
            padding: 0 10px;
        }

        .novelties-banner {
            padding: 30px 0;
            margin-bottom: 30px;
        }

        .decoration-line {
            width: 60px;
        }

        .product-card {
            padding: 15px;
            border-radius: 15px;
        }
    }

    /* Дополнительная адаптивность для очень маленьких экранов */
    @media (max-width: 480px) {
        .banner-title {
            font-size: 1.8rem;
        }

        .title-icon {
            margin: 0 5px;
        }

        .banner-subtitle {
            font-size: 0.9rem;
        }

        .product-grid {
            gap: 15px;
        }

        .decoration-line {
            width: 40px;
        }
    }

    /* Бейджи */
    .product-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 3;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .new-badge {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    }

    .discount-badge {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
    }

    .hit-fire {
        background: linear-gradient(45deg, #ff0000, #ff7700, #ffbb00);
        color: white;
        font-weight: bold;
        text-shadow: 0 0 3px rgba(0,0,0,0.3);
        animation: fire-pulse 1.5s infinite alternate;
        box-shadow: 0 0 15px rgba(255, 60, 0, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.2);
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
        0% {
            opacity: 0.5;
        }
        100% {
            opacity: 1;
        }
    }

    /* Дополнительные стили для предотвращения горизонтальной прокрутки */
    * {
        box-sizing: border-box;
    }

    body {
        overflow-x: hidden;
    }

    .main-layout {
        width: 100%;
        max-width: 100vw;
        overflow-x: hidden;
    }
</style>