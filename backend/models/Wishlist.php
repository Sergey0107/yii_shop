<?php

namespace backend\models;

use backend\models\Product;
use Yii;

/**
 * This is the model class for table "wishlist".
 *
 * @property int|null $user_id
 * @property int|null $product_id
 */
class Wishlist extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wishlist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'product_id'], 'default', 'value' => null],
            [['user_id', 'product_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'product_id' => 'Product ID',
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public static function getUserWishlistProducts($userId)
    {
        return Product::find()
            ->select('product.*')
            ->innerJoin('wishlist', 'wishlist.product_id = product.id')
            ->where(['wishlist.user_id' => $userId])
            ->all();
    }

}
