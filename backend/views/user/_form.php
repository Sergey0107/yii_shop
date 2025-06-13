<?php

use common\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var yii\widgets\ActiveForm $form */

// Получаем все доступные роли из RBAC
$authManager = Yii::$app->authManager;
$roles = $authManager->getRoles();

// Формируем массив ролей для выпадающего списка
$roleItems = [];
foreach ($roles as $role) {
    switch ($role->name) {
        case 'admin':
            $roleItems[$role->name] = 'Администратор';
            break;
        case 'moderator':
            $roleItems[$role->name] = 'Модератор';
            break;
        case 'manager':
            $roleItems[$role->name] = 'Менеджер';
            break;
        case 'user':
            $roleItems[$role->name] = 'Пользователь';
            break;
        default:
            $roleItems[$role->name] = ucfirst($role->name);
            break;
    }
}

// Получаем текущие роли пользователя
$userRoles = [];
if (!$model->isNewRecord) {
    $assignedRoles = $authManager->getRolesByUser($model->id);
    $userRoles = array_keys($assignedRoles);
}
?>

<div class="user-form cosmic-form">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'needs-validation', 'novalidate' => true]
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <!-- Поле для имени пользователя -->
            <?= $form->field($model, 'username')->textInput([
                'maxlength' => true,
                'class' => 'form-control cosmic-input',
                'placeholder' => 'Введите имя пользователя'
            ])->label('Имя пользователя', ['class' => 'cosmic-label']) ?>
        </div>

        <div class="col-md-6">
            <!-- Поле для email -->
            <?= $form->field($model, 'email')->textInput([
                'maxlength' => true,
                'type' => 'email',
                'class' => 'form-control cosmic-input',
                'placeholder' => 'Введите email'
            ])->label('Email', ['class' => 'cosmic-label']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <!-- Поле для пароля -->
            <?= $form->field($model, 'password')->passwordInput([
                'maxlength' => true,
                'class' => 'form-control cosmic-input',
                'placeholder' => $model->isNewRecord ? 'Введите пароль' : 'Оставьте пустым для сохранения текущего'
            ])->hint($model->isNewRecord ? 'Введите пароль' : 'Оставьте пустым, если не хотите менять пароль')->label('Пароль', ['class' => 'cosmic-label']) ?>
        </div>

        <div class="col-md-6">
            <!-- Поле для статуса -->
            <?= $form->field($model, 'status')->dropDownList([
                User::STATUS_ACTIVE => 'Активен',
                User::STATUS_INACTIVE => 'Неактивен',
                User::STATUS_DELETED => 'Удален',
            ], [
                'prompt' => 'Выберите статус',
                'class' => 'form-select cosmic-select'
            ])->label('Статус', ['class' => 'cosmic-label']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <!-- Поле для ролей -->
            <div class="form-group">
                <label class="cosmic-label">Роли пользователя</label>
                <div class="cosmic-roles-container">
                    <?php if (empty($roleItems)): ?>
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Роли не найдены. Убедитесь, что RBAC правильно настроен.
                        </div>
                    <?php else: ?>
                        <?php foreach ($roleItems as $roleKey => $roleLabel): ?>
                            <div class="cosmic-role-item">
                                <?= Html::checkbox("user_roles[]", in_array($roleKey, $userRoles), [
                                    'value' => $roleKey,
                                    'id' => 'role_' . $roleKey,
                                    'class' => 'cosmic-checkbox'
                                ]) ?>
                                <label for="role_<?= $roleKey ?>" class="cosmic-role-label">
                                    <span class="cosmic-role-badge role-<?= $roleKey ?>"><?= Html::encode($roleLabel) ?></span>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <small class="form-text text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    Выберите одну или несколько ролей для пользователя. Если ни одна роль не выбрана, пользователь будет иметь базовые права.
                </small>
            </div>
        </div>
    </div>

    <div class="form-group mt-4">
        <div class="d-flex gap-2">
            <?= Html::submitButton($model->isNewRecord ? 'Создать пользователя' : 'Обновить пользователя', [
                'class' => 'btn cosmic-save-btn'
            ]) ?>

            <?= Html::button('Отмена', [
                'class' => 'btn cosmic-cancel-btn',
                'data-bs-dismiss' => 'modal'
            ]) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<style>
    .cosmic-form {
        padding: 1rem;
    }

    .cosmic-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .cosmic-input,
    .cosmic-select {
        background: rgba(255, 255, 255, 0.9);
        border: 2px solid #e9ecef;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .cosmic-input:focus,
    .cosmic-select:focus {
        background: rgba(255, 255, 255, 1);
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        outline: none;
    }

    .cosmic-roles-container {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
        border: 2px dashed #dee2e6;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 1rem;
    }

    .cosmic-role-item {
        display: inline-block;
        margin: 0.5rem;
        position: relative;
    }

    .cosmic-checkbox {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .cosmic-role-label {
        cursor: pointer;
        transition: all 0.3s ease;
        display: block;
    }

    .cosmic-role-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 600;
        border-radius: 2rem;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        opacity: 0.6;
    }

    .cosmic-checkbox:checked + .cosmic-role-label .cosmic-role-badge {
        opacity: 1;
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .cosmic-role-badge.role-admin {
        background: linear-gradient(135deg, #ff6b6b, #ee5a24);
        color: white;
    }

    .cosmic-role-badge.role-moderator {
        background: linear-gradient(135deg, #ffa726, #ff7043);
        color: white;
    }

    .cosmic-role-badge.role-manager {
        background: linear-gradient(135deg, #ab47bc, #8e24aa);
        color: white;
    }

    .cosmic-role-badge.role-user {
        background: linear-gradient(135deg, #26a69a, #00acc1);
        color: white;
    }

    .cosmic-role-badge:not(.role-admin):not(.role-moderator):not(.role-manager):not(.role-user) {
        background: linear-gradient(135deg, #78909c, #607d8b);
        color: white;
    }

    .cosmic-save-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 2rem;
        transition: all 0.3s ease;
    }

    .cosmic-save-btn:hover {
        background: linear-gradient(135deg, #5a67d8 0%, #6a4c96 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }

    .cosmic-cancel-btn {
        background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 2rem;
        transition: all 0.3s ease;
    }

    .cosmic-cancel-btn:hover {
        background: linear-gradient(135deg, #85939e 0%, #6f7b7c 100%);
        transform: translateY(-2px);
    }

    .form-text {
        color: #6c757d;
        font-size: 0.875rem;
    }

    .alert {
        border-radius: 0.75rem;
        border: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Добавляем интерактивность для чекбоксов ролей
        const roleCheckboxes = document.querySelectorAll('.cosmic-checkbox');

        roleCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const badge = this.nextElementSibling.querySelector('.cosmic-role-badge');
                if (this.checked) {
                    badge.style.animation = 'pulseIn 0.3s ease-out';
                }
            });
        });
    });
</script>