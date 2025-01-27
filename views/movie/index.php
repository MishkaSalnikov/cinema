<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Список сеансов.</h1>
    </div>

    <div class="body-content">        
        <div class="row">
            <div class="col-lg-9 m-auto" style="font-size:0.8em">

                <?= $this->render('@app/views/site/movie-sessions-list', ['movieSessionsList' => $movieSessionsList]) ?>

            </div>
        </div>
    </div>
    
</div>
