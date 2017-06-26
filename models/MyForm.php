<?php

namespace app\models;

use yii\base\ErrorException;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;

/**
 * Модель для формы добавления водителя
 */
class MyForm extends ActiveRecord
{

    // поле для captcha
    public $verifyCode;

    /**
     * @return string - название таблицы в бд
     */
    public static function tableName()
    {
        return 'table';
    }

    /**
     * @return array - правила валидации данных в форме
     */
    public function rules()
    {
        return [
            // Все поля в форме обязательны для заполнения
            [['firstName', 'lastName', 'phoneNumber', 'birthday', 'text'], 'required'],

            // Год рождения должен быть в формате date
            ['birthday', 'date','format'=>'php:Y-m-d'],

            // Для верификации captcha
            ['verifyCode', 'captcha'],
        ];
    }

    /**{
     * @return array - задает специальные парраметры именования элементов в форме
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Подтвердите, что вы не робот',
            'firstName' => 'Имя:',
            'lastName' => 'Фамилия:',
            'phoneNumber' => 'Номер телефона:',
            'birthday' => 'Дата рождения:',
            'text' => 'Сообщение пользователя',
        ];
    }

}
