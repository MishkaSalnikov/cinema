<?php

use yii\helpers\Html; ?>

<h1>Сеансы</h1>

<table class="table table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Изображение</th>
            <th>Информация</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($movieSessionsList as $session): ?>
            <tr>
                <th scope="row"><?= Html::encode($session->id) ?></th>
                <td>
                    <?php
                    $uploadPath = Yii::$app->params['uploadPathUrl'];
                    $img = empty($session->movie->pict) ? Yii::getAlias($uploadPath . 'no.png') : Yii::getAlias($uploadPath . $session->movie->id . '.' . $session->movie->pict);
                    ?>
                    <img src="<?= Html::encode($img) ?>" class="img-fluid rounded d-block">
                </td>
                <td>
                    <h5 class="mb-0 mt-1">Название фильма</h5>
                    <p class="mx-0 my-0"><?= Html::encode($session->movie->title) ?></p>
                    <h5 class="mb-0 mt-1">Описание фильма</h5>
                    <p class="mx-0 my-0"><?= Html::encode($session->movie->description) ?></p>
                    <h5 class="mb-0 mt-1">Дата сеанса</h5>
                    <p class="mx-0 my-0"><?= Html::encode($session->date_time) ?></p>
                    <h5 class="mb-0 mt-1">Длительность</h5>
                    <p class="mx-0 my-0"><?= Html::encode($session->movie->duration) ?> мин.</p>
                    <h5 class="mb-0 mt-1">Ограничение по возрасту</h5>
                    <p class="mx-0 my-0"><?= Html::encode($session->movie->restrictions) ?>+</p>
                    <h5 class="mb-0 mt-1">Цена</h5>
                    <p class="mx-0 my-0"><?= Html::encode($session->price) ?> р.</p>

                    <?php if (!Yii::$app->user->isGuest): ?>
                        <div class="mt-3">
                            <?= Html::a('Редактировать сеанс', ['movie-session/update-session', 'id' => $session->id], ['class' => 'btn btn-primary btn-sm']) ?>
                            <?= Html::a('Удалить', ['movie-session/delete-session', 'id' => $session->id], [
                                'class' => 'btn btn-danger btn-sm',
                                'data' => [
                                    'confirm' => 'Точно?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </div>
                    <?php endif; ?>
                </td>


            </tr>
        <?php endforeach; ?>
    </tbody>
</table>