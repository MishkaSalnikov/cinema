<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Movie */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Добавить новый фильм';
//[['title', 'description', 'duration', 'restrictions', 'pict'], 'required'],
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php /*
<div class="movie-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'genre')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'release_date')->input('date') ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
*/
?>

<div class="row">
<div class="movie-form col-lg-6 mx-auto">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('Название фильма') ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 6, 'maxlength' => true])->label('Описание (не более 1000 симв)') ?>
    <?= $form->field($model, 'duration')->textInput(['maxlength' => true])->label('Продолжительность в минутах') ?>
    <?= $form->field($model, 'restrictions')->textInput(['maxlength' => true])->label('Возрастные ограничения (целое число от 0 до 99)') ?>
    <?= $form->field($model, 'pict')->fileInput()->label('Постер (от 300 до 3000px)') ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
</div>