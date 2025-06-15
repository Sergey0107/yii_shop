<?php

namespace backend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "review".
 *
 * @property int $id
 * @property int|null $product_id
 * @property int|null $user_id
 * @property int|null $rating
 * @property string|null $review
 *
 * @property Product $product
 * @property User $user
 */
class Review extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'review';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'user_id', 'rating', 'review'], 'default', 'value' => null],
            [['product_id', 'user_id', 'rating'], 'integer'],
            [['review'], 'string'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
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
            'product_id' => 'ID товара',
            'user_id' => 'ID пользователя',
            'rating' => 'Рейтинг',
            'review' => 'Отзыв',
        ];
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
