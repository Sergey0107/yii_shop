<?php

namespace frontend\controllers;

use backend\models\Product;
use Yii;
use yii\data\Pagination;
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
            case 'rating':
                $query->orderBy(['rating' => SORT_DESC]); // Add this if you have a rating field
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

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->pageSize = 12;

        $products = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'products' => $products,
            'pages' => $pages,
            'sort' => $sort, // Pass the sort parameter to the view
            'colors' => \backend\models\Color::find()->select(['id', 'name'])->asArray()->all(),
            'countries' => \backend\models\Country::find()->select(['id', 'name'])->asArray()->all(),
            'materials' => \backend\models\Material::find()->select(['id', 'name'])->asArray()->all(),
            'types' => \backend\models\Type::find()->select(['id', 'name'])->asArray()->all(),
            'sizes' => \backend\models\Size::find()->select(['id', 'value'])->asArray()->all(),
            'minProductPrice' => \backend\models\Product::find()->min('price') ?: 0,
            'maxProductPrice' => \backend\models\Product::find()->max('price') ?: 100000,
            'properties' => \backend\models\Property::find()->with('values')->all(),
            'selectedTypes' => $queryParams['type'] ?? [],
            'selectedColors' => $queryParams['color'] ?? [],
            'selectedSizes' => $queryParams['size'] ?? [],
            'selectedPriceMin' => $queryParams['min_price'] ?? (\backend\models\Product::find()->min('price') ?: 0),
            'selectedPriceMax' => $queryParams['max_price'] ?? (\backend\models\Product::find()->max('price') ?: 100000),
            'selectedMaterials' => $queryParams['material'] ?? [],
            'selectedCountries' => $queryParams['country'] ?? [],
            'selectedProperties' => $queryParams['properties'] ?? [],
        ]);
    }


    public function actionCard($id)
    {
        $product = Product::findOne($id);
        return $this->render('card', ['product' => $product]);
    }

}