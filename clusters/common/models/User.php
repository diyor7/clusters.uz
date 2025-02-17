<?php

namespace common\models;

use common\rbac\models\Role;
use yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the user model class extending UserIdentity.
 * Here you can implement your custom user solutions.
 *
 * @property $role Role
 */
class User extends UserIdentity
{
    const STATUS_DELETED = 0;
    const STATUS_NOT_ACTIVE = 1;
    const STATUS_ACTIVE = 10;

    public $password;
    public $confirm_password;
    public $company_name;

    const TYPE_CUSTOMER = 1;
    const TYPE_PRODUCER = 2;
    const TYPE_BOTH = 3;
    const TYPE_COMMISSION = 4;

    public static function getTypes() {
        return [
            self::TYPE_CUSTOMER => t("Покупатель"),
            self::TYPE_PRODUCER => t("Поставщик"),
            self::TYPE_BOTH => t("Покупатель / Поставщик"),
        ];
    }

    /**
     * @var \common\rbac\models\Role
     */
    public $item_name;

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'filter', 'filter' => 'trim'],
            [['username', /*'email',*/  'status'], 'required'],
            ['email', 'email'],
            [['company_id', 'is_crafter', 'type'],  'integer'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['image', 'string', 'max' => 255],

            // password field is required on 'create' scenario
            ['password', 'required', 'on' => 'create'],
            // use passwordStrengthRule() method to determine password strength
            ['password', 'string', 'min' => 6],

            ['username', 'unique', 'message' => 'This username has already been taken.'],
            // ['email', 'unique', 'message' => 'This email address has already been taken.'],
        ];
    }

    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
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
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'item_name' => Yii::t('app', 'Role'),
            'image' => Yii::t('app', 'Image'),
        ];
    }

    /**
     * Relation with Role model.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        // User has_one Role via Role.user_id -> id
        return $this->hasOne(Role::className(), ['user_id' => 'id']);
    }

    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    public function getCompanyType (){
        return $this->company ? $this->company->type : Company::TYPE_PHYSICAL;
    }

    public function getTypeName (){
        return array_key_exists($this->type, self::getTypes()) ? self::getTypes()[$this->type] : null;
    }

    //------------------------------------------------------------------------------------------------//
    // USER FINDERS
    //------------------------------------------------------------------------------------------------//

    /**
     * Finds user by username.
     *
     * @param  string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => User::STATUS_ACTIVE]);
    }

    /**
     * Finds user by email.
     *
     * @param  string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => User::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token.
     *
     * @param  string $token Password reset token.
     * @return null|static
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => User::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by account activation token.
     *
     * @param  string $token Account activation token.
     * @return static|null
     */
    public static function findByAccountActivationToken($token)
    {
        return static::findOne([
            'account_activation_token' => $token,
            'status' => User::STATUS_NOT_ACTIVE,
        ]);
    }

    /**
     * Checks to see if the given user exists in our database.
     * If LoginForm scenario is set to lwe (login with email), we need to check
     * user's email and password combo, otherwise we check username/password.
     * NOTE: used in LoginForm model.
     *
     * @param  string $username Can be either username or email based on scenario.
     * @param  string $password
     * @param  string $scenario
     * @return bool|static
     */
    public static function userExists($username, $password, $scenario)
    {
        // if scenario is 'lwe', we need to check email, otherwise we check username
        $field = ($scenario === 'lwe') ? 'email' : 'username';

        if ($user = static::findOne([$field => $username])) {
            if ($user->validatePassword($password)) {
                return $user;
            } else {
                return false; // invalid password
            }
        } else {
            return false; // invalid username|email
        }
    }

    //------------------------------------------------------------------------------------------------//
    // HELPERS
    //------------------------------------------------------------------------------------------------//

    /**
     * Returns the user status in nice format.
     *
     * @param  null|integer $status Status integer value if sent to method.
     * @return string               Nicely formatted status.
     */
    public function getStatusName($status = null)
    {
        $status = (empty($status)) ? $this->status : $status;

        if ($status === self::STATUS_DELETED) {
            return "Deleted";
        } elseif ($status === self::STATUS_NOT_ACTIVE) {
            return "Inactive";
        } else {
            return "Active";
        }
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getStatusList()
    {
        $statusArray = [
            self::STATUS_ACTIVE     => 'Active',
            self::STATUS_NOT_ACTIVE => 'Inactive',
            self::STATUS_DELETED    => 'Deleted'
        ];

        return $statusArray;
    }

    /**
     * Returns the role name ( item_name )
     *
     * @return string
     */
    public function getRoleName()
    {
        return $this->role ? $this->role->item_name : "";
    }

    /**
     * Generates new password reset token.
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token.
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Finds out if password reset token is valid.
     * 
     * @param  string $token Password reset token.
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * Generates new account activation token.
     */
    public function generateAccountActivationToken()
    {
        $this->account_activation_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes account activation token.
     */
    public function removeAccountActivationToken()
    {
        $this->account_activation_token = null;
    }

    public function getUser_profile()
    {
        return $this->hasOne(\common\models\UserProfile::className(), ['user_id' => 'id']);
    }

    public function getProfile()
    {
        return $this->hasOne(\common\models\UserProfile::className(), ['user_id' => 'id']);
    }

    public function getFull_name()
    {
        return $this->user_profile ? $this->user_profile->full_name : null;
    }

    public function getName()
    {
        return $this->company ? $this->company->name : null;
    }

    public function getAddress()
    {
        return $this->user_profile ? $this->user_profile->address : null;
    }

    public function getDescription()
    {
        return $this->user_profile ? $this->user_profile->description : null;
    }

    public function getPath()
    {
        return $this->image ? siteUrl() . 'uploads/user/' . $this->image : null;
    }

    public function getAvailableBalance (){
        return $this->company && $this->company->companyBalance ? $this->company->companyBalance->available : 0;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites()
    {
        return $this->hasMany(Favorite::className(), ['company_id' => 'id']);
    }

    public function afterDelete()
    {
        if ($this->image) {
            if (file_exists(\Yii::getAlias('@uploads') . '/user/' . $this->image))
                unlink(\Yii::getAlias('@uploads') . '/user/' . $this->image); // удаляем сам файл
        }

        return parent::beforeDelete();
    }

    public function getIsFavorite()
    {
        return !!Favorite::findOne(['user_id' => Yii::$app->user->id, 'company_id' => $this->id]);
    }
}
