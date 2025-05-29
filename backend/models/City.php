<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property int $id
 * @property string $name
 * @property string $city_code
 */
class City extends \yii\db\ActiveRecord
{

    const CODE_KOSTROMA_CDEK = 165;          // Кострома для сдека

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'city_code'], 'required'],
            [['name', 'city_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название города',
            'city_code' => 'Код города',
        ];
    }

    public function getPickupPoints()
    {
        return Yii::$app->cdekService->getPickupPoints($this->city_code);
    }

}
