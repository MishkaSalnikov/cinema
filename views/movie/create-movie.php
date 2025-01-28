<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Movie */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Добавить новый фильм';

if (@$movie) {
    $model->title = $movie['title'];
    $model->description = $movie['description'];
    $model->duration = $movie['duration'];
    $model->restrictions = $movie['restrictions'];
}
$uploadPath = Yii::$app->params['uploadPathUrl'];
$img = empty($movie->pict) ? '' : Yii::getAlias($uploadPath . $movie->id . '.' . $movie->pict);
$imgTag = empty($movie->pict) ? '' :   '<img src="' . Html::encode($img) . '" class="img-fluid rounded d-block">';





?>

<div class="row">
    <div class="movie-form col-lg-6 mx-auto"> <!-- форма добавления фильма ----------------------->
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
        <?= $imgTag; ?>
    </div>
</div>

<pre>
    <?php
    //print_r($movie);
    ?>
</pre>