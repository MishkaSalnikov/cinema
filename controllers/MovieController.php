<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\Movie;
use app\models\MovieSession;
use yii\web\UploadedFile;
use app\models\MovieSessionsList;
use yii\web\NotFoundHttpException;
use Yii;

class MovieController extends Controller
{

    public function actionCreateMovie()
    {
        $model = new Movie();
        $movies = Movie::getMoviesList();



        // Обработка формы создания фильма
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save(false)) {
                // Обработка изображения
                $uploadedFile = UploadedFile::getInstance($model, 'pict');
                $model->saveUploadedImage($uploadedFile);

                return $this->redirect(['films']);
            }
        }

        return $this->render('create-movie', [
            'model' => $model,
            'movies' => $movies,

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





    public function actionUpdateMovie($id)
    {
        $movie = Movie::findOne($id);
        if (!$movie) {
            throw new NotFoundHttpException('Фильм не найден.');
        }

        // Если данные отправлены
        if ($movie->load(Yii::$app->request->post())) {
            // Загрузка файла
            $uploadedFile = UploadedFile::getInstance($movie, 'pict');

            if ($movie->save()) {
                // Если есть загруженный файл, сохраняем его
                if ($uploadedFile) {
                    $movie->saveUploadedImage($uploadedFile);
                }

                Yii::$app->session->setFlash('success', 'Фильм успешно обновлён.');
                return $this->redirect(['movie/films']);
            }
        }

        // Отображаем форму редактирования
        return $this->render('create-movie', [
            'model' => $movie, // Передаём существующую модель
            'movie' => $movie, // Передаём данные фильма
        ]);
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
