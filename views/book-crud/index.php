<?php

use app\models\Book;
use yii\bootstrap5\LinkPager;
use yii\data\DataProviderInterface;
use yii\grid\ActionColumn;

/**@var DataProviderInterface<Book> $dataProvider */

?>

<?= yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'name',
        'issue_year',
        [
            'class' => ActionColumn::class,
            'template' => '{view} &nbsp;  {update} &nbsp; {delete}',
        ],
    ],
    'pager' => [
        'class' => LinkPager::class
    ]
]) ?>