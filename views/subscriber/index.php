<?php
/**@var \yii\data\DataProviderInterface $dataProvider */

use yii\bootstrap5\LinkPager;

?>

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