<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\Subscriber;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

final class SubscriberController extends Controller
{
    public function actionIndex(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Subscriber::find()
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }
}
