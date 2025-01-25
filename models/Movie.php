<?php

namespace app\models;

use yii\db\ActiveRecord;

class Movie extends ActiveRecord
{
    /**
     * Указываем имя таблицы в базе данных.
     */
    public static function tableName()
    {
        return 'movie'; // Таблица в БД
    }

    /**
     * Правила валидации для модели.
     */
    /*public function rules()
    {
        return [
            [['title', 'genre', 'release_date'], 'required'], // Поля обязательны для заполнения
            [['title', 'genre'], 'string', 'max' => 255],    // Строки, максимум 255 символов
            [['release_date'], 'date', 'format' => 'php:Y-m-d'], // Дата в формате Y-m-d
        ];
    }*/
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
