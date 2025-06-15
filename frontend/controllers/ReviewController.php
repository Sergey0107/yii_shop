<?php

namespace frontend\controllers;

use backend\models\Review;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class ReviewController extends Controller
{

    public function actionCreate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        $userId = Yii::$app->user->id;

        $review = new Review();
        $review->user_id = $userId;
        $review->product_id = $post['product_id'];
        $review->rating = $post['rating'];
        $review->review = $post['comment'];
        $review->created_at = date('Y-m-d H:i:s');

        if (!$review->save(false)) {
            throw new \Exception('Ошибка при сохранении отзыва');
        }

        // Получаем свежие данные отзыва с отношениями (если нужно)
        $review->refresh();

        return $this->asJson([
            'success' => true,
            'review' => [
                'id' => $review->id,
                'user_name' => $review->user->username ?? 'Аноним', // если есть связь с пользователем
                'rating' => $review->rating,
                'comment' => $review->review,
                'created_at' => Yii::$app->formatter->asDatetime($review->created_at),
            ]
        ]);
    }
}