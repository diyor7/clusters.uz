<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property integer $id
 * @property integer $tin
 * @property string $name_uz
 * @property string $name_ru
 * @property string $name_en
 * @property string $name
 * @property integer $region_id
 * @property integer $type
 * @property string $email
 * @property string $site
 * @property integer $employees
 * @property string $phone
 * @property string $address
 * @property string $created_at
 * @property string $updated_at
 * 
 * @property Region $region
 */
class Company extends \yii\db\ActiveRecord
{
    const TYPE_BUDGET = 1;
    const TYPE_COPERATE = 2;
    const TYPE_PRIVATE = 3;
    const TYPE_PHYSICAL = 4;

    public static function getTypes()
    {
        return [
//            self::TYPE_BUDGET => t("Бюджетная организация"),
            self::TYPE_COPERATE => t("Корпоративная организация"),
            self::TYPE_PRIVATE => t("Частная организация"),
            // self::TYPE_PHYSICAL => t("Физическое лицо"),
        ];
    }
    public function getTypeName()
    {
        return array_key_exists($this->type, self::getTypes()) ? self::getTypes()[$this->type] : null;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tin',  'type',  'name', 'region_id', 'address'], 'required'],
            [['tin',  'region_id', 'type', 'employees'], 'integer'],
            [['name', 'site', 'phone'], 'string', 'max' => 255],
            ['address', 'string'],
            [['tin'], 'unique'],
            [['email'], 'email'],
            [['created_at', 'updated_at'], 'safe'],
            [['phone'], 'match', 'pattern' => '/^\+998[0-9]{9}$/', 'message' => getTranslate('Неверный формат номера телефона')],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tin' => t("ИНН"),
            'name' => t("Наименование"),
            'region_id' => t("Регион"),
            'address' => t("Юридический адрес"),
            'type' => t("Тип компании"),
            'email' => t("Электронная почта"),
            'site' => t("Вебсайт"),
            'employees' => t('Количество сотрудников'),
            'phone' => t('Телефон'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['company_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyBalance()
    {
        return $this->hasOne(CompanyBalance::className(), ['company_id' => 'id']);
    }

    public function getBalance(){
        return $this->companyBalance ? $this->companyBalance->balance : 0;
    }

    public function getAvailable(){
        return $this->companyBalance ? $this->companyBalance->available : 0;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyBankAccount()
    {
        return $this->hasOne(CompanyBankAccount::className(), ['company_id' => 'id']);
    }

    public function getLink()
    {
        return strtolower(rus2translit($this->name)) . "--" . $this->id;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['company_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if (!$this->created_at) {
            $this->created_at = date("Y-m-d H:i:s");
        }

        if (!$this->isNewRecord) {
            $this->updated_at = date("Y-m-d H:i:s");
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $company_balance = CompanyBalance::findOne($this->id);

        if (!$company_balance) {
            $company_balance = new CompanyBalance([
                'company_id' => $this->id
            ]);

            $company_balance->save();
        }

        return parent::afterSave($insert, $changedAttributes);
    }
}
