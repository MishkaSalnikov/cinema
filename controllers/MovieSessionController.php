<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\Movie;
use app\models\MovieSession;
use yii\web\NotFoundHttpException;

use Yii;

class MovieSessionController extends Controller
{

    public function actionCreateSession()
    {
        $movies = Movie::getMoviesList();
        $movieSession = new MovieSession();

        // Если данные отправлены
        if ($movieSession->load(Yii::$app->request->post())) {

            // Проверяем 
            if ($movieSession->validate()) {
                if ($movieSession->save(false)) {
                    Yii::$app->session->setFlash('success', 'Сеанс успешно добавлен.');
                    return $this->redirect(['movie/index']);
                }
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка валидации. Проверьте введенные данные.');
            }
        }

        return $this->render('create-session', [
            'movieSession' => $movieSession,
            'movies' => $movies,
        ]);
    }


    public function actionUpdateSession($id)
    {
        $movieSession = MovieSession::findOne($id);
        if (!$movieSession) {
            throw new NotFoundHttpException('Сеанс не найден.');
        }
        $model = new Movie();

        // Если данные отправлены
        if ($movieSession->load(Yii::$app->request->post()) && $movieSession->save()) {
            Yii::$app->session->setFlash('success', 'Сеанс успешно обновлён.');
            return $this->redirect(['movie/index']);
        }

        // Отображаем форму редактирования
        return $this->render('create-session', [
            'movieSession' => $movieSession,
            'model' => $model,
            'movies' => Movie::getMoviesList(),
        ]);
    }

    public function actionDeleteSession($id)
    {
        try {
            MovieSession::deleteById($id);
            Yii::$app->session->setFlash('success', 'Сеанс успешно удалён.');
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['movie/index']);
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
