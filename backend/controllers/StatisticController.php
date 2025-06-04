<?php

namespace backend\controllers;

use yii\web\Controller;

class StatisticController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}