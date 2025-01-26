<?php use yii\helpers\Html; ?>

<h1>Сеансы</h1>

<table class="table table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Изображение</th>
            <th>
                
            </ht>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($movieSessionsList as $session): ?>
            <tr>
                <th scope="row"><?= Html::encode($session->id) ?></th>
                <td>
                    <?php 
                        $uploadPath = Yii::$app->params['uploadPathUrl'];
                        $img = Yii::getAlias($uploadPath . $session->movie->id . '.' . $session->movie->pict);
                    ?>
                    <img src="<?= Html::encode($img) ?>" class="img-fluid rounded d-block" >
                </td>
                <td>
                    <h3>Название фильма</h3>
                    <p><?= Html::encode($session->movie->title) ?></p>
                    <h3>Описание фильма</h3>
                    <p><?= Html::encode($session->movie->description) ?></p>
                    <h3>Дата сеанса</h3>
                    <p><?= Html::encode($session->date_time) ?></p>
                    <h3>Длительность</h3>
                    <p><?= Html::encode($session->movie->duration) ?> мин.</p>
                    <h3>Ограничение по возрасту</h3>
                    <p><?= Html::encode($session->movie->restrictions) ?>+</p>
                    <h3>Цена</h3>
                    <p><?= Html::encode($session->price) ?> р.</p>
                </td>
                
                
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
