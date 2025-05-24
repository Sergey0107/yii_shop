<?php

namespace frontend\controllers;

use AntistressStore\CdekSDK2\Entity\Requests\DeliveryPoints;
use backend\models\Order;
use backend\models\Product;
use backend\models\OrderProducts;
use Yii;
use yii\db\StaleObjectException;
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
            return $this->render('empty-cart');
        }
        $orderProducts = OrderProducts::find()->where(['order_id' => $order->id])->all();
        if (!$orderProducts) {
            return $this->render('empty-cart');
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
        $productId = (int)Yii::$app->request->post('product_id');
        $product = Product::findOne($productId);

        if (!$product) {
            throw new \Exception('Товар не найден');
        }

        $order = Order::findOne(['user_id' => Yii::$app->user->id, 'status' => Order::STATUS_DRAFT]);

        if (!$order) {
            $order = new Order();
            $order->user_id = Yii::$app->user->id;
            $order->status = Order::STATUS_DRAFT;
            $order->created_at = date('Y-m-d H:i:s', time());
            $order->total_price = $product->price;

            if (!$order->save()) {
                return ['success' => false, 'errors' => $order->getErrors()];
            }
        }

        if ($product->inUserOrder()) {
            $orderProduct = OrderProducts::findOne(['order_id' => $order->id, 'product_id' => $product->id]);
            $orderProduct->quantity += 1;
        } else {
            $orderProduct = new OrderProducts();
            $orderProduct->order_id = $order->id;
            $orderProduct->product_id = $productId;
            $orderProduct->quantity = 1;
        }

        if (!$orderProduct->save()) {
            return ['success' => false, 'errors' => $orderProduct->getErrors()];
        }

        $count = $order->getCountProducts();
        return ['success' => true, 'count' => $count];
    }

    /**
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionRemove()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $orderProductId = Yii::$app->request->get('order_product_id');
        $orderProduct = OrderProducts::findOne($orderProductId);

        if (!$orderProduct) {
            return ['success' => false, 'message' => 'Позиция не найдена в заказе'];
        }
        if (!$orderProduct->delete()) {
            return ['success' => false, 'errors' => $orderProduct->getErrors()];
        }

        $order = Order::findOne(['user_id' => Yii::$app->user->id, 'status' => Order::STATUS_DRAFT]);
        if ($order) {
            $count = $order->getCountProducts();
            $orderData = [
                'total_price' => $order->total_price,
                'products_count' => $count,
            ];
        } else {
            $orderData = [
                'total_price' => 0,
                'products_count' => 0,
            ];
        }


        return ['success' => true, 'message' => 'Товар успешно удален из корзины', 'order' => $orderData];
    }

    /**
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionClear(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $order = Order::findOne(['user_id' => Yii::$app->user->id, 'status' => Order::STATUS_DRAFT]);
        if (!$order) {
            return ['success' => false, 'message' => 'Заказ не найден'];
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $deletedRows = OrderProducts::deleteAll(['order_id' => $order->id]);
            if ($order->delete()) {
                $transaction->commit();
                return ['success' => true, 'order' => $order];
            }

            $transaction->rollBack();
            return ['success' => false, 'message' => 'Не удалось очистить корзину'];
        } catch (\Exception $e) {

            $transaction->rollBack();
            Yii::error("Ошибка при очистке корзины: " . $e->getMessage());
            return ['success' => false, 'message' => 'Произошла ошибка при очистке корзины'];
        }
    }

    public function actionEmpty()
    {
        return $this->render('empty-cart');
    }

    public function actionPlus($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $orderProduct = OrderProducts::findOne($id);
        if (!$orderProduct) {
            return ['success' => false, 'message' => 'Товар не найден'];
        }

        $orderProduct->quantity += 1;
        if ($orderProduct->save()) {
            $order = $orderProduct->order;
            $order->updateTotalPrice();

            return [
                'success' => true,
                'quantity' => $orderProduct->quantity,
                'order' => [
                    'products_count' => $order->getCountProducts(),
                    'total_price' => $order->total_price
                ]
            ];
        }

        return ['success' => false, 'message' => 'Ошибка сохранения'];
    }

    public function actionMinus($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $orderProduct = OrderProducts::findOne($id);
        if (!$orderProduct) {
            return ['success' => false, 'message' => 'Товар не найден'];
        }

        if ($orderProduct->quantity > 1) {
            $orderProduct->quantity -= 1;
            if ($orderProduct->save()) {
                $order = $orderProduct->order;
                $order->updateTotalPrice();

                return [
                    'success' => true,
                    'quantity' => $orderProduct->quantity,
                    'order' => [
                        'products_count' => $order->getCountProducts(),
                        'total_price' => $order->total_price
                    ]
                ];
            }
        }

        return ['success' => true, 'quantity' => $orderProduct->quantity];
    }
}