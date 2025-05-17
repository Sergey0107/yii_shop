<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product_property".
 *
 * @property int $id
 * @property int|null $product_id
 * @property int|null $property_id
 * @property int|null $value_id
 *
 * @property Product $product
 * @property Property $property
 * @property PropertyValue $value
 */
class ProductProperty extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_property';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'property_id', 'value_id'], 'default', 'value' => null],
            [['product_id', 'property_id', 'value_id'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::class, 'targetAttribute' => ['property_id' => 'id']],
            [['value_id'], 'exist', 'skipOnError' => true, 'targetClass' => PropertyValue::class, 'targetAttribute' => ['value_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'property_id' => 'Property ID',
            'value_id' => 'Value ID',
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
     * Gets query for [[Property]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Property::class, ['id' => 'property_id']);
    }

    /**
     * Gets query for [[Value]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getValue()
    {
        return $this->hasOne(PropertyValue::class, ['id' => 'value_id']);
    }

    public function getPropertyValue()
    {
        return $this->hasOne(PropertyValue::class, ['id' => 'value_id']);
    }

}
