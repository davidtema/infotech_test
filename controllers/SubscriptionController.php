<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\Author;
use app\models\SubscriptionForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

final class SubscriptionController extends Controller
{
    /**
     * @throws NotFoundHttpException
     */
    public function actionForm(int $id): string
    {
        $author = Author::findOne($id) ??
            throw new NotFoundHttpException('Автор не найден.');

        $model = new SubscriptionForm();

        return $this->renderAjax('form', [
            'author' => $author,
            'model' => $model
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionSubscribe(int $id): array
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $author = Author::findOne($id) ??
            throw new NotFoundHttpException('Автор не найден.');

        $model = new SubscriptionForm();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $model->subscribe($author);
            return ['status' => 'ok'];
        }

        return [
            'status' => 'error',
            'details' => $model->errors
        ];
    }
}
