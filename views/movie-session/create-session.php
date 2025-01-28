<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Movie */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Добавить новый сеанс';

?>

<div class="row"> <!-- форма добавления сеанса ----------------------->
    <div class="movie-form col-lg-6 mx-auto">
        <p><?php print_r(date('Y-m-d H:i')); ?></p>
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($movieSession, 'movie_id')->dropDownList(
            $movies, // массив 
            ['prompt' => 'Выберите фильм']
        )->label('Фильм') ?>
        <?

        echo $form->field($movieSession, 'date_time')->widget(DateTimePicker::class, [
            'options' => ['placeholder' => 'Дата и время сеанса...'],
            'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd hh:ii',
                'startDate' => date('Y-m-d H:i'), // Сегодня не работает... :(
            ],
        ]);
        ?>
        <?= $form->field($movieSession, 'price')->textInput(['maxlength' => true])->label('Цена билета') ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>