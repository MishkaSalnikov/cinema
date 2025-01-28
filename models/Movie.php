<?php

namespace app\models;

use yii\filters\AccessControl;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use Yii;

class Movie extends ActiveRecord
{
    public static function tableName()
    {
        return 'movie'; // Таблица в БД
    }

    public function rules()
    {
        return [
            [['title', 'description', 'duration', 'restrictions'], 'required'],
            [['title'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 1000],
            [['duration'], 'integer', 'min' => 0, 'max' => 1000],
            [['restrictions'], 'integer', 'min' => 0, 'max' => 100],
            [
                'pict',
                'image',
                'extensions' => 'png, jpg',
                'minWidth' => 300,
                'maxWidth' => 3000,
                'minHeight' => 300,
                'maxHeight' => 3000,
            ],
        ];
    }




    // Удаляет фильм и связанные с ним сеансы по ID.
    public static function deleteMovieWithSessions($id)
    {
        $movie = self::findOne($id);
        if (!$movie) {
            throw new NotFoundHttpException('Фильм не найден.');
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            // Удаление связанных сеансов
            MovieSession::deleteAll(['movie_id' => $movie->id]);

            // Удаление фильма
            if (!$movie->delete()) {
                throw new ServerErrorHttpException('Не удалось удалить фильм.');
            }

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }



    public function saveUploadedImage(?UploadedFile $uploadedFile)
    {
        // Если файл отсутствует, ничего не делаем
        if (!$uploadedFile) {
            return true; // Возвращаем успех, так как это не критичная ситуация
        }

        $fileName = $this->id . '.' . $uploadedFile->getExtension();
        $uploadPath = Yii::getAlias(Yii::$app->params['uploadPath']);
        $filePath = $uploadPath . $fileName;

        // Сохраняем файл на диск
        if ($uploadedFile->saveAs($filePath)) {
            $this->pict = $uploadedFile->getExtension();
            return $this->save(false); // Сохраняем обновленные данные в БД
        }

        return false; // Если файл не удалось сохранить
    }


    public static function getMoviesList()
    {
        $movies = self::find()
            ->select(['id', 'title'])
            ->asArray()
            ->all();
        return ArrayHelper::map($movies, 'id', 'title');
    }

    public static function getMovie($id)
    {
        return self::findOne($id);
    }



    public function behaviors()
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
