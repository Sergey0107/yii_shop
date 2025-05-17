<?php

/** @var yii\web\View $this */
/** @var Product[] $products */

use backend\models\Product;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\BackendAsset;

$backendUploads = BackendAsset::register($this);

$this->title = 'Каталог';

$colors = \backend\models\Color::find()->select(['id', 'name'])->asArray()->all();
$countries = \backend\models\Country::find()->select(['id', 'name'])->asArray()->all();
$materials = \backend\models\Material::find()->select(['id', 'name'])->asArray()->all();
$types = \backend\models\Type::find()->select(['id', 'name'])->asArray()->all();
$sizes = \backend\models\Size::find()->select(['id', 'value'])->asArray()->all();

$properties = \backend\models\Property::find()->with('values')->all(); // Получаем все свойства и их значения
?>
<style>
    /* === Шрифты и базовые стили === */
    @import url('https://fonts.googleapis.com/css2?family=Inter :wght@400;500;600;700&display=swap');

    body {
        margin: 0;
        font-family: 'Inter', sans-serif;
        background-color: #f9f9f9;
        color: #333;
    }

    h1, h2, h3, h4, h5, h6 {
        font-weight: 600;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    /* === Поисковая панель — во всю ширину === */
    .search-bar {
        background-color: white;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
        z-index: 10;
        position: relative;
        width: 100%;
    }

    .search-input-wrapper {
        position: relative;
        max-width: 90%;
        margin: 0 auto;
    }

    .search-input {
        width: 100%;
        padding: 14px 40px 14px 16px;
        border: 1px solid #ddd;
        border-radius: 10px;
        font-size: 16px;
        outline: none;
        transition: border-color 0.2s ease;
    }

    .search-input:focus {
        border-color: #138496;
    }

    .search-btn {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: transparent;
        border: none;
        cursor: pointer;
    }

    .search-btn svg {
        width: 20px;
        height: 20px;
        fill: #888;
    }

    /* === Боковая панель фильтров === */
    .sidebar-filters {
        width: 15%;
        min-width: 220px;
        background-color: #ffffff;
        padding: 24px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        position: sticky;
        top: 80px;
        height: calc(100vh - 80px);
        overflow-y: auto;
        border-right: 1px solid #eee;
    }

    .sidebar-filters h3 {
        font-size: 18px;
        margin-top: 0;
        margin-bottom: 20px;
        color: #2c3e50;
    }

    .sidebar-filters select,
    .sidebar-filters .form-group {
        width: 100%;
        margin-bottom: 16px;
    }

    .btn-primary,
    .btn-secondary {
        width: 100%;
        padding: 12px;
        font-weight: 600;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        transition: background-color 0.2s ease;
        font-size: 15px;
    }

    .btn-primary {
        background-color: #343a40;
        color: white;
    }

    .btn-primary:hover {
        background-color: #138496;
    }

    .btn-secondary {
        background-color: #e2e3e5;
        color: #333;
        margin-top: 10px;
    }

    .btn-secondary:hover {
        background-color: #c6c8ca;
    }

    /* === Основной макет === */
    .main-layout {
        display: flex;
        padding: 20px;
        gap: 20px;
        max-width: 1400px;
        margin: 0 auto;
        width: 100%;
    }

    /* === Товары === */
    .content {
        flex: 1;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 24px;
        width: 100%;
    }

    .product-card {
        background-color: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        display: flex;
        flex-direction: column;
        min-width: 220px;
        width: 100%;
    }

    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .product-image img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .product-info {
        padding: 16px;
        text-align: center;
    }

    .product-title {
        font-size: 16px;
        margin: 0 0 12px;
        color: #2c3e50;
        font-weight: 600;
        line-height: 1.4;
        word-break: break-word;
    }

    .product-price {
        font-size: 18px;
        font-weight: bold;
        color: #2c3e50;
        margin-bottom: 12px;
        display: block;
    }

    .btn-cart {
        background-color: #343a40;
        color: white;
        border: none;
        padding: 12px;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.2s ease;
        width: 100%;
    }

    .btn-cart:hover {
        background-color: #138496;
    }

    @media (max-width: 992px) {
        .main-layout {
            flex-direction: column;
        }

        .sidebar-filters {
            width: 100%;
            position: static;
            height: auto;
        }
    }
</style>

<!-- Поисковая панель -->
<div class="search-input-wrapper">
    <?= Html::textInput('q', Yii::$app->request->get('q'), [
        'placeholder' => 'Поиск по названию товара',
        'class' => 'search-input',
        'id' => 'searchInput'
    ]) ?>
    <button type="submit" class="search-btn" form="filter-form">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM10 6a4 4 0 110 8 4 4 0 010-8z"/>
            <path d="M17 17l5 5"/>
        </svg>
    </button>
</div>

<!-- Основной макет -->
<div class="main-layout">
    <!-- Сайдбар с фильтрами -->
    <div class="sidebar-filters">
        <form method="get" action="<?= Url::to(['catalog/index']) ?>" id="filter-form">
            <h3>Фильтры</h3>

            <?= Html::dropDownList('color', Yii::$app->request->get('color'), ArrayHelper::map($colors, 'id', 'name'), [
                'prompt' => 'Цвет',
                'class' => 'form-control'
            ]) ?>

            <?= Html::dropDownList('country', Yii::$app->request->get('country'), ArrayHelper::map($countries, 'id', 'name'), [
                'prompt' => 'Страна',
                'class' => 'form-control'
            ]) ?>

            <?= Html::dropDownList('material', Yii::$app->request->get('material'), ArrayHelper::map($materials, 'id', 'name'), [
                'prompt' => 'Материал',
                'class' => 'form-control'
            ]) ?>

            <?= Html::dropDownList('type', Yii::$app->request->get('type'), ArrayHelper::map($types, 'id', 'name'), [
                'prompt' => 'Тип',
                'class' => 'form-control'
            ]) ?>

            <?= Html::dropDownList('size', Yii::$app->request->get('size'), ArrayHelper::map($sizes, 'id', 'value'), [
                'prompt' => 'Размер',
                'class' => 'form-control'
            ]) ?>

            <?php foreach ($properties as $property): ?>
                <?= Html::dropDownList('properties[]', null, ArrayHelper::map($property->values, 'id', 'value'), [
                    'prompt' => $property->name,
                    'class' => 'form-control'
                ]) ?>
            <?php endforeach; ?>

            <?= Html::submitButton('Применить фильтр', ['class' => 'btn-primary']) ?>
            <?= Html::button('Сбросить фильтры', ['class' => 'btn-secondary', 'id' => 'resetFiltersBtn']) ?>
        </form>
    </div>

    <!-- Контент -->
    <div class="content">
        <div class="site-index">
            <div class="product-grid">
                <?php if ($products): ?>
                    <?php foreach ($products as $product): ?>
                        <a href="<?= Url::to(['catalog/card', 'id' => $product->id]) ?>" class="product-card-link">
                            <div class="product-card">
                                <div class="product-image">
                                    <?php if ($product->img): ?>
                                        <img src="<?= $backendUploads->baseUrl ?>/product/<?= $product->img ?>" alt="<?= Html::encode($product->name) ?>">
                                    <?php else: ?>
                                        <img src="<?= $backendUploads->baseUrl ?>/product/no-image.png" alt="No Image">
                                    <?php endif; ?>
                                </div>
                                <div class="product-info">
                                    <h3 class="product-title"><?= Html::encode($product->name) ?></h3>
                                    <span class="product-price"><?= Html::encode($product->price) ?> ₽</span>
                                    <button class="btn-cart">В корзину</button>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Товары не найдены.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const filterForm = document.getElementById('filter-form');

        // Отправка формы при нажатии Enter
        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                filterForm.submit();
            }
        });

        // Сброс фильтров
        document.getElementById('resetFiltersBtn').addEventListener('click', function () {
            window.location.href = '<?= Url::to(['catalog/index']) ?>';
        });
    });
</script>