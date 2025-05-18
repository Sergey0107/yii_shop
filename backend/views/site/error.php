<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $name;
?>

<div class="error-container">
    <div class="error-content">
        <h1 class="error-title"><?= Html::encode($this->title) ?></h1>
        <div class="error-message alert alert-danger">
            <?= nl2br(Html::encode($message)) ?>
        </div>
        <?php if (Yii::$app->user->isGuest): ?>
            <a href="<?= Url::to(['site/login']) ?>" class="btn btn-primary">Перейти на страницу входа</a>
        <?php else: ?>
            <p class="error-text">Перейти на страницу входа.</p>
            <form action="<?= Url::to(['site/logout']) ?>" method="post" style="display: inline;">
                <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                <button type="submit" class="btn btn-primary">Вход</button>
            </form>
        <?php endif; ?>
    </div>

    <div class="error-background"></div>
</div>

<style>
    /* Modern and stylish error page design */
    body {
        margin: 0;
        padding: 0;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }

    .error-container {
        position: relative;
        z-index: 1;
        text-align: center;
        max-width: 600px;
        width: 90%;
        padding: 2rem;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        animation: fadeIn 0.5s ease-in-out;
    }

    .error-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 800"%3E%3Cpath fill="none" stroke="%23e0e7ff" stroke-width="20" d="M0 0h800v800H0z"/%3E%3Ccircle cx="400" cy="400" r="300" fill="none" stroke="%23e0e7ff" stroke-width="20"/%3E%3C/svg%3E');
        opacity: 0.1;
        z-index: -1;
    }

    .error-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 1rem;
        animation: slideIn 0.5s ease-in-out;
    }

    .error-message {
        background: #fee2e2;
        border: 1px solid #f87171;
        color: #b91c1c;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        font-size: 1rem;
        line-height: 1.5;
    }

    .error-text {
        font-size: 1.1rem;
        color: #4b5563;
        margin-bottom: 2rem;
    }

    .btn {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        font-weight: 500;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: #2563eb;
        color: white;
        border: none;
    }

    .btn-primary:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3);
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive design */
    @media (max-width: 480px) {
        .error-title {
            font-size: 1.8rem;
        }

        .error-text {
            font-size: 0.9rem;
        }

        .btn {
            padding: 0.6rem 1.2rem;
            font-size: 0.9rem;
        }
    }
</style>