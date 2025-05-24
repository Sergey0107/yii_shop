<?php

namespace backend\models;

use backend\models\Order;
use backend\models\Product;
use Yii;
use yii\db\StaleObjectException;

/**
 * This is the model class for table "order_products".
 *
 * @property int $id
 * @property int|null $order_id
 * @property int|null $product_id
 * @property int|null $quantity
 *
 * @property Order $order
 * @property Product $product
 */
class OrderProducts extends \yii\db\ActiveRecord
{
    /**
     * @var mixed|null
     */


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id'], 'default', 'value' => null],
            [['order_id', 'product_id'], 'integer'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'product_id' => 'Product ID',
            'quantity' => 'Quantity',
        ];
    }

    /**
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function afterDelete()
    {
        parent::afterDelete();

        $order = Order::findOne($this->order_id);
        if ($order) {
            $order->updateTotalPrice();
            if ($order->total_price == 0) {
                $order->delete();
            }
        }
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

}
