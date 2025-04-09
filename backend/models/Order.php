<?php

namespace app\models;

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
            [['delivery_id'], 'exist', 'skipOnError' => true, 'targetClass' => Delivery::class, 'targetAttribute' => ['delivery_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'total_price' => 'Total Price',
            'status' => 'Status',
            'created_at' => 'Created At',
            'delivery_id' => 'Delivery ID',
            'delivery_address' => 'Delivery Address',
        ];
    }

    /**
     * Gets query for [[Delivery]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDelivery()
    {
        return $this->hasOne(Delivery::class, ['id' => 'delivery_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
