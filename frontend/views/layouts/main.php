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
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => '<i class="fas fa-store me-2"></i> Главная',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark shadow-dark fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => '<i class="fas fa-shopping-bag me-1"></i> Каталог', 'url' => ['catalog/index'], 'encode' => false],
        ['label' => '<i class="fas fa-info-circle me-1"></i> О магазине', 'url' => ['site/about'], 'encode' => false],
        ['label' => '<i class="fas fa-envelope me-1"></i> Контакты', 'url' => ['/site/contact'], 'encode' => false],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => '<i class="fas fa-user-plus me-1"></i> Зарегистрироваться', 'url' => ['/site/signup'], 'encode' => false];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
        'items' => $menuItems,
    ]);


    echo Html::a('<i class="fas fa-shopping-cart me-2"></i><span class="badge bg-danger">1</span>', ['/cart/index'], [
        'class' => 'btn btn-outline-light d-flex align-items-center',
    ]);

    if (Yii::$app->user->isGuest) {
        echo Html::tag('div', Html::a('<i class="fas fa-sign-in-alt me-1"></i> Войти', ['/site/login'], [
            'class' => 'btn btn-link login text-decoration-none text-white',
        ]), ['class' => 'd-flex']);
    } else {
        echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
            . Html::submitButton(
                '<i class="fas fa-sign-out-alt me-1"></i> Выйти (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout text-decoration-none text-white']
            )
            . Html::endForm();
    }
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container shadow-content">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 bg-light shadow-custom">
    <div class="container">
        <p class="float-start text-muted">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="float-end text-muted"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage(); ?>

<style>

    .shadow-dark {
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2), 0 2px 4px rgba(0, 0, 0, 0.1); /* Более темная и глубокая тень */
    }


    .shadow-content {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
        padding: 20px;
        background-color: #ffffff;
        border-radius: 8px;
        margin-top: 20px;
    }

    .footer.shadow-custom {
        box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.08);
    }
</style>