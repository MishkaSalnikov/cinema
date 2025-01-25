<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\Movie;
use yii\web\UploadedFile;
use Yii;

class MovieController extends Controller
{

public function actionCreate()
{
    $model = new Movie();


    if ($model->load(Yii::$app->request->post()) && $model->validate()) { //если пришел пост
        
        if ($model->save(false)) {            
            $uploadedFile = UploadedFile::getInstance($model, 'pict');
            if ($uploadedFile) {                
                $fileName = $model->id . '.' . $uploadedFile->getExtension(); //получаем айди внесенного фильма для файла
                $uploadPath = Yii::getAlias(Yii::$app->params['uploadPath']); 
                $filePath = $uploadPath . $fileName; //путь к картинке
                
                if ($uploadedFile->saveAs($filePath)) { //сохраняем картинку                    
                    $model->pict = $uploadedFile->getExtension(); //пихаем расширение в бд
                    $model->save(false); // Сохраняем без проверки
                }
            }
            return $this->redirect(['index']);//редирект на movie/index
        }
    }

    return $this->render('create', [
        'model' => $model,
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



