<?php

namespace backend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $user_id
 * @property int $total_price
 * @property int $status
 * @property string $created_at
 * @property int $delivery_id
 * @property string|null $delivery_address
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
            [['delivery_address'], 'default', 'value' => null],
            [['delivery_id'], 'default', 'value' => 1],
            [['user_id', 'total_price', 'status'], 'required'],
            [['user_id', 'total_price', 'status', 'delivery_id'], 'integer'],
            [['created_at'], 'safe'],
            [['delivery_address'], 'string', 'max' => 255],
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
            'delivery_address' => 'Адрес доставки',
            'statusName' => 'Статус заказа', // Виртуальный атрибут
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
        // Получаем все товары заказа одним запросом
        $orderProducts = $this->orderProducts;

        if (!empty($orderProducts)) {
            foreach ($orderProducts as $orderProduct) {
                // Проверка на существование связанного товара
                if ($orderProduct->product) {
                    $total += $orderProduct->product->price * $orderProduct->quantity;
                }
            }
        }

        $this->total_price = $total;
    }

    public function getCountProducts()
    {
        return $this->getOrderProducts()->count();
    }
}