<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'О нас';
?>
<div class="about-page">
    <!-- Hero Section -->
    <section class="about-hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Добро пожаловать в мир ковров</h1>
                <p class="hero-subtitle">Создаем уют и комфорт в вашем доме с 2010 года</p>
                <div class="hero-pattern">
                    <svg viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">
                        <path d="M250,0 C388,0 500,112 500,250 C500,388 388,500 250,500 C112,500 0,388 0,250 C0,112 112,0 250,0 Z" fill="rgba(255,255,255,0.1)"></path>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <div class="section-grid">
                <div class="section-content">
                    <h2 class="section-title">О нашем магазине</h2>
                    <p class="section-text">
                        Наш интернет-магазин ковров в Костроме предлагает широкий выбор высококачественных напольных покрытий для вашего дома или офиса. Мы работаем напрямую с производителями, чтобы предложить вам лучшие цены и уникальные дизайны.
                    </p>
                    <p class="section-text">
                        Каждый ковер в нашем ассортименте проходит строгий контроль качества, чтобы гарантировать долговечность и комфорт. Мы гордимся тем, что наши клиенты остаются довольны не только красотой, но и практичностью наших товаров.
                    </p>
                    <div class="decorative-elements">
                        <div class="decorative-line"></div>
                        <svg class="decorative-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="var(--primary)"/>
                        </svg>
                    </div>
                </div>
                <div class="section-image">
                    <img src="<?= Yii::getAlias('@web') ?>/uploads/about/about.jpg" alt="Ковры в интерьере">
                    <div class="image-frame"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Почему выбирают нас?</h2>
                <p class="section-subtitle">Мы заботимся о каждом клиенте и стремимся сделать процесс покупки максимально удобным</p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2Z" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 8V12" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 16H12.01" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Широкий ассортимент</h3>
                    <p class="feature-text">Более 500 моделей ковров на любой вкус и интерьер</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9 12L11 14L15 10" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Гарантия качества</h3>
                    <p class="feature-text">Только проверенные материалы и производители</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 7H5C3.89543 7 3 7.89543 3 9V18C3 19.1046 3.89543 20 5 20H19C20.1046 20 21 19.1046 21 18V9C21 7.89543 20.1046 7 19 7Z" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 5V3C16 2.46957 15.7893 1.96086 15.4142 1.58579C15.0391 1.21071 14.5304 1 14 1H10C9.46957 1 8.96086 1.21071 8.58579 1.58579C8.21071 1.96086 8 2.46957 8 3V5" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 12H12.01" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Быстрая доставка</h3>
                    <p class="feature-text">Доставляем ковры по Костроме и области за 1 день</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Наш магазин в Костроме</h2>
                <p class="section-subtitle">Приходите к нам за качественными коврами и профессиональными консультациями</p>
            </div>

            <div class="map-container">
                <!-- Яндекс Карта -->
                <div id="map" style="width: 100%; height: 400px;"></div>

                <div class="map-info">
                    <div class="info-item">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 10C21 17 12 23 12 23C12 23 3 17 3 10C3 7.61305 3.94821 5.32387 5.63604 3.63604C7.32387 1.94821 9.61305 1 12 1C14.3869 1 16.6761 1.94821 18.364 3.63604C20.0518 5.32387 21 7.61305 21 10Z" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>г. Кострома, ул. Советская, д. 142</span>
                    </div>
                    <div class="info-item">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22 16.92V19C22 19.5304 21.7893 20.0391 21.4142 20.4142C21.0391 20.7893 20.5304 21 20 21H4C3.46957 21 2.96086 20.7893 2.58579 20.4142C2.21071 20.0391 2 19.5304 2 19V16.92" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M18 9C18 7.4087 17.3679 5.88258 16.2426 4.75736C15.1174 3.63214 13.5913 3 12 3C10.4087 3 8.88258 3.63214 7.75736 4.75736C6.63214 5.88258 6 7.4087 6 9V16H18V9Z" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>Пн-Пт: 9:00 - 20:00, Сб-Вс: 10:00 - 18:00</span>
                    </div>
                    <div class="info-item">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22 16.92V19C22 19.5304 21.7893 20.0391 21.4142 20.4142C21.0391 20.7893 20.5304 21 20 21H4C3.46957 21 2.96086 20.7893 2.58579 20.4142C2.21071 20.0391 2 19.5304 2 19V16.92" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M18 9C18 7.4087 17.3679 5.88258 16.2426 4.75736C15.1174 3.63214 13.5913 3 12 3C10.4087 3 8.88258 3.63214 7.75736 4.75736C6.63214 5.88258 6 7.4087 6 9V16H18V9Z" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>+7 (4942) 123-456</span>
                    </div>
                    <a href="<?= Url::to(['site/contact']) ?>" class="map-button">Связаться с нами</a>
                </div>
            </div>
        </div>
    </section>
</div>

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

    .about-page {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        color: var(--dark);
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
    }

    .container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Hero Section */
    .about-hero {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        color: white;
        padding: 100px 0;
        position: relative;
        overflow: hidden;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 800px;
        margin: 0 auto;
        text-align: center;
    }

    .hero-title {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        opacity: 0.9;
        margin-bottom: 2rem;
    }

    .hero-pattern {
        position: absolute;
        top: 0;
        right: 0;
        height: 100%;
        opacity: 0.1;
    }

    /* About Section */
    .about-section {
        padding: 80px 0;
        background-color: white;
    }

    .section-grid {
        display: flex;
        align-items: center;
        gap: 60px;
    }

    .section-content {
        flex: 1;
    }

    .section-image {
        flex: 1;
        position: relative;
    }

    .section-image img {
        width: 100%;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        position: relative;
        z-index: 2;
    }

    .image-frame {
        position: absolute;
        width: 100%;
        height: 100%;
        border: 2px solid var(--primary);
        border-radius: var(--radius-lg);
        top: 20px;
        left: 20px;
        z-index: 1;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 1.5rem;
        position: relative;
        display: inline-block;
    }

    .section-title:after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 50px;
        height: 3px;
        background-color: var(--primary);
    }

    .section-text {
        font-size: 1.1rem;
        color: var(--gray);
        margin-bottom: 1.5rem;
        line-height: 1.7;
    }

    .decorative-elements {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-top: 30px;
    }

    .decorative-line {
        height: 2px;
        background-color: var(--primary-light);
        flex-grow: 1;
    }

    .decorative-icon {
        flex-shrink: 0;
    }

    /* Features Section */
    .features-section {
        padding: 80px 0;
        background-color: var(--secondary);
    }

    .section-header {
        text-align: center;
        margin-bottom: 60px;
    }

    .section-subtitle {
        font-size: 1.1rem;
        color: var(--gray);
        max-width: 700px;
        margin: 0 auto;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }

    .feature-card {
        background-color: white;
        padding: 40px 30px;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        text-align: center;
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
    }

    .feature-icon {
        width: 80px;
        height: 80px;
        background-color: var(--primary-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    .feature-icon svg {
        width: 40px;
        height: 40px;
    }

    .feature-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 1rem;
    }

    .feature-text {
        font-size: 1rem;
        color: var(--gray);
    }

    /* Map Section */
    .map-section {
        padding: 80px 0;
        background-color: white;
    }

    .map-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
        margin-top: 40px;
    }

    #map {
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow);
        height: 400px;
    }

    .map-info {
        background-color: var(--secondary);
        padding: 30px;
        border-radius: var(--radius-lg);
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
    }

    .info-item svg {
        flex-shrink: 0;
    }

    .info-item span {
        color: var(--gray);
    }

    .map-button {
        display: inline-block;
        background-color: var(--primary);
        color: white;
        padding: 12px 24px;
        border-radius: var(--radius);
        font-weight: 500;
        margin-top: 20px;
        transition: var(--transition);
        text-align: center;
        width: 100%;
    }

    .map-button:hover {
        background-color: var(--primary-hover);
        color: white;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .section-grid {
            flex-direction: column;
        }

        .map-container {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }

        .features-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Яндекс Карта -->
<script src="https://api-maps.yandex.ru/2.1/?apikey=ваш_api_ключ&lang=ru_RU" type="text/javascript"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        ymaps.ready(init);

        function init() {
            var myMap = new ymaps.Map("map", {
                center: [57.767265, 40.926858], // Координаты ул. Советская, 142
                zoom: 16
            });

            var myPlacemark = new ymaps.Placemark([57.767265, 40.926858], {
                hintContent: 'Магазин ковров',
                balloonContent: 'ул. Советская, д. 142'
            }, {
                iconLayout: 'default#image',
                iconImageHref: 'https://cdn-icons-png.flaticon.com/512/484/484167.png',
                iconImageSize: [40, 40],
                iconImageOffset: [-20, -40]
            });

            myMap.geoObjects.add(myPlacemark);
        }
    });
</script>