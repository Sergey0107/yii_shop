<?php
use backend\models\Product;
use yii\helpers\Html;
use yii\helpers\Json;
?>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Товары</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 100%);
            min-height: 100vh;
            color: #ffffff;
            font-weight: 400;
            line-height: 1.6;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 3rem 2rem;
        }

        .header-section {
            margin-bottom: 3rem;
        }

        .header-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0.04) 100%);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px;
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .header-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .header-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .header-text h1 {
            font-size: 2rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 0.5rem;
            letter-spacing: -0.025em;
        }

        .header-text p {
            color: rgba(255,255,255,0.7);
            font-size: 1rem;
            font-weight: 400;
        }

        .header-actions {
            display: flex;
            gap: 1rem;
        }

        .btn {
            background: rgba(255,255,255,0.08);
            color: #ffffff;
            padding: 0.75rem 1.25rem;
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            letter-spacing: 0.025em;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: transparent;
        }

        .btn:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: transparent;
            transform: translateY(-2px);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            background: rgba(255,255,255,0.06);
            border-color: rgba(255,255,255,0.15);
            transform: translateY(-2px);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 0.25rem;
            letter-spacing: -0.025em;
        }

        .stat-label {
            color: rgba(255,255,255,0.6);
            font-size: 0.875rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .controls-section {
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 3rem;
        }

        .search-container {
            margin-bottom: 2rem;
        }

        .search-wrapper {
            position: relative;
            max-width: 400px;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3rem;
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: rgba(255,255,255,0.06);
            color: #ffffff;
        }

        .search-input::placeholder {
            color: rgba(255,255,255,0.5);
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
            background: rgba(255,255,255,0.08);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.4);
            font-size: 1rem;
        }

        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .filter-label {
            font-weight: 500;
            color: rgba(255,255,255,0.7);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .filter-select, .filter-input {
            padding: 0.75rem 1rem;
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 8px;
            background: rgba(255,255,255,0.06);
            color: #ffffff;
            transition: all 0.3s ease;
        }

        .filter-select option {
            background: #1a1a2e;
            color: #ffffff;
        }

        .filter-select:focus, .filter-input:focus {
            outline: none;
            border-color: #667eea;
            background: rgba(255,255,255,0.08);
        }

        .filter-input::placeholder {
            color: rgba(255,255,255,0.5);
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
        }

        .product-card {
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px;
            padding: 2rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .product-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .product-card:hover {
            background: rgba(255,255,255,0.08);
            border-color: rgba(255,255,255,0.2);
            transform: translateY(-8px);
        }

        .product-card:hover::before {
            transform: scaleX(1);
        }

        .product-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .product-id {
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            border: 1px solid rgba(255,255,255,0.1);
            color: #ffffff;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.05em;
        }

        .product-status {
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .status-active {
            background: rgba(34, 197, 94, 0.15);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.2);
        }

        .status-inactive {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .product-name {
            font-size: 1.25rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 1rem;
            letter-spacing: -0.025em;
        }

        .product-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: rgba(255,255,255,0.7);
        }

        .detail-icon {
            color: #667eea;
            width: 16px;
            font-size: 0.875rem;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 1.5rem;
            letter-spacing: -0.025em;
        }

        .product-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
            border-radius: 6px;
        }

        .btn-view {
            background: rgba(102, 126, 234, 0.15);
            color: #667eea;
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        .btn-edit {
            background: rgba(251, 191, 36, 0.15);
            color: #fbbf24;
            border: 1px solid rgba(251, 191, 36, 0.2);
        }

        .btn-delete {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .loading-container {
            text-align: center;
            padding: 4rem 2rem;
            color: rgba(255,255,255,0.6);
        }

        .spinner {
            display: inline-block;
            width: 40px;
            height: 40px;
            border: 2px solid rgba(255,255,255,0.1);
            border-top: 2px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 1rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .no-results {
            text-align: center;
            padding: 4rem 2rem;
            color: rgba(255,255,255,0.6);
        }

        .no-results i {
            font-size: 3rem;
            color: rgba(255,255,255,0.3);
            margin-bottom: 1rem;
            display: block;
        }

        @media (max-width: 768px) {
            .container {
                padding: 2rem 1rem;
            }

            .header-content {
                flex-direction: column;
                text-align: center;
            }

            .header-left {
                flex-direction: column;
            }

            .header-text h1 {
                font-size: 1.75rem;
            }

            .header-actions {
                flex-direction: column;
                width: 100%;
            }

            .products-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .product-card {
                padding: 1.5rem;
            }

            .product-details {
                grid-template-columns: 1fr;
            }

            .filters-grid {
                grid-template-columns: 1fr;
            }

            .search-wrapper {
                max-width: 100%;
            }
        }

        /* Анимация появления */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.8s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Header -->
    <div class="header-section fade-in">
        <div class="header-card">
            <div class="header-content">
                <div class="header-left">
                    <div class="header-icon">
                        <i class="fas fa-boxes" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <div class="header-text">
                        <h1>Товары</h1>
                        <p>Управление каталогом продукции</p>
                    </div>
                </div>
                <div class="header-actions">
                    <a href="<?= Html::encode(\yii\helpers\Url::to(['create'])) ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Добавить товар
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="stats-grid fade-in">
        <div class="stat-card">
            <div class="stat-number"><?php echo Product::getProductsCount(); ?></div>
            <div class="stat-label">Всего товаров</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo Product::getActiveProductsCount(); ?></div>
            <div class="stat-label">Активные</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo Product::getNotActiveProductsCount(); ?></div>
            <div class="stat-label">Неактивные</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">₽<?php echo Product::getTotalSum(); ?></div>
            <div class="stat-label">Общая стоимость</div>
        </div>
    </div>

    <!-- Controls -->
    <div class="controls-section fade-in">
        <div class="search-container">
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Поиск товаров..." id="searchInput">
            </div>
        </div>

        <div class="filters-grid">
            <div class="filter-group">
                <label class="filter-label">Статус</label>
                <select class="filter-select" id="statusFilter">
                    <option value="">Все товары</option>
                    <option value="1">Активные</option>
                    <option value="0">Неактивные</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Цена от</label>
                <input type="number" class="filter-input" placeholder="0" id="priceFrom">
            </div>
            <div class="filter-group">
                <label class="filter-label">Цена до</label>
                <input type="number" class="filter-input" placeholder="999999" id="priceTo">
            </div>
            <div class="filter-group">
                <label class="filter-label">Количество</label>
                <select class="filter-select" id="quantityFilter">
                    <option value="">Все</option>
                    <option value="low">Мало (&lt; 10)</option>
                    <option value="medium">Средне (10-50)</option>
                    <option value="high">Много (&gt; 50)</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="products-grid fade-in" id="productsGrid">
        <?php foreach ($dataProvider->getModels() as $product): ?>
            <div class="product-card">
                <div class="product-header">
                    <div class="product-id">#<?= Html::encode($product->id) ?></div>
                    <div class="product-status <?= $product->is_active ? 'status-active' : 'status-inactive' ?>">
                        <?= $product->is_active ? 'Активен' : 'Неактивен' ?>
                    </div>
                </div>

                <div class="product-name"><?= Html::encode($product->name) ?></div>

                <div class="product-details">
                    <div class="detail-item">
                        <i class="fas fa-ruble-sign detail-icon"></i>
                        <span>Цена</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-<?= $product->quantity == 0 ? 'times-circle' : ($product->quantity < 10 ? 'exclamation-triangle' : 'check-circle') ?> detail-icon"
                           style="color: <?= $product->quantity == 0 ? '#ef4444' : ($product->quantity < 10 ? '#fbbf24' : '#22c55e') ?>"></i>
                        <span><?= Html::encode($product->quantity) ?> шт.</span>
                    </div>
                </div>

                <div class="product-price"><?= number_format($product->price, 0, ',', ' ') ?> ₽</div>

                <div class="product-actions">
                    <a href="<?= Html::encode(\yii\helpers\Url::to(['view', 'id' => $product->id])) ?>" class="btn btn-sm btn-view">
                        <i class="fas fa-eye"></i>
                        Просмотр
                    </a>
                    <a href="<?= Html::encode(\yii\helpers\Url::to(['update', 'id' => $product->id])) ?>" class="btn btn-sm btn-edit">
                        <i class="fas fa-edit"></i>
                        Изменить
                    </a>
                    <a href="<?= Html::encode(\yii\helpers\Url::to(['delete', 'id' => $product->id])) ?>"
                       class="btn btn-sm btn-delete"
                       onclick="return confirm('Вы уверены, что хотите удалить этот товар?')">
                        <i class="fas fa-trash"></i>
                        Удалить
                    </a>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if (empty($dataProvider->getModels())): ?>
            <div class="no-results">
                <i class="fas fa-search"></i>
                <div>Товары не найдены</div>
                <p style="margin-top: 0.5rem; font-size: 0.875rem;">Попробуйте изменить критерии поиска</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    // Данные товаров из PHP
    const products = <?= Json::encode(array_map(function($product) {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $product->quantity,
            'is_active' => $product->is_active,
            'description' => $product->description ?? '',
        ];
    }, $dataProvider->getModels())) ?>;

    let filteredProducts = [...products];

    function formatPrice(price) {
        return new Intl.NumberFormat('ru-RU').format(price) + ' ₽';
    }

    function getQuantityIcon(quantity) {
        if (quantity === 0) return 'fas fa-times-circle';
        if (quantity < 10) return 'fas fa-exclamation-triangle';
        return 'fas fa-check-circle';
    }

    function getQuantityColor(quantity) {
        if (quantity === 0) return '#ef4444';
        if (quantity < 10) return '#fbbf24';
        return '#22c55e';
    }

    function renderProducts() {
        const grid = document.getElementById('productsGrid');

        if (filteredProducts.length === 0) {
            grid.innerHTML = `
                <div class="no-results">
                    <i class="fas fa-search"></i>
                    <div>Товары не найдены</div>
                    <p style="margin-top: 0.5rem; font-size: 0.875rem;">Попробуйте изменить критерии поиска</p>
                </div>
            `;
            return;
        }

        grid.innerHTML = filteredProducts.map(product => `
            <div class="product-card">
                <div class="product-header">
                    <div class="product-id">#${product.id}</div>
                    <div class="product-status ${product.is_active ? 'status-active' : 'status-inactive'}">
                        ${product.is_active ? 'Активен' : 'Неактивен'}
                    </div>
                </div>

                <div class="product-name">${product.name}</div>

                <div class="product-details">
                    <div class="detail-item">
                        <i class="fas fa-ruble-sign detail-icon"></i>
                        <span>Цена</span>
                    </div>
                    <div class="detail-item">
                        <i class="${getQuantityIcon(product.quantity)} detail-icon" style="color: ${getQuantityColor(product.quantity)}"></i>
                        <span>${product.quantity} шт.</span>
                    </div>
                </div>

                <div class="product-price">${formatPrice(product.price)}</div>

                <div class="product-actions">
                    <a href="/product/view?id=${product.id}" class="btn btn-sm btn-view">
                        <i class="fas fa-eye"></i>
                        Просмотр
                    </a>
                    <a href="/product/update?id=${product.id}" class="btn btn-sm btn-edit">
                        <i class="fas fa-edit"></i>
                        Изменить
                    </a>
                    <a href="/product/delete?id=${product.id}" class="btn btn-sm btn-delete" onclick="return confirm('Вы уверены, что хотите удалить этот товар?')">
                        <i class="fas fa-trash"></i>
                        Удалить
                    </a>
                </div>
            </div>
        `).join('');
    }

    function applyFilters() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const priceFrom = parseFloat(document.getElementById('priceFrom').value) || 0;
        const priceTo = parseFloat(document.getElementById('priceTo').value) || Infinity;
        const quantityFilter = document.getElementById('quantityFilter').value;

        filteredProducts = products.filter(product => {
            const matchesSearch = product.name.toLowerCase().includes(searchTerm);
            const matchesStatus = statusFilter === '' || product.is_active.toString() === statusFilter;
            const matchesPrice = product.price >= priceFrom && product.price <= priceTo;

            let matchesQuantity = true;
            if (quantityFilter === 'low') matchesQuantity = product.quantity < 10;
            else if (quantityFilter === 'medium') matchesQuantity = product.quantity >= 10 && product.quantity <= 50;
            else if (quantityFilter === 'high') matchesQuantity = product.quantity > 50;

            return matchesSearch && matchesStatus && matchesPrice && matchesQuantity;
        });

        renderProducts();
    }

    // Event listeners для фильтрации
    document.getElementById('searchInput').addEventListener('input', applyFilters);
    document.getElementById('statusFilter').addEventListener('change', applyFilters);
    document.getElementById('priceFrom').addEventListener('input', applyFilters);
    document.getElementById('priceTo').addEventListener('input', applyFilters);
    document.getElementById('quantityFilter').addEventListener('change', applyFilters);

    // Добавляем анимацию карточкам
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.fade-in');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });
    });
</script>
</body>
</html>