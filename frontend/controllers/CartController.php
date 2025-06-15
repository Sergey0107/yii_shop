<?php

namespace frontend\controllers;

use AntistressStore\CdekSDK2\Entity\Requests\DeliveryPoints;
use YooKassa\Client;
use backend\models\City;
use backend\models\Delivery;
use backend\models\Order;
use backend\models\Product;
use backend\models\OrderProducts;
use Throwable;
use Yii;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CartController extends Controller
{
    private $pickUpPoints;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->pickUpPoints = Yii::$app->cdekService->getPickupPoints(City::CODE_KOSTROMA_CDEK);
    }

    public function actionIndex()
    {
        $cities = City::find()->all();
        $order = $this->findDraftOrder();
        if (!$order) {
            return $this->render('empty-cart');
        }

        $orderProducts = $this->findOrderPosition($order->id);
        if (!$orderProducts) {
            return $this->render('empty-cart');
        }

        return $this->render('index', [
            'order' => $order,
            'orderProducts' => $orderProducts,
            'pickupPoints' => $this->pickUpPoints,
            'cities' => $cities,
        ]);


        if (!empty($response)) {
            print_r($response); die();
        }
    }

    public function actionAdd()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        try {
            $product = $this->findProduct();
            $order = $this->findOrCreateOrder();
            $orderProduct = $this->processOrderProduct($order, $product);

            $this->saveOrderProduct($orderProduct);
            $order->updateTotalPrice();
            $product->reserveProductForOrder();

            return [
                'success' => true,
                'count' => $order->getCountProducts(),
                'total_price' => $order->total_price
            ];

        } catch (\Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            return $this->prepareErrorResponse($e);
        }
    }

    private function findProduct(): Product
    {
        $productId = (int)Yii::$app->request->post('product_id');
        $product = Product::findOne($productId);

        if (!$product) {
            throw new NotFoundHttpException('Товар не найден');
        }

        return $product;
    }

    private function findDraftOrder(): ?Order
    {
        return Order::findOne([
            'user_id' => Yii::$app->user->id,
            'status' => Order::STATUS_DRAFT
        ]);
    }

    private function findOrderPosition($orderId): ?array
    {
        return OrderProducts::find()->where(['order_id' => $orderId])->all();
    }

    private function findOrCreateOrder(): Order
    {
        $order = Order::find()
            ->where(['user_id' => Yii::$app->user->id, 'status' => Order::STATUS_DRAFT])
            ->one();

        if (!$order) {
            $order = new Order([
                'user_id' => Yii::$app->user->id,
                'status' => Order::STATUS_DRAFT,
                'created_at' => date('Y-m-d H:i:s'),
                'total_price' => 0
            ]);

            if (!$order->save()) {
                throw new \RuntimeException('Не удалось создать заказ: ' . json_encode($order->getErrors()));
            }
        }

        return $order;
    }

    private function processOrderProduct(Order $order, Product $product): OrderProducts
    {
        $orderProduct = OrderProducts::findOne([
            'order_id' => $order->id,
            'product_id' => $product->id
        ]);

        if ($orderProduct) {
            $orderProduct->quantity += 1;
        } else {
            $orderProduct = new OrderProducts([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return $orderProduct;
    }

    private function saveOrderProduct(OrderProducts $orderProduct): void
    {
        if (!$orderProduct->save()) {
            throw new \RuntimeException('Не удалось сохранить позицию заказа: ' . json_encode($orderProduct->getErrors()));
        }
    }

    private function prepareErrorResponse(\Exception $e): array
    {
        return [
            'success' => false,
            'error' => $e->getMessage(),
            'code' => $e instanceof HttpException ? $e->statusCode : 500
        ];
    }

    /**
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionRemove(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        try {
            $orderProduct = $this->findOrderProduct();
            $product = $orderProduct->product;
            $count = $orderProduct->quantity;
            $this->deleteOrderProduct($orderProduct);
            $orderData = $this->getOrderData();

            $product->returnProductToWarehouse($count);

            return [
                'success' => true,
                'message' => 'Товар успешно удален из корзины',
                'order' => $orderData
            ];

        } catch (\Exception $e) {
            Yii::error('Error removing product: ' . $e->getMessage(), __METHOD__);
            return $this->prepareErrorResponse($e);
        }
    }

    /**
     * @throws Throwable
     * @throws StaleObjectException
     */
    private function deleteOrderProduct(OrderProducts $orderProduct): void
    {
        if (!$orderProduct->delete()) {
            throw new \RuntimeException('Не удалось удалить позицию: ' . json_encode($orderProduct->getErrors()));
        }
    }

    private function getOrderData(): array
    {
        $order = $this->findDraftOrder();

        if (!$order) {
            return [
                'total_price' => 0,
                'products_count' => 0
            ];
        }

        $order->updateTotalPrice();

        return [
            'total_price' => $order->total_price,
            'products_count' => $order->getCountProducts()
        ];
    }

    private function findOrderProduct(): OrderProducts
    {
        $orderProductId = Yii::$app->request->get('order_product_id');
        $orderProduct = OrderProducts::findOne($orderProductId);

        if (!$orderProduct) {
            throw new NotFoundHttpException('Позиция не найдена в заказе');
        }

        return $orderProduct;
    }

    /**
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionClear(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $order = $this->findDraftOrder();
        if (!$order) {
            return ['success' => false, 'message' => 'Заказ не найден'];
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $order->returnAllProductsInWarehouse();
            OrderProducts::deleteAll(['order_id' => $order->id]);
            if ($order->delete()) {
                $transaction->commit();
                return ['success' => true, 'order' => $order];
            }

            $transaction->rollBack();
            return ['success' => false, 'message' => 'Не удалось очистить корзину'];
        } catch (\Exception $e) {

            $transaction->rollBack();
            Yii::error("Ошибка при очистке корзины: " . $e->getMessage());
            return $this->prepareErrorResponse($e);
        }
    }

    public function actionEmpty()
    {
        return $this->render('empty-cart');
    }

    /**
     * @throws Exception
     */
    public function actionPlus($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $orderProduct = OrderProducts::findOne($id);
        if (!$orderProduct) {
            return ['success' => false, 'message' => 'Товар не найден'];
        }

        $orderProduct->quantity += 1;
        $orderProduct->product->reserveProductForOrder();
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

    /**
     * @throws Exception
     */
    public function actionMinus($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $orderProduct = OrderProducts::findOne($id);
        if (!$orderProduct) {
            return ['success' => false, 'message' => 'Товар не найден'];
        }

        if ($orderProduct->quantity > 1) {
            $orderProduct->quantity -= 1;
            if ($orderProduct->save(false)) {

                $order = $orderProduct->order;
                $order->updateTotalPrice();
                $orderProduct->product->returnProductToWarehouse();

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


    public function actionSuccessOrder()
    {
        return $this->render('success-order');
    }


    public function actionSubmit() {
        try {
            $post = $this->validateRequest();
            $this->validateRequiredFields($post);
            $this->validateDeliveryFields($post);

            $order = $this->updateOrder($post);
            $this->processOrder($order);
            $order->updateTotalPrice();

            if ($post['payment_method'] == '2') {
                $url = $this->youKassaPayment($order);
                return $this->asJson(['success' => true, 'redirect_url' => $url]);
            }

            return $this->asJson(['success' => true, 'order_id' => $order->id]);
        } catch (\Exception $e) {
            return $this->asJson(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    private function validateRequest(): array
    {
        $post = Yii::$app->request->post();
        if (empty($post)) {
            throw new \Exception('Ошибка при передаче данных');
        }
        return $post;
    }

    private function validateRequiredFields(array $post): void
    {
        $required = ['phone', 'email', 'delivery_id', 'payment_method'];
        foreach ($required as $field) {
            if (empty($post[$field])) {
                throw new \Exception('Ошибка при оформлении заказа');
            }
        }
    }

    private function validateDeliveryFields(array $post): void
    {
        if ((int)$post['delivery_id'] == Delivery::ID_PICKUP && empty($post['pickup_point_id'])) {
            throw new \Exception('Заполните недостающие данные');
        }

        if ((int)$post['delivery_id'] == Delivery::ID_COURIER) {
            $required = ['city', 'street', 'house'];
            foreach ($required as $field) {
                if (empty($post[$field])) {
                    throw new \Exception('Заполните недостающие данные');
                }
            }
        }
    }

    private function updateOrder(array $data): Order
    {
        $order = Order::find()
            ->where(['user_id' => Yii::$app->user->id, 'status' => Order::STATUS_DRAFT])
            ->one();

        if (!$order) {
            throw new \RuntimeException('Корзина не найдена');
        }

        $order->payment_method_id = $data['payment_method'] ?? '';
        $order->delivery_id = $data['delivery_id'] ?? 1;
        $order->pickup_point_id = $data['pickup_point_id'] ?? '';
        $order->city = $data['city'] ?? '';
        $order->street = $data['street'] ?? '';
        $order->house = $data['house'] ?? '';
        $order->status = Order::STATUS_CREATED;
        $order->phone = $data['phone'] ?? '';
        $order->email = $data['email'] ?? '';
        $order->delivery_price = $data['delivery_price'] ?? 0;
        $order->comment = $data['comment'] ?? null;

        return $order;
    }

    private function processOrder(Order $order): void
    {
        if (!$order->save()) {
            throw new \RuntimeException('Не удалось сохранить заказ: ' . json_encode($order->getErrors()));
        }
    }

    /**
     * @throws \Exception
     */
    public function actionGetDeliveryCost()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $post = $this->validateRequest();
        $order = $this->findDraftOrder();
        $weight = $order->getCommonWeight();
        $city = $post['city_code'] ?? null;

        return $this->asJson([
            'success' => true,
            'delivery_cost' => Yii::$app->cdekService->getTariffSumm($weight, $city),
            'message' => 'Стоимость доставки рассчитана'
        ]);
    }

    public function actionGetPickupPoints($cityCode)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $city = City::findOne(['city_code' => $cityCode]);
        return $city->getPickupPoints();

    }

    private function youKassaPayment(Order $order)
    {
        $secretKey = 'test_PJdR1kyi5NgL0nZi1Mi8Bn8hBWUr8f1U0TtnaIjR7pU';
        $shopId = '1107680';


        $client = new Client();
        $client->setAuth($shopId, $secretKey);
        try {
            $idempotenceKey = uniqid('', true);
            $response = $client->createPayment(
                array(
                    'amount' => array(
                        'value' => $order->total_price,
                        'currency' => 'RUB',
                    ),
                    'confirmation' => array(
                        'type' => 'redirect',
                        'locale' => 'ru_RU',
                        'return_url' => 'http://localhost:20080/cart/success-order',
                    ),
                    'capture' => true,
                    'description' => 'Заказ №' . $order->id,
                    'metadata' => array(
                        'orderNumber' => $order->id
                    ),
                    'receipt' => array(
                        'customer' => array(
                            'full_name' => 'Тестовые данные',
                            'email' => 'email@email.ru',
//                            'phone' => '89536635145',
//                            'inn' => '440118073994'
                        ),
                        'items' => array(
                            array(
                                'description' => 'Переносное зарядное устройство Хувей',
                                'quantity' => '1.00',
                                'amount' => array(
                                    'value' => 1000,
                                    'currency' => 'RUB'
                                ),
                                'vat_code' => '2',
                                'payment_mode' => 'full_payment',
                                'payment_subject' => 'commodity',
                                'country_of_origin_code' => 'CN',
                                'product_code' => '44 4D 01 00 21 FA 41 00 23 05 41 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 12 00 AB 00',
                                'customs_declaration_number' => '10714040/140917/0090376',
                                'excise' => '20.00',
                                'supplier' => array(
                                    'name' => 'string',
//                                    'phone' => 'string',
//                                    'inn' => 'string'
                                )
                            ),
                        )
                    )
                ),
                $idempotenceKey
            );

            //получаем confirmationUrl для дальнейшего редиректа
            return $response->getConfirmation()->getConfirmationUrl();
        } catch (\Exception $e) {
            return $e;
        }
    }

}