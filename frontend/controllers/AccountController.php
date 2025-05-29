<?php

namespace frontend\controllers;

use backend\models\Order;
use Yii;
use yii\web\Controller;

class AccountController extends Controller
{
    public function actionIndex()
    {
        $orders = $this->getUserOrders();
        return $this->render('index', ['orders' => $orders]);
    }

    public function getUserOrders(): array
    {
        return Order::find()->where(['user_id' => Yii::$app->user->id])->all();
    }
}