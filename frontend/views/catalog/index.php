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
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\BackendAsset;

$backendUploads = BackendAsset::register($this);

$this->title = 'Каталог';
?>

<style>
    /* === Глобальные переменные и базовые стили === */
    :root {
        --primary: #2563eb;
        --primary-hover: #1d4ed8;
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
        --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --radius-sm: 0.25rem;
        --radius: 0.5rem;
        --radius-lg: 0.75rem;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        background-color: var(--light);
        color: var(--dark);
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
    }

    h1, h2, h3, h4, h5, h6 {
        font-weight: 600;
        line-height: 1.25;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    img {
        max-width: 100%;
        height: auto;
        display: block;
    }

    button, input, select, textarea {
        font-family: inherit;
    }

    .container {
        width: 100%;
        max-width: 1600px;
        padding: 0 2rem;
        margin: 0 auto;
    }

    .site-header {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        z-index: 50;
    }

    .hero-banner {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        color: white;
        padding: 2rem 0;
        margin-top: 8rem;
        position: relative;
        overflow: hidden;
        width: 100%;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 48rem;
    }

    .hero-title {
        font-weight: 800;
        line-height: 1.2;
        font-size: 2rem;
        margin-bottom: 0.75rem;
    }

    .hero-text {
        font-size: 1rem;
        margin-bottom: 1.5rem;
        opacity: 0.9;
    }

    .hero-pattern {
        position: absolute;
        top: 0;
        right: 0;
        height: 100%;
        opacity: 0.1;
    }

    .filter-toggle {
        display: none;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 1.5rem;
        background-color: var(--primary);
        color: white;
        border: none;
        border-radius: var(--radius);
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
    }

    .filter-toggle:hover {
        background-color: var(--primary-hover);
    }

    .filter-toggle svg {
        width: 1.25rem;
        height: 1.25rem;
    }

    .main-layout {
        display: flex;
        gap: 1rem;
        padding: 1rem 0;
    }

    .sidebar-filters {
        width: 18rem;
        flex-shrink: 0;
    }

    .filters-container {
        background-color: white;
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        box-shadow: var(--shadow);
    }

    .filters-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }

    .filters-title {
        font-size: 1.25rem;
        font-weight: 600;
    }

    .reset-filters {
        color: var(--primary);
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
    }

    .reset-filters:hover {
        text-decoration: underline;
    }

    .filter-group {
        margin-bottom: 1.5rem;
    }

    .filter-group-title {
        font-weight: 600;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .filter-group-toggle {
        background: none;
        border: none;
        color: var(--gray);
        cursor: pointer;
    }

    .filter-options {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .filter-option {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .filter-option input[type="checkbox"] {
        width: 1.25rem;
        height: 1.25rem;
        border-radius: var(--radius-sm);
        border: 1px solid var(--gray-light);
        appearance: none;
        cursor: pointer;
        transition: var(--transition);
        position: relative;
    }

    .filter-option input[type="checkbox"]:checked {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .filter-option input[type="checkbox"]:checked::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 0.75rem;
        height: 0.75rem;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='white'%3E%3Cpath fill-rule='evenodd' d='M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z' clip-rule='evenodd' /%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: center;
    }

    .filter-option label {
        cursor: pointer;
        user-select: none;
    }

    .filter-group {
        width: 100%;
        padding: 0.5rem;
        box-sizing: border-box;
    }

    .price-filter-wrapper {
        width: 100%;
    }

    .price-inputs {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1rem;
        width: 100%;
    }

    .price-input-container {
        flex: 1;
        min-width: 0;
    }

    .price-input {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1px solid var(--gray-light);
        border-radius: var(--radius-sm);
        font-size: 0.875rem;
        box-sizing: border-box;
    }

    .price-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
    }

    .price-slider-container {
        width: 100%;
        padding: 0 0.625rem;
        box-sizing: border-box;
    }

    .price-slider-track {
        width: 100%;
        height: 4px;
        background-color: var(--gray-light);
        border-radius: 2px;
        position: relative;
        margin: 1rem 0;
    }

    .price-slider-fill {
        position: absolute;
        height: 100%;
        background-color: var(--primary);
        border-radius: 2px;
    }

    .price-slider-handle {
        position: absolute;
        top: 50%;
        width: 16px;
        height: 16px;
        background-color: white;
        border: 2px solid var(--primary);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        cursor: grab;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        z-index: 2;
    }

    .price-slider-handle:active {
        cursor: grabbing;
    }

    #minPriceHandle {
        left: 0;
    }

    #maxPriceHandle {
        left: 100%;
    }

    .apply-filters {
        width: 100%;
        padding: 1rem;
        background-color: var(--primary);
        color: white;
        border: none;
        border-radius: var(--radius);
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        margin-top: 1rem;
    }

    .apply-filters:hover {
        background-color: var(--primary-hover);
    }

    .content {
        flex: 1;
    }

    .content-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }

    .results-count {
        color: var(--gray);
    }

    .sort-select {
        padding: 0.75rem 1rem;
        border: 1px solid var(--gray-light);
        border-radius: var(--radius);
        background-color: white;
        cursor: pointer;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(18rem, 1fr));
        gap: 0.5rem;
    }

    @media (max-width: 768px) {
        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(10rem, 1fr));
            gap: 0.5rem;
        }
        .product-card {
            height: 14rem;
        }
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

    .pagination-list {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 2rem 0 0;
        justify-content: center;
        gap: 0.5rem;
    }

    .page-item {
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius);
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
    }

    .page-item:hover:not(.active, .disabled) {
        background-color: var(--secondary);
    }

    .page-item.active {
        background-color: var(--primary);
        color: white;
    }

    .page-item.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        text-decoration: none;
        color: inherit;
    }

    .page-link svg {
        width: 1rem;
        height: 1rem;
    }

    @media (max-width: 768px) {
        .footer-container {
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .footer-column:last-child {
            grid-column: span 2;
        }
    }

    @media (max-width: 480px) {
        .footer-container {
            grid-template-columns: 1fr;
        }

        .footer-column:last-child {
            grid-column: span 1;
        }

        .footer-links-horizontal {
            flex-direction: column;
            gap: 0.5rem;
        }

        .footer-link-separator {
            display: none;
        }
    }

    @media (max-width: 1024px) {
        .sidebar-filters {
            position: fixed;
            top: 0;
            left: -100%;
            width: 24rem;
            height: 100vh;
            background-color: white;
            z-index: 100;
            padding: 1.5rem;
            overflow-y: auto;
            transition: var(--transition);
        }

        .sidebar-filters.active {
            left: 0;
            box-shadow: var(--shadow-lg);
        }

        .filter-toggle {
            display: flex;
        }

        .main-layout {
            flex-direction: column;
        }
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }

        .search-container {
            flex-direction: column;
        }

        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(14rem, 1fr));
        }
    }

    @media (max-width: 480px) {
        .header-container {
            flex-direction: column;
            gap: 1rem;
        }

        .nav-list {
            gap: 1rem;
        }

        .product-grid {
            grid-template-columns: 1fr;
        }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from { transform: translateY(1rem); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .fade-in {
        animation: fadeIn 0.5s ease forwards;
    }

    .slide-up {
        animation: slideUp 0.5s ease forwards;
    }

    ::-webkit-scrollbar {
        width: 0.5rem;
    }

    ::-webkit-scrollbar-track {
        background: var(--gray-light);
    }

    ::-webkit-scrollbar-thumb {
        background: var(--primary);
        border-radius: 0.25rem;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--primary-hover);
    }
</style>

<!-- Герой-баннер -->
<section class="hero-banner">
    <div class="container">
        <div class="hero-content slide-up">
            <h1 class="hero-title">Откройте для себя мир стиля</h1>
            <p class="hero-text">Эксклюзивная коллекция премиальных товаров для тех, кто ценит качество и элегантность</p>
            <a href="#" class="btn-primary" style="display: inline-block; padding: 0.75rem 1.5rem; border-radius: var(--radius);">Смотреть коллекцию</a>
        </div>
        <svg class="hero-pattern" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">
            <path d="M250,0 C388,0 500,112 500,250 C500,388 388,500 250,500 C112,500 0,388 0,250 C0,112 112,0 250,0 Z" fill="white"></path>
        </svg>
    </div>
</section>

<div class="container">
    <div class="main-layout">
        <aside class="sidebar-filters" id="sidebarFilters">
            <div class="filters-container">
                <div class="filters-header">
                    <h3 class="filters-title">Фильтры</h3>
                    <span class="reset-filters" id="resetFiltersBtn"><a href="<?= Url::to(['catalog/index']) ?>" class="filters">Сбросить все</a></span>
                </div>

                <form method="get" action="<?= Url::to(['catalog/index']) ?>">
                    <input type="hidden" name="page" value="1">
                    <!-- Цена -->
                    <div class="filter-group">
                        <div class="filter-group-title">Цена, ₽</div>
                        <div class="price-filter-wrapper">
                            <div class="price-inputs">
                                <div class="price-input-container">
                                    <input type="number" class="price-input" placeholder="От" id="minPrice" name="min_price"
                                           value="<?= Html::encode($selectedPriceMin) ?>" min="<?= $minProductPrice ?>" max="<?= $maxProductPrice ?>">
                                </div>
                                <div class="price-input-container">
                                    <input type="number" class="price-input" placeholder="До" id="maxPrice" name="max_price"
                                           value="<?= Html::encode($selectedPriceMax) ?>" min="<?= $minProductPrice ?>" max="<?= $maxProductPrice ?>">
                                </div>
                            </div>
                            <div class="price-slider-container">
                                <div class="price-slider-track">
                                    <div class="price-slider-fill" id="priceSliderFill"></div>
                                    <div class="price-slider-handle" id="minPriceHandle"></div>
                                    <div class="price-slider-handle" id="maxPriceHandle"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Категории -->
                    <div class="filter-group">
                        <div class="filter-group-title">Категории</div>
                        <div class="filter-options">
                            <?php foreach ($types as $type): ?>
                                <div class="filter-option">
                                    <input type="checkbox" id="type-<?= $type['id'] ?>" name="type[]" value="<?= $type['id'] ?>" <?= in_array($type['id'], $selectedTypes) ? 'checked' : '' ?>>
                                    <label for="type-<?= $type['id'] ?>"><?= Html::encode($type['name']) ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Цвета -->
                    <div class="filter-group">
                        <div class="filter-group-title">Цвета</div>
                        <div class="filter-options">
                            <?php foreach ($colors as $color): ?>
                                <div class="filter-option">
                                    <input type="checkbox" id="color-<?= $color['id'] ?>" name="color[]" value="<?= $color['id'] ?>" <?= in_array($color['id'], $selectedColors) ? 'checked' : '' ?>>
                                    <label for="color-<?= $color['id'] ?>"><?= Html::encode($color['name']) ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Размеры -->
                    <div class="filter-group">
                        <div class="filter-group-title">Размеры</div>
                        <div class="filter-options">
                            <?php foreach ($sizes as $size): ?>
                                <div class="filter-option">
                                    <input type="checkbox" id="size-<?= $size['id'] ?>" name="size[]" value="<?= $size['id'] ?>" <?= in_array($size['id'], $selectedSizes) ? 'checked' : '' ?>>
                                    <label for="size-<?= $size['id'] ?>"><?= Html::encode($size['value']) ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Материалы -->
                    <div class="filter-group">
                        <div class="filter-group-title">Материалы</div>
                        <div class="filter-options">
                            <?php foreach ($materials as $material): ?>
                                <div class="filter-option">
                                    <input type="checkbox" id="material-<?= $material['id'] ?>" name="material[]" value="<?= $material['id'] ?>" <?= in_array($material['id'], $selectedMaterials) ? 'checked' : '' ?>>
                                    <label for="material-<?= $material['id'] ?>"><?= Html::encode($material['name']) ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Страны -->
                    <div class="filter-group">
                        <div class="filter-group-title">Страны производства</div>
                        <div class="filter-options">
                            <?php foreach ($countries as $country): ?>
                                <div class="filter-option">
                                    <input type="checkbox" id="country-<?= $country['id'] ?>" name="country[]" value="<?= $country['id'] ?>" <?= in_array($country['id'], $selectedCountries) ? 'checked' : '' ?>>
                                    <label for="country-<?= $country['id'] ?>"><?= Html::encode($country['name']) ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Дополнительные свойства -->
                    <?php foreach ($properties as $property): ?>
                        <div class="filter-group">
                            <div class="filter-group-title"><?= Html::encode($property->name) ?></div>
                            <div class="filter-options">
                                <?php foreach ($property->values as $value): ?>
                                    <div class="filter-option">
                                        <input type="checkbox" id="prop-<?= $value->id ?>" name="properties[]" value="<?= $value->id ?>" <?= in_array($value->id, $selectedProperties) ? 'checked' : '' ?>>
                                        <label for="prop-<?= $value->id ?>"><?= Html::encode($value->value) ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <button type="submit" class="apply-filters">Применить фильтры</button>
                </form>
            </div>
        </aside>

        <main class="content">
            <div class="content-header">
                <div class="results-count">Найдено <?= $pages->totalCount ?> товаров</div>
                <select class="sort-select" id="sortSelect">
                    <option value="popular" <?= $sort === 'popular' ? 'selected' : '' ?>>По популярности</option>
                    <option value="price-asc" <?= $sort === 'price-asc' ? 'selected' : '' ?>>По возрастанию цены</option>
                    <option value="price-desc" <?= $sort === 'price-desc' ? 'selected' : '' ?>>По убыванию цены</option>
                    <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Сначала новинки</option>
                    <option value="rating" <?= $sort === 'rating' ? 'selected' : '' ?>>По рейтингу</option>
                </select>
            </div>

            <div class="product-grid">
                <?php if ($products): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="product-card fade-in">
                            <?php if ($product->is_new): ?>
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
                                    <?php if (rand(0, 1)): ?>
                                        <span class="old-price"><?= number_format($product->price * 1.2, 0, '', ' ') ?> ₽</span>
                                        <span class="discount">-<?= rand(10, 25) ?>%</span>
                                    <?php endif; ?>
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
                    <div class="no-results" style="grid-column: 1 / -1; text-align: center; padding: 4rem;">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-bottom: 1rem;">
                            <path d="M3 7V5C3 3.89543 3.89543 3 5 3H19C20.1046 3 21 3.89543 21 5V7M3 7V19C3 20.1046 3.89543 21 5 21H19C20.1046 21 21 20.1046 21 19V7M3 7H21" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 11C16 13.2091 14.2091 15 12 15C9.79086 15 8 13.2091 8 11" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem; color: var(--dark);">Товары не найдены</h3>
                        <p style="color: var(--gray); max-width: 32rem; margin: 0 auto;">Попробуйте изменить параметры фильтрации или поисковый запрос</p>
                        <button style="margin-top: 1.5rem; padding: 0.75rem 1.5rem; background-color: var(--primary); color: white; border: none; border-radius: var(--radius); font-weight: 500; cursor: pointer; transition: var(--transition);" id="resetFiltersBtn2">
                            Сбросить фильтры
                        </button>
                    </div>
                <?php endif; ?>
            </div>

            <div class="pagination">
                <?= \yii\widgets\LinkPager::widget([
                    'pagination' => $pages,
                    'options' => ['class' => 'pagination-list'],
                    'linkContainerOptions' => ['class' => 'page-item'],
                    'linkOptions' => ['class' => 'page-link'],
                    'activePageCssClass' => 'active',
                    'disabledPageCssClass' => 'disabled',
                    'prevPageLabel' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                    'nextPageLabel' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                    'maxButtonCount' => 5,
                ]) ?>
            </div>
        </main>
    </div>
</div>

<script>
    // Функция для обновления счетчика корзины
    function updateCartCounter(count) {
        const cartCounter = document.querySelector('.cart-counter');
        if (cartCounter) {
            cartCounter.textContent = count;
            cartCounter.style.display = count > 0 ? 'flex' : 'none';
        }
    }

    // Функция для показа уведомлений
    function showNotification(message, type = 'success') {
        // Создаем элемент уведомления
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;

        // Добавляем в DOM
        document.body.appendChild(notification);

        // Автоматическое скрытие через 3 секунды
        setTimeout(() => {
            notification.classList.add('fade-out');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Стили для уведомлений (можно добавить в CSS)
    const style = document.createElement('style');
    style.textContent = `
        .notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 5px;
            color: white;
            z-index: 1000;
            animation: slide-in 0.3s ease-out;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .success {
            background-color: #4CAF50;
        }
        .error {
            background-color: #F44336;
        }
        .fade-out {
            animation: fade-out 0.3s ease-in forwards;
        }
        @keyframes slide-in {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes fade-out {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    `;
    document.head.appendChild(style);

    function addToCart(productId) {
        // AJAX запрос для добавления в корзину
        $.post('/cart/add', {product_id: productId})
            .done(function(response) {
                if(response && response.success) {
                    // Обновляем счетчик корзины
                    if(response.cartCount !== undefined) {
                        updateCartCounter(response.cartCount);
                    }
                    showNotification('Товар добавлен в корзину');
                } else {
                    const errorMsg = response && response.message ? response.message : 'Неизвестная ошибка';
                    showNotification('Ошибка: ' + errorMsg, 'error');
                }
            })
            .fail(function(xhr) {
                let errorMsg = 'Ошибка сервера';
                if(xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                showNotification(errorMsg, 'error');
            });
    }

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
    });
</script>