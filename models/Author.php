<?php

declare(strict_types=1);

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $patronymic
 */
final class Author extends ActiveRecord implements \Stringable
{
    public static function tableName(): string
    {
        return 'author';
    }

    public function __toString(): string
    {
        return $this->last_name . ' ' . $this->first_name . ' ' . $this->patronymic;
    }
}