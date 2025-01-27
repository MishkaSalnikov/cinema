<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\Movie;
use app\models\MovieSession;
use yii\web\UploadedFile;
use app\models\MovieSessionsList;
use Yii;

class MovieController extends Controller
{

    public function actionCreate()
    {
        $model = new Movie();
        $movieSession = new MovieSession();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) { //картинка + добавление фильма
            if ($model->save(false)) {
                $uploadedFile = UploadedFile::getInstance($model, 'pict');
                $model->saveUploadedImage($uploadedFile);
                return $this->redirect(['films']);
            }
        }

        if ($movieSession->load(Yii::$app->request->post()) && $movieSession->save()) { //сохр в бд сеанса и редирект
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'movieSession' => $movieSession,
            'movies' => Movie::getMoviesList(),
            'model' => $model,
        ]);
    }

    public function actionIndex()
    {
        // movie_session + movie
        return $this->render('index', [
            'movieSessionsList' => MovieSessionsList::getSessionsWithMovies(),
        ]);
    }

    public function actionFilms()
    {
        return $this->render('films', [
            'moviesList' => Movie::find()->indexBy('id')->all(),
        ]);
    }

    public function actionDeleteMovie($id)
    {
        try {
            Movie::deleteMovieWithSessions($id);
            Yii::$app->session->setFlash('success', 'Фильм и связанные сеансы успешно удалены.');
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['movie/films']);
    }

    public function behaviors() // Запрет гостям
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }
}
