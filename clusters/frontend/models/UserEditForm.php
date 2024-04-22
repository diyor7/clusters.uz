<?php

namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Model representing  Signup Form.
 */
class UserEditForm extends Model
{
    public $username;
    public $email;
    public $full_name;
    public $address;

    public $password;
    public $confirm_password;
    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['email', 'required'],
            [
                'username', 'unique', 'targetClass' => '\common\models\User',
                'filter' => ['!=', 'id', Yii::$app->user->id],
                'message' => t('Этот телефон уже занят.')
            ],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            [
                'email', 'unique', 'targetClass' => '\common\models\User',
                'filter' => ['!=', 'id', Yii::$app->user->id],
                'message' => t('Этот адрес электронной почты уже занят.')
            ],

            [['full_name'], 'filter', 'filter' => 'trim'],
            [['full_name'], 'required'],
            ['full_name', 'string', 'min' => 3, 'max' => 255],
            [['username'], 'match', 'pattern' => '/^\+998[0-9]{9}$/', 'message' => '{attribute} ' . getTranslate('Неверный формат номера телефона')],
            ['address', 'string'],

            ['password', 'string', 'min' => 6],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => t("Пароли не совподают")],

        ];
    }

    /**
     * Returns the attribute labels.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username' => t('Телефон'),
            'email' => t('Почта'),
            'address' => t('Адрес'),
            'full_name' => t('Ф.И.О.'),
            'password' => t('Новый пароль'),
            'confirm_password' => t('Повторите новый пароль'),
        ];
    }

    public function save(){
        $user = User::findOne(Yii::$app->user->id);

        $user->username = $this->username;
        $user->email = $this->email;
        
        if ($this->password) {
            $user->setPassword($this->password);
        }

        $user->profile->address = $this->address;
        $user->profile->full_name = $this->full_name;

        return $user->save() && $user->profile->save();
    }
}
