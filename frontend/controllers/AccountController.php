<?php

namespace frontend\controllers;

use backend\models\Order;
use frontend\assets\BackendAsset;
use Yii;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\Response;

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

    public function actionGetOrderDetails()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!Yii::$app->request->isAjax) {
            return [
                'success' => false,
                'message' => 'Только AJAX запросы'
            ];
        }

        $orderId = Yii::$app->request->post('order_id');

        if (!$orderId) {
            return [
                'success' => false,
                'message' => 'ID заказа не передан'
            ];
        }

        // Находим заказ по ID и проверяем принадлежность пользователю
        $order = Order::find()
            ->where(['id' => $orderId])
            ->andWhere(['user_id' => Yii::$app->user->id])
            ->with('products') // Загружаем связанные товары
            ->one();

        if (!$order) {
            return [
                'success' => false,
                'message' => 'Заказ не найден'
            ];
        }

        // Получаем базовый URL для изображений
        $backendUploads = BackendAsset::register(Yii::$app->view);
        $baseUrl = $backendUploads->baseUrl;

        // Формируем данные о товарах
        $products = [];
        if ($order->products) {
            foreach ($order->products as $product) {
                // Определяем URL изображения
                $imageUrl = $baseUrl . '/product/no-image.png'; // По умолчанию
                if ($product->img) {
                    $imageUrl = $baseUrl . '/product/' . $product->img;
                }

                $products[] = [
                    'id' => $product->id,
                    'name' => Html::encode($product->name),
                    'price' => number_format($product->price, 0, '.', ' '),
                    'quantity' =>  1, // Количество из связующей таблицы
                    'image_url' => $imageUrl
                ];
            }
        }

        // Определяем методы оплаты и доставки (адаптируйте под вашу логику)
        $paymentMethods = [
            'cash' => 'Наличными при получении',
            'card' => 'Банковской картой',
            'online' => 'Онлайн оплата',
        ];

        $deliveryMethods = [
            'pickup' => 'Самовывоз',
            'courier' => 'Курьером',
            'post' => 'Почтой',
        ];

        return [
            'success' => true,
            'order' => [
                'id' => $order->id,
                'payment_method' => 'Оплата при получении',
                'delivery_method' => 'СДЭК',
                'total_price' => $order->total_price,
                'delivery_price' => $order->delivery_price,
                'status' => $order->getStatusName(),
                'created_at' => $order->created_at,
            ],
            'products' => $products
        ];
    }
}