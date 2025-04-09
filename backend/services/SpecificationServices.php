<?php

namespace backend\services;

use backend\models\Color;
use backend\models\Country;
use backend\models\Material;
use backend\models\Size;
use backend\models\Type;

class SpecificationServices
{
    /**
     * Метод возвращает все характеристики
     * Формат: name => action
     */
    public function getAllSpecifications()
    {
        return [
            'Размер' => 'size/index',
            'Страна изготовитель' => 'country/index',
            'Тип ковра' => 'type/index',
            'Материал изготовления' => 'material/index',
            'Цвет' => 'color/index',
        ];
    }

    public function getCountries()
    {
        $countries = Country::find()->all();
        return \yii\helpers\ArrayHelper::map($countries, 'id', 'name');
    }

    public function getSizes()
    {
        $sizes = Size::find()->all();
        return \yii\helpers\ArrayHelper::map($sizes, 'id', 'value');
    }

    public function getColors()
    {
        $colors = Color::find()->all();
        return \yii\helpers\ArrayHelper::map($colors, 'id', 'name');
    }

    public function getTypes()
    {
        $types = Type::find()->all();
        return \yii\helpers\ArrayHelper::map($types, 'id', 'name');
    }

    public function getMaterials()
    {
        $materials = Material::find()->all();
        return \yii\helpers\ArrayHelper::map($materials, 'id', 'name');
    }

}