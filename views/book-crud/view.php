<?php
?>

<?php

use app\models\Book;
use yii\widgets\DetailView;

/**@var Book $book */

echo DetailView::widget([
    'model' => $book,
    'attributes' => [
        'id',
        'isbn',
        'name',
        'photo:image',
        'about',
        'issue_year',
        [
            'attribute' => 'authors',
            'value' => function (Book $book): string {
                return join(', ', $book->authors);
            }
        ]
    ],
]);
