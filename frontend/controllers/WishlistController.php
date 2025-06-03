<?php

namespace frontend\controllers;

use backend\models\Wishlist;
use Yii;
use yii\web\Controller;

class WishlistController extends Controller
{
    public function actionIndex()
    {
        $products = Wishlist::getUserWishlistProducts(Yii::$app->user->id);

        return $this->render('index', ['products' => $products]);
    }
}