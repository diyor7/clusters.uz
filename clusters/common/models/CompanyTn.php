<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company_tn".
 *
 * @property int $id
 * @property int $company_id
 * @property int $tn_id
 * @property string|null $certificate
 * @property int|null $status
 * @property string|null $message
 * @property string|null $created_at
 *
 * @property Company $company
 * @property Tn $tn
 */
class CompanyTn extends \yii\db\ActiveRecord
{
    const STATUS_MODERATING = 1;
    const STATUS_ACCEPTED = 2;
    const STATUS_REJECTED = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company_tn';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'tn_id'], 'required'],
            [['company_id', 'tn_id', 'status'], 'integer'],
            [['certificate', 'message'], 'string', 'max' => 255],
            ['created_at', 'safe'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['tn_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tn::className(), 'targetAttribute' => ['tn_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => t("Компания"),
            'tn_id' => t("ТН ВЭД"),
            'certificate' => t("Сертификат"),
            'status' => 'Status',
            'message' => 'Message',
        ];
    }

    /**
     * Gets query for [[Company]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * Gets query for [[Tn]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTn()
    {
        return $this->hasOne(Tn::className(), ['id' => 'tn_id']);
    }

    public function beforeSave($insert)
    {
        if (!$this->created_at) {
            $this->created_at = date("Y-m-d H:i:s");
        }
        
        return parent::beforeSave($insert);
    }
}
