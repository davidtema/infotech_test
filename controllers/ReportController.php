<?php

declare(strict_types=1);

namespace app\controllers;

use app\fetcher\BookFetcher;
use app\models\TopAuthorSearchForm;
use yii\web\Controller;

final class ReportController extends Controller
{
    public $layout = 'main';

    public function __construct($id, $module, private readonly BookFetcher $bookFetcher, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function actionIndex(): string
    {
        $form = new TopAuthorSearchForm($this->bookFetcher);
        $form->load(\Yii::$app->request->get(), '');
        $records = $form->search();

        return $this->render('index', [
            'records' => $records,
            'form' => $form,
            'years' => $this->bookFetcher->fetchYears()
        ]);
    }
}
