<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "property".
 *
 * @property int $id
 * @property string $name
 *
 * @property ProductProperty[] $productProperties
 * @property PropertyValue[] $propertyValues
 */
class Property extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[ProductProperties]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductProperties()
    {
        return $this->hasMany(ProductProperty::class, ['property_id' => 'id']);
    }

    /**
     * Gets query for [[PropertyValues]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyValues()
    {
        return $this->hasMany(PropertyValue::class, ['property_id' => 'id']);
    }

}
