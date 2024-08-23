<?php
/**@var Author $author */

/**@var SubscriptionForm $model */

use app\models\Author;
use app\models\SubscriptionForm;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

?>

<p class="lead">Подпишитесь на новые книги автора <b><?= $author ?></b>.</p>

<?php $form = ActiveForm::begin([
    'id' => 'subscription-form',
    'action' => \yii\helpers\Url::to(['subscription/subscribe', 'id' => $author->id])
//    'enableAjaxValidation' => true,
//    'validationUrl' => Url::to(['subscription/subscribe', 'id' => $author->id]),
//    'enableClientValidation' => false,
]); ?>

<?= $form->field($model, 'phone'); ?>

<div class="form-group">
    <?= Html::submitButton('Подписаться', ['class' => 'btn btn-primary', 'name' => 'send-subscription-form-button']) ?>
</div>

<?php ActiveForm::end(); ?>
