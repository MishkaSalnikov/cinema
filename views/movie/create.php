<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Movie */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Добавить новый фильм';

?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $isUpdateSession = strpos($_SERVER['REQUEST_URI'], '/update-session?') !== false; ?>


<div class="accordion" id="accordionExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingOne">
      <button class="accordion-button bg-primary <?= $isUpdateSession ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="<?= $isUpdateSession ? 'false' : 'true' ?>" aria-controls="collapseOne">
        Добавить фильм
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse <?= $isUpdateSession ? '' : 'show' ?>" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
      <div class="accordion-body">
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
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="accordion-item">
    <h2 class="accordion-header" id="headingTwo">
      <button class="accordion-button <?= $isUpdateSession ? '' : 'collapsed' ?> bg-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="<?= $isUpdateSession ? 'true' : 'false' ?>" aria-controls="collapseTwo">
        <?= $isUpdateSession ? 'Изменить' : 'Добавить' ?> сеанс
      </button>
    </h2>

    <div id="collapseTwo" class="accordion-collapse collapse <?= $isUpdateSession ? 'show' : '' ?>" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
      <div class="accordion-body">

        <div class="row"> <!-- форма добавления сеанса ----------------------->
          <div class="movie-form col-lg-6 mx-auto">
            <p><?php print_r(date('Y-m-d H:i')); ?></p>
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($movieSession, 'movie_id')->dropDownList(
              $movies, // массив 
              ['prompt' => 'Выберите фильм']
            )->label('Фильм') ?>
            <?
            $movieSession->date_time = '2025-05-01 12:00';
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
      </div>
    </div>
  </div>
</div>