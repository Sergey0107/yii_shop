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

$this->title = 'Каталог';
?>
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