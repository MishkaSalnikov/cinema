<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;



class MovieSession extends ActiveRecord
{
    public static function tableName()
    {
        return 'movie_session'; // Таблица в БД
    }

    public function rules()
    {
        return [
            [['movie_id', 'date_time', 'price'], 'required'],
            [['movie_id'], 'integer'],
            [['date_time'], 'string', 'max' => 1000],
            [['price'], 'integer', 'max' => 1000],
        ];
    }

    public static function deleteById($id)
    {
        $movieSession = self::findOne($id);
        if (!$movieSession) {
            throw new NotFoundHttpException('Сеанс не найден.');
        }

        if (!$movieSession->delete()) {
            throw new \Exception('Ошибка при удалении сеанса.');
        }
    }
}
