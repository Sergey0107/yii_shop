<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\ContactForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Контакты';
?>
<div class="site-contact">
    <div class="contact-header">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>Если у вас есть вопросы или предложения, пожалуйста, заполните форму ниже. Мы свяжемся с вами в ближайшее время.</p>
    </div>

    <div class="contact-content">
        <div class="row">
            <div class="col-lg-6">
                <div class="contact-form">
                    <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <?= $form->field($model, 'name')->textInput([
                        'autofocus' => true,
                        'placeholder' => 'Введите ваше имя',
                    ])->label('Имя') ?>

                    <?= $form->field($model, 'email')->textInput([
                        'placeholder' => 'Введите ваш email',
                    ])->label('Email') ?>

                    <?= $form->field($model, 'subject')->textInput([
                        'placeholder' => 'Тема сообщения',
                    ])->label('Тема') ?>

                    <?= $form->field($model, 'body')->textarea([
                        'rows' => 6,
                        'placeholder' => 'Введите текст вашего сообщения',
                    ])->label('Сообщение') ?>

                    <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
                        'template' => '<div class="captcha-container"><div class="captcha-image">{image}</div><div class="captcha-input">{input}</div></div>',
                    ])->label('Проверочный код') ?>

                    <div class="form-group">
                        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="contact-info">
                    <h2>Как нас найти</h2>
                    <div class="info-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#17a2b8" viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                        <p>г. Кострома, ул. Советская, д. 10</p>
                    </div>
                    <div class="info-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#17a2b8" viewBox="0 0 24 24">
                            <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V6h16v12z"/>
                        </svg>
                        <p>Пн–Пт: 9:00–18:00, Сб–Вс: выходной</p>
                    </div>
                    <div class="info-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#17a2b8" viewBox="0 0 24 24">
                            <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-4H6V8h12v2z"/>
                        </svg>
                        <p>Email: info@example.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Общий стиль страницы */
    .site-contact {
        background-color: #f8f9fa;
        padding: 40px 20px;
        text-align: center;
    }

    .contact-header h1 {
        font-size: 36px;
        color: #343a40;
        margin-bottom: 10px;
    }

    .contact-header p {
        font-size: 18px;
        color: #6c757d;
        margin-bottom: 40px;
    }

    /* Форма контактов */
    .contact-form {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.06);
        text-align: left;
    }

    .contact-form .form-control {
        border-radius: 8px;
        border: 1px solid #ced4da;
        padding: 10px;
        margin-bottom: 15px;
    }

    .contact-form .btn-primary {
        background-color: #17a2b8;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .contact-form .btn-primary:hover {
        background-color: #138496;
    }

    .captcha-container {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
    }

    .captcha-image img {
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Информация о контактах */
    .contact-info {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.06);
        text-align: left;
    }

    .contact-info h2 {
        font-size: 24px;
        color: #343a40;
        margin-bottom: 20px;
    }

    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .info-item svg {
        margin-right: 10px;
    }

    .info-item p {
        font-size: 16px;
        color: #555;
    }

    /* Адаптивность */
    @media (max-width: 768px) {
        .row {
            flex-direction: column;
        }

        .col-lg-6 {
            width: 100%;
        }
    }
</style>