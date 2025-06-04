<?php

namespace frontend\controllers;

use yii\web\Controller;

class ArticlesController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}