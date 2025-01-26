<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\Movie;
use app\models\MovieSession;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use Yii;

class MovieController extends Controller
{

    public function actionCreate()
    {
        $model = new Movie();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) { // если пришел POST
            
            if ($model->save(false)) {
                $uploadedFile = UploadedFile::getInstance($model, 'pict');
                if ($uploadedFile) {
                    $fileName = $model->id . '.' . $uploadedFile->getExtension(); // получаем ID внесенного фильма для имени файла
                    $uploadPath = Yii::getAlias(Yii::$app->params['uploadPath']); 
                    $filePath = $uploadPath . $fileName;

                    if ($uploadedFile->saveAs($filePath)) { // сохраняем картинку
                        $model->pict = $uploadedFile->getExtension(); // пихаем расширение в БД
                        $model->save(false); //без проверки т.к. в модели проверка
                    }
                }
                return $this->redirect(['index']); // редирект на movie/index
            }
        }

        $movies = Movie::find()
            ->select(['id', 'title'])
            ->asArray()
            ->all();
        $moviesList = ArrayHelper::map($movies, 'id', 'title');
        
        
        
        
        $movieSession = new MovieSession();
        
        if ($movieSession->load(Yii::$app->request->post()) && $movieSession->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'movieSession' => $movieSession,
            'movies' => $movies, 
            'model' => $model,
            'moviesList' => $moviesList,
        ]);
    }

    public function actionIndex()
    {
        return $this->render('index');
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
