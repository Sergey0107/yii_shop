<?php

namespace frontend\controllers;

use backend\models\Product;
use Yii;
use yii\web\Controller;

class CatalogController extends Controller
{
    public function actionIndex()
    {
        $queryParams = \Yii::$app->request->get();

        $colorId = $queryParams['color'] ?? null;
        $countryId = $queryParams['country'] ?? null;
        $materialId = $queryParams['material'] ?? null;
        $typeId = $queryParams['type'] ?? null;
        $sizeId = $queryParams['size'] ?? null;
        $priceMin = $queryParams['min_price'] ?? null;
        $priceMax = $queryParams['max_price'] ?? null;

        $searchText = Yii::$app->request->get('text');
        $sort = Yii::$app->request->get('sort', 'popular');

        $propertyValues = $queryParams['properties'] ?? [];

        $query = Product::find();

        if ($colorId) $query->andWhere(['color_id' => $colorId]);
        if ($countryId) $query->andWhere(['country_id' => $countryId]);
        if ($materialId) $query->andWhere(['material_id' => $materialId]);
        if ($typeId) $query->andWhere(['type_id' => $typeId]);
        if ($sizeId) $query->andWhere(['size_id' => $sizeId]);
        if ($priceMin) $query->andWhere(['>=', 'price', $priceMin]);
        if ($priceMax) $query->andWhere(['<=', 'price', $priceMax]);
        if ($searchText) $query->andWhere(['like', 'name', $searchText]);

        switch ($sort) {
            case 'price-asc':
                $query->orderBy(['price' => SORT_ASC]);
                break;
            case 'price-desc':
                $query->orderBy(['price' => SORT_DESC]);
                break;
            case 'newest':
                $query->orderBy(['is_new' => SORT_DESC]);
                break;
            case 'popular':
            default:
                $query->orderBy(['is_popular' => SORT_DESC]);
                break;
        }

        if (!empty($propertyValues)) {
            foreach ($propertyValues as $i => $propertyValueId) {
                $alias = "pp_$i";

                $query->innerJoin(
                    ["$alias" => '{{%product_property}}'],
                    "$alias.product_id = product.id"
                )->andWhere(["$alias.value_id" => $propertyValueId]);
            }
        }
        //echo $query->createCommand()->rawSql; exit();
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