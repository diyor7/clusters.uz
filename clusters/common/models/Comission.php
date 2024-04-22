<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comission".
 *
 * @property int $id
 * @property int $tin
 * @property int $pinfl
 * @property string $fullname
 * @property string|null $email
 * @property string $phone
 * @property string $birthday
 * @property int $passport_number
 * @property string $passport_seria
 * @property string $position
 * @property string $company_name
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int $user_id
 *
 * @property TenderCommission[] $tenderCommissions
 */
class Comission extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comission';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tin', 'pinfl', 'fullname', 'phone', 'birthday', 'passport_number', 'passport_seria', 'position', 'company_name', 'user_id'], 'required'],
            [['tin', 'pinfl', 'passport_number', 'user_id'], 'integer'],
            [['birthday', 'created_at', 'updated_at'], 'safe'],
            [['fullname', 'email', 'phone', 'position', 'company_name'], 'string', 'max' => 255],
            [['passport_seria'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'tin' => Yii::t('main', 'Tin'),
            'pinfl' => Yii::t('main', 'Pinfl'),
            'fullname' => Yii::t('main', 'Fullname'),
            'email' => Yii::t('main', 'Email'),
            'phone' => Yii::t('main', 'Phone'),
            'birthday' => Yii::t('main', 'Birthday'),
            'passport_number' => Yii::t('main', 'Passport Number'),
            'passport_seria' => Yii::t('main', 'Passport Seria'),
            'position' => Yii::t('main', 'Position'),
            'company_name' => Yii::t('main', 'Company Name'),
            'created_at' => Yii::t('main', 'Created At'),
            'updated_at' => Yii::t('main', 'Updated At'),
            'user_id' => Yii::t('main', 'User ID'),
        ];
    }

    /**
     * Gets query for [[TenderCommissions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTenderCommissions()
    {
        return $this->hasMany(TenderCommission::className(), ['commission_id' => 'id']);
    }
}
