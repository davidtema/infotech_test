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

        $this->fill();

        return true;
    }

    public function safeDown(): bool
    {
        $this->dropTable('book');
        $this->dropTable('author');
        $this->dropTable('book_author');

        return true;
    }

    private function fill()
    {
        $bookImage = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTSA994pvCUL9WWHRWo-VLcNxkFx-n7_9JqtA&s';

        $authors = [
            [
                'first_name' => 'Василий',
                'last_name' => 'Ползунов',
                'patronymic' => 'Аркадьевич',
            ],
            [
                'first_name' => 'Ольга',
                'last_name' => 'Вкусноедова',
                'patronymic' => 'Яковлевна',
            ],
            [
                'first_name' => 'Артём',
                'last_name' => 'Непоседов',
                'patronymic' => 'Романович',
            ],
            [
                'first_name' => 'Алексей',
                'last_name' => 'Монотонов',
                'patronymic' => 'Юрьевич',
            ],
            [
                'first_name' => 'Вадим',
                'last_name' => 'Улетаев',
                'patronymic' => 'Маркович',
            ],
            [
                'first_name' => 'Татьяна',
                'last_name' => 'Небылицына',
                'patronymic' => 'Анатольевна',
            ],
            [
                'first_name' => 'Мария',
                'last_name' => 'Говорилова',
                'patronymic' => 'Борисовна',
            ],
            [
                'first_name' => 'Иван',
                'last_name' => 'Столет',
                'patronymic' => 'Ивнанович',
            ],
            [
                'first_name' => 'Семён',
                'last_name' => 'Боль',
                'patronymic' => 'Семёнович',
            ],
            [
                'first_name' => 'Людмила',
                'last_name' => 'Огородова',
                'patronymic' => 'Николаевна',
            ],
            [
                'first_name' => 'Сергей',
                'last_name' => 'Коровин',
                'patronymic' => 'Игоревич',
            ],
            [
                'first_name' => 'Всеволод',
                'last_name' => 'Непромах',
                'patronymic' => 'Александрович',
            ],
            [
                'first_name' => 'Екатерина',
                'last_name' => 'Ястребова',
                'patronymic' => 'Яковлевна',
            ],
        ];

        $years = [2020, 2021, 2022, 2023, 2024];

        // fill authors
        $authorIds = [];
        foreach ($authors as $authorCredentials) {
            $this->insert('author', [
                'first_name' => $authorCredentials['first_name'],
                'last_name' => $authorCredentials['last_name'],
                'patronymic' => $authorCredentials['patronymic'],
            ]);
            $authorIds[] = $this->db->lastInsertID;
        }

        // fill books and books-authors relation
        for ($i = 0; $i < 100; $i++) {
            $this->insert('book', [
                'name' => Yii::$app->security->generateRandomString(),
                'isbn' => Yii::$app->security->generateRandomString(self::ISBN_LENGTH),
                'photo' => $bookImage,
                'about' => 'Описание-описание-описание',
                'issue_year' => $years[array_rand($years)],
            ]);
            $bookId = $this->db->lastInsertID;

            // random authors for the book
            $bookAuthorsIds = array_rand($authorIds, rand(1, 2));
            if (!is_array($bookAuthorsIds)) {
                $bookAuthorsIds = [$bookAuthorsIds];
            }
            // fill book_author
            foreach ($bookAuthorsIds as $authorKey) {
                $this->insert('book_author', [
                    'book_id' => $bookId,
                    'author_id' => $authorIds[$authorKey]
                ]);
            }
        }
    }
}
