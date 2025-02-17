<?php
namespace common\models;

use yii\base\Model;
use Yii;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    public $isOrdering = false;

    /**
     * @var \common\models\User
     */
    private $_user = false;

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['username', 'string'],
            // [['username'], 'match', 'pattern' => '/^\+998[0-9]{9}$/', 'message' => getTranslate('Неверный формат номера телефона')],
            ['password', 'validatePassword'],
            ['rememberMe', 'boolean'],
            // username and password are required on default scenario
            [['username', 'password'], 'required', 'on' => 'default'],
            // email and password are required on 'lwe' (login with email) scenario
            [['password'], 'required', 'on' => 'lwe'],
            ['isOrdering', 'boolean']
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute The attribute currently being validated.
     * @param array  $params    The additional name-value pairs.
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) 
        {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) 
            {
                // if scenario is 'lwe' we use email, otherwise we use username
                $field = ($this->scenario === 'lwe') ? 'email' : 'username' ;

                $this->addError($attribute, t('Incorrect '.$field.' or password.'));
            }
        }
    }

    /**
     * Returns the attribute labels.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username' => t("Телефон"),
            'password' => t("Пароль"),
            'email' => t("Почта"),
            'rememberMe' => t("Запомнить меня"),
        ];
    }

    /**
     * Logs in a user using the provided username|email and password.
     *
     * @return bool Whether the user is logged in successfully.
     */
    public function login()
    {
        if ($this->validate()) 
        {
            $session_id = Yii::$app->session->id;
            $card = Cart::find()->where(['sess_id' => $session_id])->all();
            if($card && count($card) > 0){
                $user = $this->getUser();
                foreach($card as $cd){
                    $cd->user_id = $user->id;
                    $cd->save();
                }
            }
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        else 
        {
            return false;
        }
    }

    /**
     * Finds user by username or email in 'lwe' scenario.
     *
     * @return User|null|static
     */
    public function getUser()
    {
        if ($this->_user === false) 
        {
            // in 'lwe' scenario we find user by email, otherwise by username
//            if ($this->scenario === 'lwe')
//            {
//                $this->_user = User::findByEmail($this->email);
//            }
//            else
//            {
//                $this->_user = User::findByUsername($this->username);
//            }
            $this->_user = User::find()->andWhere(['username' => $this->username])->one();
        }

        return $this->_user;
    }

    /**
     * Checks to see if the given user has NOT activated his account yet.
     * We first check if user exists in our system,
     * and then did he activated his account.
     *
     * @return bool True if not activated.
     */
    public function notActivated()
    {
        // if scenario is 'lwe' we will use email as our username, otherwise we use username
        $username = ($this->scenario === 'lwe') ? $this->email : $this->username;

        if ($user = User::userExists($username, $this->password, $this->scenario))
        {
            if ($user->status === User::STATUS_NOT_ACTIVE)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }  
}
