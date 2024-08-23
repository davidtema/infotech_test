<?php

declare(strict_types=1);

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $author_id
 * @property Author $author
 * @property string $phone
 */
final class Subscriber extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'subscriber';
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }

    public function attributeLabels(): array
    {
        return [
            'author' => 'Автор',
            'phone' => 'Телефон',
        ];
    }
}
