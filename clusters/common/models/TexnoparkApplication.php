<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "texnopark_application".
 *
 * @property integer $id
 * @property string company_name,
 * @property string investment_order,
 * @property string owner_identity_doc,
 * @property string company_name,
 * @property string certificate,
 * @property string company_charter,
 * @property string business_plan,
 * @property string balance_sheet,
 * @property string investment_guarantee_letter,
 * @property string created_date
 */



class TexnoparkApplication extends \yii\db\ActiveRecord
{
    public $investment_order_file;
    public $owner_identity_doc_file;
    public $certificate_file;
    public $company_charter_file;
    public $business_plan_file;
    public $balance_sheet_file;
    public $investment_guarantee_letter_file;
    public $sort;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'texnopark_application';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_name', 'investment_order', 'owner_identity_doc', 'certificate', 'company_charter', 'business_plan', 'balance_sheet', 'investment_guarantee_letter'], 'string', 'max' => 255],
            [['created_date', 'sort'], 'safe'],
            [['investment_order_file', 'owner_identity_doc_file', 'certificate_file', 'company_charter_file', 'business_plan_file', 'balance_sheet_file', 'investment_guarantee_letter_file'], 'file', 'extensions' => ['pdf'], 'maxSize' => 1024 * 1024 * 4]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'investment_order' => t("Инвестиционное заявление*"),
            'owner_identity_doc' => t("Удостоверение личности директора"),
            'company_name' => t("Название компании"),
            'certificate' => t("Сертификат"),
            'company_charter' => t("Устав компании"),
            'business_plan' => t("ТЭО или Бизнес план"),
            'balance_sheet' => t("Финансовые резултаты за 2022"),
            'investment_guarantee_letter' => t("Гарантийное письмо инвестиции"),
            'created_date' => t("created_date"),
        ];
    }

    public function beforeSave($insert)
    {

        $this->created_date = date("Y-m-d H:i:s");

        return parent::beforeSave($insert);
    }
    
}
