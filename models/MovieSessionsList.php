<?php

namespace app\models;

use yii\db\ActiveRecord;

class MovieSessionsList extends ActiveRecord
{
    public static function tableName()
    {
        return 'movie_session';
    }

    public function getMovie()
    {
        return $this->hasOne(Movie::class, ['id' => 'movie_id']);
    }



    public static function getSessionsWithMovies()
    {
        return self::find()
            ->with('movie')
            ->orderBy(['date_time' => SORT_ASC])
            ->all();
    }
}
