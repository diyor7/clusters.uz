<?php

namespace frontend\models;

use common\models\Bank;
use common\models\Company;
use common\models\CompanyBankAccount;
use common\models\User;
use common\rbac\helpers\RbacHelper;
use yii\base\Model;
use Yii;

/**
 * Model representing  Signup Form.
 */
class SignupCompanyForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $confirm_password;
    public $status;
    public $type;

    public $full_name;

    public $description;
    public $phone;
    public $address;
    public $user_id;

    public $file;

    public $agreement;

    // company fields

    public $company_tin;
    public $company_name;
    public $company_type;
    public $company_region_id;
    public $company_bank_mfo;
    public $company_bank_account;
    public $company_site;
    public $company_email;
    public $company_phone;
    public $company_employees;
    public $company_address;

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
            // [
            //     'email', 'unique', 'targetClass' => '\common\models\User',
            //     'message' => t('Этот адрес электронной почты уже занят.')
            // ],

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
            ['type', 'in', 'range' => [User::TYPE_CUSTOMER, User::TYPE_PRODUCER, User::TYPE_BOTH]],

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
            ],

            [['company_tin', 'company_name', 'company_type', 'company_region_id', 'company_bank_mfo', 'company_bank_account', 'company_address'], 'required'],
            [
                'company_tin', 'unique', 'targetClass' => '\common\models\Company', 'targetAttribute' => 'tin',
                'message' => t('Этот инн уже занят.')
            ],
            [['company_tin', 'company_name', 'company_type', 'company_region_id', 'company_bank_mfo', 'company_bank_account', 'company_address'], 'string'],
            [['company_tin',  'company_region_id', 'company_type', 'company_employees', 'type'], 'integer'],
            [['company_name', 'company_site', 'company_phone'], 'string', 'max' => 255],
            [['company_email'], 'email'],
            [['company_bank_mfo'], 'string', 'max' => 10],
            [['company_bank_mfo'], 'exist', 'skipOnError' => true, 'targetClass' => Bank::className(), 'targetAttribute' => ['company_bank_mfo' => 'mfo']],
            [['company_bank_account'], 'string', 'max' => 50],
            ['company_type', 'in', 'range' => [Company::TYPE_BUDGET, Company::TYPE_COPERATE, Company::TYPE_PHYSICAL, Company::TYPE_PRIVATE]],
            [['company_phone'], 'match', 'pattern' => '/^\+998[0-9]{9}$/', 'message' => getTranslate('Неверный формат номера телефона')],

            [['company_bank_account'], 'match', 'pattern' => '/^[0-9]{20}$/', 'message' => getTranslate('Неверный формат р/с')],
            [['company_bank_mfo'], 'match', 'pattern' => '/^[0-9]{5}$/', 'message' => getTranslate('Неверный формат МФО')],
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
            'username' => t('Номер телефона'),
            'password' => t('Пароль'),
            'confirm_password' => t('Повторите пароль'),
            'email' => t('Электронная почта'),
            'full_name' => t('Ф.И.О.'),
            'agreement' => t('Я ознакомлен(а) с <a href="{link}" target="_blink">условиями публичной оферты</a> и согласен(а) на обработку персональных данных', ['link' => toRoute('/offerta')]),
            'company_tin' => t('ИНН организации'),
            'company_name' => t('Название организации'),
            'company_type' => t('Тип организации'),
            'type' => t('Тип пользователя'),
            'company_region_id' => t('Регион организации'),
            'company_bank_mfo' => t('МФО'),
            'company_bank_account' => t('Расчётный счёт'),
            'company_site' => t('Сайт организации'),
            'company_email' => t('Электронная почта организации'),
            'company_phone' => t('Номер телефона организации'),
            'company_employees' => t('Количество сотрудников'),
            'company_address' => t('Юридический адрес'),
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
        $user->type = $this->type;

        // if scenario is "rna" we will generate account activation token
        if ($this->scenario === 'rna') {
            $user->generateAccountActivationToken();
        }

        if ($user->save()) {
            $user_profile = new \common\models\UserProfile();
            $user_profile->user_id = $user->id;
            $user_profile->full_name = $this->full_name;
            
            if ($user_profile->save()) {
                $company = new \common\models\Company();
                $company->tin = $this->company_tin;
                $company->name = $this->company_name;
                $company->type = $this->company_type;
                $company->region_id = $this->company_region_id;
                // $company->bank_mfo;
                // $company->bank_account;
                $company->site = $this->company_site;
                $company->email = $this->company_email;
                $company->phone = $this->company_phone;
                $company->employees = $this->company_employees;
                $company->address = $this->company_address;

                if ($company->save()) {
                    $user->company_id = $company->id;
                    $user->save(false);
                    
                    $company_bank_account = new CompanyBankAccount([
                        'account' => $this->company_bank_account,
                        'mfo' => $this->company_bank_mfo,
                        'is_main' => 1,
                        'created_at' => date("Y-m-d H:i:s"),
                        'company_id' => $company->id
                    ]);

                    if ($company_bank_account->save()) {
                        return RbacHelper::assignRole($user->getId()) ? $user : null;
                    } else {
                        $user->delete();
                        $user_profile->delete();
                        $company->delete();
                    }
                } else {
                    $user->delete();
                    $user_profile->delete();
                }
            } else {
                $user->delete();
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
