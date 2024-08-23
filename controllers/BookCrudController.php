<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\Author;
use app\models\Book;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

final class BookCrudController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Book::find(),
            'pagination' => [
                'pageSize' => 10,
                'defaultPageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionCreate(): Response|string
    {
        $book = new Book();
        if ($book->load(\Yii::$app->request->post()) && $book->save()) {
            \Yii::$app->session->setFlash('success', 'Книга создана.');
            return $this->redirect(Url::to(['book-crud/index']));
        }

        return $this->render('form', [
            'book' => $book,
            'authors' => ArrayHelper::index(Author::find()->all(), 'id')
        ]);
    }

    /**
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id): string|Response
    {
        $book = $this->loadBook($id);
        if ($book->load(\Yii::$app->request->post()) && $book->save()) {
            \Yii::$app->session->setFlash('success', 'Изменения сохранены.');
            return $this->redirect(Url::to(['book-crud/index']));
        }

        return $this->render('form', [
            'book' => $book,
            'authors' => ArrayHelper::index(Author::find()->all(), 'id')
        ]);
    }

    /**
     * @throws Exception
     * @throws \Throwable
     * @throws NotFoundHttpException
     */
    public function actionDelete(int $id): \yii\web\Response
    {
        $book = $this->loadBook($id);
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $book->delete();
            $transaction->commit();
            \Yii::$app->session->setFlash('success', 'Книга удалена.');
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $this->redirect(Url::to(['book-crud/index']));
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        $book = $this->loadBook($id);

        return $this->render('view', [
            'book' => $book
        ]);
    }

    private function loadBook(int $id): Book
    {
        return Book::findOne($id) ??
            throw new NotFoundHttpException('Книга не найдена.');
    }
}
