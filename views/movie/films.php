<?php

use yii\helpers\Html;


/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div class="site-index">

  <div class="jumbotron text-center bg-transparent mt-5 mb-5">
    <h1 class="display-4">Каталог фильмов.</h1>
  </div>

  <div class="body-content">
    <div class="row">
      <div class="col-lg-9 m-auto" style="font-size:0.8em">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">pict</th>
              <th scope="col">title</th>
              <th scope="col">description</th>
              <th scope="col">duration</th>
              <th scope="col">restrictions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($moviesList as $movie): ?>
              <tr>
                <th scope="row">
                  <p><?= Html::encode($movie->id) ?></p>
                </th>
                <td>
                  <?php
                  $uploadPath = Yii::$app->params['uploadPathUrl'];
                  $img = empty($movie->pict) ? Yii::getAlias($uploadPath . 'no.png') : Yii::getAlias($uploadPath . $movie->id . '.' . $movie->pict);
                  ?>
                  <img src="<?= Html::encode($img) ?>" class="img-fluid rounded d-block">
                </td>
                <td>
                  <p><?= Html::encode($movie->title) ?></p>
                </td>
                <td>
                  <p><?= Html::encode($movie->description) ?></p>
                </td>
                <td>
                  <p><?= Html::encode($movie->duration) ?></p>
                </td>
                <td>
                  <p><?= Html::encode($movie->restrictions) ?></p>
                </td>
                <td>
                  <?php
                  echo Html::a('Редактировать', ['movie/update-movie', 'id' => $movie->id], [
                    'class' => 'btn btn-primary btn-sm'
                  ]);

                  echo Html::a('Удалить', ['movie/delete-movie', 'id' => $movie->id], [
                    'class' => 'btn btn-danger btn-sm',
                    'data' => [
                      'confirm' => 'Удалить фильм с сеансами?',
                      'method' => 'post',
                    ],
                  ]);
                  ?>

                </td>
              </tr>

            <?php endforeach; ?>
            <table class="table table-hover">


          </tbody>
        </table>

        <?php
        //print_r($moviesList);
        ?>




      </div>
    </div>
  </div>

</div>