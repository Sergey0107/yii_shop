<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "delivery".
 *
 * @property int $id
 * @property string $name
 */
class Delivery extends \yii\db\ActiveRecord
{

    public const ID_WAREHOUSE = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'delivery';
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

}
