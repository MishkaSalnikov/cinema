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


}
