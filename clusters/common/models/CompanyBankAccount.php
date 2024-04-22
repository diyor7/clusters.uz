<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company_bank_account".
 *
 * @property integer $id
 * @property integer $company_id
 * @property integer $account
 * @property integer $is_main
 * @property string $mfo
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Company $company
 * @property Bank $mfo0
 */
class CompanyBankAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_bank_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account', 'is_main', 'mfo'], 'required'],
            [['company_id', 'is_main'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['mfo'], 'string', 'max' => 10],
            [['account'], 'string', 'max' => 50],
            [['account'], 'match', 'pattern' => '/^[0-9]{20}$/', 'message' => getTranslate('Неверный формат р/с')],
            [['mfo'], 'match', 'pattern' => '/^[0-9]{5}$/', 'message' => getTranslate('Неверный формат МФО')],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['mfo'], 'exist', 'skipOnError' => true, 'targetClass' => Bank::className(), 'targetAttribute' => ['mfo' => 'mfo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => t("Поставщик"),
            'account' => t("Расчетный счёт"),
            'is_main' => t("Основной"),
            'mfo' => t("МФО"),
            'created_at' => t("Дата добавления"),
            'updated_at' => t("Дата обновления"),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBank()
    {
        return $this->hasOne(Bank::className(), ['mfo' => 'mfo']);
    }
}
