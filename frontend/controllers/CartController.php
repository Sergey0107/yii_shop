<?php

namespace frontend\controllers;

use AntistressStore\CdekSDK2\Entity\Requests\DeliveryPoints;
use backend\models\Order;
use backend\models\Product;
use backend\models\OrderProducts;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class CartController extends Controller
{
    private $cdekClient;
    private $pickUpPoints;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->cdekClient = new \AntistressStore\CdekSDK2\CdekClientV2('TEST');

        try {
            $requestPvz = (new DeliveryPoints())
                ->setType('PVZ')
                ->setCityCode(165);

            $response = $this->cdekClient->getDeliveryPoints($requestPvz);
            $this->pickUpPoints = $this->formatDeliveryPoints($response);

        } catch (\Exception $e) {
            Yii::error('Ошибка получения пунктов выдачи СДЭК: ' . $e->getMessage());
            $this->pickUpPoints = $this->getTestPickupPoints(55.7558, 37.6173);
        }
    }

    /**
     * Преобразует объект DeliveryPointsResponse в массив
     */
    private function formatDeliveryPoints($response): array
    {
        $points = [];

        foreach ($response as $item) {
            $points[] = [
                'id' => $item->getCode(),
                'name' => $item->getName(),
                'address' => $item->getLocation()->getAddress(),
                'hours' => $item->getWorkTime() ?? 'пн-пт 9:00-18:00',
                'lat' => $item->getLocation()->getLatitude(),
                'lng' => $item->getLocation()->getLongitude(),
            ];
        }

        return $points;
    }

    public function actionIndex()
    {
        $order = Order::findOne(['user_id' => Yii::$app->user->id, 'status' => Order::STATUS_DRAFT]);
        if (!$order) {
            return $this->redirect(['cart/empty']);
        }
        $orderProducts = OrderProducts::find()->where(['order_id' => $order->id])->all();
        if (!$orderProducts) {
            return $this->redirect(['cart/empty']);
        }

        return $this->render('index', [
            'order' => $order,
            'orderProducts' => $orderProducts,
            'pickupPoints' => $this->pickUpPoints,
        ]);
    }

    private function getTestPickupPoints($lat, $lng): array
    {
        return [
            [
                'id' => 'PVZ1',
                'name' => 'SDEK Тестовый пункт №1',
                'address' => 'ул. Тестовая, д. 1, Москва',
                'hours' => 'пн-пт 8:00-20:00, сб 9:00-18:00',
                'lat' => $lat + 0.01,
                'lng' => $lng + 0.01,
            ],
            [
                'id' => 'PVZ2',
                'name' => 'SDEK Тестовый пункт №2',
                'address' => 'ул. Примерная, д. 5, Москва',
                'hours' => 'пн-пт 9:00-18:00',
                'lat' => $lat - 0.01,
                'lng' => $lng + 0.005,
            ],
        ];
    }

    public function actionAdd()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $order = Order::findOne(['user_id' => Yii::$app->user->id, 'status' => Order::STATUS_DRAFT]);

        if (!$order) {
            $order = new Order();
            $order->user_id = Yii::$app->user->id;
            $order->status = Order::STATUS_DRAFT;
            $order->created_at = time();

            if (!$order->save()) {
                return ['success' => false, 'errors' => $order->getErrors()];
            }
        }

        $orderProduct = new OrderProducts();
        $orderProduct->order_id = $order->id;
        $orderProduct->product_id = Yii::$app->request->post('product_id');

        if (!$orderProduct->save()) {
            return ['success' => false, 'errors' => $orderProduct->getErrors()];
        }

        return ['success' => true];
    }

    public function actionDelete()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $order = Order::findOne(['user_id' => Yii::$app->user->id, 'status' => Order::STATUS_DRAFT]);
        if (!$order) {
            return ['success' => false, 'message' => 'Заказ не найден'];
        }

        $orderProduct = OrderProducts::findOne([
            'order_id' => $order->id,
            'product_id' => Yii::$app->request->post('product_id'),
        ]);
        if (!$orderProduct) {
            return ['success' => false, 'message' => 'Товар не найден в заказе'];
        }

        if ($orderProduct->delete()) {
            $order->updateTotalPrice(); // Пересчет общей суммы заказа при необходимости
            return ['success' => true];
        }

        return ['success' => false, 'message' => 'Не удалось удалить товар'];
    }

    public function actionClear()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $order = Order::findOne(['user_id' => Yii::$app->user->id, 'status' => Order::STATUS_DRAFT]);
        if (!$order) {
            return ['success' => false, 'message' => 'Заказ не найден'];
        }

        $orderProducts = OrderProducts::find()->where(['order_id' => $order->id])->all();
        foreach ($orderProducts as $orderProduct) {
            $orderProduct->delete();
        }

        if ($order->delete()) {
            return ['success' => true];
        }

        return ['success' => false, 'message' => 'Не удалось очистить корзину'];
    }

}