<?php
/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Заказ оформлен';
?>
<div class="success-order-page">
    <div class="success-container">
        <div class="success-icon">
            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10" fill="#4CAF50"/>
                <path d="M8 12L11 15L16 9" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>

        <h1 class="success-title">Заказ успешно оформлен!</h1>

        <div class="success-actions">
            <a href="/catalog/index" class="btn btn-continue">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 11L12 14L22 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M21 12V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V5C3 3.89543 3.89543 3 5 3H16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Вернуться к покупкам
            </a>

            <a href="/orders" class="btn btn-orders">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 5H7C5.89543 5 5 5.89543 5 7V19C5 20.1046 5.89543 21 7 21H17C18.1046 21 19 20.1046 19 19V7C19 5.89543 18.1046 5 17 5H15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 12H15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 16H15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9 5C9 3.34315 10.3431 2 12 2C13.6569 2 15 3.34315 15 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9 12H9.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9 16H9.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Мои заказы
            </a>
        </div>
    </div>
</div>

<style>
    .success-order-page {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: calc(100vh - 120px); /* Учитываем хэдер и футер */
        padding: 40px 20px;
        background-color: #f8fafc;
        animation: fadeIn 0.5s ease-out;
    }

    .success-container {
        max-width: 600px;
        width: 100%;
        background: white;
        border-radius: 16px;
        padding: 40px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transform: translateY(0);
        transition: all 0.3s ease;
    }

    .success-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }

    .success-icon {
        margin: 0 auto 20px;
        width: 100px;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f0fdf4;
        border-radius: 50%;
        border: 2px dashed #4CAF50;
        animation: bounceIn 0.8s ease;
    }

    .success-icon svg {
        animation: checkmark 0.5s ease-out 0.3s both;
    }

    .success-title {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 16px;
        line-height: 1.3;
    }

    .success-message {
        font-size: 16px;
        color: #4b5563;
        margin-bottom: 12px;
        line-height: 1.5;
    }

    .success-actions {
        display: flex;
        gap: 16px;
        margin-top: 32px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn svg {
        transition: transform 0.3s ease;
    }

    .btn:hover svg {
        transform: translateX(3px);
    }

    .btn-continue {
        background: #4CAF50;
        color: white;
        border: 2px solid #4CAF50;
    }

    .btn-continue:hover {
        background: #3e8e41;
        border-color: #3e8e41;
        transform: translateY(-2px);
    }

    .btn-orders {
        background: white;
        color: #4CAF50;
        border: 2px solid #4CAF50;
    }

    .btn-orders:hover {
        background: #f0fdf4;
        transform: translateY(-2px);
    }

    /* Анимации */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes bounceIn {
        0% { transform: scale(0.5); opacity: 0; }
        50% { transform: scale(1.1); }
        70% { transform: scale(0.9); }
        100% { transform: scale(1); opacity: 1; }
    }

    @keyframes checkmark {
        0% { transform: scale(0); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }

    /* Адаптивность */
    @media (max-width: 600px) {
        .success-container {
            padding: 30px 20px;
        }

        .success-title {
            font-size: 24px;
        }

        .success-actions {
            flex-direction: column;
            gap: 12px;
        }

        .btn {
            width: 100%;
        }
    }
</style>