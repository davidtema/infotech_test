<?php

declare(strict_types=1);

namespace app\validator;

use yii\validators\Validator;

final class PhotoValidator extends Validator
{
    public function validateAttribute($model, $attribute): void
    {
        if (!preg_match('|^https?://|', $model->$attribute)) {
            $this->addError($model, $attribute, "\"{$attribute}\" должен быть URL.");
        }
    }
}
