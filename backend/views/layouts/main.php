```php
<?php
/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

// Регистрируем кастомные стили
$this->registerCss('
    :root {
        --primary-color: #667eea;
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --bg-primary: #0f0f23;
        --bg-secondary: #1a1a2e;
        --bg-card: rgba(255,255,255,0.04);
        --border-color: rgba(255,255,255,0.08);
        --text-primary: #ffffff;
        --text-secondary: rgba(255,255,255,0.7);
        --text-muted: rgba(255,255,255,0.5);
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
        box-sizing: border-box;
    }

    body {
        background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%) !important;
        color: var(--text-primary) !important;
        font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
        line-height: 1.6;
        min-height: 100vh;
    }

    /* Современная навигация */
    .navbar {
        background: rgba(255,255,255,0.08) !important;
        backdrop-filter: blur(20px);
        border-bottom: 1px solid var(--border-color) !important;
        padding: 0.5rem 0 !important; /* Уменьшено в 2 раза */
        transition: var(--transition);
    }

    .navbar-brand {
        font-weight: 600 !important;
        font-size: 1rem !important; /* Уменьшено с 1.25rem */
        color: var(--text-primary) !important;
        display: flex !important;
        align-items: center !important;
        gap: 0.5rem !important;
    }

    .navbar-brand:hover {
        color: var(--primary-color) !important;
    }

    .navbar-brand::before {
        content: "";
        width: 24px; /* Уменьшено с 32px */
        height: 24px;
        background: var(--primary-gradient);
        border-radius: 6px;
        display: inline-block;
        mask: url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'24\' height=\'24\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3E%3Cpath d=\'m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z\'/%3E%3Cpolyline points=\'9,22 9,12 15,12 15,22\'/%3E%3C/svg%3E") no-repeat center;
        -webkit-mask: url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'24\' height=\'24\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3E%3Cpath d=\'m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z\'/%3E%3Cpolyline points=\'9,22 9,12 15,12 15,22\'/%3E%3C/svg%3E") no-repeat center;
    }

    .navbar-nav .nav-link {
        color: var(--text-secondary) !important;
        font-weight: 500 !important;
        padding: 0.5rem 0.75rem !important; /* Уменьшено с 0.75rem 1rem */
        border-radius: 6px !important;
        transition: var(--transition) !important;
        position: relative !important;
        display: flex !important;
        align-items: center !important;
        gap: 0.5rem !important;
    }

    .navbar-nav .nav-link:hover {
        color: var(--text-primary) !important;
        background: rgba(255,255,255,0.08) !important;
    }

    .navbar-nav .nav-link.active {
        color: var(--text-primary) !important;
        background: var(--primary-gradient) !important;
    }

    /* SVG иконки для пунктов меню */
    .navbar-nav .nav-link[href*="user"]::before {
        content: "";
        width: 12px; /* Уменьшено с 16px */
        height: 12px;
        background: currentColor;
        mask: url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'24\' height=\'24\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3E%3Cpath d=\'M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2\'/%3E%3Ccircle cx=\'12\' cy=\'7\' r=\'4\'/%3E%3C/svg%3E") no-repeat center;
        -webkit-mask: url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'24\' height=\'24\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3E%3Cpath d=\'M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2\'/%3E%3Ccircle cx=\'12\' cy=\'7\' r=\'4\'/%3E%3C/svg%3E") no-repeat center;
    }

    .navbar-nav .nav-link[href*="product"]::before {
        content: "";
        width: 12px; /* Уменьшено с 16px */
        height: 12px;
        background: currentColor;
        mask: url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'24\' height=\'24\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3E%3Cpath d=\'M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z\'/%3E%3Cpath d=\'M3 6h18\'/%3E%3Cpath d=\'M16 10a4 4 0 0 1-8 0\'/%3E%3C/svg%3E") no-repeat center;
        -webkit-mask: url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'24\' height=\'24\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3E%3Cpath d=\'M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z\'/%3E%3Cpath d=\'M3 6h18\'/%3E%3Cpath d=\'M16 10a4 4 0 0 1-8 0\'/%3E%3C/svg%3E") no-repeat center;
    }

    .navbar-nav .nav-link[href*="property"]::before {
        content: "";
        width: 12px; /* Уменьшено с 16px */
        height: 12px;
        background: currentColor;
        mask: url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'24\' height=\'24\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3E%3Cpath d=\'M9 12h6\'/%3E%3Cpath d=\'M9 16h6\'/%3E%3Cpath d=\'m20 6-2-2H6L4 6v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2z\'/%3E%3Cpath d=\'M16 2v4\'/%3E%3Cpath d=\'M8 2v4\'/%3E%3C/svg%3E") no-repeat center;
        -webkit-mask: url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'24\' height=\'24\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3E%3Cpath d=\'M9 12h6\'/%3E%3Cpath d=\'M9 16h6\'/%3E%3Cpath d=\'m20 6-2-2H6L4 6v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2z\'/%3E%3Cpath d=\'M16 2v4\'/%3E%3Cpath d=\'M8 2v4\'/%3E%3C/svg%3E") no-repeat center;
    }

    .navbar-nav .nav-link[href*="city"]::before {
        content: "";
        width: 12px; /* Уменьшено с 16px */
        height: 12px;
        background: currentColor;
        mask: url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'24\' height=\'24\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3E%3Cpath d=\'M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z\'/%3E%3Ccircle cx=\'12\' cy=\'10\' r=\'3\'/%3E%3C/svg%3E") no-repeat center;
        -webkit-mask: url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'24\' height=\'24\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3E%3Cpath d=\'M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z\'/%3E%3Ccircle cx=\'12\' cy=\'10\' r=\'3\'/%3E%3C/svg%3E") no-repeat center;
    }

    /* Кнопки входа/выхода */
    .btn-link.login, .btn-link.logout {
        color: var(--text-secondary) !important;
        font-weight: 500 !important;
        text-decoration: none !important;
        padding: 0.5rem 0.75rem !important; /* Уменьшено с 0.75rem 1rem */
        border-radius: 6px !important;
        transition: var(--transition) !important;
        border: 1px solid var(--border-color) !important;
    }

    .btn-link.login:hover, .btn-link.logout:hover {
        color: var(--text-primary) !important;
        background: rgba(255,255,255,0.08) !important;
        border-color: rgba(255,255,255,0.15) !important;
    }

    /* Основной контент */
    main {
        padding-top: 4rem !important; /* Уменьшено с 6rem для учета меньшей высоты хедера */
        flex: 1;
    }

    .container {
        max-width: 1400px !important;
    }

    /* Хлебные крошки */
    .breadcrumb {
        background: var(--bg-card) !important;
        backdrop-filter: blur(10px);
        border: 1px solid var(--border-color) !important;
        border-radius: 8px !important;
        padding: 1rem !important;
        margin-bottom: 2rem !important;
    }

    .breadcrumb-item {
        color: var(--text-secondary) !important;
    }

    .breadcrumb-item.active {
        color: var(--text-primary) !important;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        color: var(--text-muted) !important;
    }

    .breadcrumb-item a {
        color: var(--primary-color) !important;
        text-decoration: none !important;
        transition: var(--transition) !important;
    }

    .breadcrumb-item a:hover {
        color: var(--text-primary) !important;
    }

    /* Алерты */
    .alert {
        background: var(--bg-card) !important;
        border: 1px solid var(--border-color) !important;
        color: var(--text-primary) !important;
        border-radius: 8px !important;
        backdrop-filter: blur(10px);
    }

    .alert-success {
        border-left: 4px solid #10b981 !important;
        background: rgba(16, 185, 129, 0.1) !important;
    }

    .alert-danger {
        border-left: 4px solid #ef4444 !important;
        background: rgba(239, 68, 68, 0.1) !important;
    }

    .alert-warning {
        border-left: 4px solid #f59e0b !important;
        background: rgba(245, 158, 11, 0.1) !important;
    }

    .alert-info {
        border-left: 4px solid var(--primary-color) !important;
        background: rgba(102, 126, 234, 0.1) !important;
    }

    /* Футер */
    .footer {
        background: rgba(255,255,255,0.04) !important;
        backdrop-filter: blur(10px);
        border-top: 1px solid var(--border-color) !important;
        color: var(--text-muted) !important;
        margin-top: 4rem !important;
    }

    .footer p {
        margin: 0 !important;
        font-size: 0.875rem !important;
    }

    /* Карточки и таблицы */
    .card {
        background: var(--bg-card) !important;
        border: 1px solid var(--border-color) !important;
        color: var(--text-primary) !important;
        backdrop-filter: blur(10px);
        border-radius: 12px !important;
    }

    .table {
        color: var(--text-primary) !important;
        background: transparent !important;
    }

    .table thead th {
        background: var(--bg-card) !important;
        border-color: var(--border-color) !important;
        color: var(--text-primary) !important;
        font-weight: 600 !important;
    }

    .table tbody td {
        border-color: var(--border-color) !important;
        color: var(--text-secondary) !important;
    }

    .table tbody tr:hover {
        background: rgba(255,255,255,0.04) !important;
    }

    /* Формы */
    .form-control {
        background: var(--bg-card) !important;
        border: 1px solid var(--border-color) !important;
        color: var(--text-primary) !important;
        border-radius: 6px !important;
    }

    .form-control:focus {
        background: var(--bg-card) !important;
        border-color: var(--primary-color) !important;
        color: var(--text-primary) !important;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25) !important;
    }

    .form-label {
        color: var(--text-primary) !important;
        font-weight: 500 !important;
    }

    /* Кнопки */
    .btn-primary {
        background: var(--primary-gradient) !important;
        border: none !important;
        font-weight: 500 !important;
        transition: var(--transition) !important;
    }

    .btn-primary:hover {
        transform: translateY(-1px) !important;
        box-shadow: var(--shadow) !important;
    }

    .btn-secondary {
        background: var(--bg-card) !important;
        border: 1px solid var(--border-color) !important;
        color: var(--text-primary) !important;
    }

    .btn-secondary:hover {
        background: rgba(255,255,255,0.08) !important;
        border-color: rgba(255,255,255,0.15) !important;
        color: var(--text-primary) !important;
    }

    /* Анимации */
    .fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Адаптивность */
    @media (max-width: 768px) {
        .navbar-brand::before {
            width: 20px; /* Уменьшено с 28px */
            height: 20px;
        }
        
        .navbar-nav .nav-link {
            padding: 0.4rem 0.6rem !important; /* Уменьшено для мобильных */
        }
        
        main {
            padding-top: 3rem !important; /* Уменьшено для мобильных */
        }
    }
');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => 'Панель управления',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Пользователи', 'url' => ['/user/index']],
        ['label' => 'Товары', 'url' => ['/product/index']],
        ['label' => 'Характеристики', 'url' => ['/property/index']],
        ['label' => 'Города доставки', 'url' => ['/city/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Войти', 'url' => ['/site/login']];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
        'items' => $menuItems,
    ]);
    if (Yii::$app->user->isGuest) {
        echo Html::tag('div',Html::a('Вход',['/site/login'],['class' => ['btn btn-link login text-decoration-none']]),['class' => ['d-flex']]);
    } else {
        echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
            . Html::submitButton(
                'Выйти (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout text-decoration-none']
            )
            . Html::endForm();
    }
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container fade-in">
        <?= Breadcrumbs::widget([
            'links' => $this->params['breadcrumbs'] ?? [],
            'homeLink' => [
                'label' => 'Главная',
                'url' => Yii::$app->homeUrl,
            ],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3">
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
