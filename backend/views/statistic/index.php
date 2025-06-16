<?php
// Предполагаем, что у вас есть модель Order и User
use backend\models\Order;
use common\models\User;

// Получение статистики по времени
$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day'));
$thirtyDaysAgo = date('Y-m-d', strtotime('-30 days'));

// Заказы сегодня (включая корзину)
$ordersToday = Order::find()->where(['>=', 'created_at', $today])->count();
$ordersYesterday = Order::find()->where(['>=', 'created_at', $yesterday])->andWhere(['<', 'created_at', $today])->count();
$ordersTodayChange = $ordersYesterday > 0 ? round((($ordersToday - $ordersYesterday) / $ordersYesterday) * 100, 1) : 0;

// Оформленные заказы сегодня (без корзины)
$completedOrdersToday = Order::find()
    ->where(['>=', 'created_at', $today])
    ->andWhere(['!=', 'status', Order::STATUS_DRAFT])
    ->count();

$completedOrdersYesterday = Order::find()
    ->where(['>=', 'created_at', $yesterday])
    ->andWhere(['<', 'created_at', $today])
    ->andWhere(['!=', 'status', Order::STATUS_DRAFT])
    ->count();

$completedOrdersTodayChange = $completedOrdersYesterday > 0 ? round((($completedOrdersToday - $completedOrdersYesterday) / $completedOrdersYesterday) * 100, 1) : 0;

// Выручка за день (только оформленные заказы)
$revenueToday = Order::find()
    ->where(['>=', 'created_at', $today])
    ->andWhere(['!=', 'status', Order::STATUS_DRAFT])
//print_r($revenueToday->createCommand()->getRawSql()); die();
    ->sum('total_price') ?? 0;

$revenueYesterday = Order::find()
    ->where(['>=', 'created_at', $yesterday])
    ->andWhere(['<', 'created_at', $today])
    ->andWhere(['!=', 'status', Order::STATUS_DRAFT])
    ->sum('total_price') ?? 0;

$revenueTodayChange = $revenueYesterday > 0 ? round((($revenueToday - $revenueYesterday) / $revenueYesterday) * 100, 1) : 0;

// Средний чек (только оформленные заказы)
$avgCheckToday = $completedOrdersToday > 0 ? round($revenueToday / $completedOrdersToday) : 0;
$avgCheckYesterday = $completedOrdersYesterday > 0 ? round($revenueYesterday / $completedOrdersYesterday) : 0;
$avgCheckChange = $avgCheckYesterday > 0 ? round((($avgCheckToday - $avgCheckYesterday) / $avgCheckYesterday) * 100, 1) : 0;

// Статистика пользователей
$thisMonth = date('Y-m-01');
$lastMonth = date('Y-m-01', strtotime('-1 month'));
$lastMonthEnd = date('Y-m-t', strtotime('-1 month'));

$activeUsers = User::find()->where(['>=', 'updated_at', $lastMonth])->count();
$activeUsersLastMonth = User::find()
    ->where(['>=', 'updated_at', $lastMonth])
    ->andWhere(['<=', 'updated_at', $lastMonthEnd])
    ->count();
$activeUsersChange = $activeUsersLastMonth > 0 ? round((($activeUsers - $activeUsersLastMonth) / $activeUsersLastMonth) * 100, 1) : 0;

$newUsers = User::find()->where(['>=', 'created_at', $thisMonth])->count();
$newUsersLastMonth = User::find()
    ->where(['>=', 'created_at', $lastMonth])
    ->andWhere(['<=', 'created_at', $lastMonthEnd])
    ->count();
$newUsersChange = $newUsersLastMonth > 0 ? round((($newUsers - $newUsersLastMonth) / $newUsersLastMonth) * 100, 1) : 0;

// Повторные покупки
$totalOrders = Order::find()->where(['!=', 'status', Order::STATUS_DRAFT])->count();
$repeatOrders = Order::find()
    ->select('user_id')
    ->where(['!=', 'status', Order::STATUS_DRAFT])
    ->groupBy('user_id')
    ->having('COUNT(*) > 1')
    ->count();
$repeatPurchasesPercent = $totalOrders > 0 ? round(($repeatOrders / $totalOrders) * 100) : 0;

// LTV пользователя
$avgLTV = Order::find()
    ->where(['!=', 'status', Order::STATUS_DRAFT])
    ->average('total_price') ?? 0;

// Статистика товаров
$totalProductsSold = Order::find()
    ->joinWith('orderProducts')
    ->where(['!=', 'order.status', Order::STATUS_DRAFT])
    ->sum('order_products.quantity') ?? 0;

$totalProductsSoldLastMonth = Order::find()
    ->joinWith('orderProducts')
    ->where(['!=', 'order.status', Order::STATUS_DRAFT])
    ->andWhere(['>=', 'order.created_at', $lastMonth])
    ->andWhere(['<=', 'order.created_at', $lastMonthEnd])
    ->sum('order_products.quantity') ?? 0;

$productsSoldChange = $totalProductsSoldLastMonth > 0 ? round((($totalProductsSold - $totalProductsSoldLastMonth) / $totalProductsSoldLastMonth) * 100, 1) : 0;

// Средняя цена товара
$avgPrice = Order::find()
    ->joinWith(['orderProducts', 'orderProducts.product'])
    ->where(['!=', 'order.status', Order::STATUS_DRAFT])
    ->average('product.price') ?? 0;

// Данные для графиков
// График динамики заказов за 30 дней (включая корзину)
$orderDynamics = [];
$completedOrderDynamics = [];
$cartDynamics = [];

for ($i = 29; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $nextDate = date('Y-m-d', strtotime("-" . ($i - 1) . " days"));

    // Все заказы (включая корзину)
    $allOrdersCount = Order::find()
        ->where(['>=', 'created_at', $date])
        ->andWhere(['<', 'created_at', $nextDate])
        ->count();

    // Оформленные заказы
    $completedOrdersCount = Order::find()
        ->where(['>=', 'created_at', $date])
        ->andWhere(['<', 'created_at', $nextDate])
        ->andWhere(['!=', 'status', Order::STATUS_DRAFT])
        ->count();

    // Заказы в корзине
    $cartCount = Order::find()
        ->where(['>=', 'created_at', $date])
        ->andWhere(['<', 'created_at', $nextDate])
        ->andWhere(['status' => Order::STATUS_DRAFT])
        ->count();

    $orderDynamics[] = $allOrdersCount;
    $completedOrderDynamics[] = $completedOrdersCount;
    $cartDynamics[] = $cartCount;
}

// Топ покупатели
$topUsers = Order::find()
    ->select(['user_id', 'COUNT(*) as order_count'])
    ->joinWith('user')
    ->where(['!=', 'order.status', Order::STATUS_DRAFT])
    ->groupBy('user_id')
    ->orderBy('order_count DESC')
    ->limit(5)
    ->all();

$topUsersLabels = [];
$topUsersData = [];
foreach ($topUsers as $user) {
    $topUsersLabels[] = substr($user->user->username, 0, 1) . '***' . substr($user->user->email, 0, 1) . '.';
    $topUsersData[] = $user->user->getOrderCount();
}

// Сегментация пользователей
$newUsersCount = User::find()->where(['>=', 'created_at', $thisMonth])->count();
$activeUsersCount = User::find()
    ->where(['>=', 'updated_at', date('Y-m-d', strtotime('-30 days'))])
    ->andWhere(['<', 'created_at', $thisMonth])
    ->count();

$vipUsersCount = Order::find()
    ->select('user_id')
    ->where(['!=', 'status', Order::STATUS_DRAFT])
    ->groupBy('user_id')
    ->having('SUM(total_price) > 50000')
    ->count();

$inactiveUsersCount = User::find()
    ->where(['<', 'updated_at', date('Y-m-d', strtotime('-90 days'))])
    ->count();

$popularProducts = (new \yii\db\Query())
    ->select(['p.id', 'p.name', 'SUM(op.quantity) as total_sold'])
    ->from('order_products op')
    ->leftJoin('product p', 'p.id = op.product_id')
    ->leftJoin('order o', 'o.id = op.order_id')
    ->where(['!=', 'o.status', Order::STATUS_DRAFT])
    ->groupBy(['p.id', 'p.name'])
    ->orderBy('total_sold DESC')
    ->limit(5)
    ->all();

$popularProductsLabels = [];
$popularProductsData = [];
foreach ($popularProducts as $product) {
    $popularProductsLabels[] = $product['name'] ?? 'Товар #' . $product['id'];
    $popularProductsData[] = (int)$product['total_sold'];
}

$categorySales = (new \yii\db\Query())
    ->select(['pt.name as type_name', 'SUM(op.quantity) as total_sold'])
    ->from('order_products op')
    ->leftJoin('product p', 'p.id = op.product_id')
    ->leftJoin('type pt', 'pt.id = p.type_id')
    ->leftJoin('order o', 'o.id = op.order_id')
    ->where(['!=', 'o.status', Order::STATUS_DRAFT])
    ->groupBy(['p.type_id', 'pt.name'])
    ->orderBy('total_sold DESC')
    ->limit(5)
    ->all();

$categoryLabels = [];
$categoryData = [];
foreach ($categorySales as $category) {
    $categoryLabels[] = $category['type_name'] ?? 'Без типа';
    $categoryData[] = (int)$category['total_sold'];
}

// Статистика корзины
$draftOrders = Order::find()->where(['status' => Order::STATUS_DRAFT])->count();
$draftOrdersToday = Order::find()
    ->where(['>=', 'created_at', $today])
    ->andWhere(['status' => Order::STATUS_DRAFT])
    ->count();

$draftOrdersYesterday = Order::find()
    ->where(['>=', 'created_at', $yesterday])
    ->andWhere(['<', 'created_at', $today])
    ->andWhere(['status' => Order::STATUS_DRAFT])
    ->count();

$draftOrdersTodayChange = $draftOrdersYesterday > 0 ? round((($draftOrdersToday - $draftOrdersYesterday) / $draftOrdersYesterday) * 100, 1) : 0;

// Конверсия корзины в заказ
$conversionRate = $ordersToday > 0 ? round(($completedOrdersToday / $ordersToday) * 100, 1) : 0;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Статистика заказов</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #e2e8f0;
            min-height: 100vh;
            padding: 2rem;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 3rem;
            padding: 2rem 0;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #60a5fa, #34d399);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .header p {
            font-size: 1.1rem;
            color: #94a3b8;
            opacity: 0.8;
        }

        .tabs-container {
            background: rgba(30, 41, 59, 0.5);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(71, 85, 105, 0.3);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
        }

        .tabs-nav {
            display: flex;
            margin-bottom: 2rem;
            background: rgba(15, 23, 42, 0.6);
            border-radius: 12px;
            padding: 0.5rem;
            gap: 0.5rem;
        }

        .tab-button {
            flex: 1;
            padding: 1rem 1.5rem;
            background: transparent;
            border: none;
            border-radius: 8px;
            color: #94a3b8;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .tab-button:hover {
            color: #e2e8f0;
            background: rgba(71, 85, 105, 0.3);
        }

        .tab-button.active {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .tab-content {
            display: none;
            animation: fadeIn 0.5s ease-in-out;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(71, 85, 105, 0.3);
            border-radius: 16px;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            border-color: rgba(96, 165, 250, 0.5);
        }

        .stat-card h3 {
            font-size: 0.9rem;
            font-weight: 500;
            color: #94a3b8;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card .value {
            font-size: 2rem;
            font-weight: 700;
            color: #e2e8f0;
            margin-bottom: 0.5rem;
        }

        .stat-card .change {
            font-size: 0.85rem;
            font-weight: 500;
        }

        .change.positive { color: #22c55e; }
        .change.negative { color: #ef4444; }

        .chart-container {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(71, 85, 105, 0.3);
            border-radius: 16px;
            padding: 2rem;
            backdrop-filter: blur(10px);
            height: 400px;
            position: relative;
        }

        .chart-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #e2e8f0;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .user-stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            .user-stats-grid {
                grid-template-columns: 1fr;
            }

            .tabs-nav {
                flex-direction: column;
            }

            .header h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Статистика заказов</h1>
        <p>Аналитика продаж интернет-магазина</p>
    </div>

    <div class="tabs-container">
        <div class="tabs-nav">
            <button class="tab-button active" onclick="switchTab('time')">Статистика по времени</button>
            <button class="tab-button" onclick="switchTab('users')">Статистика по пользователям</button>
            <button class="tab-button" onclick="switchTab('products')">Популярные товары</button>
        </div>

        <!-- Вкладка: Статистика по времени -->
        <div id="time-tab" class="tab-content active">
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Всего заказов сегодня</h3>
                    <div class="value"><?= $ordersToday ?></div>
                    <div class="change <?= $ordersTodayChange >= 0 ? 'positive' : 'negative' ?>">
                        <?= $ordersTodayChange >= 0 ? '+' : '' ?><?= $ordersTodayChange ?>% к вчера
                    </div>
                </div>
                <div class="stat-card">
                    <h3>Оформленных заказов</h3>
                    <div class="value"><?= $completedOrdersToday ?></div>
                    <div class="change <?= $completedOrdersTodayChange >= 0 ? 'positive' : 'negative' ?>">
                        <?= $completedOrdersTodayChange >= 0 ? '+' : '' ?><?= $completedOrdersTodayChange ?>% к вчера
                    </div>
                </div>
                <div class="stat-card">
                    <h3>Выручка за день</h3>
                    <div class="value">₽<?= number_format($revenueToday, 0, ',', ' ') ?></div>
                    <div class="change <?= $revenueTodayChange >= 0 ? 'positive' : 'negative' ?>">
                        <?= $revenueTodayChange >= 0 ? '+' : '' ?><?= $revenueTodayChange ?>% к вчера
                    </div>
                </div>
                <div class="stat-card">
                    <h3>Средний чек</h3>
                    <div class="value">₽<?= number_format($avgCheckToday, 0, ',', ' ') ?></div>
                    <div class="change <?= $avgCheckChange >= 0 ? 'positive' : 'negative' ?>">
                        <?= $avgCheckChange >= 0 ? '+' : '' ?><?= $avgCheckChange ?>% к вчера
                    </div>
                </div>
                <div class="stat-card">
                    <h3>Заказов в  корзине сегодня</h3>
                    <div class="value"><?= $draftOrdersToday ?></div>
                    <div class="change <?= $draftOrdersTodayChange >= 0 ? 'positive' : 'negative' ?>">
                        <?= $draftOrdersTodayChange >= 0 ? '+' : '' ?><?= $draftOrdersTodayChange ?>% к вчера
                    </div>
                </div>
                <div class="stat-card">
                    <h3>Конверсия</h3>
                    <div class="value"><?= $conversionRate ?>%</div>
                    <div class="change">Корзина → Заказ</div>
                </div>
            </div>

            <div class="chart-container">
                <div class="chart-title">Динамика заказов за последние 30 дней</div>
                <canvas id="timeChart"></canvas>
            </div>
        </div>

        <!-- Вкладка: Статистика по пользователям -->
        <div id="users-tab" class="tab-content">
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Активных пользователей</h3>
                    <div class="value"><?= $activeUsers ?></div>
                    <div class="change <?= $activeUsersChange >= 0 ? 'positive' : 'negative' ?>">
                        <?= $activeUsersChange >= 0 ? '+' : '' ?><?= $activeUsersChange ?>% к прошлому месяцу
                    </div>
                </div>
                <div class="stat-card">
                    <h3>Новых пользователей</h3>
                    <div class="value"><?= $newUsers ?></div>
                    <div class="change <?= $newUsersChange >= 0 ? 'positive' : 'negative' ?>">
                        <?= $newUsersChange >= 0 ? '+' : '' ?><?= $newUsersChange ?>% к прошлому месяцу
                    </div>
                </div>
                <div class="stat-card">
                    <h3>Повторных покупок</h3>
                    <div class="value"><?= $repeatPurchasesPercent ?>%</div>
                    <div class="change">От общего числа заказов</div>
                </div>
                <div class="stat-card">
                    <h3>LTV пользователя</h3>
                    <div class="value">₽<?= number_format($avgLTV, 0, ',', ' ') ?></div>
                    <div class="change">Средний чек за все время</div>
                </div>
            </div>

            <div class="user-stats-grid">
                <div class="chart-container">
                    <div class="chart-title">Топ покупатели</div>
                    <canvas id="topUsersChart"></canvas>
                </div>
                <div class="chart-container">
                    <div class="chart-title">Сегментация пользователей</div>
                    <canvas id="userSegmentChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Вкладка: Популярные товары -->
        <div id="products-tab" class="tab-content">
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Товаров продано</h3>
                    <div class="value"><?= $totalProductsSold ?></div>
                    <div class="change <?= $productsSoldChange >= 0 ? 'positive' : 'negative' ?>">
                        <?= $productsSoldChange >= 0 ? '+' : '' ?><?= $productsSoldChange ?>% к прошлому месяцу
                    </div>
                </div>
                <div class="stat-card">
                    <h3>Средняя цена</h3>
                    <div class="value">₽<?= number_format($avgPrice, 0, ',', ' ') ?></div>
                    <div class="change">За единицу товара</div>
                </div>
            </div>

            <div class="user-stats-grid">
                <div class="chart-container">
                    <div class="chart-title">Популярные товары</div>
                    <canvas id="popularProductsChart"></canvas>
                </div>
                <div class="chart-container">
                    <div class="chart-title">Продажи по категориям</div>
                    <canvas id="categoriesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Глобальные настройки Chart.js для темной темы
    Chart.defaults.color = '#e2e8f0';
    Chart.defaults.borderColor = 'rgba(71, 85, 105, 0.3)';
    Chart.defaults.backgroundColor = 'rgba(71, 85, 105, 0.1)';

    // Данные из PHP
    const orderDynamics = <?= json_encode($orderDynamics) ?>;
    const cartDynamics = <?= json_encode($cartDynamics) ?>;
    const topUsersLabels = <?= json_encode($topUsersLabels) ?>;
    const topUsersData = <?= json_encode($topUsersData) ?>;
    const userSegmentData = [<?= $newUsersCount ?>, <?= $activeUsersCount ?>, <?= $vipUsersCount ?>, <?= $inactiveUsersCount ?>];
    const popularProductsLabels = <?= json_encode($popularProductsLabels) ?>;
    const popularProductsData = <?= json_encode($popularProductsData) ?>;
    const categoryLabels = <?= json_encode($categoryLabels) ?>;
    const categoryData = <?= json_encode($categoryData) ?>;

    // Переключение вкладок
    function switchTab(tabName) {
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.remove('active');
        });

        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active');
        });

        document.getElementById(tabName + '-tab').classList.add('active');
        event.target.classList.add('active');

        setTimeout(() => {
            initCharts(tabName);
        }, 100);
    }

    // Инициализация графиков
    function initCharts(tabName) {
        if (tabName === 'time') {
            initTimeChart();
        } else if (tabName === 'users') {
            initUserCharts();
        } else if (tabName === 'products') {
            initProductCharts();
        }
    }

    // График по времени
    function initTimeChart() {
        const ctx = document.getElementById('timeChart');
        if (!ctx) return;

        const labels = [];
        for (let i = 29; i >= 0; i--) {
            const date = new Date();
            date.setDate(date.getDate() - i);
            labels.push(date.getDate().toString());
        }

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Оформлено',
                    data: orderDynamics,
                    borderColor: '#60a5fa',
                    backgroundColor: 'rgba(96, 165, 250, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Добавлено в корзину',
                    data: cartDynamics,
                    borderColor: '#34d399',
                    backgroundColor: 'rgba(52, 211, 153, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(71, 85, 105, 0.3)'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(71, 85, 105, 0.3)'
                        }
                    }
                }
            }
        });
    }

    // Графики пользователей
    function initUserCharts() {
        const topUsersCtx = document.getElementById('topUsersChart');
        if (topUsersCtx) {
            new Chart(topUsersCtx, {
                type: 'bar',
                data: {
                    labels: topUsersLabels,
                    datasets: [{
                        label: 'Заказов',
                        data: topUsersData,
                        backgroundColor: [
                            'rgba(96, 165, 250, 0.8)',
                            'rgba(52, 211, 153, 0.8)',
                            'rgba(251, 191, 36, 0.8)',
                            'rgba(248, 113, 113, 0.8)',
                            'rgba(196, 181, 253, 0.8)'
                        ],
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(71, 85, 105, 0.3)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        const segmentCtx = document.getElementById('userSegmentChart');
        if (segmentCtx) {
            new Chart(segmentCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Новые', 'Активные', 'VIP', 'Неактивные'],
                    datasets: [{
                        data: userSegmentData,
                        backgroundColor: [
                            'rgba(96, 165, 250, 0.8)',
                            'rgba(52, 211, 153, 0.8)',
                            'rgba(251, 191, 36, 0.8)',
                            'rgba(248, 113, 113, 0.8)'
                        ],
                        borderWidth: 2,
                        borderColor: '#1e293b'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        }
    }

    // Графики товаров
    function initProductCharts() {
        const productsCtx = document.getElementById('popularProductsChart');
        if (productsCtx) {
            new Chart(productsCtx, {
                type: 'bar',
                data: {
                    labels: popularProductsLabels,
                    datasets: [{
                        label: 'Продано',
                        data: popularProductsData,
                        backgroundColor: 'rgba(96, 165, 250, 0.8)',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y',
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(71, 85, 105, 0.3)'
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        const categoriesCtx = document.getElementById('categoriesChart');
        if (categoriesCtx) {
            new Chart(categoriesCtx, {
                type: 'pie',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        data: categoryData,
                        backgroundColor: [
                            'rgba(96, 165, 250, 0.8)',
                            'rgba(52, 211, 153, 0.8)',
                            'rgba(251, 191, 36, 0.8)',
                            'rgba(248, 113, 113, 0.8)',
                            'rgba(196, 181, 253, 0.8)'
                        ],
                        borderWidth: 2,
                        borderColor: '#1e293b'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        }
    }

    // Инициализация при загрузке страницы
    document.addEventListener('DOMContentLoaded', function() {
        initTimeChart();
    });
</script>
</body>
</html>