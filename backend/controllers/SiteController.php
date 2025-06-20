<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\ForbiddenHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'error'],
                        'roles' => ['?', '@'], // Разрешаем доступ всем (и гостям, и авторизованным)
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['admin', 'manager'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    if ($action->id === 'error') {
                        return true; // Разрешаем доступ к странице ошибки всегда
                    }

                    if (Yii::$app->user->isGuest) {
                        return $this->redirect(['site/login']);
                    }

                    return $this->redirect(['site/error']);
                },
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [

                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
                'view' => 'error',
                'layout' => 'blank', // Use a lightweight layout for the error page
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->login()) {
                $user = Yii::$app->user->identity;
                $auth = Yii::$app->authManager;
                $userRoles = $auth->getRolesByUser($user->id);

                $allowedRoles = ['admin', 'manager'];
                $hasAccess = !empty(array_intersect(array_keys($userRoles), $allowedRoles));

                if ($hasAccess) {
                    return $this->goBack();
                } else {
                    Yii::$app->user->logout();
                    //Yii::$app->session->setFlash('error', 'Доступ разрешен только администраторам и менеджерам.');
                    return $this->refresh();
                }
            }
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['site/login']);
    }
}