<?php

namespace frontend\controllers;

use yii\web\Controller;

class WishlistController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}