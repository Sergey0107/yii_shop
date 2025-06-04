<?php
/**
 * @var yii\web\View $this
 */

use yii\helpers\Html;

$this->title = 'Ковровые изделия: искусство уюта в вашем доме';
$this->registerCssFile('@web/css/carpet-article.css');
?>

<!-- Баннер -->
<div class="carpet-banner">
    <div class="banner-content">
        <div class="banner-text">
            <h1 class="banner-title">
                <svg class="carpet-icon" viewBox="0 0 64 64" width="48" height="48">
                    <rect x="8" y="16" width="48" height="32" fill="#2563eb" rx="4"/>
                    <rect x="12" y="20" width="40" height="24" fill="#ffffff" rx="2"/>
                    <circle cx="20" cy="28" r="2" fill="#2563eb"/>
                    <circle cx="32" cy="28" r="2" fill="#2563eb"/>
                    <circle cx="44" cy="28" r="2" fill="#2563eb"/>
                    <circle cx="20" cy="36" r="2" fill="#2563eb"/>
                    <circle cx="32" cy="36" r="2" fill="#2563eb"/>
                    <circle cx="44" cy="36" r="2" fill="#2563eb"/>
                </svg>
                Мир ковровых изделий
            </h1>
            <p class="banner-subtitle">Превратите свой дом в оазис комфорта и стиля</p>
        </div>
        <div class="banner-decoration">
            <svg viewBox="0 0 200 200" width="200" height="200">
                <defs>
                    <pattern id="carpetPattern" patternUnits="userSpaceOnUse" width="20" height="20">
                        <rect width="20" height="20" fill="#dbeafe"/>
                        <circle cx="10" cy="10" r="3" fill="#2563eb" opacity="0.3"/>
                    </pattern>
                </defs>
                <rect width="200" height="200" fill="url(#carpetPattern)" rx="20"/>
                <path d="M50 50 Q100 30 150 50 Q170 100 150 150 Q100 170 50 150 Q30 100 50 50" fill="#ffffff" opacity="0.8"/>
            </svg>
        </div>
    </div>
</div>

<!-- Основной контент -->
<div class="carpet-article">
    <div class="article-container">

        <!-- Введение -->
        <section class="article-intro">
            <div class="intro-content">
                <h2>Ковры — это не просто напольное покрытие</h2>
                <p class="lead-text">
                    Это искусство, которое веками украшает наши дома, создавая атмосферу уюта
                    и демонстрируя изысканный вкус хозяев. Правильно подобранный ковер способен
                    преобразить любое пространство, добавив ему тепла, цвета и текстуры.
                </p>
            </div>
            <div class="intro-image">
                <div class="image-placeholder">
                    <svg viewBox="0 0 300 200" width="100%" height="200">
                        <rect width="300" height="200" fill="#f8fafc" stroke="#e2e8f0" stroke-width="2" rx="8"/>
                        <rect x="20" y="40" width="260" height="120" fill="#2563eb" rx="6"/>
                        <rect x="30" y="50" width="240" height="100" fill="#ffffff" rx="4"/>
                        <g fill="#2563eb" opacity="0.6">
                            <circle cx="80" cy="80" r="4"/>
                            <circle cx="120" cy="80" r="4"/>
                            <circle cx="160" cy="80" r="4"/>
                            <circle cx="200" cy="80" r="4"/>
                            <circle cx="80" cy="120" r="4"/>
                            <circle cx="120" cy="120" r="4"/>
                            <circle cx="160" cy="120" r="4"/>
                            <circle cx="200" cy="120" r="4"/>
                        </g>
                        <text x="150" y="185" text-anchor="middle" fill="#64748b" font-size="12">Элегантный ковер в интерьере</text>
                    </svg>
                </div>
            </div>
        </section>

        <!-- Типы ковров -->
        <section class="article-section">
            <h2 class="section-title">
                <svg class="section-icon" viewBox="0 0 24 24" width="24" height="24">
                    <path fill="#2563eb" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                </svg>
                Основные типы ковровых изделий
            </h2>

            <div class="carpet-types">
                <div class="carpet-type-card">
                    <div class="card-icon">
                        <svg viewBox="0 0 60 60" width="60" height="60">
                            <rect x="5" y="15" width="50" height="30" fill="#2563eb" rx="5"/>
                            <rect x="10" y="20" width="40" height="20" fill="#ffffff" rx="3"/>
                            <path d="M15 25 L45 25 M15 30 L45 30 M15 35 L45 35" stroke="#2563eb" stroke-width="2"/>
                        </svg>
                    </div>
                    <h3>Персидские ковры</h3>
                    <p>Традиционные ковры ручной работы с богатыми орнаментами и высочайшим качеством изготовления.</p>
                </div>

                <div class="carpet-type-card">
                    <div class="card-icon">
                        <svg viewBox="0 0 60 60" width="60" height="60">
                            <rect x="5" y="15" width="50" height="30" fill="#1e40af" rx="5"/>
                            <rect x="10" y="20" width="40" height="20" fill="#dbeafe" rx="3"/>
                            <g fill="#2563eb">
                                <circle cx="20" cy="27" r="2"/>
                                <circle cx="30" cy="27" r="2"/>
                                <circle cx="40" cy="27" r="2"/>
                                <circle cx="20" cy="37" r="2"/>
                                <circle cx="30" cy="37" r="2"/>
                                <circle cx="40" cy="37" r="2"/>
                            </g>
                        </svg>
                    </div>
                    <h3>Современные ковры</h3>
                    <p>Минималистичные дизайны, подходящие для современных интерьеров с акцентом на функциональность.</p>
                </div>

                <div class="carpet-type-card">
                    <div class="card-icon">
                        <svg viewBox="0 0 60 60" width="60" height="60">
                            <rect x="5" y="15" width="50" height="30" fill="#3b82f6" rx="5"/>
                            <rect x="10" y="20" width="40" height="20" fill="#f1f5f9" rx="3"/>
                            <path d="M15 25 Q25 22 35 25 Q45 28 45 35 Q35 38 25 35 Q15 32 15 25" fill="#2563eb" opacity="0.6"/>
                        </svg>
                    </div>
                    <h3>Детские ковры</h3>
                    <p>Яркие, безопасные и легкие в уходе ковры с обучающими и развивающими элементами.</p>
                </div>
            </div>
        </section>

        <!-- Как правильно использовать -->
        <section class="article-section">
            <h2 class="section-title">
                <svg class="section-icon" viewBox="0 0 24 24" width="24" height="24">
                    <path fill="#2563eb" d="M9 11H7v6h2v-6zm4 0h-2v6h2v-6zm4 0h-2v6h2v-6zm2.5-9H18V0h-2v2H8V0H6v2H4.5C3.67 2 3 2.67 3 3.5v15C3 19.33 3.67 20 4.5 20h15c.83 0 1.5-.67 1.5-1.5v-15C21 2.67 20.33 2 19.5 2z"/>
                </svg>
                Правила размещения и использования
            </h2>

            <div class="usage-tips">
                <div class="tip-item">
                    <div class="tip-number">1</div>
                    <div class="tip-content">
                        <h4>Размер имеет значение</h4>
                        <p>Ковер должен соответствовать размеру комнаты. В гостиной он должен быть достаточно большим,
                            чтобы все основные предметы мебели стояли на нем или касались его краев.</p>
                    </div>
                </div>

                <div class="tip-item">
                    <div class="tip-number">2</div>
                    <div class="tip-content">
                        <h4>Цветовая гармония</h4>
                        <p>Выбирайте ковер, который дополняет общую цветовую схему интерьера. Он может быть как
                            нейтральным фоном, так и ярким акцентом в комнате.</p>
                    </div>
                </div>

                <div class="tip-item">
                    <div class="tip-number">3</div>
                    <div class="tip-content">
                        <h4>Функциональность</h4>
                        <p>Учитывайте назначение помещения: для спальни подойдут мягкие ковры с высоким ворсом,
                            а для прихожей — более практичные и износостойкие.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Уход за коврами -->
        <section class="article-section care-section">
            <h2 class="section-title">
                <svg class="section-icon" viewBox="0 0 24 24" width="24" height="24">
                    <path fill="#2563eb" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
                Секреты правильного ухода
            </h2>

            <div class="care-grid">
                <div class="care-card">
                    <div class="care-icon">
                        <svg viewBox="0 0 48 48" width="48" height="48">
                            <circle cx="24" cy="24" r="20" fill="#dbeafe"/>
                            <path d="M24 8 L24 40 M8 24 L40 24" stroke="#2563eb" stroke-width="3" stroke-linecap="round"/>
                            <circle cx="24" cy="24" r="3" fill="#2563eb"/>
                        </svg>
                    </div>
                    <h4>Регулярная уборка</h4>
                    <p>Пылесосьте ковер 2-3 раза в неделю, особенно в местах с высокой проходимостью.</p>
                </div>

                <div class="care-card">
                    <div class="care-icon">
                        <svg viewBox="0 0 48 48" width="48" height="48">
                            <circle cx="24" cy="24" r="20" fill="#dbeafe"/>
                            <path d="M16 20 Q24 16 32 20 Q36 24 32 28 Q24 32 16 28 Q12 24 16 20" fill="#2563eb"/>
                            <circle cx="24" cy="24" r="2" fill="#ffffff"/>
                        </svg>
                    </div>
                    <h4>Профессиональная чистка</h4>
                    <p>Раз в год обращайтесь к специалистам для глубокой очистки и восстановления ковра.</p>
                </div>

                <div class="care-card">
                    <div class="care-icon">
                        <svg viewBox="0 0 48 48" width="48" height="48">
                            <circle cx="24" cy="24" r="20" fill="#dbeafe"/>
                            <rect x="18" y="18" width="12" height="12" fill="#2563eb" rx="2"/>
                            <path d="M20 20 L28 28 M28 20 L20 28" stroke="#ffffff" stroke-width="2"/>
                        </svg>
                    </div>
                    <h4>Удаление пятен</h4>
                    <p>Немедленно удаляйте пятна, промокая (не растирая) чистой тканью от краев к центру.</p>
                </div>
            </div>
        </section>

        <!-- Заключение -->
        <section class="article-conclusion">
            <div class="conclusion-content">
                <h2>Ковер — это инвестиция в уют</h2>
                <p>
                    Правильно выбранный и ухоженный ковер прослужит вам долгие годы, радуя глаз
                    и создавая неповторимую атмосферу в доме. Помните, что качественные ковровые
                    изделия не только украшают интерьер, но и улучшают акустику помещения,
                    обеспечивают дополнительное тепло и комфорт.
                </p>
                <div class="cta-button">
                    <?= Html::a('Узнать больше о коврах', '#', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <div class="conclusion-decoration">
                <svg viewBox="0 0 150 150" width="150" height="150">
                    <defs>
                        <radialGradient id="carpetGrad" cx="50%" cy="50%" r="50%">
                            <stop offset="0%" style="stop-color: #ffffff; stop-opacity: 1"/>
                            <stop offset="100%" style="stop-color: #2563eb; stop-opacity: 0.1"/>
                        </radialGradient>
                    </defs>
                    <circle cx="75" cy="75" r="70" fill="url(#carpetGrad)" stroke="#2563eb" stroke-width="2"/>
                    <path d="M35 75 Q75 35 115 75 Q75 115 35 75" fill="#2563eb" opacity="0.2"/>
                    <circle cx="75" cy="75" r="5" fill="#2563eb"/>
                </svg>
            </div>
        </section>
    </div>
</div>

<style>
    /* Основные стили */
    .carpet-article {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        line-height: 1.6;
        color: #334155;
    }

    /* Баннер */
    .carpet-banner {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        color: white;
        padding: 4rem 0;
        margin-bottom: 3rem;
    }

    .banner-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 3rem;
    }

    .banner-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .carpet-icon {
        flex-shrink: 0;
        filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
    }

    .banner-subtitle {
        font-size: 1.25rem;
        opacity: 0.9;
        margin: 0;
    }

    .banner-decoration {
        flex-shrink: 0;
        opacity: 0.8;
    }

    /* Основной контейнер */
    .article-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    /* Введение */
    .article-intro {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 3rem;
        margin-bottom: 4rem;
        align-items: center;
    }

    .intro-content h2 {
        font-size: 2rem;
        color: #1e40af;
        margin-bottom: 1.5rem;
        font-weight: 600;
    }

    .lead-text {
        font-size: 1.125rem;
        color: #475569;
        margin: 0;
    }

    .image-placeholder {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.1);
    }

    /* Секции */
    .article-section {
        margin-bottom: 4rem;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.75rem;
        color: #1e40af;
        margin-bottom: 2rem;
        font-weight: 600;
    }

    .section-icon {
        flex-shrink: 0;
    }

    /* Типы ковров */
    .carpet-types {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    .carpet-type-card {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(37, 99, 235, 0.05);
        border: 1px solid #e2e8f0;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .carpet-type-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.15);
    }

    .card-icon {
        margin-bottom: 1.5rem;
    }

    .carpet-type-card h3 {
        color: #1e40af;
        font-size: 1.25rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .carpet-type-card p {
        color: #64748b;
        margin: 0;
    }

    /* Советы по использованию */
    .usage-tips {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .tip-item {
        display: flex;
        gap: 1.5rem;
        align-items: flex-start;
    }

    .tip-number {
        background: #2563eb;
        color: white;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        flex-shrink: 0;
    }

    .tip-content h4 {
        color: #1e40af;
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .tip-content p {
        color: #64748b;
        margin: 0;
    }

    /* Уход за коврами */
    .care-section {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        padding: 3rem;
        border-radius: 16px;
        margin: 4rem 0;
    }

    .care-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
    }

    .care-card {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(37, 99, 235, 0.05);
        transition: transform 0.3s ease;
    }

    .care-card:hover {
        transform: translateY(-2px);
    }

    .care-icon {
        margin-bottom: 1rem;
    }

    .care-card h4 {
        color: #1e40af;
        font-size: 1.125rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .care-card p {
        color: #64748b;
        margin: 0;
        font-size: 0.95rem;
    }

    /* Заключение */
    .article-conclusion {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 3rem;
        align-items: center;
        background: linear-gradient(135deg, #dbeafe 0%, #f1f5f9 100%);
        padding: 3rem;
        border-radius: 16px;
    }

    .conclusion-content h2 {
        color: #1e40af;
        font-size: 1.75rem;
        margin-bottom: 1.5rem;
        font-weight: 600;
    }

    .conclusion-content p {
        color: #475569;
        margin-bottom: 2rem;
    }

    .cta-button .btn {
        background: #2563eb;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: background-color 0.3s ease;
        display: inline-block;
    }

    .cta-button .btn:hover {
        background: #1e40af;
        color: white;
        text-decoration: none;
    }

    /* Адаптивность */
    @media (max-width: 768px) {
        .banner-content {
            flex-direction: column;
            text-align: center;
        }

        .banner-title {
            font-size: 2rem;
        }

        .article-intro,
        .article-conclusion {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .tip-item {
            flex-direction: column;
            text-align: center;
        }

        .care-section {
            padding: 2rem;
        }
    }

    @media (max-width: 480px) {
        .article-container {
            padding: 0 1rem;
        }

        .carpet-banner {
            padding: 2rem 0;
        }

        .banner-title {
            font-size: 1.75rem;
            flex-direction: column;
            gap: 0.5rem;
        }

        .section-title {
            font-size: 1.5rem;
        }
    }
</style>