<?php

use yii\db\Migration;

class m240821_141223_create_book_and_author extends Migration
{
    private const ISBN_LENGTH = 13;

    public function safeUp(): bool
    {
        $this->createTable('book', [
            'id' => $this->primaryKey(),
            'isbn' => $this->string(self::ISBN_LENGTH)->notNull(),
            'name' => $this->string()->notNull(),
            'about' => $this->text()->notNull(),
            'issue_year' => $this->smallInteger(4)->notNull(),
            'photo' => $this->string()->notNull(),
        ]);
        $this->createIndex('idx_book_year', 'book', ['issue_year']);

        $this->createTable('author', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'patronymic' => $this->string()->notNull()
        ]);

        $this->createTable('book_author', [
            'book_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
        ]);
        $this->createIndex(
            'idx_book_id',
            'book_author',
            ['book_id']
        );
        $this->createIndex(
            'idx_author_id',
            'book_author',
            ['author_id']
        );
        $this->createIndex(
            'idx_author_book_id',
            'book_author',
            ['author_id', 'book_id'],
            true
        );

        return true;
    }

    public function safeDown(): bool
    {
        $this->dropTable('book_author');
        $this->dropTable('author');

        return true;
    }
}
