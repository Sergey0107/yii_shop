<?php

namespace frontend\controllers;

use backend\models\Product;
use yii\web\Controller;

class CatalogController extends Controller
{
    public function actionIndex()
    {
        $products = Product::find()->all();
        return $this->render('index', ['products' => $products]);
    }

}