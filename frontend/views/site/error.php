<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var \Exception $exception */

use yii\helpers\Html;

$this->title = 'Ошибка';
?>
<style>
    :root {
        --primary: #2563eb;
        --primary-hover: #1d4ed8;
        --gray-light: #f1f5f9;
        --radius: 12px;
        --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        --transition: all 0.2s ease;
    }

    .site-error {
        max-width: 600px;
        margin: 80px auto;
        padding: 2rem;
        background-color: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        text-align: center;
    }

    .site-error h1 {
        font-size: 2rem;
        color: #ef4444;
        margin-bottom: 1rem;
    }

    .alert {
        background-color: #fee2e2;
        color: #b91c1c;
        padding: 1rem 1.5rem;
        border-radius: var(--radius);
        border-left: 4px solid #ef4444;
        text-align: left;
        white-space: pre-wrap;
        word-break: break-word;
    }

    .error-description {
        margin-top: 1.5rem;
        font-size: 1.1rem;
        color: #4b5563;
    }

    .btn-back {
        display: inline-block;
        margin-top: 2rem;
        background-color: var(--primary);
        color: white;
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        border: none;
        border-radius: var(--radius);
        cursor: pointer;
        transition: background-color 0.3s ease;
        text-decoration: none;
    }

    .btn-back:hover {
        background-color: var(--primary-hover);
    }

    @media (max-width: 768px) {
        .site-error {
            margin: 40px 1rem;
            padding: 1rem;
        }

        .btn-back {
            margin-top: 1.5rem;
        }
    }
</style>

<div class="site-error">
    <h1>❌ <?= Html::encode($this->title) ?></h1>

    <div class="alert">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p class="error-description">
        Вышеуказанная ошибка произошла при обработке запроса веб-сервером.
    </p>
    <p class="error-description">
        Если вы считаете, что это ошибка сервера — пожалуйста, свяжитесь с нами.
    </p>

    <a href="<?= Yii::$app->homeUrl ?>" class="btn-back">← Вернуться на главную</a>
</div>