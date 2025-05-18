<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <?php $this->head() ?>
        <style>
            :root {
                --primary: #2563eb;
                --primary-hover: #1d4ed8;
                --primary-light: #dbeafe;
                --secondary: #f3f4f6;
                --dark: #1f2937;
                --light: #f9fafb;
                --gray: #6b7280;
                --gray-light: #e5e7eb;
                --danger: #ef4444;
                --success: #10b981;
                --warning: #f59e0b;
                --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
                --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
                --radius-sm: 0.25rem;
                --radius: 0.5rem;
                --radius-lg: 0.75rem;
                --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            body {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
                color: var(--dark);
                line-height: 1.6;
                -webkit-font-smoothing: antialiased;
            }

            /* Header styles */
            .top-bar {
                font-size: 0.875rem;
                color: white;
                background: linear-gradient(90deg, #2563eb 0%, #1e40af 100%);
            }

            .top-bar-item {
                display: flex;
                align-items: center;
            }

            .hover-opacity-100:hover {
                opacity: 1 !important;
            }

            .main-navbar {
                position: sticky;
                top: 0;
                z-index: 1020;
                padding-top: 0.5rem;
                padding-bottom: 0.5rem;
                background-color: white;
                box-shadow: var(--shadow);
            }

            .search-bar .form-control:focus {
                box-shadow: none;
                border-color: var(--primary);
            }

            .search-bar .btn-primary {
                background-color: var(--primary);
                border-color: var(--primary);
            }

            .search-bar .btn-primary:hover {
                background-color: var(--primary-hover);
                border-color: var(--primary-hover);
            }

            .icon-wrapper {
                width: 36px;
                height: 36px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                transition: var(--transition);
            }

            .user-actions a:hover .icon-wrapper {
                background-color: var(--primary-light);
            }

            .user-actions a:hover svg path {
                fill: var(--primary);
            }

            .user-actions a:hover span {
                color: var(--primary);
            }

            /* Category navigation */
            .category-navbar {
                background: linear-gradient(90deg, #2563eb 0%, #1e40af 100%);
            }

            .category-navbar .nav-link {
                color: rgba(255, 255, 255, 0.9);
                padding: 0.5rem 1rem;
                font-weight: 500;
                transition: var(--transition);
                display: flex;
                align-items: center;
                border-radius: var(--radius-lg);
            }

            .category-navbar .nav-link:hover,
            .category-navbar .nav-link.active {
                color: white;
                background-color: rgba(255, 255, 255, 0.15);
            }

            /* Breadcrumbs */
            .breadcrumb-container {
                background-color: var(--light);
                font-size: 0.875rem;
                padding: 0.5rem 0 !important;
            }

            .breadcrumb-item + .breadcrumb-item::before {
                content: ">";
                color: var(--gray);
            }

            .breadcrumb-item a {
                color: var(--gray);
                text-decoration: none;
                transition: var(--transition);
            }

            .breadcrumb-item a:hover {
                color: var(--primary);
            }

            /* Footer */
            .site-footer {
                background-color: var(--dark);
                color: white;
                padding: 3rem 0 1.5rem;
                margin-top: 3rem;
            }

            .footer-column-title {
                font-size: 1.125rem;
                font-weight: 600;
                margin-bottom: 1.25rem;
                position: relative;
            }

            .footer-column-title::after {
                content: '';
                position: absolute;
                bottom: -8px;
                left: 0;
                width: 40px;
                height: 2px;
                background-color: var(--primary);
            }

            .footer-links {
                list-style: none;
                padding: 0;
                margin: 0;
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
            }

            .footer-link {
                color: var(--gray-light);
                transition: var(--transition);
                text-decoration: none;
                font-size: 0.9375rem;
            }

            .footer-link:hover {
                color: white;
                padding-left: 4px;
            }

            .footer-contact-item {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                margin-bottom: 0.75rem;
            }

            .footer-bottom {
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                padding-top: 1.5rem;
                margin-top: 2rem;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 1rem;
            }

            .footer-socials {
                display: flex;
                gap: 1rem;
            }

            .social-link {
                width: 2.5rem;
                height: 2.5rem;
                border-radius: 50%;
                background-color: rgba(255, 255, 255, 0.1);
                display: flex;
                align-items: center;
                justify-content: center;
                transition: var(--transition);
            }

            .social-link:hover {
                background-color: var(--primary);
                transform: translateY(-3px);
            }

            .copyright {
                color: var(--gray-light);
                font-size: 0.875rem;
                margin: 0;
            }

            /* Responsive adjustments */
            @media (max-width: 992px) {
                .main-navbar .d-flex {
                    flex-wrap: wrap;
                    gap: 1rem;
                }

                .search-bar {
                    order: 3;
                    width: 100%;
                    margin: 0.5rem 0 0;
                }
            }

            @media (max-width: 768px) {
                .top-bar {
                    display: none;
                }

                .category-navbar .navbar-nav {
                    gap: 0.25rem;
                    padding-top: 0.5rem;
                }

                .category-navbar .nav-link {
                    padding: 0.5rem !important;
                    border-radius: var(--radius-sm) !important;
                }

                .footer-column {
                    margin-bottom: 2rem;
                }
            }

            @media (max-width: 576px) {
                .user-actions {
                    gap: 1rem;
                }

                .navbar-brand span {
                    font-size: 1.25rem;
                }
            }

            /* Animations */
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }

            .fade-in {
                animation: fadeIn 0.3s ease-out;
            }

            /* Logo gradient */
            .logo-gradient-text {
                background: linear-gradient(90deg, #2563eb 0%, #1e40af 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
        </style>
    </head>
    <body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header class="site-header">
        <!-- Top bar with contact info -->
        <div class="top-bar py-2">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex gap-4">
                        <div class="top-bar-item">
                            <i class="fas fa-phone-alt me-2"></i>
                            <span>+7 (123) 456-78-90</span>
                        </div>
                        <div class="top-bar-item">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <span>Москва, ул. Примерная, 123</span>
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white opacity-75 hover-opacity-100"><i class="fab fa-vk"></i></a>
                        <a href="#" class="text-white opacity-75 hover-opacity-100"><i class="fab fa-telegram"></i></a>
                        <a href="#" class="text-white opacity-75 hover-opacity-100"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main navigation bar -->
        <div class="main-navbar">
            <div class="container">
                <div class="d-flex align-items-center">
                    <!-- Logo -->
                    <a class="navbar-brand me-4" href="<?= Yii::$app->homeUrl ?>">
                        <svg width="32" height="32" viewBox="0 0 32 32" class="me-2">
                            <path fill="url(#logo-gradient)" d="M16 0a16 16 0 1 0 16 16A16 16 0 0 0 16 0zm0 30a14 14 0 1 1 14-14 14 14 0 0 1-14 14z"/>
                            <path fill="url(#logo-gradient)" d="M22 12a2 2 0 0 0-2-2h-8a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zm-2 0l-4 4-4-4z"/>
                        </svg>
                        <span class="fw-bold fs-4 logo-gradient-text"><?= Html::encode(Yii::$app->name) ?></span>
                    </a>

                    <!-- Search bar -->
                    <div class="search-bar flex-grow-1 mx-3 position-relative">
                        <form class="d-flex">
                            <div class="input-group">
                                <input type="text" class="form-control border-2 border-primary rounded-pill ps-4 pe-5 py-2" placeholder="Поиск товаров..." style="box-shadow: none;">
                                <button class="btn btn-primary rounded-pill position-absolute end-0 top-0 bottom-0 m-1 px-3" type="submit" style="z-index: 5;">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- User actions -->
                    <div class="user-actions d-flex gap-3 ms-auto">
                        <?php if (Yii::$app->user->isGuest): ?>
                            <a href="<?= Yii::$app->urlManager->createUrl(['/site/login']) ?>" class="d-flex flex-column align-items-center text-decoration-none position-relative">
                                <div class="icon-wrapper bg-primary bg-opacity-10 p-2 rounded-circle">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="#2563eb">
                                        <path d="M12 12C14.2091 12 16 10.2091 16 8C16 5.79086 14.2091 4 12 4C9.79086 4 8 5.79086 8 8C8 10.2091 9.79086 12 12 12Z"/>
                                        <path d="M12 14C7.58172 14 4 17.5817 4 22H20C20 17.5817 16.4183 14 12 14Z"/>
                                    </svg>
                                </div>
                                <span class="fs-xs mt-1 text-muted">Войти</span>
                            </a>
                        <?php else: ?>
                            <div class="dropdown">
                                <a href="#" class="d-flex flex-column align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                                    <div class="icon-wrapper bg-primary bg-opacity-10 p-2 rounded-circle">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="#2563eb">
                                            <path d="M12 12C14.2091 12 16 10.2091 16 8C16 5.79086 14.2091 4 12 4C9.79086 4 8 5.79086 8 8C8 10.2091 9.79086 12 12 12Z"/>
                                            <path d="M12 14C7.58172 14 4 17.5817 4 22H20C20 17.5817 16.4183 14 12 14Z"/>
                                        </svg>
                                    </div>
                                    <span class="fs-xs mt-1 text-muted">Аккаунт</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow">
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Профиль</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-box me-2"></i>Заказы</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <?= Html::beginForm(['/site/logout'], 'post') ?>
                                        <?= Html::submitButton('<i class="fas fa-sign-out-alt me-2"></i>Выйти', ['class' => 'dropdown-item']) ?>
                                        <?= Html::endForm() ?>
                                    </li>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <a href="<?= Yii::$app->urlManager->createUrl(['/wishlist/index']) ?>" class="d-flex flex-column align-items-center text-decoration-none position-relative">
                            <div class="icon-wrapper bg-primary bg-opacity-10 p-2 rounded-circle">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="#2563eb">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                            </div>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.5rem; padding: 0.25rem 0.35rem;">3</span>
                            <span class="fs-xs mt-1 text-muted">Избранное</span>
                        </a>

                        <a href="<?= Yii::$app->urlManager->createUrl(['/cart/index']) ?>" class="d-flex flex-column align-items-center text-decoration-none position-relative">
                            <div class="icon-wrapper bg-primary bg-opacity-10 p-2 rounded-circle">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="#2563eb">
                                    <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                                </svg>
                            </div>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.5rem; padding: 0.25rem 0.35rem;">5</span>
                            <span class="fs-xs mt-1 text-muted">Корзина</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark category-navbar">
            <div class="container">
                <button class="navbar-toggler border-0 px-2 py-1 rounded-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCategories" aria-controls="navbarCategories" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    <span class="ms-2 fw-medium">Меню</span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCategories">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex align-items-center" style="gap: 0.5rem;">
                        <li class="nav-item">
                            <a class="nav-link px-3 py-2 rounded-pill d-flex align-items-center active" href="<?= Yii::$app->urlManager->createUrl(['catalog/index']) ?>">
                                <i class="fas fa-list me-2"></i> Каталог
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 py-2 rounded-pill d-flex align-items-center" href="<?= Yii::$app->urlManager->createUrl(['catalog/new']) ?>">
                                <i class="fas fa-star me-2"></i> Новинки
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 py-2 rounded-pill d-flex align-items-center" href="<?= Yii::$app->urlManager->createUrl(['catalog/sale']) ?>">
                                <i class="fas fa-percentage me-2"></i> Акции
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 py-2 rounded-pill d-flex align-items-center" href="<?= Yii::$app->urlManager->createUrl(['catalog/brands']) ?>">
                                <i class="fas fa-copyright me-2"></i> Бренды
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 py-2 rounded-pill d-flex align-items-center" href="<?= Yii::$app->urlManager->createUrl(['site/about']) ?>">
                                <i class="fas fa-info-circle me-2"></i> О магазине
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 py-2 rounded-pill d-flex align-items-center" href="<?= Yii::$app->urlManager->createUrl(['/site/contact']) ?>">
                                <i class="fas fa-phone-alt me-2"></i> Контакты
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main role="main" class="flex-shrink-0">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'options' => ['class' => 'breadcrumb-container py-2 bg-light mb-0'],
            'itemTemplate' => '<li class="breadcrumb-item">{link}</li>',
            'activeItemTemplate' => '<li class="breadcrumb-item active">{link}</li>'
        ]) ?>

        <div class="container my-4">
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-4 mb-md-0">
                    <h4 class="footer-column-title">Магазин</h4>
                    <ul class="footer-links">
                        <li><a href="#" class="footer-link">О нас</a></li>
                        <li><a href="#" class="footer-link">Каталог</a></li>
                        <li><a href="#" class="footer-link">Новинки</a></li>
                        <li><a href="#" class="footer-link">Акции</a></li>
                        <li><a href="#" class="footer-link">Бренды</a></li>
                    </ul>
                </div>

                <div class="col-md-3 mb-4 mb-md-0">
                    <h4 class="footer-column-title">Помощь</h4>
                    <ul class="footer-links">
                        <li><a href="#" class="footer-link">Доставка и оплата</a></li>
                        <li><a href="#" class="footer-link">Возврат и обмен</a></li>
                        <li><a href="#" class="footer-link">Размеры</a></li>
                        <li><a href="#" class="footer-link">FAQ</a></li>
                        <li><a href="#" class="footer-link">Контакты</a></li>
                    </ul>
                </div>

                <div class="col-md-3 mb-4 mb-md-0">
                    <h4 class="footer-column-title">Контакты</h4>
                    <ul class="footer-links">
                        <li class="footer-contact-item">
                            <i class="fas fa-phone footer-icon"></i>
                            <a href="tel:+78005553535" class="footer-link">8 (800) 555-35-35</a>
                        </li>
                        <li class="footer-contact-item">
                            <i class="fas fa-envelope footer-icon"></i>
                            <a href="mailto:info@luxe.ru" class="footer-link">info@luxe.ru</a>
                        </li>
                        <li class="footer-contact-item">
                            <i class="fas fa-map-marker-alt footer-icon"></i>
                            <span>Москва, ул. Примерная, 123</span>
                        </li>
                        <li class="footer-contact-item">
                            <i class="fas fa-clock footer-icon"></i>
                            <span>Ежедневно с 10:00 до 22:00</span>
                        </li>
                    </ul>
                </div>

                <div class="col-md-3">
                    <h4 class="footer-column-title">Подписаться</h4>
                    <p class="footer-subscribe-text">Будьте в курсе новинок и специальных предложений</p>
                    <form class="mb-3">
                        <div class="input-group">
                            <input type="email" class="form-control bg-dark border-dark text-white" placeholder="Ваш email">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                    <div class="d-flex gap-2">
                        <a href="#" class="social-link"><i class="fab fa-vk"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-telegram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="footer-socials">
                    <a href="#" class="social-link" aria-label="VK"><i class="fab fa-vk"></i></a>
                    <a href="#" class="social-link" aria-label="Telegram"><i class="fab fa-telegram"></i></a>
                    <a href="#" class="social-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                </div>
                <div class="footer-legal">
                    <p class="copyright">© <?= date('Y') ?> <?= Html::encode(Yii::$app->name) ?>. Все права защищены.</p>
                    <div class="footer-links-horizontal">
                        <a href="#" class="footer-link">Политика конфиденциальности</a>
                        <span class="mx-2">|</span>
                        <a href="#" class="footer-link">Условия использования</a>
                        <span class="mx-2">|</span>
                        <a href="#" class="footer-link">Карта сайта</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <svg width="0" height="0" style="position: absolute;">
        <defs>
            <linearGradient id="logo-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#2563eb" />
                <stop offset="100%" stop-color="#1e40af" />
            </linearGradient>
        </defs>
    </svg>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage(); ?>