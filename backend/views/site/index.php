<?php

use backend\models\Order;
use yii\helpers\Url;

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <style>
        * {
            ma rgin: 0;
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


        .welcome-section {
            margin-bottom: 3rem;
        }

        .welcome-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0.04) 100%);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px;
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        }

        .welcome-content {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .welcome-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .welcome-text h1 {
            font-size: 2rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 0.5rem;
            letter-spacing: -0.025em;
        }

        .welcome-text p {
            color: rgba(255,255,255,0.7);
            font-size: 1rem;
            font-weight: 400;
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

        .main-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .feature-card {
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

        .feature-card::before {
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

        .feature-card:hover {
            background: rgba(255,255,255,0.08);
            border-color: rgba(255,255,255,0.2);
            transform: translateY(-8px);
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .card-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .feature-card:hover .card-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: transparent;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #ffffff;
            letter-spacing: -0.025em;
        }

        .card-description {
            color: rgba(255,255,255,0.7);
            line-height: 1.6;
            margin-bottom: 2rem;
            font-size: 0.95rem;
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

        .feature-card:hover .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: transparent;
            transform: translateX(4px);
        }

        .btn svg {
            transition: transform 0.3s ease;
        }

        .feature-card:hover .btn svg {
            transform: translateX(2px);
        }

        @media (max-width: 768px) {
            .container {
                padding: 2rem 1rem;
            }

            .welcome-content {
                flex-direction: column;
                text-align: center;
            }

            .welcome-text h1 {
                font-size: 1.75rem;
            }

            .main-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .feature-card {
                padding: 1.5rem;
            }
        }

        /* Улучшенная анимация загрузки */
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
    <div class="welcome-section fade-in">
        <div class="welcome-card">
            <div class="welcome-content">
                <div class="welcome-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L13.09 8.26L22 9L13.09 9.74L12 16L10.91 9.74L2 9L10.91 8.26L12 2Z" fill="white"/>
                    </svg>
                </div>
                <div class="welcome-text">
                    <h1>Центр управления</h1>
                    <p>Современная панель администрирования для эффективного управления вашим бизнесом</p>
                </div>
            </div>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card fade-in" style="animation-delay: 0.2s;">
            <div class="stat-number"><?php echo Order::getCountOrders(); ?></div>
            <div class="stat-label">Активных заказов</div>
        </div>
        <div class="stat-card fade-in" style="animation-delay: 0.3s;">
            <div class="stat-number"><?php echo \common\models\User::getCountUser(); ?></div>
            <div class="stat-label">Довольных клиентов</div>
        </div>
    </div>

    <div class="main-grid">
        <div class="feature-card fade-in" onclick="goToOrders()" style="animation-delay: 0.5s;">
            <div class="card-header">
                <div class="card-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 11H15M9 15H15M17 3H7C5.89543 3 5 3.89543 5 5V19C5 20.1046 5.89543 21 7 21H17C18.1046 21 19 20.1046 19 19V5C19 3.89543 18.1046 3 17 3Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3 class="card-title">Управление заказами</h3>
            </div>
            <p class="card-description">
                Полный контроль над заказами в режиме реального времени. Отслеживайте статусы, управляйте выполнением и получайте детальную аналитику по каждому заказу.
            </p>
            <button class="btn">
                Перейти к заказам
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>

        <div class="feature-card fade-in" onclick="goToStats()" style="animation-delay: 0.6s;">
            <div class="card-header">
                <div class="card-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 3V21H21M7 14L12 9L16 13L21 8" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="7" cy="14" r="2" fill="white"/>
                        <circle cx="12" cy="9" r="2" fill="white"/>
                        <circle cx="16" cy="13" r="2" fill="white"/>
                        <circle cx="21" cy="8" r="2" fill="white"/>
                    </svg>
                </div>
                <h3 class="card-title">Статистика и аналитика</h3>
            </div>
            <p class="card-description">
                Подробная аналитика продаж, поведения клиентов и эффективности бизнеса. Интерактивные графики и отчеты для принятия обоснованных решений.
            </p>
            <button class="btn">
                Перейти к статистике
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
    function goToOrders() {
        window.location.href = '<?= Url::to(['order/index']) ?>';
    }

    function goToStats() {
        window.location.href = '<?= Url::to(['statistic/index']) ?>';
    }

    // Улучшенная интерактивность
    document.querySelectorAll('.feature-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
        });
    });

    // Плавное появление элементов при загрузке
    window.addEventListener('load', function() {
        const elements = document.querySelectorAll('.fade-in');
        elements.forEach((element, index) => {
            const delay = element.style.animationDelay || '0s';
            element.style.animationDelay = delay;
        });
    });
</script>
</body>
</html>