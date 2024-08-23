<?php

declare(strict_types=1);

namespace app\models;

use yii\base\Model;

final class SubscriptionForm extends Model
{
    public ?string $phone = '';

    public function rules(): array
    {
        return [
            ['phone', 'required']
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'phone' => 'Ваш телефон'
        ];
    }

    public function subscribe(Author $author): void
    {
        $subscriber = new Subscriber();
        $subscriber->phone = $this->phone;
        $subscriber->author_id = $author->id;
        $subscriber->save();
    }
}
