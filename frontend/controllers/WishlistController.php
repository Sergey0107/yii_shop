<?php

namespace frontend\controllers;

use backend\models\Wishlist;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class WishlistController extends Controller
{
    public function beforeAction($action)
    {
        if ($action->id === 'remove') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $products = Wishlist::getUserWishlistProducts(Yii::$app->user->id);

        return $this->render('index', ['products' => $products]);
    }

    public function actionAdd()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Проверка авторизации пользователя
        if (Yii::$app->user->isGuest) {
            return ['success' => false, 'message' => 'Пожалуйста, авторизуйтесь'];
        }

        // Получение ID товара из POST-запроса
        $productId = Yii::$app->request->post('id');
        if (!$productId || !is_numeric($productId)) {
            return ['success' => false, 'message' => 'Неверный ID товара'];
        }

        $userId = Yii::$app->user->id;

        // Проверка, есть ли товар в избранном
        $wishlistItem = Wishlist::findOne([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);

        if ($wishlistItem) {
            // Товар уже в избранном — удаляем
            if ($wishlistItem->delete()) {
                return ['success' => true];
            }
            return ['success' => false, 'message' => 'Не удалось удалить товар из избранного'];
        } else {
            // Товара нет в избранном — добавляем
            $wishlistItem = new Wishlist();
            $wishlistItem->user_id = $userId;
            $wishlistItem->product_id = $productId;
            if ($wishlistItem->save()) {
                return ['success' => true];
            }
            return ['success' => false, 'message' => 'Не удалось добавить товар в избранное'];
        }
    }

    public function actionRemove()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $productId = Yii::$app->request->post('product_id');
        if (!$productId) {
            return ['success' => false, 'message' => 'Не указан ID товара'];
        }

        $userId = Yii::$app->user->id;
        if (!$userId) {
            return ['success' => false, 'message' => 'Пользователь не авторизован'];
        }

        $wishlistItem = Wishlist::findOne([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);

        if ($wishlistItem && $wishlistItem->delete()) {
            return ['success' => true];
        }

        return ['success' => false, 'message' => 'Не удалось удалить товар из избранного'];
    }
}