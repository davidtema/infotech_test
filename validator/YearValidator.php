<?php

declare(strict_types=1);

namespace app\validator;

final class YearValidator extends \yii\validators\Validator
{
    public function validateAttribute($model, $attribute): void
    {
        $maxYear = date('Y');
        if (!preg_match('|^\d{1,4}$|', $model->$attribute)) {
            $this->addError($model, $attribute, 'Допустимые значения от 0 до ' . $maxYear . '.');
            return;
        }

        if ($model->$attribute > $maxYear) {
            $this->addError($model, $attribute, 'Год ещё не наступил.');
        }
    }
}
