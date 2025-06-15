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
                    <h3>Заказов сегодня</h3>
                    <div class="value">47</div>
                    <div class="change positive">+12% к вчера</div>
                </div>
                <div class="stat-card">
                    <h3>Выручка за день</h3>
                    <div class="value">₽89,340</div>
                    <div class="change positive">+8.5% к вчера</div>
                </div>
                <div class="stat-card">
                    <h3>Средний чек</h3>
                    <div class="value">₽1,901</div>
                    <div class="change negative">-2.1% к вчера</div>
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
                    <div class="value">1,247</div>
                    <div class="change positive">+15% к прошлому месяцу</div>
                </div>
                <div class="stat-card">
                    <h3>Новых пользователей</h3>
                    <div class="value">89</div>
                    <div class="change positive">+22% к прошлому месяцу</div>
                </div>
                <div class="stat-card">
                    <h3>Повторных покупок</h3>
                    <div class="value">67%</div>
                    <div class="change positive">+5% к прошлому месяцу</div>
                </div>
                <div class="stat-card">
                    <h3>LTV пользователя</h3>
                    <div class="value">₽4,580</div>
                    <div class="change positive">+12% к прошлому месяцу</div>
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
                    <div class="value">2,847</div>
                    <div class="change positive">+18% к прошлому месяцу</div>
                </div>
                <div class="stat-card">
                    <h3>Категорий</h3>
                    <div class="value">24</div>
                    <div class="change positive">+2 новые</div>
                </div>
                <div class="stat-card">
                    <h3>Средняя цена</h3>
                    <div class="value">₽2,150</div>
                    <div class="change positive">+7% к прошлому месяцу</div>
                </div>
                <div class="stat-card">
                    <h3>Остатки на складе</h3>
                    <div class="value">₽890K</div>
                    <div class="change negative">-12% к прошлому месяцу</div>
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

    // Переключение вкладок
    function switchTab(tabName) {
        // Скрыть все вкладки
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.remove('active');
        });

        // Убрать активный класс с кнопок
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active');
        });

        // Показать выбранную вкладку
        document.getElementById(tabName + '-tab').classList.add('active');
        event.target.classList.add('active');

        // Инициализировать графики для активной вкладки
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

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['1', '3', '5', '7', '9', '11', '13', '15', '17', '19', '21', '23', '25', '27', '29'],
                datasets: [{
                    label: 'Оформлено',
                    data: [12, 19, 15, 25, 22, 30, 28, 35, 32, 40, 38, 45, 42, 48, 47],
                    borderColor: '#60a5fa',
                    backgroundColor: 'rgba(96, 165, 250, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Добавлено в корзину',
                    data: [22, 35, 28, 45, 40, 55, 52, 65, 60, 75, 70, 85, 80, 92, 89],
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
        // Топ покупатели
        const topUsersCtx = document.getElementById('topUsersChart');
        if (topUsersCtx) {
            new Chart(topUsersCtx, {
                type: 'bar',
                data: {
                    labels: ['Иван И.', 'Мария С.', 'Алексей П.', 'Елена К.', 'Дмитрий В.'],
                    datasets: [{
                        label: 'Заказов',
                        data: [24, 19, 16, 14, 12],
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

        // Сегментация пользователей
        const segmentCtx = document.getElementById('userSegmentChart');
        if (segmentCtx) {
            new Chart(segmentCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Новые', 'Активные', 'VIP', 'Неактивные'],
                    datasets: [{
                        data: [35, 45, 12, 8],
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
        // Популярные товары
        const productsCtx = document.getElementById('popularProductsChart');
        if (productsCtx) {
            new Chart(productsCtx, {
                type: 'bar',
                data: {
                    labels: ['тестовый коврик', 'Ковер "Советский"', 'ковер "Stels"', 'ковер "Ирландец"', 'ковер "Aftas"'],
                    datasets: [{
                        label: 'Продано',
                        data: [145, 132, 98, 89, 76],
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

        // Продажи по категориям
        const categoriesCtx = document.getElementById('categoriesChart');
        if (categoriesCtx) {
            new Chart(categoriesCtx, {
                type: 'pie',
                data: {
                    labels: ['Ковры', 'Ковровые дорожки', 'Аксессуары'],
                    datasets: [{
                        data: [40, 25, 20, 10, 5],
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