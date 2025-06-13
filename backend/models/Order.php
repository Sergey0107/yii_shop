<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $user_id
 * @property int $total_price
 * @property int $status
 * @property string $created_at
 * @property int $delivery_id
 * @property string|null $pickup_point_id
 * @property string|null $city
 * @property string|null $street
 * @property string|null $house
 * @property string|null $comment
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $payment_method_id
 * @property string|null $payment_status
 * @property int $delivery_price
 *
 *
 * @property Delivery $delivery
 * @property User $user
 */
class Order extends \yii\db\ActiveRecord
{
    // Константы статусов заказа
    const STATUS_DRAFT = 1;          // Черновик (недооформлен)
    const STATUS_CREATED = 2;        // Оформлен
    const STATUS_SHIPPED = 3;        // Передан в службу доставки
    const STATUS_IN_POINT = 4;       // В пункте выдачи
    const STATUS_DELIVERED = 5;      // Доставлен/получен
    const STATUS_CANCELLED = 6;      // Отменен

    /**
     * Названия статусов для отображения
     * @return array
     */
    public static function getStatusNames(): array
    {
        return [
            self::STATUS_DRAFT => 'Черновик',
            self::STATUS_CREATED => 'Оформлен',
            self::STATUS_SHIPPED => 'В доставке',
            self::STATUS_IN_POINT => 'В пункте выдачи',
            self::STATUS_DELIVERED => 'Доставлен',
            self::STATUS_CANCELLED => 'Отменен',
        ];
    }

    /**
     * Получить название текущего статуса
     * @return string
     */
    public function getStatusName(): string
    {
        $statuses = self::getStatusNames();
        return isset($statuses[$this->status]) ? $statuses[$this->status] : 'Неизвестный статус';
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['delivery_id'], 'default', 'value' => 1],
            [['user_id', 'total_price', 'status'], 'required'],
            [['user_id', 'total_price', 'status', 'delivery_id', 'delivery_price'], 'integer'],
            [['created_at'], 'safe'],
            [['status'], 'in', 'range' => array_keys(self::getStatusNames())],
            [['delivery_id'], 'exist', 'skipOnError' => true, 'targetClass' => Delivery::class, 'targetAttribute' => ['delivery_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID заказа',
            'user_id' => 'ID пользователя',
            'total_price' => 'Сумма заказа',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'delivery_id' => 'Способ доставки',
            'statusName' => 'Статус заказа',
            'delivery_price' => 'Стоимость доставки',
        ];
    }

    /**
     * Gets query for [[Delivery]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDelivery(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Delivery::class, ['id' => 'delivery_id']);
    }

    public function getOrderProducts(): \yii\db\ActiveQuery
    {
        return $this->hasMany(OrderProducts::class, ['order_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser(): \yii\db\ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function updateTotalPrice()
    {
        $total = 0;
        $orderProducts = $this->orderProducts;

        if (!empty($orderProducts)) {
            foreach ($orderProducts as $orderProduct) {
                if ($orderProduct->product) {
                    $total += $orderProduct->product->price * $orderProduct->quantity;
                }
            }
        }

        $this->total_price = $total;
        if ($this->delivery_price > 0) {
            $this->total_price += $this->delivery_price;
        }

        $this->save(false);
    }

    public function getCountProducts(): int
    {
        return (int)$this->getOrderProducts()->sum('quantity');
    }

    public function getProducts()
    {
        return $this->hasMany(Product::class, ['id' => 'product_id'])
            ->viaTable('order_products', ['order_id' => 'id']);
    }

    /**
     * @throws Exception
     */
    public function returnAllProductsInWarehouse(): void
    {
        $orderProducts = OrderProducts::findAll(['order_id' => $this->id]);
        if (!empty($orderProducts)) {
            foreach ($orderProducts as $orderProduct) {
                if ($orderProduct->product) {
                    $orderProduct->product->returnProductToWarehouse($orderProduct->quantity);
                }
            }
        }
    }

    public function getCommonWeight(): int
    {
        $orderProducts = OrderProducts::findAll(['order_id' => $this->id]);
        $weight = 0;
        foreach ($orderProducts as $orderProduct) {
            if ($orderProduct->product) {
                $weight += $orderProduct->product->weight;
            }
        }
        return $weight;
    }
}