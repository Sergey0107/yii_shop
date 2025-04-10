<?php

namespace frontend\controllers;

use backend\models\Order;
use backend\models\Product;
use backend\models\OrderProducts;
use Yii;
use yii\web\Controller;

class CartController extends Controller
{
    public function actionIndex()
    {
        $order = Order::findOne(['user_id' => Yii::$app->user->id]);
        $orderProducts = OrderProducts::find()->where(['order_id' => $order->id])->all();
        return $this->render('index', ['order' => $order, 'orderProducts' => $orderProducts]);
    }
}