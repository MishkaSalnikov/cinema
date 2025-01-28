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
            [['price'], 'number', 'min' => 0, 'max' => 10000],
            [
                ['date_time'],
                'match',
                'pattern' => '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}(:\d{2})?$/',
                'message' => 'Формат времени должен быть YYYY-MM-DD HH:MM или YYYY-MM-DD HH:MM:SS'
            ],
            [
                ['date_time'],
                'validateSessionTime', // влезет ли?
            ],
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

    public function validateSessionTime($attribute, $params)
    {
        $movie = Movie::findOne($this->movie_id);
        if (!$movie) {
            $this->addError($attribute, 'Фильм не найден.');
            return;
        }

        $movieDuration = $movie->duration;

        // Рассчитываем время начала и окончания нового сеанса
        $newStartTime = strtotime($this->$attribute);
        $newEndTime = $newStartTime + ($movieDuration * 60);

        // Форматирование даты
        $formattedStart = date('Y-m-d H:i:s', $newStartTime - 30 * 60); //+30 мин в нач и кон для поиска мешающих
        $formattedEnd = date('Y-m-d H:i:s', $newEndTime + 30 * 60);

        // Проверка пересечений, исключая текущий сеанс
        $overlappingSessions = self::find()
            ->where(['movie_id' => $this->movie_id])
            ->andWhere(['not', ['id' => $this->movie_id]]) // Исключаем текущий
            ->andWhere([
                'or',
                ['and', ['<=', 'date_time', $formattedEnd], ['>=', 'date_time', $formattedStart]],
                ['and', ['<=', 'DATE_ADD(date_time, INTERVAL :duration MINUTE)', $formattedEnd], ['>=', 'DATE_ADD(date_time, INTERVAL :duration MINUTE)', $formattedStart]],
            ])
            ->addParams([':duration' => $movieDuration])
            ->exists();

        if ($overlappingSessions) {
            $this->addError($attribute, 'Сеанс пересекается с другим или не выдержан интервал в 30 минут.');
        }
    }
}
