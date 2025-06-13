<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class StatisticController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'], // Только для админов
                    ],
                    [
                        'allow' => false, // Явно запрещаем все остальное
                        'roles' => ['*'], // Все пользователи (включая гостей)
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        return $this->redirect(['site/index']);
                    }
                    throw new ForbiddenHttpException('У вас нет доступа к этой странице');
                },
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    // Настройки HTTP-методов
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        return $this->render('index');
    }
}