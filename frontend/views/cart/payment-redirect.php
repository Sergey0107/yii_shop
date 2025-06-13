<?php
/** @var string $formHtml */
?>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Перенаправление на оплату</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .redirect-container {
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .redirect-title {
            color: #333;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .redirect-text {
            color: #666;
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 24px;
        }

        .payment-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 24px;
            border-left: 4px solid #667eea;
        }

        .manual-submit {
            background: #667eea;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .manual-submit:hover {
            background: #5a6fd8;
        }

        .security-note {
            font-size: 14px;
            color: #888;
            margin-top: 20px;
            padding: 16px;
            background: #f1f3f4;
            border-radius: 8px;
        }

        .loading-dots {
            display: inline-block;
        }

        .loading-dots::after {
            content: '';
            animation: dots 1.5s infinite;
        }

        @keyframes dots {
            0%, 20% { content: ''; }
            40% { content: '.'; }
            60% { content: '..'; }
            80%, 100% { content: '...'; }
        }
    </style>
</head>
<body>
<div class="redirect-container">
    <div class="spinner"></div>

    <h1 class="redirect-title">Перенаправление на оплату</h1>

    <p class="redirect-text">
        Пожалуйста, подождите<span class="loading-dots"></span><br>
        Вы будете автоматически перенаправлены на страницу оплаты ЮMoney.
    </p>

    <div class="payment-info">
        <strong>Безопасная оплата через ЮMoney</strong><br>
        Все платежи защищены современными технологиями шифрования
    </div>

    <!-- Здесь будет вставлена форма из PHP -->
    <?php echo $formHtml; ?>

    <button type="button" class="manual-submit" onclick="submitPaymentForm()" style="display: none;" id="manualSubmit">
        Перейти к оплате
    </button>

    <div class="security-note">
        <strong>🔒 Безопасность:</strong> Ваши данные передаются по защищенному соединению.
        Мы не храним информацию о банковских картах.
    </div>
</div>

<script>
    // Функция для автоматической отправки формы
    function autoSubmitPaymentForm() {
        const form = document.querySelector('form');
        if (form) {
            // Небольшая задержка для лучшего UX
            setTimeout(() => {
                form.submit();
            }, 5000);
        } else {
            // Если форма не найдена, показываем кнопку ручной отправки
            setTimeout(() => {
                document.getElementById('manualSubmit').style.display = 'inline-block';
                document.querySelector('.spinner').style.display = 'none';
                document.querySelector('.redirect-text').innerHTML =
                    'Не удалось автоматически перенаправить на страницу оплаты.<br>Нажмите кнопку ниже для продолжения.';
            }, 3000);
        }
    }

    // Функция для ручной отправки формы
    function submitPaymentForm() {
        const form = document.querySelector('form');
        if (form) {
            form.submit();
        } else {
            alert('Ошибка: форма оплаты не найдена. Обратитесь в службу поддержки.');
        }
    }

    // Запускаем автоматическую отправку при загрузке страницы
    document.addEventListener('DOMContentLoaded', function() {
        autoSubmitPaymentForm();
    });

    // Обработка случая, когда пользователь возвращается на страницу
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            // Страница была восстановлена из кэша
            location.reload();
        }
    });

    // Предотвращение двойной отправки формы
    let formSubmitted = false;
    document.addEventListener('submit', function(e) {
        if (formSubmitted) {
            e.preventDefault();
            return false;
        }
        formSubmitted = true;
    });
</script>
</body>
</html>