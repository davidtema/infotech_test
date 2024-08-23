<?php

declare(strict_types=1);

namespace app\bootstrap;

use app\event\handler\BookAfterSaveEventHandler;
use app\models\Book;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\db\AfterSaveEvent;
use yii\db\BaseActiveRecord;

final class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        Event::on(Book::class, BaseActiveRecord::EVENT_AFTER_INSERT, function (AfterSaveEvent $e) {
            $handler = \Yii::createObject(BookAfterSaveEventHandler::class);
            /**@var Book $book */
            $book = $e->sender;
            $handler($book);
        });
    }
}
