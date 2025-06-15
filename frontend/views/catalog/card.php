<?php

use yii\helpers\Html;
use frontend\assets\BackendAsset;

$backendUploads = BackendAsset::register($this);

/** @var \yii\web\View $this */
/** @var backend\models\Product $product */

$this->title = $product->name;
?>

<div class="product-page">
    <div class="product-container">

        <div class="product-image">
            <?php if ($product->img) { ?>
                <img src="<?= $backendUploads->baseUrl ?>/product/<?= $product->img ?>" alt="<?= Html::encode($product->name) ?>">
            <?php } else { ?>
                <img src="<?= $backendUploads->baseUrl ?>/product/no-image.png" alt="No Image">
            <?php } ?>
        </div>


        <div class="product-info">
            <h1><?= Html::encode($product->name) ?></h1>

            <div class="product-price">
                <span class="price-label">Цена:</span>
                <span class="price-value"><?= Html::encode($product->price) ?> ₽</span>
            </div>

            <div class="product-details">
                <div class="detail-row">
                    <span class="detail-key">Наличие</span>
                    <span class="detail-value <?= $product->quantity > 0 ? 'in-stock' : 'out-of-stock' ?>">
                        <?= Html::encode($product->quantity > 0 ? 'В наличии' : 'Нет в наличии') ?>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Размер</span>
                    <span class="detail-value"><?= Html::encode($product->size->value . ' м' ?? 'Не указано') ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Тип</span>
                    <span class="detail-value"><?= Html::encode($product->type->name ?? 'Не указано') ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Страна</span>
                    <span class="detail-value"><?= Html::encode($product->country->name ?? 'Не указано') ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Материал</span>
                    <span class="detail-value"><?= Html::encode($product->material->name ?? 'Не указано') ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Цвет</span>
                    <span class="detail-value"><?= Html::encode($product->color->name ?? 'Не указано') ?></span>
                </div>
            </div>

            <div class="product-actions">
                <?= Html::a('В корзину', ['/cart/add', 'id' => $product->id], [
                    'class' => 'btn btn-primary',
                    'data-method' => 'post',
                ]) ?>
            </div>
        </div>
    </div>


    <div class="product-description">
        <h2>Описание товара</h2>
        <p><?= Html::encode($product->description ?? 'Нет описания') ?></p>
    </div>

    <!-- Секция отзывов -->
    <div class="reviews-section">
        <h2>Отзывы о товаре</h2>

        <!-- Существующие отзывы -->
        <div class="reviews-list">
            <?php if (!empty($product->reviews)) { ?>
                <?php foreach ($product->reviews as $review) { ?>
                    <div class="review-item">
                        <div class="review-header">
                            <div class="reviewer-name"><?= Html::encode($review->user->username ?? 'Аноним') ?></div>
                            <div class="review-rating">
                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                    <span class="star <?= $i <= $review->rating ? 'filled' : '' ?>">★</span>
                                <?php } ?>
                            </div>
                            <div class="review-date"><?= date('d.m.Y', strtotime($review->created_at)) ?></div>
                        </div>
                        <div class="review-content">
                            <?= Html::encode($review->review) ?>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="no-reviews">
                    <p>Пока нет отзывов о данном товаре. Станьте первым, кто оставит отзыв!</p>
                </div>
            <?php } ?>
        </div>

        <!-- Форма добавления отзыва -->
        <div class="add-review-section">
            <h3>Оставить отзыв</h3>
            <?= Html::beginForm(['/review/create'], 'post', ['class' => 'review-form']) ?>
            <?= Html::hiddenInput('product_id', $product->id) ?>

            <div class="form-group">
                <label>Ваша оценка:</label>
                <div class="star-rating">
                    <?php for ($i = 1; $i <= 5; $i++) { ?>
                        <span class="star-input" data-rating="<?= $i ?>">★</span>
                    <?php } ?>
                    <?= Html::hiddenInput('rating', '', ['id' => 'rating-input']) ?>
                </div>
            </div>

            <div class="form-group">
                <label for="comment">Ваш отзыв:</label>
                <?= Html::textarea('comment', '', [
                    'id' => 'comment',
                    'class' => 'form-control',
                    'rows' => 4,
                    'placeholder' => 'Расскажите о вашем опыте использования товара...',
                    'required' => true
                ]) ?>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Отправить отзыв', ['class' => 'btn btn-primary submit-review']) ?>
            </div>
            <?= Html::endForm() ?>
        </div>
    </div>
</div>

<style>
    .product-page {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 40px 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .product-container {
        display: flex;
        gap: 40px;
        margin-bottom: 40px;
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
    }

    .product-image {
        flex: 0 0 450px;
        position: relative;
    }

    .product-image img {
        width: 100%;
        height: 450px;
        object-fit: cover;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: #fff;
    }

    .product-image img:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
    }

    .product-info {
        flex: 1;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .product-info h1 {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 25px;
        color: #1e40af;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .product-price {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 30px;
        padding: 20px;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border-radius: 15px;
        color: white;
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
    }

    .price-label {
        font-size: 18px;
        font-weight: 500;
    }

    .price-value {
        font-size: 28px;
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .product-details {
        margin-bottom: 35px;
        background: rgba(241, 245, 249, 0.7);
        padding: 25px;
        border-radius: 15px;
        border: 1px solid rgba(148, 163, 184, 0.2);
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid rgba(148, 163, 184, 0.2);
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-key {
        font-weight: 600;
        color: #1e40af;
        font-size: 16px;
        flex: 0 0 120px;
    }

    .detail-value {
        color: #374151;
        font-weight: 500;
        text-align: right;
        flex: 1;
        font-size: 16px;
    }

    .detail-value.in-stock {
        color: #059669;
        font-weight: 600;
    }

    .detail-value.out-of-stock {
        color: #dc2626;
        font-weight: 600;
    }

    .product-actions {
        text-align: center;
    }

    .product-actions .btn-primary {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border: none;
        padding: 18px 40px;
        border-radius: 50px;
        font-size: 18px;
        font-weight: 600;
        color: white;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .product-actions .btn-primary:hover {
        background: linear-gradient(135deg, #1d4ed8, #1e3a8a);
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(59, 130, 246, 0.4);
        color: white;
        text-decoration: none;
    }

    .product-description {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        max-width: 1200px;
        margin: 0 auto 40px auto;
    }

    .product-description h2 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #1e40af;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .product-description p {
        font-size: 18px;
        color: #374151;
        line-height: 1.8;
        font-weight: 400;
    }

    /* Стили для секции отзывов */
    .reviews-section {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        max-width: 1200px;
        margin: 0 auto;
    }

    .reviews-section h2 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 30px;
        color: #1e40af;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .reviews-section h3 {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 25px;
        color: #1e40af;
        border-top: 2px solid #e2e8f0;
        padding-top: 30px;
        margin-top: 40px;
    }

    .reviews-list {
        margin-bottom: 40px;
    }

    .review-item {
        background: rgba(241, 245, 249, 0.7);
        padding: 25px;
        border-radius: 15px;
        margin-bottom: 20px;
        border: 1px solid rgba(148, 163, 184, 0.2);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .review-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .reviewer-name {
        font-weight: 600;
        color: #1e40af;
        font-size: 16px;
    }

    .review-rating {
        display: flex;
        gap: 2px;
    }

    .review-rating .star {
        font-size: 18px;
        color: #d1d5db;
    }

    .review-rating .star.filled {
        color: #fbbf24;
    }

    .review-date {
        color: #6b7280;
        font-size: 14px;
    }

    .review-content {
        color: #374151;
        line-height: 1.6;
        font-size: 16px;
    }

    .no-reviews {
        text-align: center;
        padding: 40px 20px;
        color: #6b7280;
        font-style: italic;
    }

    /* Стили для формы отзыва */
    .review-form {
        background: rgba(241, 245, 249, 0.5);
        padding: 30px;
        border-radius: 15px;
        border: 1px solid rgba(148, 163, 184, 0.2);
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #1e40af;
        font-size: 16px;
    }

    .star-rating {
        display: flex;
        gap: 5px;
        margin-bottom: 10px;
    }

    .star-input {
        font-size: 28px;
        color: #d1d5db;
        cursor: pointer;
        transition: color 0.2s ease, transform 0.2s ease;
        user-select: none;
    }

    .star-input:hover {
        color: #fbbf24;
        transform: scale(1.1);
    }

    .star-input.active,
    .star-input.filled {
        color: #fbbf24;
    }

    .form-control {
        width: 100%;
        padding: 15px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 16px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        resize: vertical;
        font-family: inherit;
    }

    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .submit-review {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border: none;
        padding: 15px 35px;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 600;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .submit-review:hover {
        background: linear-gradient(135deg, #1d4ed8, #1e3a8a);
        transform: translateY(-2px);
        box-shadow: 0 15px 35px rgba(59, 130, 246, 0.4);
    }

    /* Адаптивность */
    @media (max-width: 768px) {
        .product-page {
            padding: 20px 15px;
        }

        .product-container {
            flex-direction: column;
            gap: 30px;
        }

        .product-image {
            flex: none;
        }

        .product-image img {
            height: 300px;
        }

        .product-info {
            padding: 30px 25px;
        }

        .product-info h1 {
            font-size: 26px;
        }

        .price-value {
            font-size: 24px;
        }

        .product-description,
        .reviews-section {
            padding: 30px 25px;
        }

        .product-description h2,
        .reviews-section h2 {
            font-size: 24px;
        }

        .detail-key {
            flex: 0 0 100px;
            font-size: 14px;
        }

        .detail-value {
            font-size: 14px;
        }

        .review-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .review-form {
            padding: 25px 20px;
        }
    }

    @media (max-width: 480px) {
        .product-actions .btn-primary {
            padding: 15px 30px;
            font-size: 16px;
        }

        .detail-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .detail-value {
            text-align: left;
        }

        .star-input {
            font-size: 24px;
        }

        .review-item {
            padding: 20px 15px;
        }

        .reviews-section,
        .product-description {
            padding: 25px 20px;
        }
    }

    /* Стили для уведомлений */
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 25px;
        border-radius: 10px;
        color: white;
        font-weight: 600;
        font-size: 16px;
        z-index: 10000;
        transform: translateX(400px);
        opacity: 0;
        transition: all 0.3s ease;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        max-width: 350px;
        word-wrap: break-word;
    }

    .notification.show {
        transform: translateX(0);
        opacity: 1;
    }

    .notification-success {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .notification-error {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }

    .notification-info {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    }

    /* Анимация для нового отзыва */
    .review-item.new-review {
        animation: slideInFromTop 0.5s ease-out;
        border: 2px solid #3b82f6;
    }

    @keyframes slideInFromTop {
        0% {
            transform: translateY(-20px);
            opacity: 0;
        }
        100% {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Состояние загрузки кнопки */
    .submit-review:disabled {
        background: #9ca3af !important;
        cursor: not-allowed;
        transform: none !important;
        box-shadow: none !important;
    }

    /* Адаптивность для уведомлений */
    @media (max-width: 480px) {
        .notification {
            right: 10px;
            left: 10px;
            max-width: none;
            transform: translateY(-100px);
        }

        .notification.show {
            transform: translateY(0);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.star-input');
        const ratingInput = document.getElementById('rating-input');
        const reviewForm = document.querySelector('.review-form');
        const submitButton = document.querySelector('.submit-review');
        const reviewsList = document.querySelector('.reviews-list');
        const noReviewsMessage = document.querySelector('.no-reviews');
        let currentRating = 0;

        stars.forEach((star, index) => {
            star.addEventListener('mouseenter', function() {
                highlightStars(index + 1);
            });

            star.addEventListener('click', function() {
                currentRating = index + 1;
                ratingInput.value = currentRating;
                setActiveStars(currentRating);
            });
        });

        // Сброс подсветки при выходе мыши из области звезд
        document.querySelector('.star-rating').addEventListener('mouseleave', function() {
            setActiveStars(currentRating);
        });

        function highlightStars(rating) {
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
            });
        }

        function setActiveStars(rating) {
            stars.forEach((star, index) => {
                star.classList.remove('active');
                if (index < rating) {
                    star.classList.add('filled');
                } else {
                    star.classList.remove('filled');
                }
            });
        }

        // AJAX отправка формы
        reviewForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Валидация
            if (!ratingInput.value) {
                showNotification('Пожалуйста, выберите оценку', 'error');
                return false;
            }

            const comment = document.getElementById('comment').value.trim();
            if (!comment) {
                showNotification('Пожалуйста, напишите отзыв', 'error');
                return false;
            }

            // Показать загрузку
            const originalButtonText = submitButton.textContent;
            submitButton.textContent = 'Отправка...';
            submitButton.disabled = true;

            // Подготовка данных
            const formData = new FormData(reviewForm);

            // AJAX запрос
            fetch('/review/create', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Успешно добавлен отзыв
                        addReviewToList(data.review);
                        resetForm();
                        showNotification('Отзыв успешно добавлен!', 'success');

                        if (noReviewsMessage) {
                            noReviewsMessage.style.display = 'none';
                        }
                    } else {
                        showNotification(data.message || 'Произошла ошибка при добавлении отзыва', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Произошла ошибка сети. Попробуйте еще раз.', 'error');
                })
                .finally(() => {
                    submitButton.textContent = originalButtonText;
                    submitButton.disabled = false;
                });
        });

        // Функция добавления отзыва в список
        function addReviewToList(review) {
            const reviewHtml = `
            <div class="review-item new-review">
                <div class="review-header">
                    <div class="reviewer-name">${escapeHtml(review.username || 'Аноним')}</div>
                    <div class="review-rating">
                        ${generateStarsHtml(review.rating)}
                    </div>
                    <div class="review-date">${formatDate(new Date())}</div>
                </div>
                <div class="review-content">
                    ${escapeHtml(review.comment)}
                </div>
            </div>
        `;

            // Добавить в начало списка отзывов
            reviewsList.insertAdjacentHTML('afterbegin', reviewHtml);

            // Анимация появления
            const newReview = document.querySelector('.new-review');
            setTimeout(() => {
                newReview.classList.remove('new-review');
            }, 100);
        }

        // Функция генерации звезд для отзыва
        function generateStarsHtml(rating) {
            let starsHtml = '';
            for (let i = 1; i <= 5; i++) {
                starsHtml += `<span class="star ${i <= rating ? 'filled' : ''}">★</span>`;
            }
            return starsHtml;
        }

        // Функция сброса формы
        function resetForm() {
            document.getElementById('comment').value = '';
            ratingInput.value = '';
            currentRating = 0;
            setActiveStars(0);
        }

        // Функция показа уведомлений
        function showNotification(message, type = 'info') {
            // Удалить существующее уведомление если есть
            const existingNotification = document.querySelector('.notification');
            if (existingNotification) {
                existingNotification.remove();
            }

            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.textContent = message;

            document.body.appendChild(notification);

            // Показать уведомление
            setTimeout(() => {
                notification.classList.add('show');
            }, 100);

            // Скрыть через 5 секунд
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.remove();
                    }
                }, 300);
            }, 5000);
        }

        // Вспомогательные функции
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function formatDate(date) {
            return date.toLocaleDateString('ru-RU', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
        }
    });
</script>