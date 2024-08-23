<?php
/**@var Book $book */

/**@var Author[] $authors */

use app\models\Author;
use app\models\Book;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = $book->isNewRecord ? 'Новая книга' : $book->name;

?>

<h1 class="mb-4"><?= $this->title ?></h1>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?= $form->errorSummary($book) ?>

<?= $form->field($book, 'name') ?>
<?= $form->field($book, 'isbn') ?>
<?= $form->field($book, 'issue_year') ?>
<?= $form->field($book, 'photo') ?>
<?= $form->field($book, 'about')->textarea([
    'rows' => 8
]) ?>
<?= $form->field($book, 'authors')->checkboxList($authors) ?>

<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'id' => 'save-button']); ?>

<?php ActiveForm::end(); ?>
