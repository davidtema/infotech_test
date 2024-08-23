<?php

declare(strict_types=1);

namespace app\event\handler;

use app\models\Book;

final class BookAfterSaveEventHandler
{
    public function __construct()
    {
    }

    public function __invoke(Book $book): void
    {
        //        todo add notification job here
        //        $queue = \Yii::$app->queue;
        //        $queue->push(new NotifyAuthorSubscribersJob($book));
    }
}
