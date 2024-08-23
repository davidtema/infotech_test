<?php

declare(strict_types=1);

namespace app\job;

use app\models\Book;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\queue\JobInterface;

final readonly class NotifyAuthorSubscribersJob implements JobInterface
{
    public function __construct(private Book $book)
    {
    }

    public function execute($queue)
    {
        $authors = ArrayHelper::getColumn($this->book->authors, 'id');

        $subscribers = (new Query())
            ->select('s.id')
            ->from('subscriber s')
            ->leftJoin('subscriber_notification n', 's.id = n.subscriber_id AND n.book_id=:book_id', [
                ':book_id' => $this->book->id
            ])
            ->where([
                's.author_id' => $authors,
                'n.id' => null,
            ])
            ->limit(1)
            ->column();

        // send messages, then add record to subscriber_notification table
    }
}
