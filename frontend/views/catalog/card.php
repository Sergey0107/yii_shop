<?php

use yii\helpers\Html;
use frontend\assets\BackendAsset;

$backendUploads = BackendAsset::register($this);

/** @var \yii\web\View $this */
/** @var \app\models\Product $product */

$this->title = $product->name; // Устанавливаем заголовок страницы как название товара
?>

<div class="product-page">
    <div class="product-container">
        <!-- Левая колонка: Изображение -->
        <div class="product-image">
            <?php if ($product->img) { ?>
                <img src="<?= $backendUploads->baseUrl ?>/product/<?= $product->img ?>" alt="<?= Html::encode($product->name) ?>">
            <?php } else { ?>
                <img src="<?= $backendUploads->baseUrl ?>/product/no-image.png" alt="No Image">
            <?php } ?>
        </div>

        <!-- Правая колонка: Информация о товаре -->
        <div class="product-info">
            <h1><?= Html::encode($product->name) ?></h1>

            <div class="product-price">
                Цена: <?= Html::encode($product->price) ?> ₽
            </div>

            <div class="product-details">
                <div class="detail-row">
                    <span class="detail-key">Наличие</span>
                    <span class="detail-value"><?= Html::encode($product->quantity > 0 ? 'В наличии' : 'Нет в наличии') ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Размер</span>
                    <span class="detail-value"><?= Html::encode($product->size->value . ' м' ?? 'Не указано') ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Тип</span>
                    <span class="detail-value"><?= Html::encode($product->type->name ?? 'Не указано') ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Страна</span>
                    <span class="detail-value"><?= Html::encode($product->country->name ?? 'Не указано') ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Материал</span>
                    <span class="detail-value"><?= Html::encode($product->material->name ?? 'Не указано') ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Цвет</span>
                    <span class="detail-value"><?= Html::encode($product->color->name ?? 'Не указано') ?></span>
                </div>
            </div>

            <div class="product-actions">
                <?= Html::a('В корзину', ['/cart/add', 'id' => $product->id], [
                    'class' => 'btn btn-primary',
                    'data-method' => 'post',
                ]) ?>
            </div>
        </div>
    </div>

    <!-- Описание товара -->
    <div class="product-description">
        <h2>Описание</h2>
        <p><?= Html::encode($product->description ?? 'Нет описания') ?></p>
    </div>
</div>

<style>
    /* Общий стиль страницы */
    .product-page {
        background-color: #f8f9fa; /* Светло-серый фон */
        padding: 20px;
        min-height: 100vh; /* Минимальная высота страницы */
    }

    /* Контейнер для изображения и информации */
    .product-container {
        display: flex;
        gap: 30px; /* Отступ между изображением и информацией */
        margin-bottom: 40px;
    }

    /* Стили для изображения */
    .product-image img {
        width: 100%;
        max-width: 400px; /* Максимальная ширина изображения */
        height: auto;
        border-radius: 12px; /* Скругленные углы */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Легкая тень */
    }

    /* Стили для информации о товаре */
    .product-info {
        flex: 1; /* Занимает оставшееся пространство */
        background-color: #ffffff; /* Белый фон */
        padding: 20px;
        border-radius: 12px; /* Скругленные углы */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.06); /* Легкая тень */
    }

    .product-info h1 {
        font-size: 24px;
        margin-bottom: 15px;
        color: #333; /* Темно-серый текст */
    }

    .product-price {
        font-size: 15px;
        font-weight: bold;
        color: #17a2b8; /* Цвет морской волны (согласован с навигацией) */
        margin-bottom: 15px;
    }

    .product-actions .btn-primary {
        background-color: #17a2b8; /* Цвет морской волны */
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 16px;
        transition: background-color 0.2s ease;
    }

    .product-actions .btn-primary:hover {
        background-color: #138496; /* Темнее при наведении */
    }

    /* Стили для характеристик товара */
    .product-details {
        margin-top: 20px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between; /* Распределяем элементы по краям */
        align-items: center; /* Выравнивание по центру по вертикали */
        margin-bottom: 10px; /* Отступ между строками */
    }

    .detail-key {
        font-weight: bold;
        color: #333; /* Темно-серый текст */
        white-space: nowrap; /* Запрещаем перенос текста */
    }

    .detail-value {
        color: #555; /* Серый текст */
        text-align: right; /* Выравнивание значения по правому краю */
        flex: 1; /* Занимает оставшееся пространство */
        margin-left: 20px; /* Отступ между ключом и значением */
        position: relative; /* Для псевдоэлемента */
    }

    .detail-value::before {
        content: ''; /* Добавляем разделитель */
        position: absolute;
        left: -10px; /* Положение разделителя */
        top: 50%;
        transform: translateY(-50%);
        width: 80%; /* Длина разделителя */
        height: 1px; /* Толщина разделителя */
        background-color: #ccc; /* Цвет разделителя */
    }

    /* Стили для описания товара */
    .product-description {
        background-color: #ffffff; /* Белый фон */
        padding: 20px;
        border-radius: 12px; /* Скругленные углы */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.06); /* Легкая тень */
        margin-top: 20px;
    }

    .product-description h2 {
        font-size: 22px;
        margin-bottom: 15px;
        color: #333; /* Темно-серый текст */
    }

    .product-description p {
        font-size: 16px;
        color: #555; /* Серый текст */
        line-height: 1.6; /* Улучшенная читаемость */
    }

    /* Адаптивность */
    @media (max-width: 768px) {
        .product-container {
            flex-direction: column; /* Колонки становятся вертикальными */
        }

        .product-image img {
            max-width: 100%; /* Изображение занимает всю ширину */
        }
    }
</style>