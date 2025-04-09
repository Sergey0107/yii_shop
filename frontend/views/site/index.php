<?php

/** @var yii\web\View $this */
/** @var Product[] $products */

use backend\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\BackendAsset;

$backendUploads = BackendAsset::register($this);

$this->title = 'Главная страница';
?>
<div class="site-index">
    <!-- Баннер -->
    <div class="banner">
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
    </div>

    <!-- Популярные товары -->
    <div class="popular-products">
        <h2 class="section-title">Популярные товары</h2>
        <?php if ($products) { ?>
            <div class="product-grid">
                <?php foreach ($products as $product) { ?>
                    <a href="<?= Url::to(['catalog/card', 'id' => $product->id]) ?>" class="product-card-link">
                        <div class="product-card">
                            <div class="product-image">
                                <?php if ($product->img) { ?>
                                    <img src="<?= $backendUploads->baseUrl ?>/product/<?= $product->img ?>" alt="<?= Html::encode($product->name) ?>">
                                <?php } else { ?>
                                    <img src="<?= $backendUploads->baseUrl ?>/product/no-image.png" alt="No Image">
                                <?php } ?>
                            </div>
                            <div class="product-info">
                                <h3 class="product-title"><?= Html::encode($product->name) ?></h3>
                                <div class="product-price-block">
                                    <span class="product-price"><?= Html::encode($product->price) ?> ₽</span>
                                </div>
                                <button class="btn btn-cart">В корзину</button>
                            </div>
                        </div>
                    </a>
                <?php } ?>
            </div>
        <?php } else { ?>
            <p>Товары не найдены.</p>
        <?php } ?>
    </div>
</div>

<!-- Подключение Swiper.js -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<style>
    /* Общий стиль страницы */
    .site-index {
        background-color: #f8f9fa; /* Светло-серый фон */
        padding: 20px;
        min-height: 100vh;
    }

    /* Стили для баннера */
    .banner {
        margin-bottom: 40px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.06);
    }

    .swiper-container {
        width: 100%;
        height: 400px; /* Высота слайдера */
    }

    .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Сохраняем пропорции изображения */
    }

    /* Стили для навигации */
    .swiper-button-next,
    .swiper-button-prev {
        color: #fff; /* Цвет стрелок */
        background-color: rgba(0, 0, 0, 0.5); /* Прозрачный фон */
        border-radius: 50%; /* Круглые кнопки */
        width: 40px;
        height: 40px;
        transition: background-color 0.3s ease;
    }

    .swiper-button-next:hover,
    .swiper-button-prev:hover {
        background-color: rgba(0, 0, 0, 0.8); /* Темнее при наведении */
    }

    /* Стили для пагинации */
    .swiper-pagination-bullet {
        background-color: #fff; /* Цвет точек */
        opacity: 0.6;
        transition: opacity 0.3s ease;
    }

    .swiper-pagination-bullet-active {
        opacity: 1; /* Активная точка */
    }

    /* Стили для секции "Популярные товары" */
    .section-title {
        font-size: 24px;
        font-weight: bold;
        color: #343a40; /* Темно-серый текст */
        margin-bottom: 20px;
        text-align: center;
    }

    /* Сетка товаров */
    .product-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: space-between;
    }

    /* Карточка товара */
    .product-card-link {
        text-decoration: none;
        color: inherit;
    }

    .product-card {
        width: 350px; /* 3 карточки в строке */
        background-color: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.06);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    /* Изображение товара */
    .product-image img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    }

    /* Информация о товаре */
    .product-info {
        padding: 15px;
        text-align: center;
    }

    .product-title {
        font-size: 18px;
        margin: 0 0 10px;
        color: #343a40; /* Темно-серый текст */
        word-wrap: break-word;
    }

    .product-price-block {
        background-color: #f8f9fa;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding: 5px 10px;
        margin-bottom: 10px;
    }

    .product-price {
        font-size: 16px;
        font-weight: bold;
        color: #0d6efd; /* Современный синий цвет */
    }

    /* Кнопка "В корзину" */
    .btn-cart {
        background-color: #17a2b8; /* Цвет морской волны */
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.2s ease;
        width: 100%;
    }

    .btn-cart:hover {
        background-color: #138496; /* Темнее при наведении */
    }

    /* Адаптивность */
    @media (max-width: 768px) {
        .product-card {
            width: calc(50% - 15px); /* 2 карточки в строке */
        }
    }

    @media (max-width: 480px) {
        .product-card {
            width: 100%; /* 1 карточка в строке */
        }
    }
</style>

<script>
    // Инициализация Swiper.js
    document.addEventListener('DOMContentLoaded', function () {
        const swiper = new Swiper('.swiper-container', {
            loop: true, // Бесконечная прокрутка
            autoplay: {
                delay: 3000, // Автоматическая смена слайдов каждые 3 секунды
                disableOnInteraction: false, // Не отключать автопрокрутку при взаимодействии
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true, // Возможность кликать по точкам
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    });
</script>