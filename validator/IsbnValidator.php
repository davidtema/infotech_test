<?php

declare(strict_types=1);

namespace app\validator;

use yii\validators\Validator;

final class IsbnValidator extends Validator
{
    public function validateAttribute($model, $attribute): void
    {
        // отдельно проверка символов и длины строки для удобства чтения ошибки.
        if (!preg_match('|^[-0123456789]+$|', $model->$attribute)) {
            $this->addError($model, $attribute, 'Допустимы только числа и знак "-".');
        }
        if (strlen($model->$attribute) != 13) {
            $this->addError($model, $attribute, 'Точная длина строки должна составлять 13 символов.');
        }
    }
}
