<?php

/** @var yii\web\View $this */

use yii\helpers\Url;

$this->title = 'Каталог книг';
?>
<div class="site-index">
    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4"><?= $this->title ?></h1>

        <p class="mt-4"><a class="btn btn-lg btn-success" href="<?= Url::to(['report/index']) ?>">ТОП 10 авторов
                выпуствиших больше книг за отчётный год</a></p>
    </div>
</div>
