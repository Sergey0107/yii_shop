<?php

namespace backend\controllers;

use backend\models\Country;
use backend\models\Product;
use backend\models\ProductSearch;
use backend\models\Size;
use backend\services\CountryServices;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Product();

        $sizes = (new \backend\services\SpecificationServices())->getSizes();
        $countries = (new \backend\services\SpecificationServices())->getCountries();
        $colors = (new \backend\services\SpecificationServices)->getColors();
        $types = (new \backend\services\SpecificationServices)->getTypes();
        $material = (new \backend\services\SpecificationServices)->getMaterials();

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile'); // Получаем загруженный файл
            if ($model->upload()) { // Загружаем файл и сохраняем путь
                if ($model->save(false)) { // Сохраняем модель в базу данных
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'sizes' => $sizes,
            'countries' => $countries,
            'colors' => $colors,
            'types' => $types,
            'materials' => $material,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $sizes = (new \backend\services\SpecificationServices())->getSizes();
        $countries = (new \backend\services\SpecificationServices())->getCountries();
        $colors = (new \backend\services\SpecificationServices)->getColors();
        $types = (new \backend\services\SpecificationServices)->getTypes();
        $material = (new \backend\services\SpecificationServices)->getMaterials();

        if ($model->load(Yii::$app->request->post())) {

            $model->imageFile = UploadedFile::getInstance($model, 'imageFile'); // Получаем загруженный файл
            if ($model->upload()) { // Загружаем файл и сохраняем путь
                if ($model->save(false)) { // Сохраняем модель в базу данных
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'sizes' => $sizes,
            'countries' => $countries,
            'colors' => $colors,
            'types' => $types,
            'materials' => $material,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $fileName = $model->img;
        $model->deleteImage($fileName);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
