<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Войти';
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Заполните поля для входа:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Имя пользователя') ?>

            <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>

            <?= $form->field($model, 'rememberMe')->checkbox()->label('Запомнить меня') ?>

            <div class="my-1 mx-0" style="color:#999;">
                Если вы забыли пароль <?= Html::a('восстановите его', ['site/request-password-reset']) ?>.
            </div>

            <div class="form-group">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

            <div class="mt-3 text-center">
                <p>Нет аккаунта? <?= Html::a('Зарегистрируйтесь!', ['site/signup'], ['class' => 'text-primary']) ?></p>
            </div>
        </div>
    </div>
</div>