<?php

namespace frontend\models;

use common\models\User;
use common\models\UserProfile;
use common\rbac\helpers\RbacHelper;
use nenad\passwordStrength\StrengthValidator;
use yii\base\Model;
use Yii;
use yii\web\UploadedFile;

/**
 * Model representing  Signup Form.
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $confirm_password;
    public $status;

    public $full_name;

    public $description;
    public $phone;
    public $address;
    public $user_id;

    public $file;

    public $agreement;

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
            // ['email', 'required'],
            [
                'username', 'unique', 'targetClass' => '\common\models\User',
                'message' => t('Этот телефон уже занят.')
            ],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            // ['email', 'unique', 'targetClass' => '\common\models\User',
            //     'message' => t('Этот адрес электронной почты уже занят.')],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['confirm_password', 'required'],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => t("Пароли не совподают")],

            [['agreement'], 'required', 'message' => t("Нужно согласиться с офертой.")],
            ['agreement', function ($attribute, $params, $validator) {
                if (!in_array($this->$attribute, [1, true])) {
                    $this->addError($attribute, t("Нужно согласиться с офертой."));
                }
            }],

            // on default scenario, user status is set to active
            ['status', 'default', 'value' => User::STATUS_ACTIVE, 'on' => 'default'],
            // status is set to not active on rna (registration needs activation) scenario
            ['status', 'default', 'value' => User::STATUS_NOT_ACTIVE, 'on' => 'rna'],
            // status has to be integer value in the given range. Check User model.
            ['status', 'in', 'range' => [User::STATUS_NOT_ACTIVE, User::STATUS_ACTIVE]],

            [['full_name'], 'filter', 'filter' => 'trim'],
            [['phone'], 'filter', 'filter' => 'trim'],
            [['full_name'], 'required'],
            ['full_name', 'string', 'min' => 3, 'max' => 255],
            [['username'], 'match', 'pattern' => '/^\+998[0-9]{9}$/', 'message' => '{attribute} ' . getTranslate('Неверный формат номера телефона')],
            ['description', 'string'],
            ['address', 'string'],

            [
                ['file'], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,gif,jpeg',
                'maxSize' => 1024 * 1025 * 1,
                'tooBig' => 'File size is to big. Max file size must be 2 mb'
            ]
        ];
    }

    /**
     * Set password rule based on our setting value (Force Strong Password).
     *
     * @return array Password strength rule
     */
    private function passwordStrengthRule()
    {
        // get setting value for 'Force Strong Password'
        $fsp = Yii::$app->params['fsp'];

        // password strength rule is determined by StrengthValidator
        // presets are located in: vendor/nenad/yii2-password-strength/presets.php
        $strong = [['password'], StrengthValidator::className(), 'preset' => 'normal'];

        // use normal yii rule
        $normal = ['password', 'string', 'min' => 6];

        // if 'Force Strong Password' is set to 'true' use $strong rule, else use $normal rule
        return ($fsp) ? $strong : $normal;
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
            'password' => t('Пароль'),
            'confirm_password' => t('Повторите пароль'),
            'email' => t('Почта'),
            'full_name' => t('Ф.И.О.'),
            'agreement' => t('Я ознакомлен(а) с <a href="{link}" target="_blink">условиями публичной оферты</a> и согласен(а) на обработку персональных данных', ['link' => toRoute('/offerta')]),
            'person' => t("Лицо")
        ];
    }

    /**
     * Signs up the user.
     * If scenario is set to "rna" (registration needs activation), this means
     * that user need to activate his account using email confirmation method.
     *
     * @return User|null The saved model or null if saving fails.
     */
    public function signup()
    {
        $user = new User();

        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;
        $user->is_crafter = 0;

        // if scenario is "rna" we will generate account activation token
        if ($this->scenario === 'rna') {
            $user->generateAccountActivationToken();
        }

        if ($user->save()) {
            $user_profile = new \common\models\UserProfile();
            $user_profile->user_id = $user->id;
            $user_profile->full_name = $this->full_name;

            if ($user_profile->save()) {
                return RbacHelper::assignRole($user->getId()) ? $user : null;
            }
            // if user is saved and role is assigned return user object
            return null;
        }

        return null;
    }

    /**
     * Sends email to registered user with account activation link.
     *
     * @param  object $user Registered user.
     * @return bool         Whether the message has been sent successfully.
     */
    public function sendAccountActivationEmail($user)
    {
        return Yii::$app->mailer->compose('accountActivationToken', ['user' => $user])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account activation for ' . Yii::$app->name)
            ->send();
    }
}
