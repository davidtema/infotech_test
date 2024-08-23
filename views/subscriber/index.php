<?php
/**@var \yii\data\DataProviderInterface $dataProvider */

use yii\bootstrap5\LinkPager;

?>

    <h1>Подписчики</h1>

    <p>Здесь для удобства отображены все подписчики в системе.
        Подписка представляет собой сущность Подписчик (Автор, телефон).</p>

<?= yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'phone',
        'author'
    ],
    'pager' => [
        'class' => LinkPager::class
    ]
]) ?>