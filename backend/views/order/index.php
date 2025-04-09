<?php

use backend\models\Order;
use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\OrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var User $user */

$this->title = 'Заказы';
if ($user) {
    $this->params['breadcrumbs'][] = ['label' => $user->username, 'url' => ['/user/view', 'id' => $user->id]];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1>
    <?php
    if ($user) {
        echo Html::encode($this->title) . ' пользователя ' .$user->username;
    } else {
        echo Html::encode($this->title);
    }
    ?>
    </h1>

    <?php if (!$user) { ?>
    <p>
        <?= Html::a('Создать заказ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php } ?>

    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'total_price',
            'status',
            'created_at',
            //'delivery_id',
            //'delivery_address',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Order $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
