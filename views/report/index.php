<?php

use app\dto\TopAuthorDto;
use app\models\TopAuthorSearchForm;
use yii\data\DataProviderInterface;
use yii\helpers\Url;

$this->title = 'Отчёт';

/**@var TopAuthorSearchForm $form */
/**@var array<int> $years */
/**@var DataProviderInterface<TopAuthorDto> $records */

?>

<h1>Топ-10 авторов, выпустивших наибольшее число книг за год</h1>

<?php foreach ($years as $year) { ?>
    <a href="<?= Url::current(['year' => $year]) ?>"><?php echo $year ?></a>
<?php } ?>

<?php if (!$form->year) { ?>
    <p class="lead mt-4">Выберите год</p>
<?php } else { ?>
    <?php
    if ($form->hasErrors()) { ?>
        <div class="link-danger mt-4">
            <?php foreach ($form->errors as $error) {
                foreach ($error as $message) {
                    echo $message . '<br/>';
                }
            } ?>
        </div>
    <?php } else { ?>

        <p class="lead mt-4">Отчётный год: <b><?= $form->year ?></b>.</p>

        <table class="table table-striped mt-4">
            <tr>
                <th>Автор</th>
                <th>Количество книг за год</th>
                <th>Подписка</th>
            </tr>
            <?php foreach ($records->getModels() as $record) { ?>
                <tr>
                    <td><?= $record->author ?></td>
                    <td><?= $record->booksCount ?></td>
                    <td>
                        <button class="btn btn-outline-dark btn-subscribe" data-id="<?= $record->author->id ?>">
                            Подписаться
                        </button>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>
<?php } ?>
