<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Корзина пуста';
?>
<div class="cart-page">
    <div class="container">
        <div class="empty-cart">
            <div class="empty-content">
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 5H5L5.4 7M7 15H17L21 5H5.4M7 15L5.4 5M7 15L4.70711 17.2929C4.07714 17.9229 4.52331 19 5.41421 19H17M17 19C15.8954 19 15 19.8954 15 21C15 22.1046 15.8954 23 17 23C18.1046 23 19 22.1046 19 21C19 19.8954 18.1046 19 17 19ZM9 21C9 22.1046 8.10457 23 7 23C5.89543 23 5 22.1046 5 21C5 19.8954 5.89543 19 7 19C8.10457 19 9 19.8954 9 21Z" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <h3>Ваша корзина пуста</h3>
                <p>Добавьте товары, чтобы продолжить покупки</p>
                <a href="<?= Url::to(['catalog/index']) ?>" class="btn-continue">
                    Продолжить покупки
                </a>
            </div>
        </div>
    </div>
</div>