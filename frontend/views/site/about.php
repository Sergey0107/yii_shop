<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'О нас';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <div class="about-header">
        <h1>Добро пожаловать в мир ковров!</h1>
        <p class="subtitle">Мы создаем уют и комфорт в вашем доме с 2010 года.</p>
    </div>

    <div class="about-content">
        <div class="about-section">
            <div class="about-text">
                <h2>О нашем магазине</h2>
                <p>
                    Наш интернет-магазин ковров в Костроме предлагает широкий выбор высококачественных напольных покрытий для вашего дома или офиса. Мы работаем напрямую с производителями, чтобы предложить вам лучшие цены и уникальные дизайны.
                </p>
                <p>
                    Каждый ковер в нашем ассортименте проходит строгий контроль качества, чтобы гарантировать долговечность и комфорт. Мы гордимся тем, что наши клиенты остаются довольны не только красотой, но и практичностью наших товаров.
                </p>
            </div>
            <div class="about-image">
                <img src="<?= Yii::getAlias('@web') ?>/uploads/about/about.jpg" alt="Ковры в интерьере">
            </div>
        </div>

        <div class="about-section reverse">
            <div class="about-text">
                <h2>Почему выбирают нас?</h2>
                <p>
                    Мы заботимся о каждом клиенте и стремимся сделать процесс покупки максимально удобным. Наши консультанты всегда готовы помочь вам подобрать идеальный ковер, который дополнит ваш интерьер и создаст атмосферу уюта.
                </p>
                <p>
                    Доставка по Костроме и области осуществляется в кратчайшие сроки. Мы также предлагаем услуги профессиональной укладки ковров и их последующего обслуживания.
                </p>
            </div>
            <div class="about-image">
                <img src="<?= Yii::getAlias('@web') ?>/uploads/about/about2.jpg" alt="Доставка ковров">
            </div>
        </div>

        <div class="about-features">
            <h2>Наши преимущества</h2>
            <div class="feature-grid">
                <div class="feature-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#17a2b8" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                        <path d="M11 16h2v-2h-2v2zm0-5h2V9h-2v2z"/>
                    </svg>
                    <h3>Широкий ассортимент</h3>
                    <p>Более 500 моделей ковров на любой вкус.</p>
                </div>
                <div class="feature-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#17a2b8" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                        <path d="M11 16h2v-2h-2v2zm0-5h2V9h-2v2z"/>
                    </svg>
                    <h3>Гарантия качества</h3>
                    <p>Только проверенные материалы и производители.</p>
                </div>
                <div class="feature-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#17a2b8" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                        <path d="M11 16h2v-2h-2v2zm0-5h2V9h-2v2z"/>
                    </svg>
                    <h3>Быстрая доставка</h3>
                    <p>Доставляем ковры по Костроме и области за 1 день.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .site-about {
        background-color: #f8f9fa;
        padding: 40px 20px;
        text-align: center;
    }

    .about-header h1 {
        font-size: 36px;
        color: #343a40;
        margin-bottom: 10px;
    }

    .subtitle {
        font-size: 18px;
        color: #6c757d;
        margin-bottom: 40px;
    }

    .about-section {
        display: flex;
        align-items: center;
        margin-bottom: 40px;
        gap: 30px;
        flex-wrap: wrap;
    }

    .about-section.reverse {
        flex-direction: row-reverse;
    }

    .about-text {
        flex: 1;
        text-align: left;
    }

    .about-text h2 {
        font-size: 24px;
        color: #343a40;
        margin-bottom: 15px;
    }

    .about-text p {
        font-size: 16px;
        color: #555;
        line-height: 1.6;
    }

    .about-image img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.06);
        flex: 1;
    }

    .about-features {
        margin-top: 40px;
    }

    .about-features h2 {
        font-size: 28px;
        color: #343a40;
        margin-bottom: 20px;
    }

    .feature-grid {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
    }

    .feature-item {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.06);
        text-align: center;
        flex: 1;
        min-width: 200px;
    }

    .feature-item svg {
        margin-bottom: 15px;
    }

    .feature-item h3 {
        font-size: 18px;
        color: #343a40;
        margin-bottom: 10px;
    }

    .feature-item p {
        font-size: 14px;
        color: #6c757d;
    }

    @media (max-width: 768px) {
        .about-section {
            flex-direction: column;
        }

        .about-section.reverse {
            flex-direction: column;
        }
    }
</style>