<?php

namespace app\models;

use yii\db\ActiveRecord;
use kartik\datetime\DateTimePicker;

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
            [['duration'], 'integer', 'max' => 1000],
            [['restrictions'], 'integer', 'max' => 100],
            ['pict', 'image', 'extensions' => 'png, jpg',
            'minWidth' => 300, 'maxWidth' => 3000,
            'minHeight' => 300, 'maxHeight' => 3000,
            ],
        ];
    }    
}


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
}