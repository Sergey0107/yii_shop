<?php

namespace backend\controllers;

use backend\services\SpecificationServices;
use yii\filters\VerbFilter;
use yii\web\Controller;

class SpecificationController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Color models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $propertyAll = (new \backend\services\SpecificationServices)->getAllSpecifications();

        return $this->render('index', ['propertyAll' => $propertyAll]);
    }
}