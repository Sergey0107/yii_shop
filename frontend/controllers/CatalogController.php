<?php

namespace frontend\controllers;

use backend\models\Product;
use yii\web\Controller;

class CatalogController extends Controller
{
    public function actionIndex()
    {
        $queryParams = \Yii::$app->request->get();

        $colorId = $queryParams['color'] ?? null;
        $countryId = $queryParams['country'] ?? null;
        $deliveryId = $queryParams['delivery'] ?? null;
        $materialId = $queryParams['material'] ?? null;
        $typeId = $queryParams['type'] ?? null;
        $sizeId = $queryParams['size'] ?? null;

        $propertyValues = $queryParams['properties'] ?? [];

        $query = Product::find();

        if ($colorId) $query->andWhere(['color_id' => $colorId]);
        if ($countryId) $query->andWhere(['country_id' => $countryId]);
        if ($materialId) $query->andWhere(['material_id' => $materialId]);
        if ($typeId) $query->andWhere(['type_id' => $typeId]);
        if ($sizeId) $query->andWhere(['size_id' => $sizeId]);

        if (!empty($propertyValues)) {
            foreach ($propertyValues as $i => $propertyValueId) {
                $alias = "pp_$i";

                $query->innerJoin(
                    ["$alias" => '{{%product_property}}'],
                    "$alias.product_id = product.id"
                )->andWhere(["$alias.value_id" => $propertyValueId]);
            }
        }

//        echo $query->createCommand()->rawSql;
//        exit;

        $products = $query->all();

        return $this->render('index', [
            'products' => $products,
        ]);
    }


    public function actionCard($id)
    {
        $product = Product::findOne($id);
        return $this->render('card', ['product' => $product]);
    }

}