<?php

namespace backend\controllers;

use backend\models\UserSearch;
use Yii;
use common\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
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

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {
            // Валидация через AJAX
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            // Сохранение пользователя
            if ($this->saveUserWithRoles($model)) {
                Yii::$app->session->setFlash('success', 'Пользователь успешно создан.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            // Валидация через AJAX
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            // Сохранение пользователя
            if ($this->saveUserWithRoles($model)) {
                Yii::$app->session->setFlash('success', 'Пользователь успешно обновлен.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // Проверяем, не удаляем ли мы самого себя
        if ($model->id === Yii::$app->user->id) {
            Yii::$app->session->setFlash('error', 'Вы не можете удалить собственную учетную запись.');
            return $this->redirect(['index']);
        }

        // Удаляем все роли пользователя перед удалением
        $authManager = Yii::$app->authManager;
        $authManager->revokeAll($model->id);

        // Удаляем пользователя
        $model->delete();

        Yii::$app->session->setFlash('success', 'Пользователь успешно удален.');
        return $this->redirect(['index']);
    }

    /**
     * Сохраняет пользователя с ролями
     * @param User $model
     * @return bool
     */
    protected function saveUserWithRoles($model)
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            // Если пароль не изменился (пустой), убираем его из валидации
            if (empty($model->password) && !$model->isNewRecord) {
                $model->password = null;
            }

            // Сохраняем пользователя
            if (!$model->save()) {
                $transaction->rollBack();
                return false;
            }

            // Обрабатываем роли
            $authManager = Yii::$app->authManager;
            $selectedRoles = Yii::$app->request->post('user_roles', []);

            // Удаляем все текущие роли пользователя
            $authManager->revokeAll($model->id);

            // Назначаем новые роли
            foreach ($selectedRoles as $roleName) {
                $role = $authManager->getRole($roleName);
                if ($role) {
                    $authManager->assign($role, $model->id);
                }
            }

            $transaction->commit();
            return true;

        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error('Ошибка при сохранении пользователя с ролями: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }
    }
}