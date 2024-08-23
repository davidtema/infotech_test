<?php

declare(strict_types=1);

namespace app\models;

use app\validator\IsbnValidator;
use app\validator\PhotoValidator;
use app\validator\YearValidator;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property string $isbn
 * @property string $about
 * @property int $issue_year
 * @property string $photo
 * @property Author[] $authors
 */
final class Book extends ActiveRecord
{
    public array $_authors = [];

    public static function tableName(): string
    {
        return 'book';
    }

    public function rules(): array
    {
        return [
            [['isbn', 'name', 'about', 'issue_year', 'photo'], 'required'],
            ['isbn', IsbnValidator::class],
            ['issue_year', YearValidator::class],
            ['photo', PhotoValidator::class],
        ];
    }

    public function load($data, $formName = null): bool
    {
        if (isset($data[$this->formName()]['authors'])) {
            $this->populateRelation('authors', Author::find()->andWhere(['in', 'id', $data[$this->formName()]['authors']])->all());
        }

        return parent::load($data, $formName);
    }

    /**
     * @throws InvalidConfigException
     */
    public function getAuthors(): \yii\db\ActiveQuery
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->viaTable('book_author', ['book_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes): void
    {
        // delete authors
        \Yii::$app->db->createCommand('DELETE FROM book_author WHERE book_id=:id', [
            ':id' => $this->id,
        ])->execute();

        // add authors
        foreach ($this->authors as $author) {
            \Yii::$app->db->createCommand('INSERT INTO book_author (book_id, author_id) VALUES (:book_id, :author_id)', [
                ':book_id' => $this->id,
                ':author_id' => $author->id
            ])->execute();
        }

        parent::afterSave($insert, $changedAttributes);
    }

    public function afterDelete(): void
    {
        \Yii::$app->db->createCommand('DELETE FROM book_author WHERE book_id=:id', [
            ':id' => $this->id,
        ])->execute();
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Название',
            'about' => 'Описание',
            'issue_year' => 'Год выпуска',
            'photo' => 'Фото (URL)',
            'authors' => 'Авторы'
        ];
    }
}
