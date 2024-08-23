<?php

use yii\db\Migration;

/**
 * Class m240822_143346_create_subscriber
 */
class m240822_143346_create_subscriber extends Migration
{
    public function safeUp(): bool
    {
        $this->createTable('subscriber', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'phone' => $this->string()->notNull(),
        ]);
        $this->createIndex('idx_subscriber_author', 'subscriber', 'author_id');

        $this->createTable('subscriber_notification', [
            'id' => $this->primaryKey(),
            'subscriber_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'book_id' => $this->integer()->notNull(),
        ]);
        $this->createIndex('idx_subscriber_notification_book', 'subscriber_notification', [
            'subscriber_id',
            'author_id',
            'book_id'
        ]);

        return true;
    }

    public function safeDown(): bool
    {
        $this->dropTable('subscriber');
        $this->dropTable('subscriber_notification');

        return true;
    }
}
